<?php
$id    = $_GET['id'];
$query = "DELETE FROM produk WHERE id_prd = '$id'";

// eksekusi
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo alert('Data produk Anda berhasil di HAPUS', 'home.php?view=produk');
