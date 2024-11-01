<?php

include("../config.php");

$reference = $_POST['ref'] ?? '';

// Obtém o ID do pagamento da referência
$paymentId = explode(";", file_get_contents("../transactions/$reference"))[1] ?? null;

if ($paymentId === null) {
    exit(json_encode(['error' => 'ID do pagamento não encontrado']));
}

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/' . $paymentId,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => [
        'accept: application/json',
        'content-type: application/json',
        'Authorization: Bearer ' . $acess_token
    ]
]);

$response = curl_exec($curl);
$responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($responseCode !== 200) {
    exit(json_encode(['error' => 'Erro ao obter detalhes do pagamento']));
}

// Decodifica a resposta da API
$responseData = json_decode($response, true);
$externalReference = $responseData['external_reference'];
$status = $responseData['status'];

// Atualiza o status da transação se o pagamento for aprovado
if ($status === "approved") {
    file_put_contents("../transactions/$externalReference", "approved;$paymentId");
}

// Exibe a resposta
echo json_encode(['status' => $status]);
?>
