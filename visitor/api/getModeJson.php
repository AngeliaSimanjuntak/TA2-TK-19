<?php
require('../config.php');

if (isset($_GET['key']) && isset($_GET['iddev'])) {
    $key = $_GET['key'];
    $iddev = $_GET['iddev'];

    $secretKey = mysqli_query($connection, "SELECT * FROM secret_key WHERE id = 1")->fetch_assoc();

    if ($key == $secretKey['secret_key']) {
        $device = mysqli_query($connection, "SELECT * FROM device JOIN lokasi ON device.lokasi_id = lokasi.id WHERE device.id = $iddev")->fetch_assoc();


        if ($device) {
            $response = [
                'status' => 'success',
                'mode' => $device['mode'],
                'ket' => 'Device ' . $device['nama_lokasi']
            ];
            echo json_encode($response);
        } else {
            $response = [
                'status' => 'warning',
                'mode' => '-',
                'ket' => 'Device tidak ditemukan'
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            'status' => 'failed',
            'ket' => 'Salah secret key'
        ];
        echo json_encode($response);
    }
} else {
    $response = [
        'status' => 'failed',
        'ket' => 'Salah parameter'
    ];
    echo json_encode($response);
}
