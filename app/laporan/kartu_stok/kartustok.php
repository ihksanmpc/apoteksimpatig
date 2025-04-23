<?php
include("../../../library.php");

$tgl_awal_default = date('Y-m-01');
$tgl_akhir_default = date('Y-m-d');
?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Data Laporan Kartu Stok</h3>
        </div>
    </div>

    <!-- FORM FILTER TANPA SUBMIT -->
    <div class="row row-cols-lg-auto g-3 align-items-center mb-3 mt-2">
        <div class="col-12">
            <div class="input-group">
                <div class="input-group-text">Mulai</div>
                <input type="date" class="form-control" id="tgl_awal" value="<?= $tgl_awal_default ?>">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group">
                <div class="input-group-text">Sampai</div>
                <input type="date" class="form-control" id="tgl_akhir" value="<?= $tgl_akhir_default ?>">
            </div>
        </div>
    </div>

    <!-- TABEL -->
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2 table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-start" width="5%">No.</th>
                            <th class="text-start" width="45%">Nama produk</th>
                            <th class="text-start" width="15%">Satuan</th>
                            <th class="text-center" width="8%">Stok</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM produk 
                                  JOIN satuan ON produk.stn_id = satuan.id_stn 
                                  ORDER BY wkt_prd DESC";
                        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
                        $no = 1;

                        while ($list = mysqli_fetch_assoc($sql)) {
                            echo '<tr>';
                            echo '<td class="text-center">' . $no++ . '</td>';
                            echo '<td class="text-start">' . htmlspecialchars($list['nama_prd']) . '</td>';
                            echo '<td class="text-start">' . htmlspecialchars($list['nama_stn']) . '</td>';
                            echo '<td class="text-center">' . number_format($list['stok_prd']) . '</td>';
                            echo '<td class="text-center">
                                <a href="#" 
                                   class="btn btn-sm btn-warning text-white cetak-btn" 
                                   data-id="' . $list['id_prd'] . '">
                                    <i class="fa fa-print"></i>
                                </a>
                            </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JS UNTUK TANGANI CETAK -->
<script>
    document.querySelectorAll('.cetak-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const awal = document.getElementById('tgl_awal').value;
            const akhir = document.getElementById('tgl_akhir').value;

            // Validasi sederhana
            if (!awal || !akhir) {
                alert("Silakan pilih tanggal mulai dan sampai terlebih dahulu.");
                return;
            }

            const url = `../../../app/laporan/kartu_stok/cetak_kartu_stok.php?id=${id}&tgl_awal=${encodeURIComponent(awal)}&tgl_akhir=${encodeURIComponent(akhir)}`;
            window.open(url, '_blank');
        });
    });
</script>
