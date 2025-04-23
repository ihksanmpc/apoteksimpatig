<?php $ajaxDataTable = './app/produk/table.php'; ?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12 d-flex align-items-center justify-content-between">
            <h3 class="fw-bold">Daftar Produk</h3>
            <?php if ($_SESSION['level'] == 1) : ?>
                <a href="?view=produk-form" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2 table-responsive">
                <table class="table table-striped dataTable align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-start" width="5%">No. </th>
                            <th class="text-start" width="45%">Nama produk</th>
                            <th class="text-start" width="15%">Satuan</th>
                    
                            <th class="text-center" width="15%">Hrg. Jual</th>
                            <th class="text-center" width="8%">Stok</th>
                            <?php if ($_SESSION['level'] == 1) : ?>
                            <th class="text-center" width="15%">Hrg. Beli</th>
                                <th class="text-center" width="10%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>