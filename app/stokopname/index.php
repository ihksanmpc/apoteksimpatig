

	<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Pilih Tanggal Stok Opname</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form class="row row-cols-lg-auto g-3 align-items-center mb-3 mt-2" method="POST" action="app/stokopname/export.php">
        <div class="col-12">
            <div class="input-group">
                <div class="input-group-text">Tanggal</div>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $_POST['awal'] ?: ''  ?>" required>
            </div>
        </div>


        <div class=" col-12">
            <button type="submit" name="filter" class="btn btn-primary">Download</button>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>	

    