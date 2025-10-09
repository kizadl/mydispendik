<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsurveyor = trim($_POST['idsurveyor']);

$qri = ("SELECT nm_surveyor,id_universitas,id_fakultas,id_kecamatan,id_desa,telepon FROM ats_surveyor WHERE id_surveyor='" . $idsurveyor . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmsurveyor = ucwords(strtolower($c['nm_surveyor']));
$iduniversitas = $c['id_universitas'];
$idfakultas = $c['id_fakultas'];
$idkecamatan = $c['id_kecamatan'];
$iddesa = $c['id_desa'];
$telepon = $c['telepon'];
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Edit Data Surveyor</h5>
        <p class="fs--1 mb-0 text-white">Silahkan edit data surveyor</p>
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

    <input class="form-control" type="text" id="txtidsurveyorE" value="<?php echo $idsurveyor; ?>" style="display:none;" />

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtnmsurveyorE" value="<?php echo $nmsurveyor; ?>" placeholder="Nama Surveyor" maxlength="100" autocomplete="off">
        <label for="txtnmsurveyorE">Nama Surveyor</label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbouniversitassurveyorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih universitas</option>
            <?php
            $sqlbdg = ("SELECT id_universitas,nm_universitas FROM ats_universitas WHERE aktif='Y' ORDER BY nm_universitas ASC");
            $resultbdg = mysqli_query($dbconn, $sqlbdg);
            while ($bid = mysqli_fetch_array($resultbdg)) {
                $iduniversitase = $bid['id_universitas'];
                $nmuniversitase = ucwords(strtolower($bid['nm_universitas']));
                if ($iduniversitas == $iduniversitase) {
                    $plhuniv = "selected";
                } else {
                    $plhuniv = "";
                }
                echo "
                        <option value='$iduniversitase' $plhuniv >$nmuniversitase</option>";
            }
            mysqli_free_result($resultbdg);
            ?>
        </select>
        <label for="cbouniversitassurveyorE">Pilih Universitas</label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbofakultassurveyorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih fakultas</option>
            <?php
            $sqlfakul = ("SELECT id_fakultas,nm_fakultas FROM ats_fakultas WHERE aktif='Y' AND id_universitas='" . $iduniversitas . "' ORDER BY nm_fakultas ASC");
            $resultfakultas = mysqli_query($dbconn, $sqlfakul);
            while ($f = mysqli_fetch_array($resultfakultas)) {
                $idfakultase = $f['id_fakultas'];
                $nmfakultase = ucwords(strtolower($f['nm_fakultas']));
                if ($idfakultase == $idfakultas) {
                    $plhfakul = "selected";
                } else {
                    $plhfakul = "";
                }
                echo "
                        <option value='$idfakultase' $plhfakul >$nmfakultase</option>";
            }
            mysqli_free_result($resultfakultas);
            ?>
        </select>
        <label for="cbofakultassurveyorE">Pilih Fakultas</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtnoteleponsurveyorE" value="<?php echo $telepon; ?>" placeholder="NIM" maxlength="25" autocomplete="off">
        <label for="txtnoteleponsurveyorE">NIM</label>
    </div>

    <div class="form-floating mb-2">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="cbokecacmatansurveyorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih kecamatan</option>
			<?php
			$sqlkc = ("SELECT kd_kecamatan,nama_kecamatan FROM m_kecamatan ORDER BY nama_kecamatan ASC");
			$resultkc = mysqli_query($dbconn, $sqlkc);
			while ($kc = mysqli_fetch_array($resultkc)) {
				$kdkecamatane = $kc['kd_kecamatan'];
				$namakecamatane = ucwords(strtolower($kc['nama_kecamatan']));
                if ($kdkecamatane == $idkecamatan) {
                    $plhkec = "selected";
                } else {
                    $plhkec = "";
                }
				echo "
                        <option value='$kdkecamatane' $plhkec >$namakecamatane</option>";
			}
			mysqli_free_result($resultkc);
			?>
		</select>
		<label for="cbokecacmatansurveyorE">Wilayah Kecamatan</label>
	</div>

    <div class="form-floating mb-0">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="cbodesasurveyorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih desa</option>
			<?php
			$sqlds = ("SELECT kd_desa,nama_desa FROM m_desa ORDER BY nama_desa ASC");
			$resultds = mysqli_query($dbconn, $sqlds);
			while ($ds = mysqli_fetch_array($resultds)) {
				$kddesane = $ds['kd_desa'];
				$namadesane = ucwords(strtolower($ds['nama_desa']));
                if ($kddesane == $iddesa) {
                    $plhdesa = "selected";
                } else {
                    $plhdesa = "";
                }
				echo "
                        <option value='$kddesane' $plhdesa >$namadesane</option>";
			}
			mysqli_free_result($resultds);
			mysqli_close($dbconn);
			?>
		</select>
		<label for="cbodesasurveyorE">Wilayah Desa</label>
	</div>


</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanSurveyorE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cbouniversitassurveyorE").on("change", function() {
        var iduniversitas = $('#cbouniversitassurveyorE').val();
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
                $("#cbofakultassurveyorE").empty()
                $("#cbofakultassurveyorE").append('<option value="">Pilih fakultas</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cbofakultassurveyorE").append('<option value="' + data[i].idfakultas + '">' + data[i].nmfakultas + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cbokecacmatansurveyorE").on("change", function() {
        var idkecamatan = $("#cbokecacmatansurveyorE").val()
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

                $("#cbodesasurveyorE").empty()
                $("#cbodesasurveyorE").append('<option value="">Pilih desa</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cbodesasurveyorE").append('<option value="' + data[i].iddesa + '">' + data[i].nmdesa + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cmdSimpanSurveyorE").click(function() {
        var idsurveyor = $('#txtidsurveyorE').val();
        var nmsurveyor = $('#txtnmsurveyorE').val();
        var iduniversitas = $('#cbouniversitassurveyorE').val();
        var idfakultas = $('#cbofakultassurveyorE').val();
        var nohp = $('#txtnoteleponsurveyorE').val();
        var idkecamatan = $('#cbokecacmatansurveyorE').val();
        var iddesa = $('#cbodesasurveyorE').val();

        var data = new FormData();
        data.append('idsurveyor', idsurveyor);
        data.append('nmsurveyor', nmsurveyor);
        data.append('iduniversitas', iduniversitas);
        data.append('idfakultas', idfakultas);
        data.append('nohp', nohp);
        data.append('idkecamatan', idkecamatan);
        data.append('iddesa', iddesa);

        if (idsurveyor.length <= 0) {
            alert('Data surveyor tidak terdeteksi')
        } else if (nmsurveyor.length <= 0) {
            $('#txtnmsurveyorE').focus();
            alert('Nama surveyor masih kosong')
        } else if (iduniversitas.length <= 0) {
            $('#cbouniversitassurveyorE').focus();
            alert('Universitas masih kosong')
        } else if (idfakultas.length <= 0) {
            $('#cbofakultassurveyorE').focus();
            alert('Fakultas masih kosong')
        } else if (nohp.length <= 0) {
            $('#txtnoteleponsurveyorE').focus();
            alert('NIM masih kosong')
        } else if (idkecamatan.length <= 0) {
            $('#cbokecacmatansurveyorE').focus();
            alert('Area kecamatan masih kosong')
        } else if (iddesa.length <= 0) {
            $('#cbodesasurveyorE').focus();
            alert('Area desa kelurahan masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/surveyor/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanSurveyorE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterSurveyor();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanSurveyorE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanSurveyorE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanSurveyorE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>