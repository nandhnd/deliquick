<?php 
date_default_timezone_set('Asia/Jakarta');

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'db_deliquick';

$koneksi = mysqli_connect($servername, $username, $password, $database);

if(!$koneksi) {
    die('Connection Failed:' . mysqli_connect_error());
}

?>