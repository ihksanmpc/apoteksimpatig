<li class="nav-item">
    <a class="nav-link me-3 <?php if ($view == "operator") echo 'bg-primary text-white rounded'; ?>" href="?view=operator">
        <i class="fa fa-home"></i> Beranda
    </a>
</li>
<li class="nav-item">
    <a class="nav-link me-3 <?php if ($view == "produk") echo 'bg-primary text-white rounded'; ?>" href="?view=produk">
        <i class="fa fa-cubes"></i> Produk
    </a>
</li>

<li class="nav-item me-3 d-lg-block w-80">
       <a class="nav-link me-3 <?php if ($view == "penjualan" or $view == "penjualan-detail" or $view == "penjualan-lihat") echo 'bg-primary text-white rounded'; ?>" href="?view=penjualan">
        <i class="fa fa-shopping-cart"></i> Transaksi Penjualan
    </a>
</li>
<li class="nav-item me-3 d-lg-block w-80">
    <a class="nav-link me-3 <?= ($view == 'penjualantt' or $view == 'penjualantt-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=penjualantt">
     Penjualan Tidak Tercatat
    </a>
</li>
<li class="nav-item me-3 d-lg-block w-60">
       <a class="nav-link me-3 <?= ($view == 'pengeluaran' or $view == 'pengeluaran-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=pengeluaran">
    Pengeluaran
    </a>
</li>
<li class="nav-item me-3 d-lg-block w-60">
    <a class="nav-link <?= ($view == 'laporan_harian') ? 'bg-primary text-white rounded' : '' ?>" href="?view=laporan_harian">Laporan</a>
</li>