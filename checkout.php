<?php
require_once 'connection/connect.php';
require_once 'product-action.php';
require_once 'globals.php';
require __DIR__ . '/vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

// Se sua sessão não for iniciada no globals.php, descomente:
// if (session_status() === PHP_SESSION_NONE) { session_start(); }

// (Opcional) Se não tiver a constante, garantimos um fallback simples
$isLogged = defined('IS_USER_LOGGED_IN') ? IS_USER_LOGGED_IN : (!empty($_SESSION['user_id']));
if (!$isLogged) {
  header('Location: login.php');
  exit();
}

// Carrinho
$cart = $_SESSION['cart_item'] ?? [];
if (!is_array($cart) || count($cart) === 0) {
  header('Location: restaurants.php');
  exit();
}

// CONFIG MP – SDK nova
MercadoPagoConfig::setAccessToken('APP_USR-1632496385177731-082316-8adaa1623958b3cbcc79d368739e2102-50169775'); // ← coloque o seu token (de teste ou produção)

// Total
$item_total = 0.0;
foreach ($cart as $item) {
  // Garanta número (evita "1.234,56" etc.)
  $price = (float) str_replace(',', '.', preg_replace('/[^\d,\.]/', '', (string)$item['price']));
  $qty   = (int) ($item['quantity'] ?? 1);
  $item_total += $price * $qty;
}

// Criar preferência e redirecionar quando submeter o formulário
if (isset($_POST['submit'])) {

  // Monte os itens no formato da SDK nova
  $items = [];
  foreach ($cart as $item) {
    $title = (string) ($item['title'] ?? 'Item');
    $price = (float) str_replace(',', '.', preg_replace('/[^\d,\.]/', '', (string)$item['price']));
    $qty   = (int) ($item['quantity'] ?? 1);

    $items[] = [
      'title'       => $title,
      'quantity'    => $qty,
      'unit_price'  => $price, // BRL é inferido pela conta
    ];

    // (Opcional, mas recomendado) salvar pedido no banco com prepared statement
    if (isset($_SESSION['user_id'])) {
      $stmt = $db->prepare("INSERT INTO users_orders (u_id, title, quantity, price) VALUES (?, ?, ?, ?)");
      $stmt->bind_param('isid', $_SESSION['user_id'], $title, $qty, $price);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Identificador para reconciliação posterior (webhook/success)
  $externalRef = 'ORDER-' . ($_SESSION['user_id'] ?? 'GUEST') . '-' . time();

  $client = new PreferenceClient();

  try {
    $preference = $client->create([
      'items' => $items,
      'back_urls' => [
        // Use localhost no Laragon; em produção, seu domínio
        'success' => 'https://lightpink-baboon-267549.hostingersite.com/success.php',
        'failure' => 'https://lightpink-baboon-267549.hostingersite.com/failure.php',
        'pending' => 'https://lightpink-baboon-267549.hostingersite.com/pending.php',
      ],
      'auto_return' => 'approved',
      'external_reference' => $externalRef,
      // 'notification_url' => 'https://SEU-DOMINIO.com/webhooks/mercadopago' // (recomendado em produção)
    ]);

    if (!empty($preference->init_point)) {
      // IMPORTANTE: não limpe o carrinho aqui. Limpe só no success.php depois de aprovado.
      header('Location: ' . $preference->init_point);
      exit();
    }

    throw new Exception('init_point não retornado pela API.');

  } catch (MPApiException $e) {
    $api = $e->getApiResponse();
    $status = $api ? $api->getStatusCode() : 'n/a';
    $content = $api ? json_encode($api->getContent(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) : 'n/a';
    die("Erro Mercado Pago (HTTP $status): <pre>$content</pre>");
  } catch (Exception $e) {
    die('Erro ao criar preferência: ' . htmlspecialchars($e->getMessage()));
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Finalizar Compra</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animsition.min.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <div class="site-wrapper">
    <?php require_once 'header.php'; ?>
    <div class="page-wrapper">
      <div class="top-links">
        <div class="container">
          <ul class="row links">
            <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Escolha o Restaurante</a></li>
            <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Escolha sua comida favorita</a></li>
            <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Pedido e Pagamento</a></li>
          </ul>
        </div>
      </div>

      <div class="container m-t-30">
        <form action="" method="post">
          <div class="widget clearfix">
            <div class="widget-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="cart-totals margin-b-20">
                    <div class="cart-totals-title">
                      <h4>Resumo do Carrinho</h4>
                    </div>
                    <div class="cart-totals-fields">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>Subtotal do Carrinho</td>
                            <td><?php echo "R$" . number_format($item_total, 2, ',', '.'); ?></td>
                          </tr>
                          <tr>
                            <td>Taxas de Entrega</td>
                            <td>Grátis</td>
                          </tr>
                          <tr>
                            <td class="text-color"><strong>Total</strong></td>
                            <td class="text-color"><strong><?php echo "R$" . number_format($item_total, 2, ',', '.'); ?></strong></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="payment-option">
                    <p class="text-xs-center">
                      <input type="submit" name="submit" class="btn btn-outline-success btn-block" value="Fazer Pedido">
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <?php require_once 'footer.php'; ?>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/animsition.min.js"></script>
  <script src="js/bootstrap-slider.min.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/headroom.js"></script>
  <script src="js/foodpicky.min.js"></script>
</body>
</html>
