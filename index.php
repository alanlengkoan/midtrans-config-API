<?php
// untuk url transaksi
// https://app.sandbox.midtrans.com/snap/v1/transactions method : POST

// untuk simulasi pembayaran
// https://simulator.sandbox.midtrans.com/assets/index.html

// untuk dokumentasi manual web
// https://docs.midtrans.com/id/snap/integration_php_manual.html

// untuk dokumentasi manual mobile
// https://mobile-docs.midtrans.com/

// untuk mengubah server key
function authBase64($server_key)
{
    $auth_string = $server_key . ':';
    $auth_base64 = 'Basic ' . base64_encode($auth_string);

    return $auth_base64;
}

// fungsi untuk tambah transaksi
function requestTransaksi($url, $server_key, $transaksi)
{
    $curl = curl_init();
    $curl_options = array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST           => 1,
        CURLOPT_HEADER         => 0,
        CURLOPT_HTTPHEADER     => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: '.authBase64($server_key).''
        ),
        CURLOPT_POSTFIELDS    => json_encode($transaksi)
    );

    curl_setopt_array($curl, $curl_options);

    $result = curl_exec($curl);

    if (!$result) {
        die("Connection Failure");
    }
    
    curl_close($curl);

    return $result;
}

// fungsi untuk cek detail order
function orderDetail($server_key, $id, $check)
{
    $url = 'https://api.sandbox.midtrans.com/v2/'.$id.'/'.$check;

    $curl = curl_init();

    if ($check != 'status' && $check != 'status/b2b') {
        $curl_options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => 0,
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: ' . authBase64($server_key) . ''
            ),
        );
    } else {
        $curl_options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER         => 0,
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: ' . authBase64($server_key) . ''
            ),
        );
    }

    curl_setopt_array($curl, $curl_options);

    $result = curl_exec($curl);

    if (!$result) {
        die("Connection Failure");
    }

    curl_close($curl);

    return $result;
}

$server_key = 'MASUKKAN SERVEY KEY';                                    // server key dari midtrans
$url        = 'https://app.sandbox.midtrans.com/snap/v1/transactions';  // url
$id         = '';                                                       // order id atau transaction id
$check      = '';                                                       // ada approve, deny, cancel, expire, refund, refund/online/direct, status, statusb2b

// file json untuk melakukan transaksi
$transaksi = [
    // untuk detail transaksi
    'transaction_details' => [
        'order_id'     => rand(),
        'gross_amount' => 30000000, // total dari jumlah price pada item
    ],
    // untuk detail customer
    'customer_details'    => [
        'first_name' => "Alan",
        'last_name'  => "Lengkoan",
        'email'      => "alanlengkoan15@gmail.com",
        'phone'      => "085242907595",
        "billing_address" => [
            "first_name"   => "Alan",
            "last_name"    => "Lengkoan",
            "email"        => "alanlengkoan15@gmail.com",
            "phone"        => "085242907595",
            "address"      => "Perumahan Taman Guna Asri Jl. Kelapa Molek Hibrida IV",
            "city"         => "Gowa",
            "postal_code"  => "12345",
            "country_code" => "IDN"
        ],
    ],
    // untuk detail item
    'item_details'        => [
        [
            'id'       => 'id_unit_01',
            'price'    => 10000000,
            'quantity' => 1,
            'name'     => "Mobil Honda BRV"
        ],
        [
            'id'       => 'id_unit_02',
            'price'    => 20000000,
            'quantity' => 1,
            'name'     => "Mobil Honda BRV - V"
        ],
    ],
];

// $response = requestTransaksi($url, $server_key, $transaksi);
$response = orderDetail($server_key, $id, $check);

$show = json_decode($response, true);

// header('location: '. $show['redirect_url'].'');
echo '<pre>';
print_r($show);