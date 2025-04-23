<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    daftarProduk($_GET['search']);
}

function daftarProduk($search)
{
    include("../../library.php");

    $query = "SELECT * FROM produk WHERE nama_prd LIKE '%$search%' ORDER BY wkt_prd DESC";
    $sql   = mysqli_query($conn, $query) or die(mysqli_fetch_array($conn));
    $key   = 0;
    $list  = [];

    while ($row = mysqli_fetch_array($sql)) {
        $list[$key]['id']   = $row['id_prd'];
        $list[$key]['text'] = $row['nama_prd'];
        $key++;
    }

    echo json_encode($list);
}
