<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Data Laporan Per Bulan</h3>
        </div>
    </div>
    <form class="row row-cols-lg-auto g-3 align-items-center mb-3 mt-2" method="POST" action="">
        <div class="col-12">
            <div class="input-group">
                <div class="input-group-text">Mulai</div>
                <input type="date" class="form-control" name="awal" value="<?= $_POST['awal'] ?: '' ?>" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group">
                <div class="input-group-text">Sampai</div>
                <input type="date" class="form-control" name="akhir" value="<?= $_POST['akhir'] ?: '' ?>" required>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" name="filter" class="btn btn-primary">Filter</button>
            <a href="?view=laporan" class="btn btn-warning">Reset</a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered" width="100%" cellspacing="0">
            <thead class="bg-white text-dark">
                <tr class="text-center py-3">
                    <th class="py-3">Tanggal</th>
                    <th class="py-3"><span class="text-primary">Penjualan</span></th>
                    <th class="py-3"><span class="text-success">Pendapatan</span></th>
                    <th class="py-3"><span class="text-warning">Pembelian</span></th>
                    <th class="py-3"><span class="text-danger">Pengeluaran</span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $awal = isset($_POST['awal']) ? $_POST['awal'] : date('Y-m-01');
                $akhir = isset($_POST['akhir']) ? $_POST['akhir'] : date('Y-m-d');

                $grand_penjualan = $grand_penjualan_tdk_tercatat = $grand_pembelian = $grand_pengeluaran = $grand_keuntungan = 0;

                while (strtotime($awal) <= strtotime($akhir)) :
                    $tanggal = $awal;
                    $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

                    // Mengambil data penjualan (tercatat + tidak tercatat)
                    $total_penjualan_tdk_tercatat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nmnl_ptt) AS total_penjualan_tdk_tercatat FROM penjualan_tdk_tercatat WHERE tgl_ptt = '$tanggal'"))['total_penjualan_tdk_tercatat'];
                    $total_penjualan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(byr_jl) AS total_penjualan FROM penjualan WHERE tgl_jl = '$tanggal'"))['total_penjualan'] + $total_penjualan_tdk_tercatat;
                    $grand_penjualan += $total_penjualan;

                    // Mengambil data pembelian
                    $total_pembelian = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(byr_bl) AS total_pembelian FROM pembelian WHERE tgl_bl = '$tanggal'"))['total_pembelian'];
                    $grand_pembelian += $total_pembelian;

                    // Mengambil data pengeluaran
                    $total_pengeluaran = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nmnl_lr) AS total_pengeluaran FROM pengeluaran WHERE tgl_lr = '$tanggal'"))['total_pengeluaran'];
                    $grand_pengeluaran += $total_pengeluaran;

                    // Mengambil data keuntungan
                    $total_keuntungan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(keuntungan) AS total_keuntungan FROM penjualan_detail WHERE tgl_jl = '$tanggal'"))['total_keuntungan'];
                    $grand_keuntungan += $total_keuntungan;
                ?>
                    <tr>
                        <td class="text-center"><?= tanggal($tanggal) ?></td>
                        <td class="text-primary">Rp. <span class="float-end"><?= rupiah($total_penjualan) ?></span></td>
                        <td class="text-success">Rp. <span class="float-end"><?= rupiah($total_keuntungan) ?></span></td>
                        <td class="text-warning">Rp. <span class="float-end"><?= rupiah($total_pembelian) ?></span></td>
                        <td class="text-danger">Rp. <span class="float-end"><?= rupiah($total_pengeluaran) ?></span></td>
                    </tr>
                <?php endwhile; ?>
                <tr class="bg-white text-dark">
                    <td class="text-center py-3"><strong>Grand Total</strong></td>
                    <td class="text-primary py-3"><strong>Rp. <span class="float-end"><?= rupiah($grand_penjualan) ?></span></strong></td>
                    <td class="text-success py-3"><strong>Rp. <span class="float-end"><?= rupiah($grand_keuntungan) ?></span></strong></td>
                    <td class="text-warning py-3"><strong>Rp. <span class="float-end"><?= rupiah($grand_pembelian) ?></span></strong></td>
                    <td class="text-danger py-3"><strong>Rp. <span class="float-end"><?= rupiah($grand_pengeluaran) ?></span></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
