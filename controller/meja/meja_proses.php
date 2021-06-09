<?php
date_default_timezone_set('Asia/Jakarta');
include "../../config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$proc = $_POST['proc'];
$id = $_POST['id'];
if ($proc == "delete") {

    $query = ("CALL hapusMeja('$id')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "insert") {
    $no_meja = $_POST['nomor'];
    $stat_meja = $_POST['stat_meja'];
    $create_at = date('Y-m-d G:i:s');
    $update_at = date('Y-m-d G:i:s');

    $query = ("INSERT INTO tbl_meja (nomor,status_meja, create_at, update_at) 
            VALUES ('" . $no_meja . "','" . $stat_meja . "','" . $create_at . "','" . $update_at . "')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "update") {
    $no_meja = $_POST['nomor'];
    $stat_meja = $_POST['stat_meja'];
    $update_at = date('Y-m-d G:i:s');

    $query = ("UPDATE tbl_meja SET nomor='$no_meja',status_meja='$stat_meja', update_at='$update_at' WHERE id_meja ='$id'");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read") {
    $query = "SELECT * FROM tbl_meja WHERE id_meja=" . $id;
    $result = mysqli_query($conn, $query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
}
