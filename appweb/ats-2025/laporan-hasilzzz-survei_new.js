function bersihkanLaporan() {
	$("#lbljumlahATS").html("0");
	$("#lbljumlahSurveyor").html("0");
	$("#lblJumlahSurveyorSudah").html("0");
	$("#lblpersenSurveyorSudah").html("0 %");
	$("#lblJumlahSurveyorBelum").html("0");
	$("#lblpersenSurveyorBelum").html("0 %");
	$("#lbljumlahSurvei").html("0");
	$("#lblpersensurvei").html("0 %");};

function isiJumlahMenuSurvei() {
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

$("#cbokecamatanhasilsurvei").on("change", function () {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val()
	var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	$(".lblkoplaporan").text(namakecamatan)
	$(".lblsubkoplaporan").text("Data Survei " + namakecamatan)
	$.ajax({
		type: "POST",
		url: "aksi/laporan-survei/ambil_data_desa.php",
		data: { idkecamatan: idkecamatan },
		dataType: 'json',
		success: function (data) {
			$("#cbodesahasilsurvei").empty()
			$("#cbodesahasilsurvei").append('<option value="all">-</option>')
			var i;
			for (i = 0; i < data.length; i++) {
				$("#cbodesahasilsurvei").append('<option value="' + data[i].iddesa + '">' + data[i].namadesa + '</option>')
			}
			//isiTabelWilayahSurvei();
			GrafikHasilSurvei();
			isiTabelKlasifikasiLainnya();
			isiTabelKategoriSurvei();
		},
		error: function () {
			alert("Koneksi bermasalah periksa internet");
		},
	});
});

$("#cbodesahasilsurvei").on("change", function () {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();

	var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var namadesa = $("#cbodesahasilsurvei :selected").text();
	$(".lblkoplaporan").text(namakecamatan + " - " + namadesa)
	$(".lblsubkoplaporan").text("Data Survei " + namakecamatan + " - " + namadesa)

	if (idkecamatan != "all" && iddesa != "all") {
		GrafikHasilSurvei();
		isiTabelKlasifikasiLainnya();
		isiTabelKategoriSurvei();
	} else {
		$("#loading").fadeOut("slow");
	}
});

$("#cmdExportLapATS").on("click", function() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var iddesa = $("#cbodesahasilsurvei").val();var namadesa = $("#cbodesahasilsurvei :selected").text();
	window.open("aksi/lap-excel/excel-laporan-ats.php?idkecamatan=" + idkecamatan + "&iddesa=" + iddesa + "&namakecamatan=" + namakecamatan + "&namadesa=" + namadesa, "_blank")
});

$("#cmdExportLapSurveyor").on("click", function() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var iddesa = $("#cbodesahasilsurvei").val();var namadesa = $("#cbodesahasilsurvei :selected").text();
	window.open("aksi/lap-excel/excel-laporan-surveyor.php?idkecamatan=" + idkecamatan + "&iddesa=" + iddesa + "&namakecamatan=" + namakecamatan + "&namadesa=" + namadesa, "_blank")
});

$("#cmdExportLapSurveyorSudah").on("click", function() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var iddesa = $("#cbodesahasilsurvei").val();var namadesa = $("#cbodesahasilsurvei :selected").text();
	window.open("aksi/lap-excel/excel-laporan-surveyor-sudah.php?idkecamatan=" + idkecamatan + "&iddesa=" + iddesa + "&namakecamatan=" + namakecamatan + "&namadesa=" + namadesa, "_blank")
});

$("#cmdExportLapSurveyorBelum").on("click", function() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var iddesa = $("#cbodesahasilsurvei").val();var namadesa = $("#cbodesahasilsurvei :selected").text();
	window.open("aksi/lap-excel/excel-laporan-surveyor-belum.php?idkecamatan=" + idkecamatan + "&iddesa=" + iddesa + "&namakecamatan=" + namakecamatan + "&namadesa=" + namadesa, "_blank")
});

$("#cmdExportLapTarget").on("click", function() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var iddesa = $("#cbodesahasilsurvei").val();var namadesa = $("#cbodesahasilsurvei :selected").text();
	window.open("aksi/lap-excel/excel-laporan-pencapaian-survei.php?idkecamatan=" + idkecamatan + "&iddesa=" + iddesa + "&namakecamatan=" + namakecamatan + "&namadesa=" + namadesa, "_blank")
});

$("#cmdExportLapTargetBelum").on("click", function() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var iddesa = $("#cbodesahasilsurvei").val();var namadesa = $("#cbodesahasilsurvei :selected").text();
	window.open("aksi/lap-excel/excel-laporan-ats-belum-survei.php?idkecamatan=" + idkecamatan + "&iddesa=" + iddesa + "&namakecamatan=" + namakecamatan + "&namadesa=" + namadesa, "_blank")
});

