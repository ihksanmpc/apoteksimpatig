<?php
include("../../library.php");

$query   = "SELECT * FROM satuan ORDER BY wkt_stn DESC";
$sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data    = array();
$no      = 1;

while ($list = mysqli_fetch_array($sql)) {
   $row    = array();

   $row[]  = '<p class="text-center">' . $no++ . '</p>';
   $row[]  = '<p class="text-center">' . $list['nama_stn'] . '</p>';;
   $row[]  = '
         <div class="text-center">
            <div class="btn-group btn-group-sm">
               <a href="?view=satuan-form&id=' . $list['id_stn'] . '" class="btn btn-sm btn-warning text-white" onclick="ubahForm(' . $list['id_stn'] . ')">
                  <i class="fa fa-edit"></i> Ubah
               </a>
               <a href="?view=satuan-delete&id=' . $list['id_stn'] . '" class="btn btn-sm btn-danger" onclick="return confirm(`Apakah yakin ingin menghapus data ini?`)">
                  <i class="fa fa-trash"></i> Hapus
               </a>
            </div>
         </div>
   ';

   $data[] = $row;
}

$output = array("data" => $data);
echo json_encode($output);
