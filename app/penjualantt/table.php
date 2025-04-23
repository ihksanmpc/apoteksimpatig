<?php
include("../../library.php");

// Tambahkan query JOIN untuk mendapatkan nama pengguna dari tabel user
$query   = "SELECT p.*, u.nama_usr FROM penjualan_tdk_tercatat p
            LEFT JOIN user u ON p.user_id = u.id_usr
            ORDER BY p.wkt_ptt DESC";
$sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data    = array();
$no      = 1;

while ($list = mysqli_fetch_array($sql)) {
   $row    = array();

   $row[]  = '<p class="text-center my-0">' . $no++ . '</p>';
   $row[]  = '<p class="text-center my-0">' . tanggal($list['tgl_ptt'])  . '</p>';
   $row[]  = '<p class="text-center my-0">' . $list['nama_usr'] . '</p>'; 
   
   $row[]  = 'Rp. <span class="float-end">' . rupiah($list['nmnl_ptt']) . '</span>';
   $row[]  = '<p class="text-center my-0">' . $list['ket'] . '</p>'; // nama_user dari tabel user
   
   $row[]  = '
         <div class="text-center">
            <div class="btn-group btn-group-sm">
               <a href="?view=penjualantt-form&id=' . $list['id_ptt'] . '" class="btn btn-sm btn-warning text-white" onclick="ubahForm(' . $list['id_ptt'] . ')">
                  <i class="fa fa-edit"></i>
               </a>
               <a href="?view=penjualantt-delete&id=' . $list['id_ptt'] . '" class="btn btn-sm btn-danger" onclick="return confirm(`Apakah yakin ingin menghapus data ini?`)">
                  <i class="fa fa-trash"></i>
               </a>
            </div>
         </div>
   ';

   $data[] = $row;
}

$output = array("data" => $data);
echo json_encode($output);
