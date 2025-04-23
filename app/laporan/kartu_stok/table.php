<?php
include("../../../library.php");

$tgl_awal = $_GET['awal'] ?? '';
$tgl_akhir = $_GET['akhir'] ?? '';

$query = "SELECT * FROM produk 
          JOIN satuan ON produk.stn_id = satuan.id_stn 
          ORDER BY wkt_prd DESC";
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

$data = [];
$no = 1;

while ($list = mysqli_fetch_assoc($sql)) {
    $row = [];
    $row[] = '<div class="text-center">' . $no++ . '</div>';
    $row[] = '<div class="text-start">' . htmlspecialchars($list['nama_prd']) . '</div>';
    $row[] = '<div class="text-start">' . htmlspecialchars($list['nama_stn']) . '</div>';
    $row[] = '<div class="text-center">' . number_format($list['stok_prd']) . '</div>';

    // Mengirimkan tanggal ke halaman cetak langsung dari tabel
    $row[] = '
        <div class="btn-group btn-group-sm">
            <a href="../../../app/laporan/kartu_stok/cetak_kartu_stok.php?id=' . $list['id_prd'] . '&tgl_awal=' . urlencode($tgl_awal) . '&tgl_akhir=' . urlencode($tgl_akhir) . '" 
               class="btn btn-sm btn-warning text-white" 
               target="_blank">
                <i class="fa fa-print"></i>
            </a>
        </div>
    ';

    $data[] = $row;
}

$output = ["data" => $data];
echo json_encode($output);
