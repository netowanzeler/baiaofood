<?php
require __DIR__ . '/vendor/autoload.php';
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

MercadoPagoConfig::setAccessToken("APP_USR-1632496385177731-082316-8adaa1623958b3cbcc79d368739e2102-50169775");

$payload = json_decode(file_get_contents('php://input'), true);

if (isset($payload['data']['id'])) {
    $paymentId = $payload['data']['id'];

    $client = new PaymentClient();
    $payment = $client->get($paymentId);

    // Atualiza seu pedido no banco
    if ($payment->status === "approved") {
        // marcar pedido como pago
    }
}
?>
