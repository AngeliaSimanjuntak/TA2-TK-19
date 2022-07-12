<?php $title = 'Location'; ?>

<?php
require('../layouts/header.php');

$locations = get('lokasi');
$no = 1;

if (isset($_GET['location']) && isset($_GET['month'])) {
    $lokasi_id = $_GET['location'];
    $month = $_GET['month'];

    $countVisitor = mysqli_query($connection, "SELECT MONTH(waktu_checkin) AS MONTH, WEEK(waktu_checkin) AS WEEK, COUNT(user_id) AS total FROM visitor WHERE lokasi_id = '$lokasi_id' && MONTH(waktu_checkin) = '$month' GROUP BY WEEK(waktu_checkin)");
} else {
    $countVisitor = mysqli_query($connection, "SELECT MONTH(waktu_checkin) AS MONTH, WEEK(waktu_checkin) AS WEEK, COUNT(user_id) AS total FROM visitor WHERE lokasi_id = 1 && MONTH(waktu_checkin) = MONTH(CURDATE()) GROUP BY WEEK(waktu_checkin)");
}

$data = '';

foreach ($countVisitor as $q) {
    $data .= $q['total'] . ',';
}



if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $devices = get('device');
    foreach ($devices as $dev) {
        if ($dev['lokasi_id'] == $id) {
            $_SESSION['error'] = 'Lokasi gagal didelete';
        } else {
            $query = mysqli_query($connection, "DELETE FROM lokasi WHERE id = '$id' ");

            if ($query) {
                $_SESSION['success'] = 'Lokasi berhasil didelete';
            } else {
                $_SESSION['error'] = 'Lokasi gagal didelete';
            }
        }
    }

    echo '<script>
            window.location.href="index.php"
         </script>';
}
?>

<h1 class="mb-3">Location</h1>

<?php if ($_SESSION['level'] == 'admin') : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <a href="form.php" class="btn btn-primary mb-3">Add Location</a>
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Lokasi</th>
                            <th>Alamat</th>
                            <th>Jam Operasional</th>
                            <th class="text-center">Jumlah Maximum</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($locations as $location) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $location['nama_lokasi'] ?></td>
                                <td><?= $location['alamat'] ?></td>
                                <td><?= $location['jam_operasional'] ?></td>
                                <td class="text-center"><?= $location['jml_maximum'] ?></td>
                                <td class="d-flex">
                                    <a href="form.php?id=<?= $location['id'] ?>" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?= $location['id'] ?>">
                                        <button type="submit" name="delete" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data lokasi ?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else : ?>
    <form action="" method="get">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <select name="location" id="location" class="form-control" required>
                        <option disabled selected>-- Select Location --</option>
                        <?php foreach ($locations as $location) :  ?>
                            <option <?= isset($_GET['location']) && $_GET['location'] == $location['id'] ? 'selected' : '' ?> value="<?= $location['id'] ?>"><?= $location['nama_lokasi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="month" id="month" class="form-control" required>
                        <option disabled selected>-- Select Month --</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 1 ? 'selected' : '' ?> value="1">Januari</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 2 ? 'selected' : '' ?> value="2">Februari</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 3 ? 'selected' : '' ?> value="3">Maret</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 4 ? 'selected' : '' ?> value="4">April</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 5 ? 'selected' : '' ?> value="5">Mei</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 6 ? 'selected' : '' ?> value="6">Juni</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 7 ? 'selected' : '' ?> value="7">Juli</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 8 ? 'selected' : '' ?> value="8">Agustus</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 9 ? 'selected' : '' ?> value="9">September</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 10 ? 'selected' : '' ?> value="10">Oktober</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 11 ? 'selected' : '' ?> value="11">November</option>
                        <option <?= isset($_GET['month']) && $_GET['month'] == 12 ? 'selected' : '' ?> value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <div class="row my-3">
        <div class="col-md-6">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Jumlah Maximum Lokasi <?= isset($_GET['location']) ? find('lokasi', $_GET['location'])['nama_lokasi'] : first('lokasi')['nama_lokasi'] ?></th>
                        <th><?= isset($_GET['location']) ? find('lokasi', $_GET['location'])['jml_maximum'] : first('lokasi')['jml_maximum'] ?></th>
                    </tr>
                    <tr>
                        <th>Jumlah Pengunjung Hari Ini</th>
                        <th>
                            <?php
                            $now = date('Y-m-d');
                            if (isset($_GET['location'])) {
                                $lokasi_id = $_GET['location'];

                                $total = mysqli_query($connection, "SELECT COUNT(user_id) as total FROM visitor WHERE lokasi_id = $lokasi_id AND waktu_checkin LIKE '%$now%' ")->fetch_array();
                            } else {
                                $total = mysqli_query($connection, "SELECT COUNT(user_id) as total FROM visitor WHERE lokasi_id = 1 AND waktu_checkin LIKE '%$now%' ")->fetch_array();
                            }
                            ?>

                            <?= $total['total']  ?>
                        </th>
                    </tr>
                    <tr>
                        <th>Jumlah Pengunjung Bulan <?= isset($_GET['month']) ? date('F', mktime(0, 0, 0, $_GET['month'], 10)) : date('F') ?></th>
                        <th>
                            <?php
                            $now = date('Y-m-d');
                            if (isset($_GET['location']) && isset($_GET['month'])) {
                                $lokasi_id = $_GET['location'];
                                $month = $_GET['month'];

                                $totalMonth = mysqli_query($connection, "SELECT COUNT(user_id) as total FROM visitor WHERE lokasi_id = $lokasi_id AND MONTH(waktu_checkin) = '$month' ")->fetch_array();
                            } else {
                                $totalMonth = mysqli_query($connection, "SELECT COUNT(user_id) as total FROM visitor WHERE lokasi_id = 1 AND MONTH(waktu_checkin) = MONTH(CURDATE()) ")->fetch_array();
                            }
                            ?>

                            <?= $totalMonth['total']  ?>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Visitor Lokasi <?= isset($_GET['location']) ? find('lokasi', $_GET['location'])['nama_lokasi'] : first('lokasi')['nama_lokasi'] ?> Bulan <?= isset($_GET['month']) ? date('F', mktime(0, 0, 0, $_GET['month'], 10)) : date('F') ?></h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require('../layouts/footer.php') ?>