function bersihkan() {
	$("#area-dashboard").css("display", "none");
	$("#area-survei-ats").css("display", "none");
}

function bersihkanFilter() {
	$("#txtfilterdata").val("");
	$("#txtfilteridkecamatan").val("");
	$("#txtfilteriddesa").val("");
	$("#txtfilteriduniversitas").val("");
	$("#txtfilteridfakultas").val("");
	$("#txtfilterumur").val("");
	$("#txtfilterbentukpendidikan").val("");
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

	$("#txttglterimaL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
	$("#txttglsuratL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
}

/*================ JUMLAH LAYANAN =================*/
function isiJumlahLayanan() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_jumlah_layanan.php",
		data: {},
		dataType: 'json',
		success: function (data) {
			$("#lbljummutasisiswa").text("0");
			var i;
			for (i = 0; i < data.length; i++) {
				if (data[i].jummutasisiswa <= 0){document.getElementById("lbljummutasisiswa").style.visibility = "hidden";
				} else {document.getElementById("lbljummutasisiswa").style.visibility = "visible";}

				$("#lbljummutasisiswa").text(data[i].jummutasisiswa);
			}
		},
	});
}
