<?php
$id_kategori_menu = $_POST['id_kategori_menu'];
echo "<option selected hidden value=''>-Pilih Kategori Menu-</option>";

ini_set('display_errors', 'On');
error_reporting(E_ALL);
include_once '../../config/dao.php';
$dao = new Dao();
$result = $dao->readKategoriMenu();
while ($row = mysqli_fetch_array($result)) {
    if ($id_kategori_menu != '0') {
        if ($row['id_kategori_menu'] == $id_kategori_menu) {
            $select = "selected";
        } else {
            $select = "";
        }
        echo "<option $select value='" . $row['id_kategori_menu'] . "'>" . $row['nama_kategori_menu'] . "</option>";
    } else {
        echo "<option value='" . $row['id_kategori_menu'] . "'>" . $row['nama_kategori_menu'] . "</option>";
    }
}
