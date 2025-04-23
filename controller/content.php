<?php

// Content data utama
if (isset($_GET['view'])) $view = $_GET['view'];
else $view = "admin";

if ($view == "admin") include("app/beranda-admin.php");
elseif ($view == "operator") include("app/beranda-operator.php");
elseif ($view == "logout") include("app/logout.php");

// Content PROFILE
elseif ($view == "profile") include("app/profile/index.php");
elseif ($view == "profile-submit") include("app/profile/submit.php");

// Content CRUD data SATUAN
elseif ($view == "satuan") include("app/satuan/index.php");
elseif ($view == "satuan-form") include("app/satuan/form.php");
elseif ($view == "satuan-submit") include("app/satuan/submit.php");
elseif ($view == "satuan-delete") include("app/satuan/delete.php");

// Content CRUD data PRODUK
elseif ($view == "produk") include("app/produk/index.php");
elseif ($view == "produk-form") include("app/produk/form.php");
elseif ($view == "produk-submit") include("app/produk/submit.php");
elseif ($view == "produk-delete") include("app/produk/delete.php");

// Content CRUD data SUPPLIER
elseif ($view == "supplier") include("app/supplier/index.php");
elseif ($view == "supplier-form") include("app/supplier/form.php");
elseif ($view == "supplier-submit") include("app/supplier/submit.php");
elseif ($view == "supplier-delete") include("app/supplier/delete.php");

// Content CRUD data USER
elseif ($view == "user") include("app/user/index.php");
elseif ($view == "user-form") include("app/user/form.php");
elseif ($view == "user-submit") include("app/user/submit.php");
elseif ($view == "user-delete") include("app/user/delete.php");

// Content CRUD data penjualan tidak tercatat
elseif ($view == "penjualantt") include("app/penjualantt/index.php");
elseif ($view == "penjualantt-form") include("app/penjualantt/form.php");
elseif ($view == "penjualantt-submit") include("app/penjualantt/submit.php");
elseif ($view == "penjualantt-delete") include("app/penjualantt/delete.php");

// Content CRUD data PENGELUARAN
elseif ($view == "pengeluaran") include("app/pengeluaran/index.php");
elseif ($view == "pengeluaran-form") include("app/pengeluaran/form.php");
elseif ($view == "pengeluaran-submit") include("app/pengeluaran/submit.php");
elseif ($view == "pengeluaran-delete") include("app/pengeluaran/delete.php");

// Content FITUR PEMBELIAN
elseif ($view == "pembelian") include("app/pembelian/index.php");
elseif ($view == "pembelian-baru") include("app/pembelian/baru.php");
elseif ($view == "pembelian-detail") include("app/pembelian/detail.php");
elseif ($view == "pembelian-submit") include("app/pembelian/submit.php");
elseif ($view == "pembelian-hapus") include("app/pembelian/hapus.php");

// Conten FITUR PEMBELIAN DETAIL
elseif ($view == "pembelian-detail-tambah") include("app/pembelian-detail/tambah.php");
elseif ($view == "pembelian-detail-hapus") include("app/pembelian-detail/hapus.php");

// Content FITUR PENJUALAN
elseif ($view == "penjualan") include("app/penjualan/index.php");
elseif ($view == "penjualan-baru") include("app/penjualan/baru.php");
elseif ($view == "penjualan-detail") include("app/penjualan/detail.php");
elseif ($view == "penjualan-submit") include("app/penjualan/submit.php");
elseif ($view == "penjualan-hapus") include("app/penjualan/hapus.php");
elseif ($view == "print") include("app/penjualan/print/print.php");

// Content FITUR PENJUALAN DETAIL
elseif ($view == "penjualan-detail-tambah") include("app/penjualan-detail/tambah.php");
elseif ($view == "penjualan-detail-hapus") include("app/penjualan-detail/hapus.php");

// Content DATA LAPORAN
elseif ($view == "laporan") include("app/laporan/index.php");

elseif ($view == "laporan_harian") include("app/laporan_harian/index_harian.php");

elseif ($view == "stok") include("app/stokopname/index.php");
elseif ($view == "stokopname-input") include("app/stokopname/stokopname.php");
elseif ($view == "stokopname-inputstok") include("app/stokopname/inputstok.php");
elseif ($view == "export") include("app/stokopname/export.php");
elseif ($view == "kartu-stok") include("app/laporan/kartu_stok/kartustok.php");
elseif ($view == "cetak-kartu-stok") include("app/laporan/kartu_stok/cetak_kartu_stok.php");

// Content DATA BACKUP
elseif ($view == "backup") include("app/backup.php");
