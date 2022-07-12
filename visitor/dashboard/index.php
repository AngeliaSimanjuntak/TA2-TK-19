<?php $title = 'Dashboard'; ?>

<?php
require('../layouts/header.php');

$location = get('lokasi');

if (isset($_GET['location']) && isset($_GET['date'])) {
    $idlok = $_GET['location'];
    $now = $_GET['date'];

    if ($idlok == 'all') {
        $lokasi = get('lokasi');
    } else {
        $lokasi = mysqli_query($connection, "SELECT * FROM lokasi WHERE id = $idlok");
    }
} else {
    $lokasi = get('lokasi');
    $now = date('Y-m-d');
}
?>

<h1 class="mb-3">Dashboard</h1>

<form action="">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="location">Location</label>
                <select name="location" id="location" class="form-control">
                    <option disabled selected>-- Select Location --</option>
                    <option value="all">All Location</option>
                    <?php foreach ($location as $lok) :  ?>
                        <option <?= isset($_GET['location']) && $_GET['location'] == $lok['id'] ? 'selected' : '' ?> value="<?= $lok['id'] ?>"><?= $lok['nama_lokasi'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <br>
                <button type="submit" class="btn btn-primary mt-2">Tampil</button>
            </div>
        </div>
    </div>
</form>

<div class="row mt-3 mb-5">
    <?php foreach ($lokasi as $lk) :  ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <?php if ($_SESSION['level'] == 'admin') : ?>
                        <a href="detail.php?id=<?= $lk['id'] ?>"><?= $lk['nama_lokasi'] ?></a>
                    <?php else : ?>
                        <a href="../location/index.php?location=<?= $lk['id'] ?>"><?= $lk['nama_lokasi'] ?></a>
                    <?php endif; ?>
                    <h1>
                        <?php
                        $idlok = $lk['id'];
                        $visitor = mysqli_query($connection, "SELECT count(user_id) as total FROM visitor WHERE lokasi_id = '$idlok' AND checkin = 1 AND checkout = 0 AND waktu_checkin LIKE '%$now%' ")->fetch_assoc();

                        echo $visitor['total'];
                        ?>
                        /
                        <?php
                        $maximum = mysqli_query($connection, "SELECT * FROM lokasi WHERE id = '$idlok'")->fetch_assoc();

                        echo $maximum['jml_maximum'];
                        ?>
                    </h1>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php require('../layouts/footer.php') ?>