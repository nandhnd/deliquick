<?php 
include '../koneksi.php';

if(isset($_POST['add'])) {
    $receipt_id = $_POST['receipt_id'];
    $shipping_status = $_POST['status'];
    $location = $_POST['location'];
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $result = $koneksi->query("SELECT id FROM shipping ORDER BY id DESC LIMIT 1");
    $row = $result->fetch_assoc();
    $latest_shipment_id = $row['id'];

    $prefix = substr($latest_shipment_id, 0, -1);
    $last_digit = substr($latest_shipment_id, -1);

    $new_shipment_id = $prefix . ((int)$last_digit + 1);

    $sql = "INSERT INTO shipping VALUES('$new_shipment_id', '$receipt_id', '$shipping_status', '$date', '$time', '$location')";

    if(empty($shipping_status) || empty($location)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'shipping.php?receipt=". $receipt_id ."';
            </script>
        ";
    }elseif(mysqli_query($koneksi, $sql)) {
        if($shipping_status=="Tiba di tujuan") $koneksi->query("UPDATE delivery SET status = 'Completed' WHERE receipt_id = '$receipt_id'");
        echo "  
            <script>
                alert('Proses Tambah Berhasil');
                window.location = 'shipping.php?receipt=". $receipt_id ."';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = 'shipping.php?receipt=". $receipt_id ."';
            </script>
        ";
    }
}

?>
