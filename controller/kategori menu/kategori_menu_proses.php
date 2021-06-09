<?php
date_default_timezone_set('Asia/Jakarta');
include "../../config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$proc = $_POST['proc'];
$id = $_POST['id'];
$create_at = date('Y-m-d G:i:s');
$update_at = date('Y-m-d G:i:s');
if ($proc == "delete") {

    $query = ("CALL hpsKategoriMenu('$id')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "insert") {
    $nama = $_POST['nama'];

    $query = ("INSERT INTO tbl_kategori_menu (nama_kategori_menu,create_at,update_at)
                VALUES ('" . $nama .  "','" . $create_at . "','" . $update_at . "')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "update") {
    $nama = $_POST['nama'];

    $query = ("UPDATE tbl_kategori_menu SET nama_kategori_menu='$nama', update_at='$update_at' WHERE id_kategori_menu ='$id'");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read") {
    $query = "SELECT * FROM tbl_kategori_menu WHERE id_kategori_menu=" . $id;
    $result = mysqli_query($conn, $query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
}
