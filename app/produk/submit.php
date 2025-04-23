
<?php

$id_prd   = rand(1111, 9999);
$nama_prd = strtoupper($_POST['nama_prd']);
$stn_id   = $_POST['stn_id'];
$beli_prd = $_POST['beli_prd'];
$prd_ppn = $_POST['prd_ppn'];
$jual_prd = $_POST['jual_prd'];
$stok_prd = $_POST['stok_prd'];
$wkt_prd  = date('Y-m-d H:i:s');
$tgl_ed   = $_POST['tgl_ed'];


if (isset($_GET['id'])) {
    $id_prd = $_GET['id'];

    $query   = "UPDATE produk SET 
                    nama_prd = '$nama_prd',
                    stn_id   = '$stn_id',
                    beli_prd = '$beli_prd',
                    jual_prd = '$jual_prd',
                    stok_prd = '$stok_prd',
                    tgl_ed   = '$tgl_ed'
                WHERE id_prd = '$id_prd'";
} else {
    $query   = "INSERT INTO produk SET 
                    id_prd   = '$id_prd',
                    nama_prd = '$nama_prd',
                    stn_id   = '$stn_id',
                    beli_prd = '$beli_prd',
                    jual_prd = '$jual_prd',
                    stok_prd = '$stok_prd',
                    tgl_ed   = '$tgl_ed',
                    wkt_prd  = '$wkt_prd'
                ";
}

$exeSQL = mysqli_query($conn, $query) or die(mysqli_error($conn));

if ($exeSQL) {
    if (isset($_GET['id'])) {
        echo alert('Data produk Anda berhasil di UBAH', 'home.php?view=produk');
    } else {
        echo alert('Data produk Anda berhasil di TAMBAHKAN', 'home.php?view=produk');
    }
}
