<?php
$isEdit = false;
$url    = '?view=produk-submit';

$q_satuan   = "SELECT * FROM satuan ORDER by wkt_stn DESC";
$sql_satuan = mysqli_query($conn, $q_satuan) or die(mysqli_error($conn));

if (isset($_GET['id'])) {
    $isEdit = true;
    $id     = $_GET['id'];
    $url    = '?view=produk-submit&id=' . $id;

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
            <h3 class="fw-bold">Form Produk</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form action="<?= $url ?>" method="POST">
                    <div class="row mb-3">
                        <label for="nama_prd" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_prd" value="<?= ($isEdit) ? $data['nama_prd'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nama_prd" class="col-sm-2 col-form-label">Satuan</label>
                        <div class="col-sm-6">
                            <select name="stn_id" class="form-select">
                                <option value="" selected>-- PILIH SATUAN --</option>
                                <?php while ($item = mysqli_fetch_array($sql_satuan)) : ?>
                                    <option value="<?= $item['id_stn'] ?>" <?= ($isEdit) ? isSelected($item['id_stn'], $data['stn_id']) : '' ?>>
                                        <?= $item['nama_stn'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                           <div class="row mb-3">
                        <label for="stok_prd" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="stok_prd" value="<?= ($isEdit) ? $data['stok_prd'] : '0' ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="beli_prd" class="col-sm-2 col-form-label">Harga Beli</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="beli_prd" id="beli_prd" value="<?= ($isEdit) ? $data['beli_prd'] : '' ?>" required>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label for="prd_ppn" class="col-sm-2 col-form-label">PPN %</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" name="prd_ppn" id="prd_ppn" value="11" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="prd_ppn" class="col-sm-2 col-form-label">MARGIN %</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" name="margin" id="margin" value="30" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jual_prd" class="col-sm-2 col-form-label">Harga Jual</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="jual_prd" id="jual_prd" value="<?= ($isEdit) ? $data['jual_prd'] : '' ?>" required >
                        </div>
                    </div>
             
                    <div class="row mb-3">
                        <label for="tgl_ed" class="col-sm-2 col-form-label">Tgl. Expire</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tgl_ed" value="<?= ($isEdit) ? $data['tgl_ed'] : date('Y-m-d') ?>" required>
                           
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>
                        <a href="?view=produk" class="btn btn-warning">
                            Kembali ke Daftar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let isHargaJualManual = false; // Flag untuk menandai apakah harga jual diubah manual

    // Fungsi untuk menghitung harga jual otomatis
    function hitungHargaJual() {
        if (isHargaJualManual) return; // Jika harga jual diubah manual, hentikan perhitungan otomatis

        var hargaBeli = parseFloat(document.getElementById('beli_prd').value);
         var prd_ppn = parseFloat(document.getElementById('prd_ppn').value);
        var margin = parseFloat(document.getElementById('margin').value);


        // Hitung harga jual
        var hargaJual = hargaBeli + (hargaBeli * prd_ppn / 100 ) + (hargaBeli * margin / 100 )  ;

        // Tampilkan harga jual dengan format 2 digit di belakang koma
        document.getElementById('jual_prd').value = hargaJual;
    }

    // Fungsi untuk menandai bahwa harga jual diubah manual
    function setHargaJualManual() {
        isHargaJualManual = true;
    }

    // Menambahkan event listener untuk update harga jual ketika harga beli atau margin berubah
    document.getElementById('beli_prd').addEventListener('input', hitungHargaJual);
    document.getElementById('prd_ppn').addEventListener('input', hitungHargaJual);

    // Menambahkan event listener untuk menandai harga jual diubah manual
    document.getElementById('jual_prd').addEventListener('input', setHargaJualManual);

    // Hitung harga jual ketika halaman pertama kali dimuat jika sudah ada harga beli atau margin
    window.addEventListener('load', hitungHargaJual);
</script>