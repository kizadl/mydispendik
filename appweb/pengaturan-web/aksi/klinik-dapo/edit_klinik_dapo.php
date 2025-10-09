<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$qri = ("SELECT judul,isi_klinik,tanggal FROM klinik_dapo WHERE id_klinik='1'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$judul = $d['judul'];
$tanggal = $d['tanggal'];
$tanggal = date('d-m-Y', strtotime($tanggal));
$isiklinik = $d['isi_klinik'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Edit Data Klinik Dapo</h5>
        <p class="fs--1 mb-0 text-white">Silahkan merubah data klinik dapo</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Klinik Dapo</strong> dibawah ini.<br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker fs--1" id="txttglklinike" value="<?php echo $tanggal ?>" type="text" placeholder="Tanggal informasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglklinike">Tanggal Klinik Dapo</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulklinike" value="<?php echo $judul ?>" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulklinike">Judul Klinik Dapo</label>
    </div>

    <div class="card bg-light mb-0">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1"><strong>Isi Klinik Dapo</strong></p>
            <textarea class="fs--2" name="content" id="txtisiklinike"><?php echo $isiklinik ?></textarea>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanKlinikE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script src="../vendors/tinymce/tinymce.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        tinymce.init({
            selector: "#txtisiklinike",
            height: "360",
        });
    });

    $("#cmdSimpanKlinikE").click(function() {

        var tglsambutan = $("#txttglklinike").val();
        var judul = $("#txtjudulklinike").val();
        var isisambutan = tinymce.get("txtisiklinike").getContent();

        var data = new FormData();
        data.append('tglsambutan', tglsambutan);
        data.append('judul', judul);
        data.append('isisambutan', isisambutan);

        if (tglsambutan.length <= 0) {
            $("#txttglklinike").focus();
            alert("Tanggal klinik masih kosong")
        } else if (judul.length <= 0) {
            $("#txtjudulklinike").focus();
            alert("Judul klinik masih kosong")
        } else if (isisambutan.length <= 0) {
            $("#txtisiklinike").focus();
            alert("Isi klinik masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/klinik-dapo/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanKlinikE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanKlinikE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanKlinikE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanKlinikE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>