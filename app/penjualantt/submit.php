<?php
// Mengambil data dari POST
$nominal = $_POST['nominal'];
$tanggal = $_POST['tanggal'];
$ket = $_POST['ket'];
$waktu   = date('Y-m-d H:i:s');
$user    = $_SESSION['id_user'];

// Menggunakan mysqli_real_escape_string untuk mencegah SQL Injection
$nominal = mysqli_real_escape_string($conn, $nominal);
$tanggal = mysqli_real_escape_string($conn, $tanggal);
$ket = mysqli_real_escape_string($conn, $ket);
$user = mysqli_real_escape_string($conn, $user);

// Jika ID ada di URL (edit mode)
if (isset($_GET['id'])) {
    $id_ptt  = $_GET['id']; // Pastikan ID juga disanitasi untuk mencegah SQL Injection
    $id_ptt = mysqli_real_escape_string($conn, $id_ptt);

    // Query UPDATE
    $query = "UPDATE penjualan_tdk_tercatat SET 
                tgl_ptt  = '$tanggal',
                nmnl_ptt = '$nominal',
                ket      = '$ket',
                user_id  = '$user'
              WHERE id_ptt = '$id_ptt'";
} else {
    // Query INSERT
    $id_ptt = rand(1111, 9999); // ID baru untuk insert
    $query = "INSERT INTO penjualan_tdk_tercatat 
                (id_ptt, tgl_ptt, nmnl_ptt, ket, user_id, wkt_ptt) 
              VALUES 
                ('$id_ptt', '$tanggal', '$nominal', '$ket', '$user', '$waktu')";
}

// Eksekusi query
$exeSQL = mysqli_query($conn, $query);

// Mengecek hasil eksekusi
if ($exeSQL) {
    if (isset($_GET['id'])) {
        echo alert('Data Anda berhasil di UBAH', 'home.php?view=penjualantt');
    } else {
        echo alert('Data Anda berhasil di TAMBAHKAN', 'home.php?view=penjualantt');
    }
} else {
    echo "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
}
?>
