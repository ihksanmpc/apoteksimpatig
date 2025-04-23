<?php
include("../../library.php");

// Tambahkan query JOIN untuk mendapatkan nama pengguna dari tabel user
$query   = "SELECT p.*, u.nama_usr FROM penjualan p
            LEFT JOIN user u ON p.user_id = u.id_usr
            ORDER BY p.wkt_jl DESC";
$sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data    = array();
$no      = 1;

while ($list = mysqli_fetch_array($sql)) {
   $row    = array();

   // Menampilkan nomor urut
   $row[]  = '<p class="text-center my-0">' . $no++ . '</p>';
   
   // Menampilkan tanggal penjualan
   $row[]  = '<p class="text-center my-0">' . tanggal($list['tgl_jl']) . '</p>';
   
   // Menampilkan nama pengguna yang diambil dari tabel user
   $row[]  = '<p class="text-center my-0">' . $list['nama_usr'] . '</p>'; // nama_user dari tabel user
   
   // Menampilkan nama customer
   $row[]  = '<p class="text-center my-0">' . $list['nama_customer'] . '</p>';
   
   // Menampilkan item yang dijual
   $row[]  = '<p class="text-center my-0">' . $list['item_jl'] . '</p>';
   
 
   // Menampilkan diskon
   $row[]  = 'Rp. <span class="float-end">' . rupiah($list['disk_jl']) . '</span>';  
   
   // Menampilkan jumlah yang dibayar
   $row[]  = 'Rp. <span class="float-end">' . rupiah($list['byr_jl']) . '</span>';
   
   // Menampilkan metode pembayaran
   $row[]  = '<p class="text-center my-0">' . $list['pembayaran'] . '</p>';
   
   // Menampilkan tombol aksi
   $row[]  = '
         <div class="text-center">
            <div class="btn-group btn-group-sm">
               <a class="btn btn-sm btn-warning" href="?view=penjualan-detail&status=ubah&id=' . $list['id_jl'] . '">
                  <i class="fa fa-eye"></i>
               </a>
               <a onclick="return confirm(`Apakah yakin ingin menghapus data ini?`)"href="?view=penjualan-hapus&id=' . $list['id_jl'] . '" class="btn btn-sm btn-danger">
                  <i class="fa fa-trash"></i>
               </a>
               <a class="btn btn-sm btn-primary" href="?view=print&id=' . $list['id_jl'] . '">
                  <i class="fa fa-print"></i>
               </a>
            </div>
         </div>
   ';

   $data[] = $row;
}

$output = array("data" => $data);
echo json_encode($output);
