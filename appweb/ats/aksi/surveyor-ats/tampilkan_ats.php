<?php
error_reporting(0);
$idsurveyor = trim($_POST['idsurveyor']);
$iduniversitas = trim($_POST['iduniversitas']);
$idfakultas = trim($_POST['idfakultas']);
$idkecamatan = trim($_POST['idkecamatan']);
$nmsurveyor = trim($_POST['nmsurveyor']);
$nmuniversitas = trim($_POST['nmuniversitas']);
$nmfakultas = trim($_POST['nmfakultas']);
$namakecamatan = trim($_POST['namakecamatan']);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Distribusi ATS - <?php echo $nmsurveyor ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambah atau menghapus data ATS</p>
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
                        <br><?php echo $namakecamatan ?><br>
                        Tekan tombol <strong>Tambah Data</strong> untuk menambah data,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>ATS</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidsurveyor" value="<?php echo $idsurveyor ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidkecamatan" value="<?php echo $idkecamatan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnmuniversitas" value="<?php echo $nmuniversitas ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnmfakultas" value="<?php echo $nmfakultas ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnmkecamatan" value="<?php echo $namakecamatan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnamasurveyor" value="<?php echo $nmsurveyor ?>" readonly="readonly" style="display:none" />

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
                            <th class="sort">Nama Siswa</th>
                            <th class="sort">NISN</th>
                            <th class="sort">Alamat</th>
                            <th class="sort">Keterangan</th>
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
        var idsurveyor = $('#txttransidsurveyor').val();
        $.ajax({
            type: "POST",
            url: "aksi/surveyor-ats/isi_tabel_ats.php",
            data: {
                idsurveyor: idsurveyor
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
                        '<td class="align-middle text-center" width="3%">' + data[i].no + '</td>' +
                        '<td class="align-middle text-truncate" width="18%" style="max-width:100px;">' + data[i].namasiswa + '</td>' +
                        '<td class="align-middle" width="10%">' + data[i].nisn + '</td>' +
                        '<td class="align-middle text-truncate" width="44%" style="max-width:200px;">' + data[i].alamat + ' - ' + data[i].desa + ' - ' + data[i].kecamatan + '</td>' +
                        '<td class="align-middle text-truncate" width="21%" style="max-width:120px;">' + data[i].statusats + ' ' + data[i].bentukpendidikan + '  Kelas : ' + data[i].tingkatpendidikan + '</td>' +
                        '<td class="align-middle text-center" width="4%">' +
                        '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusDistribusiSurveyor" data-idsiswa="' + data[i].idsiswa + '" data-namasiswa="' + data[i].namasiswa + '" data-alamat="' + data[i].alamat + '" data-desa="' + data[i].desa + '" data-kecamatan="' + data[i].kecamatan + '"><span class="fas fa-trash-alt"></span></button>' +
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
        var idsurveyor = $("#txttransidsurveyor").val();
        var idkecamatan = $('#txttransidkecamatan').val();
        var nmsurveyor = $("#txttransnamasurveyor").val();
        var nmkecamatan = $('#txttransnmkecamatan').val();
        var nmuniversitas = $('#txttransnmuniversitas').val();
        var nmfakultas = $('#txttransnmfakultas').val();
        $.ajax({
            type: "POST",
            url: "aksi/surveyor-ats/tambah_ats.php",
            data: {
                idsurveyor: idsurveyor,
                idkecamatan: idkecamatan,
                nmsurveyor: nmsurveyor,
                nmkecamatan: nmkecamatan,
                nmuniversitas: nmuniversitas,
                nmfakultas: nmfakultas,
            },
            success: function(resp) {
                $("#isianmodTambahDistAts").html(resp);
                $("#isianmodTambahDistAts").fadeIn(1000);
                $("#modTambahDistAts").modal('show');
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
            },
        });
    });

    $('#isitabelDistribusiSurveyor').on('click', '.btnHapusDistribusiSurveyor', function() {
        var idsiswa = $(this).data('idsiswa');
        var namasiswa = $(this).data('namasiswa');
        var alamat = $(this).data('alamat');
        var desa = $(this).data('desa');
        var kecamatan = $(this).data('kecamatan');
        let text = "Yakin menghapus data ATS\n" + namasiswa + "\n" + alamat + "\n" + desa + " - " + kecamatan;
        if (confirm(text) == true) {
            $.ajax({
                type: "POST",
                url: "aksi/surveyor-ats/aksi_hapus.php",
                data: {
                    idsiswa: idsiswa
                },
                success: function(resp) {
                    $("#ToastHapus").toast("show");
                    isiMasterDistribusiSurveyor();
                    isiSurveyorATS();
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                },
            });
        }
    });
</script>