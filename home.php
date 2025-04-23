<?php
session_start();
include 'library.php';
if (isset($_GET['view'])) $view = $_GET['view'];

if ($_SESSION['status'] != 'LOGIN') {
   $message = 'Silakan login aplikasi terlebih dahulu!';
   alert($message, 'index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title><?= $title ?></title>

   <!-- favicon -->
   <link rel="shortcut icon" href="<?= $logo ?>" type="image/x-icon">
   <!-- Bootstrap core CSS -->
   <link href="./asset/css/style.css" rel="stylesheet">
   <!-- fontawesome core CSS -->
   <link href="./asset/css/fontawesome-free-5.11.2/css/all.min.css" rel="stylesheet">
   <!-- datatables core CSS -->
   <link href="./asset/css/dataTables.bootstrap5.min.css" rel="stylesheet">

   <?php if ($_GET['view'] == 'pembelian-detail' or $_GET['view'] == 'penjualan-detail') : ?>
      <!-- Select2 -->
      <link href="./asset/css/select2.min.css" rel="stylesheet" />
      <link href="./asset/css/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
   <?php endif; ?>

</head>

<body class="bg-light">
   <!-- header -->
   <header class="py-md-2 py-1 bg-white">
      <div class="container-fluid d-flex gap-md-3 gap-2 align-items-center">
         <img src="<?= $logo ?>" width="150">
         <h1 class="m-0 fw-bold text-primary">
            <?= $title ?>
         </h1>
      </div>
   </header>

   <nav class="navbar navbar-expand-lg bg-white">
      <div class="container-fluid">
         <button class="navbar-toggler w-100" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
               <?php
               if ($_SESSION['level'] == 1) {
                  include 'nav-admin.php';
               }

               if ($_SESSION['level'] == 2) {
                  include 'nav-user.php';
               }
               ?>
            </ul>
            <ul class="navbar-nav ms-auto">
               <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                     <i class="fa-solid fa-circle-user"></i>
                     <span class="ms-1">
                        <?= $_SESSION['nama_lengkap'] ?>
                     </span>
                  </a>

                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                     <a class="dropdown-item" href="?view=profile">
                        <i class="fa-solid fa-fire-flame-curved"></i>
                        <span class="ms-1">Profile</span>
                     </a>
                     <?php if ($_SESSION['level'] == 1) : ?>
                     <a class="dropdown-item" href="?view=stok">
                        <i class="fa-solid fa-fire-flame-curved"></i>
                           <span class="ms-1">Stok Opname</span>
                        </a>
                        <a class="dropdown-item" href="?view=backup" onclick="return confirm(`Apakah yakin ingin melakukan backup database?`)">
                           <i class="fa-solid fa-fire-flame-curved"></i>
                           <span class="ms-1">Backup Database</span>
                        </a>

                     <?php endif; ?>
                     <hr class="dropdown-divider">
                     <a class="dropdown-item text-danger" href="?view=logout" onclick="return confirm(`Apakah yakin ingin keluar dari aplikasi ini ?`);">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="ms-1">
                           Keluar
                        </span>
                     </a>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </nav>

   <main class="py-4">
      <?php include("controller/content.php"); ?>
   </main>

   <footer class="py-3">
      <p class="text-center">
         Powered by <strong class="text-primary"><?= $copyright ?></strong> &copy; <?= date('Y') ?>
      </p>
   </footer>

   <!-- Bootstrap core JavaScript-->
   <script src="./asset/js/jquery-3.6.1.min.js"></script>
   <script src="./asset/js/bootstrap.bundle.min.js"></script>

   <?php if ($_GET['view'] == 'pembelian-detail' or $_GET['view'] == 'penjualan-detail') : ?>
      <script src="./asset/js/discount.js"></script>
      <script src="./asset/js/select2.full.min.js"></script>
      <script src="./asset/js/select2-produk.js"></script>
   <?php endif; ?>

   <?php if (isset($ajaxDataTable)) : ?>
      <script src="./asset/js/jquery.dataTables.min.js"></script>
      <script src="./asset/js/dataTables.bootstrap5.min.js"></script>
      <script>
         $(document).ready(function() {
            $('.dataTable').DataTable({
               "processing": true,
               "serverside": true,
               "ordering": false,
               "ajax": "<?= $ajaxDataTable ?>",
               language: {
                  url: './asset/js/datatable-id-language.json'
               }
            });
         });
      </script>
   <?php endif; ?>

   <!-- script custom -->
   <?php include("controller/script.php"); ?>
</body>

</html>