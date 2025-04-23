<?php $ajaxDataTable = './app/pembelian/table.php'; ?>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12 d-flex align-items-center justify-content-between">
            <h3 class="fw-bold">Daftar Pembelian</h3>
            <a href="?view=pembelian-baru" class="btn btn-primary">
                <i class="fa fa-plus"></i> Pembelian Baru
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
                            <th class="text-center" width="30%">Supplier</th>
                            <th class="text-center" width="20%">No. Faktur</th>
                            <th class="text-center" width="15%">Jatuh Tempo</th>
                            <th class="text-center" width="5%">Item</th>
                            <th class="text-center" width="15%">Grand Total</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>