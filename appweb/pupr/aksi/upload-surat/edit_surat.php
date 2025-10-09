<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsekolah = trim($_POST['idsekolah']);
$npsn = trim($_POST['npsn']);

$qri = ("SELECT nama FROM tbl_api_dispendik WHERE npsn='" . $npsn . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nama = strtoupper($c['nama']);

mysqli_free_result($dbquery);
mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Upload Surat Persetujuan</h5>
		<p class="fs--1 mb-0 text-white">Silahkan upload data persetujuan</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

	<input class="form-control" type="text" id="txtidsekolahupload" value="<?php echo $idsekolah; ?>" style="display:none;" />
	<input class="form-control" type="text" id="txtnpsnupload" value="<?php echo $npsn; ?>" style="display:none;" />

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-light h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
						Lengkapi isian data upload <strong>Surat Persetujuan</strong> dibawah ini<br />Tombol &nbsp;<strong>Simpan Data</strong> &nbsp;untuk menyimpan data upload persetujuan
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="mb-3">
		<label class="form-label">Nama Sekolah</label>
		<input class="form-control" type="text" value="<?php echo $nama; ?>" maxlength="50" autocomplete="off" style="font-size:13px;" disabled />
	</div>

	<div class="mb-3">
		<label class="form-label">NPSN</label>
		<input class="form-control" type="text" value="<?php echo $npsn; ?>" maxlength="50" autocomplete="off" style="font-size:13px;" disabled />
	</div>

	<div class="mb-3">
		<label class="form-label">Upload File Surat</label>
		<input class="form-control form-control-sm" id="btnUploadSuratE" type="file" accept=".pdf" />
	</div>

</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanUploadE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	function gantiFile() {
		$("#btnUploadSuratE").val('');
	}

	$('#btnUploadSuratE').bind('change', function() {
		var extensinya = $('#btnUploadSuratE').val().toLowerCase();
		var regex = new RegExp("(.*?)\.(pdf)$");
		if (!(regex.test(extensinya))) {
			alert("File upload harus file documen pdf");
			$('#btnUploadSuratE').val(null);
		}
	});

	$("#cmdSimpanUploadE").on("click", function() {
		
		var idsekolah = $('#txtidsekolahupload').val();
		var npsn = $('#txtnpsnupload').val();
		var nmfile = $('#btnUploadSuratE').val();
		
		var data = new FormData();
		data.append('upSuratE', $("#btnUploadSuratE")[0].files[0]);
		data.append('idsekolah', idsekolah);
		data.append('npsn', npsn);

		if (idsekolah.length <= 0) {
			alert('Data sekolah tidak terdeteksi')
		} else if (npsn.length <= 0) {
			alert('NPSN tidak terdeteksi')
		} else if (nmfile.length <= 0) {
			alert('File upload surat persetujuan masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/upload-surat/aksi_edit.php',
				data: data,
				dataType: "json",
				processData: false,
				contentType: false,
				beforeSend: function(e) {
					$("#cmdSimpanUploadE").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modEditDataLarge').modal('hide');
						}, 1000);
						isiMasterMedia();
						$("#ToastSukses").toast("show");
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanUploadE").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanUploadE").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanUploadE").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});
</script>