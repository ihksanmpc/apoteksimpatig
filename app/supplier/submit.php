<?php

$id_supp = rand(111111111, 999999999);
$nama    = strtoupper($_POST['nama_supp']);
$alamat  = $_POST['almt_supp'];
$kontak  = $_POST['kntk_supp'];
$waktu   = date('Y-m-d H:i:s');

if (isset($_GET['id'])) {
    $id_supp = $_GET['id'];

    $query   = "UPDATE supplier SET 
               nama_supp = '$nama',
               almt_supp = '$alamat',
               kntk_supp = '$kontak'
               WHERE id_supp = '$id_supp'
            ";
} else {
    $query   = "INSERT INTO supplier SET 
               id_supp   = '$id_supp',
               nama_supp = '$nama',
               almt_supp = '$alamat',
               kntk_supp = '$kontak',
               wkt_supp  = '$waktu'
            ";
}

$exeSQL = mysqli_query($conn, $query) or die(mysqli_error($conn));

if ($exeSQL) {
    if (isset($_GET['id'])) {
        echo alert('Data supplier Anda berhasil di UBAH', 'home.php?view=supplier');
    } else {
        echo alert('Data supplier Anda berhasil di TAMBAHKAN', 'home.php?view=supplier');
    }
}
