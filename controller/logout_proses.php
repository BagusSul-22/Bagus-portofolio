<?php
session_start();
include "../conf/dbconfig.php";
$sess_admin = $_SESSION['id_karyawan'];
$sess_nama = $_SESSION['nama_karyawan'];
if (isset($sess_admin, $sess_nama)) {
    session_destroy();
    header("location:../pages/login.php");
}
