<?php
$isEdit = false;
$url    = '?view=user-submit';

if (isset($_GET['id'])) {
    $isEdit = true;
    $id     = $_GET['id'];
    $url    = '?view=user-submit&id=' . $id;

    $query = "SELECT * FROM user WHERE id_usr = '$id'";
    $sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $data  = mysqli_fetch_array($sql);
}

function isChecked($key, $value)
{
    if ($key == $value) {
        return 'checked';
    }
}
?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Form User</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form action="<?= $url ?>" method="POST">
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" value="<?= ($isEdit) ? $data['nama_usr'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="nama_usr" class="col-sm-2 col-form-label">Level User</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="level" id="operator" value="2" <?= ($isEdit) ? isChecked($data['lvl_usr'], 2) : '' ?>>
                                <label class="form-check-label" for="operator">
                                    Operator
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="level" id="administrator" value="1" <?= ($isEdit) ? isChecked($data['lvl_usr'], 1) : '' ?>>
                                <label class="form-check-label" for="administrator">
                                    Administrator
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>
                        <a href="?view=user" class="btn btn-warning">
                            Kembali ke Daftar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>