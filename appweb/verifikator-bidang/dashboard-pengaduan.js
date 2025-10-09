$("#lv_dashboard").on("click", function () {
	bersihkan();
	ambiljumlah()
	isiGrafikPengaduan();isiDshboardPengaduan();
	$("#area-dashboard-pengaduan").fadeIn();

	$("#lblhalaman").val("dashboard");
	$("#loading").fadeOut("slow");
});

Chart.defaults.global.defaultFontColor = "#fff";

var ctx = document.getElementById('ChartGrafik').getContext("2d")
var gradient = ctx.createLinearGradient(0, 0, 0, 200)
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)')
gradient.addColorStop(0, '#b2d1f0')

function isiGrafikPengaduan() {
	$(".lblcardbelum").html("0");$(".lblpersenbelum").html("0");
	$(".lblcarddistribusi").html("0");$(".lblpersendistribusi").html("0");
	$(".lblcardjawab").html("0");$(".lblpersentindaklanjut").html("0");
	$(".lblcardselesai").html("0");$(".lblpersenselesai").html("0");

	var idbidang = $('#lblidinstansi').val();
	var rangetanggal = $("#txttanggaldashboard").val();
	var tglawal = left(rangetanggal, 10);
	var tglakhir = right(rangetanggal, 10);
	$.ajax({
		type: "POST",
		url: "aksi/ambil_grafik_pengaduan.php",
		data: { tglawal: tglawal, tglakhir: tglakhir,idbidang: idbidang },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			var labels = [];
			var valBelum = []; var valDistribusi = []; var valTindaklanjut = []; var valSelesai = [];
			myArray = data;
			$.each(myArray, function (index, jum) {
				labels.push(jum.nmbidang);
				valBelum.push(jum.jumBlm); valDistribusi.push(jum.jumDistribusi);
				valTindaklanjut.push(jum.jumTindaklanjut); valSelesai.push(jum.jumSelesai);
				
				$(".lblcardbelum").html(jum.totalbelum);$(".lblpersenbelum").html(jum.persenbelum+"%");
				$(".lblcarddistribusi").html(jum.totaldistribusi);$(".lblpersendistribusi").html(jum.persendistribusi+"%");
				$(".lblcardjawab").html(jum.totaltindaklanjut);$(".lblpersentindaklanjut").html(jum.persentindaklanjut+"%");
				$(".lblcardselesai").html(jum.totalselesai);$(".lblpersenselesai").html(jum.persenselesai+"%");

				$("#lblkopperiode").html("Periode " + jum.tglawalindo + " s/d " + jum.tglakhirindo);

			});

			var hitChartContent = document.getElementById('hitungChartPengaduan');
			hitChartContent.innerHTML = '';
			$('#hitungChartPengaduan').append('<canvas id="ChartPengaduan" height="300px"><canvas>');

			var salesChartCanvas = $('#ChartPengaduan').get(0).getContext('2d')
			var salesChartData = {
				labels: labels,
				datasets: [
					{
						label: 'Belum',
						backgroundColor: '#F44336',
						borderColor: '#F44336',
						data: valBelum,
					},
					{
						label: 'Distribusi',
						backgroundColor: '#FFA500',
						borderColor: '#FFA500',
						data: valDistribusi,
					},
					{
						label: 'Tindak Lanjut',
						backgroundColor: '#00FF00',
						borderColor: '#00FF00',
						data: valTindaklanjut,
					},
					{
						label: 'Selesai',
						backgroundColor: '#8484FF',
						borderColor: '#8484FF',
						data: valSelesai,
					},
				]
			}

			var salesChartOptions = {
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					display: true,
					labels: {
						fontColor: 'rgb(255, 255, 255,0.9)'
					}
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
				tooltips: {
					mode: 'index',
					intersect: false,
					enabled: true,
					callbacks: {
						label: function (tooltipItems, data) {
							return data.datasets[tooltipItems.datasetIndex].label + ' : ' + tooltipItems.yLabel.toLocaleString();
						}
					},
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)' },
						gridLines: { display: false, },
						barPercentage: 0.6
					}],
					yAxes: [{
						ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
						gridLines: { display: true, color: "#0d6ecf" }
					}]
				}
			}
			var salesChart = new Chart(salesChartCanvas, {
				type: 'bar',
				data: salesChartData,
				options: salesChartOptions
			}
			)
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
		},
		error: function () {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
		},
	});
}

function isiDshboardPengaduan() {
	var idbidang = $('#lblidinstansi').val();
	var rangetanggal = $("#txttanggaldashboard").val();
	var tglawal = left(rangetanggal, 10);
	var tglakhir = right(rangetanggal, 10);
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_dashboard_pengaduan.php",
		data: { tglawal: tglawal, tglakhir: tglakhir, idbidang: idbidang },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabeldashboardpengaduan').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttspengaduan == "BELUM") {
					var wrnhead = "bg-danger";
					var nmstatus = "BELUM";
				} else if (data[i].sttspengaduan == "DISTRIBUSI") {
					var wrnhead = "bg-warning";
					var nmstatus = "DISTRIBUSI";
				} else if (data[i].sttspengaduan == "JAWABAN") {
					var wrnhead = "bg-success";
					var nmstatus = "TINDAKLANJUT";
				} else if (data[i].sttspengaduan == "SELESAI") {
					var wrnhead = "bg-primary";
					var nmstatus = "SELESAI";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">' + data[i].no + '</td>' +
					'<td class="align-middle" width="16%">' + data[i].tanggal + '</td>' +
					'<td class="align-middle" width="23%">' + data[i].nmpengadu + '</td>' +
					'<td class="align-middle" width="49%">' + data[i].uraianmasalah + '</td>' +
					'<td class="align-middle" width="3%"><span class="badge ' + wrnhead + '">' + nmstatus + '</span></td>' +
					'</tr>';
			}
			$('#isitabeldashboardpengaduan').html(html);
			$("#tabeldashboardpengaduan").dataTable({
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
			console.log("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

function right(str, chr) {
	return str.slice(str.length - chr, str.length);
}

function left(str, chr) {
	return str.slice(0, chr - str.length);
}