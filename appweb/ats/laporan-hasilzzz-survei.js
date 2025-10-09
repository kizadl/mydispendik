function bersihkanLaporan() {
	$("#lbljumlahATS").html("0");
	$("#lbljumlahSurveyor").html("0");
	$("#lblJumlahSurveyorSudah").html("0");
	$("#lblpersenSurveyorSudah").html("0 %");
	$("#lblJumlahSurveyorBelum").html("0");
	$("#lblpersenSurveyorBelum").html("0 %");
	$("#lbljumlahSurvei").html("0");
	$("#lblpersensurvei").html("0 %");
}

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
			GrafikCatatanSurvei();GrafikHasilSurvei();
			//isiTabelKategoriSurvei();isiTabelCatatanSurvei();
			$("#loading").fadeOut("slow");
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
		GrafikCatatanSurvei();GrafikHasilSurvei();
		//isiTabelKategoriSurvei();isiTabelCatatanSurvei();
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
			var valLM = [];
			var valPS = [];
			var valMLN = [];
			var valPesantren = [];
			var valLTM = [];
			var valDO = [];
			var valUD = [];
			var valPutus = [];
			var valHilang = [];
			var valWafat = [];
			var valAktif = [];
			myArray = data;
			$.each(myArray, function (index, jum) {
				valLM.push(jum.jumLulusMelanjutkan);
				valPS.push(jum.jumPindahSekolah);
				valMLN.push(jum.jumMelanjutkanLN);
				valPesantren.push(jum.jumPesantren);
				valLTM.push(jum.jumLTM);
				valDO.push(jum.jumDO);
				valUD.push(jum.jumUndurDiri);
				valPutus.push(jum.jumPutus);
				valHilang.push(jum.jumHilang);
				valWafat.push(jum.jumWafat);
				valAktif.push(jum.jumAktif);

				
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
						value: valLM,
						name: 'Lulus Melanjutkan '
					},
					{
						value: valPS,
						name: 'Pindah Sekolah '
					},
					{
						value: valMLN,
						name: 'Melanjutkan LN '
					},
					{
						value: valPesantren,
						name: 'Lanjut Pesantren '
					},
					{
						value: valLTM,
						name: 'LTM '
					},
					{
						value: valDO,
						name: 'Drop Out '
					},
					{
						value: valUD,
						name: 'Mengundurkan Diri '
					},
					{
						value: valPutus,
						name: 'Putus Sekolah '
					},
					{
						value: valHilang,
						name: 'Hilang '
					},
					{
						value: valWafat,
						name: 'Meninggal Dunia '
					},
					{
						value: valAktif,
						name: 'Aktif Kembali '
					},
					]
				}]
			};

			if (option && typeof option === 'object') {
				myChart.setOption(option);
			}

			window.addEventListener('resize', myChart.resize);
		},
		error: function () {
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			console.log("Koneksi bermasalah periksa internet");
		},
	});
};

