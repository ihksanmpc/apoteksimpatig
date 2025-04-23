<?php

$status   = $_GET['status'];
$jual_id  = $_GET['id-jual'];
$prd_id   = $_GET['id-prd'];
$jml_bdet = $_GET['qty'];

// UPDATE STOK PRODUK
$qStok = "UPDATE produk SET stok_prd=stok_prd+$jml_bdet WHERE id_prd=$prd_id";
query($conn, $qStok);

// DELETE PENJUALAN DETAIL
$query   = "DELETE FROM penjualan_detail WHERE jual_id=$jual_id AND prd_id=$prd_id";
query($conn, $query);

$query   = "DELETE FROM kartu_stok WHERE  id_prd=$prd_id";
query($conn, $query);

// REDIRECT
echo redirect('home.php?view=penjualan-detail&status=' . $status . '&id=' . $jual_id);
