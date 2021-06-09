<!DOCTYPE html>
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

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/sb2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/sb2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/sb2/css/style_login2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/fjr/css/sweetalert.css">

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
                                        <h1 class="h4 text-gray-900 mb-4">Kopi Bukan Luwak</h1>
                                    </div>
                                    <form class="user" id="formInputLogin" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username_log" name="username_log" placeholder="Username" required="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password_log" name="password_log" placeholder="Password" required="" />
                                        </div>

                                        <input type="button" class="btn btn-primary btn-user btn-block" onclick="login()" value="Login">
                                    </form>
                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <div class="footer">
        <center>
            <p>© 2020 Kopi Bukan Luwak. All Rights Reserved</p>
        </center>
    </div>
</body>
<!-- Bootstrap core JavaScript-->
<!-- <script src="../assets/vendor/jquery/jquery.min.js"></script> -->
<script src="../assets/sb2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../assets/sb2/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../assets/js/sb-admin-2.min.js"></script>
<script type="text/javascript" src="../assets/fjr/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/fjr/js/sweetalert.all.js"></script>

<script type="text/javascript">
    function login() {
        $.ajax({
            url: "../controller/login_proses.php",
            type: "POST",
            data: $('#formInputLogin').serialize(), //serialize() untuk mengambil semua data di dalam form
            dataType: "text",
            success: function(data) {
                if (data == 1) {
                    swal({
                        title: 'Berhasil Masuk',
                        type: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then((result) => {
                        window.location = '../index.php';
                    })

                } else {
                    swal({
                        title: 'Ups...',
                        text: 'Cek Username dan Password',
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
</script>

</html>