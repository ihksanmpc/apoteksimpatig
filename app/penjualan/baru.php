<?php

$id      = rand(11111, 99999);
$tanggal = date('Y-m-d');
$nama    = 'UMUM';
$item    = 0;
$total   = 0;
$diskon  = 0;
$bayar   = 0;
$user    = $_SESSION['id_user'];
$waktu   = date('Y-m-d H:i:s');

// sql query
$query   = redirect('home.php?view=penjualan-detail&status=baru&id=' . $id);

// eksekusi
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));


