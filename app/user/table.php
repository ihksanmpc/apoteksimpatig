<?php
include("../../library.php");

$query   = "SELECT * FROM user ORDER BY wkt_usr DESC";
$sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data    = array();
$no      = 1;

while ($list = mysqli_fetch_array($sql)) {
   $row    = array();

   $row[]  = '<p class="text-center my-0">' . $no++ . '</p>';
   $row[]  = '<p class="text-center my-0">' . $list['nama_usr'] . '</p>';
   $row[]  = '<p class="text-center my-0">' . $list['user_usr'] . '</p>';
   if ($list['lvl_usr'] == 1) {
      $row[]  = '<p class="my-0 text-center text-primary">Administrator</p>';
   }

   if ($list['lvl_usr'] == 2) {
      $row[]  = '<p class="my-0 text-center text-secondary">Operator</p>';
   }
   $row[]  = '
         <div class="text-center">
            <div class="btn-group btn-group-sm">
               <a href="?view=user-form&id=' . $list['id_usr'] . '" class="btn btn-sm btn-warning text-white" onclick="ubahForm(' . $list['id_usr'] . ')">
                  <i class="fa fa-edit"></i>
               </a>
               <a href="?view=user-delete&id=' . $list['id_usr'] . '" class="btn btn-sm btn-danger" onclick="return confirm(`Apakah yakin ingin menghapus data ini?`)">
                  <i class="fa fa-trash"></i>
               </a>
            </div>
         </div>
   ';

   $data[] = $row;
}

$output = array("data" => $data);
echo json_encode($output);
