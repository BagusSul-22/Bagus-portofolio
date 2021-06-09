<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    include_once 'config/dao.php';
    $dao = new Dao();

    $periode = $_GET['periode'];

    if ($periode == 1) {
        $ket_periode = "Semua data laporan";
        $result = $dao->readlaporansemuatransaksi();
        $url = "pages/cetak/cetak_laporan_transaksi.php?periode=1";
    } else if ($periode == 2) {
        $tglhariini = date('Y-m-d');
        $tglhariinitext = date('d-m-Y');
        $ket_periode = $tglhariinitext;
        $result = $dao->readlaporanhariinitransaksi($tglhariini);
        $url = "pages/cetak/cetak_laporan_transaksi.php?periode=2";
    } else {
        $awal = $_GET['tglawal'];
        $tglawal = date('Y-m-d', strtotime($awal));

        $akhir = $_GET['tglakhir'];
        $tglakhir = date('Y-m-d', strtotime($akhir));

        $ket_periode = $awal . " sampai " . $akhir;

        $result = $dao->readlaporanpertanggaltransaksi($tglawal, $tglakhir);
        $url = "pages/cetak/cetak_laporan_transaksi.php?periode=3&tglawal=" . $tglawal . "&tglakhir=" . $tglakhir;
    }
    ?>


    <div class="col-xl mb-4 mt-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h class="h3 mb-0 text-gray-800">Laporan transaksi </h>
        </div>

        <div class="col-xl mb-4 text-right mt-4">
            <h5>Periode laporan : <span><?= $ket_periode ?></span></h5>
        </div>
        <div class="col-xl mb-4 text-right mt-4"> <a href="<?= $url ?>" target="_blank" class="btn btn-primary" role="button" title="Cetak "><i class="glyphicon glyphicon-print"></i> Cetak</a>
        </div>
        <div class="box-header" style="margin-bottom:30px">
            <!-- DataTales -->
            <div class="card shadow mb-4" id=tabel_laporan>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatablelaporan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Pesanan</th>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Jam Transaksi</th>
                                    <th>Jumlah Beli</th>
                                    <th>Modal</th>
                                    <th>Total Belanja</th>
                                    <th>Keuntungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no = $no + 1; ?></td>
                                        <td><?php echo $row['id_transaksi']; ?></td>
                                        <td><?php echo $row['nama_karyawan']; ?></td>
                                        <td><?php echo $row['tanggal_transaksi']; ?></td>
                                        <td><?php echo $row['jam_transaksi']; ?></td>
                                        <td><?php echo $row['jumlah_beli']; ?></td>
                                        <td><?php echo $row['modal_rupiah']; ?></td>
                                        <td><?php echo $row['total_beli_rupiah']; ?></td>
                                        <td><?php echo $row['keuntungan_rupiah']; ?></td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Javascript Datatable -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#laporan').DataTable();
    });
</script>