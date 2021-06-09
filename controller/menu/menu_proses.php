
<?php
date_default_timezone_set('Asia/Jakarta');
include "../../config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$proc = $_POST['proc'];
$id = $_POST['id'];
if ($proc == "delete") {
    $query = ("CALL hapusMenu('$id')");

    if (mysqli_query($conn, $query)) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "insert") {
    $nama_menu = $_POST['nama'];
    $id_kategori_menu = $_POST['cb_kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $create_at = date('Y-m-d G:i:s');
    $update_at = date('Y-m-d G:i:s');
    $nama_foto =  rand(1, 10000);
    $tanggal = date('d-m-Y');


    //Data foto Menu
    $nama_file_menu = $_FILES['foto_menu']['name'];
    $ukuran_file_menu = $_FILES['foto_menu']['size'];
    $tipe_file_menu = strtolower(pathinfo($nama_file_menu, PATHINFO_EXTENSION));
    $tmp_file_menu = $_FILES['foto_menu']['tmp_name'];

    // Set nama file menjadi tanggal dan jam upload
    $nama_file_baru = "image-" . $tanggal . " - " . $nama_foto . "." . $tipe_file_menu;

    // Set path folder tempat menyimpan gambarnya
    $path_menu = "../../img/menu/" . $nama_file_baru;

    $limit = 1000000;
    $ekstensi =  array('png', 'jpg', 'jpeg');

    // Cek apakah tipe file yang diupload adalah jpg / jpeg / png dan pdf
    if (in_array($tipe_file_menu, $ekstensi)) {

        // Cek apakah ukuran file yang diupload kurang dari sama dengan 1Mb
        if ($ukuran_file_menu < $limit) {

            $upload_menu = move_uploaded_file($tmp_file_menu, $path_menu);

            // Cek apakah gambar berhasil diupload atau tidak
            if ($upload_menu) {
                $query = "insert into tbl_menu(nama_menu, id_kategori_menu, foto, stok, 
                    harga, create_at, update_at) values ('$nama_menu', '$id_kategori_menu', '$nama_file_baru', '$stok', 
                    '$harga', '$create_at', '$update_at')";

                if (mysqli_query($conn, $query)) {
                    echo "1";
                } else {
                    echo "0";
                }
            } else {
                echo "2";
            }
        } else {
            echo "3";
        }
    } else {
        echo "4";
    }
} else if ($proc == "update") {
    $nama_menu = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $update_at = date('Y-m-d G:i:s');
    $query = "UPDATE tbl_menu SET nama_menu = '$nama_menu',stok = '$stok', harga = '$harga', update_at = '$update_at' WHERE id_menu = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
} else if ($proc == "read") {
    $query = "SELECT * FROM tbl_menu WHERE id_menu=" . $id;
    $result = mysqli_query($conn, $query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
}
