<?php
ob_start();
session_start();
include "config/dbconfig.php";
include "controller/fungsi.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (isset($_SESSION['id_karyawan']) == 0) {
  header("location:pages/login.php");
} else {
?>


  <script>
    function showModalPeriodeLaporan(ket) {
      $("#modal_title").html(ket);
      $("#periode").val("1");
      $("#tgl_group").hide();
      $("#modal_periode_laporan").modal("show");
    }
  </script>

  <script>
    function showModalLaporanMenu(ket) {
      $("#modal_title").html(ket);
      $("#periode").val("1");
      $("#modal_laporan_menu").modal("show");
    }
  </script>

  <style>
    .modal-header {
      background-color: #2196F3;
      padding: 16px 16px;
      color: #FFF;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
      border-bottom: 2px dashed #337AB7;
    }
  </style>


  <!DOCTYPE html>
  <html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kopi Bukan Luwak - Dashboard</title>


    <!--===============================================================================================================-->
    <!-- Custom fonts for this template-->
    <link href="../admin/assets/sb2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../admin/assets/sb2/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Datatables css-->
    <link href="../admin/assets/sb2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Sweetalert css -->
    <link rel="stylesheet" type="text/css" href="../admin/assets/fjr/css/sweetalert.css">
    <script src="../admin/assets/sb2/vendor/jquery/jquery.min.js"></script>
    <!--================================================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/fjr/css/jquery-ui.css" />
  </head>


  <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-utensils"></i>
          </div>
          <div class="sidebar-brand-text mx-3">Kopi Bukan Luwak</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->

        <!-- Nav Item - Pages Collapse Menu -->

        <li class="nav-item">
          <a class="nav-link collapsed" id="master" href="" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-database"></i>
            <span>Master</span>
          </a>
          <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" id="data_karyawan" href="index.php?page=data_karyawan">Data Karyawan</a>
              <a class="collapse-item" id="data_jabatan" href="index.php?page=data_jabatan">Data Jabatan</a>
              <a class="collapse-item" id="data_kategori_menu" href="index.php?page=data_kategori_menu">Data Kategori Menu</a>
              <a class="collapse-item" id="data_menu" href="index.php?page=data_menu">Data Menu</a>
              <a class="collapse-item" id="data_meja" href="index.php?page=data_meja">Data Meja</a>
            </div>
          </div>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" id="data_pesanan" href="#" data-toggle="collapse" data-target="#collapseTwo4" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-cocktail"></i>
            <span>Dapur</span>
          </a>
          <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="index.php?page=data_pesanan">Data Pesanan</a>
            </div>
          </div>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" id="data_transaksi" href="#" data-toggle="collapse" data-target="#collapseTwo6" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-money-bill-wave"></i>
            <span>Transaksi</span>
          </a>
          <div id="collapseTwo6" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="index.php?page=data_transaksi">Data Transaksi</a>
            </div>
          </div>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" id="data_laporan" href="#" data-toggle="collapse" data-target="#collapseTwo5" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-print"></i>
            <span>Laporan</span>
          </a>
          <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" onClick="showModalPeriodeLaporan('Transaksi')">Laporan Transaksi</a>
            </div>
          </div>

          <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" onClick="showModalLaporanMenu('Menu')">Laporan Menu</a>
            </div>
          </div>

        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>


              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <?php
              $idkaryawan = $_SESSION['id_karyawan'];
              $query_karyawan = "SELECT tbl_karyawan.nama_karyawan, tbl_jabatan.nama_jabatan FROM tbl_jabatan, tbl_karyawan WHERE tbl_jabatan.id_jabatan = tbl_karyawan.id_jabatan AND id_karyawan='$idkaryawan'";
              $sql_karyawan = mysqli_query($conn, $query_karyawan);
              $row = mysqli_fetch_array($sql_karyawan);
              ?>
              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row['nama_karyawan'] ?></span>
                  <img class="img-profile rounded-circle" src="../admin/img/profil.png">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    <i id="nmkaryawan"><?php echo $row['nama_karyawan'] ?></i>
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa- fa-sm fa-fw mr-2 text-gray-400"></i>
                    <i id="jabatan"><?php echo $row['nama_jabatan'] ?></i>
                  </a>
                  <a class="dropdown-item" onclick="logout()" href="#">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </a>
                </div>
              </li>
          </nav>
          <!-- End of Topbar -->


          <!-- /.container-fluid -->

          <!-- Page Heading -->
          <ul class="navbar-nav ml-auto">
            <div id="page-wrapper" style="padding: 0px 0px 0px 0px">
              <?php include "config/page.php"; ?>
            </div>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <div>
          <footer class="sticky-footer bg-white">
            <div class="container my-auto">
              <div class="copyright text-center my-auto">
                <span>Copyright &copy; Kopi Bukan Luwak 2020</span>
              </div>
            </div>
          </footer>
        </div>
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Modal Periode Laporan -->
    <div class="modal fade" id="modal_periode_laporan" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hiden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Laporan <span id="modal_title"></span></h5>
            <button style="color:#fff" class="close" type="button" data-dismiss="modal" aria-label="close">
              <span aria-hiden="true">&times;</span>
            </button>

          </div>
          <div class="modal-body">
            <form id="formInputPeriodeLaporan">
              <div class="box-body">
                <div class="form-group">
                  <label>Periode Cetak</label>
                  <select type="text" name="periode" id="periode" class="form-control">
                    <option value="1">Semua</option>
                    <option value="2">Hari ini</option>
                    <option value="3">Per tanggal</option>
                  </select>
                </div>
                <div id="tgl_group">
                  <div class="form-group">
                    <label>Tanggal Awal</label>
                    <input readonly name="tgl_awal" id="tgl_awal" type="text" placeholder="Tanggal Awal" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input readonly name="tgl_akhir" id="tgl_akhir" type="text" placeholder="Tanggal Akhir" class="form-control">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-dismiss="modal">
              Batal
            </button>
            <button class="btn btn-primary" type="button" onclick="readLaporan();">
              Tampil
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- /Modal Periode Laporan -->

    <!-- Modal Laporan Menu -->
    <div class="modal fade" id="modal_laporan_menu" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hiden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Laporan Menu<span id="modal_title"></span></h5>
            <button style="color:#fff" class="close" type="button" data-dismiss="modal" aria-label="close">
              <span aria-hiden="true">&times;</span>
            </button>

          </div>
          <div class="modal-body">
            <form id="formInputLaporanMenu">
              <div class="box-body">
                <div class="form-group">
                  <label>Cetak</label>
                  <select type="text" name="periode" id="periode" class="form-control">
                    <option value="1">Semua</option>
                  </select>
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-dismiss="modal">
              Batal
            </button>
            <button class="btn btn-primary" type="button" onclick="readLaporanMenu();">
              Tampil
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- /Modal Periode Laporan -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>


    <!--===============================================================================================================-->
    <!-- Bootstrap core JavaScript-->



    <!--===============================================================================================================-->
    <!-- Bootstrap core JavaScript-->
    <script src="../admin/assets/sb2/vendor/jquery/jquery.min.js"></script>
    <script src="../admin/assets/sb2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../admin/assets/sb2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../admin/assets/sb2/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../admin/assets/sb2/vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../admin/assets/sb2/js/demo/chart-area-demo.js"></script>
    <script src="../admin/assets/sb2/js/demo/chart-pie-demo.js"></script>
    <!-- sweetalert -->
    <script type="text/javascript" src="../admin/assets/fjr/js/sweetalert.all.js"></script>
    <!-- Page level plugins -->
    <script src="../admin/assets/sb2/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../admin/assets/sb2/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../admin/assets/sb2/js/demo/datatables-demo.js"></script>
    <script type="text/javascript" src="assets/fjr/js/jquery-ui.js"></script>
    <!--===============================================================================================================-->


    <!--===============================================================================================================-->


    <script type="text/javascript">
      var level = $("#jabatan").html();
      if (level == 'Dapur') {
        $("#data_pesanan").css({
          "display": ""
        });
        $("#master,#data_jabatan,#data_karyawan,#data_meja,#data_menu,#data_kategori_menu,#data_laporan,#data_transaksi").css({
          "display": "none"
        });
      } else if (level == 'Kasir') {
        $("#data_menu,#data_kategori_menu,#data_transaksi").css({
          "display": ""
        });
        $("#data_jabatan,#data_karyawan,#data_meja,#data_pesanan,#data_laporan").css({
          "display": "none"
        });
      } else if (level == 'Owner') {
        $("#data_jabatan,#data_karyawan,#data_meja,#data_menu,#data_kategori_menu,#data_laporan,#data_pesanan,#data_transaksi").css({
          "display": ""
        });
      }

      function logout() {
        swal({
          title: 'Anda yakin ingin logout?',
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then((result) => {
          if (result.value) {
            window.location = "controller/logout_proses.php";
          }
        })
      }

      //pemilihan periode laporan
      $("#periode").on("change", function() {

        var periode = $("#periode").val();

        if (periode == '3') {
          //menampilkan periode tanggal
          $("#tgl_group").fadeIn("slow");
        } else {
          //menyembunyikan periode tanggal
          $("#tgl_group").fadeOut("slow");
          $("#tgl_awal").val("");
          $("#tgl_akhir").val("");
        }
      })


      //tanggal awal dan tanggal akhir
      $("#tgl_awal").datepicker({
        dateFormat: 'dd-mm-yy',
        maxDate: new Date(),
        onSelect: function() {
          var tglawal = $(this).val();
          $.ajax({
            url: "controller/laporan/for_mindate_tglakhir.php",
            type: "POST",
            data: "tglawal=" + tglawal,
            dataType: "text",
            success: function(data) {
              $("#tgl_akhir").datepicker("destroy");
              $("#tgl_akhir").val("");
              $("#tgl_akhir").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: new Date(data),
                maxDate: new Date(),
              })
            }
          });
        }
      });


      function readLaporan() {

        var periode = $("#periode").val();
        var laporan = $("#modal_title").html();

        if (laporan == 'Transaksi') {
          if (periode == '3') {
            var tglawal = $("#tgl_awal").val();
            var tglakhir = $("#tgl_akhir").val();
            $.ajax({
              url: "controller/laporan/laporan_proses.php",
              type: "POST",
              data: "proc=read_pertanggal_laporan_transaksi&tgl_awal=" + tglawal + "&tgl_akhir=" + tglakhir,
              dataType: "text",
              success: function(data) {
                if (data == 1) {
                  window.location = 'index.php?page=laporan_transaksi&periode=3&tglawal=' + tglawal + '&tglakhir=' +
                    tglakhir;
                } else {
                  swal({
                    title: 'Ups...',
                    text: 'Data laporan tidak ditemukan, silahkan cek di periode tanggal lain',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                swal({
                  title: 'Ups...',
                  text: 'Cek Koneksi Anda',
                  type: 'error',
                  timer: 2000,
                  showConfirmButton: false,
                })
              }
            });
          } else if (periode == '2') {
            $.ajax({
              url: "controller/laporan/laporan_proses.php",
              type: "POST",
              data: "proc=read_hariini_laporan_transaksi",
              dataType: "text",
              success: function(data) {
                if (data == 1) {
                  window.location = 'index.php?page=laporan_transaksi&periode=2';
                } else {
                  swal({
                    title: 'Ups...',
                    text: 'Data laporan tidak ditemukan, silahkan cek di tanggal lain',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                swal({
                  title: 'Ups...',
                  text: 'Cek Koneksi Anda',
                  type: 'error',
                  timer: 2000,
                  showConfirmButton: false,
                })
              }
            });
          } else {
            $.ajax({
              url: "controller/laporan/laporan_proses.php",
              type: "POST",
              data: "proc=read_semua_laporan_transaksi",
              dataType: "text",
              success: function(data) {
                if (data == 1) {
                  window.location = 'index.php?page=laporan_transaksi&periode=1';
                } else {
                  swal({
                    title: 'Ups...',
                    text: 'Data laporan tidak ditemukan',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                setTimeout(function() {
                  swal({
                    title: 'Ups...',
                    text: 'Cek Koneksi Anda',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                  })
                });
              }
            });
          }

        }
      }

      function readLaporanMenu() {

        var periode = $("#periode").val();
        var laporan = $("#modal_title").html();

        if (laporan == 'Menu') {
          $.ajax({
            url: "controller/laporan/laporan_proses.php",
            type: "POST",
            data: "proc=read_semua_laporan_menu",
            dataType: "text",
            success: function(data) {
              if (data == 1) {
                window.location = 'index.php?page=laporan_menu&periode=1';
              } else {
                swal({
                  title: 'Ups...',
                  text: 'Data laporan tidak ditemukan',
                  type: 'error',
                  timer: 2000,
                  showConfirmButton: false,
                })
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              setTimeout(function() {
                swal({
                  title: 'Ups...',
                  text: 'Cek Koneksi Anda',
                  type: 'error',
                  timer: 2000,
                  showConfirmButton: false,
                })
              });
            }
          });
        }

      }
    </script>

  </html>
<?php } ?>