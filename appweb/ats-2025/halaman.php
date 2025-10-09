<?php
error_reporting(0);
session_start();

if ($_SESSION['AKSES'] == "administrator" or $_SESSION['AKSES'] == "operator dapodik") {
    $iduser = $_SESSION['IDOPERATOR'];
    $username = $_SESSION['USERNAME'];
    $nmoperator = $_SESSION['NMOPERATOR'];
    $akses = $_SESSION['AKSES'];
    $idinstansi = "1";
} else {
    header('location:../home.html');
}

require_once '../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "../services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tanggal = tgl_indo(date('Y-m-d'));
$tglserver = date('Y-m-d');

$tglpic = date('d-m-Y');
$tglpic2 = date('d-m-Y', strtotime('+1 days', strtotime($tglpic)));

$awalbulan = date('01-m-Y');
$jmlhari  = date('t');
$akhirbulan  = date('t-m-Y');

$tglpicindo = tgl_indo(date('Y-m-d'));
$tglpic2indo = tgl_indo(date('Y-m-d', strtotime('+1 days', strtotime($tglpic))));

$editor = $iduser;

$modulhalaman = trim($_GET['module']);
if ($modulhalaman == "dashboard") {
    $judulhalaman = "Dashboard ATS";
    $judullogo = "Dashboard";
} else if ($modulhalaman == "koordinator") {
    $judulhalaman = "Koordinator Surveyor";
    $judullogo = "Koordinator";
} else if ($modulhalaman == "surveyor") {
    $judulhalaman = "Data Surveyor";
    $judullogo = "Surveyor";
} else if ($modulhalaman == "universitas") {
    $judulhalaman = "Data Universitas";
    $judullogo = "Universitas";
} else if ($modulhalaman == "fakultas") {
    $judulhalaman = "Data Fakultas";
    $judullogo = "Fakultas";
} else if ($modulhalaman == "pengaturan-koordinator") {
    $judulhalaman = "Koordinator - Surveyor";
    $judullogo = "Atur Surveyor";
} else if ($modulhalaman == "pengaturan-surveyor") {
    $judulhalaman = "Surveyor - ATS";
    $judullogo = "Atur ATS";
} else if ($modulhalaman == "survei-ats") {
    $judulhalaman = "Survei ATS";
    $judullogo = "Survei ATS";
}

$qricbg = ("SELECT nm_instansi FROM m_instansi WHERE id_instansi='" . $idinstansi . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$nmcabang = ucwords(strtolower($c['nm_instansi']));
mysqli_free_result($dbcabang);

$qrioperator = ("SELECT nm_operator FROM m_operator WHERE id_operator='" . $iduser . "'");
$dboperator = mysqli_query($dbconn, $qrioperator);
$op = mysqli_fetch_assoc($dboperator);
$namaoperator = strtoupper($op['nm_operator']);
mysqli_free_result($dboperator);

?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="google" content="notranslate" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">

    <title>Administrator | <?php echo $judulhalaman; ?></title>

    <link href="favicon.png" rel="icon" />
    <link href="favicon.png" rel="apple-touch-icon" />
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../assets/js/config.js"></script>
    <script src="../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="../vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="../vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />

    <link href="../vendors/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

    <link rel="stylesheet" href="../vendors/datatables-select/css/select.bootstrap4.min.css">

    <link href="../vendors/choices/choices.min.css" rel="stylesheet" />
    <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.js"></script>

    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js" crossorigin="anonymous"></script>

    <style>
        .leaflet-control-container .leaflet-routing-container-hide {
            display: none;
        }
    </style>

    <style type="text/css">
        #loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(../assets/css/loading.gif) 50% 50% no-repeat #ede9df;
            background-color: #252525;
            opacity: 0.5;
            filter: alpha(opacity=50);
        }

        .pagination {
            padding-right: 10px;
        }

        .page-link {
            border: none;
            margin-top: 5px;
            padding-top: 5px;
            height: 32px;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }

        .paginate_button.active .page-link {
            background-color: black !important;
        }

        @media screen and (min-width: 676px) {
            .modal-detail-dialog {
                max-width: 1100px;
            }
        }
    </style>

