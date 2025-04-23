<?php $ajaxDataTable = './app/penjualan/table.php'; ?>

<?php
$awal              = date('Y-m-d');
$akhir             = date('Y-m-d');
$no                = 1;
$data              = array();


$penjualan_tdk_tercatat        = 0;
$total_penjualan_tdk_tercatat  = 0;
$grand_penjualan   = 0;

while (strtotime($awal) <= strtotime($akhir)) {
   // ambil data tanggal
   $tanggal = $awal;
   $awal    = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

    // jumlah total penjualan
   $query_jl = "SELECT SUM(byr_jl) AS total_penjualan FROM penjualan WHERE tgl_jl LIKE '$tanggal'";
   $sql_jl = mysqli_query($conn, $query_jl) or die(mysqli_error($conn));
   $data_jl = mysqli_fetch_assoc($sql_jl);
   $total_penjualan = $data_jl['total_penjualan'] ;
   $grand_penjualan += $total_penjualan;

// jumlah total penjualan tdk tercatat
                    $query_jl = "SELECT SUM(nmnl_ptt) AS total_penjualan_tdk_tercatat FROM penjualan_tdk_tercatat WHERE tgl_ptt LIKE '$tanggal'";
                    $sql_jl = mysqli_query($conn, $query_jl) or die(mysqli_error($conn));
                    $data_jl = mysqli_fetch_assoc($sql_jl);
                    $total_penjualan_tdk_tercatat = $data_jl['total_penjualan_tdk_tercatat'];
                    $grand_penjualan_tdk_tercatat += $total_penjualan_tdk_tercatat;
   $total_penjualan_all = $total_penjualan + $total_penjualan_tdk_tercatat;
   }

?>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12 d-flex align-items-center justify-content-between">
            <h4 class="fw-bold">Total Penjualan Hari Ini : <strong class="">Rp. <?= rupiah($total_penjualan_all) ?></strong> </h4>  
           

                <a href="?view=penjualan-baru"  class="btn btn-primary">
                    <i class="fa fa-plus"></i> Penjualan Baru
                </a>
           
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2 table-responsive">
                <table class="table table-striped dataTable align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center" width="5%">No. </th>
                            <th class="text-center" width="10%">Tanggal</th>
                            <th class="text-center" width="15%">Petugas</th>
                            <th class="text-center" width="10%">Customer</th>
                            <th class="text-center" width="5%">Item</th>
                            
                            <th class="text-center" width="10%">Disk</th>
                            <th class="text-center" width="15%">Grand Total</th>
                           <th class="text-center" width="15%">Pembayaran</th>
                                <th class="text-center" width="10%">Aksi</th>
                            
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>