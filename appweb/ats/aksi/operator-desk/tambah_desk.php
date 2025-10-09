<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Tambah Data Operator Desk</h5>
		<p class="fs--1 mb-0 text-white">Silahkan menambahkan data operator desk</p>
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

	<div class="form-floating mb-0">
		<input type="text" class="form-control form-control-sm" id="txtnmoperatordesk" value="" placeholder="Nama operator" maxlength="50" autocomplete="off">
		<label for="txtnmoperatordesk">Nama Operator</label>
	</div>

</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
	<button class="btn btn-sm btn-falcon-primary" type="button" id="cmdSimpanOperatorDesk">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$("#txtnmoperatordesk").val("");
	});

	$("#cmdSimpanOperatorDesk").click(function() {
		var nmuser = $('#txtnmoperatordesk').val();

		if (nmuser.length <= 0) {
			$('#txtnmoperatordesk').focus();
			alert('Nama operator desk masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/operator-desk/aksi_tambah.php',
				data: {
					nmuser: nmuser,
				},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanOperatorDesk").attr("disabled", "disabled");
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
						$("#cmdSimpanOperatorDesk").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanOperatorDesk").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanOperatorDesk").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});
</script>