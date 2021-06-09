<?php
include "../../conf/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$username = $_POST['username'];

$query = mysqli_query ($conn, "SELECT * FROM tb_karyawan WHERE username_karyawan='$username'");
$check = mysqli_num_rows($query);

if ($check>0){
  echo 0;
} else {
  echo 1;
}
?>