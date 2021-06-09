<?php
date_default_timezone_set('Asia/Jakarta');
include "../../config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$proc = $_POST['proc'];
$id = $_POST['id'];
if ($proc == "delete") {

    $query = ("CALL hapusKaryawan('$id')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "insert") {
    $username = $_POST['username'];
    $password = MD5($_POST['password']);
    $nama = $_POST['nama'];
    $ttl = $_POST['ttl'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['no_hp'];
    $jabatan = $_POST['cb_jabatan'];
    $create_at = date('Y-m-d G:i:s');
    $update_at = date('Y-m-d G:i:s');

    $query = ("INSERT INTO tbl_karyawan (username_karyawan, password_karyawan, nama_karyawan,ttl, alamat_karyawan, no_hp_karyawan, id_jabatan, create_at, update_at) 
            VALUES ('" . $username . "','" . $password . "','" . $nama  . "','" . $ttl . "','" . $alamat . "','" . $nohp . "','" . $jabatan . "','" . $create_at . "','" . $update_at . "')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "update") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['no_hp'];
    $update_at = date('Y-m-d G:i:s');

    $query = ("UPDATE tbl_karyawan SET nama_karyawan='$nama', alamat_karyawan='$alamat', no_hp_karyawan='$nohp', update_at='$update_at' WHERE id_karyawan ='$id'");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read") {
    $query = "SELECT * FROM tbl_karyawan WHERE id_karyawan=" . $id;
    $result = mysqli_query($conn, $query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
}
