<?php
session_start();
?><h1>Pagamento falhou ou foi cancelado</h1>
<pre><?php print_r($_GET); ?></pre>
<a href="checkout.php">Tentar novamente</a>
<a href="restaurants.php">Voltar</a>