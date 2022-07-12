<?php

require('../config.php');

if (isset($_GET['key']) && isset($_GET['iddev']) && isset($_GET['uuid'])) {
    $key = $_GET['key'];
    $iddev = $_GET['iddev'];
    $uuid = $_GET['uuid'];
    $date = date('Y-m-d H:i:s');
    $now = date('Y-m-d');

    $secretKey = mysqli_query($connection, "SELECT * FROM secret_key WHERE id = 1")->fetch_assoc();

    if ($key == $secretKey['secret_key']) {
        $device = mysqli_query($connection, "SELECT * FROM device JOIN lokasi ON device.lokasi_id=lokasi.id WHERE device.id = $iddev")->fetch_assoc();

        if ($device) {
            $lokasi_id = $device['lokasi_id'];

            $lokasi = mysqli_query($connection, "SELECT * FROM lokasi WHERE id = $lokasi_id ")->fetch_assoc();

            $totalVisitor = mysqli_query($connection, "SELECT count(user_id) as total FROM visitor WHERE lokasi_id = $lokasi_id AND waktu_checkin LIKE '%$now%' AND checkout = 0")->fetch_assoc()['total'];

            if ($totalVisitor < $lokasi['jml_maximum']) {
                $user = mysqli_query($connection, "SELECT * FROM user WHERE uuid = '$uuid'")->fetch_assoc();

                if ($user) {
                    $user_id = $user['id'];
                    $device_id = $device['id'];

                    $visit = mysqli_query($connection, "SELECT * FROM visitor WHERE user_id = '$user_id' AND waktu_checkin LIKE '%$now%' AND lokasi_id = '$lokasi_id' ")->fetch_assoc();


                    if ($visit == null) {

                        $visitor = mysqli_query($connection, "INSERT INTO visitor (id, user_id, lokasi_id, device_id, checkin, waktu_checkin, foto_checkin) VALUES (null, '$user_id', '$lokasi_id', '$device_id', 1, '$date', '')");

                        if ($visitor) {
                            $response = [
                                'status' => 'success',
                                'ket' => 'Berhasil Checkin',
                                'nama' => $user['nama'],
                                'email' => $user['email'],
                                'waktu' => date('d/m/Y H:i:s'),
                            ];
                            echo json_encode($response);
                        } else {
                            $response = [
                                'status' => 'failed',
                                'ket' => 'Gagal insert',
                            ];
                            echo json_encode($response);
                        }
                    } else if ($visit['checkin'] == 1 && $visit['checkout'] == 0) {
                        $id_visit = $visit['id'];

                        $updateVisitor = mysqli_query($connection, "UPDATE visitor SET checkout = 1, waktu_checkout = '$date', foto_checkout = '' WHERE id = '$id_visit'");

                        if ($updateVisitor) {
                            $response = [
                                'status' => 'success',
                                'ket' => 'Berhasil Checkout',
                                'nama' => $user['nama'],
                                'email' => $user['email'],
                                'waktu' => date('d/m/Y H:i:s'),
                            ];
                            echo json_encode($response);
                        } else {
                            $response = [
                                'status' => 'failed',
                                'ket' => 'Gagal Checkout',
                            ];
                            echo json_encode($response);
                        }
                    } else {
                        $response = [
                            'status' => 'failed',
                            'ket' => 'Anda sudah melakukan checkin di lokasi ini',
                        ];
                        echo json_encode($response);
                    }
                } else {
                    $response = [
                        'status' => 'failed',
                        'ket' => 'Nik tidak terdaftar',
                    ];
                    echo json_encode($response);
                }
            } else {
                $response = [
                    'status' => 'failed',
                    'ket' => 'Lokasi sudah penuh',
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                'status' => 'failed',
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
