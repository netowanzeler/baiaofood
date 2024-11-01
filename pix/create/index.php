<?php

include("../config.php");

// Gerar uma chave de idempotência
$idempotencyKey = uniqid("payment_", true);

// Dados recebidos via POST
$name = strtolower($_POST['name'] ?? '');
$email = strtolower($_POST['email'] ?? '');
$value = $_POST['value'] ?? 0;

// Corrige o valor
$value = str_replace(",", ".", $value);
$value = floatval($value);

// Verifica se o valor é positivo
if ($value <= 0) {
    exit(json_encode(['error' => 'O valor da transação deve ser positivo.']));
}

$description = "PRODUTO #1";

// Pagador
$pagador = [
    "first_name" => $name,
    "last_name" => "",
    "email" => $email
];

// Gera um ID de compra (referência para ser usada no seu sistema)
$externalReference = geraString(24);

// Função para gerar a string
function geraString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Informações sobre o pagamento
$infos = [
    "notification_url" => $notification_url, // URL para notificações do Mercado Pago
    "description" => $description,
    "external_reference" => $externalReference,
    "transaction_amount" => $value,
    "payment_method_id" => "pix"
];

// Encoda as informações em JSON
$payment = array_merge(["payer" => $pagador], $infos);
$payment = json_encode($payment);

// Faz o request para o Mercado Pago usando cURL
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.mercadopago.com/v1/payments/",
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $payment,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $acess_token,
        'Content-Type: application/json',
        'X-Idempotency-Key: ' . $idempotencyKey // Adicionando o cabeçalho X-Idempotency-Key
    ]
]);

$response = curl_exec($curl);

// Verifica se houve erro na execução do cURL
if (curl_errno($curl)) {
    exit(json_encode(['error' => 'Erro cURL: ' . curl_error($curl)]));
}

curl_close($curl);

// Decodifica a resposta
$data = json_decode($response, true);

// Verifica se a resposta contém dados de interação
if (isset($data['point_of_interaction']['transaction_data'])) {
    $response = $data['point_of_interaction']['transaction_data'];

    // Cria uma array apenas com as informações
    $arr = [
        'qr_code' => $response['qr_code'] ?? null,
        'qr_code_base64' => $response['qr_code_base64'] ?? null,
        'payment_url' => $response['ticket_url'] ?? null,
        'id' => $data['id'] ?? null,
        'ref' => $externalReference,
        'full_info_for_developer' => $data
    ];

    // Cria um arquivo com a referência da transação para verificar se o pagamento foi aprovado depois
    $paymentId = $data['id'] ?? null;
    file_put_contents("../transactions/$externalReference", "pending;$paymentId");

    // Exibe array
    echo json_encode($arr);
} else {
    echo json_encode(['error' => 'Erro ao gerar o pagamento', 'details' => $data]);
}
?>
