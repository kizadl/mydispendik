<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$idpodcast = trim($_POST['idpodcast']);

$qri = ("SELECT judul,headline,aktif,isi_podcast,link_youtube,tanggal FROM podcast WHERE id_podcast='" . $idpodcast . "'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$judul = $d['judul'];
$tanggal = $d['tanggal'];
$tanggal = date('d-m-Y', strtotime($tanggal));
$headline = $d['headline'];
$isipodcast = $d['isi_podcast'];
$linkyoutube = $d['link_youtube'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Edit Data Podcast</h5>
        <p class="fs--1 mb-0 text-white">Silahkan merubah data podcast</p>
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

    <input class="form-control form-control-sm datetimepicker fs--1" id="txtidPodcastE" value="<?php echo $idpodcast ?>" type="text" hidden />

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker fs--1" id="txttglpodcaste" value="<?php echo $tanggal ?>" type="text" placeholder="Tanggal informasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglpodcaste">Tanggal Podcast</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulpodcaste" value="<?php echo $judul ?>" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulpodcaste">Judul Podcast</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3 fs--1" size="1" name="cboheadlinepodcaste" id="cboheadlinepodcaste" data-options='{"removeItemButton":true,"placeholder":true}'>
            <?php
            if ($headline == "Y") {
                $plhY = "selected";
            } else {
                $plhY = "";
            }
            if ($headline == "N") {
                $plhN = "selected";
            } else {
                $plhN = "";
            }
            echo "
            <option value='N' $plhN>Bukan Headline</option>
            <option value='Y' $plhY>Headline</option>";
            ?>
        </select>
        <label for="cboheadlinepodcaste">Headline</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1"><strong>Isi Keterangan Podcast</strong></p>
            <textarea class="fs--2" name="content" id="txtisipodcaste"><?php echo $isipodcast ?></textarea>
        </div>
    </div>

    <div class="card bg-light mb-0">
        <div class="card-body px-3 py-2 mb-0">
            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm fs--1" id="txtlinkyoutubee" value="<?php echo $linkyoutube ?>" placeholder="Url link youtube" maxlength="100" autocomplete="off">
                <label for="txtlinkyoutubee">ID Link Youtube</label>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanPodcastE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script src="../vendors/tinymce/tinymce.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        tinymce.init({
            selector: "#txtisipodcaste",
            height: "360",
        });
    });

    $("#cmdSimpanPodcastE").click(function() {

        var idpengumuman = $("#txtidPodcastE").val();
        var tglinformasi = $("#txttglpodcaste").val();
        var judul = $("#txtjudulpodcaste").val();
        var headline = $("#cboheadlinepodcaste").val();
        var isiinformasi = tinymce.get("txtisipodcaste").getContent();
        var linkyoutube = $("#txtlinkyoutubee").val();

        var data = new FormData();
        data.append('idpengumuman', idpengumuman);
        data.append('tglinformasi', tglinformasi);
        data.append('judul', judul);
        data.append('headline', headline);
        data.append('isiinformasi', isiinformasi);
        data.append('linkyoutube', linkyoutube);

        if (idpengumuman.length <= 0) {
            alert("ID informasi tidak terdeteksi")
        } else if (tglinformasi.length <= 0) {
            $("#txttglpodcaste").focus();
            alert("Tanggal masih kosong")
        } else if (judul.length <= 0) {
            $("#txtjudulpodcaste").focus();
            alert("Judul masih kosong")
        } else if (headline.length <= 0) {
            $("#cboheadlinepodcaste").focus();
            alert("Headline masih kosong")
        } else if (isiinformasi.length <= 0) {
            $("#txtisipodcaste").focus();
            alert("Isi podcast masih kosong")
        } else if (linkyoutube.length <= 0) {
            $("#txtlinkyoutubee").focus();
            alert("ID link youtube masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/podcast/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanPodcastE").attr("disabled", "disabled");
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
                        $("#cmdSimpanPodcastE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanPodcastE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanPodcastE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>