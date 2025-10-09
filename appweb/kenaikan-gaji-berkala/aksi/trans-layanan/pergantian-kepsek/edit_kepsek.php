<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$qrilay = ("SELECT layanan FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
$dblayanan = mysqli_query($dbconn, $qrilay);
$d = mysqli_fetch_assoc($dblayanan);
$layanan = $d['layanan'];
mysqli_free_result($dblayanan);

$sqlx = ("SELECT nama,nik,nip,nuptk,nm_sekolah_asal,npsn_asal,no_wa,
			nm_sekolah_tugas,npsn_tugas,stts_penugasan,
			no_surat_tugas,tgl_surat_tugas,tmt_surat_tugas,
			ijazah_s1,nm_pt,prog_studi,no_ijazah,thn_lulus FROM tte_trans_pergantian_kepsek WHERE id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$nmkepsek = $sm['nama'];
$nik = $sm['nik'];
$nip = strtoupper($sm['nip']);
$nuptk = strtoupper($sm['nuptk']);
$nmsekolahasal = strtoupper($sm['nm_sekolah_asal']);
$npsnasal = strtoupper($sm['npsn_asal']);
$noWA = $sm['no_wa'];

$nmsekolahtugas = strtoupper($sm['nm_sekolah_tugas']);
$npsntugas = strtoupper($sm['npsn_tugas']);
$sttspenugasan = $sm['stts_penugasan'];

$nosurattugas = strtoupper($sm['no_surat_tugas']);
$tglsurattugas = $sm['tgl_surat_tugas'];$tglsurattugas = date('d-m-Y', strtotime($tglsurattugas));
$tmtsurattugas = $sm['tmt_surat_tugas'];$tmtsurattugas = date('d-m-Y', strtotime($tmtsurattugas));

$ijazahs1 = $sm['ijazah_s1'];
if ($ijazahs1 == "Y"){
    $hidrekom = ""; $chkrekomval = "checked";
    $namapt = strtoupper($sm['nm_pt']);
    $progstudy = strtoupper($sm['prog_studi']);
    $noijazah = strtoupper($sm['no_ijazah']);
    $thnlulus = $sm['thn_lulus'];
} else if ($ijazahs1 == "N"){
    $hidrekom = "display:none"; $chkrekomval = "";
    $namapt = "";
    $progstudy = "";
    $noijazah = "";
    $thnlulus = "";
}
mysqli_free_result($restps);mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data <?php echo $layanan ?></h5>
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

    <input type="text" class="form-control form-control-sm" id="txtidTransaksiKSE" value="<?php echo $idtransaksi ?>" hidden >
    <input type="text" class="form-control form-control-sm" id="txtidlayananKSE" value="<?php echo $idlayanan ?>" hidden >
    
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
                    <input type="text" class="form-control form-control-sm" id="txtnamaKSE" value="<?php echo $nmkepsek ?>" maxlength="100" placeholder="Nama lengkap" autocomplete="off">
                    <label for="txtnamaKSE">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtnikKSE" value="<?php echo $nik ?>" maxlength="20" placeholder="NIK" autocomplete="off">
                    <label for="txtnikKSE">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnipKSE" value="<?php echo $nip ?>" maxlength="35" placeholder="NIP" autocomplete="off">
                    <label for="txtnipKSE">NIP</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnuptkKSE" value="<?php echo $nuptk ?>" maxlength="35" placeholder="NUPTK" autocomplete="off">
                    <label for="txtnuptkKSE">NUPTK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsekolahasalKSE" value="<?php echo $nmsekolahasal ?>" maxlength="100" placeholder="Sekolah" autocomplete="off">
                    <label for="txtnmsekolahasalKSE">Nama Sekolah</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnpsnasalKSE" value="<?php echo $npsnasal ?>" maxlength="50" placeholder="NPSN" autocomplete="off">
                    <label for="txtnpsnasalKSE">NPSN</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaKSE" value="<?php echo $noWA ?>" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaKSE">No. HP WhatsApp (WA) Aktif</label>
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
                <input type="text" class="form-control form-control-sm" id="txtsekolahtmptugasKSE" value="<?php echo $nmsekolahtugas ?>" maxlength="100" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahtmptugasKSE">Nama Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsntempattugasKSE" value="<?php echo $npsntugas ?>" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsntempattugasKSE">NPSN Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cbostatuspenugasanKSE" id="cbostatuspenugasanKSE" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Status Penugasan</option>
                    <?php
                        if ($sttspenugasan == "sekolah induk") {
                            $plhInduk = "selected";
                        } else if ($sttspenugasan == "sekolah non induk") {
                            $plhNonInduk = "selected";
                        }
                        echo "<option value='sekolah induk' $plhInduk >Sekolah Induk</option>
                        <option value='sekolah non induk' $plhNonInduk >Sekolah Non Induk</option>";
                    ?>
                </select>
                <label for="cbostatuspenugasanKSE">Status Penugasan</label>
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
                <input type="text" class="form-control form-control-sm" id="txtnosurattugasKSE" value="<?php echo $nosurattugas ?>" maxlength="50" placeholder="No. Surat Tugas" autocomplete="off">
                <label for="txtnosurattugasKSE">No. Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglsurattugasKSE" value="<?php echo $tglsurattugas ?>" type="text" placeholder="Tanggal surat tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsurattugasKSE">Tanggal Surat Tugas</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttmtsurattugasKSE" value="<?php echo $tmtsurattugas ?>" type="text" placeholder="TMT Surat Tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttmtsurattugasKSE">TMT Surat Tugas</label>
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

            <input type="text" id="lblchkijazahKSEE" value="<?php echo $ijazahs1 ?>" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkijazahKSE" type="checkbox" <?php echo $chkrekomval ?> />
                <label class="form-check-label" for="chkijazahKSE">Ijazah S1 Ke atas</label>
            </div>
            <div id="area-ijazah-ganti-kepsekE" style="<?php echo $hidrekom ?>">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmuniversitasKSE" value="<?php echo $namapt ?>" maxlength="50" placeholder="Perguruan tinggi" autocomplete="off">
                    <label for="txtnmuniversitasKSE">Nama Perguruan Tinggi</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtproGstudyKSE" value="<?php echo $progstudy ?>" maxlength="50" placeholder="Program study" autocomplete="off">
                    <label for="txtproGstudyKSE">Program Study</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnoijazahKSE" value="<?php echo $noijazah ?>" maxlength="50" placeholder="Nomor ijazah" autocomplete="off">
                    <label for="txtnoijazahKSE">Nomor Ijazah</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="number" class="form-control form-control-sm" id="txtthnlulusKSE" value="<?php echo $thnlulus ?>" maxlength="4" placeholder="Tahun lulus" autocomplete="off">
                    <label for="txtthnlulusKSE">Tahun Lulus</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanGantiKepsekE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
 
    $("#chkijazahKSE").on("change", function() {
        $("#txtnmuniversitasKSE").val("");
        $("#txtproGstudyKSE").val("");
        $("#txtnoijazahKSE").val("");
        $("#txtthnlulusKSE").val("");
        if ($(this).is(':checked')) {
            $("#lblchkijazahKSEE").val("Y");
            $("#area-ijazah-ganti-kepsekE").fadeIn();
        } else {
            $("#lblchkijazahKSEE").val("N");
            $("#area-ijazah-ganti-kepsekE").fadeOut("slow");
        }
    });

    $("#cmdsimpanGantiKepsekE").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidinstansi").val();
    
        var idlayanan = $("#txtidlayananKSE").val();
        var idtransaksi = $("#txtidTransaksiKSE").val();
        
        var nmkepsek = $("#txtnamaKSE").val();
        var nik = $("#txtnikKSE").val();
        var nip = $("#txtnipKSE").val();
        var nuptk = $("#txtnuptkKSE").val();
        var sekolahasal = $("#txtnmsekolahasalKSE").val();
        var npsnasal = $("#txtnpsnasalKSE").val();
        var noWA = $("#txtnowaKSE").val();

        var nmsekolahtugas = $("#txtsekolahtmptugasKSE").val();
        var npsntugas = $("#txtnpsntempattugasKSE").val();
        var statuspenugasan = $("#cbostatuspenugasanKSE").val();
       
        var nosurattugas = $("#txtnosurattugasKSE").val();
        var tglsurattugas = $("#txttglsurattugasKSE").val();
        var tmtsurattugas = $("#txttmtsurattugasKSE").val();
 
        var chkijazah = $("#lblchkijazahKSEE").val();
        var namapt = $("#txtnmuniversitasKSE").val();
        var progstudy = $("#txtproGstudyKSE").val();
        var noijazah = $("#txtnoijazahKSE").val();
        var thnlulusijazah = $("#txtthnlulusKSE").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);

        data.append('idtransaksi', idtransaksi);
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

        if (idlayanan.length <= 0 || idtransaksi.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmkepsek.length <= 0) {
            $("#txtnamaKSE").focus();
            alert("Nama kepala sekolah masih kosong")
        } else if (nik.length <= 0) {
            $("#txtnikKSE").focus();
            alert("NIK masih kosong")
        } else if (nip.length <= 0) {
            $("#txtnipKSE").focus();
            alert("NIP masih kosong")
        } else if (nuptk.length <= 0) {
            $("#txtnuptkKSE").focus();
            alert("NUPTK masih kosong")
        } else if (sekolahasal.length <= 0) {
            $("#txtnmsekolahasalKSE").focus();
            alert("Sekolah asal masih kosong")
        } else if (npsnasal.length <= 0) {
            $("#txtnpsnasalKSE").focus();
            alert("NPSN sekolah asal masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaKSE").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (nmsekolahtugas.length <= 0) {
            $("#txtsekolahtmptugasKSE").focus();
            alert("Nama sekolah tempat tugas masih kosong")
        } else if (npsntugas.length <= 0) {
            $("#txtnpsntempattugasKSE").focus();
            alert("NPSN sekolah tempat tugas masih kosong")
        } else if (statuspenugasan.length <= 0) {
            $("#cbostatuspenugasanKSE").focus();
            alert("Status penugasan masih kosong")
       
        } else if (nosurattugas.length <= 0) {
            $("#txtnosurattugasKSE").focus();
            alert("Nomor surat tugas masih kosong")
        } else if (tglsurattugas.length <= 0) {
            $("#txttglsurattugasKSE").focus();
            alert("Tanggal surat tugas masih kosong")
        } else if (tmtsurattugas.length <= 0) {
            $("#txttmtsurattugasKSE").focus();
            alert("TMT surat tugas masih kosong")

        } else if (chkijazah == "Y" && namapt == "") {
            $("#txtnmuniversitasKSE").focus();
            alert("Nama perguruan tinggi masih kosong")
        } else if (chkijazah == "Y" && progstudy == "") {
            $("#txtproGstudyKSE").focus();
            alert("Program study masih kosong")
        } else if (chkijazah == "Y" && noijazah == "") {
            $("#txtnoijazahKSE").focus();
            alert("Nomor ijazah masih kosong")
        } else if (chkijazah == "Y" && thnlulusijazah == "") {
            $("#txtthnlulusKSE").focus();
            alert("Tahun lulus ijazah masih kosong")
        } else {
            var urlnya = "aksi/trans-layanan/pergantian-kepsek/aksi_edit.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanGantiKepsekE").attr("disabled", "disabled");
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
                        $("#cmdsimpanGantiKepsekE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanGantiKepsekE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanGantiKepsekE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>