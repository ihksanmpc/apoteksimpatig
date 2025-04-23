<?php

$id_jl  = $_POST['id_jl'];
$nama   = strtoupper($_POST['nama']);
$item   = $_POST['item'];
$total  = $_POST['total'];
$diskon = $_POST['diskon'];
$bayar  = $_POST['grandtotal'];
$tanggal = date('Y-m-d');
$user    = $_SESSION['id_user'];
$waktu   = date('Y-m-d H:i:s');
$pembayaran  = strtoupper($_POST['pembayaran']);

// Mengecek apakah id_jl sudah ada di database
$query_check = "SELECT * FROM penjualan WHERE id_jl = '$id_jl'";
$result_check = mysqli_query($conn, $query_check);

// Jika id_jl sudah ada, lakukan UPDATE
if (mysqli_num_rows($result_check) > 0) {
    // Query UPDATE
    $query = "UPDATE penjualan SET 
                tgl_jl        = '$tanggal',
                nama_customer = '$nama',
                item_jl       = '$item',
                total_jl      = '$total',
                disk_jl       = '$diskon',
                byr_jl        = '$bayar',
                user_id       = '$user',
                wkt_jl        = '$waktu',
                pembayaran    = '$pembayaran'
              WHERE id_jl = '$id_jl'";
} else {
    // Jika id_jl belum ada, lakukan INSERT
    $query = "INSERT INTO penjualan SET 
                id_jl         = '$id_jl',
                tgl_jl        = '$tanggal',
                nama_customer = '$nama',
                item_jl       = '$item',
                total_jl      = '$total',
                disk_jl       = '$diskon',
                byr_jl        = '$bayar',
                user_id       = '$user',
                wkt_jl        = '$waktu',
                 pembayaran    = '$pembayaran'
              ";
}

// Eksekusi query
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo redirect('home.php?view=penjualan');
?>
