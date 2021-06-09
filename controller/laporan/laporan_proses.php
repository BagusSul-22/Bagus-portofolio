<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
include "../../config/dbconfig.php";
include_once '../../config/dao.php';
$dao = new Dao();

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$proc = $_POST['proc'];

//FOR LAPORAN TRANSAKSI
if ($proc == "read_semua_laporan_transaksi") {

    $result = $dao->readLaporanSemuaTransaksi();
    $check = mysqli_num_rows($result);

    if ($check > 0) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read_hariini_laporan_transaksi") {

    $tglhariini = date('Y-m-d');

    $result = $dao->readLaporanHariIniTransaksi($tglhariini);
    $check = mysqli_num_rows($result);

    if ($check > 0) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read_semua_laporan_menu") {

    $result = $dao->readLaporanSemuaMenu();
    $check = mysqli_num_rows($result);

    if ($check > 0) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read_pertanggal_laporan_transaksi") {

    $awal = $_POST['tgl_awal'];
    $tglawal = date('Y-m-d', strtotime($awal));

    $akhir = $_POST['tgl_akhir'];
    $tglakhir = date('Y-m-d', strtotime($akhir));

    $result = $dao->readLaporanPerTanggalTransaksi($tglawal, $tglakhir);
    $check = mysqli_num_rows($result);

    if ($check > 0) {
        echo 1;
    } else {
        echo 0;
    }
}
