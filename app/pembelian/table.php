<?php
include("../../library.php");

$query   = "SELECT * FROM pembelian LEFT JOIN supplier on pembelian.supp_id=supplier.id_supp ORDER BY id_bl DESC";
$sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data    = array();
$no      = 1;

while ($list = mysqli_fetch_array($sql)) {
   $row    = array();

   $row[]  = '<p class="text-center my-0">' . $no++ . '</p>';
   $row[]  = '<p class="text-center my-0">' . $list['nama_supp'] . '</p>';
   $row[]  = '<p class="text-center my-0">' . $list['faktur'] . '</p>';
   $row[]  = '<p class="text-center my-0">' . tanggal($list['jth_tempo']) . '</p>';
   $row[]  = '<p class="text-center my-0">' . number_format($list['item_bl']) . '</p>';
   $row[]  = 'Rp. <span class="float-end">' . rupiah($list['byr_bl']) . '</span>';
   $row[]  = '
         <div class="text-center">
            <div class="btn-group btn-group-sm">
               <a class="btn btn-sm btn-warning" href="?view=pembelian-detail&status=ubah&id=' . $list['id_bl'] . '">
                  <i class="fa fa-eye"></i>
               </a>
               <a onclick="return confirm(`Apakah yakin ingin menghapus data ini?`)"href="?view=pembelian-hapus&id=' . $list['id_bl'] . '" class="btn btn-sm btn-danger">
                  <i class="fa fa-trash"></i>
               </a>
            </div>
         </div>
   ';

   $data[] = $row;
}

$output = array("data" => $data);
echo json_encode($output);
