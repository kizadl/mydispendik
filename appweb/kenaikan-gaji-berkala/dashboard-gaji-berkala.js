$("#lv_dashboard").on("click", function () {
	bersihkan();
	$("#area-halaman").fadeIn();
	$("#area-dashboard").fadeIn();
	//isiGrafikLayanan();
	$("#lblhalaman").val("dashboard");
});

$("#cmdRefreshDashboard").on("click", function () {
	isiGrafikLayanan();
});

$("#cmdRekapDashboard").on("click", function () {
	var rangetanggal = $("#txttanggaldashboard").val();
	var tglawal = left(rangetanggal, 10);
	var tglakhir = right(rangetanggal, 10);
	var idinstansi = $('#lblidinstansi').val();
	window.open("rekapitulasi@" + tglawal + "@" + tglakhir + "@" + idinstansi + ".html", '_self')
});

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

	$("#txttglterimaL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
	$("#txttglsuratL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
}

Chart.defaults.global.defaultFontColor = "#fff";

var ctx = document.getElementById('ChartGrafik').getContext("2d")
var gradient = ctx.createLinearGradient(0, 0, 0, 200)
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)')
gradient.addColorStop(0, '#b2d1f0')

function isiGrafikLayanan() {
	var rangetanggal = $("#txttanggaldashboard").val();
	var tglawal = left(rangetanggal, 10);
	var tglakhir = right(rangetanggal, 10);
	var idinstansi = $("#lblidinstansi").val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_grafik_lap_layanan.php",
		data: { idinstansi: idinstansi, tglawal: tglawal, tglakhir: tglakhir },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			var labels = [];
			var values = [];
			myArray = data;
			$.each(myArray, function (index, jum) {
				$("#lblkopperiode").html("Periode " + jum.tglawalindo + " s/d " +jum.tglakhirindo);
				labels.push(jum.nmlayanan);
				values.push(jum.jmllayanan);
			});

			var hitChartContent = document.getElementById('hitungChartGrafik');
			hitChartContent.innerHTML = '';
			$('#hitungChartGrafik').append('<canvas id="ChartGrafik" height="300"><canvas>');

			var salesChartCanvas = $('#ChartGrafik').get(0).getContext('2d')
			var salesChartData = {
				labels: labels,
				datasets: [
					{
						label: "Jumlah",
						backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE"],
						borderColor: 'rgba(60,141,188,0.8)',
						pointRadius: false,
						pointColor: '#3b8bba',
						pointStrokeColor: 'rgba(60,141,188,1)',
						pointHighlightFill: '#fff',
						pointHighlightStroke: 'rgba(60,141,188,1)',
						data: values,
					},
				]
			}

			var salesChartOptions = {
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					display: false
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
						ticks: { display: false, fontColor: 'rgb(255, 255, 255,0.6)' },
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

function right(str, chr) {
	return str.slice(str.length - chr, str.length);
}

function left(str, chr) {
	return str.slice(0, chr - str.length);
}