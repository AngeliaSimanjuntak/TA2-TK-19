<?php $title = 'Location'; ?>

<?php
require('../layouts/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $lokasi = find('lokasi', $id);

    $jam = explode(' - ', $lokasi['jam_operasional']);
    $jam_buka = $jam['0'];
    $jam_tutup = $jam['1'];
}

if (isset($_POST['submit'])) {
    $nama_lokasi = htmlspecialchars($_POST['nama_lokasi']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $jam_operasional = htmlspecialchars($_POST['jam_buka']) . ' - ' . htmlspecialchars($_POST['jam_tutup']);
    $jml_maximum = htmlspecialchars($_POST['jml_maximum']);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $table = 'lokasi';
        $data = "nama_lokasi=" . "'" . "$nama_lokasi" . "'," . "alamat=" . "'" . "$alamat" . "'," . "jam_operasional=" . "'" . "$jam_operasional" . "'," . "jml_maximum=" . "'" . "$jml_maximum" . "'";

        $update = update($table, $data, $id);

        if ($update) {
            $_SESSION['success'] = 'Lokasi berhasil diupdate';

            echo '<script>
                    window.location.href="index.php"
                 </script>';
        } else {
            $_SESSION['error'] = 'Lokasi gagal diupdate';

            echo '<script>
                    window.location.href="form.php"
                 </script>';
        }
    } else {
        $table = 'lokasi';
        $data = "'" . "$nama_lokasi" . "'," . "'" . "$alamat" . "'," . "'" . "$jam_operasional" . "'," . "'" . "$jml_maximum" . "'";

        $create = create($table, $data);

        if ($create) {
            $_SESSION['success'] = 'Lokasi berhasil ditambahkan';

            echo '<script>
                    window.location.href="index.php"
                  </script>';
        } else {
            $_SESSION['error'] = 'Lokasi gagal ditambahkan';

            echo '<script>
                    window.location.href="form.php"
                 </script>';
        }
    }
}
?>

<div class="container" id="container-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">
                <?php if (isset($_GET['id'])) : ?>
                    Edit Location
                <?php else : ?>
                    Add Location
                <?php endif; ?>
            </h2>
            <form action="" method="post">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="nama_lokasi">Nama Lokasi</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" value="<?= isset($_GET['id']) ? $lokasi['nama_lokasi'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="alamat">Alamat</label>
                    </div>
                    <div class="col-md-9">
                        <textarea name="alamat" id="alamat" rows="4" class="form-control" required><?= isset($_GET['id']) ? $lokasi['alamat'] : '' ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="jam_buka">Jam Buka</label>
                    </div>
                    <div class="col-md-9">
                        <input type="time" name="jam_buka" id="jam_buka" class="form-control" value="<?= isset($_GET['id']) ? $jam_buka : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="jam_tutup">Jam Tutup</label>
                    </div>
                    <div class="col-md-9">
                        <input type="time" name="jam_tutup" id="jam_tutup" class="form-control" value="<?= isset($_GET['id']) ? $jam_tutup : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="jml_maximum">Batas Maximum Pengunjung</label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" name="jml_maximum" id="jml_maximum" class="form-control" value="<?= isset($_GET['id']) ? $lokasi['jml_maximum'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require('../layouts/footer.php') ?>