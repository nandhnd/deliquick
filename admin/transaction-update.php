<?php
include('../koneksi.php');

if(isset($_POST['edit'])) {
    $receipt_id = $_POST['receipt_id'];
    $payment_method = $_POST['payment_method'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    $sql = "UPDATE transaction SET payment_method = '$payment_method', amount = '$amount', status = '$status' WHERE receipt_id = '$receipt_id'";

    if(empty($payment_method) || empty($amount) || empty($status)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'transaction.php';
            </script>
        ";
    }elseif(mysqli_query($koneksi, $sql)) {
        echo "  
            <script>
                alert('Proses Edit Berhasil');
                window.location = 'transaction.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = 'transaction.php';
            </script>
        ";
    }
}
?>
