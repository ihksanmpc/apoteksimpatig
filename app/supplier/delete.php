<?php
$id    = $_GET['id'];
$query = "DELETE FROM supplier WHERE id_supp = '$id'";

// eksekusi
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo alert('Data supplier Anda berhasil di HAPUS', 'home.php?view=supplier');