</head>

<body style="-webkit-user-select:none;-moz-user-select:none;">

    <div id="loading"></div>

    <div style="display:none">

        <input type="text" id="lbltglserver" value="<?php echo $tglserver; ?>" readonly="readonly" />
        <input type="text" id="lblhalaman" value="<?php echo $modulhalaman; ?>" readonly="readonly" />
        <input type="text" id="lblnminstansi" value="<?php echo $nmcabang; ?>" readonly="readonly" />

        <input type="text" id="lbleditor" value="<?php echo $editor; ?>" readonly="readonly" />
        <input type="text" id="lblnamaeditor" value="<?php echo $namaoperator; ?>" readonly="readonly" />
        <input type="text" id="lblakses" value="<?php echo $akses; ?>" readonly="readonly" />
        <input type="text" id="lblidinstansi" value="<?php echo $idinstansi; ?>" readonly="readonly" />

        <input type="text" id="lblidlevel" value="1" readonly="readonly" />
        <input type="text" id="lblnamalevel" value="operator dapodik" readonly="readonly" />
        <input type="text" id="lblkettte" value="N" readonly="readonly" />

        <input type="text" id="txtketfilterdata" value="" readonly="readonly" />
        <input type="text" id="txtketfilter" value="" readonly="readonly" />
        <input type="text" id="txtfilteriduniversitas" value="" readonly="readonly" />
        <input type="text" id="txtfilteridfakultas" value="" readonly="readonly" />
        <input type="text" id="txtfilteridkecamatan" value="" readonly="readonly" />
        <input type="text" id="txtfilteriddesa" value="" readonly="readonly" />

        <input type="text" id="txtfilterdataSurvei" value="all" readonly="readonly" />
        <input type="text" id="txtketfilterexportSurvei" value="Semua Data Survei" readonly="readonly" />
        <input type="text" id="txtfilteridkecamatanSurvei" value="" readonly="readonly" />
        <input type="text" id="txtfilteriddesaSurvei" value="" readonly="readonly" />
        <input type="text" id="txtfilteriduniversitasSurvei" value="" readonly="readonly" />
        <input type="text" id="txtfilteridfakultasSurvei" value="" readonly="readonly" />
        <input type="text" id="txtfilterumurSurvei" value="" readonly="readonly" />
        <input type="text" id="txtfilterbentukpendidikanSurvei" value="" readonly="readonly" />

        <input type="text" id="txtfilterkategorisurvei" value="" readonly="readonly" />
    </div>

    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">
            <nav class="navbar navbar-light navbar-vertical navbar-expand-xl navbar-vibrant">
                <script>
                    var navbarStyle = localStorage.getItem("navbarStyle");
                    if (navbarStyle && navbarStyle !== 'transparent') {
                        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                    }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">
                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    </div>
                    <a class="navbar-brand" href="#">
                        <div class="d-flex align-items-center py-3"><span class="text-primary fs-2 fw-bold mb-0"><?php echo $judullogo; ?></span></div>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-2 mt-2" id="navbarVerticalNav">
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Dashboard</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="laporan-survei.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-bar"></span></span><span class="nav-link-text ps-1">Laporan Survei</span>
                                    </div>
                                </a>
                            </li>
                        </ul>

                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mb-2">
                                    <div class="col-auto navbar-vertical-label">Data Master</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="surveyor.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chalkboard-teacher"></span></span><span class="nav-link-text ps-1">
                                            Surveyor</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="koordinator.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-friends"></span></span><span class="nav-link-text ps-1">Koordinator</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="universitas.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-university"></span></span><span class="nav-link-text ps-1">Universitas</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="fakultas.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-random"></span></span><span class="nav-link-text ps-1">Fakultas</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">

                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Pengaturan
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="koordinator-surveyor.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-friends"></span></span><span class="nav-link-text ps-1">Koordinator - Surveyor</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="surveyor-ats.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chalkboard-teacher"></span></span><span class="nav-link-text ps-1">Surveyor - ATS</span>
                                    </div>
                                </a>
                            </li>

                        </ul>

                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mb-2">
                                    <div class="col-auto navbar-vertical-label">Survei ATS</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="survei-ats.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-map-signs"></span></span><span class="nav-link-text ps-1">
                                            Survei ATS</span>
                                        <span class="badge rounded-pill ms-2 bg-danger" id="lbljumlahsiswasurvei"></span>
                                    </div>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
            <div class="content">

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="home.html">
                        <div class="d-flex align-items-center"><span class="font-sans-serif"><?php echo $judullogo; ?></span>
                        </div>
                    </a>

                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

                        <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="../assets/img/team/avatar.png" alt="" />
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <a class="dropdown-item" href="logout.html">Halaman Administrator</a>
                                </div>
                            </div>
                        </li>
                    </ul>

                </nav>

                <?php
                include "area-dashboard.php";
                include "area-tabel-layanan.php";
                include "area-tabel-master.php";
                ?>

            </div>
            <!--content-->

        </div>
        <!--container-fluid-->

        <?php
        include "modal.php";
        ?>

    </main>

    <script src="../vendors/popper/popper.min.js"></script>
    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/anchorjs/anchor.min.js"></script>

    <script src="../vendors/fontawesome/all.min.js"></script>
    <script src="../vendors/lodash/lodash.min.js"></script>

    <script src="../vendors/jquery/jquery.min.js"></script>

    <script src="../vendors/jquery/socket.io-1.2.0.js"></script>

    <script src="../assets/lib/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
    <script src="../assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

    <script src="../vendors/datatables-select/js/dataTables.select.min.js"></script>

    <script src="../assets/js/flatpickr.js"></script>
    <script src="../vendors/choices/choices.min.js"></script>
    <script src="../assets/js/theme.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/hosuaby/Leaflet.SmoothMarkerBouncing@v2.0.0/dist/bundle.js" crossorigin="anonymous"></script>

    <script type="text/javascript" charset="utf-8">
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
    </script>

    <script src="dashboard.js"></script>
    <!-- <script src="halaman-atsnya.js"></script> -->
    <script src="master-data-ats.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            setTimeout(function() {
                document.body.style.cursor = "default";
                bersihkan();
                bersihkanFilter();
                isiJumlahLayanan();

                var halaman = $("#lblhalaman").val();
                if (halaman == "dashboard") {
                    bersihkan();
                    $("#area-dashboard").fadeIn();
                    hitungGrafikTotalSekolah();
                    isiGrafikStatus();
                    isiGrafikAkreditasi();
                    isiGrafikKelamin()
                    isiGafikUsia();
                } else if (halaman == "universitas") {
                    bersihkan();
                    isiMasterUniversitas();
                    $("#area-master-universitas").fadeIn();
                } else if (halaman == "fakultas") {
                    bersihkan();
                    isiMasterFakultas();
                    $("#area-master-fakultas").fadeIn();
                } else if (halaman == "koordinator") {
                    bersihkan();
                    isiMasterKoordinator();
                    $("#area-master-koordinator").fadeIn();
                } else if (halaman == "surveyor") {
                    bersihkan();
                    isiMasterSurveyor();
                    $("#area-master-surveyor").fadeIn();
                } else if (halaman == "pengaturan-koordinator") {
                    bersihkan();
                    isiKoordinatorSurveyor();
                    $("#area-koordinator-surveyor").fadeIn();
                } else if (halaman == "pengaturan-surveyor") {
                    bersihkan();
                    //isiSurveyorATS();
                    $("#area-surveyor-ats").fadeIn();
                } else if (halaman == "survei-ats") {
                    bersihkan();
                    bersihkanFilter();
                    $("#txtfilterdataSurvei").val("all");
                    isiHasilSurvei();
                    $("#area-survei-ats").fadeIn();
                }
                $("#loading").fadeOut("slow");
            }, 1000);
        });
    </script>

</body>

</html>