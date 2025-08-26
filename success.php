<?php
session_start();

// Apaga o carrinho apenas se o pagamento foi aprovado
if (isset($_GET['status']) && $_GET['status'] === 'approved') {
    unset($_SESSION['cart_item']);
}

// Pega o status para exibir na interface
$status = $_GET['status'] ?? 'indefinido';
$referencia = $_GET['external_reference'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Pagamento Recebido</title>
  <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- se não tiver, remova -->
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-success">Pagamento iniciado com sucesso!</h1>

    <p>Status atual: <strong><?php echo htmlspecialchars($status); ?></strong></p>
    <p>Referência do pedido: <strong><?php echo htmlspecialchars($referencia); ?></strong></p>

    <p>Você será notificado assim que o pagamento for confirmado pela instituição financeira.</p>

    <a href="index.php" class="btn btn-primary mt-3">Voltar para a Página Inicial</a>
  </div>

  <!-- (Opcional) Para debug -->
  <!-- <pre><?php print_r($_GET); ?></pre> -->
</body>
</html>
