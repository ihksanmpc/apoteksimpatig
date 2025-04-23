<head>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php
$status = $_GET['status'];
$jualID = $_GET['id'];

$query = "SELECT * FROM penjualan WHERE id_jl=$jualID LIMIT 1";
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data = mysqli_fetch_array($sql);

// Hitung grand total
$total = 0;
$jual_id = $_GET['id'];
$query_detail = "SELECT * FROM penjualan_detail JOIN produk ON penjualan_detail.prd_id=produk.id_prd WHERE jual_id=$jual_id ORDER BY id_jdet DESC";
$sql_detail = mysqli_query($conn, $query_detail) or die(mysqli_error($conn));
$item = mysqli_num_rows($sql_detail);

while ($list = mysqli_fetch_array($sql_detail)) {
    $total += $list['jual_prd'] * $list['jml_jdet'];
}

// Hitung diskon dan grand total
$diskon = ($status == 'ubah') ? $data['disk_jl'] : 0; // Diskon dalam nilai tetap (Rp)
$grandtotal = $total - $diskon;
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-md-6 col-12 mb-2">
            <h2 class="fw-bold">Grand Total Penjualan</h2>
        </div>
        <div class="col-md-6 col-12 mb-2 text-md-end">
            <h2 class="fw-bold">Rp. <span id="textGrandTotal"><?= number_format($grandtotal, 0, ',', '.') ?></span>,-</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <form class="row row-cols-lg-auto g-3 align-items-center" action="?view=penjualan-detail-tambah&status=<?= $status ?>&id=<?= $_GET['id'] ?>" method="POST" onsubmit=" handleAddProduct()">
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-text">Barang/Produk</div>
                        <select class="form-select select2-produk" id="id_produk" name="id_produk" required></select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group" style="max-width: 250px;">
                        <div class="input-group-text">Qty</div>
                        <button type="button" id="decreaseBtn" class="btn btn-primary" style="width: 40px;">-</button>
                        <input class="form-control text-center" type="number" name="jml_jdet" value="1" id="qtyInput" required style="width: 60px;">
                        <button type="button" id="increaseBtn" class="btn btn-primary" style="width: 40px;">+</button>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i>Tambah Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Other content here -->
