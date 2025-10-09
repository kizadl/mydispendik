<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Input Data FAQ Question</h5>
        <p class="fs--1 mb-0 text-white">Silahkan input data faq question</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>FAQ Question</strong> dibawah ini.<br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulfaq" value="" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulfaq">Pertanyaan</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1"><strong>Isi Uraian Faq</strong></p>
            <textarea class="fs--2" name="content" id="txtisifaq"></textarea>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanFAQ">Simpan data</button>
</div>

<script src="../vendors/tinymce/tinymce.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        tinymce.init({
            selector: "#txtisifaq",
            height: "360",
        });

        $("#txtjudulfaq").val("");
    });

    $("#cmdSimpanFAQ").click(function() {

        var judul = $("#txtjudulfaq").val();
        var isifaq = tinymce.get("txtisifaq").getContent();
 
        var data = new FormData();
        data.append('judul', judul);
        data.append('isifaq', isifaq);
 
        if (judul.length <= 0) {
            $("#txtjudulfaq").focus();
            alert("Judul pertanyaan masih kosong")
        } else if (isifaq.length <= 0) {
            $("#txtisifaq").focus();
            alert("Isi uraian faq masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/faq/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanFAQ").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterFaq();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanFAQ").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanFAQ").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanFAQ").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>