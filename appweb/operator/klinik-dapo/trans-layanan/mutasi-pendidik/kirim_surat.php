<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idsekolah = trim($_POST['idsekolah']);
$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$nmlayanan = trim($_POST['layanan']);

$namasiswa = trim($_POST['namasiswa']);
$nip = trim($_POST['nip']);
$statuskepegawaian = trim($_POST['statuskepegawaian']);
$jenisptk = trim($_POST['jenisptk']);

$ketlevel = trim($_POST['ketlevel']);
$sttsoptdapodik = trim($_POST['sttsoptdapodik']);

?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white fs-0">Terima Atau Tolak <?php echo $nmlayanan ?></h5>
        <p class="fs--1 mb-0 text-white">Menerima atau menolak data <?php echo $nmlayanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body align-items-center">
                    <p class="fs--1 mt-0 mb-2">
                        <strong><?php echo $namasiswa ?><br />NIP. <?php echo $nip ?><br /><?php echo $statuskepegawaian ?> / <?php echo $jenisptk ?></strong>
                    </p>
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi data <strong>Alasan Penolakan</strong> jika permohonan ini tidak memenuhi syarat untuk diterima<br />
                        Tekan tombol <strong>Menerima Permohonan</strong> untuk menerima permohonan<br />
                        Tekan tombol <strong>Tolak Permohonan</strong> untuk menolak atau tidak menerima permohonan<br />
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidsuratKirim" value="<?php echo $idtransaksi ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidlayananKirim" value="<?php echo $idlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidinstansiKirim" value="<?php echo $idsekolah ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransketlevelsuratKirim" value="<?php echo $ketlevel ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttranssttsoptdapodikKirim" value="<?php echo $sttsoptdapodik ?>" readonly="readonly" style="display:none" />

    <input type="text" id="txttransnamasiswaKirim" value="<?php echo $namasiswa ?>" readonly="readonly" style="display:none" />
   
    <div class="form-floating mb-0 mt-3">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="optkelanjutanrekom" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="Y">Menerima Permohonan</option>
            <option value="N">Tolak (Tidak Menerima)</option>
        </select>
        <label for="optkelanjutanrekom">Kelanjutan Permohonan</label>
    </div>

    <div class="form-floating mt-3 mb-0 area-tolak" style="display:none">
        <textarea class="form-control form-control-sm fs--1" id="txtalasantolak" placeholder="Alasan penolakan" style="height: 100px"></textarea>
        <label for="txtalasantolak">Alasan Penolakan</label>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-danger area-tolak" type="button" id="cmdTolakSurat" style="display:none">Tolak permohonan</button>
    <button class="btn btn-sm btn-success me-3 area-terima" type="button" id="cmdTeruskanSurat">Terima permohonan</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $(".area-terima").css("display","block");
        $(".area-tolak").css("display","none");
        $('#txtalasantolak').val("");
    });

    $("#optkelanjutanrekom").on("change",function() {
        var cbolanjut = $('#optkelanjutanrekom').val();
        $('#txtalasantolak').val("");
        if (cbolanjut == "Y"){
            $(".area-terima").css("display","block");
            $(".area-tolak").css("display","none");
        } else if (cbolanjut == "N"){
            $(".area-terima").css("display","none");
            $(".area-tolak").css("display","block");
        }
    });

    $("#cmdTolakSurat").click(function() {

        var idoperator = $('#lbleditor').val();
        var namaoperator = $('#lblnamaeditor').val();
        var idsekolah = $('#txttransidinstansiKirim').val();
        var idtransaksi = $('#txttransidsuratKirim').val();
        var idlayanan = $('#txttransidlayananKirim').val();
        var levelsurat = $('#txttransketlevelsuratKirim').val();
        var leveloperator = $('#lblnamalevel').val();
        var modetransaksi = "tolak";

        var statusleveloperator = $('#txttranssttsoptdapodikKirim').val(); 
        if (statusleveloperator == "belum"){
            var pengiriman = "baru";
        } else {
            var pengiriman = "ulang";
        }

        var alasantolak = $('#txtalasantolak').val();

        var namasiswa = $('#txttransnamasiswaKirim').val();
        
        if (idsekolah.length <= 0) {
            alert('Data sekolah pengirim tidak terdeteksi')
        } else if (idlayanan.length <= 0) {
            alert('Data layanan tidak terdeteksi')
        } else if (idtransaksi.length <= 0) {
            alert('Data transaksi tidak terdeteksi')
        } else if (alasantolak.length <= 0) {
            $('#txtalasantolak').focus();
            alert('Alasan penolakan masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: "aksi/trans-layanan/mutasi-pendidik/aksi_kirim.php",
                data: {
                    idoperator: idoperator,
                    namaoperator: namaoperator,
                    idlayanan: idlayanan,
                    idtransaksi: idtransaksi,
                    namasiswa: namasiswa,
                    levelsurat: levelsurat,
                    leveloperator: leveloperator,
                    modetransaksi: modetransaksi,
                    alasantolak: alasantolak
                },
                beforeSend: function(e) {
                    $("#loading").fadeIn();
                    document.body.style.cursor = "wait";
                },
                success: function(resp) {
                    document.body.style.cursor = "default";
                    $("#loading").fadeOut("slow");
                    setTimeout(function() {
                        $('#modBebasData').modal('hide');
                    }, 1000);
                    $("#ToastSukses").toast("show");
                    isiMutasiPendidik();
                    isiJumlahLayanan();
                    isiNotifikasiStatus();
                    //isiLayananSurat();
                    //isiJumlahSurat();
                    /*
                    socket.emit('kirim surat', idinduk);
                    socket.emit('kirim surat', idinstansi + "#" + leveloperator);

                    if (leveloperator == 3) {
                        socket.emit('kirim surat', idinduk + "#" + levelprev);
                    } else if (leveloperator == 4) {
                        socket.emit('kirim surat', idinstansi + "#" + levelprev);
                        socket.emit('kirim level 5', idinstansi + "#5");
                    } else if (leveloperator == 6) {
                        socket.emit('kirim surat', idinstansi + "#" + levelprev);
                        socket.emit('kirim level 7', idinduk + "#7");
                    }
                        */
                },
                error: function() {
                    document.body.style.cursor = "default";
                    $("#loading").fadeOut("slow");
                    alert('Koneksi bermasalah periksa internet');
                },
            });
        };
    });

    $("#cmdTeruskanSurat").click(function() {
        var idoperator = $('#lbleditor').val();
        var namaoperator = $('#lblnamaeditor').val();
        var idsekolah = $('#txttransidinstansiKirim').val();
        var idtransaksi = $('#txttransidsuratKirim').val();
        var idlayanan = $('#txttransidlayananKirim').val();
        var levelsurat = $('#txttransketlevelsuratKirim').val();
        var leveloperator = $('#lblnamalevel').val();
        var modetransaksi = "terima";

        var statusleveloperator = $('#txttranssttsoptdapodikKirim').val(); 
        if (statusleveloperator == "belum"){
            var pengiriman = "baru";
        } else {
            var pengiriman = "ulang";
        }

        var alasantolak = $('#txtalasantolak').val();

        var namasiswa = $('#txttransnamasiswaKirim').val();
        
        if (idsekolah.length <= 0) {
            alert('Data sekolah pengirim tidak terdeteksi')
        } else if (idlayanan.length <= 0) {
            alert('Data layanan tidak terdeteksi')
        } else if (idtransaksi.length <= 0) {
            alert('Data transaksi tidak terdeteksi')
        } else {
            $.ajax({
                type: "POST",
                url: "aksi/trans-layanan/mutasi-pendidik/aksi_kirim.php",
                data: {
                    idoperator: idoperator,
                    namaoperator: namaoperator,
                    idlayanan: idlayanan,
                    idtransaksi: idtransaksi,
                    namasiswa: namasiswa,
                    levelsurat: levelsurat,
                    leveloperator: leveloperator,
                    modetransaksi: modetransaksi,
                    alasantolak: alasantolak
                },
                beforeSend: function(e) {
                    $("#loading").fadeIn();
                    document.body.style.cursor = "wait";
                },
                success: function(resp) {
                    document.body.style.cursor = "default";
                    $("#loading").fadeOut("slow");
                    setTimeout(function() {
                        $('#modBebasData').modal('hide');
                    }, 1000);
                    $("#ToastSukses").toast("show");
                    isiMutasiPendidik();
                    isiJumlahLayanan();
                    isiNotifikasiStatus();
                    //isiLayananSurat();
                    //isiJumlahSurat();
                    /*
                    socket.emit('kirim surat', idinduk);
                    socket.emit('kirim surat', idinstansi + "#" + leveloperator);

                    if (leveloperator == 3) {
                        socket.emit('kirim surat', idinduk + "#" + levelprev);
                    } else if (leveloperator == 4) {
                        socket.emit('kirim surat', idinstansi + "#" + levelprev);
                        socket.emit('kirim level 5', idinstansi + "#5");
                    } else if (leveloperator == 6) {
                        socket.emit('kirim surat', idinstansi + "#" + levelprev);
                        socket.emit('kirim level 7', idinduk + "#7");
                    }
                        */
                },
                error: function() {
                    document.body.style.cursor = "default";
                    $("#loading").fadeOut("slow");
                    alert('Koneksi bermasalah periksa internet');
                },
            });
        };
    });
</script>