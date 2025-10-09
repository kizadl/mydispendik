<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Tambah Data Surveyor</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data surveyor</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Surveyor</strong> dibawah ini.<br />
                        Isi data <strong>No. Telepon</strong> dengan benar. Data nomor telepon akan ditetapkan sebagai <strong>Username dan Password</strong>.<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtnmsurveyor" value="" placeholder="Nama Surveyor" maxlength="100" autocomplete="off">
        <label for="txtnmsurveyor">Nama Surveyor</label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbouniversitassurveyor" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih universitas</option>
            <?php
            $sqlbdg = ("SELECT id_universitas,nm_universitas FROM ats_universitas_2025 WHERE aktif='Y' ORDER BY nm_universitas ASC");
            $resultbdg = mysqli_query($dbconn, $sqlbdg);
            while ($bid = mysqli_fetch_array($resultbdg)) {
                $iduniversitase = $bid['id_universitas'];
                $nmuniversitase = ucwords(strtolower($bid['nm_universitas']));

                echo "
                        <option value='$iduniversitas'>$nmuniversitas</option>";
            }
            mysqli_free_result($resultbdg);
            ?>
        </select>
        <label for="cbouniversitassurveyor">Pilih Universitas</label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbofakultassurveyor" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih fakultas</option>
        </select>
        <label for="cbofakultassurveyor">Pilih Fakultas</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtnoteleponsurveyor" value="" placeholder="NIM" maxlength="25" autocomplete="off">
        <label for="txtnoteleponsurveyor">NIM</label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbokecacmatansurveyor" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih kecamatan</option>
            <?php
            $sqlkc = ("SELECT kd_kecamatan,nama_kecamatan FROM m_kecamatan ORDER BY nama_kecamatan ASC");
            $resultkc = mysqli_query($dbconn, $sqlkc);
            while ($kc = mysqli_fetch_array($resultkc)) {
                $kdkecamatan = $kc['kd_kecamatan'];
                $namakecamatan = ucwords(strtolower($kc['nama_kecamatan']));
                echo "
                        <option value='$kdkecamatan'>$namakecamatan</option>";
            }
            mysqli_free_result($resultkc);
            mysqli_close($dbconn);
            ?>
        </select>
        <label for="cbokecacmatansurveyor">Wilayah Kecamatan</label>
    </div>

    <div class="form-floating mb-0">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbodesasurveyor" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih desa</option>
        </select>
        <label for="cbodesasurveyor">Wilayah Desa</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanSurveyor">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnmsurveyor").val("");
        $("#cbofakultassurveyor").val("");
        $("#txtnoteleponsurveyor").val("");
        $("#cbokecacmatansurveyor").val("");
        $("#cbodesasurveyor").val("");
    });

    $("#cbouniversitassurveyor").on("change", function() {
        var iduniversitas = $('#cbouniversitassurveyor').val();
        $.ajax({
            type: "POST",
            url: "aksi/koordinator/ambil_data_fakultas.php",
            data: {
                iduniversitas: iduniversitas
            },
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";
                $("#cbofakultassurveyor").empty()
                $("#cbofakultassurveyor").append('<option value="">Pilih fakultas</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cbofakultassurveyor").append('<option value="' + data[i].idfakultas + '">' + data[i].nmfakultas + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cbokecacmatansurveyor").on("change", function() {
        var idkecamatan = $("#cbokecacmatansurveyor").val()
        $.ajax({
            type: "POST",
            url: "aksi/surveyor/ambil_data_desa.php",
            data: {
                idkecamatan: idkecamatan
            },
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";

                $("#cbodesasurveyor").empty()
                $("#cbodesasurveyor").append('<option value="">Pilih desa</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cbodesasurveyor").append('<option value="' + data[i].iddesa + '">' + data[i].nmdesa + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cmdSimpanSurveyor").click(function() {
        var nmsurveyor = $('#txtnmsurveyor').val();
        var iduniversitas = $('#cbouniversitassurveyor').val();
        var idfakultas = $('#cbofakultassurveyor').val();
        var nohp = $('#txtnoteleponsurveyor').val();
        var idkecamatan = $('#cbokecacmatansurveyor').val();
        var iddesa = $('#cbodesasurveyor').val();

        var data = new FormData();
        data.append('nmsurveyor', nmsurveyor);
        data.append('iduniversitas', iduniversitas);
        data.append('idfakultas', idfakultas);
        data.append('nohp', nohp);
        data.append('idkecamatan', idkecamatan);
        data.append('iddesa', iddesa);

        if (nmsurveyor.length <= 0) {
            $('#txtnmsurveyor').focus();
            alert('Nama surveyor masih kosong')
        } else if (iduniversitas.length <= 0) {
            $('#cbouniversitassurveyor').focus();
            alert('Universitas masih kosong')
        } else if (idfakultas.length <= 0) {
            $('#cbofakultassurveyor').focus();
            alert('Fakultas masih kosong')
        } else if (nohp.length <= 0) {
            $('#txtnoteleponsurveyor').focus();
            alert('NIM masih kosong')
        } else if (idkecamatan.length <= 0) {
            $('#cbokecacmatansurveyor').focus();
            alert('Area kecamatan masih kosong')
        } else if (iddesa.length <= 0) {
            $('#cbodesasurveyor').focus();
            alert('Area desa kelurahan masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/surveyor/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanSurveyor").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterSurveyor();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanSurveyor").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanSurveyor").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanSurveyor").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>