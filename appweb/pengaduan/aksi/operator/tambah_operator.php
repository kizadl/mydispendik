<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Tambah Operator Bidang</h5>
		<p class="fs--1 mb-0 text-white">Silahkan menambahkan data operator bidang</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi isian data <strong>Operator Bidang</strong> dibawah ini.<br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data <strong>Operator Bidang</strong>
					</p>

				</div>
			</div>
		</div>
	</div>

	<div class="form-floating mb-3">
		<input type="text" class="form-control form-control-sm" id="txtnmoperator" value="" placeholder="Nama lengkap" maxlength="50" autocomplete="off">
		<label for="txtnmoperator">Nama Operator</label>
	</div>


	<div class="form-floating mb-1" style="display:block">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="optbidangOperator" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih Bidang</option>
			<?php
			$sqlbdg = ("SELECT id_bidang,nm_bidang FROM m_bidang");
			$resultbdg = mysqli_query($dbconn, $sqlbdg);
			while ($bid = mysqli_fetch_array($resultbdg)) {
				$idbidang = $bid['id_bidang'];
				$nmbidang = $bid['nm_bidang'];
				echo "
                        <option value='$idbidang'>$nmbidang</option>";
			}
			?>
		</select>
		<label for="optbidangOperator">Pilih Bidang</label>
	</div>

</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanOperator">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$("#txtnmoperator").val("");$("#optbidangOperator").val("");
	});

	$("#cmdSimpanOperator").click(function() {
		var nmuser = $('#txtnmoperator').val();
		var idbidang = $('#optbidangOperator').val();

		if (nmuser.length <= 0) {
			$('#txtnmoperator').focus();
			alert('Nama operator bidang masih kosong')
		} else if (idbidang.length <= 0) {
			$('#optbidangOperator').focus();
			alert('Pilihan bidang masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/operator/aksi_tambah.php',
				data: {
					nmuser: nmuser,
					idbidang: idbidang,
				},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanOperator").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modTambahDataLarge').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
						isiMasterOperator();
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanOperator").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanOperator").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanOperator").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});
</script>