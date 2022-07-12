<?php $title = 'Dashboard'; ?>

<?php
require('../layouts/header.php');

$user = find('user', $_SESSION['id']);
$id = $user['id'];
$no = 1;

$riwayat = mysqli_query($connection, " SELECT * FROM visitor JOIN lokasi ON visitor.lokasi_id = lokasi.id WHERE user_id = $id ");

if (isset($_POST['update'])) {
    $email = htmlspecialchars($_POST['email']);
    $nama = htmlspecialchars($_POST['nama']);
    $password = $_POST['password'] == '' ? $user['password'] : password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    $id = $_SESSION['id'];

    if ($_FILES['foto_wajah']['size'] != 0) {
        $info_wajah = getimagesize($_FILES['foto_wajah']['tmp_name']);
        $extension_wajah = image_type_to_extension($info_wajah[2]);

        $pathWajah = '../uploads/wajah/' . $_SESSION['wajah'];
        if (file_exists($pathWajah)) {
            unlink($pathWajah);
        }

        $foto_wajah = strtolower(str_replace(' ', '_', $nama)) . $extension_wajah;

        move_uploaded_file($_FILES["foto_wajah"]["tmp_name"], "../uploads/wajah/" . $foto_wajah);
    } else {
        $foto_wajah = $_SESSION['wajah'];
    }



    $data = "nama=" . "'" . "$nama" . "'," . "password=" . "'" . "$password" . "'," . "gambar_wajah=" . "'" . "$foto_wajah" . "'";

    $update = update('user', $data, $id);

    if ($update) {
        $_SESSION['success'] = 'Profile berhasil diupdate';

        echo '<script>
                window.location.href="profile.php"
             </script>';
    } else {
        $_SESSION['success'] = 'Profile berhasil diupdate';

        echo '<script>
                window.location.href="profile.php"
            </script>';
    }
}
?>

<h1 class="mb-3 text-center">Profile</h1>

<div class="row justify-content-center mb-3">
    <div class="col-md-2">
        <div id="qr-code" data-id="<?= $_SESSION['uuid'] ?>" style="margin-left: 20px;"> </div><br>
        <a href="" class="btn btn-sm btn-info" id="download" style="margin-left: 35px;"><i class="fas fa-download"></i> Download</a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <div class="col-md-3">
                    <label for="email">Email</label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="email" id="email" class="form-control" value="<?= $user['email'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-3">
                    <label for="nama">Nama</label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $user['nama'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-3">
                    <label for="password">Password</label>
                </div>
                <div class="col-md-9">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-3">
                    <label for="foto_wajah">Foto Wajah</label>
                </div>

                <div class="col-md-9">
                    <input type="file" class="form-control mb-2" src="<?= $_SESSION['wajah'] ?>" id="foto_wajah" placeholder="foto_wajah" name="foto_wajah" onchange="document.getElementById('prev_wajah').src = window.URL.createObjectURL(this.files[0])">

                    <img src="<?= $base_url; ?>/uploads/wajah/<?= $_SESSION['wajah']; ?>" alt="" width="80px" id="prev_wajah">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <h4 class="my-3 text-center">Riwayat Kunjungan</h4>
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Lokasi</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Waktu Kunjungan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($riwayat as $ryt) :  ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $ryt['nama_lokasi'] ?></td>
                            <td><?= date('d/m/Y', strtotime($ryt['waktu_checkin'])) ?></td>
                            <td><?= date('H:i', strtotime($ryt['waktu_checkin'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php require('../layouts/footer.php') ?>