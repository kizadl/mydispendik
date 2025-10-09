function isiNotifikasiPesan() {
	var idsekolah = $("#lblidinstansi").val();
	var ketlevel = $("#lblnamalevel").val();
	$.ajax({
		type: "POST",
		url: "aksi/notifikasi/isi_notifikasi_pesan.php",
		data: {idsekolah:idsekolah,ketlevel:ketlevel},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#area-notifikasi-pesan').html("");
			$('.lbljumnotifpesan').text("0");
			$('.cmdHapusNotifikasiPesan').text("Hapus 0 pesan belum dibaca");
			document.body.style.cursor = "default";
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<div class="list-group-item">' +
					'<a class="notification notification-unread notification-flush btnListNotifPesan" data-idpesan="' + data[i].idpesan + '" data-idtransaksi="' + data[i].idtransaksi + '" data-idlayanan="' + data[i].idlayanan + '" data-nmlayanan="' + data[i].nmlayanan + '" data-idsekolah="' + data[i].idsekolah + '" data-sttskirim="' + data[i].sttskirim + '" href="#!">' +
					'<div class="notification-body">' +
					'<p class="mb-1"><strong>' + data[i].nmpengirim +'<br></strong>' + data[i].isipesan + '</p>' +
					'<span class="notification-time text-800">' + data[i].waktupesan + ' - ' + data[i].jampesan + 
					'<br/>' + data[i].nmlayanan + '</span>' +
					'</div>' +
					'</a>' +
					'</div>';

					$('.lbljumnotifpesan').text(data[i].no);
					$('.cmdHapusNotifikasiPesan').text("Hapus "+data[i].no+" pesan belum dibaca");
			}
			$('#area-notifikasi-pesan').html(html);
			$("#loading").fadeOut("slow");
		},
		error: function () {
			$("#loading").fadeOut("slow");
			console.log("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$('#area-notifikasi-pesan').on('click', '.btnListNotifPesan', function () {
	$("#txtidsuratbukapesan").val("");
	var idpesan = $(this).data('idpesan');
	var idtransaksi = $(this).data('idtransaksi');
	var idlayanan = $(this).data('idlayanan'); var nmlayanan = $(this).data('nmlayanan');
	var idsekolah = $(this).data('idsekolah');
	var sttskirim = $(this).data('sttskirim');
	$("#txtidsuratbukapesan").val(idtransaksi); // indicator idsurat --> node.js
	if (idlayanan == "1"){var urlPesan = "aksi/notifikasi/pesan-mutasi-siswa.php";}
	else if (idlayanan == "2"){var urlPesan = "aksi/notifikasi/pesan-layanan.php";}
	else if (idlayanan == "3"){var urlPesan = "aksi/notifikasi/pesan-layanan.php";}
	else if (idlayanan == "4"){var urlPesan = "aksi/notifikasi/pesan-layanan.php";}
	else if (idlayanan == "5"){var urlPesan = "aksi/notifikasi/pesan-layanan.php";}
	else if (idlayanan == "6"){var urlPesan = "aksi/notifikasi/pesan-layanan.php";}
	else if (idlayanan == "7"){var urlPesan = "aksi/notifikasi/pesan-layanan.php";}
	else if (idlayanan == "8"){var urlPesan = "aksi/notifikasi/pesan-layanan.php";}
	$.ajax({
		type: "POST",
		url: urlPesan,
		data: { idpesan: idpesan,idtransaksi: idtransaksi,idlayanan: idlayanan,nmlayanan: nmlayanan,idsekolah: idsekolah,sttskirim: sttskirim },
		success: function (resp) {
			$("#isianModBebasData").html(resp);
			$("#isianModBebasData").fadeIn(1000);
			$("#modBebasData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('.cmdHapusNotifikasiPesan').on('click', function () {
	var ketlevel = $("#lblnamalevel").val();
	$.ajax({
		type: "POST",
		url:  "aksi/notifikasi/aksi_hapus_notifikasi_pesan.php",
		data: {ketlevel: ketlevel},
		dataType: "json",
		beforeSend: function (e) {
			document.body.style.cursor = "wait";
		},
		success: function (resp) {
			document.body.style.cursor = "default";
			if (resp.msg2 == "ok"){
				isiNotifikasiPesan();
			}
		},
		error: function () { 
			document.body.style.cursor = "default";
			console.log('Koneksi bermasalah periksa internet'); 
		},
	});
});

function isiNotifikasiStatus() {
	var idinstansi = $("#lblidinstansi").val();
	var ketlevel = $("#lblnamalevel").val();
	$.ajax({
		type: "POST",
		url: "aksi/notifikasi/isi_notifikasi_status.php",
		data: {idinstansi:idinstansi,ketlevel:ketlevel},
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#area-notifikasi-status').html("");
			$('.lbljumnotifstatus').text("0");
			$('.cmdHapusNotifikasiStatus').text("Hapus 0 pembaharuan status");
			document.body.style.cursor = "default";
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<div class="list-group-item">' +
					'<a class="notification notification-unread notification-flush btnListNotifStatus" data-idstatus="' + data[i].idstatus + '" data-idtransaksi="' + data[i].idtransaksi + '" data-idlayanan="' + data[i].idlayanan + '" data-nmlayanan="' + data[i].nmlayanan + '" href="#!">' +
					'<div class="notification-body">' +
					'<p class="mb-1"><strong>' + data[i].nmpengirim +'<br></strong>' + data[i].isistatus + '</p>' +
					'<span class="notification-time text-800">' + data[i].tglstatus + ' - ' + data[i].jamstatus + 
					'<br/>' + data[i].nmlayanan + '</span>' +
					'</div>' +
					'</a>' +
					'</div>';

					$('.lbljumnotifstatus').text(data[i].no);
					$('.cmdHapusNotifikasiStatus').text("Hapus "+data[i].no+" pembaharuan status");
			}
			$('#area-notifikasi-status').html(html);
			$("#loading").fadeOut("slow");
		},
		error: function () {
			$("#loading").fadeOut("slow");
			console.log("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$('#area-notifikasi-status').on('click', '.btnListNotifStatus', function () {
	var idstatus = $(this).data('idstatus');
	var idtransaksi = $(this).data('idtransaksi');
	var idlayanan = $(this).data('idlayanan');
	if (idlayanan == "1"){var urltimeline = "aksi/notifikasi/timeline-mutasi-siswa.php";}
	else if (idlayanan == "2"){var urltimeline = "aksi/notifikasi/timeline-pdb-mi.php";}
	else if (idlayanan == "3"){var urltimeline = "aksi/notifikasi/timeline-mutasi-pendidik.php";}
	else if (idlayanan == "4"){var urltimeline = "aksi/notifikasi/timeline-pergantian-kepsek.php";}
	else if (idlayanan == "5"){var urltimeline = "aksi/notifikasi/timeline-perubahan-ptk.php";}
	else if (idlayanan == "6"){var urltimeline = "aksi/notifikasi/timeline-pengajuan-npsn.php";}
	else if (idlayanan == "7"){var urltimeline = "aksi/notifikasi/timeline-akun-operator.php";}
	else if (idlayanan == "8"){var urltimeline = "aksi/notifikasi/timeline-pengajuan-npyp.php";}
	$.ajax({
		type: "POST",
		url: urltimeline,
		data: { idstatus: idstatus,idtransaksi: idtransaksi },
		success: function (resp) {
			$("#isianModBebasData").html(resp);
			$("#isianModBebasData").fadeIn(1000);
			$("#modBebasData").modal('show');
			isiNotifikasiStatus();
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('.cmdHapusNotifikasiStatus').on('click', function () {
	var ketlevel = $("#lblnamalevel").val();
	$.ajax({
		type: "POST",
		url:  "aksi/notifikasi/aksi_hapus_notifikasi_status.php",
		data: {ketlevel: ketlevel},
		dataType: "json",
		beforeSend: function (e) {
			document.body.style.cursor = "wait";
		},
		success: function (resp) {
			document.body.style.cursor = "default";
			if (resp.msg2 == "ok"){
				isiNotifikasiStatus();
			}
		},
		error: function () { 
			document.body.style.cursor = "default";
			console.log('Koneksi bermasalah periksa internet'); 
		},
	});
});