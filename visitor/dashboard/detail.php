<?php $title = 'Location'; ?>

<?php
require('../layouts/header.php');

is_admin();

if (isset($_GET['id'])) {
    $no = 1;
    $id = $_GET['id'];

    $lokasi = find('lokasi', $id);
    $visitor = mysqli_query($connection, "SELECT * FROM visitor JOIN user ON visitor.user_id = user.id WHERE lokasi_id = $id ");
}


?>


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <h2 class="mb-3">Detail Visitor <?= $lokasi['nama_lokasi'] ?></h2>
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Waktu Check In</th>
                        <th>Waktu Check Out</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($visitor as $visit) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $visit['email'] ?></td>
                            <td><?= $visit['nama'] ?></td>
                            <td><?= $visit['waktu_checkin'] ?? '-' ?></td>
                            <td><?= $visit['waktu_checkout'] ?? '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require('../layouts/footer.php') ?>