function bersihkan() {
	$('#area-dashboard').css('display', 'none');
	$('#area-master-koordinator').css('display', 'none');
	$('#area-master-surveyor').css('display', 'none');
	$('#area-master-desk').css('display', 'none');
	$('#area-master-universitas').css('display', 'none');
	$('#area-master-fakultas').css('display', 'none');
	$('#area-koordinator-surveyor').css('display', 'none');
	$('#area-surveyor-ats').css('display', 'none');
	$('#area-survei-ats').css('display', 'none');
}

function bersihkanFilter() {
	$('#txtketfilterdata').val('Semua Data Surveyor');
	$('#txtketfilter').val('all');
	$('#txtfilteriduniversitas').val('');
	$('#txtfilteridfakultas').val('');
	$('#txtfilteridkecamatan').val('');
	$('#txtfilteriddesa').val('');

	$('#txtfilterdataSurvei').val('');
	$('#txtfilteridkecamatanSurvei').val('');
	$('#txtfilteriddesaSurvei').val('');
	$('#txtfilteriduniversitasSurvei').val('');
	$('#txtfilteridfakultasSurvei').val('');
	$('#txtfilterumurSurvei').val('');
	$('#txtfilterbentukpendidikanSurvei').val('');
	$('#txtfilterkategorisurvei').val('');
}

function right(str, chr) {
	return str.slice(str.length - chr, str.length);
}

function left(str, chr) {
	return str.slice(0, chr - str.length);
}

function tanggalHariIni() {
	var tglserver = $('#lbltglserver').val();
	arrbulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
	arrtanggal = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', ];
	mydate = new Date(tglserver);

	tanggal = mydate.getDate();
	bulan = mydate.getMonth();
	tahun = mydate.getFullYear();

	//$("#txttglterimaL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
}

/*================ JUMLAH LAYANAN =================*/
function isiJumlahLayanan() {
	$.ajax({
		type: 'POST',
		url: 'aksi/isi_jumlah_layanan.php',
		data: {},
		dataType: 'json',
		success: function (data) {
			$('#lbljumlahsiswasurvei').text('0');
			var i;
			for (i = 0; i < data.length; i++) {
				if (data[i].jumsiswa <= 0) {
					document.getElementById('lbljumlahsiswasurvei').style.visibility = 'hidden';
				} else {
					document.getElementById('lbljumlahsiswasurvei').style.visibility = 'visible';
				}

				$('#lbljumlahsiswasurvei').text(data[i].jumsiswa);
			}
		},
	});
}

