<?php
$client_key    = 'SB-Mid-client-C_B1t7C5Q0B47okb';
$if_production = false;
$url           = ($if_production == true) ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

if (!strpos($_SERVER['REQUEST_URI'], '/change')) {
    http_response_code(404);
    echo 'salah path, silahkan dicek apabila sudah benar berada di /change!';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(404);
    echo 'halaman tidak ditemukan!';
    exit();
}
// untuk mengambil data
$data = file_get_contents('php://input');
// untuk mengubah extension file
header('Content-Type: application/json');

$charge_result = chargeAPI($url, $client_key, $data);

http_response_code($charge_result['http_code']);

echo $charge_result['body'];

function chargeAPI($url, $client_key, $data)
{
    $ch = curl_init();
    $curl_options = array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST           => 1,
        CURLOPT_HEADER         => 0,
        CURLOPT_HTTPHEADER     => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($client_key . ':')
        ),
        CURLOPT_POSTFIELDS    => $data
    );

    curl_setopt_array($ch, $curl_options);
    
    $result = array(
        'body' => curl_exec($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
    );
    
    return $result;
}