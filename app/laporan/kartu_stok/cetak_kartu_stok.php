<?php
require('../../../fpdf/fpdf.php');
include("../../../library.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$tglAwal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tglAkhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';

if (!$id || !$tglAwal || !$tglAkhir) {
    die("Parameter tidak lengkap.");
}

if (!$conn) {
    die("Koneksi database gagal.");
}

// Ambil data produk
$produkQuery = mysqli_query($conn, "SELECT * FROM produk WHERE id_prd = '$id'");
$produk = mysqli_fetch_assoc($produkQuery);
$namaProduk = $produk ? $produk['nama_prd'] : 'Tidak ditemukan';
$edProduk = $produk && $produk['tgl_ed'] ? date('d-m-Y', strtotime($produk['tgl_ed'])) : '-';

// Hitung stok awal berdasarkan akumulasi sebelum tanggal awal
$stokAwalQuery = mysqli_query($conn, "
    SELECT 
        COALESCE(SUM(masuk), 0) AS total_masuk,
        COALESCE(SUM(keluar), 0) AS total_keluar,
        (
            SELECT stok_awal 
            FROM kartu_stok 
            WHERE id_prd = '$id' 
              AND tanggal < '$tglAwal'
            ORDER BY tanggal ASC, id ASC 
            LIMIT 1
        ) AS stok_awal_pertama
    FROM kartu_stok 
    WHERE id_prd = '$id' 
      AND tanggal < '$tglAwal'
");

$stokAwal = 0;
if ($stokAwalQuery && mysqli_num_rows($stokAwalQuery) > 0) {
    $data = mysqli_fetch_assoc($stokAwalQuery);
    $stok_awal_pertama = $data['stok_awal_pertama'] ?? 0;
    $stokAwal = $stok_awal_pertama + $data['total_masuk'] - $data['total_keluar'];
}

// Ambil data kartu stok selama periode
$stokQuery = mysqli_query($conn, "
    SELECT ks.*, u.nama_usr 
    FROM kartu_stok ks
    LEFT JOIN user u ON ks.id_usr = u.id_usr
    WHERE ks.id_prd = '$id' 
      AND ks.tanggal BETWEEN '$tglAwal' AND '$tglAkhir' 
    ORDER BY ks.tanggal ASC
");

// Buat PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Kartu Stok', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nama Produk: ' . $namaProduk, 0, 1);
$pdf->Cell(0, 10, 'Stok Awal: ' . $stokAwal, 0, 1);
$pdf->Cell(0, 10, 'Periode: ' . date('d-m-Y', strtotime($tglAwal)) . ' s/d ' . date('d-m-Y', strtotime($tglAkhir)), 0, 1);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);

// Header tabel
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(22, 8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(25, 8, 'No Bukti', 1, 0, 'C');
$pdf->Cell(45, 8, 'Keterangan', 1, 0, 'C');
$pdf->Cell(15, 8, 'Masuk', 1, 0, 'C');
$pdf->Cell(15, 8, 'Keluar', 1, 0, 'C');
$pdf->Cell(15, 8, 'Sisa', 1, 0, 'C');
$pdf->Cell(25, 8, 'Tanggal Exp', 1, 0, 'C');
$pdf->Cell(28, 8, 'Petugas', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$no = 1;
$sisa = $stokAwal;

while ($row = mysqli_fetch_assoc($stokQuery)) {
    $sisa = $sisa + (int)$row['masuk'] - (int)$row['keluar'];

    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(22, 8, date('d-m-Y', strtotime($row['tanggal'])), 1, 0);
    $pdf->Cell(25, 8, $row['kode'], 1, 0);
    $pdf->Cell(45, 8, $row['keterangan'], 1, 0);
    $pdf->Cell(15, 8, $row['masuk'], 1, 0, 'C');
    $pdf->Cell(15, 8, $row['keluar'], 1, 0, 'C');
    $pdf->Cell(15, 8, $sisa, 1, 0, 'R');
    $pdf->Cell(25, 8, $edProduk, 1, 0, 'C');
    $pdf->Cell(28, 8, $row['nama_usr'], 1, 1);
}

// Total
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(102, 8, 'Total', 1, 0, 'C');
$pdf->Cell(15, 8, '-', 1, 0);
$pdf->Cell(15, 8, '-', 1, 0);
$pdf->Cell(15, 8, $sisa, 1, 0, 'R');
$pdf->Cell(25, 8, '-', 1, 0);
$pdf->Cell(28, 8, '-', 1, 1);

$pdf->Ln(15);

// Tanda tangan
$pdf->SetFont('Arial', '', 10);
$tanggalCetak = date('d-m-Y');

$pdf->Cell(95, 6, 'Petugas', 0, 0, 'C');
$pdf->Cell(95, 6, 'Kepala Apotek', 0, 1, 'C');
$pdf->Ln(20);
$pdf->Cell(95, 6, '(___________________)', 0, 0, 'C');
$pdf->Cell(95, 6, '(___________________)', 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 6, "Dicetak pada: $tanggalCetak", 0, 0, 'R');

$pdf->Output('I', 'kartu_stok.pdf');
?>
