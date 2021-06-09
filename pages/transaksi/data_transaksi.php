<script>
    function showModalTransaksi() {
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


    function showModalBayar() {
        refreshModal();
        $("#modal_title").html("Tambah Meja");
        $("#nama_menu").val("");
        $("#proc").val("insert");
        $("#harga_menu").val("");
        $("#jumlah").val("");
        $("#total").val("");
        $("#modal_transaksi").modal("show");
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
            <h class="h3 mb-0 text-gray-800"></i></a><span id="judul">Data Transaksi</span> <span id="id_transaksi_in_detail"></span></h>
        </div>


        <div class="box-header" style="margin-bottom:30px">

            <!-- DataTales -->
            <div class="card shadow mb-4">

                <div class="card-header">
                    <a onclick="btn_belum_bayar();" class="btn btn-danger" role="button" title="belum bayar" style="color:#fff"></i> Belum Bayar</a>
                    <a onclick="btn_sudah_bayar();" class="btn btn-success" role="button" title="sudah bayar" style="color:#fff"></i> Sudah Bayar</a>

                </div>
                <div id="belum_bayar">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatableTransaksiBelumBayar" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Pesanan</th>
                                        <th>Nomor Meja</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="transaksi_belum_list"></tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <div id="sudah_bayar">
                    <div class="card-body" id="sudah_bayar">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatableTransaksiSudahBayar" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Pesanan</th>
                                        <th>Nomor Meja</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="transaksi_sudah_list"></tbody>


                            </table>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
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
<!-- Modal Transaksi -->
<div class="modal fade" id="modal_transaksi" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hiden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button style="color:#fff" class="close" type="button" data-dismiss="modal" aria-label="close">
                    <span aria-hiden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formBayarTransaksi">
                    <div class="box-body">
                        <input type="hidden" name="id_meja" id="id_meja">
                        <input type="hidden" name="id" id="id_transaksi">
                        <input type="hidden" name="proc" value="prosesbayarkasir">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabel_menu" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="data_menu_list"></tbody>
                                <tfoot>
                                    <td class="text-center" colspan="4">TOTAL</td>
                                    <td id="grand_total"></td>
                                </tfoot>

                            </table>

                        </div>

                        <div class="form-group has-feedback">
                            <label>Bayar</label>
                            <input type="text" name="bayar" id="bayar" class="form-control textbox" placeholder="Rp. 0" maxlength="20" onkeypress="return inputAngka(event)">
                            <h6 class="text-warning"></h6>
                        </div>
                        <div id="keterangan_group" class="form-group">
                            <label id="keterangan"></label>
                        </div>
                        <div id="kembalian_group" class="form-group" style="text-align: right">
                            <label>Kembalian <br>Rp. <span id="kembalian">0</span></label>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-primary" type="button" onclick="prosesData()">
                    Bayar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Meja -->

<!-- /Modal pesanan -->


<!-- Javascript Datatable -->
<script type="text/javascript">
    readDataTransaksi('1');
    $('#judul').html('Data Transaksi - Belum Bayar');
    $('#sudah_bayar').hide();
    $('#belum_bayar').fadeIn('slow');


    $(function() {
        $("#datatableTransaksiSudahBayar,#datatableTransaksiBelumBayar").DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
        });
    });

    $(document).ready(function() {
        //Mengirimkan Token Keamanan
        $.ajaxSetup({
            headers: {
                'Csrf-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    var bayar = document.getElementById("bayar");
    bayar.addEventListener("keyup", function(e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        bayar.value = formatRupiah(this.value, "Rp. ");

        hitungKembalian();
    });

    function btn_sudah_bayar() {
        readDataTransaksi('2');
        $('#judul').html('Daftar Transaksi - Sudah Bayar');
        $('#belum_bayar').hide();
        $('#sudah_bayar').fadeIn('slow');

    }

    function btn_belum_bayar() {
        readDataTransaksi('1');
        $('#judul').html('Daftar Transaksi - Belum Bayar');
        $('#sudah_bayar').hide();
        $('#belum_bayar').fadeIn('slow');

    }

    function btnbayar(id_transaksi, id_meja) {
        readDataBayar(id_transaksi);
        $('#judul').html('Daftar Transaksi');
        $('#id_transaksi').val(id_transaksi);
        $('#id_meja').val(id_meja);
        $('#modal_transaksi').modal("show");

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


    function prosesData() {
        var id = $("#id_transaksi").val();
        var bayar = $("#bayar").val();
        var kembali = $("#kembalian").html();
        swal({
            title: 'Bayar ?',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "controller/transaksi/transaksi_proses.php",
                    type: "POST",
                    data: $("#formBayarTransaksi").serialize(),
                    cache: false,
                    dataType: "text",
                    success: function(data) {
                        if (data == 1) {
                            $("#modal_transaksi").modal('hide');
                            readDataTransaksi('1');
                            $('#judul').html('Daftar Transaksi - Belum Bayar');
                            $('#sudah_bayar').hide();
                            $('#belum_bayar').fadeIn('slow');
                            swal({
                                title: 'BerhasiL',
                                type: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            }).then((result) => {
                                //window.location = 'index.php?page=data_transaksi';
                                window.open('pages/cetak/cetak_nota.php?id=' + id + '&bayar=' + bayar + '&kembali=' + kembali, '_blank');
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




    function readDataBayar(id_transaksi) {
        $.ajax({
            type: "POST",
            url: "controller/transaksi/transaksi_proses.php",
            data: "proc=prosesBayar&id=" + id_transaksi,
            async: false,
            dataType: "json",
            success: function(data) {
                $(".preloader").fadeOut();
                var i;
                var grand_total = 0.0;
                var no = 1;
                var data_list = '';
                for (i = 0; i < data.length; i++) {
                    data_list +=
                        '<tr>' +
                        '<td>' + no++ + '</td>' +
                        '<td style="text-align:center">' + data[i].nama_menu + '</td>' +
                        '<td> ' + formatRupiah(data[i].harga.toString(), "Rp.") + '</td>' +
                        '<td>' + data[i].jumlah + '</td>' +
                        '<td>' + formatRupiah(data[i].total.toString(), "Rp.") + '</td>' +
                        '</tr>';
                    var total = parseFloat(data[i].total);
                    total = isNaN(total) ? 0 : total;
                    grand_total += total;

                }
                $("#data_menu_list").html(data_list);
                $("#grand_total").html(formatRupiah(grand_total.toString(), "Rp."));
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

    function hitungKembalian() {
        var total = $("#grand_total").html();
        var bayar_diterima = $("#bayar").val();
        var len = bayar_diterima.length;
        if (len > 0) {
            var bayar = $("#bayar").val();
            $.ajax({
                url: "controller/transaksi/hitung_pengembalian.php",
                type: "POST",
                data: "bayar=" + bayar + "&total=" + total,
                dataType: "json",
                success: function(data) {
                    if (data[0].hasil == 1) {
                        $("#keterangan_group").hide();
                        $("#keterangan").html("Sukses");
                        $("#kembalian_group").fadeIn("slow");
                        $("#kembalian").html(data[0].KembalianRp);
                    } else if (data[0].hasil == 0) {
                        $("#keterangan_group").hide();
                        $("#keterangan").html("Sukses");
                        $("#kembalian_group").fadeIn("slow");
                        $("#kembalian").html(data[0].KembalianRp);
                    } else if (data[0].hasil == 2) {
                        $("#kembalian_group").hide();
                        $("#keterangan").html("Pembayaran masih kurang");
                        $("#keterangan_group").fadeIn("slow");
                    } else {
                        swal.fire({
                            title: 'Ups...',
                            text: 'Sepertinya ada yang bermasalah',
                            type: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal.fire({
                        title: 'Ups...',
                        text: 'Cek Koneksi Anda',
                        type: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    })
                }
            });

        } else {
            $("#keterangan_group").hide();
            $("#kembalian_group").hide();
        }
    }

    function readDataTransaksi(status) {
        if (status == '1') {
            $div_table = 'transaksi_belum_list';
        } else {
            $div_table = 'transaksi_sudah_list';
        }
        $.ajax({
            type: "POST",
            url: "controller/transaksi/transaksi_proses.php",
            data: "proc=readall&id=0&status=" + status,
            async: false,
            dataType: "json",
            success: function(data) {
                $(".preloader").fadeOut();
                var i;
                var no = 1;
                var data_list = '';
                for (i = 0; i < data.length; i++) {
                    var is_success = data[i].is_success;
                    if (is_success == '1') {
                        var btn_color = 'danger';
                        var display_aksi = '';
                    } else {
                        var btn_color = 'success';
                        var display_aksi = 'none';
                    }
                    data_list +=
                        '<tr>' +
                        '<td>' + no++ + '</td>' +
                        '<td style="text-align:center">' + data[i].id_transaksi + '</td>' +
                        '<td>Meja ' + data[i].nomor + '</td>' +
                        '<td>' + data[i].nama_pelanggan + '</td>' +
                        '<td>' + formatRupiah(data[i].total_beli.toString(), "Rp.") + '</td>' +

                        '<td style="text-align:center;display:' + display_aksi + '">' +
                        '<a style="color:white" onclick="btnbayar(' + "'" + data[i].id_transaksi + "'" + ',' + "'" + data[i].id_meja + "'" + ')" class="btn btn-' + btn_color + '" role="button" title="Hapus Data">Bayar</a>' +
                        '</td>' +
                        '</tr>';
                }
                $("#" + $div_table).html(data_list);
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
</script>