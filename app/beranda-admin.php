<?php
$awal = date('Y-m-d');
$akhir = date('Y-m-d');
$no = 1;
$data = array();

// Variabel untuk menghitung total
$grand_penjualan = 0;
$grand_pembelian = 0;
$grand_pengeluaran = 0;
$grand_keuntungan = 0;

while (strtotime($awal) <= strtotime($akhir)) {
    $tanggal = $awal;
    $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

    // Ambil data penjualan, pembelian, pengeluaran, dan keuntungan untuk tanggal tersebut
    $query = "
        SELECT 
            (SELECT SUM(nmnl_ptt) FROM penjualan_tdk_tercatat WHERE tgl_ptt = '$tanggal') AS total_penjualan_tdk_tercatat,
            (SELECT SUM(byr_jl) FROM penjualan WHERE tgl_jl = '$tanggal') AS total_penjualan,
            (SELECT SUM(byr_bl) FROM pembelian WHERE tgl_bl = '$tanggal') AS total_pembelian,
            (SELECT SUM(nmnl_lr) FROM pengeluaran WHERE tgl_lr = '$tanggal') AS total_pengeluaran,
            (SELECT SUM(keuntungan) FROM penjualan_detail WHERE tgl_jl = '$tanggal') AS total_keuntungan
    ";
    
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $total_penjualan = $row['total_penjualan'] + $row['total_penjualan_tdk_tercatat'];
        $grand_penjualan += $total_penjualan;
        $grand_pembelian += $row['total_pembelian'];
        $grand_pengeluaran += $row['total_pengeluaran'];
        $grand_keuntungan += $row['total_keuntungan'];
    }
}
?>

<div class="container-fluid">
   <h4 class="text-primary m-0 fw-bold">
      Penjualan Hari Ini : <?= date('Y-m-d'); ?>
   </h4>
   <br>

   <div class="row mb-2">
      <?php
      $cards = [
         ['label' => 'Penjualan', 'value' => $grand_penjualan, 'color' => 'primary', 'icon' => 'penjualan.svg'],
         ['label' => 'Pembelian', 'value' => $grand_pembelian, 'color' => 'warning', 'icon' => 'pembelian.svg'],
         ['label' => 'Pengeluaran', 'value' => $grand_pengeluaran, 'color' => 'danger', 'icon' => 'pengeluaran.svg'],
         ['label' => 'Pendapatan', 'value' => $grand_keuntungan, 'color' => 'success', 'icon' => 'pendapatan.svg']
      ];

      foreach ($cards as $card) {
         echo "
         <div class='col-md-3 col-12 mb-2'>
            <div class='card border-0 shadow p-3'>
               <div class='d-flex align-item-center justify-content-between'>
                  <div class='align-self-center'>
                     <strong class=''>Rp. " . rupiah($card['value']) . "</strong>
                     <h4 class='text-{$card['color']} m-0 fw-bold'>{$card['label']}</h4>
                  </div>
                  <img class='img-fluid' alt='Responsive image' src='asset/img/{$card['icon']}' width='75'>
               </div>
            </div>
         </div>";
      }
      ?>
   </div>
   
   <br>

   <h4 class="text-primary m-0 fw-bold">Grafik Bulanan</h4>
   <br>

   <div class="row">
      <?php
      $charts = [
         ['id' => 'chart_penjualan', 'title' => 'Grafik Penjualan', 'color' => 'primary'],
         ['id' => 'chart_keuntungan', 'title' => 'Grafik Pendapatan', 'color' => 'success'],
         ['id' => 'chart_pembelian', 'title' => 'Grafik Pembelian', 'color' => 'warning'],
         ['id' => 'chart_pengeluaran', 'title' => 'Grafik Pengeluaran', 'color' => 'danger']
      ];

      foreach ($charts as $chart) {
         echo "
         <div class='col-md-6 col-12 mb-2'>
            <div class='card border border-{$chart['color']} shadow mb-4'>
               <div class='card-header bg-{$chart['color']} text-white'>
                  <h6 class='m-0 font-weight-bold'>{$chart['title']}</h6>
               </div>
               <div class='card-body'>
                  <div class='chart-area'>
                     <canvas id='{$chart['id']}'></canvas>
                  </div>
               </div>
            </div>
         </div>";
      }
      ?>
   </div>
</div>
