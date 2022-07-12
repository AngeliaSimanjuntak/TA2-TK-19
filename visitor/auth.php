<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require('config.php');

function login()
{
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM user WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['uuid'] = $user['uuid'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['wajah'] = $user['gambar_wajah'];
            $_SESSION['level'] = $user['level'];

            header('Location:dashboard');
        } else {
            $_SESSION['error'] = 'Password tidak sesuai';
        }
    } else {
        $_SESSION['error'] = 'User tidak ditemukan';
    }
}

function register()
{
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    $level = 'visitor';
    $uuid = date('ymd') . rand(100, 999);

    $info_wajah = getimagesize($_FILES['foto_wajah']['tmp_name']);
    $extension_wajah = image_type_to_extension($info_wajah[2]);

    $foto_wajah = strtolower(str_replace(' ', '_', $nama)) . $extension_wajah;

    move_uploaded_file($_FILES["foto_wajah"]["tmp_name"], "uploads/wajah/" . $foto_wajah);



    $query = mysqli_query($GLOBALS['connection'], "INSERT INTO user VALUES (null, '$uuid', '$nama', '$email', '$password', '$foto_wajah', '$level')");

    if ($query) {
        $subject = "Email Pemberitahuan Pendaftaran";
        $message = "<h1>Hai " . $nama . ".</h1><p>Selamat pendaftaran anda berhasil. Silahkan mengakses Metro demi kenyamanan kita bersama.</p>";

        sendmail($email, $subject, $message);

        $_SESSION['success'] = 'Registrasi berhasil';
        header('Location:login.php');
    } else {
        $_SESSION['error'] = 'Registrasi gagal';
        header('Location:register.php');
    }
}

function sendmail($to, $subject, $message)
{
    $from = "putrianjeliapasaribu@gmail.com";  // your mail
    $password = "tmoannlqhmceklfp";  // your mail password

    // Ignore from here
    $mail = new PHPMailer(true);

    // To Here

    //SMTP Settings
    $mail->isSMTP();
    // $mail->SMTPDebug  = 1;
    $mail->SMTPAuth   = TRUE;
    $mail->AuthType = 'LOGIN';
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = $from;
    $mail->Password   = $password;


    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom($from, 'Admin');
    $mail->addAddress($to); // enter email address whom you want to send
    $mail->Subject = ($subject);
    $mail->Body = $message;
    $mail->send();
}

function logout()
{
    session_unset();
    session_destroy();

    header('Location:../login.php');
}

function auth()
{
    if ($_SESSION['login'] != true) {
        header('Location:../login.php');
    }
}

function is_admin()
{
    if ($_SESSION['level'] != 'admin') {
        header('Location:../404.php');
    }
}
