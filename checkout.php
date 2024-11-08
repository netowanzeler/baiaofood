
<?php
require 'vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['items'])) {
    // Configura o Access Token do Mercado Pago
    MercadoPago\SDK::setAccessToken('APP_USR-858640062735956-110211-a4bc6d2eed69b35ec17f1057bb57c93e-50169775');

    // Criação da preferência de pagamento
    $preference = new MercadoPago\Preference();

    // Loop pelos itens enviados via POST
    $items = [];
    foreach ($_POST['items'] as $item) {
        $mp_item = new MercadoPago\Item();
        $mp_item->title = $item['title'];
        $mp_item->quantity = (int)$item['quantity'];
        $mp_item->unit_price = (float)$item['price'];
        $mp_item->currency_id = "BRL";
        
        $items[] = $mp_item;
    }

    // Adiciona os itens à preferência de pagamento
    $preference->items = $items;

    // URLs de redirecionamento após o pagamento
    $preference->back_urls = array(
        "success" => "https://lightskyblue-owl-392240.hostingersite.com/index.php",
        "failure" => "localhost/baiaofood",
        "pending" => "localhost/baiaofood"
    );
    $preference->auto_return = "approved";

    // Salva a preferência e obtém o link de pagamento
    $preference->save();

    // Redireciona o usuário para o link de pagamento
    header("Location: {$preference->init_point}");
    exit();
} else {
    echo "Nenhum item no carrinho.";
}
?>