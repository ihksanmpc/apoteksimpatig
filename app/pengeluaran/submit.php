<?php
// Mengambil data dari POST dan memastikan data aman
$jenis   = strtoupper(mysqli_real_escape_string($conn, $_POST['jenis']));
$nominal = mysqli_real_escape_string($conn, $_POST['nominal']);
$tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
$waktu   = date('Y-m-d H:i:s');
$user    = mysqli_real_escape_string($conn, $_SESSION['id_user']);

// Jika ID ada di URL (edit mode)
if (isset($_GET['id'])) {
    $id_lr  = mysqli_real_escape_string($conn, $_GET['id']); // Sanitasi ID

    // Query UPDATE
    $query = "UPDATE pengeluaran SET 
                tgl_lr  = '$tanggal',
                jns_lr  = '$jenis',
                nmnl_lr = '$nominal',
                user_id = '$user'
              WHERE id_lr = '$id_lr'";
} else {
    // ID baru untuk INSERT
    $id_lr = rand(1111, 9999);

    // Query INSERT
    $query = "INSERT INTO pengeluaran (id_lr, tgl_lr, jns_lr, nmnl_lr, user_id, wkt_lr) 
              VALUES ('$id_lr', '$tanggal', '$jenis', '$nominal', '$user', '$waktu')";
}

// Eksekusi query
$exeSQL = mysqli_query($conn, $query);

// Mengecek hasil eksekusi
if ($exeSQL) {
    if (isset($_GET['id'])) {
        echo alert('Data pengeluaran Anda berhasil di UBAH', 'home.php?view=pengeluaran');
    } else {
        echo alert('Data pengeluaran Anda berhasil di TAMBAHKAN', 'home.php?view=pengeluaran');
    }
} else {
    // Jika gagal
    echo "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
}
?>
