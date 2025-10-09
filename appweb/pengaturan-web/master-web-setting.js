function bersihkan() {
	$("#area-dashboard-kunjungan").fadeOut("slow");
	$("#area-halaman-informasi").fadeOut("slow");
	$("#area-halaman-podcast").fadeOut("slow");

}

$("#lv_sambutan").on("click", function () {
	$.ajax({
		type: "POST",
		url: "aksi/sambutan/edit_sambutan.php",
		data: { },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$("#lv_informasi").on("click", function () {
	bersihkan();
	ambiljumlah()
	isiMasterInformasi();
	$("#area-halaman-informasi").fadeIn();

	$("#lblhalaman").val("informasi");
	$("#loading").fadeOut("slow");
});

$("#lv_podcast").on("click", function () {
	bersihkan();
	ambiljumlah()
	isiMasterPodcast();
	$("#area-halaman-podcast").fadeIn();

	$("#lblhalaman").val("podcast");
	$("#loading").fadeOut("slow");
});

$("#lv_klinik_dapo").on("click", function () {
	$.ajax({
		type: "POST",
		url: "aksi/klinik-dapo/edit_klinik_dapo.php",
		data: { },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$("#lv_inovasi_sekolah").on("click", function () {
	bersihkan();
	var ketsekolah = $(this).data('keterangan');
	$("#txttransketkurikulum").val(ketsekolah);

	isiMasterKebutuhanSD();
	$("#area-halaman-kebutuhan-SD").fadeIn();

	$("#lblhalaman").val("kebutuhan-SD");
	$("#loading").fadeOut("slow");
});

$("#lv_pojok_literasi").on("click", function () {
	bersihkan();
	var ketsekolah = $(this).data('keterangan');
	$("#txttransketkurikulum").val(ketsekolah);

	isiMasterKebutuhanSMP();
	$("#area-halaman-kebutuhan-SMP").fadeIn();

	$("#lblhalaman").val("kebutuhan-SMP");
	$("#loading").fadeOut("slow");
});

function ambiljumlah() {
	$.ajax({
		type: "POST",
		url: "aksi/ambil_jumlah.php",
		dataType: 'json',
		success: function (data) {
			$("#lblnavjmlInformasi").html("0");
			$("#lblnavjmlPodcast").html("0");
			$("#lblnavjmlInovasi").html("0");
			$("#lblnavjmlPesan").html("0");
			var i;
			for (i = 0; i < data.length; i++) {
				$("#lblnavjmlInformasi").html(data[i].jumPengumuman);
				$("#lblnavjmlPodcast").html(data[i].jumPodcast);
				$("#lblnavjmlInovasi").html(data[i].jumInovasi);
				$("#lblnavjmlPesan").html(data[i].jumPesan);
			}
		},
		error: function () {
			console.log('error');
		},
	});
}

/*======================================================*/
/*===================== INFORMASI =====================*/
/*=====================================================*/
function isiMasterInformasi() {
	var filterinfo = $('#cbofilterinformasi').val();
	$.ajax({
		type: "POST",
		url: "aksi/informasi/isi_tabel_informasi.php",
		data: { filterinfo: filterinfo },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelInformasi').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if(data[i].headline == "Y"){
					var wrnhead = "bg-primary";
				} else if(data[i].headline == "N"){
					var wrnhead = "bg-warning";
				}

				html +=
				'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">'+data[i].no+'</td>' +
					'<td class="align-middle" width="16%">'+data[i].hari+'<br/>'+data[i].tanggal+'</td>' +
					'<td class="align-middle" width="25%">' + data[i].judul + '</td>' +
					'<td class="align-middle" width="49%">' + data[i].isipengumuman + '</td>' +
					'<td class="align-middle text-center" width="3%"><span class="badge '+wrnhead+' rounded-pill">'+data[i].headline+'</span></td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditInformasi" data-idpengumuman="'+data[i].idpengumuman+'"><span class="fas fa-edit"></span></button> '+
					'</td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnHapusInformasi" data-idpengumuman="'+data[i].idpengumuman+'" data-judul="'+data[i].judul+'"><span class="fas fa-trash-alt"></span></button> '+
					'</td>' +
					'<td class="align-middle" width="2%">'+
						'<a href="tampilkan-' + data[i].idpengumuman + '.html" target="_blank" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2"><span class="fas fa-file-download"></span></a> '+
					'</td>' +
				'</tr>';
			}
			$('#isitabelInformasi').html(html);
			$("#tabelInformasi").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
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

$("#cmdRefreshInformasi").click(function () {
	isiMasterInformasi();
});

$("#cmdTambahInformasi").click(function () {
	$.ajax({
		type: "POST",
		url: "aksi/informasi/tambah_informasi.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelInformasi').on('click', '.btnEditInformasi', function () {
	var idpengumuman = $(this).data('idpengumuman');
	$.ajax({
		type: "POST",
		url: "aksi/informasi/edit_informasi.php",
		data: { idpengumuman: idpengumuman },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelInformasi').on('click', '.btnHapusInformasi', function () {
	var idpengumuman = $(this).data('idpengumuman'); 
	var judul = $(this).data('judul');
	
	let text = "Yakin Anda menghapus data informasi pendidikan\n" + judul;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/informasi/aksi_hapus.php",
			data: { idpengumuman: idpengumuman },
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterInformasi();
			},
			error: function () { alert('Koneksi bermasalah periksa internet'); },
		});
	}
});

/*======================================================*/
/*===================== PODCAST =====================*/
/*=====================================================*/
function isiMasterPodcast() {
	var filterinfo = $('#cbofilterPodcast').val();
	$.ajax({
		type: "POST",
		url: "aksi/podcast/isi_tabel_podcast.php",
		data: { filterinfo: filterinfo },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelPodcast').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if(data[i].headline == "Y"){
					var wrnhead = "bg-primary";
				} else if(data[i].headline == "N"){
					var wrnhead = "bg-warning";
				}

				html +=
				'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">'+data[i].no+'</td>' +
					'<td class="align-middle" width="16%">'+data[i].hari+'<br/>'+data[i].tanggal+'</td>' +
					'<td class="align-middle" width="25%">' + data[i].judul + '</td>' +
					'<td class="align-middle" width="47%">' + data[i].isipodcast + '</td>' +
					'<td class="align-middle text-center" width="3%"><span class="badge '+wrnhead+' rounded-pill">'+data[i].headline+'</span></td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnViewPodcast" data-idpodcast="'+data[i].idpodcast+'"><span class="fas fa-video"></span></button> '+
					'</td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditPodcast" data-idpodcast="'+data[i].idpodcast+'"><span class="fas fa-edit"></span></button> '+
					'</td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnHapusPodcast" data-idpodcast="'+data[i].idpodcast+'" data-judul="'+data[i].judul+'"><span class="fas fa-trash-alt"></span></button> '+
					'</td>' +
				'</tr>';
			}
			$('#isitabelPodcast').html(html);
			$("#tabelPodcast").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
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

$("#cmdRefreshPodcast").click(function () {
	isiMasterPodcast();
});

$("#cmdTambahPodcast").click(function () {
	$.ajax({
		type: "POST",
		url: "aksi/podcast/tambah_podcast.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelPodcast').on('click', '.btnViewPodcast', function () {
	var idpodcast = $(this).data('idpodcast');
	$.ajax({
		type: "POST",
		url: "aksi/podcast/tampilkan-detail-podcast.php",
		data: { idpodcast: idpodcast },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelPodcast').on('click', '.btnEditPodcast', function () {
	var idpodcast = $(this).data('idpodcast');
	$.ajax({
		type: "POST",
		url: "aksi/podcast/edit_podcast.php",
		data: { idpodcast: idpodcast },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelPodcast').on('click', '.btnHapusPodcast', function () {
	var idpodcast = $(this).data('idpodcast'); 
	var judul = $(this).data('judul');
	
	let text = "Yakin Anda menghapus data podcast\n" + judul;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/podcast/aksi_hapus.php",
			data: { idpodcast: idpodcast },
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterPodcast();
			},
			error: function () { alert('Koneksi bermasalah periksa internet'); },
		});
	}
});

