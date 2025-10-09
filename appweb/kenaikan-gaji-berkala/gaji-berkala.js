function bersihkan() {

	$("#txtidlayananONFocus").val("");// indicator layanan

	$("#area-dashboard").css("display", "none");
	$("#area-mutasi-siswa").css("display", "none");

	$("#area-master-verifikator").css("display", "none");
	$("#area-master-layanan").css("display", "none");
	$("#area-master-bidang").css("display", "none");
	$("#area-master-seksi").css("display", "none");

	$("#area-arsip-mutasi-siswa").css("display", "none");

}

/*================ JUMLAH LAYANAN =================*/
function isiJumlahLayananDapo() {
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
		error: function () {
			console.log("Koneksi bermasalah periksa internet");
		},
	});
}

/*================ MUTASI SISWA 
 KOMPOSISI GAJI BERKALA =================*/
function isiMutasiSiswa() {
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_mutasi_siswa.php",
		data: { },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#tabeMutasiSiswa').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttsoptsekolah == "belum") { var warnakirimsoft = "badge-soft-secondary"; }
				else if (data[i].sttsoptsekolah == "terkirim") { var warnakirimsoft = "bg-primary";}

				if (data[i].sttsoptdapodik == "belum") { 
					var wrnlevel2 = "badge-soft-secondary";
					var hidblmterkirim = "";var hidterkirim = "display:none";
				}else if (data[i].sttsoptdapodik == "terkirim") { 
					var wrnlevel2 = "bg-primary";
					var hidblmterkirim = "display:none";var hidterkirim = "";
				}
				
				if (data[i].sttsoptbidang == "belum") { var wrnlevel3 = "badge-soft-secondary";}
				else if (data[i].sttsoptbidang == "terkirim") { var wrnlevel3 = "bg-primary";}
				
				if (data[i].sttskasi == "belum") { var wrnlevel4 = "badge-soft-secondary";}
				else if (data[i].sttskasi == "terima") { var wrnlevel4 = "bg-primary";}
				else if (data[i].sttskasi == "tolak") { var wrnlevel4 = "bg-danger";}

				if (data[i].sttskabid == "belum") { var wrnlevel5 = "badge-soft-secondary";}
				else if (data[i].sttskabid == "terima") { var wrnlevel5 = "bg-primary";}
				else if (data[i].sttskabid == "tolak") { var wrnlevel5 = "bg-danger";}

				if (data[i].ketstatussurat == "Belum") { var warnastatus = "badge-soft-secondary";var hidarsip = "display:none";var hidcmdedit = "";var hidcmdkirim = "";}
				else if (data[i].ketstatussurat == "Terima") { var warnastatus = "badge-soft-primary";var hidarsip = "";var hidcmdedit = "display:none";var hidcmdkirim = "display:none";}
				else if (data[i].ketstatussurat == "Tolak") { var warnastatus = "badge-soft-danger";var hidarsip = "display:none";var hidcmdedit = "";var hidcmdkirim = "";}

				if (data[i].sttssyarat == "belum") { var dissttssyarat = "display:none"; }
				else if (data[i].sttssyarat == "sudah") { var dissttssyarat = ""; }

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-top text-center" width="4%">' + data[i].no + '</td>' +
					'<td class="align-top" width="14%">' + data[i].tglsurat + '<br/>' + data[i].nosurat + '</td>' +
					'<td class="align-top" width="22%">' + data[i].namasiswa + '<br><span class="text-secondary"><b>Kelas : </b>' + data[i].kelas + '<br><b>No. WA : </b>' + data[i].nowa + '</span></td>' +
					'<td class="align-top text-truncate" width="40%" style="max-width:100px;">' + 
						data[i].asalsekolah + ' - ' + data[i].npsnasalsekolah + '<br><b>Mutasi Ke :</b><br>' + data[i].mutasike + ' - ' + data[i].npsnmutasi + '<br><b>Alasan :</b> ' + data[i].alasanmutasi + 
					'</td>' +
					'<td class="align-middle text-center" width="16%">' +
						'<a href="#" class="badge ' + warnakirimsoft + ' fs--2 me-1 mb-1 btnViewTimelineMutasiSiswa" data-bs-toggle="tooltip" title="Status surat" data-idtransaksi="' + data[i].idtransaksi + '">1</a>' +
						'<a href="#" class="badge ' + wrnlevel2 + ' fs--2 me-1 mb-1 btnViewTimelineMutasiSiswa" data-bs-toggle="tooltip" title="Status surat" data-idtransaksi="' + data[i].idtransaksi + '">2</a>' +
						'<a href="#" class="badge ' + wrnlevel3 + ' fs--2 me-1 mb-1 btnViewTimelineMutasiSiswa" data-bs-toggle="tooltip" title="Status surat" data-idtransaksi="' + data[i].idtransaksi + '">3</a>' +
						'<a href="#" class="badge ' + wrnlevel4 + ' fs--2 me-1 mb-1 btnViewTimelineMutasiSiswa" data-bs-toggle="tooltip" title="Status surat" data-idtransaksi="' + data[i].idtransaksi + '">4</a>' +
						'<a href="#" class="badge ' + wrnlevel5 + ' mt-1 me-1 mb-1 btnViewTimelineMutasiSiswa" data-bs-toggle="tooltip" title="Status surat" data-idtransaksi="' + data[i].idtransaksi + '"><span class="fas fa-user-tie fs--2"></span></a>' +
						'<br/><a href="#" class="badge ' + warnastatus + ' mt-2 btnViewTimelineMutasiSiswa" data-bs-toggle="tooltip" title="Status surat" data-idtransaksi="' + data[i].idtransaksi + '">' + data[i].ketstatussurat + '</a>' +
					'</td>' +
					'<td class="align-middle text-center" width="5%">' +
						'<button class="btn btn-light icon-item rounded-3 mb-1 fs--2 icon-item-sm btnUploadSyaratMutasiSiswa" data-bs-toggle="tooltip" title="Upload persyaratan" data-idtransaksi="' + data[i].idtransaksi + '" data-idlayanan="' + data[i].idlayanan + '" data-layanan="Mutasi Siswa" data-idsekolah="' + data[i].idsekolah + '" data-idbidang="' + data[i].idbidang + '" data-namasiswa="' + data[i].namasiswa + '" data-nosurat="' + data[i].nosurat + '"><span class="fas fa-paperclip"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 mb-1 fs--2 icon-item-sm btnPesanMutasiSiswa" data-bs-toggle="tooltip" title="Kirim Pesan" data-idtransaksi="' + data[i].idtransaksi + '" data-idlayanan="' + data[i].idlayanan + '" data-layanan="Mutasi Siswa" data-idsekolah="' + data[i].idsekolah + '" data-idbidang="' + data[i].idbidang + '" data-namasiswa="' + data[i].namasiswa + '" data-nosurat="' + data[i].nosurat + '" data-sttskirim="' + data[i].sttsoptdapodik + '"><span class="fas fa-comment-alt text-500"></span></button> ' +
					'</td>' +
					'<td class="align-middle" width="5%">' +
						'<button class="btn btn-light icon-item rounded-3 mb-1 fs--2 icon-item-sm btnKirimMutasiSiswa" data-bs-toggle="tooltip" title="Kirim surat" data-idtransaksi="' + data[i].idtransaksi + '" data-idlayanan="' + data[i].idlayanan + '" data-idsekolah="' + data[i].idsekolah + '" data-idbidang="' + data[i].idbidang + '" data-sttsoptdapodik="' + data[i].sttsoptdapodik + '" data-ketlevel="' + data[i].ketlevel + '" data-nosurat="' + data[i].nosurat + '" data-namasiswa="' + data[i].namasiswa + '" data-kelas="' + data[i].kelas + '" data-asalsekolah="' + data[i].asalsekolah + '" data-mutasike="' + data[i].mutasike + '" data-alasanmutasi="' + data[i].alasanmutasi + '" style="' + dissttssyarat + ';' + hidcmdkirim + '"><span class="fas fa-share-alt"></span></button> ' +
						'<a href="print-surat-' + data[i].mdcetak + '.html" target="_blank" data-bs-toggle="tooltip" title="Pratinjau surat" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1" style="' + hidblmterkirim + '"><span class="fas fa-envelope"></span></a>' +
						'<a href="tampilkan-' + data[i].mdcetak + '.html" target="_blank" data-bs-toggle="tooltip" title="Tampilkan surat" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm" style="' + hidterkirim + '"><span class="fas fa-envelope"></span></a>' +
					'</td>' +
					'<td class="align-middle" width="5%">' +
						'<button class="btn btn-light icon-item rounded-3 mb-1 fs--2 icon-item-sm btnArsipMutasiSiswa" data-bs-toggle="tooltip" title="Arsipkan Surat" data-id="' + data[i].idtransaksi + '" data-idlayanan="' + data[i].idlayanan + '" data-idsekolah="' + data[i].idsekolah + '" data-idbidang="' + data[i].idbidang + '" data-sttsoptdapodik="' + data[i].sttsoptdapodik + '" data-ketlevel="' + data[i].ketlevel + '" data-nosurat="' + data[i].nosurat + '" data-namasiswa="' + data[i].namasiswa + '" data-kelas="' + data[i].kelas + '" data-asalsekolah="' + data[i].asalsekolah + '" data-mutasike="' + data[i].mutasike + '" data-alasanmutasi="' + data[i].alasanmutasi + '" style="' + hidarsip + '"><span class="fas fa-folder-open"></span></button> ' +
						'<button class="btn btn-light icon-item rounded-3 mb-1 fs--2 icon-item-sm btnEditMutasiSiswa" data-bs-toggle="tooltip" title="Edit Surat" data-idtransaksi="' + data[i].idtransaksi + '" data-idlayanan="' + data[i].idlayanan + '" data-idsekolah="' + data[i].idsekolah + '" style="' + hidcmdedit + '"><span class="fas fa-edit"></span></button> ' +
					'</td>' +
					'</tr>';
			}
			$('#isitabeMutasiSiswa').html(html);
			$("#tabeMutasiSiswa").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
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

