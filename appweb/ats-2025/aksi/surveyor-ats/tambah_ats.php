<?php
error_reporting(0);
$idsurveyor = trim($_POST['idsurveyor']);
$idkecamatan = trim($_POST['idkecamatan']);
$nmsurveyor = trim($_POST['nmsurveyor']);
$nmuniversitas = trim($_POST['nmuniversitas']);
$nmfakultas = trim($_POST['nmfakultas']);
$namakecamatan = trim($_POST['nmkecamatan']);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Distribusi ATS - <?php echo $nmsurveyor ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data dengan memilih data ATS</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="row mb-2 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $nmsurveyor ?></strong>
                        <br><?php echo $nmuniversitas ?> - <?php echo $nmfakultas ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidsurveyortbhats" value="<?php echo $idsurveyor ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidkecamatantbhats" value="<?php echo $idkecamatan ?>" readonly="readonly" style="display:none" />

    <div class="card z-index-1 mb-1">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h6 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data ATS <?php echo $namakecamatan ?></h6>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshTambahDistribusiAts"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar mb-0">
                <table id="tableSiswaSelect" class="table table-hover table-sm mb-0 fs--1 overflow-hidden">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center"></th>
                            <th class="sort">Nama Siswa</th>
                            <th class="sort">NISN</th>
                            <th class="sort">Alamat</th>
                            <th class="sort">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableSiswaSelect">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanDistSurveyorToAts">Simpan data</button>
</div>

<script>
    $('#modTambahDistAts').on('shown.bs.modal', function(e) {
        isiPilihDataSiswa();
        $("#modTambahDataXtraLarge").modal("hide");
    });

    $("#modTambahDistAts").on("hide.bs.modal", function() {
        $("#modTambahDataXtraLarge").modal("show");
    });

    function isiPilihDataSiswa() {
        var idkecamatan = $('#txttransidkecamatantbhats').val();
        var idsurveyor = $('#txttransidsurveyortbhats').val();
        $.ajax({
            type: "POST",
            url: "aksi/surveyor-ats/isi_tabel_list_ats.php",
            data: {
                idsurveyor: idsurveyor,
                idkecamatan: idkecamatan,
            },
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $('#tableSiswaSelect').dataTable().fnDestroy();
                document.body.style.cursor = "default";
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html +=
                        '<tr id="' + data[i].idsiswa + '">' +
                        '<td class="align-middle text-center" width="4%"></td>' +
                        '<td class="align-middle text-truncate" width="18%" style="max-width:100px;">' + data[i].namasiswa + '</td>' +
                        '<td class="align-middle" width="10%">' + data[i].nisn + '</td>' +
                        '<td class="align-middle text-truncate" width="44%" style="max-width:200px;">' + data[i].alamat + ' - ' + data[i].desa + ' - ' + data[i].kecamatan + '</td>' +
                        '<td class="align-middle text-truncate" width="24%" style="max-width:120px;">' + data[i].statusats + ' ' + data[i].bentukpendidikan + '  Kelas : ' + data[i].tingkatpendidikan + '</td>' +
                        '</tr>';
                }

                $('#isitableSiswaSelect').html(html);
                var tabeleAts;
                tabeleAts = $("#tableSiswaSelect").dataTable({
                    "paging": true,
                    "lengthChange": false,
                    "pageLength": 25,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": false,
                    "scrollX": false,
                    columnDefs: [{
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    }],
                    select: {
                        style: 'os',
                        //selector: 'td:not(:last-child)'
                    },
                    order: [
                        [1, 'asc']
                    ],
                    initComplete: function() {
                        $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
                    },
                    "searching": true,
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

    $("#cmdRefreshTambahDistribusiAts").click(function() {
        isiPilihDataSiswa();
    });

    $("#cmdSimpanDistSurveyorToAts").click(function() {
        var idsurveyor = $('#txttransidsurveyortbhats').val();
        var arridats = [];
        var tabeleAts = $('#tableSiswaSelect').DataTable();
        $.each(tabeleAts.rows('.selected').nodes(), function(i, item) {
            var idats = item.id;
            arridats.push(idats);
        });

        if (idsurveyor.length <= 0) {
            alert('Surveyor tidak terdeteksi')
        } else if (arridats.length <= 0) {
            alert('Data ats masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/surveyor-ats/aksi_tambah.php',
                data:{idsurveyor:idsurveyor,arridats:arridats},
                dataType: "json",
                beforeSend: function(e) {
                    $("#cmdSimpanDistSurveyorToAts").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDistAts').modal('hide');
                        }, 1000);
                        isiMasterDistribusiSurveyor();
                        isiSurveyorATS();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanDistSurveyorToAts").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanDistSurveyorToAts").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanDistSurveyorToAts").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>