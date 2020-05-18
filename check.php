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