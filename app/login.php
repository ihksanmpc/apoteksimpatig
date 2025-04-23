<?php

// jalankan session
session_start();

// include file koneksi
include("../library.php");

// init variabel
$username = $_POST['username'];
$password = md5($_POST['password']);

// query sql untuk ambil data user dan password
$query = "SELECT * FROM user WHERE user_usr='$username' AND pass_usr='$password'";

// eksekusi query
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

// hitung jumlah data yang terambil
$jumlah_data = mysqli_num_rows($sql);

// fetching array data dari sql
$data = mysqli_fetch_array($sql);

// jika jumlah data sama dengan satu atau ketemu
if ($jumlah_data == 1) {

    // buat session
    $_SESSION['id_user']      = $data['id_usr'];
    $_SESSION['nama_lengkap'] = $data['nama_usr'];
    $_SESSION['username']     = $data['user_usr'];
    $_SESSION['password']     = $data['pass_usr'];
    $_SESSION['level']        = $data['lvl_usr'];
    $_SESSION['status']       = 'LOGIN';

    // cek level user
    if ($data['lvl_usr'] == 1) {
        // berhasil
        header("location: ../home.php?view=admin");
    } else {
        // berhasil
        header("location: ../home.php?view=operator");
    }
} else {
    // gagal
    $message = 'User tidak ditemukan. Harap masukkan username dan password yang benar!';
    alert($message, '../index.php');
}
