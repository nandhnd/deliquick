<?php 
include '../koneksi.php';

if(isset($_POST['add'])) {
    $id = "user-".date('dmysHG');
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO user VALUES('$id', '$username', '$email', '$password','$role')";

    if(empty($email) || empty($username) || empty($password)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'user.php';
            </script>
        ";
    }elseif(mysqli_query($koneksi, $sql)) {
        echo "  
            <script>
                alert('Tambah User Berhasil');
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
