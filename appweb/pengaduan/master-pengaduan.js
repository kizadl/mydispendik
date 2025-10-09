function bersihkan() {
	$("#area-dashboard-pengaduan").fadeOut();
	$("#area-halaman-pengaduan").fadeOut();
	$("#area-halaman-faq").fadeOut();
	$("#area-halaman-operator").fadeOut();
}

$("#lv_dashboard").on("click", function () {
	bersihkan();
	ambiljumlah()
	isiGrafikPengaduan();isiDshboardPengaduan();
	$("#area-dashboard-pengaduan").fadeIn();

	$("#lblhalaman").val("dashboard");
	$("#loading").fadeOut("slow");
});

$("#lv_pengaduan").on("click", function () {
	bersihkan();
	ambiljumlah()
	isiMasterPengaduan();
	$("#area-halaman-pengaduan").fadeIn();

	$("#lblhalaman").val("pengaduan");
	$("#loading").fadeOut("slow");
});

$("#lv_faq").on("click", function () {
	bersihkan();
	isiMasterFaq();
	$("#area-halaman-faq").fadeIn();

	$("#lblhalaman").val("faq");
	$("#loading").fadeOut("slow");
});

$("#lv_operator_bidang").on("click", function () {
	bersihkan();
	isiMasterOperator();
	$("#area-halaman-operator").fadeIn();

	$("#lblhalaman").val("operator");
	$("#loading").fadeOut("slow");
});

function ambiljumlah() {
	$.ajax({
		type: "POST",
		url: "aksi/ambil_jumlah.php",
		dataType: 'json',
		success: function (data) {
			$("#lblnavjmlPengaduan").html("0");
			var i;
			for (i = 0; i < data.length; i++) {
				$("#lblnavjmlPengaduan").html(data[i].jumPengaduan);
			}
		},
		error: function () {
			console.log('error');
		},
	});
}

