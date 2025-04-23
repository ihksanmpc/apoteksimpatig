<?php
$id_prd = $_GET['id'];
$id_stokop = rand(1111, 9999);
$nama_prd = strtoupper($_POST['nama_prd']);
$beli_prd = $_POST['beli_prd'];
$stok_prd = $_POST['stok_prd'];
$stokny = $_POST['stokny'];
$selisi = $_POST['selisi'];
$tselisi = $_POST['tselisi'];
$ket = $_POST['ket'];
$tgl_op = $_POST['tgl_op'];

// Query untuk mengecek apakah produk dengan id_prd dan tgl_op sudah ada
$checkQuery = "SELECT * FROM stokopname WHERE id_prd = '$id_prd' AND tgl_op = '$tgl_op'";
$checkResult = mysqli_query($conn, $checkQuery);

// Jika data dengan id_prd dan tgl_op sudah ada, lakukan operasi update
if (mysqli_num_rows($checkResult) > 0) {
    $query = "UPDATE stokopname SET 
        id_stokop = '$id_stokop',
        nama_prd = '$nama_prd',
        beli_prd = '$beli_prd',
        stok_prd = '$stok_prd',
        stokny = '$stokny',
        selisi = '$selisi',
        tselisi = '$tselisi',
        ket = '$ket',
        tgl_op = '$tgl_op' 
        WHERE id_prd = '$id_prd' AND tgl_op = '$tgl_op'";  // Menggunakan WHERE untuk memastikan update yang tepat
} else {
    // Query SQL untuk insert data produk ke dalam stokopname
    $query = "INSERT INTO stokopname 
        (id_stokop, id_prd, nama_prd, beli_prd, stok_prd, stokny, selisi, tselisi, ket, tgl_op) 
        VALUES 
        ('$id_stokop', '$id_prd', '$nama_prd', '$beli_prd', '$stok_prd', '$stokny', '$selisi', '$tselisi', '$ket', '$tgl_op')";
}

// Menjalankan query untuk update atau insert
$exeSQL = mysqli_query($conn, $query);

if ($exeSQL) {
    // Update stok di tabel produk setelah berhasil memasukkan data ke stokopname
    $updateStokQuery = "UPDATE produk SET stok_prd = '$stokny' WHERE id_prd = '$id_prd'";

    $updateResult = mysqli_query($conn, $updateStokQuery);

    if ($updateResult) {
        echo "<script>alert('Data produk berhasil diperbarui dan stok berhasil diperbarui!'); window.location.href = 'home.php?view=produk';</script>";
    } else {
        echo 'Terjadi kesalahan saat memperbarui stok: ' . mysqli_error($conn);
    }
} else {
    echo 'Terjadi kesalahan saat memasukkan data atau update data: ' . mysqli_error($conn);  // Menambahkan pesan error untuk debugging
}
?>
