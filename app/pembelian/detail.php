<?php
$status = $_GET['status'];
$beliID = $_GET['id'];

$query = "SELECT * FROM pembelian WHERE id_bl=$beliID LIMIT 1";
$sql   = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data  = mysqli_fetch_array($sql);

function isSelected($key, $value)
{
    if ($key == $value) {
        return 'selected';
    }
}
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-md-6 col-12 mb-2">
            <h2 class="fw-bold">Grand Total Pembelian</h2>
        </div>
        <div class="col-md-6 col-12 mb-2 text-md-end">
            <h2 class="fw-bold">Rp. <span id="textGrandTotal"><?= rupiah($total) ?></span>,-</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <form class="row row-cols-lg-auto g-3 align-items-center" action="?view=pembelian-detail-tambah&status=<?= $status ?>&id=<?= $_GET['id'] ?>" method="POST" id="formTambahObat">
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-text">
                            Barang/Produk
                        </div>
                        <select class="form-select select2-produk" id="id_produk" name="id_produk" required>
                            <!-- Produk options dynamically loaded -->
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-text">
                            Qty
                        </div>
                        <input class="form-control" type="number" name="jml_bdet" id="qty" value="1" required>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-8 col-12 mb-2">
            <table class="table table-sm table-hover align-middle">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nama Produk</th>
                        <th class="text-center" width="100">Harga</th>
                        <th class="text-center" width="80">Qty</th>
                        <th class="text-center" width="120">Total</th>
                        <th class="text-center" width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyProduk">
                    <?php
                    $beli_id = $_GET['id'];
                    $query   = "SELECT * FROM pembelian_detail JOIN produk ON pembelian_detail.prd_id=produk.id_prd WHERE beli_id=$beli_id ORDER BY id_bdet DESC";
                    $sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    $total   = 0;
                    $item    = mysqli_num_rows($sql);

                    while ($list = mysqli_fetch_array($sql)) {
                    ?>
                        <tr>
                            <td>
                                <p class="text-start my-0"><?= $list['nama_prd'] ?></p>
                            </td>
                            <td>
                                Rp. <span class="float-end"><?= rupiah($list['beli_prd']) ?></span>
                            </td>
                            <td>
                                <p class="text-center my-0"><?= number_format($list['jml_bdet']) ?></p>
                            </td>
                            <td>
                                Rp.
                                <span class="float-end">
                                    <?= rupiah($list['beli_prd'] * $list['jml_bdet']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="?view=pembelian-detail-hapus&status=<?= $status ?>&id-beli=<?= $_GET['id'] ?>&id-prd=<?= $list['id_prd'] ?>&qty=<?= $list['jml_bdet'] ?>" class="btn btn-sm btn-danger rounded-circle">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                        $total += $list['beli_prd'] * $list['jml_bdet'];
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <form action="?view=pembelian-submit" method="POST" class="row g-3">
                        <input type="hidden" name="id_bl" value="<?= $_GET['id'] ?>">
                        <div class="col-12">
                            <label class="form-label">Supplier</label>
                            <select name="supplier" id="supplier" class="form-control" required>
                                <?php if ($status == 'baru') : ?>
                                    <option value="">-- Pilih Supplier --</option>
                                <?php endif; ?>
                                <?php
                                $query   = "SELECT * FROM supplier ORDER BY wkt_supp DESC";
                                $sql     = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                while ($supplier  = mysqli_fetch_array($sql)) :
                                ?>
                                    <option value="<?= $supplier['id_supp'] ?>" <?= ($status == 'ubah') ? isSelected($supplier['id_supp'], $data['supp_id']) : '' ?>>
                                        <?= $supplier['nama_supp'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">No. Faktur</label>
                            <input type="text" class="form-control" name="faktur" value="<?= ($status == 'ubah') ? $data['faktur'] : '' ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Jatuh Tempo</label>
                            <input type="date" class="form-control" name="jth_tempo" value="<?= ($status == 'ubah') ? $data['jth_tempo'] : date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="item">Item</label>
                            <input type="text" class="form-control" name="item" id="item" value="<?= $item ?>" readonly>
                        </div>
                        <div class="col-md-8">
                            <label for="id">Total</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    Rp.
                                </div>
                                <input type="text" class="form-control text-end" name="total" id="total" value="<?= $total ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="id">PPN</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="ppn" id="ppn" value="11" required>
                                <div class="input-group-text">
                                    %
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="id">Grand Total</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    Rp.
                                </div>
                                <input type="text" class="form-control text-end" name="grandtotal" id="grandtotal" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-check-circle"></i> Simpan Pembelian
                            </button>
                            <a href="?view=pembelian" class="btn btn-danger w-100 mt-2">
                                <i class="fa fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menghitung grand total
    function updateGrandTotal() {
        var total = parseFloat(document.getElementById('total').value) || 0;
        var ppn = parseFloat(document.getElementById('ppn').value) || 0;

        // Menghitung PPN
        var ppnAmount = (ppn / 100) * total;

        // Menghitung grand total setelah PPN
        var grandTotal = total + ppnAmount;

        // Update grand total di form
        document.getElementById('grandtotal').value = grandTotal.toFixed(2);
        document.getElementById('textGrandTotal').textContent = grandTotal.toFixed(2);
    }

    // Event listener untuk perubahan pada PPN
    document.getElementById('ppn').addEventListener('input', updateGrandTotal);

    // Event listener untuk menambah item (produk dan quantity)
    document.getElementById('formTambahObat').addEventListener('submit', function (e) {
        e.preventDefault();

        // Ambil harga produk dan quantity
        var hargaProduk = parseFloat(document.getElementById('id_produk').value);
        var qty = parseInt(document.getElementById('qty').value);

        // Validasi harga produk dan qty agar valid
        if (isNaN(hargaProduk) || isNaN(qty) || qty <= 0) {
            alert('Mohon masukkan harga produk dan quantity yang valid.');
            return;
        }

        // Hitung total untuk item baru
        var totalItem = hargaProduk * qty;

        // Ambil nilai grand total sebelumnya
        var grandTotal = parseFloat(document.getElementById('grandtotal').value) || 0;

        // Update grand total setelah menambahkan total item
        grandTotal += totalItem;

        // Update grand total di form
        document.getElementById('grandtotal').value = grandTotal.toFixed(2);
        document.getElementById('textGrandTotal').textContent = grandTotal.toFixed(2);

        // Lanjutkan submit form setelah update
        this.submit();
    });

    // Panggil fungsi untuk pertama kali agar total dihitung setelah halaman dimuat
    updateGrandTotal();
</script>
