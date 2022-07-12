<?php $title = 'Device'; ?>

<?php
require('../layouts/header.php');

$locations = get('lokasi');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $device = find('device', $id);
}

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $lokasi_id = htmlspecialchars($_POST['lokasi_id']);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $table = 'device';
        $data = "lokasi_id=" . "'" . "$lokasi_id" . "'," . "nama=" . "'" . "$nama" . "'," .  "mode='SCAN'";

        $update = update($table, $data, $id);

        if ($update) {
            $_SESSION['success'] = 'Device berhasil diupdate';

            echo '<script>
                    window.location.href="index.php"
                 </script>';
        } else {
            $_SESSION['error'] = 'Device gagal diupdate';

            echo '<script>
                    window.location.href="form.php"
                 </script>';
        }
    } else {
        $table = 'device';
        $data = "'" . "$lokasi_id" . "'," . "'" . "$nama" . "'," . "'SCAN'";

        $create = create($table, $data);

        if ($create) {
            $_SESSION['success'] = 'Device berhasil ditambahkan';

            echo '<script>
                    window.location.href="index.php"
                  </script>';
        } else {
            $_SESSION['error'] = 'Device gagal ditambahkan';

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
                    Edit Device
                <?php else : ?>
                    Add Device
                <?php endif; ?>
            </h2>
            <form action="" method="post">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="nama">Nama Device</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= isset($_GET['id']) ? $device['nama'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="lokasi_id">Lokasi</label>
                    </div>
                    <div class="col-md-9">
                        <select name="lokasi_id" id="lokasi_id" class="form-control" required>
                            <option disabled selected>-- Pilih Lokasi --</option>
                            <?php foreach ($locations as $location) : ?>
                                <option <?= isset($_GET['id']) && $device['lokasi_id'] == $location['id'] ? 'selected' : '' ?> value="<?= $location['id'] ?>"><?= $location['nama_lokasi'] ?></option>
                            <?php endforeach; ?>
                        </select>
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