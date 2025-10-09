function bersihkan() {
	$("#area-master-surveyor").css("display", "none");
}

/*================ SURVEYOR =================*/
function isiMasterSurveyor() {
	var idsurveyor = $("#lbleditor").val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_surveyor.php",
		data: { idsurveyor:idsurveyor},
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
					'<td class="align-middle" width="32%">' + data[i].namasekolah + 
						'<br>' + data[i].statusats + ' Tahun ' + data[i].tahun + ' - ' + data[i].bentukpendidikan + ' - Tingkat ' + data[i].tingkatpendidikan + 
					'</td>' +
					'<td class="align-middle" width="5%">' +
						'<span class="badge ' + warnaaktif + '">' + data[i].statusats + '</span>' +
					'</td>' +
					'<td class="align-middle" width="5%">' +
						'<a href="#" class="badge ' + warnasurvei + ' text-white btnViewTimeline" data-idsiswa="' + data[i].idsiswa + '" data-jumsurvei="' + data[i].jumsurvei + '">' + data[i].jumsurvei + '</a>' +
					'</td>' +
					'<td align="right" class="d-flex" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnViewFoto" data-idsiswa="' + data[i].idsiswa + '" style="'+ hidfoto +'"><span class="fas fa-camera"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditSiswa" data-idsiswa="' + data[i].idsiswa + '"><span class="fas fa-edit"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnSurvei" data-idsiswa="' + data[i].idsiswa + '"><span class="fas fa-sliders-h"></span></button> ' +
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

$("#cmdRefreshSurveyor").on("click",function () {
	isiMasterSurveyor();
});

$('#isitableSurveyor').on('click', '.btnViewFoto', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $("#lbleditor").val();
	$.ajax({
		type: "POST",
		url: "aksi/surveyor/tampilkan-foto.php",
		data: { idsiswa: idsiswa,idsurveyor: idsurveyor },
		success: function (resp) {
			$("#isianModBebasData").html(resp);
			$("#isianModBebasData").fadeIn(1000);
			$("#modBebasData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitableSurveyor').on('click', '.btnEditSiswa', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $("#lbleditor").val();
	$.ajax({
		type: "POST",
		url: "aksi/surveyor/edit_siswa.php",
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

$('#isitableSurveyor').on('click', '.btnSurvei', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $("#lbleditor").val();
	$.ajax({
		type: "POST",
		url: "aksi/surveyor/tambah_data_survei.php",
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

$('#isitableSurveyor').on('click', '.btnViewTimeline', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $("#lbleditor").val();
	$.ajax({
		type: "POST",
		url: "aksi/surveyor/timeline-hasil-survei.php",
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
