<?php
$isEdit = false;
$url    = '?view=supplier-submit';

$q_satuan   = "SELECT * FROM satuan ORDER by wkt_stn DESC";
$sql_satuan = mysqli_query($conn, $q_satuan) or die(mysqli_error($conn));

if (isset($_GET['id'])) {
    $isEdit = true;
    $id     = $_GET['id'];
    $url    = '?view=supplier-submit&id=' . $id;

    $query = "SELECT * FROM supplier WHERE id_supp = '$id'";
    $sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $data  = mysqli_fetch_array($sql);
}
?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Form Supplier</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form action="<?= $url ?>" method="POST">
                    <div class="row mb-3">
                        <label for="nama_supp" class="col-sm-2 col-form-label">Nama supplier</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_supp" value="<?= ($isEdit) ? $data['nama_supp'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="kntk_supp" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="kntk_supp" value="<?= ($isEdit) ? $data['kntk_supp'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="almt_supp" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="almt_supp" value="<?= ($isEdit) ? $data['almt_supp'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>
                        <a href="?view=supplier" class="btn btn-warning">
                            Kembali ke Daftar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>