/*======================================================*/
/*===================== PENGADUAN =====================*/
/*=====================================================*/
function isiMasterPengaduan() {
	var filterinfo = $('#cbofilterpengaduan').val();
	$.ajax({
		type: "POST",
		url: "aksi/pengaduan/isi_tabel_pengaduan.php",
		data: {
			filterinfo: filterinfo
		},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelpengaduan').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttspengaduan == "BELUM") {
					var wrnhead = "bg-danger";
					var nmstatus = "BELUM";
					var hiddenhapus = "";
					var hiddenselesai = "display:none";
				} else if (data[i].sttspengaduan == "DISTRIBUSI") {
					var wrnhead = "bg-warning";
					var nmstatus = "DISTRIBUSI";
					var hiddenhapus = "display:none";
					var hiddenselesai = "display:none";
				} else if (data[i].sttspengaduan == "JAWABAN") {
					var wrnhead = "bg-success";
					var nmstatus = "TINDAKLANJUT";
					var hiddenhapus = "display:none";
					var hiddenselesai = "";
				} else if (data[i].sttspengaduan == "SELESAI") {
					var wrnhead = "bg-primary";
					var nmstatus = "SELESAI";
					var hiddenhapus = "display:none";
					var hiddenselesai = "display:none";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">' + data[i].no + '</td>' +
					'<td class="align-middle" width="16%">' + data[i].tanggal + '</td>' +
					'<td class="align-middle" width="23%">' + data[i].nmpengadu + '</td>' +
					'<td class="align-middle" width="49%">' + data[i].uraianmasalah + '</td>' +
					'<td class="align-middle" width="3%"><span class="badge ' + wrnhead + '">' + nmstatus + '</span></td>' +
					'<td class="align-middle" width="2%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnFotoPengaduan" data-idpengaduan="' + data[i].idpengaduan + '" data-nik="' + data[i].nik + '" data-nmpengadu="' + data[i].nmpengadu + '" data-alamat="' + data[i].alamat + '" data-notelepon="' + data[i].notelepon + '" data-uraianmasalah="' + data[i].uraianmasalah + '"><span class="fas fa-camera"></span></button> ' +
					'</td>' +
					'<td class="align-middle" width="2%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnTeruskanPengaduan" data-idpengaduan="' + data[i].idpengaduan + '"><span class="fas fa-project-diagram"></span></button> ' +
					'</td>' +
					'<td class="align-middle" width="2%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnHapusPengaduan" data-idpengaduan="' + data[i].idpengaduan + '" data-nmpengadu="' + data[i].nmpengadu + '" data-uraianmasalah="' + data[i].uraianmasalah + '" style="' + hiddenhapus + '"><span class="fas fa-trash-alt"></span></button> ' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnSelesaiPengaduan" data-idpengaduan="' + data[i].idpengaduan + '" data-nmpengadu="' + data[i].nmpengadu + '" data-uraianmasalah="' + data[i].uraianmasalah + '" style="' + hiddenselesai + '"><span class="fas fa-trash-alt"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelpengaduan').html(html);
			$("#tabelpengaduan").dataTable({
				"paging": true,
				"lengthChange": false,
				"ordering": true,
				"info": false,
				"autoWidth": true,
				"responsive": true,
				"select": false,
				"scrollX": false,
				initComplete: function () {
					$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
				},
				"searching": true,
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

$("#cmdRefreshPengaduan").click(function () {
	isiMasterPengaduan();
});

$('#isitabelpengaduan').on('click', '.btnFotoPengaduan', function () {
	var idpengaduan = $(this).data('idpengaduan');
	var nik = $(this).data('nik');
	var nmpengadu = $(this).data('nmpengadu');
	var alamat = $(this).data('alamat');
	var notelepon = $(this).data('notelepon');
	var uraianmasalah = $(this).data('uraianmasalah');
	$.ajax({
		type: "POST",
		url: "aksi/pengaduan/tampilkan-foto.php",
		data: {
			idpengaduan: idpengaduan,
			nik: nik,
			nmpengadu: nmpengadu,
			alamat: alamat,
			notelepon: notelepon,
			uraianmasalah: uraianmasalah
		},
		success: function (resp) {
			$("#isianmodFotoXLarge").html(resp);
			$("#isianmodFotoXLarge").fadeIn(1000);
			$("#modFotoXLarge").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modFotoXLarge").modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitabelpengaduan').on('click', '.btnTeruskanPengaduan', function () {
	var idpengaduan = $(this).data('idpengaduan');
	$.ajax({
		type: "POST",
		url: "aksi/pengaduan/pencarian-pengaduan.php",
		data: {
			idpengaduan: idpengaduan
		},
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modTambahDataLarge").modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitabelpengaduan').on('click', '.btnSelesaiPengaduan', function () {
	var idpengaduan = $(this).data('idpengaduan');
	var nmpengadu = $(this).data('nmpengadu');
	var uraianmasalah = $(this).data('uraianmasalah');

	let text = "Yakin Anda merubah status pengaduan Selesai\n" + nmpengadu + "\n" + uraianmasalah;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/pengaduan/aksi_selesai_pengaduan.php",
			data: {
				idpengaduan: idpengaduan
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterPengaduan();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

$('#isitabelpengaduan').on('click', '.btnHapusPengaduan', function () {
	var idpengaduan = $(this).data('idpengaduan');
	var nmpengadu = $(this).data('nmpengadu');
	var uraianmasalah = $(this).data('uraianmasalah');

	let text = "Yakin Anda menghapus data pengaduan\n" + nmpengadu + "\n" + uraianmasalah;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/pengaduan/aksi_hapus_pengaduan.php",
			data: {
				idpengaduan: idpengaduan
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterPengaduan();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

/*======================================================*/
/*=====================    FAQ    =====================*/
/*=====================================================*/
function isiMasterFaq() {
	$.ajax({
		type: "POST",
		url: "aksi/faq/isi_tabel_faq.php",
		data: {},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelFAQ').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">' + data[i].no + '</td>' +
					'<td class="align-middle" width="34%">' + data[i].judulfaq + '</td>' +
					'<td class="align-middle" width="57%">' + data[i].uraianfaq + '</td>' +
					'<td class="align-middle" width="3%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditFAQ" data-idfaq="' + data[i].idfaq + '"><span class="fas fa-edit"></span></button> ' +
					'</td>' +
					'<td class="align-middle" width="3%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnHapusFAQ" data-idfaq="' + data[i].idfaq + '" data-judul="' + data[i].judulfaq + '"><span class="fas fa-trash-alt"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelFAQ').html(html);
			$("#tabelFAQ").dataTable({
				"paging": true,
				"lengthChange": false,
				"ordering": true,
				"info": false,
				"autoWidth": true,
				"responsive": true,
				"select": false,
				"scrollX": false,
				initComplete: function () {
					$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
				},
				"searching": true,
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

$("#cmdRefreshFaq").click(function () {
	isiMasterFaq();
});

$("#cmdTambahFaq").click(function () {
	$.ajax({
		type: "POST",
		url: "aksi/faq/tambah_faq.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modTambahDataLarge").modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitabelFAQ').on('click', '.btnEditFAQ', function () {
	var idfaq = $(this).data('idfaq');
	$.ajax({
		type: "POST",
		url: "aksi/faq/edit_faq.php",
		data: {
			idfaq: idfaq
		},
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modTambahDataLarge").modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitabelFAQ').on('click', '.btnHapusFAQ', function () {
	var idfaq = $(this).data('idfaq');
	var judul = $(this).data('judul');

	let text = "Yakin Anda menghapus data FAQ\n" + judul;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/faq/aksi_hapus.php",
			data: {
				idfaq: idfaq
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterFaq();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

/*================ OPERATOR =================*/
function isiMasterOperator() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_operator.php",
		data: {},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelOperatorAdm').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				var warna = "bg-info";

				if (data[i].blokir == "Y") {
					var warnablokir = "bg-warning";
				} else if (data[i].blokir == "N") {
					var warnablokir = "bg-primary";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle" width="20%">' + data[i].username + '</td>' +
					'<td class="align-middle text-truncate" width="52%" style="max-width:150px;">' + data[i].nminstansi + '</td>' +
					'<td class="align-middle text-center" width="12%"><span class="badge ' + warnablokir + '">' + data[i].nmblokir + '</span></td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnBlokirOptAdm" data-idoperator="' + data[i].idoperator + '" data-username="' + data[i].username + '" data-nminstansi="' + data[i].nminstansi + '" data-blokir="' + data[i].blokir + '" data-bs-toggle="tooltip" title="Blokir"><span class="fas fa-ban"></span></button>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnEditOptAdm" data-idoperator="' + data[i].idoperator + '" data-username="' + data[i].username + '" data-bs-toggle="modal" data-bs-target="#modEditOperatorAdm" data-bs-toggle="tooltip" title="Edit"><span class="fas fa-edit"></span></button>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnHapusOptAdm" data-idoperator="' + data[i].idoperator + '" data-username="' + data[i].username + '" data-nminstansi="' + data[i].nminstansi + '" data-bs-toggle="tooltip" title="Hapus"><span class="fas fa-trash-alt"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelOperatorAdm').html(html);
			$("#tabelOperatorAdm").dataTable({
				"paging": true,
				"lengthChange": false,
				"ordering": true,
				"info": false,
				"autoWidth": true,
				"responsive": true,
				"select": false,
				"scrollX": false,
				initComplete: function () {
					$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
				},
				"searching": true,
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

$("#cmdRefreshOperator").click(function () {
	isiMasterOperator();
});

$("#cmdTambahOperator").click(function () {
	$.ajax({
		type: "POST",
		url: "aksi/operator/tambah_operator.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambamodTambahDataLargehData").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modTambahDataLarge").modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitabelOperatorAdm').on('click', '.btnEditOptAdm', function () {
	var idoperator = $(this).data('idoperator');
	$.ajax({
		type: "POST",
		url: "aksi/operator/edit_operator.php",
		data: {
			idoperator: idoperator
		},
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modTambahDataLarge").modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitabelOperatorAdm').on('click', '.btnHapusOptAdm', function () {
	var idoperator = $(this).data('idoperator');
	var nmoperator = $(this).data('username');
	var nminstansi = $(this).data('nminstansi');
	let text = "Yakin Anda menghapus data operator\n\n" + nmoperator + "\n" + nminstansi;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/operator/aksi_hapus.php",
			data: {
				idoperator: idoperator
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterOperator();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

$('#isitabelOperatorAdm').on('click', '.btnBlokirOptAdm', function () {
	var idoperator = $(this).data('idoperator');
	var nmoperator = $(this).data('username');
	var blokir = $(this).data('blokir');
	var nminstansi = $(this).data('nminstansi');
	if (blokir == "Y") {
		var ubahstatus = "Membuka Blokir";
		var status = "N";
	} else {
		var ubahstatus = "Memblokir";
		var status = "Y";
	}
	let text = "Yakin Anda " + ubahstatus + " data operator\n\n" + nmoperator + "\n" + nminstansi;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/operator/aksi_blokir.php",
			data: {
				idoperator: idoperator,
				status: status
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterOperator();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});
