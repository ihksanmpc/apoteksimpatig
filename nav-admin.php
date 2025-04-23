<ul class="navbar-nav d-flex flex-wrap">
    <!-- Menu utama -->
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'admin') ? 'bg-primary text-white rounded' : '' ?>" href="?view=admin">Beranda</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'satuan' || $view == 'satuan-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=satuan">Satuan</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'produk' || $view == 'produk-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=produk">Produk</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'supplier' || $view == 'supplier-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=supplier">Supplier</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'user' || $view == 'user-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=user">User</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'penjualan' || $view == 'penjualan-detail') ? 'bg-primary text-white rounded' : '' ?>" href="?view=penjualan">Penjualan</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'pembelian' || $view == 'pembelian-detail') ? 'bg-primary text-white rounded' : '' ?>" href="?view=pembelian">Pembelian</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'penjualantt' || $view == 'penjualantt-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=penjualantt">Penjualan Tidak Tercatat</a>
    </li>
    <li class="nav-item me-3">
        <a class="nav-link <?= ($view == 'pengeluaran' || $view == 'pengeluaran-form') ? 'bg-primary text-white rounded' : '' ?>" href="?view=pengeluaran">Pengeluaran</a>
    </li>

    <!-- Dropdown menu -->
    <li class="nav-item dropdown me-3">
        <a class="nav-link dropdown-toggle <?= ($view == 'laporan' || $view == 'kartu-stok') ? 'bg-primary text-white rounded' : '' ?>" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Laporan
        </a>
        <ul class="dropdown-menu" aria-labelledby="laporanDropdown">
            <li>
                <a class="dropdown-item <?= ($view == 'laporan') ? 'active' : '' ?>" href="?view=laporan">Laporan Penjualan</a>
            </li>
            <li>
                <a class="dropdown-item <?= ($view == 'kartu-stok') ? 'active' : '' ?>" href="?view=kartu-stok">Kartu Stok</a>
            </li>
        </ul>
    </li>
</ul>