/*================ HASIL SURVEYOR =================*/
function isiHasilSurvei(page = 1) {
    console.log("TEST isiHasilSurvei called with page:", page);
    var filterdata = $('#txtfilterdataSurvei').val() || '';
    var idkecamatan = $('#txtfilteridkecamatanSurvei').val() || '';
    var iddesa = $('#txtfilteriddesaSurvei').val() || '';
    var iduniversitas = $('#txtfilteriduniversitasSurvei').val() || '';
    var idfakultas = $('#txtfilteridfakultasSurvei').val() || '';
    var umur = $('#txtfilterumurSurvei').val() || '';
    var bentukpendidikan = $('#txtfilterbentukpendidikanSurvei').val() || '';
    var kategori = $('#txtfilterkategorisurvei').val() || '';
    var limit = 100; // Number of records per page
    
    $.ajax({
        type: 'POST',
        url: 'aksi/isi_tabel_hasil_survei.php',
        data: {
            filterdata: filterdata,
            idkecamatan: idkecamatan,
            iddesa: iddesa,
            iduniversitas: iduniversitas,
            idfakultas: idfakultas,
            umur: umur,
            bentukpendidikan: bentukpendidikan,
            kategori: kategori,
            page: page,
            limit: limit
        },
        dataType: 'json',
        beforeSend: function (e) {
            $('#loading').fadeIn();
            document.body.style.cursor = 'wait';
        },
        success: function (response) {
            // Destroy existing DataTable
            try {
                if ($.fn.DataTable.isDataTable('#tableHasilSurveyor')) {
                    $('#tableHasilSurveyor').DataTable().destroy();
                }
            } catch (e) {
                console.log('Error destroying table:', e);
            }
            
            document.body.style.cursor = 'default';
            $('#loading').fadeOut('slow');
            
            console.log('Received data:', response);
            
            var html = '';
            if (!response || !response.data || response.data.length === 0) {
                html = '<tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>';
                $('#isitableHasilSurveyor').html(html);
                $('#paginationSurvei').html('Tidak ada data');
                return;
            }
            
            var records = response.data;
            for (var i = 0; i < records.length; i++) {
                if (records[i].statusats == 'DO') {
                    var warnaaktif = 'bg-danger';
                } else if (records[i].statusats == 'BPB') {
                    var warnaaktif = 'bg-primary';
                } else if (records[i].statusats == 'LTM') {
                    var warnaaktif = 'bg-warning';
                } else {
                    records[i].statusats = 'LA';
                    var warnaaktif = 'bg-secondary';
                }

                if (records[i].jumsurvei == '0') {
                    var warnasurvei = 'bg-danger';
                    var hidfoto = 'display:none';
                } else {
                    var warnasurvei = 'bg-success';
                    var hidfoto = '';
                }

                html +=
                    '<tr class="btn-reveal-trigger">' +
                    '<td class="align-middle" width="4%">' +
                    records[i].no +
                    '</td>' +
                    '<td class="align-middle text-truncate" width="22%" style="max-width:120px">' +
                    records[i].namasiswa +
                    '<br>' +
                    records[i].tmplahir +
                    ', ' +
                    records[i].tgllahir +
                    ' - ' +
                    records[i].umur +
                    ' Tahun</td>' +
                    '<td class="align-middle text-truncate" width="27%" style="max-width:200px">' +
                    '<span class="me-1">' +
                    records[i].alamat +
                    ', RT ' +
                    records[i].rt +
                    ', RW ' +
                    records[i].rw +
                    '<br>' +
                    records[i].desa +
                    ' - ' +
                    records[i].kecamatan +
                    '</span>' +
                    '</td>' +
                    '<td class="align-middle" width="32%">' +
                    records[i].namasekolah +
                    '<br>' +
                    records[i].statusats +
                    ' Tahun ' +
                    records[i].tahun +
                    ' - ' +
                    records[i].bentukpendidikan +
                    ' - Tingkat ' +
                    records[i].tingkatpendidikan +
                    '</td>' +
                    '<td class="align-middle" width="5%">' +
                    '<span class="badge ' +
                    warnaaktif +
                    '">' +
                    records[i].statusats +
                    '</span>' +
                    '</td>' +
                    '<td class="align-middle" width="5%">' +
                    '<a href="#" class="badge ' +
                    warnasurvei +
                    ' text-white btnViewTimeline" data-idsiswa="' +
                    records[i].idsiswa +
                    '" data-jumsurvei="' +
                    records[i].jumsurvei +
                    '">' +
                    records[i].jumsurvei +
                    '</a>' +
                    '</td>' +
                    '<td align="right" class="d-flex" width="4%">' +
                    '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnViewFoto" data-idsiswa="' +
                    records[i].idsiswa +
                    '" style="' +
                    hidfoto +
                    '"><span class="fas fa-camera"></span></button> ' +
                    '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditSiswa" data-idsiswa="' +
                    records[i].idsiswa +
                    '"><span class="fas fa-edit"></span></button> ' +
                    '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnSurvei" data-idsiswa="' +
                    records[i].idsiswa +
                    '"><span class="fas fa-sliders-h"></span></button> ' +
                    '</td>' +
                    '</tr>';
            }
            
            try {
                $('#isitableHasilSurveyor').html(html);

                // Initialize DataTable
                var table = $('#tableHasilSurveyor').DataTable({
                    retrieve: false,
                    destroy: true,
                    paging: false,
                    lengthChange: false,
                    ordering: false,
                    info: false,
                    autoWidth: false,
                    responsive: true,
                    select: false,
                    scrollX: false,
                });

                // Update pagination display
                if (response.pagination) {
                    $('#paginationSurvei').html(
                        'Menampilkan ' + (((response.pagination.page - 1) * response.pagination.limit) + 1) +
                        ' sampai ' + Math.min(response.pagination.page * response.pagination.limit, response.pagination.total) +
                        ' dari ' + response.pagination.total + ' data' +
                        '<br>' + buatPagination(response.pagination.page, response.pagination.total_pages)
                    );
                }
            } catch (e) {
                console.log('Error initializing table:', e);
                $('#loading').fadeOut('slow');
            }
        },
        error: function () {
            $('#loading').fadeOut('slow');
            alert('Koneksi bermasalah periksa internet');
            document.body.style.cursor = 'default';
        },
    });
}

