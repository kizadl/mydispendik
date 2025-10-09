<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Input Data Podcast</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data podcast</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Podcast</strong> dibawah ini.<br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker fs--1" id="txttglpodcast" value="" type="text" placeholder="Tanggal informasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglpodcast">Tanggal Podcast</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulpodcast" value="" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulpodcast">Judul Podcast</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3 fs--1" size="1" name="cboheadlinepodcast" id="cboheadlinepodcast" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="N">Bukan Headline</option>
            <option value="Y">Headline</option>
        </select>
        <label for="cboheadlinepodcast">Headline</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1"><strong>Isi Keterangan Podcast</strong></p>
            <textarea class="fs--2" name="content" id="txtisipodcast"></textarea>
        </div>
    </div>

    <div class="card bg-light mb-0">
        <div class="card-body px-3 py-2 mb-0">
            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm fs--1" id="txtlinkyoutube" value="" placeholder="Url link youtube" maxlength="100" autocomplete="off">
                <label for="txtlinkyoutube">ID Link Youtube</label>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanPodcast">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script src="../vendors/tinymce/tinymce.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        tinymce.init({
            selector: "#txtisipodcast",
            height: "360",
        });

        $("#txtjudulpodcast").val("");
        $("#cboheadlinepodcast").val("N");

        var tglserver = $("#lbltglserver").val();
        arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
            "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"
        ];
        mydate = new Date(tglserver);

        tanggal = mydate.getDate();
        bulan = mydate.getMonth();
        tahun = mydate.getFullYear();

        $("#txttglpodcast").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
    });

    $("#cmdSimpanPodcast").click(function() {

        var tglinformasi = $("#txttglpodcast").val();
        var judul = $("#txtjudulpodcast").val();
        var headline = $("#cboheadlinepodcast").val();
        var isiinformasi = tinymce.get("txtisipodcast").getContent();
        var linkyoutube = $("#txtlinkyoutube").val();

        var data = new FormData();
        data.append('tglinformasi', tglinformasi);
        data.append('judul', judul);
        data.append('headline', headline);
        data.append('isiinformasi', isiinformasi);
        data.append('linkyoutube', linkyoutube);

        if (tglinformasi.length <= 0) {
            $("#txttglpodcast").focus();
            alert("Tanggal masih kosong")
        } else if (judul.length <= 0) {
            $("#txtjudulpodcast").focus();
            alert("Judul masih kosong")
        } else if (headline.length <= 0) {
            $("#cboheadlinepodcast").focus();
            alert("Headline masih kosong")
        } else if (isiinformasi.length <= 0) {
            $("#txtisipodcast").focus();
            alert("Isi podcast masih kosong")
        } else if (linkyoutube.length <= 0) {
            $("#txtlinkyoutube").focus();
            alert("ID link youtube masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/podcast/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanPodcast").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterPodcast();
                        ambiljumlah();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanPodcast").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanPodcast").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanPodcast").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>