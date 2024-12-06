<?php
include('../koneksi.php');
require_once("../dompdf/autoload.inc.php");

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$query = mysqli_query($koneksi, "SELECT * FROM transaction");
$html = '<center><h3>Data Transaksi</h3></center><hr/><br>';
$html .= '<table border="1" width="100%" style="border-collapse: collapse;">
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Receipt ID</th>
                <th>Date</th>
                <th>Payment</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>';
$no = 1;
while ($transaction = mysqli_fetch_array($query)) {
    $html .= "<tr>
                <td>" . $no . "</td>
                <td>" . $transaction['id'] . "</td>
                <td>" . $transaction['receipt_id'] . "</td>
                <td>" . substr($transaction['date'], 0, 10) . "</td>
                <td>" . $transaction['payment_method'] . "</td>
                <td>Rp. " . $transaction['amount'] . "</td>
                <td>" . $transaction['status'] . "</td>
            </tr>";
    $no++;
}
$html .= "</table>";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream('laporan-transaksi.pdf');
?>
