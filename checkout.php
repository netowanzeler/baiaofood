<?php
require 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken('APP_USR-858640062735956-110211-a4bc6d2eed69b35ec17f1057bb57c93e-50169775');

// Criação de uma nova preferência de pagamento
$preference = new MercadoPago\Preference();

// Configuração dos itens da preferência
$item = new MercadoPago\Item();
$item->title = "Produto Exemplo";
$item->quantity = 1;
$item->currency_id = "BRL";
$item->unit_price = 100.00; // Exemplo de valor em reais

$preference->items = array($item);

// URL de redirecionamento após o pagamento
$preference->back_urls = array(
    "success" => "https://seusite.com/sucesso",
    "failure" => "https://seusite.com/falha",
    "pending" => "https://seusite.com/pendente"
);
$preference->auto_return = "approved";

// Salva a preferência e gera o link
$preference->save();

echo "<a href='$preference->init_point'>Pagar com Mercado Pago</a>";
