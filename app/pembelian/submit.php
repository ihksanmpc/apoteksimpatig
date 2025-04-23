<?php

// data untuk table pembelian
$id_bl     = $_POST['id_bl'];
$supplier  = $_POST['supplier'];
$faktur    = $_POST['faktur'];
$jth_tempo = $_POST['jth_tempo'];
$item      = $_POST['item'];
$total     = $_POST['total'];
$ppn     = $_POST['ppn'];
$user    = $_SESSION['id_user'];
$bayar     = $_POST['grandtotal'];
$tanggal = date('Y-m-d');


// cek apakah id_bl sudah ada di database
$query_check = "SELECT * FROM pembelian WHERE id_bl = '$id_bl'";
$result_check = mysqli_query($conn, $query_check);

// jika id_bl sudah ada, lakukan UPDATE
if (mysqli_num_rows($result_check) > 0) {
    $query = "UPDATE pembelian SET 
    tgl_bl        = '$tanggal',
                          supp_id  = '$supplier',
                          faktur   = '$faktur',
                          jth_tempo = '$jth_tempo',
                          item_bl  = '$item',
                          total_bl = '$total',
                          ppn = '$ppn',
                       user_id = '$user',
                          byr_bl   = '$bayar'
                  WHERE id_bl = '$id_bl'";
} else {
    // jika id_bl belum ada, lakukan INSERT
    $query = "INSERT INTO pembelian (id_bl, supp_id, faktur, tgl_bl, jth_tempo, item_bl, total_bl,ppn,user_id, byr_bl) 
              VALUES ('$id_bl', '$supplier', '$faktur', '$tanggal','$jth_tempo', '$item', '$total', '$ppn','$user', '$bayar')";
}

// eksekusi query
mysqli_query($conn, $query) or die(mysqli_error($conn));

echo redirect('home.php?view=pembelian');
?>