</div>

    <div class="row mb-2">
        <div class="col-md-8 col-12 mb-2">
            <table class="table table-sm table-hover align-middle">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nama Produk</th>
                        <th class="text-center" width="100">Satuan</th>
                        <th class="text-center" width="100">Harga</th>
                        <th class="text-center" width="80">Qty</th>
                        <th class="text-center" width="120">Total</th>
                        <th class="text-center" width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($sql_detail, 0); // Reset pointer result set
                    while ($list = mysqli_fetch_array($sql_detail)) {
                        // Query untuk mendapatkan satuan produk
                        $query_stn = "SELECT satuan.nama_stn FROM satuan JOIN produk ON produk.stn_id = satuan.id_stn WHERE produk.id_prd = " . $list['prd_id'];
                        $sql_stn = mysqli_query($conn, $query_stn);
                        $satuan = mysqli_fetch_array($sql_stn);
                    ?>
                        <tr>
                            <td>
                                <p class="text-start my-0"><?= $list['nama_prd'] ?></p>
                            </td>
                            <td>
                                <p class="text-start my-0"><?= $satuan['nama_stn'] ?></p>
                            </td>
                            <td>
                                Rp. <span class="float-end"><?= number_format($list['jual_prd'], 0, ',', '.') ?></span>
                            </td>
                            <td>
                                <p class="text-center my-0"><?= number_format($list['jml_jdet']) ?></p>
                            </td>
                            <td>
                                Rp.
                                <span class="float-end">
                                    <?= number_format($list['jual_prd'] * $list['jml_jdet'], 0, ',', '.') ?>
                                </span>
                            </td>
                           <td class="text-center">
    <a href="?view=penjualan-detail-hapus&status=<?= $status ?>&id-jual=<?= $_GET['id'] ?>&id-prd=<?= $list['id_prd'] ?>&qty=<?= $list['jml_jdet'] ?>" class="btn btn-sm btn-danger rounded-circle btn-hapus">
        <i class="fa fa-trash"></i>
    </a>
</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <form action="?view=penjualan-submit" method="POST" class="row g-3" onsubmit="selesaiTransaksi()">
                        <input type="hidden" name="id_jl" value="<?= $_GET['id'] ?>">
                        <div class="col-12">
                            <label class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" name="nama" value="UMUM" required>
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
                            <label for="id">Diskon</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    Rp.
                                </div>
                                <input type="text" class="form-control" name="diskon" id="diskon" value="<?= $diskon ?>" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="id">Grand Total</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    Rp.
                                </div>
                                <input type="text" class="form-control text-end" name="grandtotal" id="grandtotal" value="<?= $grandtotal ?>" readonly>
                            </div>
                        </div>
                        <div class="col-12">
 
 <label class="form-label">Pembayaran</label>
<select name="pembayaran" id="pembayaran" class="form-control" required>
<option value="tunai" selected>Tunai</option>
<option value="transfer" >Transer</option>
  <option value="qris">Qris</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-check-circle"></i> Simpan penjualan
                            </button>
                            <a href="?view=penjualan" class="btn btn-danger w-100 mt-2">
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

// Ambil elemen input qty dan tombol
const qtyInput = document.getElementById('qtyInput');
const increaseBtn = document.getElementById('increaseBtn');
const decreaseBtn = document.getElementById('decreaseBtn');

// Tambahkan event listener pada tombol increase (Tambah)
increaseBtn.addEventListener('click', function(event) {
    event.preventDefault();
    let currentQty = parseInt(qtyInput.value);
    qtyInput.value = currentQty + 1;  // Tambah kuantitas satu
});

// Tambahkan event listener pada tombol decrease (Kurang)
decreaseBtn.addEventListener('click', function(event) {
    event.preventDefault();
    let currentQty = parseInt(qtyInput.value);
    if (currentQty > 1) {  // Jangan biarkan qty lebih kecil dari 1
        qtyInput.value = currentQty - 1;  // Kurangi kuantitas satu
    }
});

// Variabel untuk melacak status transaksi
let transaksiSelesai = false;

// Fungsi untuk menandakan transaksi selesai setelah checkout
function selesaiTransaksi() {
    transaksiSelesai = true;
}

// Fungsi untuk menandakan jika tombol "Tambah Produk" ditekan
function handleAddProduct(event) {
    transaksiSelesai = true; // Menandakan transaksi belum selesai ketika menambah produk
}

// Event listener untuk sebelum meninggalkan halaman
window.addEventListener('beforeunload', function(event) {
    if (!transaksiSelesai) {
        const message = "Anda belum menyelesaikan transaksi. Hapus Produk Atau Stok Akan Berkurang";
        event.preventDefault(); // Untuk kompatibilitas dengan browser modern
        event.returnValue = message; // Untuk beberapa browser
        return message; // Untuk browser lain
    }
});

// Menambahkan event listener untuk tombol hapus
document.querySelectorAll('.btn-hapus').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah link default (hapus produk)

        const url = this.href; // Ambil URL untuk penghapusan produk
transaksiSelesai = true; // Set transaksiSelesai menjadi true

        // Menampilkan konfirmasi SweetAlert
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Produk ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna menekan tombol Hapus, redirect ke URL untuk menghapus produk
                window.location.href = url; 
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const diskonInput = document.getElementById('diskon');
    const totalInput = document.getElementById('total');
    const grandtotalInput = document.getElementById('grandtotal');
    const textGrandTotal = document.getElementById('textGrandTotal');

    if (!diskonInput || !totalInput || !grandtotalInput || !textGrandTotal) {
        console.error("Elemen input tidak ditemukan!");
        return;
    }

    // Fungsi untuk menghitung grand total
    function hitungGrandTotal() {
        let total = parseFloat(totalInput.value) || 0; // Pastikan total adalah angka
        let diskon = parseFloat(diskonInput.value) || 0; // Pastikan diskon adalah angka
        let grandtotal = total - diskon;

        if (grandtotal < 0) {
            grandtotal = 0; // Pastikan grand total tidak negatif
        }

        // Update nilai input dan tampilan
        grandtotalInput.value = grandtotal.toFixed(2);
        textGrandTotal.innerText = grandtotal.toLocaleString('id-ID');
    }

    // Event listener untuk input diskon
    diskonInput.addEventListener('input', hitungGrandTotal);

    // Event listener untuk tombol Enter (keyup)
    diskonInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            hitungGrandTotal();
        }
    });

    // Event listener untuk perubahan nilai (change)
    diskonInput.addEventListener('change', hitungGrandTotal);

    // Hitung grand total saat halaman dimuat
    hitungGrandTotal();
});

</script>