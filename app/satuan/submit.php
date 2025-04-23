<?php

$id_stn   = rand(111111111, 999999999);
$nama_stn = strtoupper($_POST['nama_stn']);
$wkt_stn  = date('Y-m-d H:i:s');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query   = "UPDATE satuan SET nama_stn = '$nama_stn' WHERE id_stn = '$id'";
} else {
    $query   = "INSERT INTO satuan SET 
                    id_stn   = '$id_stn',
                    nama_stn = '$nama_stn',
                    wkt_stn  = '$wkt_stn'
                ";
}

$exeSQL = mysqli_query($conn, $query) or die(mysqli_error($conn));

if ($exeSQL) {
    if (isset($_GET['id'])) {
        echo alert('Data satuan Anda berhasil di UBAH', 'home.php?view=satuan');
    } else {
        echo alert('Data satuan Anda berhasil di TAMBAHKAN', 'home.php?view=satuan');
    }
}
