<?php
session_start();
// Aqui você pode validar os parâmetros recebidos (payment_id, status, preference_id, external_reference)
if (isset($_GET['status']) && $_GET['status'] === 'approved') {
  // Só apague o carrinho após sucesso
  unset($_SESSION['cart_item']);
}
// Atualize o status do pedido no banco usando $_GET['external_reference'] se você definiu
?>
<h1>Pagamento aprovado!</h1>
<pre><?php print_r($_GET); ?></pre>
<a href="restaurants.php">Voltar</a>
