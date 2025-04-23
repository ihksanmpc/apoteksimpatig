<?php
$isEdit = false;
$url    = '?view=penjualantt-submit';

if (isset($_GET['id'])) {
    $isEdit = true;
    $id     = $_GET['id'];
    $url    = '?view=penjualantt-submit&id=' . $id;

    $query = "SELECT * FROM penjualan_tdk_tercatat WHERE id_ptt = '$id'";
    $sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $data  = mysqli_fetch_array($sql);
}

?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Form Penjualan Tidak Tercatat</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           
                <form action="<?= $url ?>" method="POST">
              
                    <div class="row mb-3">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" name="tanggal" value="<?= ($isEdit) ? $data['tgl_ptt'] : date('Y-m-d')  ?>" required>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="nominal" value="<?= ($isEdit) ? $data['nmnl_ptt'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nominal" class="col-sm-2 col-form-label">Ketrangan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="ket" value="<?= ($isEdit) ? $data['ket'] : '' ?>" >
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