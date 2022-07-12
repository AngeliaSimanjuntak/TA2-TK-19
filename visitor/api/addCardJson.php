<?php

require('../config.php');

if (isset($_GET['key']) && isset($_GET['iddev']) && isset($_GET['email'])) {
    $key = $_GET['key'];
    $iddev = $_GET['iddev'];
    $email = $_GET['email'];

    $secretKey = mysqli_query($connection, "SELECT * FROM secret_key WHERE id = 1")->fetch_assoc();

    if ($key == $secretKey['secret_key']) {
        $device = mysqli_query($connection, "SELECT * FROM device WHERE id = $iddev")->fetch_assoc();

        if ($device) {
            $user = mysqli_query($connection, "SELECT * FROM user WHERE email = '$email'")->fetch_assoc();

            if ($user) {
                $response = [
                    'status' => 'failed',
                    'ket' => 'Email sudah terdaftar'
                ];
                echo json_encode($response);
            } else {
                $emailFromTable = mysqli_query($connection, "SELECT * FROM email WHERE id = 1 ")->fetch_assoc();

                $updateemail = mysqli_query($connection, "UPDATE email SET email = '$email' WHERE id = 1");

                if ($updateemail) {
                    $response = [
                        'status' => 'success',
                        'ket' => 'Email berhasil ditambahkan'
                    ];
                    echo json_encode($response);
                } else {
                    $response = [
                        'status' => 'failed',
                        'ket' => 'Terjadi Kesalahan'
                    ];
                    echo json_encode($response);
                }
            }
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
