<?php
// untuk chart pada dashboard
$awal_chart      = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
$akhir_chart     = date('Y-m-d');
$tanggal_chart   = $awal_chart;
$data_tanggal    = array();
$data_penjualan  = array();
$data_pembelian  = array();
$data_pengeluaran = array();
$data_keuntungan = array();
$data_penjualan_all = array();
$data_penjualan_tdk_tercatat = array();

while (strtotime($tanggal_chart) <= strtotime($akhir_chart)) {
   $data_tanggal[]      = (int) substr($tanggal_chart, 8, 2);

   // untuk data penjualan
   $query_jl            = "SELECT SUM(byr_jl) AS total_penjualan FROM penjualan WHERE tgl_jl LIKE '$tanggal_chart'";
   $sql_jl              = mysqli_query($conn, $query_jl) or die(mysqli_error($conn));
   $data_jl             = mysqli_fetch_assoc($sql_jl);
   $penjualan           = $data_jl['total_penjualan'];
   $data_penjualan[]    = (int) $penjualan;

   // untuk data penjualan tidak tercatat
   $query_jl            = "SELECT SUM(nmnl_ptt) AS total_penjualan_tdk_tercatat FROM penjualan_tdk_tercatat WHERE tgl_ptt LIKE '$tanggal_chart'";
   $sql_jl              = mysqli_query($conn, $query_jl) or die(mysqli_error($conn));
   $data_jl             = mysqli_fetch_assoc($sql_jl);
   $penjualan_tdk_tercatat = $data_jl['total_penjualan_tdk_tercatat'];
   $data_penjualan_tdk_tercatat[] = (int) $penjualan_tdk_tercatat;

   // untuk data pembelian
   $query_bl            = "SELECT SUM(byr_bl) AS total_pembelian FROM pembelian WHERE tgl_bl LIKE '$tanggal_chart'";
   $sql_bl              = mysqli_query($conn, $query_bl) or die(mysqli_error($conn));
   $data_bl             = mysqli_fetch_assoc($sql_bl);
   $pembelian           = $data_bl['total_pembelian'];
   $data_pembelian[]    = (int) $pembelian;

   // untuk data pengeluaran
   $query_lr            = "SELECT SUM(nmnl_lr) AS total_pengeluaran FROM pengeluaran WHERE tgl_lr LIKE '$tanggal_chart'";
   $sql_lr              = mysqli_query($conn, $query_lr) or die(mysqli_error($conn));
   $data_lr             = mysqli_fetch_assoc($sql_lr);
   $pengeluaran         = $data_lr['total_pengeluaran'];
   $data_pengeluaran[]  = (int) $pengeluaran;

   $penjualan_all = $penjualan +  $penjualan_tdk_tercatat;
   $data_penjualan_all[] = (int) $penjualan_all;

   // untuk data keuntungan
   $query_un            = "SELECT SUM(keuntungan) AS total_keuntungan FROM penjualan_detail WHERE tgl_jl = '$tanggal_chart'";
   $sql_un              = mysqli_query($conn, $query_un) or die(mysqli_error($conn));
   $data_un             = mysqli_fetch_assoc($sql_un);
   $keuntungan          = $data_un['total_keuntungan'];
   $data_keuntungan[]   = (int) $keuntungan;

   $tanggal_chart       = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_chart)));
}
?>

