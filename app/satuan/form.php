<?php
$isEdit = false;
$url    = '?view=satuan-submit';

if (isset($_GET['id'])) {
    $isEdit = true;
    $id     = $_GET['id'];
    $url    = '?view=satuan-submit&id=' . $id;

    $query = "SELECT * FROM satuan WHERE id_stn = '$id'";
    $sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $data  = mysqli_fetch_array($sql);
}
?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Form Satuan Produk</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form action="<?= $url ?>" method="POST">
                    <div class="row mb-3">
                        <label for="nama_stn" class="col-sm-2 col-form-label">Nama Satuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_stn" value="<?= ($isEdit) ? $data['nama_stn'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>