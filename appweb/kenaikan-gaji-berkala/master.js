/*================ MASTER LAYANAN =================*/
function isiMasterLayanan() {
	var idinstansi = $('#lblidinstansi').val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_list_layanan.php",
		data: { idinstansi: idinstansi },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelMasterLayanan').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td align="center" class="align-top" width="4%">' + data[i].no + '</td>' +
					'<td class="align-top text-truncate" width="32%" style="max-width:140px;">' + data[i].nmlayanan +
					'</td>' +
					'<td class="align-middle text-truncate" width="60%" style="max-width:250px;">' + data[i].nosurat + '</td>' +
					'<td align="center" class="align-middle" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditLayanan" data-bs-toggle="tooltip" title="Edit layanan" data-id="' + data[i].kdlayanan + '" data-nmlayanan="' + data[i].nmlayanan + '"><span class="fas fa-edit"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelMasterLayanan').html(html);
			$("#tabelMasterLayanan").dataTable({
				"paging": false, "lengthChange": false, "ordering": false, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": false,
			
			});
			$("#loading").fadeOut("slow");
		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshLayanan").click(function () {
	isiMasterLayanan();
});

$('#isitabelMasterLayanan').on('click', '.btnEditLayanan', function () {
	var idlayanan = $(this).data('id');var nmlayanan = $(this).data('nmlayanan');
	$.ajax({
		type: "POST",
		url: "aksi/persyaratan/tampilkan_persyaratan.php",
		data: { idlayanan: idlayanan,nmlayanan: nmlayanan },
		success: function (resp) {
			$("#isianmodTambahDataXtraLarge").html(resp);
			$("#isianmodTambahDataXtraLarge").fadeIn(1000);
			$("#modTambahDataXtraLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataXtraLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

/*================ MASTER PERSYARATAN =================*/
function isiMasterPersyaratan() {
	var idinstansi = $('#lblidinstansi').val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_list_persyaratan.php",
		data: { idinstansi: idinstansi },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelMasterPersyaratan').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td align="center" class="align-top" width="4%">' + data[i].no + '</td>' +
					'<td class="align-top text-truncate" width="32%" style="max-width:140px;">' + data[i].nmlayanan + '</td>' +
					'<td class="align-middle text-truncate" width="60%" style="max-width:250px;">' + data[i].nmpersyaratan + '</td>' +
					'<td align="center" class="align-middle" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnPersyaratan" data-bs-toggle="tooltip" title="Persyaratan" data-id="' + data[i].kdlayanan + '" data-nmlayanan="' + data[i].nmlayanan + '"><span class="fas fa-tasks"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelMasterPersyaratan').html(html);
			$("#tabelMasterPersyaratan").dataTable({
				"paging": false, "lengthChange": false, "ordering": false, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": false,
			
			});
			$("#loading").fadeOut("slow");
		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshPersyaratan").click(function () {
	isiMasterPersyaratan();
});

$('#isitabelMasterPersyaratan').on('click', '.btnPersyaratan', function () {
	var idlayanan = $(this).data('id');var nmlayanan = $(this).data('nmlayanan');
	$.ajax({
		type: "POST",
		url: "aksi/persyaratan/tampilkan_persyaratan.php",
		data: { idlayanan: idlayanan,nmlayanan: nmlayanan },
		success: function (resp) {
			$("#isianmodTambahDataXtraLarge").html(resp);
			$("#isianmodTambahDataXtraLarge").fadeIn(1000);
			$("#modTambahDataXtraLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataXtraLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelMasterPersyaratan').on('click', '.cmdEditListLayanan', function () {
	var idlayanan = $(this).data('id');
	$.ajax({
		type: "POST",
		url: "aksi/layanan/edit_layanan.php",
		data: { idlayanan: idlayanan},
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	}); 
});