<script>
    function showModalmenu() {
        refreshModal();
        get_kategori_menu();
        $("#modal_title").html("Tambah menu");
        $("#id").val("");
        $("#proc").val("insert");
        $("#nama").val("");
        $("#cb_kategori").show();
        $("#foto_menu").show();
        $("#foto_menu").val("");
        var input = document.getElementById("foto_menu");
        input.type = "file";
        $("#pratinjau_foto_menu").html('');
        $("#stok").val("");
        $("#harga").val("");
        $("#modal_menu").modal("show");
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
                <h class="h3 mb-0 text-gray-800">Data Menu</h>
            </div>
        </div>

        <div class="box-header" style="margin-bottom:30px">


            <div class="box-header" style="margin-bottom:30px">

                <!-- DataTales -->
                <div class="card shadow mb-4">
                    <div class="col-xl mb-4 mt-4">
                        <button onClick="showModalmenu()" class="btn btn-primary" role="button" title="Tambah "><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama menu</th>
                                        <th>Kategori menu</th>
                                        <th>Foto</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
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
                                    $result = $dao->readMenu();
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no = $no + 1; ?></td>
                                            <td><?php echo $row['nama_menu']; ?></td>
                                            <td><?php echo $row['nama_kategori_menu']; ?></td>
                                            <td><?php echo $row['foto']; ?></td>
                                            <td><?php echo $row['stok']; ?></td>
                                            <td><?php echo $row['harga']; ?></td>
                                            <td><?php echo $row['create_at']; ?></td>
                                            <td><?php echo $row['update_at']; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-info btn-circle btn-sm" role="button" onclick="updateData('<?php echo $row['id_menu']; ?>')" title="Ubah Data"><i class="fas fa-info-circle"></i></button>
                                                <button class="btn btn-danger btn-circle btn-sm" role="button" onclick="deleteData('<?php echo $row['id_menu']; ?>','<?php echo $row['nama_menu']; ?>')" title="Hapus Data"><i class="fas fa-trash"></i></button>

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
        <!-- Modal menu -->
        <div class="modal fade" id="modal_menu" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hiden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title"></h5>
                        <button style="color:#fff" class="close" type="button" data-dismiss="modal" aria-label="close">
                            <span aria-hiden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formInputMenu" method="post">
                            <div class="box-body">
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="proc" id="proc">
                                <div class="form-group has-feedback">
                                    <label>Nama Menu</label>
                                    <input type="text" name="nama" id="nama" class="form-control textbox" placeholder="Masukkan Nama Menu" maxlength="20">
                                    <h6 class="text-warning"></h6>
                                </div>
                                <div class="form-group" style="margin-top:20px" id="kategori_group">
                                    <label>Kategori menu</label>
                                    <select type="text" name="cb_kategori" id="cb_kategori" class="form-control">
                                        <option value="">
                                    </select>
                                </div>
                                <div class="form-group has-feedback" id="foto_group">
                                    <label>Foto Menu</label>
                                    <input type="file" name="foto_menu" id="foto_menu" class="form-control textbox" onchange="return validasiFileFoto()">
                                    <h6 class="text-warning"></h6>
                                </div>
                                <div id="pratinjau_foto_menu">
                                </div>
                                <div class="form-group has-feedback">
                                    <label>Stok</label>
                                    <input type="text" name="stok" id="stok" class="form-control textbox" placeholder="Masukkan Stok" maxlength="30">
                                    <h6 class="text-warning"></h6>
                                </div>
                                <div class="form-group has-feedback">
                                    <label>Harga <br></label>
                                    <input type="text" name="harga" id="harga" class="form-control textbox" placeholder="Masukkan Harga" maxlength="30">
                                    <h6 class="text-warning"></h6>
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
            </div>
        </div>
    </div>
</div>
<!-- /------------>

<!-- Javascript Datatable -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#datakategorimenu").DataTable();

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

    function get_kategori_menu() {
        $.ajax({
            url: "controller/menu/get_kategori_menu.php",
            type: "POST",
            data: "id_kategori_menu=0",
            cache: false,
            success: function(data) {
                $("#cb_kategori").html(data);
            }
        });
    }

    function get_kategori_menu_edit(id_kategori_menu) {
        $.ajax({
            url: "controller/menu/get_kategori_menu.php",
            type: "POST",
            data: "id_kategori_menu=" + id_kategori_menu,
            cache: false,
            success: function(data) {
                $("#cb_kategori").html(data);
            }
        });
    }

    function validasiFileFoto() {
        var inputFileFoto = document.getElementById('foto_menu');
        var pathFileFoto = inputFileFoto.value;
        var ekstensiOkFoto = /(\.jpg|\.jpeg|\.png)$/i;
        if (!ekstensiOkFoto.exec(pathFileFoto)) {
            inputFileFoto.value = '';
            swal({
                title: "Ups...",
                text: "Silakan upload file yang memiliki ekstensi .jpeg /.jpg /.png",
                type: "error",
                timer: 2000,
                showConfirmButton: false,
            })
            return false;
        } else {
            //Pratinjau gambar
            if (inputFileFoto.files && inputFileFoto.files[0]) {
                var file_size_foto = $('#foto_menu')[0].files[0].size;
                if (file_size_foto > 1000000) {
                    inputFileFoto.value = '';
                    swal({
                        title: "Ups...",
                        text: "Maksimal ukuran file adalah 1 MB",
                        type: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    })
                    return false;
                } else {
                    var readerFoto = new FileReader();
                    readerFoto.onload = function(e) {
                        document.getElementById('pratinjau_foto_menu').innerHTML = '<img src="' + e.target.result + '" class="rounded" width="100px"/>';
                    };
                    readerFoto.readAsDataURL(inputFileFoto.files[0]);
                    return true;
                }
            }
        }
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
        $("#formInputMenu").find(".textbox").each(function() {
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
                        url: "controller/menu/menu_proses.php",
                        type: "POST",
                        data: new FormData($("#formInputMenu")[0]),
                        processData: false,
                        contentType: false,
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
                                    window.location = 'index.php?page=data_menu';
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
            url: "controller/menu/menu_proses.php",
            type: "POST",
            data: "proc=read&id=" + id,
            cache: false,
            dataType: "json",
            success: function(data) {
                refreshModal();
                $("#modal_title").html("Ubah Data Menu " + data.nama_menu);
                $("#proc").val("update");
                $("#id").val(data.id_menu);
                $("#nama").val(data.nama_menu);
                get_kategori_menu_edit(data.id_kategori_menu);
                var input = document.getElementById("foto_menu");
                input.type = "text";
                $("#foto_menu").val(data.foto);
                $("#foto_group").hide();
                $("#stok").val(data.stok);
                $("#harga").val(data.harga);
                $("#modal_menu").modal("show");
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
                    url: "controller/menu/menu_proses.php",
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
                                window.location = 'index.php?page=data_menu';
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
<script>
    function previewImg() {
        const sampul = document.querySelector('#foto_menu');
        const sampulLabel = document.querySelector('.custom-file-label');
        const imgPreview = document.querySelector('.img-preview');


        sampulLabel.textContent = sampul.files[0].name;


        const fileSampul = new FileReader();
        fileSampul.readAsDataURL(sampul.files[0]);


        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }



    }
</script>

<script type="text/javascript">
    function preview(foto, idpreview) {
        var gb = foto.files;
        for (var i = 0; i < gb.length; i++) {
            var gbPreview = gb[i];
            var imageType = /image.*/;
            var preview = document.getElementById(idpreview);
            var reader = new FileReader();
            if (gbPreview.type.match(imageType)) {
                preview.file = gbPreview;
                reader.onload = (function(element) {
                    return function(e) {
                        element.src = e.target.result;
                    };
                })(preview);
                reader.readAsDataURL(gbPreview);
            } else {
                alert("Type file tidak sesuai. Khusus image.");
            }

        }
    }
</script>