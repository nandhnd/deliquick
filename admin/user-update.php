<?php
include('../koneksi.php');

if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE user SET name = '$username', email = '$email', role = '$role' WHERE id = '$id'";

    if(empty($email) || empty($username)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'user.php';
            </script>
        ";
    }elseif(mysqli_query($koneksi, $sql)) {
        echo "  
            <script>
                alert('Edit User Berhasil');
                window.location = 'user.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = 'user.php';
            </script>
        ";
    }
}
?>
