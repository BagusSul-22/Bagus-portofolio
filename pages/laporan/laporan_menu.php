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
        $ket_periode = "Semua data laporan menu";
        $result = $dao->readLaporanSemuaMenu();
        $url = "pages/cetak/cetak_laporan_menu.php?periode=1";
    }
    ?>


    <div class="col-xl mb-4 mt-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h class="h3 mb-0 text-gray-800">Laporan Menu </h>
        </div>

        <div class="col-xl mb-4 text-right mt-4">
            <h5>Laporan : <span><?= $ket_periode ?></span></h5>
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
                                    <th>Nama Menu</th>
                                    <th>Harga Menu</th>
                                    <th>Stok</th>
                                    <th>Tanggal Ubah</th>
                                    <th>Jam Ubah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no = $no + 1; ?></td>
                                        <td><?php echo $row['nama_menu']; ?></td>
                                        <td><?php echo $row['harga']; ?></td>
                                        <td><?php echo $row['stok']; ?></td>
                                        <td><?php echo $row['tanggal']; ?></td>
                                        <td><?php echo $row['Jam']; ?></td>
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