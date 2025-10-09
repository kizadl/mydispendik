<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$idpesan = trim($_POST['idpesan']);
$idsekolah = trim($_POST['idsekolah']);
$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$nmlayanan = trim($_POST['nmlayanan']);
$sttskirim = trim($_POST['sttskirim']);

if ($sttskirim == "belum"){
    $hidverifikator = "display:none";
} else if ($sttskirim == "terkirim"){
    $hidverifikator = "";
}

$sql2  = "UPDATE tte_detail_pesan SET dibaca_operator_dapodik='Y' WHERE id_pesan='".$idpesan."'";
$res=mysqli_query($dbconn,$sql2);	

$qricbg = ("SELECT nama_siswa,no_surat FROM tte_trans_mutasi_siswa WHERE id_transaksi='" . $idtransaksi . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$namasiswa = ucwords(strtolower($c['nama_siswa']));
$nosurat = strtoupper($c['no_surat']);
mysqli_free_result($dbcabang);

$sqlx = ("SELECT pengirim,penerima FROM tte_detail_pesan WHERE id_pesan='".$idpesan."'");
$dbpesan = mysqli_query($dbconn, $sqlx);
$p = mysqli_fetch_assoc($dbpesan);
$pengirim = $p['pengirim'];$penerima = $p['penerima'];

if ($pengirim == "operator sekolah" OR $penerima == "operator sekolah"){
    $activeoptsekolah = "active";
} else if ($pengirim == "operator bidang" OR $penerima == "operator bidang"){
    $activeoptbidang = "active";
} else if ($pengirim == "kepala seksi" OR $penerima == "kepala seksi"){
    $activekasi = "active";
} else if ($pengirim == "kepala bidang" OR $penerima == "kepala bidang"){
    $activekabid = "active";
}

mysqli_free_result($dbpesan);

mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Layanan Kirim Pesan Verifikator</h5>
        <p class="fs--1 mb-0 text-white">Kirim Pesan Ke Verifikator Layanan - <?php echo $nmlayanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $namasiswa ?></strong><br />NO. <?php echo $nosurat ?><br /><?php echo $nmlayanan ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidsuratPsNotif" value="<?php echo $idtransaksi ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidlayananPsNotif" value="<?php echo $idlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidinstansiPsNotif" value="<?php echo $idsekolah ?>" readonly="readonly" style="display:none" />
 
    <input type="text" id="txttranspengirimnotif" value="<?php echo $pengirim ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttranspenerimanotif" value="<?php echo $penerima ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttranspesanverifikatorNotif" value="" readonly="readonly" style="display:none" />
    
    <div class="card card-chat overflow-hidden">
        <div class="card-body d-flex p-0 h-100">
            <div class="chat-sidebar">
                <div class="contacts-list h-100 overflow-auto scrollbar-overlay">
                    <div class="nav nav-tabs border-0 flex-column" role="tablist" aria-orientation="vertical">

                        <div class="hover-actions-trigger chat-contact nav-item <?php echo $activeoptsekolah ?> list-verifikator" role="tab" data-verifikator="operator sekolah" id="chat-link-2" data-bs-toggle="tab" data-bs-target="#chat-2" aria-controls="chat-2" aria-selected="true">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Operator Sekolah</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumoptsekolah"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item <?php echo $activeoptbidang ?> list-verifikator" role="tab" data-verifikator="operator bidang" id="chat-link-3" data-bs-toggle="tab" data-bs-target="#chat-3" aria-controls="chat-3" aria-selected="false" style="<?php echo $hidverifikator;?>">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Operator Bidang</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumoptbidang"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item <?php echo $activekasi ?> list-verifikator" role="tab" data-verifikator="kepala seksi" id="chat-link-4" data-bs-toggle="tab" data-bs-target="#chat-4" aria-controls="chat-4" aria-selected="false" style="<?php echo $hidverifikator;?>">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Kepala Seksi</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumkasi"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item <?php echo $activekabid ?> list-verifikator" role="tab" data-verifikator="kepala bidang" id="chat-link-5" data-bs-toggle="tab" data-bs-target="#chat-5" aria-controls="chat-5" aria-selected="false" style="<?php echo $hidverifikator;?>">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Kepala Bidang</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumkabid"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!----------------------------
            akhir list verifikator SIDEBAR
            ----------------------------->
            <div class="tab-content card-chat-content">

                <div class="tab-pane card-chat-pane <?php echo $activeoptsekolah ?>" id="chat-2" role="tabpanel" aria-labelledby="chat-link-2">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Operator Sekolah</h5>
                                    <div class="fs--1 text-800 lbljumoptsekolah"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id ="area-pesan-operator-sekolah-notif"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane <?php echo $activeoptbidang ?>" id="chat-3" role="tabpanel" aria-labelledby="chat-link-3">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Operator Bidang</h5>
                                    <div class="fs--1 text-800 lbljumoptbidang"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-operator-bidang-notif"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane <?php echo $activekasi ?>" id="chat-4" role="tabpanel" aria-labelledby="chat-link-4">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Kepala Seksi</h5>
                                    <div class="fs--1 text-800 lbljumkasi"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-kasi-notif"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane <?php echo $activekabid ?>" id="chat-5" role="tabpanel" aria-labelledby="chat-link-5">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Kepala Bidang</h5>
                                    <div class="fs--1 text-800 lbljumkabid"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-kabid-notif"></div>
                    </div>
                </div>

                <div class="chat-editor-area">
                    <div class="emojiarea-editor outline-none scrollbar text-1000" contenteditable="true" id="txtisipesannotif"></div>
                    <button class="btn btn-sm btn-send shadow-none" id="cmdKirimPesanNotif">Send</button>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        var penerima = $("#txttranspenerimanotif").val();
        var pengirim = $("#txttranspengirimnotif").val();
        ambilJumlahPesan();
        isiNotifikasiPesan();
        $("#txtisipesannotif").text("");
        if (pengirim == "operator sekolah" || penerima == "operator sekolah"){
             $("#txttranspesanverifikatorNotif").val("operator sekolah");
             isiPesanOptSekolah();
        } else if (pengirim == "operator bidang" || penerima == "operator bidang"){
             $("#txttranspesanverifikatorNotif").val("operator bidang");
             isiPesanOptBidang();
        } else if (pengirim == "kepala seksi" || penerima == "kepala seksi"){
             $("#txttranspesanverifikatorNotif").val("kepala seksi");
             isiPesanKasi();
        } else if (pengirim == "kepala bidang" || penerima == "kepala bidang"){
             $("#txttranspesanverifikatorNotif").val("kepala bidang");
             isiPesanKabid();
        }
    });

    $('#modBebasData').on('shown.bs.modal', function(e) {
        $("#txtindikatorbukapesan").val("ON");
    });

    $('#modBebasData').on('hidden.bs.modal', function(e) {
        $("#txtindikatorbukapesan").val("OFF");
        $("#txtidsuratbukapesan").val("");
    });

    $(".list-verifikator").on("click",function () {
        $("#txtisipesannotif").text("");
        $("#txttranspesanverifikatorNotif").val("");
        var ketverifikator = $(this).data('verifikator');
        $("#txttranspesanverifikatorNotif").val(ketverifikator);

        if (ketverifikator == "operator sekolah"){isiPesanOptSekolah();}
        else if (ketverifikator == "operator bidang"){isiPesanOptBidang();}
        else if (ketverifikator == "kepala seksi"){isiPesanKasi();}
        else if (ketverifikator == "kepala bidang"){isiPesanKabid();}
    });

    $("#cmdKirimPesanNotif").on("click",function () {
        var idsekolah = $("#txttransidinstansiPsNotif").val();
        var idoperator = $("#lbleditor").val();
        var namaoperator = $("#lblnamaeditor").val();
        var pengirim = $("#lblnamalevel").val();
        var idtransaksi = $("#txttransidsuratPsNotif").val();
        var idlayanan = $("#txttransidlayananPsNotif").val();
        var isipesan = $("#txtisipesannotif").text();
        var penerima = $("#txttranspesanverifikatorNotif").val();
        
        var data = new FormData();
        data.append('idoperator', idoperator);
        data.append('namaoperator', namaoperator);
        data.append('pengirim', pengirim);
        data.append('idtransaksi', idtransaksi);
        data.append('idlayanan', idlayanan);
        data.append('isipesan', isipesan);
        data.append('penerima', penerima);
        data.append('idsekolah', idsekolah);

        if (idoperator.length <= 0 || pengirim.length <= 0 || idtransaksi.length <= 0 || idlayanan.length <= 0 || penerima.length <= 0) {
            console.log("Kelengkapan data tidak terdeteksi")
        } else if (isipesan.length <= 0) {
            $("#txtisipesannotif").focus();
            console.log("Isi pesan masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/trans-layanan/mutasi-siswa/pesan/aksi_tambah_pesan.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdKirimPesanNotif").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        $("#cmdKirimPesanNotif").removeAttr("disabled");
                        $("#txtisipesannotif").text("");

                        ambilJumlahPesan();
                        if (penerima == "operator sekolah"){
                            isiPesanOptSekolah();isiNotifikasiPesan();
                            //socket.emit('pesan verifikator level 3', idsekolah+"#"+"3");
                            //socket.emit('pesan level 3', idsekolah);}
                        } else if (penerima == "operator bidang"){
                            isiPesanOptBidang();isiNotifikasiPesan();
                        } else if (penerima == "kepala seksi"){
                            isiPesanKasi();isiNotifikasiPesan();
                        } else if (penerima == "kepala bidang"){
                            isiPesanKabid();isiNotifikasiPesan();
                        }
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdKirimPesanNotif").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdKirimPesanNotif").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdKirimPesanNotif").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });


    function ambilJumlahPesan() {
        var idtransaksi = $('#txttransidsuratPsNotif').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-layanan/mutasi-siswa/pesan/isi_jumlah_pesan.php",
            data: {idtransaksi: idtransaksi},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {

                $(".lbljumoptsekolah").html("");
                $(".lbljumoptbidang").html("");
                $(".lbljumkasi").html("");
                $(".lbljumkabid").html("");
  
                document.body.style.cursor = "default";
                var i;

                for (i = 0; i < data.length; i++) {

                    if (data[i].jumoptsekolah == 0){
                        $("#chat-link-2").removeClass("unread-message");
                        $(".lbljumoptsekolah").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-2").addClass("unread-message");
                        $(".lbljumoptsekolah").html(data[i].jumoptsekolah + " pesan");
                    }

                    if (data[i].jumloptbidang == 0){
                        $("#chat-link-3").removeClass("unread-message");
                        $(".lbljumoptbidang").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-3").addClass("unread-message");
                        $(".lbljumoptbidang").html(data[i].jumloptbidang + " pesan");
                    }

                    if (data[i].jumkasi == 0){
                        $("#chat-link-4").removeClass("unread-message");
                        $(".lbljumkasi").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-4").addClass("unread-message");
                        $(".lbljumkasi").html(data[i].jumkasi + " pesan");
                    }

                    if (data[i].jumkabid == 0){
                        $("#chat-link-5").removeClass("unread-message");
                        $(".lbljumkabid").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-5").addClass("unread-message");
                        $(".lbljumkabid").html(data[i].jumkabid + " pesan");
                    }

                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanOptSekolah() {
        var idtransaksi = $('#txttransidsuratPsNotif').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-layanan/mutasi-siswa/pesan/isi_pesan_operator_sekolah.php",
            data: {idtransaksi: idtransaksi},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-operator-sekolah-notif").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].pengirim != "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].pengirim == "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-operator-sekolah-notif').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanOptBidang() {
        var idtransaksi = $('#txttransidsuratPsNotif').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-layanan/mutasi-siswa/pesan/isi_pesan_operator_bidang.php",
            data: {idtransaksi: idtransaksi},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-operator-bidang-notif").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].pengirim != "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].pengirim == "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-operator-bidang-notif').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanKasi() {
        var idtransaksi = $('#txttransidsuratPsNotif').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-layanan/mutasi-siswa/pesan/isi_pesan_kasi.php",
            data: {idtransaksi: idtransaksi},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-kasi-notif").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].pengirim != "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].pengirim == "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-kasi-notif').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanKabid() {
        var idtransaksi = $('#txttransidsuratPsNotif').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-layanan/mutasi-siswa/pesan/isi_pesan_kabid.php",
            data: {idtransaksi: idtransaksi},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-kabid-notif").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].pengirim != "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].pengirim == "operator dapodik"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmpengirim + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-kabid-notif').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

</script>