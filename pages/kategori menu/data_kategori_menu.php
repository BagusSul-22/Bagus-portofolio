<script>
    function showModalKategorimenu() {
        refreshModal();
        $("#modal_title").html("Tambah kategori menu");
        $("#id").val("");
        $("#proc").val("insert");
        $("#nama").val("");
        $("#modal_kategorimenu").modal("show");
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



<div class="content-wrapper">
    <div class="col-xl mb-4 mt-4">
        <div class="col-xl mb-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h class="h3 mb-0 text-gray-800">Data Kategori Menu</h>
            </div>
        </div>

        <div class="box-header" style="margin-bottom:30px">


            <div class="box-header" style="margin-bottom:30px">
                <!-- DataTales -->
                <div class="card shadow mb-4">
                    <div class="col-xl mb-4 mt-4">
                        <button onClick="showModalKategorimenu()" class="btn btn-primary" role="button" title="Tambah "><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsif">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
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
                                    $result = $dao->readKategoriMenu();
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no = $no + 1; ?></td>
                                            <td><?php echo $row['nama_kategori_menu']; ?></td>
                                            <td><?php echo $row['create_at']; ?></td>
                                            <td><?php echo $row['update_at']; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-info btn-circle btn-sm" role="button" onclick="updateData('<?php echo $row['id_kategori_menu']; ?>')" title="Ubah Data"><i class="fas fa-info-circle"></i></button>
                                                <button class="btn btn-danger btn-circle btn-sm" role="button" onclick="deleteData('<?php echo $row['id_kategori_menu']; ?>','<?php echo $row['nama_kategori_menu']; ?>')" title="Hapus Data"><i class="fas fa-trash"></i></button>

                                            <?php
                                        }
                                            ?>
                                            </td>
                                        </tr>
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
        <!-- /.content-wrapper -->
        <!-- Modal kategori menu -->
        <div class="modal fade" id="modal_kategorimenu" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hiden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title"></h5>
                        <button style="color:#fff" class="close" type="button" data-dismiss="modal" aria-label="close">
                            <span aria-hiden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formInputKategorimenu">
                            <div class="box-body">
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="proc" id="proc">
                                <div class="form-group has-feedback" id="username_group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control textbox" placeholder="Masukkan nama kategori" maxlength="30">
                                    <h6 class="text-warning"></h6>
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
        <!-- /-->
    </div>

    <!-- Javascript Datatable -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#datakategoriMenu").DataTable();

            //semua element dengan class text-warning akan di sembunyikan saat load
            $(".text-warning").hide();
            //untuk mengecek bahwa semua textbox tidak boleh kosong
            $("input").each(function() {
                $(this).blur(function() { //blur function itu dijalankan saat element kehilangan fokus
                    if (!$(this).val()) { //this mengacu pada text box yang sedang fokus
                        return get_error_text(this); //function get_error_text ada di bawah
                    } else {
                        $(this).removeClass("no-valid");
                        $(this).parent().find(".text-warning").hide(); //cari element dengan class has-warning dari element induk text yang sedang focus
                    }
                });
            });

            //mengecek nama
            $("#nama").blur(function() {
                var alamat = $(this).val();
                var len = alamat.length;
                if (len > 30) {
                    $(this).parent().find(".text-warning").text("");
                    $(this).parent().find(".text-warning").text("nama maximal 30 karakter");
                    return apply_feedback_error(this);
                }
            });
        });

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
            $("#formInputKategorimenu").find(".textbox").each(function() {
                if (!$(this).val()) {
                    get_error_text(this);
                    valid = false;
                    swal({
                        title: 'Ups...',
                        text: 'Isi semua kolom dengan benar',
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
                            url: "controller/kategori menu/kategori_menu_proses.php",
                            type: "POST",
                            data: $("#formInputKategorimenu").serialize(),
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
                                        window.location = 'index.php?page=data_kategori_menu';
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

        function updateData(id) {
            $.ajax({
                url: "controller/kategori menu/kategori_menu_proses.php",
                type: "POST",
                data: "proc=read&id=" + id,
                cache: false,
                dataType: "json",
                success: function(data) {
                    refreshModal();
                    $("#modal_title").html("Ubah Data Kategori Menu " + data.nomor);
                    $("#proc").val("update");
                    $("#id").val(data.id_kategori_menu);
                    $("#nama").val(data.nama_ketegori_menu);
                    $("#modal_kategorimenu").modal("show");
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
                        url: "controller/kategori menu/kategori_menu_proses.php",
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
                                    window.location = 'index.php?page=data_kategori_menu';
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