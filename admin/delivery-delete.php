<?php
include('../koneksi.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM delivery WHERE receipt_id = '$id'";
    $sql2 = "DELETE FROM shipping WHERE receipt_id = '$id'";
    $sql3 = "DELETE FROM transaction WHERE receipt_id = '$id'";

    if(mysqli_query($koneksi, $sql) && mysqli_query($koneksi, $sql2) && mysqli_query($koneksi, $sql3)) {
        echo "
            <script>
                alert('Proses Hapus Berhasil');
                window.location = '../delivery.php';
            </script>
        ";
    }
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = '../delivery.php';
            </script>
        ";
    }
?>
