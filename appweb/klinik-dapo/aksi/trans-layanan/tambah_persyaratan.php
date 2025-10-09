<?php
error_reporting(0);
$idsekolah = trim($_POST['idsekolah']);
$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$nmlayanan = trim($_POST['layanan']);
$nosurat = trim($_POST['nosurat']);
$namasiswa = trim($_POST['namasiswa']);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Upload Dokumen Persyaratan</h5>
        <p class="fs--1 mb-0 text-white">Upload Dokumen - <?php echo $nmlayanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $namasiswa ?><br />NO. <?php echo $nosurat ?><br /><?php echo $nmlayanan ?></strong><br /><br />
                        Lengkapi semua item persyaratan dibawah ini<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-upload"></span> &nbsp;&nbsp;(Ikon upload dokumen) untuk upload file dokumen (*.pdf),
                        Tombol &nbsp;&nbsp;<span class="fas fa-file-pdf"></span> &nbsp;&nbsp;(Ikon dokumen) untuk menampilkan file dokumen,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;(Ikon hapus) untuk menghapus file dokumen<br /><br />
                        <strong>Catatan</strong> : Semua item persyaratan (** wajib) harus ada / terupload.
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
    <input type="text" id="txttransjumlahfilePs" value="" readonly="readonly" style="display:none" />
    <input type="text" id="txttransjumlahsyaratPs" value="" readonly="readonly" style="display:none" />

    <div class="card z-index-1 mb-3">
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar mb-3">
                <table id="tabelDataPersyaratanUP" class="table table-sm table-striped mb-0 fs--1 overflow-hidden">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Dokumen Persyaratan</th>
                            <th class="sort">Upload</th>
                            <th class="sort">File</th>
                            <th class="sort text-center"></th>
                            <th class="sort text-center"></th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelDataPersyaratanUP">
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        isiMasterPersyaratan()
    });

    function isiMasterPersyaratan() {
        var idtransaksi = $('#txttransidsuratPs').val();
        var idlayanan = $('#txttransidlayananPs').val();
        var idsekolah = $('#txttransidinstansiPs').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-layanan/isi_tabel_persyaratan.php",
            data: {
                idtransaksi: idtransaksi,
                idlayanan: idlayanan,
                idsekolah: idsekolah
            },
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $('#isitabelDataPersyaratanUP').html("");
                document.body.style.cursor = "default";
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {

                    $("#txttransjumlahfilePs").val(data[i].jumlahfile);
                    $("#txttransjumlahsyaratPs").val(data[i].no);

                    if (data[i].sttsfile == "Y") {
                        var warnastts = "bg-success";
                        var ststusfile = "ADA";
                        var hidstatus = "";
                    } else if (data[i].sttsfile == "N") {
                        var warnastts = "bg-danger";
                        var ststusfile = "TIDAK ADA";
                        var hidstatus = "display:none";
                    }

                    if (data[i].modeupload == "WAJIB") {
                        var warnaupload = "bg-info";
                    } else if (data[i].modeupload == "OPSIONAL") {
                        var warnaupload = "bg-danger";
                    }

                    html +=
                        '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
                        '<td class="align-middle text-truncate" width="68%" style="max-width:150px;">' + data[i].persyaratan + '</td>' +
                        '<td class="align-middle" width="12%">' +
                        '<span class="badge ' + warnaupload + '">' + data[i].modeupload + '</span>' +
                        '</td>' +
                        '<td class="align-middle" width="10%">' +
                        '<span class="badge ' + warnastts + '">' + ststusfile + '</span>' +
                        '</td>' +
                        '<td class="align-middle text-center" width="2%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 text-600 btnFileUploadSyarat" data-idpersyaratan="' + data[i].idpersyaratan + '" data-persyaratan="' + data[i].persyaratan + '" data-nmfile="' + data[i].nmfile + '"><span class="fas fa-upload"></span></button> ' +
                        '</td>' +
                        '<td class="align-middle text-center" width="2%">' +
                        '<a href="syarat-' + idlayanan + '-' + data[i].mdtransaksi + '-' + data[i].mdsyarat + '.html" target="_blank" data-bs-toggle="tooltip" title="Tampilkan persyaratan" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm text-600" style="' + hidstatus + '"><span class="fas fa-file-pdf"></span></a>' +
                        '</td>' +
                        '<td class="align-middle text-center" width="2%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 text-warning btnFileHapusSyarat" data-idpersyaratan="' + data[i].idpersyaratan + '" data-persyaratan="' + data[i].persyaratan + '" data-nmfile="' + data[i].nmfile + '" style="' + hidstatus + '"><span class="fas fa-trash-alt"></span></button> ' +
                        '</td>' +
                        '</tr>';
                }

                $('#isitabelDataPersyaratanUP').html(html);
                $("#loading").fadeOut("slow");
            },
            error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    $('#isitabelDataPersyaratanUP').on('click', '.btnFileUploadSyarat', function() {
        var idinstansi = $('#txttransidinstansiPs').val();
        var idpersyaratan = $(this).data('idpersyaratan');
        var idtransaksi = $("#txttransidsuratPs").val();
        var idlayanan = $("#txttransidlayananPs").val();
        var nmlayanan = $("#txttransnamalayananPs").val();
        var nmpemohon = $("#txttransnamapemohonPs").val();
        var nosurat = $("#txttransnosuratPs").val();
        var persyaratan = $(this).data('persyaratan');
        var nmfile = $(this).data('nmfile');
        $.ajax({
            type: 'POST',
            url: "aksi/trans-layanan/tambah_upload_syarat.php",
            data: {
                idinstansi: idinstansi,
                idpersyaratan: idpersyaratan,
                persyaratan: persyaratan,
                persyaratan: persyaratan,
                nmfile: nmfile,
                idtransaksi: idtransaksi,
                idlayanan: idlayanan,
                nmlayanan: nmlayanan,
                nmpemohon: nmpemohon,
                nosurat: nosurat
            },
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(resp) {
                $("#loading").fadeOut("slow");
                document.body.style.cursor = "default";
                $("#isianmodUploadSyarat").html(resp);
                $("#isianmodUploadSyarat").fadeIn(1000);
                $("#modUploadSyarat").modal('show');
            },
            error: function() {
                $("#loading").fadeOut("slow");
                document.body.style.cursor = "default";
                alert("Koneksi ke server terputus");
            },
        });
    });

    $('#isitabelDataPersyaratanUP').on('click', '.btnFileHapusSyarat', function() {
        var idpersyaratan = $(this).data('idpersyaratan');
        var idtransaksi = $('#txttransidsuratPs').val();
        var idlayanan = $("#txttransidlayananPs").val();
        var idsekolah = $('#txttransidinstansiPs').val();
        var persyaratan = $(this).data('persyaratan');
        var nmfile = $(this).data('nmfile');
        let text = "Yakin menghapus file dokumen persyaratan\n" + persyaratan + "\n";
        if (confirm(text) == true) {
            $.ajax({
                type: "POST",
                url: "aksi/trans-layanan/aksi-hapus-file-syarat.php",
                data: {
                    idpersyaratan: idpersyaratan,
                    idsekolah: idsekolah,
                    idlayanan: idlayanan,
                    idtransaksi: idtransaksi,
                    nmfile: nmfile,
                    persyaratan: persyaratan
                },
                success: function(resp) {
                    isiMasterPersyaratanAfterUpload();
                    /*
                    var idinduk = $("#lblidinstansi").val();
                    var jumlahfile = $("#txttransjumlahfilePs").val();
                    var jumlahsyarat = $("#txttransjumlahsyaratPs").val();
                    if (jumlahfile == jumlahsyarat) {
                        socket.emit('upload syarat lengkap', idinduk);
                    }
                        */
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                },
            });
        }
    });

    function isiMasterPersyaratanAfterUpload() {
        var idtransaksi = $('#txttransidsuratPs').val();
        var idlayanan = $('#txttransidlayananPs').val();
        var idsekolah = $('#txttransidinstansiPs').val();
        $.ajax({
            type: "POST",
            url: "aksi/trans-layanan/isi_tabel_persyaratan.php",
            data: {
                idtransaksi: idtransaksi,
                idlayanan: idlayanan,
                idsekolah: idsekolah
            },
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $('#isitabelDataPersyaratanUP').html("");
                document.body.style.cursor = "default";
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {

                    $("#txttransjumlahfilePs").val(data[i].jumlahfile);
                    $("#txttransjumlahsyaratPs").val(data[i].no);

                    if (data[i].sttsfile == "Y") {
                        var warnastts = "bg-success";
                        var ststusfile = "ADA";
                        var hidstatus = "";
                    } else if (data[i].sttsfile == "N") {
                        var warnastts = "bg-danger";
                        var ststusfile = "TIDAK ADA";
                        var hidstatus = "display:none";
                    }

                    if (data[i].modeupload == "WAJIB") {
                        var warnaupload = "bg-info";
                    } else if (data[i].modeupload == "OPSIONAL") {
                        var warnaupload = "bg-danger";
                    }

                    html +=
                    '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
                        '<td class="align-middle text-truncate" width="68%" style="max-width:150px;">' + data[i].persyaratan + '</td>' +
                        '<td class="align-middle" width="12%">' +
                        '<span class="badge ' + warnaupload + '">' + data[i].modeupload + '</span>' +
                        '</td>' +
                        '<td class="align-middle" width="10%">' +
                        '<span class="badge ' + warnastts + '">' + ststusfile + '</span>' +
                        '</td>' +
                        '<td class="align-middle text-center" width="2%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 text-600 btnFileUploadSyarat" data-idpersyaratan="' + data[i].idpersyaratan + '" data-persyaratan="' + data[i].persyaratan + '" data-nmfile="' + data[i].nmfile + '"><span class="fas fa-upload"></span></button> ' +
                        '</td>' +
                        '<td class="align-middle text-center" width="2%">' +
                        '<a href="syarat-' + idlayanan + '-' + data[i].mdtransaksi + '-' + data[i].mdsyarat + '.html" target="_blank" data-bs-toggle="tooltip" title="Tampilkan persyaratan" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm text-600" style="' + hidstatus + '"><span class="fas fa-file-pdf"></span></a>' +
                        '</td>' +
                        '<td class="align-middle text-center" width="2%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 text-warning btnFileHapusSyarat" data-idpersyaratan="' + data[i].idpersyaratan + '" data-persyaratan="' + data[i].persyaratan + '" data-nmfile="' + data[i].nmfile + '" style="' + hidstatus + '"><span class="fas fa-trash-alt"></span></button> ' +
                        '</td>' +
                        '</tr>';
                }

                $('#isitabelDataPersyaratanUP').html(html);

                var idlayananOnFocus = $("#txtidlayananONFocus").val();
                if (idlayananOnFocus == "1") {
                    isiMutasiSiswa();
                } else if (idlayananOnFocus == "2") {
                    isiPDBMI();
                } else if (idlayananOnFocus == "3") {
                    isiMutasiPendidik();
                } else if (idlayananOnFocus == "4") {
                    isiPergantianKepsek();
                } else if (idlayananOnFocus == "5") {
                    isiPerubahanJenisPTK();
                } else if (idlayananOnFocus == "6") {
                    isiPengajuanNPSN();
                } else if (idlayananOnFocus == "7") {
                    isiPengajuanAkun();
                } else if (idlayananOnFocus == "8") {
                    isiPengajuanNPYP();
                }

                $("#loading").fadeOut("slow");
            },
            error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }
</script>