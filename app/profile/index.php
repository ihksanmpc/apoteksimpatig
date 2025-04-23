<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Pengaturan Profile</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="?view=profile-submit" class="bg-white p-3" method="POST">
                <div class="row mb-4">
                    <label for="fullname_user" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="fullname_user" value="<?= $_SESSION['nama_lengkap'] ?>" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="name_user" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name_user" value="<?= $_SESSION['username'] ?>" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="pass_user" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="pass_user" placeholder="*****">
                        <small class="text-danger">
                            Kosongkan jika tidak ingin mengubah password Anda.
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 offset-2 text-end">
                        <button type="submit" class="btn btn-primary">Simpan Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>