<script>
    function showModalPesanan() {
        refreshModal();
        $("#modal_title").html("Tambah menu");
        $("#id").val("");
        $("#proc").val("insert");
        $("#nama").val("");
        $("#kategori_group").show();
        $("#foto_menu").val("");
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


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="col-xl mb-4 mt-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h class="h3 mb-0 text-gray-800"><a class="btn btn-primary" id="btn_kembali" onclick="btn_kembali()" style="color:white"><i class="fas fa-arrow-left"></i></a><span id="judul"> Data Pesanan</span> <span id="id_transaksi_in_detail"></span></h>
        </div>

        <div class="box-header" style="margin-bottom:30px">
            <!-- DataTales -->
            <div class="card shadow mb-4" id=tabel_pemesanan>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatablePemesanan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nomor Pesanan</th>
                                    <th>Nomor Meja</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pesanan_list"></tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>


        <div class="card shadow mb-4" id=tabel_detail_pemesanan>

            <div class="col-xl mb-4 text-right mt-4">
                <button id="btn_proses_semua" onclick="prosesSemuaDataDetailPemesanan()" class="btn btn-primary" role="button" title="Tambah "><i class="glyphicon glyphicon-plus"></i> Proses semua</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatableDetail" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama menu</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detail_pesanan_list"></tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</div>
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Modal pesanan -->

<!-- /Modal pesanan -->

<!-- Javascript Datatable -->
<script type="text/javascript">
    readDataPemesanan();
    $('#btn_kembali').hide();
    $('#tabel_pemesanan').fadeIn('slow');
    $('#judul').html('Data Pemesanan');
    $('#tabel_detail_pemesanan').hide();
    $(document).ready(function() {
        $("#datatablePemesanan").DataTable();
        $("#datatableDetail").DataTable();
    });

    function btn_kembali() {
        readDataPemesanan();
        $('#btn_kembali').hide();
        $('#tabel_pemesanan').fadeIn('slow');
        $('#judul').html('Data Pemesanan');
        $('#tabel_detail_pemesanan').hide();
    }

    function detailData(id_transaksi, status_transaksi) {
        if (status_transaksi == '1') {
            swal.fire({
                title: 'Ups...',
                text: 'Pemesanan ini sudah di proses',
                type: 'info',
                timer: 2000,
                showConfirmButton: false,
            })
        } else {
            $('#btn_kembali').fadeIn('slow');
            $('#judul').html('Data Detail Pemesanan - ');
            $('#id_transaksi_in_detail').html(id_transaksi);
            $('#tabel_pemesanan').hide();
            readDataDetailPemesanan(id_transaksi);
            $('#tabel_detail_pemesanan').fadeIn('slow');
        }
    }

    function hapusData(id_transaksi, id_meja) {
        swal({
            title: 'Anda yakin ingin menghapus pesanan?',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "controller/pesanan/pesanan_proses.php",
                    type: "POST",
                    data: "proc=hapusdatapesanan&id=" + id_transaksi + "&id_meja=" + id_meja,
                    cache: false,
                    dataType: "text",
                    success: function(data) {
                        if (data == 1) {
                            $("#datatableDetail").dataTable().fnDestroy();
                            readDataDetailPemesanan(id_transaksi);
                            $("#datatableDetail").DataTable()

                            swal({
                                title: 'Berhasil Diproses',
                                type: 'success',
                                timer: 2000,
                                showConfirmButton: false,
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


    function readDataDetailPemesanan(id_transaksi) {
        $.ajax({
            type: "POST",
            url: "controller/pesanan/pesanan_proses.php",
            data: "proc=readalldetailpemesanan&id=" + id_transaksi,
            async: false,
            dataType: "json",
            success: function(data) {
                $(".preloader").fadeOut();
                var i;
                var no = 1;
                var detail_pesanan_list = '';
                for (i = 0; i < data.length; i++) {
                    var is_proses = data[i].is_proses;
                    if (is_proses == '1') {
                        var btn_color = 'success';
                    } else {
                        var btn_color = 'danger';
                    }
                    detail_pesanan_list +=
                        '<tr>' +
                        '<td>' + no++ + '</td>' +
                        '<td style="text-align:center">' + data[i].nama_menu + '</td>' +
                        '<td>' + data[i].jumlah + ' item</td>' +

                        '<td style="text-align:right">' +

                        '<a style="color:white" onclick="prosesDataDetailPemesanan(' + "'" + data[i].id_transaksi + "'" + ',' + "'" + data[i].id_detail_transaksi + "'" + ',' + "'" + data[i].is_proses + "'" + ');" class="btn btn-' + btn_color + '" role="button" title="Hapus Data">Proses</a>    ' +

                        '</td>' +
                        '</tr>';
                }
                $("#detail_pesanan_list").html(detail_pesanan_list);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $(".preloader").fadeOut();
                swal.fire({
                    title: 'Ups...',
                    text: 'Cek Koneksi Anda',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                })
            }
        });
    }

    function prosesSemuaDataDetailPemesanan() {
        var id_transaksi = $("#id_transaksi_in_detail").html();
        swal({
            title: 'Anda yakin ingin memproses semua?',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "controller/pesanan/pesanan_proses.php",
                    type: "POST",
                    data: "proc=prosessemuadatadetail&id=" + id_transaksi,
                    cache: false,
                    dataType: "text",
                    success: function(data) {
                        if (data == 1) {
                            $("#datatableDetail").dataTable().fnDestroy();
                            readDataDetailPemesanan(id_transaksi);
                            $("#datatableDetail").DataTable()

                            swal({
                                title: 'Berhasil Diproses',
                                type: 'success',
                                timer: 2000,
                                showConfirmButton: false,
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


    function prosesDataDetailPemesanan(id_transaksi, id_detail_transaksi, status_detail) {
        if (status_detail == '1') {
            swal.fire({
                title: 'Ups...',
                text: 'Pemesanan ini sudah di proses',
                type: 'info',
                timer: 2000,
                showConfirmButton: false,
            })
        } else {
            swal({
                title: 'Anda yakin ingin memproses?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "controller/pesanan/pesanan_proses.php",
                        type: "POST",
                        data: "proc=prosesdatadetail&id=" + id_detail_transaksi + "&id_transaksi=" + id_transaksi,
                        cache: false,
                        dataType: "text",
                        success: function(data) {
                            if (data == 1) {
                                $("#datatableDetail").dataTable().fnDestroy();
                                readDataDetailPemesanan(id_transaksi);
                                $("#datatableDetail").DataTable()

                                swal({
                                    title: 'Berhasil Diproses',
                                    type: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
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


    function readDataPemesanan() {
        $.ajax({
            type: "POST",
            url: "controller/pesanan/pesanan_proses.php",
            data: "proc=readall&id=0",
            async: false,
            dataType: "json",
            success: function(data) {
                $(".preloader").fadeOut();
                var i;
                var no = 1;
                var pesanan_list = '';
                for (i = 0; i < data.length; i++) {
                    var is_success = data[i].is_success;
                    if (is_success == '1') {
                        var btn_color = 'success';
                    } else {
                        var btn_color = 'danger';
                    }
                    pesanan_list +=
                        '<tr>' +
                        '<td>' + no++ + '</td>' +
                        '<td style="text-align:center">' + data[i].id_transaksi + '</td>' +
                        '<td>Meja ' + data[i].nomor + '</td>' +
                        '<td>' + data[i].jumlah_beli + ' item</td>' +

                        '<td style="text-align:center">' +

                        '<a style="color:white" onclick="detailData(' + "'" + data[i].id_transaksi + "'" + ',' + "'" + data[i].is_success + "'" + ');" class="btn btn-' + btn_color + '" role="button" title="Hapus Data">Proses</a>' +

                        '<a style="color:white" onclick="hapusData(' + "'" + data[i].id_transaksi + "'" + ',' + "'" + data[i].id_meja + "'" + ',' + "'" + data[i].is_success + "'" + ');" class="btn btn-primary" role="button" title="Hapus Pesanan">Hapus</a>' +

                        '</td>' +
                        '</tr>';
                }
                $("#pesanan_list").html(pesanan_list);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $(".preloader").fadeOut();
                swal.fire({
                    title: 'Ups...',
                    text: 'Cek Koneksi Anda',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                })
            }
        });
    }

    function prosesPesanan(id) {
        $.ajax({
            url: "controller/pesanan/pesanan_proses.php",
            type: "POST",
            data: "proc=read&id=" + id,
            cache: false,
            dataType: "json",
            success: function(data) {
                refreshModal();
                $("#modal_title").html("Pesanan " + data.nama);
                $("#proc").val("update");
                $("#id").val(data.id);
                $("#nama").val(data.nama);
                $("#menu").val(data.menu);
                $("#jumlah").val(data.jumlah);
                $("#harga").val(data.harga);
                $("#total").val(data.total);
                $("#modal_pesanan").modal("show");
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