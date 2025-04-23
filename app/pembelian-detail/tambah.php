<?php
$id_beli  = $_GET['id'];
$status   = $_GET['status'];
$id_prd   = $_POST['id_produk'];
$jml_bdet = $_POST['jml_bdet'];
$tanggal  = date('Y-m-d');
$user     = $_SESSION['id_user'];
$url      = 'home.php?view=pembelian-detail&status=' . $status . '&id=' . $id_beli;

// Ambil data produk
$qProduk = "SELECT * FROM produk WHERE id_prd = $id_prd LIMIT 1";
$eProduk = mysqli_query($conn, $qProduk) or die(mysqli_error($conn));
$dProduk = mysqli_fetch_assoc($eProduk);
$nama_prd = mysqli_real_escape_string($conn, $dProduk['nama_prd']);
$stok_awal = mysqli_real_escape_string($conn, $dProduk['stok_prd']);

// Cek apakah produk sudah ada di pembelian_detail
$queryCek = "SELECT * FROM pembelian_detail WHERE beli_id = $id_beli AND prd_id = $id_prd";
$cek = mysqli_query($conn, $queryCek) or die(mysqli_error($conn));

if (mysqli_num_rows($cek) > 0) {
    // Jika sudah ada, update jumlah
    $qUpdate = "UPDATE pembelian_detail 
                SET jml_bdet = jml_bdet + $jml_bdet 
                WHERE beli_id = $id_beli AND prd_id = $id_prd";
    query($conn, $qUpdate);
} else {
    // Jika belum ada, insert baru
    $query2 = "INSERT INTO pembelian_detail 
                SET beli_id = $id_beli, prd_id = $id_prd, jml_bdet = $jml_bdet";
    query($conn, $query2);
}

// Tambah stok produk
$qStok = "UPDATE produk SET stok_prd = stok_prd + $jml_bdet WHERE id_prd = $id_prd";
query($conn, $qStok);

// Simpan ke kartu_stok
$query3 = "
    INSERT INTO kartu_stok (id_prd, tanggal, kode, keterangan, masuk, keluar, stok_awal, id_usr)
    VALUES (
        $id_prd,
        '$tanggal',
        '$id_beli',
        'Pembelian Dari',
        '$jml_bdet',
        0,
        '$stok_awal',
        '$user'
    )
";
$result3 = mysqli_query($conn, $query3);

if (!$result3) {
    die("Gagal input kartu_stok: " . mysqli_error($conn));
}

echo redirect($url);
?>