function GrafikCatatanSurvei() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	$.ajax({
		type: "POST",
		url: "aksi/laporan-survei/ambil_grafik_catatan_survei.php",
		data: {
			idkecamatan: idkecamatan,
			iddesa: iddesa
		},
		dataType: 'json',
		success: function (data) {
			var jumCatatan = [];
			var catatan = [];
			var nilainya = [];
			myArray = data;
			$.each(myArray, function (index, jum) {
				jumCatatan.push(jum.jumCatatan);
				catatan.push(jum.catatan);
				nilainya.push({ value: jum.jumCatatan, name: jum.catatan });
			});

			var dom = document.getElementById('chart-container-catatan');
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
					show:false,
				},
				series: [{
					name: 'Jumlah',
					type: 'pie',
					radius: ['20%', '70%'],
					avoidLabelOverlap: false,
					itemStyle: {
						borderRadius: 10,
						borderColor: '#7f9dc0',
						borderWidth: 2
					},
					data: nilainya,
					roseType: 'area'
				}]
			};

			if (option && typeof option === 'object') {
				myChart.setOption(option);
			}
			window.addEventListener('resize', myChart.resize);
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
		success: function (data) {
			$('#tableLapHasilSurvei').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">1</td>' +
					'<td class="align-middle" width="50%">Lulus Melanjutkan</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumLulusMelanjutkanL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumLulusMelanjutkanP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumLulusMelanjutkan + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenLulusMelanjutkan + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="LM" data-namakategori="Lulus Melanjutkan"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +
					
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">2</td>' +
					'<td class="align-middle" width="50%">Pindah Sekolah</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumPindahSekolahL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumPindahSekolahP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumPindahSekolah + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class="badge badge-soft-danger fs--2">' + data[i].persenPindahSekolah + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="PS" data-namakategori="Pindah Sekolah"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">3</td>' +
					'<td class="align-middle" width="50%">Melanjutkan Ke Luar Negeri</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumMelanjutkanLNL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumMelanjutkanLNP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumMelanjutkanLN + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenMelanjutkanLN + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="MLN" data-namakategori="Melanjutkan Ke Luar Negeri"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">4</td>' +
					'<td class="align-middle" width="50%">Melanjutkan Ke Pesantren</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumPesantrenL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumPesantrenP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumPesantren + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenPesantren + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="MP" data-namakategori="Melanjutkan Ke Pesantren"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

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
					'<td class="align-middle" width="50%">Mengundurkan Diri</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumUndurDiriL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumUndurDiriP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumUndurDiri + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenUndurDiri + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="MD" data-namakategori="Mengundurkan Diri"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">8</td>' +
					'<td class="align-middle" width="50%">Putus Sekolah</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumPutusL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumPutusP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumPutus + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenPutus + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="PTS" data-namakategori="Putus Sekolah"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">9</td>' +
					'<td class="align-middle" width="50%">Hilang</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumHilangL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumHilangP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumHilang + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenHilang + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="HL" data-namakategori="Hilang"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">10</td>' +
					'<td class="align-middle" width="50%">Meninggal Dunia</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumWafatL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumWafatP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumWafat + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenWafat + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="WFT" data-namakategori="Meninggal Dunia"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>' +

					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">11</td>' +
					'<td class="align-middle" width="50%">Aktif Kembali</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumAktifL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumAktifP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumAktif + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persenAktif + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapExcelKategori" data-kategori="AK" data-namakategori="Aktif Kembali"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitableLapHasilSurvei').html(html);
			$("#tableLapHasilSurvei").dataTable({
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

$('#isitableLapHasilSurvei').on('click', '.btnExportLapExcelKategori', function () {
	var kategori = $(this).data('kategori');
	var namakategori = $(this).data('namakategori');
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	window.open("aksi/lap-excel/excel-laporan-detail-tabel-kategori.php?kategori="+kategori+"&namakategori="+namakategori+"&idkecamatan="+idkecamatan+"&iddesa="+iddesa,"_blank")
});

function isiTabelCatatanSurvei() {
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	$.ajax({
		type: "POST",
		url: "aksi/laporan-survei/ambil_tabel_catatan_survei.php",
		data: {
			idkecamatan: idkecamatan,
			iddesa: iddesa
		},
		dataType: 'json',
		success: function (data) {
			$('#tableLapCatatanSurvei').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			$("#loading").fadeOut("slow");
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">' + data[i].no + '</td>' +
					'<td class="align-middle" width="50%">' + data[i].namacatatan + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumCatatanL + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].jumCatatanP + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].jumCatatan + '</td>' +
					'<td class="align-middle text-center" width="18%">' +
						'<span class=" badge badge-soft-danger fs--2">' + data[i].persentaseCatatan + ' %</span>' +
					'</td>' +
					'<td class="align-middle text-center" width="3%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--1 icon-item-sm me-2 btnExportLapCatatanExcel" data-idcatatan="' + data[i].idcatatan + '" data-namacatatan="' + data[i].namacatatan + '"><span class="fas fa-file-excel"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitableLapCatatanSurvei').html(html);
			$("#tableLapCatatanSurvei").dataTable({
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

$('#isitableLapCatatanSurvei').on('click', '.btnExportLapCatatanExcel', function () {
	var idcatatan = $(this).data('idcatatan');
	var namacatatan = $(this).data('namacatatan');
	var idkecamatan = $("#cbokecamatanhasilsurvei").val();
	var iddesa = $("#cbodesahasilsurvei").val();
	window.open("aksi/lap-excel/excel-laporan-detail-tabel-catatan.php?idcatatan="+idcatatan+"&namacatatan="+namacatatan+"&idkecamatan="+idkecamatan+"&iddesa="+iddesa,"_blank")
});
