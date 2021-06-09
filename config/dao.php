<?php
include_once 'dbconfig.php';

class Dao
{
    var $link;
    public function __construct()
    {
        $this->link = new Dbconfig();
    }

    //KARYAWAN

    public function readKaryawan()
    {
        $query = "SELECT tbl_karyawan.*, tbl_jabatan.nama_jabatan FROM tbl_jabatan, tbl_karyawan 
            WHERE tbl_jabatan.id_jabatan = tbl_karyawan.id_jabatan AND tbl_karyawan.id_karyawan > '1' ORDER BY tbl_karyawan.nama_karyawan ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahKaryawan()
    {
        $query = "SELECT COUNT(id_karyawan) AS jumlah_karyawan FROM tbl_karyawan";
        return mysqli_query($this->link->conn, $query);
    }

    //JABATAN

    public function readJabatan()
    {
        $query = "SELECT * FROM tbl_jabatan ORDER BY nama_jabatan ASC";
        return mysqli_query($this->link->conn, $query);
    }

    //KATEGORI MENU

    public function readKategoriMenu()
    {
        $query = "SELECT * FROM tbl_kategori_menu ORDER BY nama_kategori_menu ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahKategoriMenu()
    {
        $query = "SELECT COUNT(id_kategori_menu) AS jumlah_kategori_menu FROM tbl_kategori_menu";
        return mysqli_query($this->link->conn, $query);
    }

    //MENU

    public function readMenu()
    {
        $query = "SELECT tbl_kategori_menu.nama_kategori_menu, tbl_menu.*, FORMAT(tbl_menu.harga, 0) AS harga_rupiah
            FROM tbl_kategori_menu, tbl_menu WHERE tbl_kategori_menu.id_kategori_menu = tbl_menu.id_kategori_menu 
            ORDER BY tbl_menu.nama_menu ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahMenu()
    {
        $query = "SELECT COUNT(id_menu) AS jumlah_menu FROM tbl_menu";
        return mysqli_query($this->link->conn, $query);
    }

    public function readMenuTerlaris()
    {
        $query = "SELECT tbl_menu.nama_menu, tbl_detail_transaksi.id_menu, SUM(tbl_detail_transaksi.jumlah) AS jumlah_terjual
            FROM tbl_menu, tbl_detail_transaksi 
            WHERE tbl_menu.id_menu = tbl_detail_transaksi.id_menu
            GROUP BY tbl_detail_transaksi.id_menu
            ORDER BY jumlah_terjual DESC
            LIMIT 1";
        return mysqli_query($this->link->conn, $query);
    }

    //MEJA
    public function readMeja()
    {
        $query = "SELECT * FROM tbl_meja ORDER BY nomor ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function mejaKosong()
    {
        $query = "SELECT COUNT(`id_meja`) AS jumlah_meja_kosong FROM tbl_meja
        WHERE status_meja='0'";
        return mysqli_query($this->link->conn, $query);
    }

    //PESANAN
    public function readPesanan()
    {
        $query = "SELECT tbl_transaksi.`id_transaksi`, tbl_meja.`nomor`, tbl_transaksi.`nama_pelanggan`,`tbl_detail_transaksi`.`total`,`tbl_transaksi`.`tbl_transaksi`STATUS
        FROM tbl_transaksi, `tbl_detail_transaksi`,`tbl_meja` 
        WHERE tbl_transaksi.id_transaksi = tbl_detail_transaksi.id_transaksi
        AND tbl_meja.id_meja = tbl_transaksi.`id_meja`
        ORDER BY tbl_transaksi.`id_transaksi` ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPesananDapur()
    {
        $query = "SELECT `tbl_transaksi`.`id_transaksi`,tbl_meja.`nomor`,`tbl_transaksi`.`jumlah_beli`, `tbl_transaksi`.`is_success`
        FROM tbl_meja
        INNER JOIN `tbl_transaksi` ON tbl_meja.`id_meja` = tbl_transaksi.`id_meja`;";
        return mysqli_query($this->link->conn, $query);
    }

    public function readNota($id_transaksi)
    {
        $query = "SELECT tbl_menu.nama_menu, tbl_detail_transaksi.jumlah, tbl_detail_transaksi.harga_menu, tbl_detail_transaksi.total FROM tbl_detail_transaksi
        INNER JOIN tbl_menu ON `tbl_menu`.`id_menu` = `tbl_detail_transaksi`.`id_menu`
        WHERE tbl_detail_transaksi.id_transaksi = '$id_transaksi'";
        return mysqli_query($this->link->conn, $query);
    }


    public function readprosesBayar()
    {
        $query = "SELECT tbl_detail_transaksi.`id_detail_transaksi`,tbl_menu.`nama_menu`,`tbl_detail_transaksi`.`jumlah`,`tbl_detail_transaksi`.`total`
        FROM tbl_menu
        INNER JOIN `tbl_detail_transaksi`
        ON `tbl_menu`.`id_menu` = tbl_detail_transaksi.`id_menu`
        WHERE tbl_detail_transaksi.id_transaksi";
        return mysqli_query($this->link->conn, $query);
    }

    //SUPPLIER

    public function readSupplier()
    {
        $query = "SELECT * FROM tb_supplier ORDER BY nama_supplier ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahSupplier()
    {
        $query = "SELECT COUNT(id_supplier) AS jumlah_supplier FROM tb_supplier";
        return mysqli_query($this->link->conn, $query);
    }

    //BARANG

    public function readBarang()
    {
        $query = "SELECT tb_barang.id_barang, tb_barang.nama_barang, tb_barang.unit, tb_barang.stok, FORMAT(tb_barang.harga, 0) AS harga, tb_barang.on_create, 
            tb_barang.on_update, tb_supplier.nama_supplier FROM tb_supplier, tb_barang WHERE tb_supplier.id_supplier = tb_barang.id_supplier 
            ORDER BY tb_barang.nama_barang ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahBarang()
    {
        $query = "SELECT COUNT(id_barang) AS jumlah_barang FROM tb_barang";
        return mysqli_query($this->link->conn, $query);
    }

    //BARANG MASUK

    public function readBarangMasuk()
    {
        $query = "SELECT id_barang_masuk, id_barang, nama_barang, DATE_FORMAT(tgl_masuk, '%d-%m-%Y') tgl_masuk, 
            unit, stok_awal, stok_masuk, 
            stok_akhir, FORMAT(harga, 0) AS harga, FORMAT(total_harga, 0) AS harga_total, on_create, 
            on_update FROM tb_barang_masuk ORDER BY tgl_masuk DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahBarangMasukHariIni($tglhariini)
    {
        $query = "SELECT COUNT(id_barang_masuk) AS jumlah_barang_masuk_hari_ini FROM tb_barang_masuk WHERE tgl_masuk = '$tglhariini'";
        return mysqli_query($this->link->conn, $query);
    }

    //BARANG KELUAR

    public function readBarangKeluar()
    {
        $query = "SELECT id_barang_keluar, id_barang, nama_barang, DATE_FORMAT(tgl_keluar, '%d-%m-%Y') tgl_keluar, 
            unit, stok_awal, stok_keluar, stok_akhir, on_create, 
            on_update FROM tb_barang_keluar ORDER BY tgl_keluar DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahBarangKeluarHariIni($tglhariini)
    {
        $query = "SELECT COUNT(id_barang_keluar) AS jumlah_barang_keluar_hari_ini FROM tb_barang_keluar WHERE tgl_keluar = '$tglhariini'";
        return mysqli_query($this->link->conn, $query);
    }

    //TRANSAKSI

    public function readTransaksi()
    {
        $query = "SELECT tbl_karyawan.nama_karyawan, tbl_transaksi.*, tbl_menu.nama_menu, tbl_detail_transaksi.*
            FROM tbl_karyawan, tbl_transaksi, tbl_menu, tbl_detail_transaksi WHERE 
            tbl_karyawan.id_karyawan = tbl_transaksi.id_karyawan AND tbl_transaksi.id_transaksi = tbl_detail_transaksi.id_transaksi 
            AND tbl_menu.id_menu = tbl_detail_transaksi.id_menu ORDER BY tbl_menu.nama_menu ASC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readTransaksiHariIni($tglhariini)
    {
        $query = "SELECT tbl_karyawan.nama_karyawan, tbl_transaksi.jam_transaksi, tbl_transaksi.jumlah_beli, FORMAT(tbl_transaksi.total_belanja, 0) AS total_belanja
            FROM tbl_karyawan, tbl_transaksi WHERE tbl_karyawan.id_karyawan = tbl_transaksi.id_karyawan AND tbl_transaksi.tgl_transaksi = '$tglhariini' 
            ORDER BY tbl_transaksi.jam_transaksi DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahTransaksi()
    {
        $query = "SELECT COUNT(id_transaksi) AS jumlah_transaksi FROM tbl_transaksi";
        return mysqli_query($this->link->conn, $query);
    }

    public function readJumlahTransaksiHariIni($tglhariini)
    {
        $query = "SELECT COUNT(id_transaksi) AS jumlah_transaksi_hari_ini FROM tbl_transaksi WHERE tgl_transaksi = '$tglhariini'";
        return mysqli_query($this->link->conn, $query);
    }

    //LAPORAN TRANSAKSI

    public function readLaporanSemuaTransaksi()
    {
        $query = "SELECT id_transaksi, id_transaksi AS id_transaksi_param, id_karyawan, nama_karyawan, DATE_FORMAT(`create_at`, '%d-%m-%Y') tanggal_transaksi,  TIME_FORMAT(`create_at`, '%H:%i') jam_transaksi,
                jumlah_beli, 
                FORMAT((SELECT SUM(tbl_menu.modal*tbl_detail_transaksi.jumlah) AS modal
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param),0) AS modal_rupiah,
                FORMAT(total_beli, 0) AS total_beli_rupiah,
                FORMAT((SELECT SUM(tbl_detail_transaksi.total-(tbl_menu.modal*tbl_detail_transaksi.jumlah)) AS keuntungan
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param),0) AS keuntungan_rupiah,
                (SELECT SUM(tbl_menu.modal*tbl_detail_transaksi.jumlah) AS modal
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param) AS modal,
                total_beli,
                (SELECT SUM(tbl_detail_transaksi.total-(tbl_menu.modal*tbl_detail_transaksi.jumlah)) AS keuntungan
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param) AS keuntungan
            FROM tbl_transaksi
            WHERE is_success = '2' 
            ORDER BY `create_at` DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readLaporanSemuaMenu()
    {
        $query = "SELECT tbl_menu.`nama_menu`,`tbl_menu`.`harga`,`tbl_menu`.`stok`,
        DATE_FORMAT(`tbl_menu`.`update_at`,'%d-%m-%Y') AS tanggal,
        TIME_FORMAT(`tbl_menu`.`update_at`,'%H:%i') AS Jam
        FROM tbl_menu
        ORDER BY `update_at` DESC";
        return mysqli_query($this->link->conn, $query);
    }


    public function readLaporanHariIniTransaksi($tglhariini)
    {
        $query = "SELECT id_transaksi, id_transaksi AS id_transaksi_param, id_karyawan, nama_karyawan, DATE_FORMAT(`create_at`, '%d-%m-%Y') tanggal_transaksi,  TIME_FORMAT(`create_at`, '%H:%i') jam_transaksi,
            jumlah_beli, 
            FORMAT((SELECT SUM(tbl_menu.modal*tbl_detail_transaksi.jumlah) AS modal
                FROM tbl_menu
                INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param),0) AS modal_rupiah,
            FORMAT(total_beli, 0) AS total_beli_rupiah,
            FORMAT((SELECT SUM(tbl_detail_transaksi.total-(tbl_menu.modal*tbl_detail_transaksi.jumlah)) AS keuntungan
                FROM tbl_menu
                INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param),0) AS keuntungan_rupiah,
            (SELECT SUM(tbl_menu.modal*tbl_detail_transaksi.jumlah) AS modal
                FROM tbl_menu
                INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param) AS modal,
            total_beli,
            (SELECT SUM(tbl_detail_transaksi.total-(tbl_menu.modal*tbl_detail_transaksi.jumlah)) AS keuntungan
                FROM tbl_menu
                INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param) AS keuntungan
        FROM tbl_transaksi
        WHERE DATE_FORMAT(create_at,'%Y-%m-%d')='$tglhariini'
        AND is_success = '2' 
        ORDER BY `create_at` DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readLaporanPerTanggalTransaksi($tglawal, $tglakhir)
    {
        $query = "SELECT id_transaksi, id_transaksi AS id_transaksi_param, id_karyawan, nama_karyawan, DATE_FORMAT(`create_at`, '%d-%m-%Y') tanggal_transaksi,  TIME_FORMAT(`create_at`, '%H:%i') jam_transaksi,
                jumlah_beli, 
                FORMAT((SELECT SUM(tbl_menu.modal*tbl_detail_transaksi.jumlah) AS modal
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param),0) AS modal_rupiah,
                FORMAT(total_beli, 0) AS total_beli_rupiah,
                FORMAT((SELECT SUM(tbl_detail_transaksi.total-(tbl_menu.modal*tbl_detail_transaksi.jumlah)) AS keuntungan
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param),0) AS keuntungan_rupiah,
                (SELECT SUM(tbl_menu.modal*tbl_detail_transaksi.jumlah) AS modal
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param) AS modal,
                total_beli,
                (SELECT SUM(tbl_detail_transaksi.total-(tbl_menu.modal*tbl_detail_transaksi.jumlah)) AS keuntungan
                    FROM tbl_menu
                    INNER JOIN tbl_detail_transaksi ON tbl_menu.id_menu = tbl_detail_transaksi.id_menu
                    WHERE tbl_detail_transaksi.id_transaksi = id_transaksi_param) AS keuntungan
            FROM tbl_transaksi
            WHERE DATE_FORMAT(create_at,'%Y-%m-%d') BETWEEN '$tglawal' AND '$tglakhir' 
            AND is_success = '2' 
            ORDER BY `create_at` DESC";
        return mysqli_query($this->link->conn, $query);
    }

    //MUTASI BARANG MASUK

    public function readMutasiSemuaBarangMasuk()
    {
        $query = "SELECT id_barang, nama_barang, DATE_FORMAT(tgl_masuk, '%d-%m-%Y') tgl_masuk, 
            unit, stok_awal, stok_masuk, 
            stok_akhir, FORMAT(harga, 0) AS harga, FORMAT(total_harga, 0) AS harga_total 
            FROM tb_barang_masuk ORDER BY tgl_masuk DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readMutasiHariIniBarangMasuk($tglhariini)
    {
        $query = "SELECT id_barang, nama_barang, DATE_FORMAT(tgl_masuk, '%d-%m-%Y') tgl_masuk, 
            unit, stok_awal, stok_masuk, 
            stok_akhir, FORMAT(harga, 0) AS harga, FORMAT(total_harga, 0) AS harga_total 
            FROM tb_barang_masuk WHERE tgl_masuk = '$tglhariini' ORDER BY tgl_masuk DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readMutasiPerTanggalBarangMasuk($tglawal, $tglakhir)
    {
        $query = "SELECT id_barang, nama_barang, DATE_FORMAT(tgl_masuk, '%d-%m-%Y') tgl_masuk, 
            unit, stok_awal, stok_masuk, 
            stok_akhir, FORMAT(harga, 0) AS harga, FORMAT(total_harga, 0) AS harga_total 
            FROM tb_barang_masuk WHERE tgl_masuk >= '$tglawal' AND tgl_masuk <= '$tglakhir' ORDER BY tgl_masuk DESC";
        return mysqli_query($this->link->conn, $query);
    }

    //MUTASI BARANG KELUAR

    public function readMutasiSemuaBarangKeluar()
    {
        $query = "SELECT id_barang, nama_barang, DATE_FORMAT(tgl_keluar, '%d-%m-%Y') tgl_keluar, 
            unit, stok_awal, stok_keluar, 
            stok_akhir FROM tb_barang_keluar ORDER BY tgl_keluar DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readMutasiHariIniBarangKeluar($tglhariini)
    {
        $query = "SELECT id_barang, nama_barang, DATE_FORMAT(tgl_keluar, '%d-%m-%Y') tgl_keluar, 
            unit, stok_awal, stok_keluar, 
            stok_akhir FROM tb_barang_keluar WHERE tgl_keluar = '$tglhariini' ORDER BY tgl_keluar DESC";
        return mysqli_query($this->link->conn, $query);
    }

    public function readMutasiPerTanggalBarangKeluar($tglawal, $tglakhir)
    {
        $query = "SELECT id_barang, nama_barang, DATE_FORMAT(tgl_keluar, '%d-%m-%Y') tgl_keluar, 
            unit, stok_awal, stok_keluar, 
            stok_akhir FROM tb_barang, tb_barang_keluar WHERE tgl_keluar >= '$tglawal' AND tgl_keluar <= '$tglakhir' ORDER BY tgl_keluar DESC";
        return mysqli_query($this->link->conn, $query);
    }

    //UNTUK GRAFIK JUMLAH PENGUNJUNG

    public function readPengunjungHarian()
    {
        $query = "SELECT DATE_FORMAT(tgl_transaksi, '%d-%m-%Y') tanggal, 
                SUM(jumlah_pengunjung) AS jumlah_pengunjung
            FROM
                (
                SELECT tgl_transaksi, COUNT(id_transaksi) AS jumlah_pengunjung
                FROM tb_transaksi
                WHERE tgl_transaksi BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 DAY) AND CURDATE()
                GROUP BY tgl_transaksi
                UNION ALL
                SELECT CURDATE(), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -1 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -2 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -3 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -4 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -5 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -6 DAY), 0
                ) X
            GROUP BY tgl_transaksi
            ORDER BY DATE(tgl_transaksi) DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPengunjungMingguan()
    {
        $query = "SELECT year_week, 
                YEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS tahun,
                WEEKOFYEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS minggu_ke, 
                SUM(jumlah_pengunjung) AS jumlah_pengunjung
            FROM
                (
                SELECT YEARWEEK(tgl_transaksi, 3) AS year_week, COUNT(id_transaksi) AS jumlah_pengunjung
                FROM tb_transaksi
                GROUP BY YEARWEEK(tgl_transaksi, 3)
                UNION ALL
                SELECT YEARWEEK(CURDATE(), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -1 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -2 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -3 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -4 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -5 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -6 WEEK), 3), 0
                ) X
            GROUP BY year_week
            ORDER BY year_week DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPengunjungBulanan()
    {
        $query = "SELECT tahun, 
                bulan, 
                SUM(jumlah_pengunjung) AS jumlah_pengunjung
            FROM
                (
                SELECT MONTH(tgl_transaksi) AS bulan, COUNT(id_transaksi) AS jumlah_pengunjung, YEAR(tgl_transaksi) AS tahun
                FROM tb_transaksi
                GROUP BY MONTH(tgl_transaksi)
                UNION ALL
                SELECT MONTH(CURDATE()), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -1 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -2 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -3 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -4 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -5 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -6 MONTH)), 0, YEAR(CURDATE())
                ) X
            GROUP BY bulan
            ORDER BY bulan DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    //UNTUK GRAFIK PENDAPATAN

    public function readPendapatanHarian()
    {
        $query = "SELECT DATE_FORMAT(tgl_transaksi, '%d-%m-%Y') tanggal, 
                SUM(pendapatan) AS pendapatan
            FROM
                (
                SELECT tgl_transaksi, SUM(total_belanja) AS pendapatan
                FROM tb_transaksi
                WHERE tgl_transaksi BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 DAY) AND CURDATE()
                GROUP BY tgl_transaksi
                UNION ALL
                SELECT CURDATE(), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -1 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -2 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -3 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -4 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -5 DAY), 0
                UNION ALL
                SELECT DATE_ADD(CURDATE(), INTERVAL -6 DAY), 0
                ) X
            GROUP BY tgl_transaksi
            ORDER BY 
                CAST(YEAR(tgl_transaksi) AS UNSIGNED),
                CAST(MONTH(tgl_transaksi) AS UNSIGNED),
                CAST(DAY(tgl_transaksi) AS UNSIGNED)
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPendapatanMingguan()
    {
        $query = "SELECT year_week, 
                YEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS tahun,
                WEEKOFYEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS minggu_ke, 
                SUM(pendapatan) AS pendapatan
            FROM
                (
                SELECT YEARWEEK(tgl_transaksi, 3) AS year_week, SUM(total_belanja) AS pendapatan
                FROM tb_transaksi
                GROUP BY YEARWEEK(tgl_transaksi, 3)
                UNION ALL
                SELECT YEARWEEK(CURDATE(), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -1 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -2 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -3 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -4 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -5 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -6 WEEK), 3), 0
                ) X
            GROUP BY year_week
            ORDER BY year_week DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPendapatanBulanan()
    {
        $query = "SELECT tahun, 
                bulan, 
                SUM(pendapatan) AS pendapatan
            FROM
                (
                SELECT MONTH(tgl_transaksi) AS bulan, SUM(total_belanja) AS pendapatan, YEAR(tgl_transaksi) AS tahun
                FROM tb_transaksi
                GROUP BY MONTH(tgl_transaksi)
                UNION ALL
                SELECT MONTH(CURDATE()), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -1 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -2 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -3 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -4 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -5 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -6 MONTH)), 0, YEAR(CURDATE())
                ) X
            GROUP BY bulan
            ORDER BY bulan DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    //UNTUK GRAFIK PENGELUARAN DAN PEMASUKAN

    public function readPengeluaranMingguan()
    {
        $query = "SELECT year_week, 
                YEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS tahun,
                WEEKOFYEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS minggu_ke, 
                SUM(pengeluaran) AS pengeluaran
            FROM
                (
                SELECT YEARWEEK(tgl_masuk, 3) AS year_week, SUM(total_harga) AS pengeluaran
                FROM tb_barang_masuk
                GROUP BY YEARWEEK(tgl_masuk, 3)
                UNION ALL
                SELECT YEARWEEK(CURDATE(), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -1 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -2 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -3 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -4 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -5 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -6 WEEK), 3), 0
                ) X
            GROUP BY year_week
            ORDER BY year_week DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPemasukanMingguan()
    {
        $query = "SELECT year_week, 
                YEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS tahun,
                WEEKOFYEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS minggu_ke, 
                SUM(pemasukan) AS pemasukan
            FROM
                (
                SELECT YEARWEEK(tgl_transaksi, 3) AS year_week, SUM(total_belanja) AS pemasukan
                FROM tb_transaksi
                GROUP BY YEARWEEK(tgl_transaksi, 3)
                UNION ALL
                SELECT YEARWEEK(CURDATE(), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -1 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -2 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -3 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -4 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -5 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -6 WEEK), 3), 0
                ) X
            GROUP BY year_week
            ORDER BY year_week DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPengeluaranBulanan()
    {
        $query = "SELECT tahun, 
                bulan, 
                SUM(pengeluaran) AS pengeluaran
            FROM
                (
                SELECT MONTH(tgl_masuk) AS bulan, SUM(total_harga) AS pengeluaran, YEAR(tgl_masuk) AS tahun
                FROM tb_barang_masuk
                GROUP BY MONTH(tgl_masuk)
                UNION ALL
                SELECT MONTH(CURDATE()), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -1 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -2 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -3 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -4 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -5 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -6 MONTH)), 0, YEAR(CURDATE())
                ) X
            GROUP BY bulan
            ORDER BY bulan DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readPemasukanBulanan()
    {
        $query = "SELECT tahun, 
                bulan, 
                SUM(pemasukan) AS pemasukan
            FROM
                (
                SELECT MONTH(tgl_transaksi) AS bulan, SUM(total_belanja) AS pemasukan, YEAR(tgl_transaksi) AS tahun
                FROM tb_transaksi
                GROUP BY MONTH(tgl_transaksi)
                UNION ALL
                SELECT MONTH(CURDATE()), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -1 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -2 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -3 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -4 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -5 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -6 MONTH)), 0, YEAR(CURDATE())
                ) X
            GROUP BY bulan
            ORDER BY bulan DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    //UNTUK GRAFIK BARANG MASUK DAN BARANG KELUAR

    public function readBarangMasukMingguan()
    {
        $query = "SELECT year_week, 
                YEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS tahun,
                WEEKOFYEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS minggu_ke, 
                SUM(jumlah_barang_masuk) AS jumlah_barang_masuk
            FROM
                (
                SELECT YEARWEEK(tgl_masuk, 3) AS year_week, SUM(stok_masuk) AS jumlah_barang_masuk
                FROM tb_barang_masuk
                GROUP BY YEARWEEK(tgl_masuk, 3)
                UNION ALL
                SELECT YEARWEEK(CURDATE(), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -1 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -2 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -3 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -4 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -5 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -6 WEEK), 3), 0
                ) X
            GROUP BY year_week
            ORDER BY year_week DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readBarangKeluarMingguan()
    {
        $query = "SELECT year_week, 
                YEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS tahun,
                WEEKOFYEAR(STR_TO_DATE(CONCAT(year_week,' Monday'), '%x%v %W')) AS minggu_ke, 
                SUM(jumlah_barang_keluar) AS jumlah_barang_keluar
            FROM
                (
                SELECT YEARWEEK(tgl_keluar, 3) AS year_week, SUM(stok_keluar) AS jumlah_barang_keluar
                FROM tb_barang_keluar
                GROUP BY YEARWEEK(tgl_keluar, 3)
                UNION ALL
                SELECT YEARWEEK(CURDATE(), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -1 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -2 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -3 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -4 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -5 WEEK), 3), 0
                UNION ALL
                SELECT YEARWEEK(DATE_ADD(CURDATE(), INTERVAL -6 WEEK), 3), 0
                ) X
            GROUP BY year_week
            ORDER BY year_week DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readBarangMasukBulanan()
    {
        $query = "SELECT tahun, 
                bulan, 
                SUM(jumlah_barang_masuk) AS jumlah_barang_masuk
            FROM
                (
                SELECT MONTH(tgl_masuk) AS bulan, SUM(stok_masuk) AS jumlah_barang_masuk, YEAR(tgl_masuk) AS tahun
                FROM tb_barang_masuk
                GROUP BY MONTH(tgl_masuk)
                UNION ALL
                SELECT MONTH(CURDATE()), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -1 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -2 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -3 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -4 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -5 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -6 MONTH)), 0, YEAR(CURDATE())
                ) X
            GROUP BY bulan
            ORDER BY bulan DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }

    public function readBarangKeluarBulanan()
    {
        $query = "SELECT tahun, bulan, SUM(jumlah_barang_keluar) AS jumlah_barang_keluar
            FROM
                (
                SELECT MONTH(tgl_keluar) AS bulan, SUM(stok_keluar) AS jumlah_barang_keluar, YEAR(tgl_keluar) AS tahun
                FROM tb_barang_keluar
                GROUP BY MONTH(tgl_keluar)
                UNION ALL
                SELECT MONTH(CURDATE()), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -1 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -2 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -3 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -4 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -5 MONTH)), 0, YEAR(CURDATE())
                UNION ALL
                SELECT MONTH(DATE_ADD(CURDATE(), INTERVAL -6 MONTH)), 0, YEAR(CURDATE())
                ) X
            GROUP BY bulan
            ORDER BY bulan DESC
            LIMIT 7";
        return mysqli_query($this->link->conn, $query);
    }
}
