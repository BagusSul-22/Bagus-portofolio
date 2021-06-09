<script>
    function showModalMejaInsert() {
        refreshModal();
        $("#modal_title").html("Tambah Meja");
        $("#id").val("");
        $("#proc").val("insert");
        $("#nomor").val("");
        $("#status").val("");
        $("#modal_meja").modal("show");
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="col-xl mb-4 mt-4">
        <!-- Main content -->
        <div class="col-xl mb-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h class="h3 mb-0 text-gray-800">Data Meja </h>
            </div>
        </div>
        <div class="box-header" style="margin-bottom:30px">

            <!-- DataTales -->
            <div class="card shadow mb-4">
                <div class="col-xl mb-4 mt-4">
                    <button class="btn btn-primary" type="button" onclick="showModalMejaInsert();">
                        Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nomor Meja</th>
                                    <th>Status</th>
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
                                $result = $dao->readMeja();
                                $no = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no = $no + 1; ?></td>
                                        <td><?php echo $row['nomor']; ?></td>
                                        <td><?php echo $row['status_meja']; ?></td>
                                        <td><?php echo $row['create_at']; ?></td>
                                        <td><?php echo $row['update_at']; ?></td>
                                        <td style="text-align:center">

                                            <button class="btn btn-info btn-circle btn-sm" type="button" onclick="updateData('<?php echo $row['id_meja']; ?>')" title="Ubah Data"><i class="fas fa-info-circle"></i>
                                            </button>
                                            <button class="btn btn-danger btn-circle btn-sm" type="button" onclick="deleteData('<?php echo $row['id_meja']; ?>')" title="Hapus Data"><i class="fas fa-trash"></i>
                                            </button>

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

<!-- Modal Meja -->
<div class="modal fade" id="modal_meja" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hiden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button style="color:#fff" class="close" type="button" data-dismiss="modal" aria-label="close">
                    <span aria-hiden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formInputMeja">
                    <div class="box-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="proc" id="proc">
                        <div class="form-group has-feedback">
                            <label>Nomor Meja</label>
                            <input type="text" name="nomor" id="nomor" class="form-control textbox" placeholder="Masukkan Nomor" maxlength="20">
                            <h6 class="text-warning"></h6>
                            <label>Status</label>
                            <input type="text" name="stat_meja" id="stat_meja" class="form-control textbox" placeholder="Masukkan Status" maxlength="20">
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
<!-- /Modal Meja -->

<!-- Javascript Datatable -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#dataTable").DataTable();

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

        //mengecek nomor
        $("#nomor").blur(function() {
            var nomor = $(this).val();
            var len = nomor.length;
            if (len > 3) {
                $(this).parent().find(".text-warning").text("");
                $(this).parent().find(".text-warning").text("nama maximal 3 karakter");
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
        $("#formInputMeja").find(".textbox").each(function() {
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
                        url: "controller/meja/meja_proses.php",
                        type: "POST",
                        data: $("#formInputMeja").serialize(),
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
                                    window.location = 'index.php?page=data_meja';
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
            url: "controller/meja/meja_proses.php",
            type: "POST",
            data: "proc=read&id=" + id,
            cache: false,
            dataType: "json",
            success: function(data) {
                refreshModal();
                $("#modal_title").html("Ubah Data Meja " + data.nomor);
                $("#proc").val("update");
                $("#id").val(data.id_meja);
                $("#nomor").val(data.nomor);
                $("#stat_meja").val(data.status_meja);
                $("#modal_meja").modal("show");
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

    function deleteData(id, nomor) {
        swal({
            title: 'Anda yakin ingin menghapus meja ' + nomor + '?',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "controller/meja/meja_proses.php",
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
                                window.location = 'index.php?page=data_meja';
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