<?php

/**
 * Variabel untuk menangkap seluruh input dari form
 */
$iduser   = $_SESSION['id_user'];
$fullname = strtoupper($_POST['fullname_user']);
$username = $_POST['name_user'];

if ($_POST['pass_user'] == null) {
    $password  = $_SESSION['password'];
} else {
    $password  = md5($_POST['pass_user']);
}

/**
 *  VARIABEL QUERY MYSQL 
 * 
 * $query  => untuk menulis script query dari MySQL
 * $exeSQL => untuk menjalankan perintah atau eksekusi query dari variabel $query
 */
$query  = "UPDATE user SET nama_usr='$fullname', user_usr='$username', pass_usr='$password' WHERE id_usr='$iduser'";
$exeSQL = mysqli_query($conn, $query) or die(mysqli_error($conn));

if ($exeSQL) {

    // Ambil data yang telah dirubah
    $queryData  = "SELECT * FROM user WHERE id_usr='$iduser' LIMIT 1";
    $exeSQLData = mysqli_query($conn, $queryData) or die(mysqli_error($conn));
    $data       = mysqli_fetch_array($exeSQLData);

    /**
     * VARIABEL SESSION
     * 
     * untuk membuat session dari user yang sedang login
     */
    $_SESSION['id_user']      = $data['id_usr'];
    $_SESSION['nama_lengkap'] = $data['nama_usr'];
    $_SESSION['username']     = $data['user_usr'];
    $_SESSION['password']     = $data['pass_usr'];
    $_SESSION['level']        = $data['lvl_usr'];

    echo alert('Pengaturan user Anda BERHASIL diperbarui', 'home.php?view=profile');
} else {
    // JIKA FALSE
    echo alert('Pengaturan user Anda GAGAL diperbarui', 'home.php?view=profile');
}
