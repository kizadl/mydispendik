/*================ SURVEYOR =================*/
function isiMasterSurveyor() {
	var iduniversitas = $("#lbliduniversitas").val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_surveyor.php",
		data: { iduniversitas:iduniversitas},
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
					'<td class="align-top" width="4%">' + data[i].no + '</td>' +
					'<td class="align-top text-truncate" width="33%" style="max-width:120px">' + data[i].nmsurveyor + '<br>' + data[i].nmkecamatan + ' - ' + data[i].nmdesa + '</td>' +
					'<td class="align-top text-truncate" width="25%" style="max-width:200px">'+
						'<span class="me-1">' + data[i].nmfakultas + '</span>'+
					'</td>' +
					'<td class="align-top" width="14%">' + data[i].telepon + '</td>' +
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

$("#cmdExportSurveyor").on("click",function () {
	var iduniversitas = $("#lbliduniversitas").val();
	window.open("aksi/lap-excel/excel_data_surveyor.php?iduniversitas="+iduniversitas,"_blank")
});

$("#cmdRefreshSurveyor").on("click",function () {
	isiMasterSurveyor();
});

$("#cmdTambahSurveyor").on("click",function () {
	var iduniversitas = $("#lbliduniversitas").val();
	$.ajax({
		type: "POST",
		url: "aksi/surveyor/tambah_surveyor.php",
		data: { iduniversitas: iduniversitas },
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

/*================ KOORDINATOR - SURVEYOR =================*/
function isiKoordinatorSurveyor() {
	var iduniversitas = $("#lbliduniversitas").val();
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
					'<td class="align-top" width="22%">' + data[i].nmkoordinator +'</td>' +
					'<td class="align-top" width="70%">' + data[i].listsurveyor + '</td>' +
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

$("#cmdRefreshAturKoordinator").click(function () {
	isiKoordinatorSurveyor();
});

$("#cmdExportAturKoordinator").on("click",function () {
	var iduniversitas = $("#lbliduniversitas").val();
	window.open("aksi/lap-excel/excel_data_koordinator_surveyor.php?iduniversitas="+iduniversitas,"_blank")
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
	var iduniversitas = $("#lbliduniversitas").val();
	var idwilayah = $('#cbowilayahATS').val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_pengaturan_surveyor.php",
		data: {iduniversitas: iduniversitas, idwilayah: idwilayah },
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
					'<td class="align-top text-truncate" width="35%" style="max-width:140px;">' + data[i].nmsurveyor +'<br>' + data[i].nmfakultas +'<br>' + data[i].namakecamatan +' - ' + data[i].namadesa +'</td>' +
					'<td class="align-top" width="57%">' + data[i].listsurveyor + '</td>' +
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

$("#cmdExportAturATS").on("click",function () {
	var iduniversitas = $("#lbliduniversitas").val();
	var idkecamatan = $("#cbowilayahATS").val();var namakecamatan = $("#cbowilayahATS :selected").text();
	window.open("aksi/lap-excel/excel_data_surveyor_ats.php?iduniversitas="+iduniversitas+"&idkecamatan="+idkecamatan+"&namakecamatan="+namakecamatan,"_blank")
	isiSurveyorATS();
});

$("#cmdRefreshAturATS").click(function () {
	isiSurveyorATS();
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

/*================ HASIL SURVEYOR =================*/
function isiHasilSurvei() {
	var idkoordinator = $("#lbleditor").val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_hasil_survei.php",
		data: { idkoordinator:idkoordinator},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#tableHasilSurveyor').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				
				if (data[i].statusats == "DO") { 
					var warnaaktif = "bg-danger"; 
				} else if (data[i].statusats == "BPB") { 
					var warnaaktif = "bg-primary"; 
				} else if (data[i].statusats == "LTM") { 
					var warnaaktif = "bg-warning"; 
				}

				if (data[i].jumsurvei == "0") { 
					var warnasurvei = "bg-danger"; var hidfoto = "display:none"; 
				} else { 
					var warnasurvei = "bg-success"; var hidfoto = ""; 
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle text-truncate" width="22%" style="max-width:120px">' + data[i].namasiswa + '<br>' + data[i].tmplahir + ', ' + data[i].tgllahir + ' - ' + data[i].umur + ' Tahun</td>' +
					'<td class="align-middle text-truncate" width="27%" style="max-width:200px">'+
						'<span class="me-1">' + data[i].alamat + ', RT ' + data[i].rt + ', RW ' + data[i].rw +
						  '<br>' + data[i].desa +' - '+ data[i].kecamatan +'</span>'+
					'</td>' +
					'<td class="align-middle text-truncate" width="34%" style="max-width:250px">' + data[i].namasekolah + 
						'<br>' + data[i].statusats + ' Tahun ' + data[i].tahun + ' - ' + data[i].bentukpendidikan + ' - Tingkat ' + data[i].tingkatpendidikan + 
					'</td>' +
					'<td class="align-middle" width="5%">' +
						'<span class="badge ' + warnaaktif + '">' + data[i].statusats + '</span>' +
					'</td>' +
					'<td class="align-middle" width="5%">' +
						'<a href="#" class="badge ' + warnasurvei + ' text-white btnViewTimeline" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '" data-jumsurvei="' + data[i].jumsurvei + '">' + data[i].jumsurvei + '</a>' +
					'</td>' +
					'<td class="d-flex align-middle" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnViewFoto" data-idsiswa="' + data[i].idsiswa + '" style="'+ hidfoto +'"><span class="fas fa-camera"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditSiswa" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '"><span class="fas fa-edit"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnSurvei" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '"><span class="fas fa-sliders-h"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitableHasilSurveyor').html(html);
			$("#tableHasilSurveyor").dataTable({
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

$("#cmdRefreshHasil").on("click",function () {
	isiHasilSurvei();
});

$('#isitableHasilSurveyor').on('click', '.btnViewFoto', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: "POST",
		url: "aksi/hasil-survei/tampilkan-foto.php",
		data: { idsiswa: idsiswa,idsurveyor: idsurveyor },
		success: function (resp) {
			$("#isianModBebasData").html(resp);
			$("#isianModBebasData").fadeIn(1000);
			$("#modBebasData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableHasilSurveyor').on('click', '.btnEditSiswa', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: "POST",
		url: "aksi/hasil-survei/edit_siswa.php",
		data: { idsiswa: idsiswa,idsurveyor: idsurveyor },
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableHasilSurveyor').on('click', '.btnSurvei', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: "POST",
		url: "aksi/hasil-survei/tambah_data_survei.php",
		data: { idsiswa: idsiswa,idsurveyor: idsurveyor },
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableHasilSurveyor').on('click', '.btnViewTimeline', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: "POST",
		url: "aksi/hasil-survei/timeline-hasil-survei.php",
		data: { idsiswa: idsiswa,idsurveyor: idsurveyor },
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});
