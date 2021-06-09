<?php
    echo "<option selected hidden value='Pilih Jabatan'>Pilih Jabatan</option>";

    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    include_once '../../config/dao.php';
    $dao = new Dao();
    $result = $dao->readJabatan();
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value='".$row['id_jabatan']."'>".$row['nama_jabatan']."</option>";
    }