function isiTabelWilayahSurvei() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	$.ajax({
		type: "POST",
		url: "aksi/laporan-survei/ambil_tabel_survei_area.php",
		data: {
			idkecamatan: idkecamatan
		},
		dataType: 'json',
		success: function (data) {
			$('#tableLapArea').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="20%">' + data[i].namawilayah + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].detailSurveyorBelum + '</td>' +
					'<td class="align-middle text-center" width="8%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenDetSurveyorbelum + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].detailSurveyorSudah + '</td>' +
					'<td class="align-middle text-center" width="8%">' +
						'<span class=" badge badge-soft-success fs--2">' + data[i].persenDetSurveyorsudah + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center text-primary" width="8%">' + data[i].totalDetSurveyor + '</td>' +
					
					'<td class="align-middle text-center" width="8%">' + data[i].detailATSBelum + '</td>' +
					'<td class="align-middle text-center" width="8%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenDetATSbelum + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].detailATSsudah + '</td>' +
					'<td class="align-middle text-center" width="8%">' +
						'<span class=" badge badge-soft-success fs--2">' + data[i].persenDetATSsudah + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center text-primary" width="8%">' + data[i].totalDetATS + '</td>' +
					'</tr>';
			}
			$('#isitableLapArea').html(html);
			$("#tableLapArea").dataTable({
				"paging": false, "lengthChange": false, "ordering": true, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": false,
			});
		},
		error: function () {
			$("#loading").fadeOut("slow");
			console.log("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

function GrafikHasilSurvei() {
	bersihkanLaporan();
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	$.ajax({
		type: "POST",
		url: "aksi/laporan-survei/ambil_grafik_hasil_survei.php",
		data: {
			idkecamatan: idkecamatan,
			iddesa: iddesa
		},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			var valDO = [];
			var valLTM = [];
			var valBPB = [];
			var valLainnya = [];
			myArray = data;
			$.each(myArray, function (index, jum) {
				valDO.push(jum.jumDO);
				valLTM.push(jum.jumLTM);
				valBPB.push(jum.jumBPB);
				valLainnya.push(jum.jumLainnya);
				
				$("#lbljumlahSurveyor").html(jum.jumSurveyor);
				$("#lblJumlahSurveyorSudah").html(jum.jumSurveyorSudah);
				$("#lblpersenSurveyorSudah").html(jum.jumSurveyorSudahPersen + " %");
				$("#lblJumlahSurveyorBelum").html(jum.jumSurveyorBelum);
				$("#lblpersenSurveyorBelum").html(jum.jumSurveyorBelumPersen + " %");

				$("#lbljumlahATS").html(jum.jumSiswaATS);
				$("#lbljumlahBelumSurvei").html(jum.jumATSBelum);
				$("#lblpersenbelumsurvei").html(jum.jumATSBelumPersen + " %");

				$("#lbljumlahSurvei").html(jum.jumATSSudah);
				$("#lblpersensurvei").html(jum.jumATSSudahPersen + " %");
			});

			var dom = document.getElementById('chart-container-hasil');
			var myChart = echarts.init(dom, null, {
				renderer: 'canvas',
				useDirtyRect: false
			});
			var app = {};

			var option;

			option = {
				tooltip: {
					trigger: 'item'
				},
				legend: {
					type: 'scroll',
					orient: 'vertical',
					left: 10,
					top: 20,
					bottom: 20,
					textStyle: {
						color: 'white'
					},
				},
				series: [{
					name: 'Jumlah',
					type: 'pie',
					radius: ['40%', '70%'],
					avoidLabelOverlap: false,
					itemStyle: {
						borderRadius: 10,
						borderColor: '#7f9dc0',
						borderWidth: 2
					},

					data: [{
						value: valDO,
						name: 'Drop Out'
					},
					{
						value: valLTM,
						name: 'Lulus Tidak Melanjutkan'
					},
					{
						value: valBPB,
						name: 'Belum Pernah Bersekolah'
					},
					{
						value: valLainnya,
						name: 'Lainnya'
					}
					]
				}]
			};

			if (option && typeof option === 'object') {
				myChart.setOption(option);
			}

			window.addEventListener('resize', myChart.resize);
			// Tidak hide loading di sini, biarkan function terakhir yang hide
		},
		error: function () {
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			console.log("Koneksi bermasalah periksa internet");
		},
	});
};

function isiTabelKategoriSurvei() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	$.ajax({
		type: "POST",
		url: "aksi/laporan-survei/ambil_tabel_hasil_survei.php",
		data: {
			idkecamatan: idkecamatan,
			iddesa: iddesa
		},
		dataType: 'json',
		beforeSend: function (e) {
			// Loading sudah ditampilkan oleh function pemanggil
		},
		success: function (data) {
			$('#tableLapHasilSurvei').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">5</td>' +
					'<td class="align-middle" width="50%">Lulus Tidak Melanjutkan (LTM)</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumLTML + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumLTMP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumLTM + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenLTM + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="LTM" data-namakategori="Lulus Tidak Melanjutkan (LTM)"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">6</td>' +
					'<td class="align-middle" width="50%">Dikeluarkan (Drop Out)</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumDOL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumDOP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumDO + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenDO + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="DO" data-namakategori="Dikeluarkan (Drop Out)"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +
					
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">7</td>' +
					'<td class="align-middle" width="50%">Belum Pernah Bersekolah (BPB)</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumBPBL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumBPBP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumBPB + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenBPB + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="BPB" data-namakategori="Belum Pernah Bersekolah (BPB)"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +
					
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">8</td>' +
					'<td class="align-middle" width="50%">Lainnya</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumLainnyaL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumLainnyaP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumLainnya + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenLainnya + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="LAINNYA" data-namakategori="Lainnya"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitableLapHasilSurvei').html(html);
			$("#tableLapHasilSurvei").dataTable({
				"paging": false, "lengthChange": false, "ordering": true, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": false,
			});
			// Tidak hide loading di sini, biarkan isiTabelKlasifikasiLainnya yang hide (function terakhir)
		},
		error: function () {
			$("#loading").fadeOut("slow");
			console.log("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$('#isitableLapHasilSurvei').on('click', '.btnExportLapExcelKategori', function () {
	var kategori = $(this).data('kategori');
	var namakategori = $(this).data('namakategori');
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	window.open("aksi/lap-excel/excel-laporan-detail-tabel-kategori.php?kategori="+kategori+"&namakategori="+namakategori+"&idkecamatan="+idkecamatan+"&iddesa="+iddesa,"_blank")
});

function isiTabelKlasifikasiLainnya() {
	$("#loading").fadeIn();
	document.body.style.cursor = "wait";
	
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	$.ajax({
		type: "POST",
		url: "aksi/laporan-survei/ambil_tabel_klasifikasi_lainnya.php",
		data: {
			idkecamatan: idkecamatan,
			iddesa: iddesa
		},
		dataType: 'json',
		beforeSend: function (e) {
			// Loading sudah ditampilkan oleh function pemanggil
		},
		success: function (data) {
			if ($.fn.DataTable.isDataTable('#tabelKlasifikasiLainnya')) {
				$('#tabelKlasifikasiLainnya').DataTable().destroy();
			}
			
			var html = '';
			var i;
			
			if (data && data.length > 0) {
				for (i = 0; i < data.length; i++) {
					var no = i + 1;
					
					html +=
						'<tr class="btn-reveal-trigger">' +
						'<td class="align-middle text-center" width="5%">' + no + '</td>' +
						'<td class="align-middle" width="15%">' + data[i].nama_sekolah + '</td>' +
						'<td class="align-middle" width="10%">' + data[i].kecamatan + '</td>' +
						'<td class="align-middle" width="10%">' + data[i].desa + '</td>' +
						'<td class="align-middle" width="20%">' + data[i].nama_siswa + '</td>' +
						'<td class="align-middle" width="15%">' + data[i].jenis_kelamin + '</td>' +
						'<td class="align-middle" width="25%">' + data[i].klasifikasi + '</td>' +
						'</tr>';
				}
			} else {
				html = '<tr><td colspan="7" class="text-center text-muted">' +
					   '<i class="fas fa-info-circle me-2"></i>' +
					   'Semua siswa telah terkategorikan sebagai LTM, DO, atau BPB. Tidak ada klasifikasi lainnya.' +
					   '</td></tr>';
			}
			
			$('#isitableKlasifikasiLainnya').html(html);
			
			if (data && data.length > 0) {
				$("#tabelKlasifikasiLainnya").DataTable({
					"paging": true, 
					"lengthChange": true, 
					"ordering": true, 
					"info": true, 
					"autoWidth": false, 
					"responsive": true, 
					"select": false, 
					"scrollX": true,
					"pageLength": 10,
					"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
					"pagingType": "simple_numbers",
					"dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
						   '<"row"<"col-sm-12"tr>>' +
						   '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
					initComplete: function () { 
						$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); 
					}, 
					"searching": true,
					"language": {
						"search": "Cari:",
						"lengthMenu": "Tampilkan _MENU_ data per halaman",
						"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
						"infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
						"infoFiltered": "(difilter dari _MAX_ total data)",
						"zeroRecords": "Tidak ada data yang sesuai",
						"emptyTable": "Tidak ada data dalam tabel",
						"paginate": {
							"first": "Pertama",
							"last": "Terakhir",
							"next": "Selanjutnya",
							"previous": "Sebelumnya"
						}
					}
				});
			}
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
		},
		error: function () {
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			console.log("Koneksi bermasalah periksa internet");
		},
	});
}

$("#btnExportKlasifikasiLainnya").on("click", function() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var namakecamatan = $("#cbokecamatanhasilsurvei :selected").text();
	var iddesa = $("#cbodesahasilsurvei").val();
	var namadesa = $("#cbodesahasilsurvei :selected").text();
	window.open("aksi/lap-excel/excel-laporan-klasifikasi-lainnya.php?idkecamatan=" + idkecamatan + "&iddesa=" + iddesa + "&namakecamatan=" + namakecamatan + "&namadesa=" + namadesa, "_blank")
});
