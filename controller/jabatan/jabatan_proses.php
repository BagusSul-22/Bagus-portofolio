<?php
date_default_timezone_set('Asia/Jakarta');
include "../../config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$proc = $_POST['proc'];
$id = $_POST['id'];
if ($proc == "delete") {

    $query = ("CALL hapusJabatan('$id')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "insert") {
    $nama = $_POST['nama'];
    $create_at = date('Y-m-d G:i:s');
    $update_at = date('Y-m-d G:i:s');

    $query = ("INSERT INTO tbl_jabatan (nama_jabatan, create_at, update_at) 
            VALUES ('" . $nama . "','" . $create_at . "','" . $update_at . "')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "update") {
    $nama = $_POST['nama'];
    $update_at = date('Y-m-d G:i:s');

    $query = ("UPDATE tbl_jabatan SET nama_jabatan='$nama', update_at='$update_at' WHERE id_jabatan ='$id'");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read") {
    $query = "SELECT * FROM tbl_jabatan WHERE id_jabatan=" . $id;
    $result = mysqli_query($conn, $query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
}
