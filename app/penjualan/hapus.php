<?php

$id_jl = $_GET['id'];

$q1 = "DELETE FROM penjualan WHERE id_jl=$id_jl";
query($conn, $q1);

$q2 = "SELECT * FROM penjualan_detail WHERE jual_id=$id_jl";
$s2 = mysqli_query($conn, $q2) or die(mysqli_error($conn));

while ($d2 = mysqli_fetch_array($s2)) {
    // UPDATE STOK PRODUK
    $prd_id   = $d2['prd_id'];
    $jml_jdet = $d2['jml_jdet'];
    $qStok = "UPDATE produk SET stok_prd=stok_prd+$jml_jdet WHERE id_prd=$prd_id";
    query($conn, $qStok);

    // DELETE PENJUALAN DETAIL
    $prd_id = $d2['prd_id'];
    $query  = "DELETE FROM penjualan_detail WHERE jual_id=$id_jl AND prd_id=$prd_id";
    query($conn, $query);
}

// REDIRECT
echo redirect('home.php?view=penjualan');
