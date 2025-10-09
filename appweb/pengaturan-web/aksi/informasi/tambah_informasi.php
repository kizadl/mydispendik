<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Input Data Informasi Pendidikan</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data informasi pendidikan</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Informasi Pendidikan</strong> dibawah ini.<br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker fs--1" id="txttglinformasi" value="" type="text" placeholder="Tanggal informasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglinformasi">Tanggal Informasi</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulinformasi" value="" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulinformasi">Judul Informasi</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3 fs--1" size="1" name="cboheadlineinformasi" id="cboheadlineinformasi" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="N">Bukan Headline</option>
            <option value="Y">Headline</option>
        </select>
        <label for="cboheadlineinformasi">Headline</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1"><strong>Isi Informasi</strong></p>
            <textarea class="fs--2" name="content" id="txtisiinformasi"></textarea>
        </div>
    </div>

    <div class="card bg-light mb-0">
        <div class="card-body px-3 py-2 mb-0">
            <label for="btnUploadFoto">Upload File Dokumen (*.pdf)</label>
            <div class="form-floating mb-0">
                <input class="form-control form-control-sm px-4" id="btnUploadInformasi" type="file" accept=".pdf" />
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanInformasi">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script src="../vendors/tinymce/tinymce.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        tinymce.init({
            selector: "#txtisiinformasi",
            height: "360",
        });

        $("#txtjudulinformasi").val("");
        $("#cboheadlineinformasi").val("N");

        var tglserver = $("#lbltglserver").val();
        arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
            "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"
        ];
        mydate = new Date(tglserver);

        tanggal = mydate.getDate();
        bulan = mydate.getMonth();
        tahun = mydate.getFullYear();

        $("#txttglinformasi").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
    });

    $('#btnUploadInformasi').bind('change', function() {
        var extensinya = $('#btnUploadInformasi').val().toLowerCase();
        var regex = new RegExp("(.*?)\.(pdf)$");
        if (!(regex.test(extensinya))) {
            alert("File upload harus file dokumen pdf");
            $('#btnUploadInformasi').val(null);
        }
    });

    $("#cmdSimpanInformasi").click(function() {

        var tglinformasi = $("#txttglinformasi").val();
        var judul = $("#txtjudulinformasi").val();
        var headline = $("#cboheadlineinformasi").val();
        var isiinformasi = tinymce.get("txtisiinformasi").getContent();

        var data = new FormData();
        data.append('upinformasi', $("#btnUploadInformasi")[0].files[0]);
        data.append('tglinformasi', tglinformasi);
        data.append('judul', judul);
        data.append('headline', headline);
        data.append('isiinformasi', isiinformasi);

        if (tglinformasi.length <= 0) {
            $("#txttglinformasi").focus();
            alert("Tanggal masih kosong")
        } else if (judul.length <= 0) {
            $("#txtjudulinformasi").focus();
            alert("Judul masih kosong")
        } else if (headline.length <= 0) {
            $("#cboheadlineinformasi").focus();
            alert("Headline masih kosong")
        } else if (isiinformasi.length <= 0) {
            $("#txtisiinformasi").focus();
            alert("Isi informasi masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/informasi/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanInformasi").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterInformasi();
                        ambiljumlah();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanInformasi").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanInformasi").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanInformasi").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>