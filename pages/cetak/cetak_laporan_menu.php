<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL);
include "../../config/dbconfig.php";
include_once '../../config/dao.php';
$dao = new Dao();
date_default_timezone_set('Asia/Jakarta');
require_once '../../vendor/autoload.php';

$conn = mysqli_connect("localhost", "root", "", "kopq_kopibukanluwak");
$hari_ini = date("d F Y", strtotime(date("Y-m-d")));
$periode = $_GET['periode'];

function convertTglInLaporan($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[0] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[2];
}

$query = mysqli_query($conn, "SELECT tbl_karyawan.nama_karyawan  
    FROM tbl_karyawan 
    INNER JOIN tbl_jabatan ON tbl_karyawan.id_jabatan = tbl_jabatan.id_jabatan
    WHERE tbl_jabatan.nama_jabatan ='Owner'");
$check = mysqli_num_rows($query);

if ($check >= 1) {
    $row = mysqli_fetch_assoc($query);
    $nama = $row['nama_karyawan'];
} else {
    $nama = '';
}

$query_total = mysqli_query($conn, "SELECT SUM(total_beli) AS grand_total
FROM tbl_transaksi
WHERE is_success ='2'");
$check_total = mysqli_num_rows($query_total);

if ($check_total >= 1) {
    $row_total = mysqli_fetch_assoc($query_total);
    $total_keseluruhan = $row_total['grand_total'];
} else {
    $total_keseluruhan = '0';
}

if ($periode == 1) {
    $ket_periode = "Semua data laporan";
}

define('K_PATH_IMAGES', '../../assets/img/');

// extend TCPF with custom functions
class MYPDF extends TCPDF
{

    // Load table data from file
    public function LoadData($con, $periode)
    {
        include_once '../../config/dao.php';
        $dao = new Dao();

        if ($periode == 1) {
            $ket_periode = "Semua data laporan";
            $result = $dao->readlaporansemuaMenu();
        }

        $list = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $list[] = $row;
        }
        return $list;
    }

    // Colored table
    public function ColoredTable($header, $data, $total_keseluruhan)
    {
        // Colors, line width and bold font
        $this->SetFillColor(204, 102, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.1);
        $this->SetFont('helvetica', '', '6');
        // Header
        $w = array(10, 35, 34, 34, 24, 26);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255, 229, 204);
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', '6');
        // Data
        $fill = 0;
        $no = 1;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $no . '.', 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['nama_menu'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['harga'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row['stok'], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, convertTglInLaporan($row['tanggal']), 'LR', 0, 'C', $fill);
            $this->Cell($w[5], 6, $row['Jam'] . ' WIB', 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
            $no++;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
        $this->SetFont('helvetica', 'B', '6');
        $this->Ln();
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator("Kopi Bukan Luwak");
$pdf->SetAuthor('Laporan');
$pdf->SetTitle('Laporan Menu');

$pdf->setHeaderData('logo2.png', 18, 'Kopi Bukan Luwak', 'Jl. Kaliurang Km 16,5 Kledokan Umbulmartani Ngemplak Sleman Yogyakarta', array(0, 0, 0), array(0, 0, 0));
$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', '8'));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', '12');

$pdf->AddPage();

// column titles
$header = array('No.', 'Nama Menu', 'Harga', 'Stok', 'Tanggal', 'Jam');

// data loading
$list = $pdf->LoadData($conn, $periode);
//print_r($list); exit;

$title = <<<EOD
  <br>
  <h5>Laporan Menu</h5>
  <h6>Periode: $ket_periode</h6>
  </br>
EOD;

$ttd = <<<EOD
    <h5>Sleman, $hari_ini <br> Mengetahui,</h5>
    <h5></h5>
    <h5></h5>
    <h5></h5>
    <h5>Owner</h5>
    <h5>($nama)</h5>
EOD;

$space = <<<EOD
  <h5></h5>
  <h5></h5>
  <h5></h5>
EOD;

$pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true);

// print colored table
$pdf->ColoredTable($header, $list, $total_keseluruhan);

$y = $pdf->getY();

$pdf->writeHTMLCell(0, 0, '', $y, $space, 0, 1, 0, true, 'C', true);
$pdf->SetFont('helvetica', '', '9');
$pdf->writeHTMLCell(300, 0, '', '', $ttd, 0, 1, 0, true, 'C', true);

$pdf->Output('Laporan_menu_' . $hari_ini . '.pdf', 'I');
