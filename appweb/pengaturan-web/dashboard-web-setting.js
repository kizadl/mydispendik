$("#lv_dashboard").on("click", function () {
	bersihkan();
	isiGrafikKunjungan(); isiDashboardKunjungan();
	$("#area-dashboard-kunjungan").fadeIn();

	$("#lblhalaman").val("dashboard");
	$("#loading").fadeOut("slow");
});

Chart.defaults.global.defaultFontColor = "#fff";

var ctx = document.getElementById('ChartGrafik').getContext("2d")
var gradient = ctx.createLinearGradient(0, 0, 0, 200)
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)')
gradient.addColorStop(0, '#b2d1f0')

function isiGrafikKunjungan() {
	var rangetanggal = $("#txttanggaldashboard").val();
	var tglawal = left(rangetanggal, 10);
	var tglakhir = right(rangetanggal, 10);
	$.ajax({
		type: "POST",
		url: "aksi/ambil_grafik_kunjungan.php",
		data: { tglawal: tglawal, tglakhir: tglakhir },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			var labels = ['Beranda', 'Informasi', 'Sarpras', 'SPM', 'Podcast', 'Pengaduan', 'Kegiatan'];
			var valBeranda = [];
			myArray = data;
			$.each(myArray, function (index, jum) {
				valBeranda.push(jum.jumBeranda, jum.jumInformasi, jum.jumSarpras, jum.jumSPM, jum.jumPodcast, jum.jumPengaduan, jum.jumKegiatan);
				$("#lblkopperiode").html("Periode " + jum.tglawalindo + " s/d " + jum.tglakhirindo);
			});

			var hitChartContent = document.getElementById('hitungChartKunjungan');
			hitChartContent.innerHTML = '';
			$('#hitungChartKunjungan').append('<canvas id="ChartKunjungan" height="300px"><canvas>');

			var salesChartCanvas = $('#ChartKunjungan').get(0).getContext('2d')
			var salesChartData = {
				labels: labels,
				datasets: [
					{
						label: 'Jumlah',
						borderColor: 'rgb(255, 255, 255,0.6)',
						backgroundColor: gradient,
						fill: true,
						pointBorderColor: 'rgba(0, 0, 0, 0)',
						pointBackgroundColor: 'rgba(0, 0, 0, 0)',
						pointHoverBackgroundColor: 'rgb(54, 162, 235)',
						pointHoverBorderColor: 'rgb(54, 162, 235)',
						data: valBeranda,

					},
				]
			}

			var salesChartOptions = {
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					display: false,
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
				type: 'line',
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

function isiDashboardKunjungan() {
	var rangetanggal = $("#txttanggaldashboard").val();
	var tglawal = left(rangetanggal, 10);
	var tglakhir = right(rangetanggal, 10);
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_dashboard_kunjungan.php",
		data: { tglawal: tglawal, tglakhir: tglakhir },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabeldashboardkunjungan').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="20%">' + data[i].tanggal + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].beranda + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].informasi + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].sarpras + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].spm + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].podcast + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].pengaduan + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].kegiatan + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].total + '</td>' +
					'</tr>';
			}
			$('#isitabeldashboardkunjungan').html(html);
			$("#tabeldashboardkunjungan").dataTable({
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