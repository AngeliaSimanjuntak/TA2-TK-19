<?php
require('config.php');
require('auth.php');
require('function.php');

if (isset($_POST['register'])) {
    register();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/logo/logo1.png" rel="icon">
    <title>Metro - Register</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-12 col-md-7">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (isset($_SESSION['error'])) : ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <?= $_SESSION['error'] ?>
                                    </div>
                                    <?php unset($_SESSION['error']) ?>
                                <?php endif; ?>
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                    </div>
                                    <form class="user" action="" method="POST" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="nama">Nama</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama" required>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="nik">Nik</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="number" class="form-control" id="nik" placeholder="Nik" name="nik" required>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="email">Email</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="password">Password</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="foto_ktp">Foto Ktp</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="file" class="form-control mb-2" id="foto_ktp" placeholder="foto_ktp" name="foto_ktp" required onchange="document.getElementById('prev_ktp').src = window.URL.createObjectURL(this.files[0])">

                                                <img src="" alt="" width="100px" id="prev_ktp">

                                            </div>
                                        </div> -->

                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="foto_wajah">Foto Wajah</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="file" class="form-control mb-2" id="foto_wajah" placeholder="foto_wajah" name="foto_wajah" required onchange="document.getElementById('prev_wajah').src = window.URL.createObjectURL(this.files[0])">

                                                <img src="" alt="" width="80px" id="prev_wajah">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-7">
                                                <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="login.php">Login</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="index.php">Back to home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/ruang-admin.min.js"></script>
</body>

</html>