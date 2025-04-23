<?php
$jualID = $_GET['id'];

// Query untuk mendapatkan data penjualan
$query = "SELECT * FROM penjualan WHERE id_jl=$jualID LIMIT 1";
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data = mysqli_fetch_assoc($sql);

// Query untuk mendapatkan nama user
$query_user = "SELECT u.nama_usr, p.wkt_jl FROM penjualan p
               LEFT JOIN user u ON p.user_id = u.id_usr
               WHERE p.id_jl = $jualID";
$sql_user = mysqli_query($conn, $query_user) or die(mysqli_error($conn));
$user_data = mysqli_fetch_assoc($sql_user);

// Mengambil informasi metode pembayaran
$metode_pembayaran = $data['pembayaran']; // Misalnya 'metode_pembayaran' adalah kolom yang menyimpan "tunai" atau "transfer"

// Inisialisasi variabel diskon dan grandtotal
$diskon = isset($data['disk_jl']) ? $data['disk_jl'] : 0; // Pastikan diskon ada, jika tidak, set ke 0
$grandtotal = 0; 

$jual_id = $_GET['id'];
$query_detail = "SELECT * FROM penjualan_detail JOIN produk ON penjualan_detail.prd_id=produk.id_prd WHERE jual_id=$jual_id ORDER BY id_jdet DESC";
$sql_detail = mysqli_query($conn, $query_detail) or die(mysqli_error($conn));
$item = mysqli_num_rows($sql_detail);

// Reset grand total untuk menjumlahkan semua produk
$total_semua_produk = 0;

while ($list = mysqli_fetch_assoc($sql_detail)) {
    $total = $list['jual_prd'] * $list['jml_jdet'];
    $total_semua_produk += $total; // Menjumlahkan total semua produk
}

// Setelah loop selesai, kurangi diskon dari total semua produk
$grandtotal = $total_semua_produk - $diskon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
</head>
<body>


<div id="table-print">
<p class="header"><h3>APOTEK SIMPATIG</h3></p>
<p>Simpang Tiga MPC</p>
<p>----------------</p>
<p>Kasir:<?= htmlspecialchars($user_data['nama_usr']) ?></p> <!-- Menampilkan nama kasir -->
<p>Tgl : <?= date('d-m-Y H:i:s'  ,  strtotime($user_data['wkt_jl'])) ?></p> <!-- Menampilkan tanggal penjualan -->
<p>----------------</p>
    <table>
        <thead>
            <tr>  
                <td> Harga - </td>
                <td> Qty- </td>
                <td> Total</td>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan detail produk
            mysqli_data_seek($sql_detail, 0); // Reset pointer result set
            while ($list = mysqli_fetch_assoc($sql_detail)) {
                $total_item = $list['jual_prd'] * $list['jml_jdet'];
                echo "<tr>";
                echo "<td colspan='3'>" . htmlspecialchars($list['nama_prd']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td></td>";
                echo "<td>" . number_format($list['jual_prd'], 0, ',', '.') . "x</td>";
                echo "<td class='text-center'>" . number_format($list['jml_jdet']) ."=</td>";
                echo "<td>" . number_format($total_item, 0, ',', '.') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<p>----------------</p>
    <p>Pembayaran: </p>
    <p><?= htmlspecialchars($metode_pembayaran) ?></p>
    <p>Jumlah Item: <?= $item ?></p>
 <p>Diskon: Rp. <?= number_format($diskon, 0, ',', '.') ?></p>
    <p><strong>Grand Total:</p>
    <p> Rp. <?= number_format($grandtotal, 0, ',', '.') ?></strong></p>
<p>----------------</p>
    <div class="table-footer">
        <p>Semoga Lekas</p>
         <p> Sembuh! Terima </p>
          <p>Kasih Atas </p>
          <p>Kepercayaan Anda</p>
         
    </div>
</div>

<script type="text/javascript">
    function printTable() {
        var printContents = document.getElementById('table-print').outerHTML;
        var originalContents = document.body.innerHTML;

        var printWindow = window.open('', '', 'height=400, width=300');
        printWindow.document.write('<html><head><title>Print</title>');

        printWindow.document.write(`
            <style>
                body { font-family: Arial, sans-serif; font-size: 8px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { padding: 1px; text-align: left; font-size: 8px; border:1px }
                th { background-color: #f2f2f2; }
                 .heder { font-size: 10px; text-align: center; margin-top: 10px; }
                .table-footer { font-size: 5px; text-align: center; margin-top: 10px; }

            </style>
        `);

        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');

        printWindow.document.close();
        printWindow.print();
    }
</script>

<button onclick="printTable()">Print Invoice</button>

</body>
</html>
