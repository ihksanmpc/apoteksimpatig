<?php
$id    = $_GET['id'];
$query = "DELETE FROM satuan WHERE id_stn = '$id'";

// eksekusi
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo alert('Data satuan Anda berhasil di HAPUS', 'home.php?view=satuan');
