<html>

<head>
    <title>Kopi Bukan Luwak - Login</title>
    <link rel="shortcut icon" href="../images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Couvee AD" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/css/style_login2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/sweetalert.css">


</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>

                                    </div>
                                    <form class="user" method="post">
                                        <form id="formInputKaryawan">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="nama_log" name="nama_log" placeholder="Nama Lengkap">

                                            </div>

                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="alamat_log" name="alamat_log" placeholder="Alamat">

                                            </div>

                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="nohp_log" name="nohp_log" placeholder="Nomor Handphone">

                                            </div>

                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="idjabatan_log" name="idjabatan_log" placeholder="Id Jabatan">

                                            </div>

                                            <hr>

                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="username_log" name="username_log" placeholder="Username" value="">

                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                                </div>
                                        </form>

                                        <button type="submit" onclick="inputData()" class="btn btn-primary btn-user btn-block">
                                            Register
                                        </button>


                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="login.php">Sudah punya akun? Coba Login</a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer">
            <p>© 2020 Kopi Bukan Luwak. All Rights Reserved</p>
        </div>
</body>
<!-- Bootstrap core JavaScript-->
<!-- <script src="../assets/vendor/jquery/jquery.min.js"></script> -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../assets/js/sb-admin-2.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/sweetalert.all.js"></script>
<script type="text/javascript">
    function inputData() {
        var valid = true;
        $("#formInputKaryawan").find(".textbox").each(function() {
            if (!$(this).val()) {
                get_error_text(this);
                valid = false;
                swal({
                    title: 'Ups...',
                    text: 'Semua kolom harus terisi',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                })
            }
            if ($(this).hasClass("no-valid")) {
                valid = false;
                swal({
                    title: 'Ups...',
                    text: 'Isi semua kolom dengan benar',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                })
            }
        });
        if (valid) {
            var jabatan = $("#jabatan").val();
            if (jabatan == 'Pilih Jabatan') {
                swal({
                    title: 'Ups...',
                    text: 'Pilih jabatan terlebih dahulu',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                })
            } else {
                swal({
                    title: 'Anda yakin ingin menyimpan data?',
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "controller/karyawan/karyawan_proses.php",
                            type: "POST",
                            data: $("#formInputKaryawan").serialize(),
                            cache: false,
                            dataType: "text",
                            success: function(data) {
                                if (data == 1) {
                                    swal({
                                        title: 'Berhasil Simpan',
                                        type: 'success',
                                        timer: 2000,
                                        showConfirmButton: false,
                                    }).then((result) => {
                                        window.location = 'index.php?page=data_karyawan';
                                    })
                                } else {
                                    swal({
                                        title: 'Ups...',
                                        text: 'Sepertinya ada yang bermasalah',
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
                    }
                })
            }
        }
    }
</script>




</html>