<?php

$id        = rand(111111111, 999999999);
$tanggal   = date('Y-m-d');
$jth_tempo = date('Y-m-d');
$supplier  = 0;
$item      = 0;
$total     = 0;
$diskon    = 0;
$bayar     = 0;
$user      = $_SESSION['id_user'];
$waktu     = date('Y-m-d H:i:s');

// sql query
$query   = redirect('home.php?view=pembelian-detail&status=baru&id=' . $id);

// eksekusi
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));