<script src="./asset/js/Chart.min.js"></script>
<script>
   // Format angka
   function number_format(number, decimals, dec_point, thousands_sep) {
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
         prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
         sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
         dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
         s = '',
         toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
         };
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
         s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
         s[1] = s[1] || '';
         s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
   }

   // Grafik Penjualan
   var ctx = document.getElementById("chart_penjualan");
   var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
         labels: <?= json_encode($data_tanggal) ?>,
         datasets: [{
            label: "Total Penjualan",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: <?= json_encode($data_penjualan_all) ?>,
         }],
      },
      options: {
         maintainAspectRatio: false,
         layout: {
            padding: {
               left: 10,
               right: 25,
               top: 25,
               bottom: 0
            }
         },
         scales: {
            xAxes: [{
               time: {
                  unit: 'date'
               },
               gridLines: {
                  display: false,
                  drawBorder: false
               },
               ticks: {
                  maxTicksLimit: 7
               }
            }],
            yAxes: [{
               ticks: {
                  maxTicksLimit: 5,
                  padding: 10,
                  callback: function(value) {
                     return 'Rp. ' + number_format(value);
                  }
               },
               gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
               }
            }],
         },
         legend: {
            display: false
         },
         tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
               label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
               }
            }
         }
      }
   });

   // Grafik Pembelian
   var ctxPembelian = document.getElementById("chart_pembelian");
   var myPembelianChart = new Chart(ctxPembelian, {
      type: 'line',
      data: {
         labels: <?= json_encode($data_tanggal) ?>,
         datasets: [{
            label: "Total Pembelian",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "#ffc107",
            pointRadius: 3,
            pointBackgroundColor: "#ffc107",
            pointBorderColor: "#ffc107",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "#ffc107",
            pointHoverBorderColor: "#ffc107",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: <?= json_encode($data_pembelian) ?>,
         }],
      },
      options: {
         maintainAspectRatio: false,
         layout: {
            padding: {
               left: 10,
               right: 25,
               top: 25,
               bottom: 0
            }
         },
         scales: {
            xAxes: [{
               time: {
                  unit: 'date'
               },
               gridLines: {
                  display: false,
                  drawBorder: false
               },
               ticks: {
                  maxTicksLimit: 7
               }
            }],
            yAxes: [{
               ticks: {
                  maxTicksLimit: 5,
                  padding: 10,
                  callback: function(value) {
                     return 'Rp. ' + number_format(value);
                  }
               },
               gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
               }
            }],
         },
         legend: {
            display: false
         },
         tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
               label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
               }
            }
         }
      }
   });

   // Grafik Pengeluaran
   var ctxPengeluaran = document.getElementById("chart_pengeluaran");
   var myPengeluaranChart = new Chart(ctxPengeluaran, {
      type: 'line',
      data: {
         labels: <?= json_encode($data_tanggal) ?>,
         datasets: [{
            label: "Total Pengeluaran",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "#dc3545",
            pointRadius: 3,
            pointBackgroundColor: "#dc3545",
            pointBorderColor: "#dc3545",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "#dc3545",
            pointHoverBorderColor: "#dc3545",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: <?= json_encode($data_pengeluaran) ?>,
         }],
      },
      options: {
         maintainAspectRatio: false,
         layout: {
            padding: {
               left: 10,
               right: 25,
               top: 25,
               bottom: 0
            }
         },
         scales: {
            xAxes: [{
               time: {
                  unit: 'date'
               },
               gridLines: {
                  display: false,
                  drawBorder: false
               },
               ticks: {
                  maxTicksLimit: 7
               }
            }],
            yAxes: [{
               ticks: {
                  maxTicksLimit: 5,
                  padding: 10,
                  callback: function(value) {
                     return 'Rp. ' + number_format(value);
                  }
               },
               gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
               }
            }],
         },
         legend: {
            display: false
         },
         tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
               label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
               }
            }
         }
      }
   });

   // Grafik Keuntungan
   var ctxKeuntungan = document.getElementById("chart_keuntungan");
   var myKeuntunganChart = new Chart(ctxKeuntungan, {
      type: 'line',
      data: {
         labels: <?= json_encode($data_tanggal) ?>,
         datasets: [{
            label: "Total Keuntungan",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "#28a745",  // Warna hijau untuk keuntungan
            pointRadius: 3,
            pointBackgroundColor: "#28a745",
            pointBorderColor: "#28a745",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "#28a745",
            pointHoverBorderColor: "#28a745",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: <?= json_encode($data_keuntungan) ?>,
         }],
      },
      options: {
         maintainAspectRatio: false,
         layout: {
            padding: {
               left: 10,
               right: 25,
               top: 25,
               bottom: 0
            }
         },
         scales: {
            xAxes: [{
               time: {
                  unit: 'date'
               },
               gridLines: {
                  display: false,
                  drawBorder: false
               },
               ticks: {
                  maxTicksLimit: 7
               }
            }],
            yAxes: [{
               ticks: {
                  maxTicksLimit: 5,
                  padding: 10,
                  callback: function(value) {
                     return 'Rp. ' + number_format(value);
                  }
               },
               gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
               }
            }],
         },
         legend: {
            display: false
         },
         tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
               label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
               }
            }
         }
      }
   });
</script>
