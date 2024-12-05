<?php
include('../koneksi.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM user WHERE id = '$id'";

    if(mysqli_query($koneksi, $sql)) {
        echo "
            <script>
                alert('Hapus User Berhasil');
                window.location = '../user.php';
            </script>
        ";
    }
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = '../user.php';
            </script>
        ";
    }
?>
