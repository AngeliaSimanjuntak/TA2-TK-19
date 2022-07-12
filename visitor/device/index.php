<?php $title = 'Device'; ?>

<?php
require('../layouts/header.php');

$devices = get('device');
$no = 1;

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $query = mysqli_query($connection, "DELETE FROM device WHERE id = '$id' ");

    if ($query) {
        $_SESSION['success'] = 'Device berhasil didelete';
    } else {
        $_SESSION['error'] = 'Device gagal didelete';
    }

    echo '<script>
            window.location.href="index.php"
         </script>';
}
?>

<h1 class="mb-3">Device</h1>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <a href="form.php" class="btn btn-primary mb-3">Add Device</a>
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Id Device</th>
                        <th>Nama Device</th>
                        <th>Nama Lokasi</th>
                        <th>Mode</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($devices as $device) : ?>
                        <?php
                        $id_lokasi = $device['lokasi_id'];
                        $lokasi = mysqli_query($connection, "SELECT * FROM lokasi WHERE id = $id_lokasi")->fetch_assoc();
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $device['id'] ?></td>
                            <td><?= $device['nama'] ?></td>
                            <td>
                                <?= $lokasi['nama_lokasi'] ?>
                            </td>
                            <td><?= $device['mode'] ?></td>
                            <td class="d-flex">
                                <a href="form.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?= $device['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data device ?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require('../layouts/footer.php') ?>