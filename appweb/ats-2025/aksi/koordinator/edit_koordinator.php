<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idkoordinator = trim($_POST['idkoordinator']);

$qri = ("SELECT nm_koordinator,id_universitas,id_fakultas FROM ats_koordinator_2025 WHERE id_koordinator='" . $idkoordinator . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmkoordinator = ucwords(strtolower($c['nm_koordinator']));
$iduniversitas = $c['id_universitas'];
$idfakultas = $c['id_fakultas'];
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Edit Data Koordinator</h5>
		<p class="fs--1 mb-0 text-white">Silahkan edit data koordinator</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi isian data <strong>Koordinator</strong> dibawah ini.<br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data <strong>Koordinator</strong>
					</p>

				</div>
			</div>
		</div>
	</div>

	<input type="text" class="form-control form-control-sm" id="txtidkoordinatorE" value="<?php echo $idkoordinator; ?>" style="display:none">

	<div class="form-floating mb-3">
		<input type="text" class="form-control form-control-sm" id="txtnmkoordinatorE" value="<?php echo $nmkoordinator; ?>" placeholder="Nama koordinator" maxlength="50" autocomplete="off">
		<label for="txtnmkoordinatorE">Nama Koordinator</label>
	</div>

	<div class="form-floating mb-3">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="cbouniversitaskoordinatorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih universitas</option>
			<?php
			$sqlbdg = ("SELECT id_universitas,nm_universitas FROM ats_universitas_2025 WHERE aktif='Y' ORDER BY nm_universitas ASC");
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
		<label for="cbouniversitaskoordinatorE">Pilih Universitas</label>
	</div>

	<div class="form-floating mb-0">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="cbofakultaskoordinatorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih fakultas</option>
			<?php
			$sqlfakul = ("SELECT id_fakultas,nm_fakultas FROM ats_fakultas_2025 WHERE aktif='Y' AND id_universitas='" . $iduniversitas . "' ORDER BY nm_fakultas ASC");
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
			mysqli_close($dbconn);
			?>
		</select>
		<label for="cbofakultaskoordinatorE">Pilih Fakultas</label>
	</div>

</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanKoordinatorE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$("#cbouniversitaskoordinatorE").on("change", function() {
		var iduniversitas = $('#cbouniversitaskoordinatorE').val();
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
				$("#cbofakultaskoordinatorE").empty()
				$("#cbofakultaskoordinatorE").append('<option value="">Pilih fakultas</option>')
				var i;
				for (i = 0; i < data.length; i++) {
					$("#cbofakultaskoordinatorE").append('<option value="' + data[i].idfakultas + '">' + data[i].nmfakultas + '</option>')
				}
			},
			error: function() {
				console.log("Koneksi bermasalah periksa internet");
				document.body.style.cursor = "default";
			},
		});
	});

	$("#cmdSimpanKoordinatorE").click(function() {
		var idkoordinator = $('#txtidkoordinatorE').val();
		var nmkoordinator = $('#txtnmkoordinatorE').val();
		var iduniversitas = $('#cbouniversitaskoordinatorE').val();
		var idfakultas = $('#cbofakultaskoordinatorE').val();

		if (idkoordinator.length <= 0) {
			alert('Data koordinator tidak terdeteksi')
		} else if (nmkoordinator.length <= 0) {
			$('#txtnmkoordinatorE').focus();
			alert('Nama koordinator masih kosong')
		} else if (iduniversitas.length <= 0) {
			$('#cbouniversitaskoordinatorE').focus();
			alert('Universitas masih kosong')
		} else if (idfakultas.length <= 0) {
			$('#cbofakultaskoordinatorE').focus();
			alert('Fakultas masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/koordinator/aksi_edit.php',
				data: {
					idkoordinator: idkoordinator,
					nmkoordinator: nmkoordinator,
					iduniversitas: iduniversitas,
					idfakultas: idfakultas,
				},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanKoordinatorE").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modTambahDataLarge').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
						isiMasterKoordinator();
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanKoordinatorE").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanKoordinatorE").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanKoordinatorE").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});
</script>