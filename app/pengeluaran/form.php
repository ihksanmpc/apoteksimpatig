<?php
$isEdit = false;
$url    = '?view=pengeluaran-submit';

if (isset($_GET['id'])) {
    $isEdit = true;
    $id     = $_GET['id'];
    $url    = '?view=pengeluaran-submit&id=' . $id;

    $query = "SELECT * FROM pengeluaran WHERE id_lr = '$id'";
    $sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $data  = mysqli_fetch_array($sql);
}

?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Form Pengeluaran</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form action="<?= $url ?>" method="POST">
                    <div class="row mb-3">
                        <label for="jenis" class="col-sm-2 col-form-label">Jenis pengeluaran</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jenis" value="<?= ($isEdit) ? $data['jns_lr'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" name="tanggal" value="<?= ($isEdit) ? $data['tgl_lr'] : date('Y-m-d') ?>" required>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="nominal" value="<?= ($isEdit) ? $data['nmnl_lr'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>
                        <a href="?view=pengeluaran" class="btn btn-warning">
                            Kembali ke Daftar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>