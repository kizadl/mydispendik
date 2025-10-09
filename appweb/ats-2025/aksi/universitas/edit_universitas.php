<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$iduniversitas = trim($_POST['iduniversitas']);

$qri = ("SELECT nm_universitas FROM ats_universitas_2025 WHERE id_universitas='" . $iduniversitas . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmuniversitas = ucwords(strtolower($c['nm_universitas']));
mysqli_free_result($dbquery);
mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data Universitas</h5>
        <p class="fs--1 mb-0 text-white">Silahkan edit data universitas</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Universitas</strong> dibawah ini.<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input class="form-control" type="text" id="txtiduniversitasE" value="<?php echo $iduniversitas; ?>" style="display:none;" />

    <div class="form-floating mb-0">
        <input type="text" class="form-control form-control-sm" id="txtnmuniversitasE" value="<?php echo $nmuniversitas; ?>" placeholder="Nama Universitas" maxlength="100" autocomplete="off">
        <label for="txtnmuniversitasE">Nama Universitas</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanUniversitasE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cmdSimpanUniversitasE").click(function() {
        var iduniversitas = $('#txtiduniversitasE').val();
        var nmuniversitas = $('#txtnmuniversitasE').val();

        var data = new FormData();
        data.append('iduniversitas', iduniversitas);
        data.append('nmuniversitas', nmuniversitas);

        if (iduniversitas.length <= 0) {
            alert('Data Universitas tidak terdeteksi')
        } else if (nmuniversitas.length <= 0) {
            $('#txtnmuniversitasE').focus();
            alert('Nama Universitas masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/universitas/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanUniversitasE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterUniversitas();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanUniversitasE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanUniversitasE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanUniversitasE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>