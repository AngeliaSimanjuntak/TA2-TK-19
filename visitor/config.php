<?php

date_default_timezone_set('Asia/Jakarta');


$host = 'localhost';
$username = 'root';
$password = '';
$database = 'visitor';

$base_url = 'http://localhost/visitor';

$connection = mysqli_connect($host, $username, $password, $database) or die;
