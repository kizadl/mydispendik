/*================ HASIL SURVEYOR =================*/
function isiHasilSurvei() {
	var filterdata = $("#txtfilterdata").val();
	var idkecamatan = $("#txtfilteridkecamatan").val();
	var iddesa = $("#txtfilteriddesa").val();
	var iduniversitas = $("#txtfilteriduniversitas").val();
	var idfakultas = $("#txtfilteridfakultas").val();
	var umur = $("#txtfilterumur").val();
	var bentukpendidikan = $("#txtfilterbentukpendidikan").val();
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
	var filterdata = $("#txtfilterdata").val();
	var ketkopexport = $("#txtketfilterexport").val();
	var idkecamatan = $("#txtfilteridkecamatan").val();
	var iddesa = $("#txtfilteriddesa").val();
	var iduniversitas = $("#txtfilteriduniversitas").val();
	var idfakultas = $("#txtfilteridfakultas").val();
	var umur = $("#txtfilterumur").val();
	var bentukpendidikan = $("#txtfilterbentukpendidikan").val();
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
