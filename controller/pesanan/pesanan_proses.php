<?php
date_default_timezone_set('Asia/Jakarta');
include "../../config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$proc = $_POST['proc'];
$id = $_POST['id'];
$update_at = date('Y-m-d G:i:s');

if ($proc == "update") {
    $id_transaksi = $_POST['id_transaksi'];
    $stat_pesanan = $_POST['stat_meja'];


    $query = ("UPDATE tbl_transaksi SET id_transaksi='$id_transaksi',status='$stat_pesanan', update_at='$update_at' WHERE id_meja ='$id'");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read") {
    $query = "SELECT tbl_transaksi.`id_transaksi`, tbl_meja.`nomor`, tbl_transaksi.`nama_pelanggan`,`tbl_detail_transaksi`.`total`,`tbl_transaksi`.`status` AS pesanan_masuk
        FROM tbl_transaksi, `tbl_detail_transaksi`,`tbl_meja` 
        WHERE tbl_transaksi.`id_transaksi` = tbl_detail_transaksi.`id_detail_transaksi`
        ORDER BY tbl_meja.`nomor` ASC";
    $result = mysqli_query($conn, $query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
} else if ($proc == "readall") {
    $query = "SELECT `tbl_transaksi`.`id_transaksi`,tbl_meja.`nomor`,`tbl_transaksi`.`jumlah_beli`,tbl_meja.id_meja, `tbl_transaksi`.`is_success`
    FROM tbl_meja
    INNER JOIN `tbl_transaksi` ON tbl_meja.`id_meja` = tbl_transaksi.`id_meja`
    WHERE tbl_transaksi.is_success='0'
    ORDER BY tbl_transaksi.`id_transaksi` DESC";
    $result = mysqli_query($conn, $query);
    $list = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $list[] = $row;
    }
    echo json_encode($list);
    exit();
} else if ($proc == "readalldetailpemesanan") {
    $query = "SELECT `tbl_detail_transaksi`.`id_detail_transaksi`,tbl_detail_transaksi.is_proses,`tbl_detail_transaksi`.`id_transaksi`,tbl_menu.`nama_menu`,tbl_detail_transaksi.`note`,`tbl_detail_transaksi`.`jumlah`
    FROM tbl_menu
    INNER JOIN `tbl_detail_transaksi` ON tbl_menu.`id_menu` = tbl_detail_transaksi.`id_menu`
    WHERE tbl_detail_transaksi.id_transaksi='$id'";
    $result = mysqli_query($conn, $query);
    $list = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $list[] = $row;
    }
    echo json_encode($list);
    exit();
} else if ($proc == "hapusdatapesanan") {
    $id_meja = $_POST['id_meja'];
    $query = ("UPDATE tbl_meja SET status_meja='0',update_at='$update_at' WHERE id_meja ='$id_meja'");

    if (mysqli_query($conn, $query)) {
        $queryupdatemeja = ("DELETE FROM `tbl_transaksi` WHERE `id_transaksi` = '$id'");
        if (mysqli_query($conn, $queryupdatemeja)) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else if ($proc == "prosesdatadetail") {
    $id_transaksi = $_POST['id_transaksi'];
    $query = ("UPDATE tbl_detail_transaksi SET is_proses='1',update_at='$update_at' WHERE id_detail_transaksi ='$id'");

    if (mysqli_query($conn, $query)) {
        $query_cek_status = mysqli_query($conn, "SELECT COUNT(id_detail_transaksi) AS jumlah FROM tbl_detail_transaksi WHERE id_transaksi ='$id_transaksi' AND is_proses ='0'");
        $row_cek_data = mysqli_fetch_assoc($query_cek_status);
        $jumlah_data = $row_cek_data['jumlah'];
        if ($jumlah_data < 1) {
            $queryupdatestatustransaksi = ("UPDATE tbl_transaksi SET is_success='1',update_at='$update_at' WHERE id_transaksi ='$id_transaksi'");
            if (mysqli_query($conn, $queryupdatestatustransaksi)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 1;
        }
    } else {
        echo 0;
    }
} else if ($proc == "prosessemuadatadetail") {
    $query = ("UPDATE tbl_detail_transaksi SET is_proses='1' WHERE id_transaksi ='$id'");

    if (mysqli_query($conn, $query)) {
        $queryupdatestatustransaksi = ("UPDATE tbl_transaksi SET is_success='1' WHERE id_transaksi ='$id'");
        if (mysqli_query($conn, $queryupdatestatustransaksi)) {
            echo 1;
        } else {
            echo mysqli_error($conn);
        }
    } else {
        echo mysqli_error($conn);
    }
}
