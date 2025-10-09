<?php
error_reporting(0);
$idlayanan = trim($_POST['idlayanan']);
$nmlayanan = trim($_POST['nmlayanan']);
?>
<!------------------MODAL PENCARIAN ------------------>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Persyaratan <?php echo $nmlayanan ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambah. edit atau hapus data persyaratan <?php echo $nmlayanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="row mb-2 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tekan tombol <strong>Tambah Data</strong> untuk menambah data<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data
                        <strong><?php echo $nmlayanan ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidlayananPs" value="<?php echo $idlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamalayananPs" value="<?php echo $nmlayanan ?>" readonly="readonly" style="display:none" />

    <div class="card z-index-1 mb-1">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button" id="cmdTambahPersyaratan"><span class="d-none d-sm-inline-block ms-1">Tambah
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshPersyaratan"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar mb-0">
                <table id="tabelPersyaratan" class="table table-sm table-striped mb-0 fs--1 overflow-hidden">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Persyaratan Layanan</th>
                            <th class="sort">Nama File</th>
                            <th class="sort">Upload</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelPersyaratan">
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
        var idlayanan = $('#txttransidlayananPs').val();
        $.ajax({
            type: "POST",
            url: "aksi/persyaratan/isi_tabel_persyaratan.php",
            data: {
                idlayanan: idlayanan
            },
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $('#tabelPersyaratan').dataTable().fnDestroy();
                document.body.style.cursor = "default";
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html +=
                        '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
                        '<td class="align-middle text-truncate" width="45%" style="max-width:150px;">' + data[i].persyaratan + '</td>' +
                        '<td class="align-middle text-truncate" width="33%" style="max-width:80px;">' + data[i].nmfile + '</td>' +
                        '<td class="align-middle" width="10%">' + data[i].modeupload + '</td>' +
                        '<td class="d-flex align-middle text-center" width="8%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditPersyaratan" data-iddetail="' + data[i].iddetail + '"><span class="fas fa-edit"></span></button> ' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusPersyaratan" data-iddetail="' + data[i].iddetail + '" data-persyaratan="' + data[i].persyaratan + '"><span class="fas fa-trash-alt"></span></button>' +
                        '</td>' +
                        '</tr>';
                }

                $('#isitabelPersyaratan').html(html);
                $("#tabelPersyaratan").dataTable({
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

    $("#cmdRefreshPersyaratan").click(function() {
        isiMasterPersyaratan();
    });

    $("#cmdTambahPersyaratan").click(function() {
        var idlayanan = $("#txttransidlayananPs").val();
        var nmlayanan = $("#txttransnamalayananPs").val();
        $.ajax({
            type: "POST",
            url: "aksi/persyaratan/tambah_persyaratan.php",
            data: {
                idlayanan: idlayanan,
                nmlayanan: nmlayanan
            },
            success: function(resp) {
                $("#isianmodTambahDataLargeBebas").html(resp);
                $("#isianmodTambahDataLargeBebas").fadeIn(1000);
                $("#modTambahDataLargeBebas").modal('show');
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
            },
        });
    });

    $('#isitabelPersyaratan').on('click', '.btnEditPersyaratan', function() {
        var idpersyaratan = $(this).data('iddetail');
        var nmlayanan = $("#txttransnamalayananPs").val();
        $.ajax({
            type: 'POST',
            url: "aksi/persyaratan/edit_persyaratan.php",
            data: {
                idpersyaratan: idpersyaratan,
                nmlayanan: nmlayanan
            },
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(resp) {
                $("#loading").fadeOut("slow");
                document.body.style.cursor = "default";
                $("#isianmodTambahDataLargeBebas").html(resp);
                $("#isianmodTambahDataLargeBebas").fadeIn(1000);
                $("#modTambahDataLargeBebas").modal('show');
            },
            error: function() {
                $("#loading").fadeOut("slow");
                document.body.style.cursor = "default";
                alert("Koneksi ke server terputus");
            },
        });
    });

    $('#isitabelPersyaratan').on('click', '.btnHapusPersyaratan', function() {
        var idpersyaratan = $(this).data('iddetail');
        var persyaratan = $(this).data('persyaratan');
        let text = "Yakin menghapus data persyaratan\n" + persyaratan;
        if (confirm(text) == true) {
            $.ajax({
                type: "POST",
                url: "aksi/persyaratan/aksi_hapus.php",
                data: {
                    idpersyaratan: idpersyaratan
                },
                success: function(resp) {
                    $("#ToastHapus").toast("show");
                    isiMasterPersyaratan();
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                },
            });
        }
    });
</script>