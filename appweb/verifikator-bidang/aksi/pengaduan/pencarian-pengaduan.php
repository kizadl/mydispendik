<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idpengaduan = trim($_POST['idpengaduan']);

$sqlbid = ("SELECT p.stts_pengaduan
FROM pengaduan p 
WHERE p.id_pengaduan = '" . $idpengaduan . "'");
$resultbid = mysqli_query($dbconn, $sqlbid);
$s = mysqli_fetch_assoc($resultbid);
$sttspengaduan = $s['stts_pengaduan'];
if ($s['stts_pengaduan'] == "distribusi") {
    $hidencmdteruskan = "";
} else if ($s['stts_pengaduan'] == "jawaban") {
    $hidencmdteruskan = "display:none;";
} else if ($s['stts_pengaduan'] == "selesai") {
    $hidencmdteruskan = "display:none;";
}
?>
<!------------------MODAL PENCARIAN ------------------>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Distribusi Pengaduan</h5>
        <p class="fs--1 mb-0 text-white">Distribusi pengaduan Ke Bidang</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <input class="form-control" type="text" id="txtkatapencarianpengaduan" value="<?php echo $idpengaduan ?>" autocomplete="off" style="font-size:13px;display:none;" />
    <input class="form-control" type="text" id="txtstatuspengaduan" value="<?php echo $sttspengaduan ?>" autocomplete="off" style="font-size:13px;display:none;" />

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                    <table class="fs--1">
                        <tr>
                            <td>Identitas Pelapor</td>
                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                            <td><span class="lblnmpengadu"></span></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                            <td><span id="lblalamatpengadu"></span></td>
                        </tr>
                        <tr>
                            <td>No. Telepon / WA </td>
                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                            <td><span id="lblteleponpengadu"></span></td>
                        </tr>
                    </table>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive scrollbar mb-3">
        <table id="tblcaripengaduan" class="table table-sm table-striped mb-0 fs--1 w-100">
            <thead class="bg-200">
                <tr>
                    <th class="sort text-center">No</th>
                    <th class="sort">Waktu</th>
                    <th class="sort">Uraian Masalah</th>
                    <th class="sort text-center">Status</th>
                    <th class="sort text-center"></th>
                </tr>
            </thead>
            <tbody class="bg-white" id="isitblcaripengaduan"></tbody>
        </table>
    </div>

    <div class="row mb-0 g-3">
        <div class="col-xxl-12">
            <div class="card bg-info text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong>Status Pengaduan</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 mt-0 g-3">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body">
                    <div id="area-timeline"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-light mb-0" id="area-bidang" style="<?php echo $hidencmdteruskan ?>">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1"><strong>Isi Jawaban Pertanyaan</strong></p>
            <textarea class="fs--2" name="content" id="txtisiuraianjawaban"><?php echo $uraianfaq ?></textarea>
        </div>
    </div>

</div>

<div class="modal-footer float-right">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdTeruskanBidang" style="<?php echo $hidencmdteruskan ?>">Kirim Ke Pelapor</button>
</div>

<script src="../vendors/tinymce/tinymce.min.js"></script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: "#txtisiuraianjawaban",
            height: "360",
            content_style: "body { font-size: 11pt; font-family: Arial;line-height: 1.0; }",
        });

        isiTabelPencarianPengaduan();
        isiTimelineStatus();
    });

    function isiTabelPencarianPengaduan() {
        $('.lblnmpengadu').html("");
        $('#lblalamatpengadu').html("");
        $('#lblteleponpengadu').html("");
        var idpengaduan = $('#txtkatapencarianpengaduan').val();
        $.ajax({
            type: "POST",
            url: "aksi/pengaduan/isi_tabel_pencarian.php",
            data: {
                idpengaduan: idpengaduan
            },
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";
                $('#tblcaripengaduan').dataTable().fnDestroy();
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {

                    $('.lblnmpengadu').html(data[i].nmpengadu);
                    $('#lblalamatpengadu').html(data[i].alamat);
                    $('#lblteleponpengadu').html(data[i].notelepon);

                    if (data[i].sttspengaduan == "BELUM") {
                        var warnastts = "bg-danger";
                    } else if (data[i].sttspengaduan == "DISTRIBUSI") {
                        var warnastts = "bg-warning";
                    } else if (data[i].sttspengaduan == "JAWABAN") {
                        var warnastts = "bg-success";
                    } else if (data[i].sttspengaduan == "SELESAI") {
                        var warnastts = "bg-primary";
                    }

                    html +=
                        '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle text-center" width="5%">' + data[i].no + '</td>' +
                        '<td class="align-middle" width="15%">' + data[i].tanggal + '</td>' +
                        '<td class="align-middle" width="65%">' + data[i].uraianmasalah + '</td>' +
                        '<td class="align-middle text-center" width="10%"><span class="badge ' + warnastts + '">' + data[i].sttspengaduan + '</span></td>' +
                        '<td class="align-middle text-center" width="5%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnViewstatusCari" data-id="' + data[i].idpengaduan + '" data-bs-toggle="tooltip" title="Lihat status"><span class="fas fa-check"></span></button>' +
                        '</td>' +
                        '</tr>';
                }
                $('#isitblcaripengaduan').html(html);
                $("#tblcaripengaduan").dataTable({
                    "paging": false,
                    "lengthChange": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": false,
                    "select": false,
                    "scrollX": false,
                    initComplete: function() {
                        $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
                    },
                    "searching": false,
                });
                $("#loading").fadeOut("slow");

            },
            error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    function isiTimelineStatus() {
        $('#area-timeline').html("");
        var idpengaduan = $('#txtkatapencarianpengaduan').val();
        $.ajax({
            type: "POST",
            url: "aksi/pengaduan/area-timeline-pengaduan.php",
            data: {
                idpengaduan: idpengaduan
            },
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";
                $('#area-timeline').html("");
                $('#area-timeline').html(data);
                $("#loading").fadeOut("slow");

            },
            error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    $('#isitblcaripengaduan').on('click', '.btnViewstatusCari', function() {
        var idpengaduan = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "aksi/pengaduan/area-timeline-pengaduan-history.php",
            data: {
                idpengaduan: idpengaduan
            },
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";
                $('#area-timeline').html("");
                $('#area-timeline').html(data);
            },
            error: function() {
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cmdTeruskanBidang").click(function() {
        var idoperator = $('#lbleditor').val();
        var idpengaduan = $('#txtkatapencarianpengaduan').val();
        var isiuraian = tinymce.get("txtisiuraianjawaban").getContent();

        var data = new FormData();
        data.append('idoperator', idoperator);
        data.append('idpengaduan', idpengaduan);
        data.append('isiuraian', isiuraian);

        if (idpengaduan.length <= 0) {
            alert('Pengaduan tidak terdeteksi')
        } else if (isiuraian.length <= 0) {
            $('#txtisiuraianjawaban').focus();
            alert('Isi uraian jawaban belum ditentukan')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/pengaduan/aksi_teruskan_pengaduan.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdTeruskanBidang").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterPengaduan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdTeruskanBidang").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdTeruskanBidang").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdTeruskanBidang").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>