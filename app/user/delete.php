<?php

$id    = $_GET['id'];
$query = "DELETE FROM user WHERE id_usr = '$id'";

// eksekusi
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo alert('Data user Anda berhasil di HAPUS', 'home.php?view=user');