function buatPagination(current, total) {
    let html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

    // Tombol Previous
    if (current > 1) {
        html += `<li class="page-item"><a class="page-link btnPage" data-page="${current-1}" href="#">Previous</a></li>`;
    } else {
        html += `<li class="page-item disabled"><span class="page-link">Previous</span></li>`;
    }

    // Halaman pertama
    if (current > 3) {
        html += `<li class="page-item"><a class="page-link btnPage" data-page="1" href="#">1</a></li>`;
        if (current > 4) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }

    // Range halaman sekitar current
    let start = Math.max(1, current - 2);
    let end = Math.min(total, current + 2);
    for (let i = start; i <= end; i++) {
        if (i === current) {
            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
        } else {
            html += `<li class="page-item"><a class="page-link btnPage" data-page="${i}" href="#">${i}</a></li>`;
        }
    }

    // Halaman terakhir
    if (current < total - 2) {
        if (current < total - 3) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        html += `<li class="page-item"><a class="page-link btnPage" data-page="${total}" href="#">${total}</a></li>`;
    }

    // Tombol Next
    if (current < total) {
        html += `<li class="page-item"><a class="page-link btnPage" data-page="${current+1}" href="#">Next</a></li>`;
    } else {
        html += `<li class="page-item disabled"><span class="page-link">Next</span></li>`;
    }

    html += '</ul></nav>';
    return html;
}

// PERBAIKAN UTAMA: Pastikan event handler pagination terpasang dengan benar
// Gunakan $(document).ready dan pastikan handler tidak dobel
$(document).ready(function() {
    // Remove existing handler dulu untuk mencegah dobel
    $(document).off('click', '.btnPage');
    
    // Pasang handler baru
    $(document).on('click', '.btnPage', function(e) {
        e.preventDefault();
        console.log('Pagination button clicked'); // Debug
        let page = $(this).data('page');
        console.log('Going to page:', page); // Debug
        if (page) {
            isiHasilSurvei(page);
        }
        return false;
    });
});

// Alternatif jika masih tidak jalan, coba ini:
// Pasang ulang event handler setiap selesai load data
function pasangEventPagination() {
    $(document).off('click', '.btnPage').on('click', '.btnPage', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        console.log('Pagination clicked, page:', page);
        isiHasilSurvei(page);
        return false;
    });
}

