function bersihkan() {
	$("#area-dashboard").css("display", "none");
	$("#area-master-koordinator").css("display", "none");
	$("#area-master-surveyor").css("display", "none");
	$("#area-master-desk").css("display", "none");
	$("#area-master-universitas").css("display", "none");
	$("#area-master-fakultas").css("display", "none");
	$("#area-koordinator-surveyor").css("display", "none");
	$("#area-surveyor-ats").css("display", "none");
	$("#area-survei-ats").css("display", "none");
}

function bersihkanFilter() {
	$("#txtketfilterdata").val("Semua Data Surveyor");
	$("#txtketfilter").val("all");
	$("#txtfilteriduniversitas").val("");
	$("#txtfilteridfakultas").val("");
	$("#txtfilteridkecamatan").val("");
	$("#txtfilteriddesa").val("");

	$("#txtfilterdataSurvei").val("");
	$("#txtfilteridkecamatanSurvei").val("");
	$("#txtfilteriddesaSurvei").val("");
	$("#txtfilteriduniversitasSurvei").val("");
	$("#txtfilteridfakultasSurvei").val("");
	$("#txtfilterumurSurvei").val("");
	$("#txtfilterbentukpendidikanSurvei").val("");
	$("#txtfilterkategorisurvei").val("");
	$("#txtfilteridcatatansurvei").val("");
}

function right(str, chr) {
	return str.slice(str.length - chr, str.length);
}

function left(str, chr) {
	return str.slice(0, chr - str.length);
}

function tanggalHariIni() {
	var tglserver = $("#lbltglserver").val();
	arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
	arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
		"15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30",
		"31"
	];
	mydate = new Date(tglserver);

	tanggal = mydate.getDate();
	bulan = mydate.getMonth();
	tahun = mydate.getFullYear();

	//$("#txttglterimaL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
}

/*================ JUMLAH LAYANAN =================*/
function isiJumlahLayanan() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_jumlah_layanan.php",
		data: {},
		dataType: 'json',
		success: function (data) {
			$("#lbljumlahsiswasurvei").text("0");
			var i;
			for (i = 0; i < data.length; i++) {
				if (data[i].jumsiswa <= 0) {
					document.getElementById("lbljumlahsiswasurvei").style.visibility = "hidden";
				} else { document.getElementById("lbljumlahsiswasurvei").style.visibility = "visible"; }

				$("#lbljumlahsiswasurvei").text(data[i].jumsiswa);
			}
		},
	});
}

/*================ HASIL SURVEYOR =================*/
function isiHasilSurvei() {
	var filterdata = $("#txtfilterdataSurvei").val();
	var idkecamatan = $("#txtfilteridkecamatanSurvei").val();
	var iddesa = $("#txtfilteriddesaSurvei").val();
	var iduniversitas = $("#txtfilteriduniversitasSurvei").val();
	var idfakultas = $("#txtfilteridfakultasSurvei").val();
	var umur = $("#txtfilterumurSurvei").val();
	var bentukpendidikan = $("#txtfilterbentukpendidikanSurvei").val();
	var kategori = $("#txtfilterkategorisurvei").val();
	var idcatatan = $("#txtfilteridcatatansurvei").val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_hasil_survei.php",
		data: { filterdata:filterdata,idkecamatan:idkecamatan,iddesa:iddesa,iduniversitas:iduniversitas,idfakultas:idfakultas,umur:umur,bentukpendidikan:bentukpendidikan,kategori:kategori,idcatatan:idcatatan},
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

				if (data[i].desk == "N") { 
					var warnasurvei = "bg-danger"; 
				} else { 
					var warnasurvei = "bg-success"; 
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle text-truncate" width="20%" style="max-width:120px">' + data[i].namasiswa + '<br>' + data[i].tmplahir + ', ' + data[i].tgllahir + ' - ' + data[i].umur + ' Tahun</td>' +
					'<td class="align-middle text-truncate" width="27%" style="max-width:200px">'+
						'<span class="me-1">' + data[i].alamat + ', RT ' + data[i].rt + ', RW ' + data[i].rw +
						  '<br>' + data[i].desa +' - '+ data[i].kecamatan +'</span>'+
					'</td>' +
					'<td class="align-middle text-truncate" width="34%" style="max-width:250px">' + data[i].namasekolah + 
						'<br>' + data[i].statusats + ' Tahun ' + data[i].tahun + ' - ' + data[i].bentukpendidikan + ' - Tingkat ' + data[i].tingkatpendidikan + 
					'</td>' +
					'<td class="align-middle" width="4%">' +
						'<span class="badge ' + warnaaktif + '">' + data[i].statusats + '</span>' +
					'</td>' +
					'<td class="align-middle" width="4%">' +
						'<a href="#" class="badge ' + warnasurvei + ' text-white btnViewTimeline" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '" data-jumsurvei="' + data[i].jumsurvei + '">' + data[i].desk + '</a>' +
					'</td>' +
					'<td class="align-middle" width="2%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnViewFoto" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '"><span class="fas fa-camera"></span></button> ' +
					'</td>' +
					'<td class="d-flex align-middle" width="6%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnInputDesk" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '" data-desk="' + data[i].desk + '"><span class="fas fa-user-tie"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditSiswa" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '"><span class="fas fa-edit"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnSurvei" data-idsurveyor="' + data[i].idsurveyor + '" data-idsiswa="' + data[i].idsiswa + '"><span class="fas fa-sliders-h"></span></button> ' +
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

$("#cmdFilterHasil").on("click",function () {
	$.ajax({
		type: "POST",
		url: "aksi/filter/filter-data-survei.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$("#cmdExportHasil").on("click",function () {
	var filterdata = $("#txtfilterdataSurvei").val();
	var ketkopexport = $("#txtketfilterexportSurvei").val();
	var idkecamatan = $("#txtfilteridkecamatanSurvei").val();
	var iddesa = $("#txtfilteriddesaSurvei").val();
	var iduniversitas = $("#txtfilteriduniversitasSurvei").val();
	var idfakultas = $("#txtfilteridfakultasSurvei").val();
	var umur = $("#txtfilterumurSurvei").val();
	var bentukpendidikan = $("#txtfilterbentukpendidikanSurvei").val();
	var kategori = $("#txtfilterkategorisurvei").val();
	var idcatatan = $("#txtfilteridcatatansurvei").val();
	window.open("aksi/lap-excel/excel_data_hasil_survei.php?filterdata="+filterdata+"&ketkopexport="+ketkopexport+"&iduniversitas="+iduniversitas+"&idfakultas="+idfakultas+"&idkecamatan="+idkecamatan+"&iddesa="+iddesa+"&umur="+umur+"&bentukpendidikan="+bentukpendidikan+"&kategori="+kategori+"&idcatatan="+idcatatan,"_blank")
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

$('#isitableHasilSurveyor').on('click', '.btnInputDesk', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	var ketdesk = $(this).data('desk');
	$.ajax({
		type: "POST",
		url: "aksi/hasil-survei/tambah_data_desk.php",
		data: { idsiswa: idsiswa,idsurveyor: idsurveyor,ketdesk: ketdesk },
		success: function (resp) {
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modEditDataLarge").modal('show');
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
