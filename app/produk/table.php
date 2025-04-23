<?php
include("../../library.php");

$query   = "SELECT * FROM produk JOIN satuan on produk.stn_id=satuan.id_stn ORDER BY wkt_prd DESC";
$sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data    = array();
$no      = 1;

while ($list = mysqli_fetch_array($sql)) {
   $row    = array();

   $row[]  = '<span class="text-center">' . $no++ . '</span>';
   $row[]  = '<span class="text-start">' . $list['nama_prd'] . '</span> <br> 
               <small style="font-size:11px">' . tanggal($list['tgl_ed']) . '</small>';
   $row[]  = '<span class="text-start">' . $list['nama_stn'] . '</span>';
   
   
   $row[]  = 'Rp. <span class="float-end">' . rupiah($list['jual_prd']) . '</span>';

   if ($list['stok_prd'] <= 10) {
      $row[]  = '<span class="float-end fw-bold text-danger">' . number_format($list['stok_prd']) . '</span>';
   } else {
      $row[]  = '<span class="float-end">' . number_format($list['stok_prd']) . '</span>';
   }
$row[]  = 'Rp. <span class="float-end">' . rupiah($list['beli_prd']) . '</span>';
   $row[]  = '
            <div class="text-center">
               <div class="btn-group btn-group-sm">
                  <a href="?view=produk-form&id=' . $list['id_prd'] . '" class="btn btn-sm btn-warning text-white" onclick="ubahForm(' . $list['id_prd'] . ')">
                     <i class="fa fa-edit"></i>
                  </a>
                  <a href="?view=produk-delete&id=' . $list['id_prd'] . '" class="btn btn-sm btn-danger" onclick="return confirm(`Apakah yakin ingin menghapus data ini?`)">
                     <i class="fa fa-trash"></i>
              
                   <a href="?view=stokopname-input&id=' . $list['id_prd'] . '" class="btn btn-sm btn-primary text-white" onclick="ubahForm(' . $list['id_prd'] . ')">
                     <i class="fa fa-search-minus"></i>
                  </a>
               </div>
            </div>
      ';

   $data[] = $row;
}

$output = array("data" => $data);
echo json_encode($output);
