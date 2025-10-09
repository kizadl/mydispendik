<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idlayanan = trim($_POST['idlayanan']);
$qrilay = ("SELECT layanan FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
$dblayanan = mysqli_query($dbconn, $qrilay);
$d = mysqli_fetch_assoc($dblayanan);
$layanan = $d['layanan'];
mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Input Data <?php echo $layanan ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan isi dan lengkapi data <?php echo $layanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong><?php echo $layanan ?></strong>
                        (Data Kepala Sekolah, Data Sekolah Tempat Tugas, Data Surat Tugas dan Data Ijazah).
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Kepala Sekolah</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 justify-content-between mt-3 px-card pb-3">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnamaKS" value="" maxlength="100" placeholder="Nama lengkap" autocomplete="off">
                    <label for="txtnamaKS">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtnikKS" value="" maxlength="20" placeholder="NIK" autocomplete="off">
                    <label for="txtnikKS">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnipKS" value="" maxlength="35" placeholder="NIP" autocomplete="off">
                    <label for="txtnipKS">NIP</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnuptkKS" value="" maxlength="35" placeholder="NUPTK" autocomplete="off">
                    <label for="txtnuptkKS">NUPTK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsekolahasalKS" value="" maxlength="100" placeholder="Sekolah" autocomplete="off">
                    <label for="txtnmsekolahasalKS">Nama Sekolah</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnpsnasalKS" value="" maxlength="50" placeholder="NPSN" autocomplete="off">
                    <label for="txtnpsnasalKS">NPSN</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaKS" value="" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaKS">No. HP WhatsApp (WA) Aktif</label>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Sekolah Tempat Tugas</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtsekolahtmptugasKS" value="" maxlength="100" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahtmptugasKS">Nama Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsntempattugasKS" value="" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsntempattugasKS">NPSN Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cbostatuspenugasanKS" id="cbostatuspenugasanKS" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Status Penugasan</option>
                    <option value="sekolah induk">Sekolah Induk</option>
                    <option value="sekolah non induk">Sekolah Non Induk</option>
                </select>
                <label for="cbostatuspenugasanKS">Status Penugasan</label>
            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Surat Tugas</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnosurattugasKS" value="" maxlength="50" placeholder="No. Surat Tugas" autocomplete="off">
                <label for="txtnosurattugasKS">No. Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglsurattugasKS" value="" type="text" placeholder="Tanggal surat tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsurattugasKS">Tanggal Surat Tugas</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttmtsurattugasKS" value="" type="text" placeholder="TMT Surat Tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttmtsurattugasKS">TMT Surat Tugas</label>
            </div>

        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Ijazah S1 Keatas <code>(** Opsional ** Tidak Wajib hanya untuk yang ijazah S1 Ke atas **)</code></h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <input type="text" id="lblchkIjazahKS" value="" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkijazahKS" type="checkbox" />
                <label class="form-check-label" for="chkijazahKS">Ijazah S1 Ke atas</label>
            </div>
            <div id="area-ijazah-ganti-kepsek" style="display:none">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmuniversitasKS" value="" maxlength="50" placeholder="Perguruan tinggi" autocomplete="off">
                    <label for="txtnmuniversitasKS">Nama Perguruan Tinggi</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtproGstudyKS" value="" maxlength="50" placeholder="Program study" autocomplete="off">
                    <label for="txtproGstudyKS">Program Study</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnoijazahKS" value="" maxlength="50" placeholder="Nomor ijazah" autocomplete="off">
                    <label for="txtnoijazahKS">Nomor Ijazah</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="number" class="form-control form-control-sm" id="txtthnlulusKS" value="" maxlength="4" placeholder="Tahun lulus" autocomplete="off">
                    <label for="txtthnlulusKS">Tahun Lulus</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanGantiKepsek">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        $("#txtnamaKS").val("");
        $("#txtnikKS").val("");
        $("#txtnipKS").val("");
        $("#txtnuptkKS").val("");
        $("#txtnmsekolahasalKS").val("");
        $("#txtnpsnasalKS").val("");
        $("#txtnowaKS").val("");

        $("#txtsekolahtmptugasKS").val("");
        $("#txtnpsntempattugasKS").val("");
        $("#cbostatuspenugasanKS").val("");
    
        $("#txtnosurattugasKS").val("");
        $("#txttglsurattugasKS").val("");
        $("#txttmtsurattugasKS").val("");

        $("#lblchkIjazahKS").val("N"); //$("#chkijazahKS").val("");
        $("#txtnmuniversitasKS").val("");
        $("#txtproGstudyKS").val("");
        $("#txtnoijazahKS").val("");
        $("#txtthnlulusKS").val("");
    });

    $("#chkijazahKS").on("change", function() {
        $("#txtnmuniversitasKS").val("");
        $("#txtproGstudyKS").val("");
        $("#txtnoijazahKS").val("");
        $("#txtthnlulusKS").val("");
        if ($(this).is(':checked')) {
            $("#lblchkIjazahKS").val("Y");
            $("#area-ijazah-ganti-kepsek").fadeIn();
        } else {
            $("#lblchkIjazahKS").val("N");
            $("#area-ijazah-ganti-kepsek").fadeOut("slow");
        }
    });

    $("#cmdsimpanGantiKepsek").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        var idlayanan = "4";
        
        var nmkepsek = $("#txtnamaKS").val();
        var nik = $("#txtnikKS").val();
        var nip = $("#txtnipKS").val();
        var nuptk = $("#txtnuptkKS").val();
        var sekolahasal = $("#txtnmsekolahasalKS").val();
        var npsnasal = $("#txtnpsnasalKS").val();
        var noWA = $("#txtnowaKS").val();

        var nmsekolahtugas = $("#txtsekolahtmptugasKS").val();
        var npsntugas = $("#txtnpsntempattugasKS").val();
        var statuspenugasan = $("#cbostatuspenugasanKS").val();
       
        var nosurattugas = $("#txtnosurattugasKS").val();
        var tglsurattugas = $("#txttglsurattugasKS").val();
        var tmtsurattugas = $("#txttmtsurattugasKS").val();
 
        var chkijazah = $("#lblchkIjazahKS").val();
        var namapt = $("#txtnmuniversitasKS").val();
        var progstudy = $("#txtproGstudyKS").val();
        var noijazah = $("#txtnoijazahKS").val();
        var thnlulusijazah = $("#txtthnlulusKS").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);

        data.append('nmkepsek', nmkepsek);
        data.append('nik', nik);
        data.append('nip', nip);
        data.append('nuptk', nuptk);
        data.append('sekolahasal', sekolahasal);
        data.append('npsnasal', npsnasal);
        data.append('noWA', noWA);

        data.append('nmsekolahtugas', nmsekolahtugas);
        data.append('npsntugas', npsntugas);
        data.append('statuspenugasan', statuspenugasan);

        data.append('nosurattugas', nosurattugas);
        data.append('tglsurattugas', tglsurattugas);
        data.append('tmtsurattugas', tmtsurattugas);
  
        data.append('chkijazah', chkijazah);
        data.append('namapt', namapt);
        data.append('progstudy', progstudy);
        data.append('noijazah', noijazah);
        data.append('thnlulusijazah', thnlulusijazah);

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmkepsek.length <= 0) {
            $("#txtnamaKS").focus();
            alert("Nama kepala sekolah masih kosong")
        } else if (nik.length <= 0) {
            $("#txtnikKS").focus();
            alert("NIK masih kosong")
        } else if (nip.length <= 0) {
            $("#txtnipKS").focus();
            alert("NIP masih kosong")
        } else if (nuptk.length <= 0) {
            $("#txtnuptkKS").focus();
            alert("NUPTK masih kosong")
        } else if (sekolahasal.length <= 0) {
            $("#txtnmsekolahasalKS").focus();
            alert("Sekolah asal masih kosong")
        } else if (npsnasal.length <= 0) {
            $("#txtnpsnasalKS").focus();
            alert("NPSN sekolah asal masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaKS").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (nmsekolahtugas.length <= 0) {
            $("#txtsekolahtmptugasKS").focus();
            alert("Nama sekolah tempat tugas masih kosong")
        } else if (npsntugas.length <= 0) {
            $("#txtnpsntempattugasKS").focus();
            alert("NPSN sekolah tempat tugas masih kosong")
        } else if (statuspenugasan.length <= 0) {
            $("#cbostatuspenugasanKS").focus();
            alert("Status penugasan masih kosong")
       
        } else if (nosurattugas.length <= 0) {
            $("#txtnosurattugasKS").focus();
            alert("Nomor surat tugas masih kosong")
        } else if (tglsurattugas.length <= 0) {
            $("#txttglsurattugasKS").focus();
            alert("Tanggal surat tugas masih kosong")
        } else if (tmtsurattugas.length <= 0) {
            $("#txttmtsurattugasKS").focus();
            alert("TMT surat tugas masih kosong")

        } else if (chkijazah == "Y" && namapt == "") {
            $("#txtnmuniversitasKS").focus();
            alert("Nama perguruan tinggi masih kosong")
        } else if (chkijazah == "Y" && progstudy == "") {
            $("#txtproGstudyKS").focus();
            alert("Program study masih kosong")
        } else if (chkijazah == "Y" && noijazah == "") {
            $("#txtnoijazahKS").focus();
            alert("Nomor ijazah masih kosong")
        } else if (chkijazah == "Y" && thnlulusijazah == "") {
            $("#txtthnlulusKS").focus();
            alert("Tahun lulus ijazah masih kosong")
        } else {
            var urlnya = "klinik-dapo/trans-layanan/pergantian-kepsek/aksi_tambah.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanGantiKepsek").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiPergantianKepsek();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanGantiKepsek").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanGantiKepsek").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanGantiKepsek").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>