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

$sql2  = "UPDATE tte_detail_pesan SET dibaca_operator_dapodik='Y' WHERE id_pesan='".$idpesan."'";
$res=mysqli_query($dbconn,$sql2);	

if($idlayanan == "2"){
    $qricbg = ("SELECT nama_siswa,no_order FROM tte_trans_verifikasi_pdb_mi WHERE id_transaksi='" . $idtransaksi . "'");
    $dbcabang = mysqli_query($dbconn, $qricbg);
    $c = mysqli_fetch_assoc($dbcabang);
    $namasiswa = ucwords(strtolower($c['nama_siswa']));
    $noorder = strtoupper($c['no_order']);
} else if($idlayanan == "3"){
    $qricbg = ("SELECT nama_ptk,no_order FROM tte_trans_mutasi_pendidik WHERE id_transaksi='" . $idtransaksi . "'");
    $dbcabang = mysqli_query($dbconn, $qricbg);
    $c = mysqli_fetch_assoc($dbcabang);
    $namasiswa = ucwords(strtolower($c['nama_ptk']));
    $noorder = strtoupper($c['no_order']);
} else if($idlayanan == "4"){
    $qricbg = ("SELECT nama,no_order FROM tte_trans_pergantian_kepsek WHERE id_transaksi='" . $idtransaksi . "'");
    $dbcabang = mysqli_query($dbconn, $qricbg);
    $c = mysqli_fetch_assoc($dbcabang);
    $namasiswa = ucwords(strtolower($c['nama']));
    $noorder = strtoupper($c['no_order']);
} else if($idlayanan == "5"){
    $qricbg = ("SELECT nama,no_order FROM tte_trans_perubahan_ptk WHERE id_transaksi='" . $idtransaksi . "'");
    $dbcabang = mysqli_query($dbconn, $qricbg);
    $c = mysqli_fetch_assoc($dbcabang);
    $namasiswa = ucwords(strtolower($c['nama']));
    $noorder = strtoupper($c['no_order']);
} else if($idlayanan == "6"){
    $qricbg = ("SELECT nama,no_order FROM tte_trans_pengajuan_npsn WHERE id_transaksi='" . $idtransaksi . "'");
    $dbcabang = mysqli_query($dbconn, $qricbg);
    $c = mysqli_fetch_assoc($dbcabang);
    $namasiswa = ucwords(strtolower($c['nama']));
    $noorder = strtoupper($c['no_order']);
} else if($idlayanan == "7"){
    $qricbg = ("SELECT nm_operator,npsn FROM tte_trans_pengajuan_akun_operator WHERE id_transaksi='" . $idtransaksi . "'");
    $dbcabang = mysqli_query($dbconn, $qricbg);
    $c = mysqli_fetch_assoc($dbcabang);
    $namasiswa = ucwords(strtolower($c['nm_operator']));
    $noorder = strtoupper($c['npsn']);
} else if($idlayanan == "8"){
    $qricbg = ("SELECT nm_yayasan,no_order FROM tte_trans_pengajuan_npyp WHERE id_transaksi='" . $idtransaksi . "'");
    $dbcabang = mysqli_query($dbconn, $qricbg);
    $c = mysqli_fetch_assoc($dbcabang);
    $namasiswa = ucwords(strtolower($c['nm_yayasan']));
    $noorder = strtoupper($c['no_order']);
}
mysqli_free_result($dbcabang);
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
                        <strong><?php echo $namasiswa ?></strong><br />NO. <?php echo $noorder ?><br /><?php echo $nmlayanan ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidsuratPs" value="<?php echo $idtransaksi ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidlayananPs" value="<?php echo $idlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidinstansiPs" value="<?php echo $idsekolah ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamalayananPs" value="<?php echo $nmlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamapemohonPs" value="<?php echo $namasiswa ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnosuratPs" value="<?php echo $nosurat ?>" readonly="readonly" style="display:none" />

    <input type="text" id="txttranspesanverifikator" value="" readonly="readonly" style="display:none" />

    <div class="card card-chat overflow-hidden">
        <div class="card-body d-flex p-0 h-100">
            <div class="tab-content card-chat-content">

                <div class="tab-pane card-chat-pane active" id="chat-2" role="tabpanel" aria-labelledby="chat-link-2">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Operator Dapodik</h5>
                                    <div class="fs--1 text-800 lbljumoptsekolah"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id ="area-pesan-operator-sekolah"></div>
                    </div>
                </div>

                <div class="chat-editor-area">
                    <div class="emojiarea-editor outline-none scrollbar text-1000" contenteditable="true" id="txtisipesan"></div>
                    <button class="btn btn-sm btn-send shadow-none" id="cmdKirimPesan">Send</button>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $("#txttranspesanverifikator").val("operator sekolah");
        $("#txtisipesan").text("");
        isiNotifikasiPesan();
        ambilJumlahPesan();
        isiPesanOptSekolah();
    });

    $('#modBebasData').on('shown.bs.modal', function(e) {
        $("#txtindikatorbukapesan").val("ON");
    });

    $('#modBebasData').on('hidden.bs.modal', function(e) {
        $("#txtindikatorbukapesan").val("OFF");
        $("#txtidsuratbukapesan").val("");
    });

    $(".list-verifikator").on("click",function () {
        $("#txtisipesan").text("");
        $("#txttranspesanverifikator").val("");
        var ketverifikator = $(this).data('verifikator');
        $("#txttranspesanverifikator").val(ketverifikator);

        if (ketverifikator == "operator sekolah"){isiPesanOptSekolah();}
    });

    $("#cmdKirimPesan").on("click",function () {
        var idsekolah = $("#lblidsekolah").val();
        var idoperator = $("#lbleditor").val();
        var namaoperator = $("#lblnamaeditor").val();
        var pengirim = $("#lblnamalevel").val();
        var idtransaksi = $("#txttransidsuratPs").val();
        var idlayanan = $("#txttransidlayananPs").val();
        var isipesan = $("#txtisipesan").text();
        var penerima = $("#txttranspesanverifikator").val();
        
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
            $("#txtisipesan").focus();
            console.log("Isi pesan masih kosong")
        } else {
            $.ajax({
                type: "POST",
                url: 'klinik-dapo/trans-layanan/pesan/aksi_tambah_pesan.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdKirimPesan").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        $("#cmdKirimPesan").removeAttr("disabled");
                        $("#txtisipesan").text("");

                        ambilJumlahPesan();
                        if (penerima == "operator sekolah"){
                            isiPesanOptSekolah();isiNotifikasiPesan();
                            //socket.emit('pesan verifikator level 3', idsekolah+"#"+"3");
                            //socket.emit('pesan level 3', idsekolah);}
                        }
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdKirimPesan").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdKirimPesan").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdKirimPesan").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });

    function ambilJumlahPesan() {
        var idtransaksi = $('#txttransidsuratPs').val();
        var idlayanan = $("#txttransidlayananPs").val();
        $.ajax({
            type: "POST",
            url: "klinik-dapo/trans-layanan/pesan/isi_jumlah_pesan.php",
            data: {idtransaksi: idtransaksi,idlayanan: idlayanan},
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
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanOptSekolah() {
        var idtransaksi = $('#txttransidsuratPs').val();
        var idlayanan = $("#txttransidlayananPs").val();
        $.ajax({
            type: "POST",
            url: "klinik-dapo/trans-layanan/pesan/isi_pesan_operator_sekolah.php",
            data: {idtransaksi: idtransaksi,idlayanan: idlayanan},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-operator-sekolah").html("");
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
                $('#area-pesan-operator-sekolah').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

</script>