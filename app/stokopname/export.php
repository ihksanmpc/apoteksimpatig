<?php
// Konfigurasi database
$host     = "localhost";
$user     = "apoteksi_apotek";
$pass     = "XxbTR7YUdfww2jHCPyvk";
$db       = "apoteksi_apotek";
$title    = "Apotek";

// Koneksi database
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// QUERY BUILDER
function query($conn, $query)
{
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    return $result;
}

// Load file autoload.php
require 'vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Pengaturan style untuk header tabel
$style_col = [
    'font' => ['bold' => true],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ]

];

// Pengaturan style untuk isi tabel
$style_row = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ]
];

// Mengambil tanggal mulai dari form (jika ada)
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';

// Set header untuk file Excel
if ($start_date) {
    $sheet->setCellValue('A1', "LAPORAN STOK OPNAME TANGGAL " . date('d-m-Y', strtotime($start_date)));
} else {
    $sheet->setCellValue('A1', "LAPORAN STOK OPNAME");
}

$sheet->mergeCells('A1:K1');
$sheet->getStyle('A1')->getFont()->setBold(true);
$sheet->getStyle('A1')->getFont()->setSize(15);
$sheet->getStyle('A3')->getFont()->setBold(true);
$sheet->getStyle('B3')->getFont()->setBold(true);
$sheet->getStyle('C3')->getFont()->setBold(true);
$sheet->getStyle('D3')->getFont()->setBold(true);
$sheet->getStyle('E3')->getFont()->setBold(true);
$sheet->getStyle('F3')->getFont()->setBold(true);
$sheet->getStyle('G3')->getFont()->setBold(true);
$sheet->getStyle('H3')->getFont()->setBold(true);
$sheet->getStyle('I3')->getFont()->setBold(true);
$sheet->getStyle('J3')->getFont()->setBold(true);
$sheet->getStyle('K3')->getFont()->setBold(true);

// Buat header tabel pada baris ke 3
$sheet->setCellValue('A3', "NO");
$sheet->setCellValue('B3', "ID Stok OP");
$sheet->setCellValue('C3', "ID Produk");
$sheet->setCellValue('D3', "Nama Produk");
$sheet->setCellValue('E3', "Harga Beli");
$sheet->setCellValue('F3', "Stok Komputer");
$sheet->setCellValue('G3', "Stok Nyata");
$sheet->setCellValue('H3', "Selisih Stok");
$sheet->setCellValue('I3', "Selisih Harga");
$sheet->setCellValue('J3', "Tanggal");
$sheet->setCellValue('K3', "Keterangan");

// Apply style header ke masing-masing kolom header
$sheet->getStyle('A3')->applyFromArray($style_col);

// Menyusun query berdasarkan tanggal yang dipilih
$query = "SELECT * FROM stokopname";

// Jika tanggal mulai dipilih, tambahkan filter pada query
if ($start_date) {
    $query .= " WHERE tgl_op = '$start_date'";
}

$result = query($conn, $query);

// Set variabel untuk nomor urut dan baris pertama data
$no = 1; 
$row = 4; // Baris pertama untuk data adalah baris ke 4

// Menulis data ke Excel
while ($data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $no);
    $sheet->setCellValue('B' . $row, $data['id_stokop']);
    $sheet->setCellValue('C' . $row, $data['id_prd']);
    $sheet->setCellValue('D' . $row, $data['nama_prd']);
    $sheet->setCellValue('E' . $row, $data['beli_prd']);
    $sheet->setCellValue('F' . $row, $data['stok_prd']);
    $sheet->setCellValue('G' . $row, $data['stokny']);
    $sheet->setCellValue('H' . $row, $data['selisi']);
    $sheet->setCellValue('I' . $row, $data['tselisi']);
    $sheet->setCellValue('J' . $row, $data['tgl_op']);
    $sheet->setCellValue('K' . $row, $data['ket']);

    // Apply style row untuk setiap baris data
    $sheet->getStyle('A' . $row)->applyFromArray($style_row);

    $no++; // Tambah 1 setiap kali looping
    $row++; // Tambah 1 setiap kali looping
}

// Set lebar kolom
// Set lebar kolom lainnya...

// Set orientasi kertas jadi LANDSCAPE
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$sheet->setTitle("Laporan Stok Opname");

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . ($start_date ? "Laporan Stok Opname Tanggal " . date('d-m-Y', strtotime($start_date)) : "Laporan Stok Opname") . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Menutup koneksi database
mysqli_close($conn);
?>
