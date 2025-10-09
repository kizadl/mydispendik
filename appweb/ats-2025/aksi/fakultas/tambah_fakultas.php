<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Tambah Data Fakultas</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data fakultas</p>
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

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmfakultas" value="" placeholder="Nama fakultas" maxlength="100" autocomplete="off">
        <label for="txtnmfakultas">Nama Fakultas</label>
    </div>

    <div class="form-floating mb-1">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbouniversitas" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih universitas</option>
            <?php
            $qrikec = ("SELECT id_universitas,nm_universitas FROM ats_universitas_2025 WHERE aktif='Y' ORDER BY nm_universitas ASC");
            $liskec = mysqli_query($dbconn, $qrikec);
            while ($j = mysqli_fetch_array($liskec)) {
                echo "<option value=\"" . $j['id_universitas'] . "\">" . ucwords(strtolower($j['nm_universitas'])) . "</option>";
            }
            mysqli_free_result($liskec);
            mysqli_close($dbconn);
            ?>
        </select>
        <label for="cbouniversitas">Pilihan Universitas</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanFakultas">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnmfakultas").val("");
        $("#cbouniversitas").val("");
    });

    $("#cmdSimpanFakultas").click(function() {
        var nmfakultas = $('#txtnmfakultas').val();
        var iduniversitas = $('#cbouniversitas').val();

        var data = new FormData();
        data.append('nmfakultas', nmfakultas);
        data.append('iduniversitas', iduniversitas);

        if (nmfakultas.length <= 0) {
            $('#txtnmfakultas').focus();
            alert('Nama fakultas masih kosong')
        } else if (iduniversitas.length <= 0) {
            $('#cbouniversitas').focus();
            alert('Universitas masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/fakultas/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanFakultas").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterFakultas();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanFakultas").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanFakultas").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanFakultas").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>