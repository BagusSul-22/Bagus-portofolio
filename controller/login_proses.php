<?php
ob_start();
session_start();
include "../config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$username = $_POST['username_log'];
$password = md5($_POST['password_log']);

$query = mysqli_query($conn, "SELECT id_karyawan,nama_karyawan FROM tbl_karyawan WHERE username_karyawan='$username' AND password_karyawan ='$password'");
$check = mysqli_num_rows($query);

if ($check >= 1) {
  $row = mysqli_fetch_assoc($query);
  $_SESSION['id_karyawan'] = $row['id_karyawan'];
  $_SESSION['nama_karyawan'] = $row['nama_karyawan'];
  echo 1;
} else {
  echo 0;
}
