<!-- Content Wrapper. Contains page content -->
<?php

include_once "config/dbconfig.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$tglhariini = date('Y-m-d');
ini_set('display_errors', 'On');
error_reporting(E_ALL);
include_once 'config/dao.php';
$dao = new Dao();
?>

<!-- Page Heading -->
<div class="col-xl mb-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
</div>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $result = $dao->readJumlahKaryawan();
                            $rowjmlkaryawan = mysqli_fetch_array($result);
                            ?>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Karyawan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><strong><?php echo $rowjmlkaryawan['jumlah_karyawan']; ?></strong></div>
                        </div>
                        <div class="col-auto">
                            <i class="pull-left fa fa-users icon-rounded"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $result = $dao->readJumlahMenu();
                            $rowjmlmenu = mysqli_fetch_array($result);
                            ?>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Menu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><strong><?php echo $rowjmlmenu['jumlah_menu']; ?></strong></div>
                        </div>
                        <div class="col-auto">
                            <i class="pull-left fa fa-users icon-rounded"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $result = $dao->mejaKosong();
                            $rowjmlmejakosong = mysqli_fetch_array($result);
                            ?>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Meja Kosong</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><strong><?php echo $rowjmlmejakosong['jumlah_meja_kosong']; ?></strong></div>
                        </div>
                        <div class="col-auto">
                            <i class="pull-left fa fa-users icon-rounded"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Kategori Menu</div>
                            <div class="row no-gutters align-items-center">
                                <?php
                                $result = $dao->readJumlahKategoriMenu();
                                $rowjmlkategorimenu = mysqli_fetch_array($result);
                                ?>
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><strong><?php echo $rowjmlkategorimenu['jumlah_kategori_menu']; ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Content Row -->

<!-- Content Row -->