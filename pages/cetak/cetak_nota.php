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
$id_transaksi = $_GET['id'];
$bayar = $_GET['bayar'];
$kembali = $_GET['kembali'];
$karyawan = $_SESSION['nama_karyawan'];

$query_data = mysqli_query($conn, "SELECT `tbl_transaksi`.`nama_karyawan`,`tbl_transaksi`.`nama_pelanggan`,`tbl_meja`.`nomor`,
DATE_FORMAT(`tbl_transaksi`.`create_at`,'%d-%m-%Y') AS tgl_transaksi,
TIME_FORMAT(`tbl_transaksi`.`create_at`,'%H:%i') AS jam_transaksi
FROM `tbl_transaksi`
INNER JOIN tbl_meja ON tbl_transaksi.`id_meja` = `tbl_meja`.`id_meja`
WHERE id_transaksi ='$id_transaksi'");
$check_data = mysqli_num_rows($query_data);

if ($check_data >= 1) {
    $row_data = mysqli_fetch_assoc($query_data);
    $kasir = $row_data['nama_karyawan'];
    $plg = $row_data['nama_pelanggan'];
    $meja = $row_data['nomor'];
    $tgl = $row_data['tgl_transaksi'];
    $jam = $row_data['jam_transaksi'];
} else {
    $kasir = '-';
    $plg = '-';
    $meja = '-';
    $tgl = '-';
    $jam = '-';
}

define('K_PATH_IMAGES', '../../assets/img/');

// extend TCPF with custom functions
class MYPDF extends TCPDF
{

    // Load table data from file
    public function LoadData($con, $id_transaksi)
    {
        include_once '../../config/dao.php';
        $dao = new Dao();
        $result = $dao->readNota($id_transaksi);
        $list = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $list[] = $row;
        }
        return $list;
    }

    // Colored table
    public function ColoredTable($data, $bayar, $kembali)
    {
        // Color and font restoration
        $this->SetFillColor(255, 229, 204);
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', '6');
        // Data
        $total = 0;

        foreach ($data as $row) {
            $this->Cell(70, 3, $row['nama_menu'], 0, 0, 'L', 0);
            $this->Ln();
            $this->Cell(50, 3, $row['jumlah'] . 'x' . $row['harga_menu'], 0, 0, 'L', 0);
            $this->Cell(20, 3, $row['total'], 0, 0, 'R', 0);
            $this->Ln();
            $total += $row['total'];
        }
        $this->Ln();
        $this->SetFont('helvetica', '', '6');
        $this->Cell(50, 3, '', 0, 0, 'C', 0);
        $this->Cell(20, 3, 'Total : ' . $total, 0, 0, 'R', 0);
        $this->Ln();
        $this->Cell(50, 3, '', 0, 0, 'C', 0);
        $this->Cell(20, 3, 'Bayar Tunai : ' . $bayar, 0, 0, 'R', 0);
        $this->Ln();
        $this->Cell(50, 3, '', 0, 0, 'C', 0);
        $this->Cell(20, 3, 'Kembali : ' . $kembali, 0, 0, 'R', 0);
        $this->Ln();
    }
}

// create new PDF document
$pdf = new MYPDF('L', 'mm', array('100', '100'), true, 'UTF-8', false);

$pdf->SetCreator("Kopi Bukan Luwak");
$pdf->SetAuthor('Nota');
$pdf->SetTitle('Nota');

$pdf->setHeaderData('', 0, 'Kopi Bukan Luwak', 'JL.Kaliurang Km 16,5 Kledokan Umbulmartani Ngemplak Sleman Yogyakarta', array(0, 0, 0), array(0, 0, 0));
$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', '8'));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', '6');

$pdf->AddPage();

// data loading
$list = $pdf->LoadData($conn, $id_transaksi);

$title = <<<EOD
  <h5>NOTA</h5>
EOD;

$pdf->writeHTMLCell(0, 5, '', '', $title, 0, 1, 0, true, 'C', true);
$pdf->Cell(70, 3, 'No Pesanan: ' . $id_transaksi, 0, 0, 'L', 0);
$pdf->Ln();
$pdf->Cell(70, 3, 'Pelanggan: ' . $plg, 0, 0, 'L', 0);
$pdf->Ln();
$pdf->Cell(70, 3, 'Kasir: ' . $kasir, 0, 0, 'L', 0);
$pdf->Ln();
$pdf->Cell(70, 3, 'Tanggal: ' . $tgl . ' ' . $jam, 0, 0, 'L', 0);
$pdf->Ln();
$pdf->Cell(70, 2, '---------------------------------------------------------------------------------------------------', 0, 0, 'C', 0);
$pdf->Ln();

// print colored table
$pdf->ColoredTable($list, $bayar, $kembali);

$y = $pdf->getY();

// $pdf->writeHTMLCell(0, 0, '', $y, $space, 0, 1, 0, true, 'C', true);
$pdf->SetFont('helvetica', 'B', '6');
$pdf->Cell(70, 2, '---------------------------------------------------------------------------------------------------', 0, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(70, 10, 'Terima kasih atas kunjungan anda', 0, 0, 'C', 0);
$pdf->Ln();

$pdf->Output('Nota_' . $hari_ini . '.pdf', 'I');
