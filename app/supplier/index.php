<?php $ajaxDataTable = './app/supplier/table.php'; ?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12 d-flex align-items-center justify-content-between">
            <h3 class="fw-bold">Daftar Supplier</h3>
            <a href="?view=supplier-form" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah
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
                            <th class="text-center" width="50%">Nama supplier</th>
                            <th class="text-center" width="25%">Kontak</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>