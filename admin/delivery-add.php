<?php 
include '../koneksi.php';

if(isset($_POST['add'])) {
    $receipt_id = "dlq-".date('YmdHis');
    $customer_name = $_POST['name'];
    $customer_phone = $_POST['phone'];
    $pickup_address = $_POST['pickup'];
    $delivery_address = $_POST['delivery'];
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $status = 'In Progress';

    $shipping_id="ship-".$receipt_id."1";
    $shipping_status="Menunggu Pickup";

    $transaction_id="trn-".$receipt_id;
    $payment_method = "-";
    $amount= "0";
    $transaction_status = "Waiting Payment";

    $sql = "INSERT INTO delivery VALUES('$receipt_id', '$customer_name', '$customer_phone', '$pickup_address',
            '$delivery_address', '$date', '$time','$status')";

    $sql2 = "INSERT INTO shipping VALUES('$shipping_id', '$receipt_id', '$shipping_status', '$date', '$time', '$pickup_address')";

    $sql3 = "INSERT INTO transaction VALUES('$transaction_id', '$receipt_id', '$date', '$payment_method', '$amount', '$transaction_status')";


    
    if(empty($receipt_id) || empty($customer_name) || empty($customer_phone || empty($pickup_address) || empty($delivery_address))) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'delivery.php';
            </script>
        ";
    }elseif(mysqli_query($koneksi, $sql) && mysqli_query($koneksi, $sql2) && mysqli_query($koneksi, $sql3)) {

        echo "  
            <script>
                alert('Proses Tambah Berhasil');
                window.location = 'delivery.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = 'delivery.php';
            </script>
        ";
    }
}

?>