$('#cmdFilterHasil').on('click', function () {
	$.ajax({
		type: 'POST',
		url: 'aksi/filter/filter-data-survei.php',
		success: function (resp) {
			$('#isianModTambahDataLarge').html(resp);
			$('#isianModTambahDataLarge').fadeIn(1000);
			$('#modTambahDataLarge').modal({ backdrop: 'static', keyboard: false });
			$('#modTambahDataLarge').modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#cmdExportHasil').on('click', function () {
	var filterdata = $('#txtfilterdataSurvei').val();
	var ketkopexport = $('#txtketfilterexportSurvei').val();
	var idkecamatan = $('#txtfilteridkecamatanSurvei').val();
	var iddesa = $('#txtfilteriddesaSurvei').val();
	var iduniversitas = $('#txtfilteriduniversitasSurvei').val();
	var idfakultas = $('#txtfilteridfakultasSurvei').val();
	var umur = $('#txtfilterumurSurvei').val();
	var bentukpendidikan = $('#txtfilterbentukpendidikanSurvei').val();
	var kategori = $('#txtfilterkategorisurvei').val();
	window.open(
		'aksi/lap-excel/excel_data_hasil_survei.php?filterdata=' +
			filterdata +
			'&ketkopexport=' +
			ketkopexport +
			'&iduniversitas=' +
			iduniversitas +
			'&idfakultas=' +
			idfakultas +
			'&idkecamatan=' +
			idkecamatan +
			'&iddesa=' +
			iddesa +
			'&umur=' +
			umur +
			'&bentukpendidikan=' +
			bentukpendidikan +
			'&kategori=' +
			kategori,
		'_blank'
	);
});

$('#isitableHasilSurveyor').on('click', '.btnViewFoto', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: 'POST',
		url: 'aksi/hasil-survei/tampilkan-foto.php',
		data: { idsiswa: idsiswa, idsurveyor: idsurveyor },
		success: function (resp) {
			$('#isianModBebasData').html(resp);
			$('#isianModBebasData').fadeIn(1000);
			$('#modBebasData').modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

// $('#isitableHasilSurveyor').on('click', '.btnInputDesk', function () {
// 	var idsiswa = $(this).data('idsiswa');
// 	var idsurveyor = $(this).data('idsurveyor');
// 	var ketdesk = $(this).data('desk');
// 	$.ajax({
// 		type: "POST",
// 		url: "aksi/hasil-survei/tambah_data_desk.php",
// 		data: { idsiswa: idsiswa,idsurveyor: idsurveyor,ketdesk: ketdesk },
// 		success: function (resp) {
// 			$("#isianModEditDataLarge").html(resp);
// 			$("#isianModEditDataLarge").fadeIn(1000);
// 			$("#modEditDataLarge").modal({ backdrop: 'static', keyboard: false })
// 			$("#modEditDataLarge").modal('show');
// 		},
// 		error: function () { alert('Koneksi bermasalah periksa internet'); },
// 	});
// });

$('#isitableHasilSurveyor').on('click', '.btnEditSiswa', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: 'POST',
		url: 'aksi/hasil-survei/edit_siswa.php',
		data: { idsiswa: idsiswa, idsurveyor: idsurveyor },
		success: function (resp) {
			$('#isianModEditDataLarge').html(resp);
			$('#isianModEditDataLarge').fadeIn(1000);
			$('#modEditDataLarge').modal({ backdrop: 'static', keyboard: false });
			$('#modEditDataLarge').modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitableHasilSurveyor').on('click', '.btnSurvei', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: 'POST',
		url: 'aksi/hasil-survei/tambah_data_survei.php',
		data: { idsiswa: idsiswa, idsurveyor: idsurveyor },
		success: function (resp) {
			$('#isianModEditDataLarge').html(resp);
			$('#isianModEditDataLarge').fadeIn(1000);
			$('#modEditDataLarge').modal({ backdrop: 'static', keyboard: false });
			$('#modEditDataLarge').modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

$('#isitableHasilSurveyor').on('click', '.btnViewTimeline', function () {
	var idsiswa = $(this).data('idsiswa');
	var idsurveyor = $(this).data('idsurveyor');
	$.ajax({
		type: 'POST',
		url: 'aksi/hasil-survei/timeline-hasil-survei.php',
		data: { idsiswa: idsiswa, idsurveyor: idsurveyor },
		success: function (resp) {
			$('#isianModEditDataLarge').html(resp);
			$('#isianModEditDataLarge').fadeIn(1000);
			$('#modEditDataLarge').modal({ backdrop: 'static', keyboard: false });
			$('#modEditDataLarge').modal('show');
		},
		error: function () {
			alert('Koneksi bermasalah periksa internet');
		},
	});
});

