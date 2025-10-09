<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$idpengumuman = trim($_POST['idpengumuman']);

$qri = ("SELECT judul,headline,aktif,isi_pengumuman,tanggal FROM pengumuman WHERE id_pengumuman='" . $idpengumuman . "'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$judul = $d['judul'];
$tanggal = $d['tanggal'];
$tanggal = date('d-m-Y', strtotime($tanggal));
$headline = $d['headline'];
$isipengumuman = $d['isi_pengumuman'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Edit Data Informasi Pendidikan</h5>
        <p class="fs--1 mb-0 text-white">Silahkan merubah data informasi pendidikan</p>
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

    <input class="form-control form-control-sm datetimepicker fs--1" id="txtidpengumumanE" value="<?php echo $idpengumuman ?>" type="text" hidden />

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker fs--1" id="txttglinformasie" value="<?php echo $tanggal ?>" type="text" placeholder="Tanggal informasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglinformasie">Tanggal Informasi</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm fs--1" id="txtjudulinformasie" value="<?php echo $judul ?>" placeholder="Judul informasi" maxlength="100" autocomplete="off">
        <label for="txtjudulinformasie">Judul Informasi</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3 fs--1" size="1" name="cboheadlineinformasie" id="cboheadlineinformasie" data-options='{"removeItemButton":true,"placeholder":true}'>
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
        <label for="cboheadlineinformasie">Headline</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1"><strong>Isi Informasi</strong></p>
            <textarea class="fs--2" name="content" id="txtisiinformasie"><?php echo $isipengumuman ?></textarea>
        </div>
    </div>

    <div class="card bg-light mb-0">
        <div class="card-body px-3 py-2 mb-0">
            <label for="btnUploadFoto">Upload File Dokumen (*.pdf)</label>
            <div class="form-floating mb-0">
                <input class="form-control form-control-sm px-4" id="btnUploadInformasiE" type="file" accept=".pdf" />
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanInformasiE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script src="../vendors/tinymce/tinymce.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        tinymce.init({
            selector: "#txtisiinformasie",
            height: "360",
        });
    });

    $('#btnUploadInformasiE').bind('change', function() {
        var extensinya = $('#btnUploadInformasiE').val().toLowerCase();
        var regex = new RegExp("(.*?)\.(pdf)$");
        if (!(regex.test(extensinya))) {
            alert("File upload harus file dokumen pdf");
            $('#btnUploadInformasiE').val(null);
        }
    });

    $("#cmdSimpanInformasiE").click(function() {

        var idpengumuman = $("#txtidpengumumanE").val();
        var tglinformasi = $("#txttglinformasie").val();
        var judul = $("#txtjudulinformasie").val();
        var headline = $("#cboheadlineinformasie").val();
        var isiinformasi = tinymce.get("txtisiinformasie").getContent();

        var data = new FormData();
        data.append('upinformasiE', $("#btnUploadInformasiE")[0].files[0]);
        data.append('idpengumuman', idpengumuman);
        data.append('tglinformasi', tglinformasi);
        data.append('judul', judul);
        data.append('headline', headline);
        data.append('isiinformasi', isiinformasi);

        if (idpengumuman.length <= 0) {
            alert("ID informasi tidak terdeteksi")
        } else if (tglinformasi.length <= 0) {
            $("#txttglinformasie").focus();
            alert("Tanggal masih kosong")
        } else if (judul.length <= 0) {
            $("#txtjudulinformasie").focus();
            alert("Judul masih kosong")
        } else if (headline.length <= 0) {
            $("#cboheadlineinformasie").focus();
            alert("Headline masih kosong")
        } else if (isiinformasi.length <= 0) {
            $("#txtisiinformasie").focus();
            alert("Isi informasi masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/informasi/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanInformasiE").attr("disabled", "disabled");
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
                        $("#cmdSimpanInformasiE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanInformasiE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanInformasiE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>