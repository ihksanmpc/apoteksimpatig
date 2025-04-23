<?php
$id    = $_GET['id'];
$query = "DELETE FROM penjualan_tdk_tercatat WHERE id_ptt = '$id'";

// eksekusi
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo alert('Data Anda berhasil di HAPUS', 'home.php?view=penjualantt');
