<div class="container my-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold text-center">Data Laporan Harian</h3>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center" style="width: 100%;">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3 text-primary">Penjualan</th>
                    <th class="py-3 text-primary">Penjualan Tidak Tercatat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $awal = date('Y-m-d');
                $akhir = date('Y-m-d');

                if (isset($_POST['filter'])) {
                    $awal = $_POST['awal'];
                    $akhir = $_POST['akhir'];
                }

                $grand_penjualan = 0;
                $grand_penjualan_tdk_tercatat = 0;

                while (strtotime($awal) <= strtotime($akhir)) :
                    $tanggal = $awal;
                    $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

                    // Penjualan tercatat
                    $query_jl = "SELECT SUM(byr_jl) AS total_penjualan FROM penjualan WHERE tgl_jl LIKE '$tanggal'";
                    $sql_jl = mysqli_query($conn, $query_jl) or die(mysqli_error($conn));
                    $data_jl = mysqli_fetch_assoc($sql_jl);
                    $total_penjualan = $data_jl['total_penjualan'] ?? 0;
                    $grand_penjualan += $total_penjualan;

                    // Penjualan tidak tercatat
                    $query_jl = "SELECT SUM(nmnl_ptt) AS total_penjualan_tdk_tercatat FROM penjualan_tdk_tercatat WHERE tgl_ptt LIKE '$tanggal'";
                    $sql_jl = mysqli_query($conn, $query_jl) or die(mysqli_error($conn));
                    $data_jl = mysqli_fetch_assoc($sql_jl);
                    $total_penjualan_tdk_tercatat = $data_jl['total_penjualan_tdk_tercatat'] ?? 0;
                    $grand_penjualan_tdk_tercatat += $total_penjualan_tdk_tercatat;

                    $grand_all = $grand_penjualan + $grand_penjualan_tdk_tercatat;
                ?>
                    <tr>
                        <td><?= tanggal($tanggal) ?></td>
                        <td class="text-end text-primary">Rp. <?= rupiah($total_penjualan) ?></td>
                        <td class="text-end text-primary">Rp. <?= rupiah($total_penjualan_tdk_tercatat) ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr class="table-light">
                    <td class="fw-bold text-center py-3" colspan="2">Grand Total</td>
                    <td class="fw-bold text-end text-primary py-3">Rp. <?= rupiah($grand_all) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
