<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Tambah Data Koordinator</h5>
		<p class="fs--1 mb-0 text-white">Silahkan menambahkan data koordinator</p>
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

	<div class="form-floating mb-3">
		<input type="text" class="form-control form-control-sm" id="txtnmkoordinator" value="" placeholder="Nama koordinator" maxlength="50" autocomplete="off">
		<label for="txtnmkoordinator">Nama Koordinator</label>
	</div>

	<div class="form-floating mb-3">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="cbouniversitaskoordinator" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih universitas</option>
			<?php
			$sqlbdg = ("SELECT id_universitas,nm_universitas FROM ats_universitas WHERE aktif='Y' ORDER BY nm_universitas ASC");
			$resultbdg = mysqli_query($dbconn, $sqlbdg);
			while ($bid = mysqli_fetch_array($resultbdg)) {
				$iduniversitas = $bid['id_universitas'];
				$nmuniversitas = ucwords(strtolower($bid['nm_universitas']));
				echo "
                        <option value='$iduniversitas'>$nmuniversitas</option>";
			}
			mysqli_free_result($resultbdg);
			mysqli_close($dbconn);
			?>
		</select>
		<label for="cbouniversitaskoordinator">Pilih Universitas</label>
	</div>

	<div class="form-floating mb-0">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="cbofakultaskoordinator" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih fakultas</option>
		</select>
		<label for="cbofakultaskoordinator">Pilih Fakultas</label>
	</div>

</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanKoordinator">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$("#txtnmkoordinator").val("");
		$("#cbouniversitaskoordinator").val("");
		$("#cbofakultaskoordinator").val("");
	});

	$("#cbouniversitaskoordinator").on("change", function() {
		var iduniversitas = $('#cbouniversitaskoordinator').val();
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
				$("#cbofakultaskoordinator").empty()
				$("#cbofakultaskoordinator").append('<option value="">Pilih fakultas</option>')
				var i;
				for (i = 0; i < data.length; i++) {
					$("#cbofakultaskoordinator").append('<option value="' + data[i].idfakultas + '">' + data[i].nmfakultas + '</option>')
				}
			},
			error: function() {
				console.log("Koneksi bermasalah periksa internet");
				document.body.style.cursor = "default";
			},
		});
	});

	$("#cmdSimpanKoordinator").click(function() {
		var nmkoordinator = $('#txtnmkoordinator').val();
		var iduniversitas = $('#cbouniversitaskoordinator').val();
		var idfakultas = $('#cbofakultaskoordinator').val();

		if (nmkoordinator.length <= 0) {
			$('#txtnmkoordinator').focus();
			alert('Nama koordinator masih kosong')
		} else if (iduniversitas.length <= 0) {
			$('#cbouniversitaskoordinator').focus();
			alert('Universitas masih kosong')
		} else if (idfakultas.length <= 0) {
			$('#cbofakultaskoordinator').focus();
			alert('Fakultas masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/koordinator/aksi_tambah.php',
				data: {
					nmkoordinator: nmkoordinator,
					iduniversitas: iduniversitas,
					idfakultas: idfakultas,
				},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanKoordinator").attr("disabled", "disabled");
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
						$("#cmdSimpanKoordinator").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanKoordinator").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanKoordinator").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});
</script>