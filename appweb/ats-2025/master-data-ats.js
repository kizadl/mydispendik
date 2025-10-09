/*================ KOORDINATOR =================*/
function isiMasterKoordinator() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_koordinator.php",
		data: {},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelKoordinator').dataTable().fnDestroy();
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
					'<td class="align-middle text-truncate" width="20%" style="max-width:100px;">' + data[i].nmkoordinator + '</td>' +
					'<td class="align-middle text-truncate" width="36%" style="max-width:150px;">' + data[i].nmuniversitas + ' - ' + data[i].nmfakultas + '</td>' +
					'<td class="align-middle" width="16%">' + data[i].username + '</td>' +
					'<td class="align-middle text-center" width="12%"><span class="badge ' + warnablokir + '">' + data[i].nmblokir + '</span></td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnBlokirKoordinator" data-idkoordinator="' + data[i].idkoordinator + '" data-nmkoordinator="' + data[i].nmkoordinator + '" data-nmuniversitas="' + data[i].nmuniversitas + '" data-nmfakultas="' + data[i].nmfakultas + '" data-blokir="' + data[i].blokir + '" data-bs-toggle="tooltip" title="Blokir"><span class="fas fa-ban"></span></button>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnEditKoordinator" data-idkoordinator="' + data[i].idkoordinator + '" data-nmkoordinator="' + data[i].nmkoordinator + '" data-bs-toggle="tooltip" title="Edit"><span class="fas fa-edit"></span></button>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnHapusKoordinator" data-idkoordinator="' + data[i].idkoordinator + '" data-nmkoordinator="' + data[i].nmkoordinator + '" data-nmuniversitas="' + data[i].nmuniversitas + '" data-nmfakultas="' + data[i].nmfakultas + '" data-bs-toggle="tooltip" title="Hapus"><span class="fas fa-trash-alt"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelKoordinator').html(html);
			$("#tabelKoordinator").dataTable({
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

$("#cmdExportKoordinator").on("click",function () {
	window.open("aksi/lap-excel/excel_data_koordinator.php")
});

$("#cmdRefreshKoordinator").click(function () {
	isiMasterKoordinator();
});

$("#cmdTambahKoordinator").click(function () {
	$.ajax({
		type: "POST",
		url: "aksi/koordinator/tambah_koordinator.php",
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

$('#isitabelKoordinator').on('click', '.btnEditKoordinator', function () {
	var idkoordinator = $(this).data('idkoordinator');
	$.ajax({
		type: "POST",
		url: "aksi/koordinator/edit_koordinator.php",
		data: {
			idkoordinator: idkoordinator
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

$('#isitabelKoordinator').on('click', '.btnHapusKoordinator', function () {
	var idkoordinator = $(this).data('idkoordinator');
	var nmkoordinator = $(this).data('nmkoordinator');
	var nmuniversitas = $(this).data('nmuniversitas');
	var nmfakultas = $(this).data('nmfakultas');
	let text = "Yakin Anda menghapus data koordinator\n" + nmkoordinator + "\n" + nmuniversitas+ "\n" + nmfakultas;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/koordinator/aksi_hapus.php",
			data: {
				idkoordinator: idkoordinator
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterKoordinator();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

$('#isitabelKoordinator').on('click', '.btnBlokirKoordinator', function () {
	var idkoordinator = $(this).data('idkoordinator');
	var nmkoordinator = $(this).data('nmkoordinator');
	var nmuniversitas = $(this).data('nmuniversitas');
	var nmfakultas = $(this).data('nmfakultas');
	var blokir = $(this).data('blokir');
	if (blokir == "Y") {
		var ubahstatus = "Membuka Blokir";
		var status = "N";
	} else {
		var ubahstatus = "Memblokir";
		var status = "Y";
	}
	let text = "Yakin Anda " + ubahstatus + " data koordinator\n" + nmkoordinator + "\n" + nmuniversitas + "\n" + nmfakultas;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/koordinator/aksi_blokir.php",
			data: {
				idkoordinator: idkoordinator,
				status: status
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterKoordinator();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

/*================ SURVEYOR =================*/
function isiMasterSurveyor() {
	var ketfilter = $("#txtketfilter").val();
	var iduniversitas = $("#txtfilteriduniversitas").val();
	var idfakultas = $("#txtfilteridfakultas").val();
	var idkecamatan = $("#txtfilteridkecamatan").val();
	var iddesa = $("#txtfilteriddesa").val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_surveyor.php",
		data: {ketfilter:ketfilter,iduniversitas:iduniversitas,idfakultas:idfakultas,idkecamatan:idkecamatan,iddesa:iddesa },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#tableSurveyor').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				if (data[i].statushp == "TIDAK AKTIF") { 
					var warnaaktif = "bg-danger"; var fasfaicon = ""; var hidaktivasi = "hidden";
				} else if (data[i].statushp == "AKTIF") { 
					var warnaaktif = "bg-primary"; var fasfaicon = "fas fa-ban"; var hidaktivasi = "";
				} else if (data[i].statushp == "MENUNGGU AKTIVASI") { 
					var warnaaktif = "bg-warning"; var fasfaicon = "fas fa-check"; var hidaktivasi = "";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle text-truncate" width="20%" style="max-width:120px">' + data[i].nmsurveyor + '<br>' + data[i].nmkecamatan + '</td>' +
					'<td class="align-middle text-truncate" width="38%" style="max-width:200px">'+
						'<span class="me-1">' + data[i].nmuniversitas + ' - ' + data[i].nmfakultas + '</span>'+
					'</td>' +
					'<td class="align-middle" width="14%">' + data[i].telepon + '</td>' +
					'<td class="align-middle" width="13%">' +
						'<span class="badge ' + warnaaktif + '">' + data[i].statushp + '</span>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnAktivasiSurveyor" data-id="' + data[i].idsurveyor + '" data-nmsurveyor="' + data[i].nmsurveyor + '" data-telepon="' + data[i].telepon + '" data-statushp="' + data[i].statushp + '" '+hidaktivasi+'><span class="'+ fasfaicon +'"></span></button> ' +
					'</td>' +
					'<td class="d-flex align-middle" width="12%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditSurveyor" data-id="' + data[i].idsurveyor + '"><span class="fas fa-edit"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusSurveyor" data-id="' + data[i].idsurveyor + '" data-nmsurveyor="' + data[i].nmsurveyor + '" data-telepon="' + data[i].telepon + '"><span class="fas fa-trash"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitableSurveyor').html(html);
			$("#tableSurveyor").dataTable({
				"paging": false, "lengthChange": false, "ordering": true, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdFilterSurveyor").on("click",function () {
	$.ajax({
		type: "POST",
		url: "aksi/filter/filter-surveyor.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$("#cmdExportSurveyor").on("click",function () {
	var ketfilter = $("#txtketfilter").val();
	var ketfilterdata = $("#txtketfilterdata").val();
	var iduniversitas = $("#txtfilteriduniversitas").val();
	var idfakultas = $("#txtfilteridfakultas").val();
	var idkecamatan = $("#txtfilteridkecamatan").val();
	var iddesa = $("#txtfilteriddesa").val();
	window.open("aksi/lap-excel/excel_data_surveyor.php?ketfilter="+ketfilter+"&ketfilterdata="+ketfilterdata+"&iduniversitas="+iduniversitas+"&idfakultas="+idfakultas+"&idkecamatan="+idkecamatan+"&iddesa="+iddesa,"_blank")
});

$("#cmdTambahSurveyor").on("click",function () {
	$.ajax({
		type: "POST",
		url: "aksi/surveyor/tambah_surveyor.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableSurveyor').on('click', '.btnEditSurveyor', function () {
	var idsurveyor = $(this).data('id');
	$.ajax({
		type: "POST",
		url: "aksi/surveyor/edit_surveyor.php",
		data: { idsurveyor: idsurveyor },
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableSurveyor').on('click', '.btnHapusSurveyor', function () {
	var idsurveyor = $(this).data('id'); var nmsurveyor = $(this).data('nmsurveyor');var username = $(this).data('telepon');
	let text = "Yakin menghapus data surveyor\n" + nmsurveyor +"\n" + username;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/surveyor/aksi_hapus.php",
			data: { idsurveyor: idsurveyor },
			success: function (resp) {
				$("#ToastHapus").toast("show");
				isiMasterSurveyor();
			},
			error: function () { alert('Koneksi bermasalah periksa internet'); },
		});
	}
});

$('#isitableSurveyor').on('click', '.btnAktivasiSurveyor', function () {
	var idsurveyor = $(this).data('id'); var nmsurveyor = $(this).data('nmsurveyor');var username = $(this).data('telepon');var statushp = $(this).data('statushp');
	if (statushp == "MENUNGGU AKTIVASI") { var ubahstatus = "Aktifkan Handphone"; var status = "AKTIF"; } 
	else if (statushp == "AKTIF") { var ubahstatus = "Non Aktifkan Handphone"; var status = "TIDAK AKTIF"; }
	let text = "Yakin Anda " + ubahstatus + " data surveyor\n" + nmsurveyor + "\n" + username;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/surveyor/aksi_aktivasi.php",
			data: { idsurveyor: idsurveyor, status: status },
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterSurveyor();
			},
			error: function () { alert('Koneksi bermasalah periksa internet'); },
		});
	}
});

/*================ OPERATOR DESK =================*/
function isiMasterOperatorDesk() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_operator_desk.php",
		data: {},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelOperatorDesk').dataTable().fnDestroy();
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
					'<td class="align-middle text-truncate" width="20%" style="max-width:100px;">' + data[i].nmuser + '</td>' +
					'<td class="align-middle" width="36%">' + data[i].username + '</td>' +
					'<td class="align-middle text-center" width="32%"><span class="badge ' + warnablokir + '">' + data[i].nmblokir + '</span></td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnBlokirDesk" data-iduser="' + data[i].iduser + '" data-nmuser="' + data[i].nmuser + '" data-blokir="' + data[i].blokir + '" data-bs-toggle="tooltip" title="Blokir"><span class="fas fa-ban"></span></button>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnEditDesk" data-iduser="' + data[i].iduser + '" data-nmuser="' + data[i].nmuser + '" data-bs-toggle="tooltip" title="Edit"><span class="fas fa-edit"></span></button>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnHapusDesk" data-iduser="' + data[i].iduser + '" data-nmuser="' + data[i].nmuser + '" data-bs-toggle="tooltip" title="Hapus"><span class="fas fa-trash-alt"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelOperatorDesk').html(html);
			$("#tabelOperatorDesk").dataTable({
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

$("#cmdExportDesk").on("click",function () {
	window.open("aksi/lap-excel/excel_data_desk.php")
});

$("#cmdRefreshDesk").click(function () {
	isiMasterOperatorDesk();
});

$("#cmdTambahDesk").click(function () {
	$.ajax({
		type: "POST",
		url: "aksi/operator-desk/tambah_desk.php",
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

$('#isitabelOperatorDesk').on('click', '.btnEditDesk', function () {
	var iduser = $(this).data('iduser');
	$.ajax({
		type: "POST",
		url: "aksi/operator-desk/edit_desk.php",
		data: {
			iduser: iduser
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

$('#isitabelOperatorDesk').on('click', '.btnHapusDesk', function () {
	var iduser = $(this).data('iduser');
	var nmuser = $(this).data('nmuser');
	let text = "Yakin Anda menghapus data operator desk\n" + nmuser ;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/operator-desk/aksi_hapus.php",
			data: {
				iduser: iduser
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterOperatorDesk();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

$('#isitabelOperatorDesk').on('click', '.btnBlokirDesk', function () {
	var iduser = $(this).data('iduser');
	var nmuser = $(this).data('nmuser');
	var blokir = $(this).data('blokir');
	if (blokir == "Y") {
		var ubahstatus = "Membuka Blokir";
		var status = "N";
	} else {
		var ubahstatus = "Memblokir";
		var status = "Y";
	}
	let text = "Yakin Anda " + ubahstatus + " data operator desk\n" + nmuser;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/operator-desk/aksi_blokir.php",
			data: {
				iduser: iduser,
				status: status
			},
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiMasterOperatorDesk();
			},
			error: function () {
				alert('Koneksi bermasalah periksa internet');
			},
		});
	}
});

/*================ UNIVERSITAS =================*/
function isiMasterUniversitas() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_universitas.php",
		data: { },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#tableUniversitas').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle text-truncate" width="86%" style="max-width:250px">'+
						'<span class="me-1">' + data[i].nmuniversitas + '</span>'+
					'</td>' +
					'<td class="d-flex align-middle" width="10%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditUniversitas" data-id="' + data[i].iduniversitas + '"><span class="fas fa-edit"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusUniversitas" data-id="' + data[i].iduniversitas + '" data-nmuniversitas="' + data[i].nmuniversitas + '"><span class="fas fa-trash"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitableUniversitas').html(html);
			$("#tableUniversitas").dataTable({
				"paging": false, "lengthChange": false, "ordering": true, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshUniversitas").on("click",function () {
	isiMasterUniversitas();
});

$("#cmdTambahUniversitas").on("click",function () {
	$.ajax({
		type: "POST",
		url: "aksi/universitas/tambah_universitas.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableUniversitas').on('click', '.btnEditUniversitas', function () {
	var iduniversitas = $(this).data('id');
	$.ajax({
		type: "POST",
		url: "aksi/universitas/edit_universitas.php",
		data: { iduniversitas: iduniversitas },
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableUniversitas').on('click', '.btnHapusUniversitas', function () {
	var iduniversitas = $(this).data('id'); var nmuniversitas = $(this).data('nmuniversitas');
	let text = "Yakin menghapus data universitas\n" + nmuniversitas;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/universitas/aksi_hapus.php",
			data: { iduniversitas: iduniversitas },
			success: function (resp) {
				$("#ToastHapus").toast("show");
				isiMasterUniversitas();
			},
			error: function () { alert('Koneksi bermasalah periksa internet'); },
		});
	}
});

/*================ FAKULTAS =================*/
function isiMasterFakultas() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_fakultas.php",
		data: { },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#tableFakultas').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
			
				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle text-truncate" width="50%" style="max-width:250px">'+
						'<span class="me-1">' + data[i].nmfakultas + '</span>'+
					'</td>' +
					'<td class="align-middle text-truncate" width="36%" style="max-width:250px">'+
						'<span class="me-1">' + data[i].nmuniversitas + '</span>'+
					'</td>' +
					'<td class="d-flex align-middle" width="10%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditFakultas" data-id="' + data[i].idfakultas + '"><span class="fas fa-edit"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusFakultas" data-id="' + data[i].idfakultas + '" data-nmfakultas="' + data[i].nmfakultas + '"  data-nmuniversitas="' + data[i].nmuniversitas + '"><span class="fas fa-trash"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitableFakultas').html(html);
			$("#tableFakultas").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshFakultas").on("click",function () {
	isiMasterFakultas();
});

$("#cmdTambahFakultas").on("click",function () {
	$.ajax({
		type: "POST",
		url: "aksi/fakultas/tambah_fakultas.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableFakultas').on('click', '.btnEditFakultas', function () {
	var idfakultas = $(this).data('id');
	$.ajax({
		type: "POST",
		url: "aksi/fakultas/edit_fakultas.php",
		data: { idfakultas: idfakultas },
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableFakultas').on('click', '.btnHapusFakultas', function () {
	var idfakultas = $(this).data('id'); var nmfakultas = $(this).data('nmfakultas');var nmuniversitas = $(this).data('nmuniversitas');
	let text = "Yakin menghapus data fakultas\n" + nmfakultas +"\n" + nmuniversitas;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/fakultas/aksi_hapus.php",
			data: { idfakultas: idfakultas },
			success: function (resp) {
				$("#ToastHapus").toast("show");
				isiMasterFakultas();
			},
			error: function () { alert('Koneksi bermasalah periksa internet'); },
		});
	}
});

/*================ KOORDINATOR - SURVEYOR =================*/
function isiKoordinatorSurveyor() {
	var iduniversitas = $('#cbouniversitasAturKoordinator').val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_pengaturan_koordinator.php",
		data: { iduniversitas: iduniversitas },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelPengaturanKoordinator').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td align="center" class="align-top" width="4%">' + data[i].no + '</td>' +
					'<td class="align-top text-truncate" width="32%" style="max-width:140px;">' + data[i].nmkoordinator +'<br>' + data[i].nmuniversitas +'</td>' +
					'<td class="align-top" width="60%">' + data[i].listsurveyor + '</td>' +
					'<td align="center" class="align-middle" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnAturSurveyor" data-bs-toggle="tooltip" title="Data Surveyor" data-id="' + data[i].idkoordinator + '" data-iduniversitas="' + data[i].iduniversitas + '" data-idfakultas="' + data[i].idfakultas + '" data-nmkoordinator="' + data[i].nmkoordinator + '" data-nmuniversitas="' + data[i].nmuniversitas + '" data-nmfakultas="' + data[i].nmfakultas + '"><span class="fas fa-chalkboard-teacher"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelPengaturanKoordinator').html(html);
			$("#tabelPengaturanKoordinator").dataTable({
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

$("#cmdExportAturKoordinator").on("click",function () {
	var iduniversitas = $('#cbouniversitasAturKoordinator').val();
	var namauniversitas = $('#cbouniversitasAturKoordinator :selected').text();
	window.open("aksi/lap-excel/excel_data_koordinator_surveyor.php?iduniversitas="+iduniversitas+"&nmuniversitas="+namauniversitas,"_blank")
	isiKoordinatorSurveyor();
});

$("#cmdRefreshAturKoordinator").click(function () {
	isiKoordinatorSurveyor();
});

$('#isitabelPengaturanKoordinator').on('click', '.btnAturSurveyor', function () {
	var idkoordinator = $(this).data('id');
	var iduniversitas = $(this).data('iduniversitas');
	var idfakultas = $(this).data('idfakultas');
	var nmkoordinator = $(this).data('nmkoordinator');
	var nmuniversitas = $(this).data('nmuniversitas');
	var nmfakultas = $(this).data('nmfakultas');
	$.ajax({
		type: "POST",
		url: "aksi/koordinator-surveyor/tampilkan_surveyor.php",
		data: { idkoordinator: idkoordinator,iduniversitas: iduniversitas,idfakultas: idfakultas,nmkoordinator: nmkoordinator,nmuniversitas: nmuniversitas,nmfakultas: nmfakultas },
		success: function (resp) {
			$("#isianmodDistKoorToSurveyor").html(resp);
			$("#isianmodDistKoorToSurveyor").fadeIn(1000);
			$("#modDistKoorToSurveyor").modal({ backdrop: 'static', keyboard: false })
			$("#modDistKoorToSurveyor").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});


/*================ SURVEYOR - ATS =================*/
function isiSurveyorATS() {
	var ketfilter = $("#txtketfilter").val();
	var iduniversitas = $("#txtfilteriduniversitas").val();
	var idfakultas = $("#txtfilteridfakultas").val();
	var idkecamatan = $("#txtfilteridkecamatan").val();
	var iddesa = $("#txtfilteriddesa").val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_pengaturan_surveyor.php",
		data: {ketfilter:ketfilter,iduniversitas:iduniversitas,idfakultas:idfakultas,idkecamatan:idkecamatan,iddesa:iddesa },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelPengaturanATS').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td align="center" class="align-top" width="4%">' + data[i].no + '</td>' +
					'<td class="align-top text-truncate" width="42%" style="max-width:140px;">' + data[i].nmsurveyor +'<br>' + data[i].nmuniversitas +'<br>' + data[i].nmfakultas +'<br>' + data[i].namakecamatan +' - ' + data[i].namadesa +'</td>' +
					'<td class="align-top" width="50%">' + data[i].listsurveyor + '</td>' +
					'<td align="center" class="align-middle" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnAturATS" data-bs-toggle="tooltip" title="Data Surveyor" data-id="' + data[i].idsurveyor + '" data-iduniversitas="' + data[i].iduniversitas + '" data-idfakultas="' + data[i].idfakultas + '" data-idkecamatan="' + data[i].idkecamatan + '" data-namakecamatan="' + data[i].namakecamatan + '" data-nmsurveyor="' + data[i].nmsurveyor + '" data-nmuniversitas="' + data[i].nmuniversitas + '" data-nmfakultas="' + data[i].nmfakultas + '"><span class="fas fa-map-signs"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelPengaturanATS').html(html);
			$("#tabelPengaturanATS").dataTable({
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

$("#cmdFilterAturAts").on("click",function () {
	$.ajax({
		type: "POST",
		url: "aksi/filter/filter-surveyor-ats.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$("#cmdExportAturAts").on("click",function () {
	var ketfilter = $("#txtketfilter").val();
	var ketfilterdata = $("#txtketfilterdata").val();
	var iduniversitas = $("#txtfilteriduniversitas").val();
	var idfakultas = $("#txtfilteridfakultas").val();
	var idkecamatan = $("#txtfilteridkecamatan").val();
	var iddesa = $("#txtfilteriddesa").val();
	window.open("aksi/lap-excel/excel_data_surveyor_ats.php?ketfilter="+ketfilter+"&ketfilterdata="+ketfilterdata+"&iduniversitas="+iduniversitas+"&idfakultas="+idfakultas+"&idkecamatan="+idkecamatan+"&iddesa="+iddesa,"_blank")
});

$('#isitabelPengaturanATS').on('click', '.btnAturATS', function () {
	var idsurveyor = $(this).data('id');
	var iduniversitas = $(this).data('iduniversitas');
	var idfakultas = $(this).data('idfakultas');
	var idkecamatan = $(this).data('idkecamatan');
	var nmsurveyor = $(this).data('nmsurveyor');
	var nmuniversitas = $(this).data('nmuniversitas');
	var nmfakultas = $(this).data('nmfakultas');
	var namakecamatan = $(this).data('namakecamatan');
	$.ajax({
		type: "POST",
		url: "aksi/surveyor-ats/tampilkan_ats.php",
		data: { idsurveyor: idsurveyor,iduniversitas: iduniversitas,idfakultas: idfakultas,idkecamatan: idkecamatan,nmsurveyor: nmsurveyor,nmuniversitas: nmuniversitas,nmfakultas: nmfakultas,namakecamatan: namakecamatan },
		success: function (resp) {
			$("#isianmodTambahDataXtraLarge").html(resp);
			$("#isianmodTambahDataXtraLarge").fadeIn(1000);
			$("#modTambahDataXtraLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataXtraLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$("#cbowilayahATS").on("change", function() {
	var idkecamatan = $("#cbowilayahATS").val()
	$.ajax({
		type: "POST",
		url: "aksi/surveyor-ats/ambil_data_desa.php",
		data: {
			idkecamatan: idkecamatan
		},
		dataType: 'json',
		beforeSend: function(e) {
			document.body.style.cursor = "wait";
		},
		success: function(data) {
			document.body.style.cursor = "default";

			$("#cbowilayahdesaATS").empty()
			$("#cbowilayahdesaATS").append('<option value="">Pilih desa</option>')
			var i;
			for (i = 0; i < data.length; i++) {
				$("#cbowilayahdesaATS").append('<option value="' + data[i].iddesa + '">' + data[i].nmdesa + '</option>')
			}
		},
		error: function() {
			console.log("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
});