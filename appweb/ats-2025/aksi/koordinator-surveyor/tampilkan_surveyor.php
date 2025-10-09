<?php
error_reporting(0);
$idkoordinator = trim($_POST['idkoordinator']);
$iduniversitas = trim($_POST['iduniversitas']);
$idfakultas = trim($_POST['idfakultas']);
$nmkoordinator = trim($_POST['nmkoordinator']);
$nmuniversitas = trim($_POST['nmuniversitas']);
$nmfakultas = trim($_POST['nmfakultas']);
?>
<!------------------MODAL PENCARIAN ------------------>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Distribusi Surveyor - <?php echo $nmkoordinator ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambah. edit atau hapus data surveyor</p>
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
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>Surveyor</strong>
                        <br><strong><?php echo $nmkoordinator ?></strong>
                        <br><?php echo $nmuniversitas ?> - <?php echo $nmfakultas ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidkoordinator" value="<?php echo $idkoordinator ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransiduniversitas" value="<?php echo $iduniversitas ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidfakultas" value="<?php echo $idfakultas ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamakoordinator" value="<?php echo $nmkoordinator ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamauniversitas" value="<?php echo $nmuniversitas ?>" readonly="readonly" style="display:none" />

    <div class="card z-index-1 mb-1">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahDistribusiSurveyor"><span class="d-none d-sm-inline-block ms-1">Tambah
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshDistribusiSurveyor"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar mb-0">
                <table id="tabelDistribusiSurveyor" class="table table-hover table-sm table-striped mb-0 fs--1 overflow-hidden">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Nama Surveyor</th>
                            <th class="sort">Fakultas</th>
                            <th class="sort">NIM</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelDistribusiSurveyor">
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        isiMasterDistribusiSurveyor()
    });

    function isiMasterDistribusiSurveyor() {
        var idkoordinator = $('#txttransidkoordinator').val();
        $.ajax({
            type: "POST",
            url: "aksi/koordinator-surveyor/isi_tabel_surveyor.php",
            data: {
                idkoordinator: idkoordinator
            },
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $('#tabelDistribusiSurveyor').dataTable().fnDestroy();
                document.body.style.cursor = "default";
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html +=
                        '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
                        '<td class="align-middle text-truncate" width="30%" style="max-width:150px;">' + data[i].nmsurveyor + '</td>' +
                        '<td class="align-middle text-truncate" width="42%" style="max-width:180px;">' + data[i].nmfakultas + '</td>' +
                        '<td class="align-middle text-truncate" width="20%" style="max-width:80px;">' + data[i].telepon + '</td>' +
                        '<td class="align-middle text-center" width="4%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusDistribusiSurveyor" data-idsurveyor="' + data[i].idsurveyor + '" data-telepon="' + data[i].telepon + '" data-nmsurveyor="' + data[i].nmsurveyor + '"><span class="fas fa-trash-alt"></span></button>' +
                        '</td>' +
                        '</tr>';
                }

                $('#isitabelDistribusiSurveyor').html(html);
                $("#tabelDistribusiSurveyor").dataTable({
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

    $("#cmdRefreshDistribusiSurveyor").click(function() {
        isiMasterDistribusiSurveyor();
    });

    $("#cmdTambahDistribusiSurveyor").click(function() {
        var idkoordinator = $("#txttransidkoordinator").val();
        var nmkoordinator = $("#txttransnamakoordinator").val();
        var iduniversitas = $('#txttransiduniversitas').val();
        var namauniversitas = $('#txttransnamauniversitas').val();
        $.ajax({
            type: "POST",
            url: "aksi/koordinator-surveyor/tambah_surveyor.php",
            data: {
                idkoordinator: idkoordinator,
                nmkoordinator: nmkoordinator,
                iduniversitas: iduniversitas,namauniversitas:namauniversitas
            },
            success: function(resp) {
                $("#isianmodTambahKoorToSurveyor").html(resp);
                $("#isianmodTambahKoorToSurveyor").fadeIn(1000);
                $("#modTambahKoorToSurveyor").modal('show');
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
            },
        });
    });

    $('#isitabelDistribusiSurveyor').on('click', '.btnHapusDistribusiSurveyor', function() {
        var idsurveyor = $(this).data('idsurveyor');
        var nmsurveyor = $(this).data('nmsurveyor');var telepon = $(this).data('telepon');
        let text = "Yakin menghapus data surveyor\n" + nmsurveyor + "\n" + telepon;
        if (confirm(text) == true) {
            $.ajax({
                type: "POST",
                url: "aksi/koordinator-surveyor/aksi_hapus.php",
                data: {
                    idsurveyor: idsurveyor
                },
                success: function(resp) {
                    $("#ToastHapus").toast("show");
                    isiMasterDistribusiSurveyor();isiKoordinatorSurveyor();
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                },
            });
        }
    });
</script>