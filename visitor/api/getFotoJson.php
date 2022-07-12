<?php
require('../config.php');

if (isset($_GET['key']) && isset($_GET['uuid'])) {
    $key = $_GET['key'];
    $uuid = $_GET['uuid'];

    $secretKey = mysqli_query($connection, "SELECT * FROM secret_key WHERE id = 1")->fetch_assoc();

    if ($key == $secretKey['secret_key']) {
        $data = mysqli_query($connection, "SELECT * FROM user WHERE user.uuid = $uuid")->fetch_assoc();

        if ($data) {
            $response = [
                'status' => 'success',
                'wajah' => $data['gambar_wajah'],
                'nama' => $data['nama'],
            ];
            echo json_encode($response);
        } else {
            $response = [
                'status' => 'error',
                'ket' => 'Uuid tidak ditemukan'
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
