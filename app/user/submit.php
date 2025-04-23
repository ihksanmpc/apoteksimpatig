<?php

$id_usr  = rand(111111111, 999999999);
$nama    = strtoupper($_POST['nama']);
$user    = strtolower(str_replace(' ', '', $_POST['nama']));
$pass    = md5(123456);
$level   = $_POST['level'];
$waktu   = date('Y-m-d H:i:s');

if (isset($_GET['id'])) {
    $id_usr = $_GET['id'];

    $query  =   "UPDATE user SET 
                    nama_usr = '$nama',
                    user_usr = '$user', 
                    lvl_usr  = '$level'
                WHERE id_usr = '$id_usr'";
} else {
    $query  =   "INSERT INTO user SET 
                    id_usr   = '$id_usr',
                    nama_usr = '$nama',
                    user_usr = '$user',
                    pass_usr = '$pass',
                    lvl_usr  = '$level',
                    wkt_usr  = '$waktu'
                ";
}

$exeSQL = mysqli_query($conn, $query) or die(mysqli_error($conn));

if ($exeSQL) {
    if (isset($_GET['id'])) {
        echo alert('Data user Anda berhasil di UBAH', 'home.php?view=user');
    } else {
        echo alert('Data user Anda berhasil di TAMBAHKAN', 'home.php?view=user');
    }
}
