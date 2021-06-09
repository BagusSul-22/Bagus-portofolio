<script>
    function showModalKaryawanInsert() {
        refreshModal();
        get_jabatan();
        $("#modal_title").html("Tambah karyawan");
        $("#id").val("");
        $("#proc").val("insert");
        $("#username").val("");
        $("#password").val("");
        $("#confirm_password").val("");
        $("#nama").val("");
        $("#ttl").val("");
        $("#alamat").val("");
        $("#no_hp").val("");
        $("#username_group").show();
        $("#password_group").show();
        $("#jabatan_group").show();
        $("#confirm_password_group").show();
        $("#modal_karyawan").modal("show");
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
</style><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="col-xl mb-4 mt-4">
        <!-- Content Header (Page header) -->
        <!-- <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">DATA KARYAWAN</li>
        </ol>
    </section> -->
        <div class="col-xl mb-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h class="h3 mb-0 text-gray-800">Data Karyawan</h>
            </div>
        </div>
        <div class="box-header" style="margin-bottom:30px">

            <!-- DataTales -->
            <div class="card shadow mb-4">
                <div class="col-xl mb-4 mt-4">
                    <button onClick="showModalKaryawanInsert()" class="btn btn-primary" role="button" title="Tambah "><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Handphone</th>
                                    <th>Jabatan</th>
                                    <th>Create</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                ini_set('display_errors', 'On');
                                error_reporting(E_ALL);
                                include_once 'config/dao.php';
                                $dao = new Dao();
                                $result = $dao->readKaryawan();
                                $no = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no = $no + 1; ?></td>
                                        <td><?php echo $row['username_karyawan']; ?></td>
                                        <td><?php echo $row['nama_karyawan']; ?></td>
                                        <td><?php echo $row['alamat_karyawan']; ?></td>
                                        <td><?php echo $row['no_hp_karyawan']; ?></td>
                                        <td><?php echo $row['nama_jabatan']; ?></td>
                                        <td><?php echo $row['create_at']; ?></td>
                                        <td><?php echo $row['update_at']; ?></td>
                                        <td style="text-align:center">
                                            <?php
                                            $jabatan = $row['nama_jabatan'];
                                            if ($jabatan == "Owner") {
                                            ?>
                                                <button class="btn btn-info btn-circle btn-sm" role="button" onclick="updateData('<?php echo $row['id_karyawan']; ?>')" title="Ubah Data"><i class="fas fa-info-circle"></i></button>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-info btn-circle btn-sm" role="button" onclick="updateData('<?php echo $row['id_karyawan']; ?>')" title="Ubah Data"><i class="fas fa-info-circle"></i></button>
                                                <button class="btn btn-danger btn-circle btn-sm" role="button" onclick="deleteData('<?php echo $row['id_karyawan']; ?>','<?php echo $row['nama_karyawan']; ?>')" title="Hapus Data"><i class="fas fa-trash"></i></button>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
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
</div>
<!-- /.content-wrapper -->
<!-- Modal Karyawan -->
<div class="modal fade" id="modal_karyawan" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hiden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button style="color:#fff" class="close" type="button" data-dismiss="modal" aria-label="close">
                    <span aria-hiden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formInputKaryawan">
                    <div class="box-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="proc" id="proc">
                        <div class="form-group has-feedback" id="username_group">
                            <label>Username</label>
                            <input type="text" name="username" id="username" class="form-control textbox" placeholder="Masukkan Username" maxlength="20">
                            <h6 class="text-warning"></h6>
                        </div>
                        <div class="form-group has-feedback" id="password_group">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control textbox" placeholder="Masukkan Password (minimal 8 karakter)" minlength="8" maxlength="35">
                            <h6 class="text-warning"></h6>
                        </div>
                        <div class="form-group has-feedback" id="confirm_password_group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control textbox" maxlength="35" placeholder="Masukkan Confirm Password">
                            <h6 class="text-warning"></h6>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control textbox" placeholder="Masukkan Nama Lengkap" maxlength="50">
                            <h6 class="text-warning"></h6>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Tanggal lahir</label>
                            <input type="text" name="ttl" id="ttl" class="form-control textbox" placeholder="Masukkan Tanggal lahir" maxlength="50">
                            <h6 class="text-warning"></h6>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Alamat</label>
                            <textarea type="text" name="alamat" id="alamat" class="form-control textbox" placeholder="Masukkan Alamat" maxlength="300"></textarea>
                            <h6 class="text-warning"></h6>
                        </div>
                        <div class="form-group has-feedback">
                            <label>No. Handphone</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control textbox" placeholder="Masukkan No. Handphone" onkeypress="return inputAngka(event)" minlength="10" maxlength="16">
                            <h6 class="text-warning"></h6>
                        </div>
                        <div class="form-group" style="margin-top:20px" id="jabatan_group">
                            <label>Jabatan</label>
                            <select type="text" name="cb_jabatan" id="cb_jabatan" class="form-control">
                                <option value="">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-primary" type="button" onclick="inputData();">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Karyawan -->
<!-- Javascript Datatable -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#dataTablekaryawan").DataTable();
    });

    //semua element dengan class text-warning akan di sembunyikan saat load
    $(".text-warning").hide();
    //untuk mengecek bahwa semua textbox tidak boleh kosong
    $("input,textarea").each(function() {
        $(this).blur(function() { //blur function itu dijalankan saat element kehilangan fokus
            if (!$(this).val()) { //this mengacu pada text box yang sedang fokus
                return get_error_text(this); //function get_error_text ada di bawah
            } else {
                $(this).removeClass("no-valid");
                $(this).parent().find(".text-warning").hide(); //cari element dengan class has-warning dari element induk text yang sedang focus
            }
        });
    });

    //mengecek textbox Nama Valid Atau Tidak
    $("#nama").blur(function() {
        var nama = $(this).val();
        var len = nama.length;
        if (len > 0) { //jika ada isinya
            if (!valid_nama(nama)) { //jika nama tidak valid
                $(this).parent().find(".text-warning").text("");
                $(this).parent().find(".text-warning").text("Nama Tidak Valid");
                return apply_feedback_error(this);
            } else {
                if (len > 50) { //jika karakter >30
                    $(this).parent().find(".text-warning").text("");
                    $(this).parent().find(".text-warning").text("Maximal Karakter 50");
                    return apply_feedback_error(this);
                }
            }
        }
    });

    //mengecek text box username
    $("#username").blur(function() {
        var username = $(this).val();
        var len = username.length;
        if (len > 0) {
            if (len > 20) {
                $(this).parent().find(".text-warning").text("");
                $(this).parent().find(".text-warning").text("Maximal Karakter 20");
                return apply_feedback_error(this);
            } else {
                $.ajax({
                    url: "controller/karyawan/cek_username.php",
                    type: "POST",
                    data: "username=" + username,
                    dataType: "text",
                    success: function(data) {
                        if (data == 0) { //pada file cek_email.php, apabila email sudah ada di database makan akan mengembalikan nilai 0
                            $("#username").parent().find(".text-warning").text("");
                            $("#username").parent().find(".text-warning").text("username sudah ada");
                            return apply_feedback_error("#username");
                        }
                    }
                });
            }
        }
    });

    //mengecek password
    $("#password").blur(function() {
        var password = $(this).val();
        var len = password.length;
        if (len > 0 && len < 8) {
            $(this).parent().find(".text-warning").text("");
            $(this).parent().find(".text-warning").text("password minimal 8 karakter");
            return apply_feedback_error(this);
        }
    });

    //mengecek alamat
    $("#alamat").blur(function() {
        var alamat = $(this).val();
        var len = alamat.length;
        if (len > 0 && len < 10) {
            $(this).parent().find('.text-warning').text("");
            $(this).parent().find('.text-warning').text("isilah alamat dengan lengkap, minimal 10 karakter");
            return apply_feedback_error(this);
        }
    });

    //mengecek konfirmasi password
    $("#confirm_password").blur(function() {
        var pass = $("#password").val();
        var conf = $(this).val();
        var len = conf.length;
        if (len > 0 && pass !== conf) {
            $(this).parent().find(".text-warning").text("");
            $(this).parent().find(".text-warning").text("Konfirmasi Password tidak sama dengan password");
            return apply_feedback_error(this);
        }
    });

    //mengecek nomer hp
    $("#no_hp").blur(function() {
        var hp = $(this).val();
        var len = hp.length;
        if (len > 0 && len <= 10) {
            $(this).parent().find(".text-warning").text("");
            $(this).parent().find(".text-warning").text("Nomer HP terlalu pendek");
            return apply_feedback_error(this);
        } else {
            if (!valid_hp(hp)) {
                $(this).parent().find(".text-warning").text("");
                $(this).parent().find(".text-warning").text("Format nomer hp tidak sah.(ex: 085736262623)");
                return apply_feedback_error(this);
            }
        }
    });

    function get_jabatan() {
        $.ajax({
            url: "controller/karyawan/get_jabatan.php",
            type: "POST",
            cache: false,
            success: function(data) {
                $("#cb_jabatan").html(data);
            }
        });
    }

    //menerapkan gaya validasi form bootstrap saat terjadi eror
    function apply_feedback_error(textbox) {
        $(textbox).addClass("no-valid"); //menambah class no valid
        $(textbox).parent().find(".text-warning").show();
    }

    //untuk mendapat eror teks saat textbox kosong, digunakan saat submit form dan blur fungsi
    function get_error_text(textbox) {
        $(textbox).parent().find(".text-warning").text("");
        $(textbox).parent().find(".text-warning").text("Text Box Ini Tidak Boleh Kosong");
        return apply_feedback_error(textbox);
    }

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

    function updateData(id) {
        $.ajax({
            url: "controller/karyawan/karyawan_proses.php",
            type: "POST",
            data: "proc=read&id=" + id,
            cache: false,
            dataType: "json",
            success: function(data) {
                refreshModal();
                $("#modal_title").html("Ubah Data " + data.username_karyawan);
                $("#proc").val("update");
                $("#id").val(data.id_karyawan);
                $("#username").val(data.username_karyawan);
                $("#password").val(data.password_karyawan);
                $("#confirm_password").val(data.password_karyawan);
                $("#nama").val(data.nama_karyawan);
                $("#alamat").val(data.alamat_karyawan);
                $("#no_hp").val(data.no_hp_karyawan);
                $("#jabatan").val(data.id_jabatan);
                $("#username_group").hide();
                $("#password_group").hide();
                $("#jabatan_group").hide();
                $("#confirm_password_group").hide();
                $("#modal_karyawan").modal("show");
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

    function deleteData(id, nama) {
        swal({
            title: 'Anda yakin ingin menghapus ' + nama + '?',
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
                    data: "proc=delete&id=" + id,
                    cache: false,
                    dataType: "text",
                    success: function(data) {
                        if (data == 1) {
                            swal({
                                title: 'Berhasil Hapus',
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
</script>