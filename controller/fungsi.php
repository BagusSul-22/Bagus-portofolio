<script>
    function inputAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function inputHuruf(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 65 || charCode > 90)&&(charCode < 97 || charCode > 122)&&charCode>32)
            return false;
        return true;
    }

    //fungsi cek plat mobil
    function valid_plat(plat) {
        var pola = new RegExp(/^[a-z A-Z 0-9]+$/);
        return pola.test(plat);
    }

    //fungsi cek nama
    function valid_nama(nama) {
        var pola = new RegExp(/^[a-z A-Z ']+$/);
        return pola.test(nama);
    }

    //fungsi cek tanggal lahir
    function valid_tanggal(tanggal) {
        var pola = new RegExp(/\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/);
        return pola.test(tanggal);
    }

    //fungsi cek email
    function valid_email(email) {
        var pola = new RegExp(/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]+$/);
        return pola.test(email);
    }

    //fungsi cek phone 
    function valid_hp(no_hp) {
        var pola = new RegExp(/^[0-9-+]+$/);
        return pola.test(no_hp);
    }

    function rupiah($angka){
	    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	    return $hasil_rupiah;
    }

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function refreshModal(){
        $('.text-warning').hide();
        $('input').each(function () {
            $(this).removeClass('no-valid');
            $(this).closest('div').removeClass('has-warning');
            $(this).closest('div').removeClass('has-success');
            $(this).parent().find('.form-control-feedback').removeClass('glyphicon glyphicon-warning-sign');
            $(this).parent().find('.form-control-feedback').removeClass('glyphicon glyphicon-ok');    
        });
    }
</script>