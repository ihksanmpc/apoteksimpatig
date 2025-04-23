<?php
$isEdit = false;
$url    = '?view=stokopname-inputstok';

if (isset($_GET['id'])) {
    $isEdit = true;
    $id     = $_GET['id'];
    $url    = '?view=stokopname-inputstok&id=' . $id;

    $query = "SELECT * FROM produk WHERE id_prd = '$id'";
    $sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $data  = mysqli_fetch_array($sql);
}

function isSelected($key, $value)
{
    if ($key == $value) {
        return 'selected';
    }
}
?>
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Stok Opname</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form action="<?= $url ?>" method="POST">
                    <div class="row mb-3">
                        <label for="nama_prd" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_prd" value="<?= ($isEdit && isset($data['nama_prd'])) ? htmlspecialchars($data['nama_prd']) : '' ?>" readonly >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="beli_prd" class="col-sm-2 col-form-label">Harga Beli</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="beli_prd" id="beli_prd" value="<?= ($isEdit && isset($data['beli_prd'])) ? htmlspecialchars($data['beli_prd']) : '0' ?>" readonly step="any">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="stok_prd" class="col-sm-2 col-form-label">Stok Komputer</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="stok_prd" id="stok_prd" value="<?= ($isEdit && isset($data['stok_prd'])) ? htmlspecialchars($data['stok_prd']) : '0' ?>" readonly step="any">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="stokny" class="col-sm-2 col-form-label">Stok Nyata</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="stokny" id="stokny" value="" required step="any">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="selisi" class="col-sm-2 col-form-label">Selisih</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="selisi" id="selisi" readonly step="any" min="-999999">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tselisi" class="col-sm-2 col-form-label">Total Selisih</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="tselisi" id="tselisi" value="0" readonly step="any">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="ket" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="ket" id="ket" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tgl_op" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tgl_op" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                        <a href="?view=produk" class="btn btn-warning">Kembali ke Daftar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function hitungSelisih() {
        const stokKomputer = parseFloat(document.getElementById('stok_prd').value);
        const stokNyata = parseFloat(document.getElementById('stokny').value);
        const hargaBeli = parseFloat(document.getElementById('beli_prd').value);

        if (isNaN(stokKomputer) || isNaN(stokNyata) || isNaN(hargaBeli)) {
            return;
        }

        const selisih = stokNyata - stokKomputer  ;
        const totalSelisih = hargaBeli * selisih;

        document.getElementById('selisi').value = selisih;
        document.getElementById('tselisi').value = totalSelisih;

        console.log("Stok Komputer:", stokKomputer);
        console.log("Stok Nyata:", stokNyata);
        console.log("Selisih:", selisih);
        console.log("Total Selisih:", totalSelisih);
    }

    document.getElementById('stokny').addEventListener('input', hitungSelisih);
    document.getElementById('stok_prd').addEventListener('input', hitungSelisih);
    document.getElementById('beli_prd').addEventListener('input', hitungSelisih);

    window.addEventListener('load', hitungSelisih);
</script>
