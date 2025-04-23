<?php

/**
 * SETUP KONFIGURASI DATABASE MYSQL
 * ================================
 */
$host     = "localhost";
$user     = "apoteksi_apotek";
$pass     = "XxbTR7YUdfww2jHCPyvk";
$db       = "apoteksi_apotek";
$title    = "Apotek";


// JALANKAN KONEKSI
$conn = mysqli_connect($host, $user, $pass, $db);

// QUERY BUILDER
function query($conn, $query)
{
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}