$("#cmdRefreshMutasiSiswa").click(function () {
	//isiMutasiSiswa()
	var kalimat = "234512#ID@009";
	var awalid = kalimat.indexOf("#");
	var akhirid = kalimat.indexOf("@");
	var panjangkalimat = kalimat.length;
	var filterid = kalimat.slice(awalid+1, akhirid);
	var filtertransaksi = kalimat.slice(akhirid+1, panjangkalimat);
	//alert(filtertransaksi)
	socket.emit('kirim pesan to operator sekolah',filterid+"@"+filtertransaksi);  
});

$("#cmdArsipMutasiSiswa").click(function () {
	var idlayanan = "1";
	var idsekolah = $(this).data('idsekolah');
	$.ajax({
		type: 'POST',
		url: "aksi/trans-layanan/mutasi-siswa/tambah_mutasi_siswa.php",
		data: {
			idlayanan: idlayanan
		},
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function(resp) {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modEditDataLarge").modal('show');
			$("#modTambahDataLarge").modal('hide');
		},
		error: function() {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			alert("Koneksi ke server terputus");
		},
	});
});

$('#isitabeMutasiSiswa').on('click', '.btnEditMutasiSiswa', function () {
	var idtransaksi = $(this).data('idtransaksi');
	var idlayanan = $(this).data('idlayanan'); 
	var idsekolah = $(this).data('idsekolah');
	$.ajax({
		type: 'POST',
		url: "aksi/trans-layanan/mutasi-siswa/edit_mutasi_siswa.php",
		data: {idtransaksi: idtransaksi,idlayanan: idlayanan},
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function(resp) {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			$("#isianModEditDataLarge").html(resp);
			$("#isianModEditDataLarge").fadeIn(1000);
			$("#modEditDataLarge").modal({
				backdrop: 'static',
				keyboard: false
			})
			$("#modEditDataLarge").modal('show');
			$("#modTambahDataLarge").modal('hide');
		},
		error: function() {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			alert("Koneksi ke server terputus");
		},
	});
});

