<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idoperator = trim($_POST['idoperator']);

$qri = ("SELECT nm_operator,akses,id_bidang FROM m_operator WHERE id_operator='" . $idoperator . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmoperator = strtoupper($c['nm_operator']);
$idbidangnya = $c['id_bidang'];
$akses = $c['akses'];
if ($akses == "operator bidang" OR $akses == "" OR $akses == NULL){
	$hidcbobidang ="";
} else {$hidcbobidang ="display:none";}
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Edit Data Operator</h5>
		<p class="fs--1 mb-0 text-white">Silahkan edit data operator</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi isian data <strong>Operator</strong> dibawah ini.<br />
						Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data <strong>Operator</strong>
					</p>

				</div>
			</div>
		</div>
	</div>

	<input type="text" class="form-control form-control-sm" id="txtidoperatorE" value="<?php echo $idoperator; ?>" style="display:none">

	<div class="form-floating mb-3">
		<input type="text" class="form-control form-control-sm" id="txtnmoperatorE" value="<?php echo $nmoperator; ?>" placeholder="Nama lengkap" maxlength="50" autocomplete="off">
		<label for="txtnmoperatorE">Nama Operator</label>
	</div>

	<div class="form-floating mb-0">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="optAksesOperatorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih Akses</option>
			<?php
			if ($akses == "operator bidang") {
				$plhoptbidang = "selected";
			} else if ($akses == "operator dapodik") {
				$plhoptdapo = "selected";
			}
			echo "
				<option value='operator dapodik' $plhoptdapo >Operator Dapodik</option>
				<option value='operator bidang' $plhoptbidang >Operator Bidang</option>";
			?>
		</select>
		<label for="optAksesOperatorE">Pilih Akses</label>
	</div>

	<div class="form-floating mb-1 mt-3" style="<?php echo $hidcbobidang; ?>" id="area-cbobidangE">
		<select class="form-select form-select-sm js-choice fs--1 px-3" id="optbidangOperatorE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih Bidang</option>
			<?php
			$sqlbdg = ("SELECT id_bidang,nm_bidang FROM tte_m_bidang WHERE aktif='Y'");
			$resultbdg = mysqli_query($dbconn, $sqlbdg);
			while ($bid = mysqli_fetch_array($resultbdg)) {
				$idbidang = $bid['id_bidang'];
				$nmbidang = $bid['nm_bidang'];

				if ($idbidangnya == $idbidang) {
					$pilihbidang = "selected";
				} else {
					$pilihbidang = "";
				}
				echo "
                        <option value='$idbidang' $pilihbidang >$nmbidang</option>";
			}
			mysqli_free_result($resultbdg);
			mysqli_close($dbconn);
			?>
		</select>
		<label for="optbidangOperatorE">Pilih Bidang</label>
	</div>


</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanOperatorE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">

	$("#optAksesOperatorE").on("change", function() {
		var akses = $('#optAksesOperatorE').val();
		$("#optbidangOperatorE").val("");
		if (akses == "operator dapodik" || akses == "") {
			$("#area-cbobidangE").css("display", "none");
		} else if (akses == "operator bidang") {
			$("#area-cbobidangE").css("display", "block");
		}
	});

	$("#cmdSimpanOperatorE").on("click", function() {
		var idoperator = $('#txtidoperatorE').val();
		var idbidang = $('#optbidangOperatorE').val();
		var nmuser = $('#txtnmoperatorE').val();
		var akses = $('#optAksesOperatorE').val();

		if (idoperator.length <= 0) {
			alert('Data operator tidak terdeteksi')
		} else if (nmuser.length <= 0) {
			$('#txtnmoperatorE').focus();
			alert('Nama operator masih kosong')
		} else if (akses.length <= 0) {
			$('#optAksesOperatorE').focus();
			alert('Pilihan hak akses masih kosong')
		} else if (akses == "operator bidang" && idbidang.length <= 0) {
			$('#optbidangOperatorE').focus();
			alert('Pilihan bidang masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/operator/aksi_edit.php',
				data: {
					nmuser: nmuser,
					akses: akses,
					idbidang: idbidang,
					idoperator: idoperator
				},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanOperatorE").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modTambahDataLarge').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
						isiMasterVerifikator();
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanOperatorE").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanOperatorE").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanOperatorE").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});
</script>