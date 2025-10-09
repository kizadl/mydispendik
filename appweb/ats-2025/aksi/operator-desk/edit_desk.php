<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$iduser = trim($_POST['iduser']);

$qri = ("SELECT nm_user FROM ats_user_2025 WHERE id='" . $iduser . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmuser = ucwords(strtolower($c['nm_user']));
mysqli_free_result($dbquery);
mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Edit Data Operator Desk</h5>
		<p class="fs--1 mb-0 text-white">Silahkan edit data operator desk</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi isian data <strong>Operator Desk</strong> dibawah ini.<br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data <strong>Operator Desk</strong>
					</p>

				</div>
			</div>
		</div>
	</div>

	<input type="text" class="form-control form-control-sm" id="txtidoperatordeskE" value="<?php echo $iduser; ?>" style="display:none">

	<div class="form-floating mb-0">
		<input type="text" class="form-control form-control-sm" id="txtnmoperatordeskE" value="<?php echo $nmuser; ?>" placeholder="Nama operator" maxlength="50" autocomplete="off">
		<label for="txtnmoperatordeskE">Nama Operator</label>
	</div>

</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanOperatorDeskE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$("#cmdSimpanOperatorDeskE").click(function() {
		var iduser = $('#txtidoperatordeskE').val();
		var nmuser = $('#txtnmoperatordeskE').val();

		if (iduser.length <= 0) {
			alert('Data operator desk tidak terdeteksi')
		} else if (nmuser.length <= 0) {
			$('#txtnmoperatordeskE').focus();
			alert('Nama operator desk masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/operator-desk/aksi_edit.php',
				data: {
					iduser: iduser,
					nmuser: nmuser,
				},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanOperatorDeskE").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modTambahDataLarge').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
						isiMasterOperatorDesk();
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanOperatorDeskE").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanOperatorDeskE").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanOperatorDeskE").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});
</script>