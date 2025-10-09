<?php
error_reporting(0);
$idkoordinator = trim($_POST['idkoordinator']);
$iduniversitas = trim($_POST['iduniversitas']);
$nmkoordinator = trim($_POST['nmkoordinator']);
$namauniversitas = trim($_POST['namauniversitas']);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Distribusi Surveyor - <?php echo $nmkoordinator ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data surveyor <?php echo $namauniversitas ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <input type="text" id="txttransidkoordinatortosurveyor" value="<?php echo $idkoordinator ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransiduniversitaskoortosurveyor" value="<?php echo $iduniversitas ?>" readonly="readonly" style="display:none" />

    <div class="card z-index-1 mb-1">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h6 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Surveyor</h6>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshTambahDistribusiSurveyor"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar mb-0">
                <table id="tabelTambahDistribusiSurveyor" class="table table-sm table-hover mb-0 fs--1 overflow-hidden">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center"></th>
                            <th class="sort">Nama Surveyor</th>
                            <th class="sort">Fakultas</th>
                            <th class="sort">NIM</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelTambahDistribusiSurveyor">
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanDistKoorToSurveyor">Simpan data</button>
</div>

<script>
 
    $('#modTambahKoorToSurveyor').on('shown.bs.modal', function(e) {
        isiTambahDistribusiKorToSurveyor();
        $("#modDistKoorToSurveyor").modal("hide");
    });

    $("#modTambahKoorToSurveyor").on("hide.bs.modal", function() {
        $("#modDistKoorToSurveyor").modal("show");
    });

    function isiTambahDistribusiKorToSurveyor() {
        var iduniversitas = $('#txttransiduniversitaskoortosurveyor').val();
        $.ajax({
            type: "POST",
            url: "aksi/koordinator-surveyor/isi_tabel_list_surveyor.php",
            data: {
                iduniversitas: iduniversitas
            },
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $('#tabelTambahDistribusiSurveyor').dataTable().fnDestroy();
                document.body.style.cursor = "default";
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html +=
                        '<tr id="' + data[i].idsurveyor + '">' +
                        '<td class="align-middle text-center" width="4%"></td>' +
                        '<td class="align-middle text-truncate" width="30%" style="max-width:150px;">' + data[i].nmsurveyor + '</td>' +
                        '<td class="align-middle text-truncate" width="44%" style="max-width:180px;">' + data[i].nmfakultas + '</td>' +
                        '<td class="align-middle text-truncate" width="22%" style="max-width:80px;">' + data[i].telepon + '</td>' +
                        '</tr>';
                }

                $('#isitabelTambahDistribusiSurveyor').html(html);
                var tabelesurveyor;				
				tabelesurveyor = $("#tabelTambahDistribusiSurveyor").dataTable({
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

    $("#cmdRefreshTambahDistribusiSurveyor").click(function() {
        isiTambahDistribusiKorToSurveyor();
    });

    $("#cmdSimpanDistKoorToSurveyor").click(function() {
        var idkoordinator = $('#txttransidkoordinatortosurveyor').val();
        var arridsurveyor = [];
        var tabelesurveyor = $('#tabelTambahDistribusiSurveyor').DataTable();
        $.each(tabelesurveyor.rows('.selected').nodes(), function(i, item) {
            var idsurveyor = item.id;
            arridsurveyor.push(idsurveyor);
        });

        if (idkoordinator.length <= 0) {
            alert('Koordinator tidak terdeteksi')
        } else if (arridsurveyor.length <= 0) {
            alert('Data surveyor masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/koordinator-surveyor/aksi_tambah.php',
                data:{idkoordinator:idkoordinator,arridsurveyor:arridsurveyor},
                dataType: "json",
                beforeSend: function(e) {
                    $("#cmdSimpanDistKoorToSurveyor").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahKoorToSurveyor').modal('hide');
                        }, 1000);
                        isiMasterDistribusiSurveyor();
                        isiKoordinatorSurveyor();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanDistKoorToSurveyor").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanDistKoorToSurveyor").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanDistKoorToSurveyor").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });

</script>