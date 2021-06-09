<?php
if (isset($_GET['page'])) {
  $page = $_GET['page'];
  switch ($page) {
      //karyawan
    case 'data_karyawan':
      include 'pages/karyawan/data_karyawan.php';
      break;

      //jabatan
    case 'data_jabatan':
      include 'pages/jabatan/data_jabatan.php';
      break;

      //meja
    case 'data_meja':
      include 'pages/meja/data_meja.php';
      break;

      //kategori menu
    case 'data_kategori_menu':
      include 'pages/kategori menu/data_kategori_menu.php';
      break;

      //menu
    case 'data_menu':
      include 'pages/menu/data_menu.php';
      break;

      //pesanan
    case 'data_pesanan':
      include 'pages/pesanan/data_pesanan.php';
      break;

      //barang
    case 'data_transaksi':
      include 'pages/transaksi/data_transaksi.php';
      break;

      //barang masuk
    case 'data_barang_masuk':
      include 'pages/barang masuk/data_barang_masuk.php';
      break;

      //barang keluar
    case 'data_barang_keluar':
      include 'pages/barang keluar/data_barang_keluar.php';
      break;

      //laporan transaksi
    case 'laporan_transaksi':
      include 'pages/laporan/laporan_transaksi.php';
      break;

      //laporan transaksi
    case 'laporan_menu':
      include 'pages/laporan/laporan_menu.php';
      break;

      //mutasi barang masuk
    case 'mutasi_barang_masuk':
      include 'pages/laporan/mutasi_barang_masuk.php';
      break;

      //mutasi barang keluar
    case 'mutasi_barang_keluar':
      include 'pages/laporan/mutasi_barang_keluar.php';
      break;
  }
} else {
  include "pages/beranda.php";
}
