function bersihkan() {
	$("#area-dashboard-pengaduan").fadeOut();
	$("#area-halaman-pengaduan").fadeOut();
}

$("#lv_pengaduan").on("click", function () {
	bersihkan();
	ambiljumlah()
	isiMasterPengaduan();
	$("#area-halaman-pengaduan").fadeIn();

	$("#lblhalaman").val("pengaduan");
	$("#loading").fadeOut("slow");
});

function ambiljumlah() {
	var idbidang = $('#lblidinstansi').val();
	$("#lblnavjmlPengaduan").html("0");
	$.ajax({
		type: "POST",
		url: "aksi/ambil_jumlah.php",
		data: { idbidang: idbidang },
		dataType: 'json',
		success: function (data) {
			$("#lblnavjmlPengaduan").html("0");
			var i;
			for (i = 0; i < data.length; i++) {
				$("#lblnavjmlPengaduan").html(data[i].jumPengaduan);
			}
		},
		error: function () {
			console.log('error');
		},
	});
}

/*======================================================*/
/*===================== PENGADUAN =====================*/
/*=====================================================*/
function isiMasterPengaduan() {
	var idbidang = $('#lblidinstansi').val();
	var filterinfo = $('#cbofilterpengaduan').val();
	$.ajax({
		type: "POST",
		url: "aksi/pengaduan/isi_tabel_pengaduan.php",
		data: { filterinfo: filterinfo ,idbidang: idbidang },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelpengaduan').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if(data[i].sttspengaduan == "DISTRIBUSI"){
					var wrnhead = "bg-warning";var nmstatus = "DISTRIBUSI";
				} else if(data[i].sttspengaduan == "JAWABAN"){
					var wrnhead = "bg-success";var nmstatus = "TINDAKLANJUT";
				} else if(data[i].sttspengaduan == "SELESAI"){
					var wrnhead = "bg-primary";var nmstatus = "SELESAI";
				}

				html +=
				'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="3%">'+data[i].no+'</td>' +
					'<td class="align-middle" width="16%">'+data[i].tanggal+'</td>' +
					'<td class="align-middle" width="25%">' + data[i].nmpengadu + '</td>' +
					'<td class="align-middle" width="47%">' + data[i].uraianmasalah + '</td>' +
					'<td class="align-middle" width="5%"><span class="badge '+wrnhead+'">'+nmstatus+'</span></td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnFotoPengaduan" data-idpengaduan="'+data[i].idpengaduan+'" data-nik="'+data[i].nik+'" data-nmpengadu="'+data[i].nmpengadu+'" data-alamat="'+data[i].alamat+'" data-notelepon="'+data[i].notelepon+'" data-uraianmasalah="'+data[i].uraianmasalah+'"><span class="fas fa-camera"></span></button> '+
					'</td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnTeruskanPengaduan" data-idpengaduan="'+data[i].idpengaduan+'"><span class="fas fa-project-diagram"></span></button> '+
					'</td>' +
				'</tr>';
			}
			$('#isitabelpengaduan').html(html);
			$("#tabelpengaduan").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
			$("#loading").fadeOut("slow");

		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshPengaduan").click(function () {
	isiMasterPengaduan();
});

$('#isitabelpengaduan').on('click', '.btnTeruskanPengaduan', function () {
	var idpengaduan = $(this).data('idpengaduan');
	$.ajax({
		type: "POST",
		url: "aksi/pengaduan/pencarian-pengaduan.php",
		data: { idpengaduan: idpengaduan },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelpengaduan').on('click', '.btnFotoPengaduan', function () {
	var idpengaduan = $(this).data('idpengaduan');
	var nik = $(this).data('nik');
	var nmpengadu = $(this).data('nmpengadu');
	var alamat = $(this).data('alamat');
	var notelepon = $(this).data('notelepon');
	var uraianmasalah = $(this).data('uraianmasalah');
	$.ajax({
		type: "POST",
		url: "aksi/pengaduan/tampilkan-foto.php",
		data: { idpengaduan: idpengaduan,nik: nik,nmpengadu: nmpengadu,alamat: alamat,notelepon: notelepon,uraianmasalah: uraianmasalah },
		success: function (resp) {
			$("#isianmodFotoXLarge").html(resp);
			$("#isianmodFotoXLarge").fadeIn(1000);
			$("#modFotoXLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modFotoXLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

