function bersihkan(){
	stopVideo()
	$("#lblhalaman").val("");
	$("#txttransid").val("");$("#txttransketerangan").val("");$("#txttransnmwilayah").val("");
	
	$("#txttransiddetailsekolah").val("");//// detail sekolah ////

	$("#lblkoppeta").text("");
	$("#lblkopgrafik1").text("");$("#lblkopgrafik2").text("");
	$("#lblkopgrafik3").text("");$("#lblkopgrafik4").text("");
	
	$("#area-halaman-utama").fadeOut("slow");
	$("#area-halaman-sekolah").fadeOut("slow");
	$("#area-halaman-media").fadeOut("slow");
	$("#area-peta").fadeOut("slow");
  }

  $('#cmdGantiPassword').on('click', function() {
	var idoperator = $('#lbleditor').val();
	$.ajax({
		type:"POST",		
		url :"../services/reset_password.php",	
		data:{idoperator:idoperator},
		success:function(resp){
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
			$("#modTambahData").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	}); 
  });

  $("#lv_data_media").on("click",function(){
	bersihkan();           
	isiMasterMedia();
	$("#area-halaman-media").fadeIn();

	$("#lblhalaman").val("mastermedia");
	$("#loading").fadeOut("slow");
  });

	function groupArrayOfObjects(list, key) {
		return list.reduce(function(rv, x) {
		  (rv[x[key]] = rv[x[key]] || []).push(x);
		  return rv;
		}, {});
	  };

  /*================ MEDIA =================*/
  function isiMasterMedia(){
	var filtermedia = $("#cbofiltermedia").val();
	$.ajax({
	  type:"POST",
	  url : "aksi/isi_tabel_kondisi_prasarana.php",
	  data: {filtermedia: filtermedia},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
		  $('#tabelMediaAdm').dataTable().fnDestroy();
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
 
				  html += 
				  '<tr class="btn-reveal-trigger">'+
					'<td class="align-middle" width="12%">'+data[i].npsn+'</td>'+
					'<td class="align-middle text-truncate" width="34%" style="max-width:250px;">'+data[i].nminstansi+'</td>'+
					'<td class="align-middle text-center" width="3%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnViewMediaAdm" data-id="'+data[i].id+'" data-koordinat="'+data[i].koordinat+'" data-bs-toggle="tooltip" title="Tampilkan data media"><span class="fa fa-camera"></span></button>'+
					'</td>'+
					'<td class="align-middle text-center" width="3%">'+
					  '<a href="cetak-persetujuan-'+data[i].mdid+'.html" target="_blank" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1" data-bs-toggle="tooltip" title="Download form kerusakan"><span class="fa fa-file-pdf"></span></a>'+
					'</td>'+
					'<td class="align-middle text-center" width="3%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnUploadPersetujuan" data-id="'+data[i].id+'" data-npsn="'+data[i].npsn+'" data-bs-toggle="tooltip" title="Upload Persetujuan"><span class="fas fa-edit text-primary"></span></button>'+
					'</td>'+
					'<td class="align-middle text-center" width="12%">'+
						'<a href="tampilkan-'+data[i].npsn+'.html" target="_blank" class="badge badge-soft-primary">'+data[i].statussetuju+'</a>'+
					'</td>'+
					'<td class="align-middle text-center text-primary" width="3%"><strong>'+data[i].jmltotal+'</strong></td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].kelas+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].perpustakaan+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].kepsek+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].guru+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].pembinaan+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].multimedia+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].komputer+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].ips+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].ipa+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].bahasa+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].wcumum+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].wcsiswa+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].wcguru+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].ibadah+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].asrama+'</td>'+
				  '</tr>';
				  }			
				  $('#isitabelMediaAdm').html(html);
				  $("#tabelMediaAdm").dataTable({"paging": true, "lengthChange": false,"pageLength": 25,"ordering": true,"info": false,"autoWidth": false,"responsive": false,"select": false,"scrollX": true,
						initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
						$("#loading").fadeOut("slow");		

	  },
	  error: function() {
		$("#loading").fadeOut("slow");
		alert("Koneksi bermasalah periksa internet");
		document.body.style.cursor = "default";					
	  },
	});	
  }

  $("#cmdRefreshMedia").on("click",function(){
	isiMasterMedia();
  });

  $("#cmdExcelMedia").on("click",function(){
	var filtermedia = $("#cbofiltermedia").val();
	window.open("excel-rekap-"+filtermedia+".html", '_self')
  });

  $('#isitabelMediaAdm').on('click', '.btnViewMediaAdm', function() {
	$("#txttransiddetailsekolah").val("");
	var idsekolah = $(this).data('id');
	$("#txttransiddetailsekolah").val(idsekolah);

	window.scrollTo(0, 0);
	const koordinat = $(this).data('koordinat');
	const words1 = koordinat.split(',');
	map.setView([words1[0], words1[1]], 18);
	
	stopVideo()

	$.ajax({
		type: 'POST',
		url: "aksi/tampilkan/tampilkan-detail-dashboard.php",
		data: {
			idsekolah: idsekolah
		},
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function(resp) {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			$("#area-halaman-utama").fadeOut("slow");
			$("#area-halaman-media").fadeOut("slow");
			$("#area-halaman-sekolah").fadeIn();
			$("#area-peta").fadeIn();

			$('#hal-detail-sekolah').html(resp);

			//let player = Plyr.setup('.popin__video-container');
			//player.restart();
			isiVideo()

			isiFotoKelas()
			isiFotoPerpustakaan()
			isiFotoKepsek()
			isiFotoGuru()
			isiFotoPembinaan()
			isiFotoMultimedia()
			isiFotoKomputer()
			isiFotoIPS()
			isiFotoIPA()
			isiFotoBahasa()
			isiFotoWCUmum()
			isiFotoWCSiswa()
			isiFotoWCGuru()
			isiFotoIbadah()
			isiFotoAsrama()

			$("#modTambahDataLarge").modal('hide');
		},
		error: function() {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			alert("Koneksi ke server terputus");
		},
	});
  });

  $('#isitabelMediaAdm').on('click','.btnUploadPersetujuan',function(){
	var idsekolah = $(this).data('id');var npsn = $(this).data('npsn');
	$.ajax({
	  type:"POST",		
	  url :"aksi/upload-surat/edit_surat.php",	
	  data:{idsekolah:idsekolah,npsn:npsn},
	  success:function(resp){
		$("#isianModEditDataLarge").html(resp);
		$("#isianModEditDataLarge").fadeIn(1000);
		$("#modEditDataLarge").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditDataLarge").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });


