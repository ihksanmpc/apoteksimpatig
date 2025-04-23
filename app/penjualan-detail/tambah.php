<?php
$id_jual  = intval($_GET['id']);
$status   = $_GET['status'];
$id_prd   = intval($_POST['id_produk']);
$jml_jdet = intval($_POST['jml_jdet']);
$tanggal  = date('Y-m-d');
$user     = $_SESSION['id_user'];
$url      = 'home.php?view=penjualan-detail&status=' . urlencode($status) . '&id=' . $id_jual;

// Cek apakah produk sudah ditambahkan ke detail penjualan
$query = "SELECT * FROM penjualan_detail WHERE jual_id = $id_jual AND prd_id = $id_prd";
$sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
$cek   = mysqli_num_rows($sql);

if ($cek >= 1) {
    echo alert('Barang/Produk telah ditambahkan!', $url);
} else {
    // Ambil data produk
    $qProduk = "SELECT * FROM produk WHERE id_prd = $id_prd LIMIT 1";
    $eProduk = mysqli_query($conn, $qProduk) or die(mysqli_error($conn));
    $dProduk = mysqli_fetch_assoc($eProduk);

    $stok_awal = intval($dProduk['stok_prd']);
    $nama_prd  = mysqli_real_escape_string($conn, $dProduk['nama_prd']);

    if ($stok_awal < $jml_jdet) {
        echo alert('Stok Barang/Produk tidak mencukupi jumlah pembelian', $url);
    } else {
        $harga_beli = floatval($dProduk['beli_prd']);
        $harga_jual = floatval($dProduk['jual_prd']);
        $keuntungan = ($harga_jual - $harga_beli) * $jml_jdet;

        // Insert ke penjualan_detail
        $query2 = "INSERT INTO penjualan_detail 
                    (jual_id, prd_id, jml_jdet, tgl_jl, keuntungan)
                   VALUES 
                    ($id_jual, $id_prd, $jml_jdet, '$tanggal', $keuntungan)";
        mysqli_query($conn, $query2) or die(mysqli_error($conn));

        // Insert ke kartu_stok sebagai stok keluar (karena penjualan)
        $query3 = "INSERT INTO kartu_stok 
                    (id_prd, tanggal, kode, keterangan, masuk, keluar, stok_awal, id_usr)
                   VALUES 
                    ($id_prd, '$tanggal', '$id_jual', 'Penjualan', 0, $jml_jdet, $stok_awal, $user)";
        mysqli_query($conn, $query3) or die(mysqli_error($conn));

        // Update stok produk
        $new_stok = $stok_awal - $jml_jdet;
        $updateStok = "UPDATE produk SET stok_prd = $new_stok WHERE id_prd = $id_prd";
        mysqli_query($conn, $updateStok) or die(mysqli_error($conn));

        echo redirect($url);
    }
}
?>
