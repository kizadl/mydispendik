<?php
error_reporting(0);
$idinstansi = trim($_POST['idinstansi']);
$idsurat = trim($_POST['idsurat']);
$nmlayanan = trim($_POST['layanan']);
$nosurat = trim($_POST['nosurat']);
$nmpemohon = trim($_POST['nmpemohon']);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Arsip Pesan Verifikator</h5>
        <p class="fs--1 mb-0 text-white">Arsip Pesan Ke Verifikator - <?php echo $nmlayanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $nmpemohon ?></strong><br />NO. <?php echo $nosurat ?><br /><?php echo $nmlayanan ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidsuratPsA" value="<?php echo $idsurat ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidinstansiPsA" value="<?php echo $idinstansi ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamalayananPsA" value="<?php echo $nmlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamapemohonPsA" value="<?php echo $nmpemohon ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnosuratPsA" value="<?php echo $nosurat ?>" readonly="readonly" style="display:none" />

    <input type="text" id="txttranspesanverifikatora" value="" readonly="readonly" style="display:none" />

    <div class="card card-chat overflow-hidden">
        <div class="card-body d-flex p-0 h-100">
            <div class="chat-sidebar">
                <div class="contacts-list h-100 overflow-auto scrollbar-overlay">
                    <div class="nav nav-tabs border-0 flex-column" role="tablist" aria-orientation="vertical">

                        <div class="hover-actions-trigger chat-contact nav-item active list-verifikator" role="tab" data-verifikator="2" id="chat-link-2" data-bs-toggle="tab" data-bs-target="#chat-2" aria-controls="chat-2" aria-selected="true">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Verifikator 2</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumverifikator2"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item list-verifikator" role="tab" data-verifikator="3" id="chat-link-3" data-bs-toggle="tab" data-bs-target="#chat-3" aria-controls="chat-3" aria-selected="false">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Verifikator 3</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumverifikator3"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item list-verifikator unread-message" role="tab" data-verifikator="4" id="chat-link-4" data-bs-toggle="tab" data-bs-target="#chat-4" aria-controls="chat-4" aria-selected="false">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Verifikator 4</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumverifikator4"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item list-verifikator" role="tab" data-verifikator="5" id="chat-link-5" data-bs-toggle="tab" data-bs-target="#chat-5" aria-controls="chat-5" aria-selected="false">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Verifikator 5</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumverifikator5"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item list-verifikator" role="tab" data-verifikator="6" id="chat-link-6" data-bs-toggle="tab" data-bs-target="#chat-6" aria-controls="chat-6" aria-selected="false">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Verifikator 6</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumverifikator6"></div>
                                        <div class="position-absolute bottom-0 end-0 hover-hide"><span class="fas fa-check text-success" data-fa-transform="shrink-5 down-4"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover-actions-trigger chat-contact nav-item list-verifikator" role="tab" data-verifikator="7" id="chat-link-7" data-bs-toggle="tab" data-bs-target="#chat-7" aria-controls="chat-7" aria-selected="false">
                            <div class="d-flex p-3">
                                <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 chat-contact-title">Verifikator 7</h6>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="chat-contact-content pe-3 lbljumverifikator7"></div>
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

                <div class="tab-pane card-chat-pane active" id="chat-2" role="tabpanel" aria-labelledby="chat-link-2">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Verifikator 2</h5>
                                    <div class="fs--2 text-400 lbljumverifikator2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id ="area-pesan-level-2"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane" id="chat-3" role="tabpanel" aria-labelledby="chat-link-3">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Verifikator 3</h5>
                                    <div class="fs--2 text-400 lbljumverifikator3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-level-3"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane" id="chat-4" role="tabpanel" aria-labelledby="chat-link-4">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Verifikator 4</h5>
                                    <div class="fs--2 text-400 lbljumverifikator4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-level-4"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane" id="chat-5" role="tabpanel" aria-labelledby="chat-link-5">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Verifikator 5</h5>
                                    <div class="fs--2 text-400 lbljumverifikator5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-level-5"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane" id="chat-6" role="tabpanel" aria-labelledby="chat-link-6">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Verifikator 6</h5>
                                    <div class="fs--2 text-400 lbljumverifikator6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-level-6"></div>
                    </div>
                </div>
                <div class="tab-pane card-chat-pane" id="chat-7" role="tabpanel" aria-labelledby="chat-link-7">
                    <div class="chat-content-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-8 d-flex align-items-center">
                                <div class="min-w-0">
                                    <h5 class="mb-0 text-truncate fs-0">Verifikator 7</h5>
                                    <div class="fs--2 text-400 lbljumverifikator7"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-content-body" style="display: inherit;">
                        <div class="chat-content-scroll-area scrollbar" id="area-pesan-level-7"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $("#txttranspesanverifikatora").val("2");
        $("#txtisipesan").text("");
        ambilJumlahPesan();
        isiPesanLevel2();
    });

    $(".list-verifikator").on("click",function () {
        $("#txtisipesan").text("");
        $("#txttranspesanverifikatora").val("");
        var ketverifikator = $(this).data('verifikator');
        $("#txttranspesanverifikatora").val(ketverifikator);

        if (ketverifikator == "2"){isiPesanLevel2();}
        else if (ketverifikator == "3"){isiPesanLevel3();}
        else if (ketverifikator == "4"){isiPesanLevel4();}
        else if (ketverifikator == "5"){isiPesanLevel5();}
        else if (ketverifikator == "6"){isiPesanLevel6();}
        else if (ketverifikator == "7"){isiPesanLevel7();}
    });

    function ambilJumlahPesan() {
        var idsurat = $('#txttransidsuratPsA').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-surat/isi_jumlah_pesan.php",
            data: {idsurat: idsurat},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {

                $(".lbljumverifikator2").html("");
                $(".lbljumverifikator3").html("");
                $(".lbljumverifikator4").html("");
                $(".lbljumverifikator5").html("");
                $(".lbljumverifikator6").html("");
                $(".lbljumverifikator7").html("");

                document.body.style.cursor = "default";
                var i;

                for (i = 0; i < data.length; i++) {

                    if (data[i].jumlevel2 == 0){
                        $("#chat-link-2").removeClass("unread-message");
                        $(".lbljumverifikator2").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-2").addClass("unread-message");
                        $(".lbljumverifikator2").html(data[i].jumlevel2 + " pesan");
                    }

                    if (data[i].jumlevel3 == 0){
                        $("#chat-link-3").removeClass("unread-message");
                        $(".lbljumverifikator3").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-3").addClass("unread-message");
                        $(".lbljumverifikator3").html(data[i].jumlevel3 + " pesan");
                    }

                    if (data[i].jumlevel4 == 0){
                        $("#chat-link-4").removeClass("unread-message");
                        $(".lbljumverifikator4").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-4").addClass("unread-message");
                        $(".lbljumverifikator4").html(data[i].jumlevel4 + " pesan");
                    }

                    if (data[i].jumlevel5 == 0){
                        $("#chat-link-5").removeClass("unread-message");
                        $(".lbljumverifikator5").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-5").addClass("unread-message");
                        $(".lbljumverifikator5").html(data[i].jumlevel5 + " pesan");
                    }

                    if (data[i].jumlevel6 == 0){
                        $("#chat-link-6").removeClass("unread-message");
                        $(".lbljumverifikator6").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-6").addClass("unread-message");
                        $(".lbljumverifikator6").html(data[i].jumlevel6 + " pesan");
                    }

                    if (data[i].jumlevel7 == 0){
                        $("#chat-link-7").removeClass("unread-message");
                        $(".lbljumverifikator7").html("Tidak ada pesan");
                    } else {
                        $("#chat-link-7").addClass("unread-message");
                        $(".lbljumverifikator7").html(data[i].jumlevel7 + " pesan");
                    }

                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanLevel2() {
        var idsurat = $('#txttransidsuratPsA').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-surat/isi_pesan_level_2.php",
            data: {idsurat: idsurat},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-level-2").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].ketlevel != "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].ketlevel == "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-level-2').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanLevel3() {
        var idsurat = $('#txttransidsuratPsA').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-surat/isi_pesan_level_3.php",
            data: {idsurat: idsurat},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-level-3").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].ketlevel != "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].ketlevel == "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-level-3').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanLevel4() {
        var idsurat = $('#txttransidsuratPsA').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-surat/isi_pesan_level_4.php",
            data: {idsurat: idsurat},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-level-4").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].ketlevel != "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].ketlevel == "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-level-4').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanLevel5() {
        var idsurat = $('#txttransidsuratPsA').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-surat/isi_pesan_level_5.php",
            data: {idsurat: idsurat},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-level-5").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].ketlevel != "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].ketlevel == "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-level-5').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanLevel6() {
        var idsurat = $('#txttransidsuratPsA').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-surat/isi_pesan_level_6.php",
            data: {idsurat: idsurat},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-level-6").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].ketlevel != "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].ketlevel == "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-level-6').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiPesanLevel7() {
        var idsurat = $('#txttransidsuratPsA').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-surat/isi_pesan_level_7.php",
            data: {idsurat: idsurat},
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $("#area-pesan-level-7").html("");
                document.body.style.cursor = "default";
                var html = "";
                var i;
                for (i = 0; i < data.length; i++) {
                    if(data[i].ketlevel != "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1">'+
                                '<div class="w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex align-items-center">'+
                                        '<div class="chat-message bg-200 p-2 rounded-2"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 ms-1"><span>'+ data[i].tglpesan + ' - ' + data[i].jampesan + '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    } else if(data[i].ketlevel == "1"){
                        html +=
                        '<div class="d-flex p-3">'+
                            '<div class="flex-1 d-flex justify-content-end">'+
                                '<div class="w-100 w-xxl-75">'+
                                    '<div class="hover-actions-trigger d-flex flex-end-center">'+
                                        '<div class="bg-soft-success p-2 rounded-2 chat-message light"><strong>'+ data[i].nmoperator + ' :</strong><br/>'+ data[i].isipesan + '</div>'+
                                        '</div>'+
                                        '<div class="text-400 fs--2 text-end">'+ data[i].tglpesan + ' - ' + data[i].jampesan + '<span class="fas fa-check ms-2 text-success"></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
                $('#area-pesan-level-7').html(html);
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

</script>