<?php
error_reporting(0);

$idpengaduan = trim($_POST['idpengaduan']);
$mdpengaduan = md5($idpengaduan);

$nik = trim($_POST['nik']);
$nmpengadu = trim($_POST['nmpengadu']);
$alamat = trim($_POST['alamat']);
$notelepon = trim($_POST['notelepon']);
$uraianmasalah = trim($_POST['uraianmasalah']);

?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h5 class="mb-0 text-white">Foto Pengaduan</h5>
		<p class="fs--1 mb-0 text-white">Data Foto Pengaduan</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body bg-light py-3 px-4">

	<div class="row mb-3 g-3">
		<div class="col-xxl-12">
			<div class="card bg-primary text-white h-lg-100">
				<div class="card-body d-flex align-items-center">
					<p class="fs--1 mt-0 mb-0">
					<table class="fs--1">
						<tr>
							<td>Identitas Pelapor</td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?php echo $nmpengadu ?></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?php echo $alamat ?></td>
						</tr>
						<tr>
							<td>No. Telepon / WA </td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?php echo $notelepon ?></td>
						</tr>
						<tr>
							<td>Uraian Masalah</td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?php echo $uraianmasalah ?></td>
						</tr>
					</table>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="hoverbox rounded-3 text-center">
		<img class="img-fluid" src="../data-pengaduan/<?php echo $mdpengaduan ?>.png" alt="" />
		<div class="light hoverbox-content bg-dark p-5 flex-center">
			<div>
				<p class="lead text-white"><?php echo $uraianmasalah ?></p>
			</div>
		</div>
	</div>

</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">close</button>
</div>

<script type="text/javascript" charset="utf-8">

</script>