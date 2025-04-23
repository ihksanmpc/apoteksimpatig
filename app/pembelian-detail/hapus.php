<?php

$status   = $_GET['status'];
$beli_id  = $_GET['id-beli'];
$prd_id   = $_GET['id-prd'];
$jml_bdet = $_GET['qty'];

// UPDATE STOK PRODUK
$qStok = "UPDATE produk SET stok_prd=stok_prd-$jml_bdet WHERE id_prd=$prd_id";
query($conn, $qStok);

// DELETE PEMBELIAN DETAIL
$query   = "DELETE FROM pembelian_detail WHERE beli_id=$beli_id AND prd_id=$prd_id";
query($conn, $query);
// DELETE PEMBELIAN DETAIL
$query   = "DELETE FROM kartu_stok WHERE  id_prd=$prd_id";
query($conn, $query);

// REDIRECT
echo redirect('home.php?view=pembelian-detail&status=' . $status . '&id=' . $beli_id);
