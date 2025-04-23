<?php
$id    = $_GET['id'];
$query = "DELETE FROM pengeluaran WHERE id_lr = '$id'";

// eksekusi
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo alert('Data Anda berhasil di HAPUS', 'home.php?view=pengeluaran');
