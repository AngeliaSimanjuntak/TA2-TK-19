<?php $title = 'Location'; ?>

<?php
require('../layouts/header.php');

is_admin();

date_default_timezone_set('Asia/Jakarta');

$no = 1;
$now = date('Y-m-d');

$locations = get('lokasi');
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'checkin') {
        $visitor = mysqli_query($connection, " SELECT * FROM visitor JOIN user ON visitor.user_id = user.id WHERE waktu_checkin LIKE '%$now%' AND checkin = 1 ");
    }

    if ($_GET['status'] == 'checkout') {
        $visitor = mysqli_query($connection, " SELECT * FROM visitor JOIN user ON visitor.user_id = user.id WHERE waktu_checkin LIKE '%$now%' AND checkout = 1 ");
    }
} else {
    $visitor = mysqli_query($connection, " SELECT * FROM user WHERE level = 'visitor'");
}

?>

<h1 class="mb-3">Visitor</h1>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <div class="row d-flex justify-content-between">
                <div class="col-md-4">
                    <a href="<?= $base_url; ?>/visitor" class="btn btn-primary mb-3">Register</a>
                    <a href="?status=checkin" class="btn btn-primary mb-3">Check In</a>
                    <a href="?status=checkout" class="btn btn-primary mb-3">Check Out</a>
                </div>

                <?php if (isset($_GET['status'])) : ?>
                    <div class="col-md-7">
                        <form action="">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <select name="location" id="location" class="form-control">
                                            <option disabled selected>-- Select Location --</option>
                                            <?php foreach ($locations as $lok) :  ?>
                                                <option <?= isset($_GET['location']) && $_GET['location'] == $lok['id'] ? 'selected' : '' ?> value="<?= $lok['id'] ?>"><?= $lok['nama_lokasi'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="date" name="date" id="date" class="form-control" value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Tampil</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <?php if (isset($_GET['status'])) : ?>
                            <th>Lokasi</th>
                            <th>Waktu</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($visitor as $visit) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <img src="../uploads/wajah/<?= $visit['gambar_wajah'] ?>" alt="" class="img-profile rounded-circle" width="60px">
                            </td>
                            <td><?= $visit['nama'] ?></td>
                            <td><?= $visit['email'] ?></td>
                            <?php if (isset($_GET['status'])) : ?>
                                <td>
                                    <?php
                                    $lokasi_id = $visit['lokasi_id'];
                                    $lokasi = mysqli_query($connection, "SELECT * FROM lokasi WHERE id = $lokasi_id")->fetch_assoc();
                                    ?>
                                    <?= $lokasi['nama_lokasi'] ?? '-' ?>
                                </td>
                                <td><?= isset($_GET['status']) && $_GET['status'] == 'checkout' ? date('d/m/Y', strtotime($visit['waktu_checkout'])) : date('d/m/Y H:i', strtotime($visit['waktu_checkin'])) ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require('../layouts/footer.php') ?>