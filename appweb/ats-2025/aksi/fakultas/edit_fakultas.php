<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idfakultas = trim($_POST['idfakultas']);

$qri = ("SELECT nm_fakultas,id_universitas FROM ats_fakultas_2025 WHERE id_fakultas='" . $idfakultas . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmfakultas = ucwords(strtolower($c['nm_fakultas']));
$iduniversitas = $c['id_universitas'];
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data Fakultas</h5>
        <p class="fs--1 mb-0 text-white">Silahkan edit data fakultas</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Fakultas</strong> dibawah ini.<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input class="form-control" type="text" id="txtidfakultasE" value="<?php echo $idfakultas; ?>" style="display:none;" />

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmfakultasE" value="<?php echo $nmfakultas; ?>" placeholder="Nama Fakultas" maxlength="100" autocomplete="off">
        <label for="txtnmfakultasE">Nama Fakultas</label>
    </div>

    <div class="form-floating mb-1">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbouniversitasE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih universitas</option>
            <?php
            $qrikec = ("SELECT id_universitas,nm_universitas FROM ats_universitas_2025 WHERE aktif='Y' ORDER BY nm_universitas ASC");
            $liskec = mysqli_query($dbconn, $qrikec);
            while ($j = mysqli_fetch_array($liskec)) {
                if ($iduniversitas == $j['id_universitas']) {
                    $plhins = "selected";
                } else {
                    $plhins = "";
                }
                echo "<option value=\"" . $j['id_universitas'] . "\" $plhins >" . ucwords(strtolower($j['nm_universitas'])) . "</option>";
            }
            mysqli_free_result($liskec);
            mysqli_close($dbconn);
            ?>
        </select>
        <label for="cbouniversitasE">Pilihan Universitas</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanFakultasE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cmdSimpanFakultasE").click(function() {
        var idfakultas = $('#txtidfakultasE').val();
        var nmfakultas = $('#txtnmfakultasE').val();
        var iduniversitas = $('#cbouniversitasE').val();

        var data = new FormData();
        data.append('idfakultas', idfakultas);
        data.append('nmfakultas', nmfakultas);
        data.append('iduniversitas', iduniversitas);

        if (idfakultas.length <= 0) {
            alert('Data Fakultas tidak terdeteksi')
        } else if (nmfakultas.length <= 0) {
            $('#txtnmfakultasE').focus();
            alert('Nama Fakultas masih kosong')
        } else if (iduniversitas.length <= 0) {
            $('#cbouniversitasE').focus();
            alert('Universitas masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/fakultas/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanFakultasE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterFakultas();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanFakultasE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanFakultasE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanFakultasE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>