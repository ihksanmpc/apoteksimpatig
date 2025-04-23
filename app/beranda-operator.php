<div class="container">
    <div class="row mb-2">
        <div class="col-md-8 mb-3 align-self-center">
            <h3>Selamat Datang!</h3>
            <h2 class="display-4 fw-bolder text-primary"><?= ucwords($_SESSION['nama_lengkap']) ?></h2>
            <small class="my-3 text-justify">Sistem Informasi Penjualan <strong><?= $title ?></strong> untuk memantau semua transaksi yang dilakukan mulai dari penjualan, pembelian hingga pengeluaran dengan laporan data setiap bulan</small>
            <br>
            <a href="?view=penjualan-baru" class="btn btn-primary px-3 mt-4">
                Penjualan Baru
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <img class="img-fluid" alt="Responsive image" src="<?= $logo ?>">
        </div>
    </div>
</div>