$('#isitabeMutasiSiswa').on('click', '.btnUploadSyaratMutasiSiswa', function () {
	var idtransaksi = $(this).data('idtransaksi');
	var idlayanan = $(this).data('idlayanan'); var layanan = $(this).data('layanan');
	var nosurat = $(this).data('nosurat');var namasiswa = $(this).data('namasiswa');
	var idsekolah = $(this).data('idsekolah');
	$.ajax({
		type: "POST",
		url: "aksi/trans-layanan/tambah_persyaratan.php",
		data: { idtransaksi: idtransaksi,idlayanan: idlayanan,layanan: layanan,nosurat: nosurat,namasiswa: namasiswa,idsekolah: idsekolah },
		success: function (resp) {
			$("#isianmodTampilSyarat").html(resp);
			$("#isianmodTampilSyarat").fadeIn(1000);
			$("#modTampilSyarat").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabeMutasiSiswa').on('click', '.btnPesanMutasiSiswa', function () {
	$("#txtidsuratbukapesan").val("");
	var idtransaksi = $(this).data('idtransaksi');
	var idlayanan = $(this).data('idlayanan'); var layanan = $(this).data('layanan');
	var nosurat = $(this).data('nosurat');var namasiswa = $(this).data('namasiswa');
	var idsekolah = $(this).data('idsekolah');
	var sttskirim = $(this).data('sttskirim');
	$("#txtidsuratbukapesan").val(idtransaksi);// indicator idsurat --> node.js
	$.ajax({
		type: "POST",
		url: "aksi/trans-layanan/mutasi-siswa/pesan/pesan-mutasi-siswa.php",
		data: { idtransaksi: idtransaksi,idlayanan: idlayanan,layanan: layanan,nosurat: nosurat,namasiswa: namasiswa,idsekolah: idsekolah,sttskirim: sttskirim },
		success: function (resp) {
			$("#isianModBebasData").html(resp);
			$("#isianModBebasData").fadeIn(1000);
			$("#modBebasData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabeMutasiSiswa').on('click', '.btnViewTimelineMutasiSiswa', function () {
	var idtransaksi = $(this).data('idtransaksi');
	var Urltimeline = "aksi/trans-layanan/mutasi-siswa/timeline-mutasi-siswa.php";
	$.ajax({
		type: "POST",
		url: Urltimeline,
		data: { idtransaksi: idtransaksi },
		success: function (resp) {
			$("#isianModBebasData").html(resp);
			$("#isianModBebasData").fadeIn(1000);
			$("#modBebasData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabeMutasiSiswa').on('click', '.btnKirimMutasiSiswa', function () {
	var idsekolah = $(this).data('idsekolah');
	var idbidang = $(this).data('idbidang');
	var idtransaksi = $(this).data('idtransaksi');
	var idlayanan = $(this).data('idlayanan');
	var nosurat = $(this).data('nosurat');
	var namasiswa = $(this).data('namasiswa'); 
	var kelas = $(this).data('kelas'); 

	var asalsekolah = $(this).data('asalsekolah'); 
	var mutasike = $(this).data('mutasike'); 
	var alasanmutasi = $(this).data('alasanmutasi'); 

	var layanan = "Mutasi Siswa"; 
	var sttsoptdapodik = $(this).data('sttsoptdapodik');
	var ketlevel = $(this).data('ketlevel');

	$.ajax({
		type: "POST",
		url: "aksi/trans-layanan/mutasi-siswa/kirim_surat.php",
		data: { idtransaksi: idtransaksi,idlayanan: idlayanan,layanan: layanan,nosurat: nosurat,namasiswa: namasiswa,kelas: kelas,idsekolah: idsekolah,idbidang: idbidang,ketlevel: ketlevel,sttsoptdapodik: sttsoptdapodik,asalsekolah: asalsekolah,mutasike: mutasike,alasanmutasi: alasanmutasi },
		success: function (resp) {
			$("#isianModBebasData").html(resp);
			$("#isianModBebasData").fadeIn(1000);
			$("#modBebasData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
		
});
