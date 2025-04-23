<?php

$id_bl = $_GET['id'];

$q1 = "DELETE FROM pembelian WHERE id_bl=$id_bl";
query($conn, $q1);

$q2 = "SELECT * FROM pembelian_detail WHERE beli_id=$id_bl";
$s2 = mysqli_query($conn, $q2) or die(mysqli_error($conn));

while ($d2 = mysqli_fetch_array($s2)) {
    // UPDATE STOK PRODUK
    $prd_id   = $d2['prd_id'];
    $jml_bdet = $d2['jml_bdet'];
    $qStok = "UPDATE produk SET stok_prd=stok_prd-$jml_bdet WHERE id_prd=$prd_id";
    query($conn, $qStok);

    // DELETE PEMBELIAN DETAIL
    $prd_id = $d2['prd_id'];
    $query  = "DELETE FROM pembelian_detail WHERE beli_id=$id_bl AND prd_id=$prd_id";
    query($conn, $query);
}

// REDIRECT
echo redirect('home.php?view=pembelian');
