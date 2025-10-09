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
    $judulhalaman = "Dashboard";
    $judullogo = "Dashboard";
} else if ($modulhalaman == "gajiberkala") {
    $judulhalaman = "Gaji Berkala";
    $judullogo = "Berkala";
} else if ($modulhalaman == "persyaratan") {
    $judulhalaman = "Persyaratan";
    $judullogo = "Prasyarat";
} else if ($modulhalaman == "layanan") {
    $judulhalaman = "Layanan";
    $judullogo = "Layanan";
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

$qrisrv = ("SELECT server_url,server_node,qr_url FROM set_server WHERE id_server='1'");
$dbsrv = mysqli_query($dbconn, $qrisrv);
$b = mysqli_fetch_assoc($dbsrv);
$ipserver = $b['server_url'] . "operator/";
$ipservernode = $b['server_node'];
$QRCodeUrl = $b['qr_url'];
mysqli_free_result($dbsrv);
mysqli_close($dbconn);
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

    <title>Klinik Dapo | <?php echo $judulhalaman; ?></title>

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

    <link href="../vendors/glightbox/glightbox.min.css" rel="stylesheet" />
    <link href="../vendors/plyr/plyr.css" rel="stylesheet" />
    <link href="../vendors/dropzone/dropzone.min.css" rel="stylesheet">

    <link href="../vendors/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

    <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">

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

        <input type="text" id="lblURLserver" value="<?php echo $ipserver; ?>" readonly="readonly" />
        <input type="text" id="lblURLserverNode" value="<?php echo $ipservernode; ?>" readonly="readonly" />
        <input type="text" id="lblQRURL" value="<?php echo $QRCodeUrl; ?>" readonly="readonly" />
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

        <input type="text" id="txtidlayananONFocus" value="" readonly="readonly" />
        <input type="text" id="txtindikatorbukapesan" value="OFF" readonly="readonly" />
        <input type="text" id="txtidsuratbukapesan" value="" readonly="readonly" />
        
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
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0"><?php echo $judullogo; ?></span></div>
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
                                <a class="nav-link" href="permohonan-kenaikan-gaji-berkala.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-business-time"></span></span><span class="nav-link-text ps-1">
                                            Gaji Berkala</span>
                                        <span class="badge rounded-pill ms-2 bg-danger" id="lbljummutasisiswa"></span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Pengaturan Tte
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="bidang.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-signature"></span></span><span class="nav-link-text ps-1">Kepala Dinas</span>
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
                                <a class="nav-link" href="layanan.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-braille"></span></span><span class="nav-link-text ps-1">
                                            Layanan</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="persyaratan.html" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-layer-group"></span></span><span class="nav-link-text ps-1">
                                            Persyaratan</span>
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

                        <li class="nav-item dropdown">
                            <a class="nav-link notification-indicator notification-indicator-info notification-indicator-fill px-0 fa-icon-wait" id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-comment-alt" data-fa-transform="shrink-7" style="font-size: 33px;"></span><span class="notification-indicator-number lbljumnotifpesan">0</span></a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg" aria-labelledby="navbarDropdownNotification">
                                <div class="card card-notification shadow-none">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h6 class="card-header-title mb-0">Pesan Belum Dibaca</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scrollbar-overlay" style="max-height:19rem">
                                        <div class="list-group list-group-flush fw-normal fs--1" id="area-notifikasi-pesan">
                                        </div>
                                    </div>
                                    <div class="card-footer text-center border-top"><a class="card-link d-block cmdHapusNotifikasiPesan" href="#!"></a></div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link notification-indicator notification-indicator-danger notification-indicator-fill px-0 fa-icon-wait" id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-envelope" data-fa-transform="shrink-7" style="font-size: 33px;"></span><span class="notification-indicator-number lbljumnotifstatus">0</span></a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg" aria-labelledby="navbarDropdownNotification">
                                <div class="card card-notification shadow-none">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h6 class="card-header-title mb-0">Pembaharuan Status Surat</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scrollbar-overlay" style="max-height:19rem">
                                        <div class="list-group list-group-flush fw-normal fs--1" id="area-notifikasi-status">
                                        </div>
                                    </div>
                                    <div class="card-footer text-center border-top"><a class="card-link d-block cmdHapusNotifikasiStatus" href="#!"></a></div>
                                </div>
                            </div>
                        </li>

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
                include "area-tabel-gaji-berkala.php";
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

    <!--script src="../vendors/jquery/socket.io-1.2.0.js"></!--script-->

    <script src="../assets/lib/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
    <script src="../assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

    <script src="../vendors/glightbox/glightbox.min.js"></script>
    <script src="../vendors/plyr/plyr.polyfilled.min.js"></script>
    <script src="../vendors/dropzone/dropzone.min.js"></script>

    <script src="../assets/js/flatpickr.js"></script>

    <script src="../vendors/glightbox/glightbox.min.js"></script>
    <!--script src="../vendors/plyr/plyr.polyfilled.min.js"></!--script-->
    <script src="../vendors/dropzone/dropzone.min.js"></script>

    <script src="../assets/js/theme.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <script src="notifikasi.js"></script>
    <script src="dashboard-gaji-berkala-dapo.js"></script>
    <script src="gaji-berkala.js"></script>
    <script src="master.js"></script>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.20.0/firebase-app.js";
        import {
            getAnalytics
        } from "https://www.gstatic.com/firebasejs/9.20.0/firebase-analytics.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCw_2T8xupQmXezDt2YetXhUev4MmdcLVE",
            authDomain: "ptsp-3899e.firebaseapp.com",
            projectId: "ptsp-3899e",
            storageBucket: "ptsp-3899e.appspot.com",
            messagingSenderId: "179497319630",
            appId: "1:179497319630:web:bf64e8248591d4dbeea49f",
            measurementId: "G-QB90G2P7G6"
        };

        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
    </script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            setTimeout(function() {
                document.body.style.cursor = "default";
 
                isiNotifikasiPesan();
                isiNotifikasiStatus();
               // isiJumlahLayananDapo();

                var halaman = $("#lblhalaman").val();
                if (halaman == "dashboard") {
                    bersihkan();
                    $("#area-dashboard").fadeIn();
                } else if (halaman == "gajiberkala") {
                    bersihkan();
                    //siMutasiSiswa();
                    $("#area-mutasi-siswa").fadeIn();
                    $("#txtidlayananONFocus").val("1");
                } else if (halaman == "persyaratan") {
                    bersihkan();
                    isiMasterLayanan();
                    $("#area-master-layanan").fadeIn();
                } else if (halaman == "layanan") {
                    bersihkan();
                    isiMasterLayanan();
                    $("#area-master-layanan").fadeIn();
                }
                $("#loading").fadeOut("slow");
            }, 1000);
        });

/*
        var urlservernode = $('#lblURLserverNode').val();
        var socket_connect = function(room) {
            return io(urlservernode, {
                query: 'r_var=' + room
            });
        }

        var idlog = $('#lblnamalevel').val();
        var socket = socket_connect(idlog);

        $(function() {


            socket.on('terima pesan from operator dapodik', function(msg) {
                alert(msg)
            });

            var halaman = $("#lblhalaman").val();

            socket.on('terima mutasi siswa', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "mutasisiswa") {
                    isiMutasiSiswa();
                } 
            });

            socket.on('terima mutasi pendidik', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "mutasitenagapendidik") {
                    isiMutasiPendidik();
                } 
            });

            socket.on('terima pdb mi', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "verifikasipdbmi") {
                    isiPDBMI();
                } 
            });

            socket.on('terima pengajuan akun', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "akunoperator") {
                    isiPengajuanAkun();
                } 
            });

            socket.on('terima pengajuan npsn', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "pengajuannpsn") {
                    isiPengajuanNPSN();
                } 
            });

            socket.on('terima pengajuan npyp', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "pengajuannpyp") {
                    isiPengajuanNPYP();
                } 
            });

            socket.on('terima perubahan ptk', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "perubahanptk") {
                    isiPerubahanJenisPTK();
                } 
            });

            socket.on('terima pergantian kepsek', function(msg) {
                isiJumlahLayananDapo();
                isiNotifikasiStatus();
                if (halaman == "pergantiankepsek") {
                    isiPergantianKepsek();
                } 
            });

            socket.on('kirim level 3', function(msg) {
                isiLayananSurat();
                isiNotifikasiStatus();
            });
            socket.on('kirim level 4', function(msg) {
                isiLayananSurat();
                isiNotifikasiStatus();
            });
            socket.on('kirim level 5', function(msg) {
                isiLayananSurat();
                isiNotifikasiStatus();
            });
            socket.on('status akhir', function(msg) {
                isiLayananSurat();
                isiNotifikasiStatus();
            });

            ////// emit pesan /////
            socket.on('pesan level 2', function(msg) {
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel2();
                }
            });

            socket.on('pesan level 3', function(msg) {
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel3();
                }
            });

            socket.on('pesan level 4', function(msg) {
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel4();
                }
            });

            socket.on('pesan level 5', function(msg) {
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel5();
                }
            });

            ////// pesan from verifikator /////
            socket.on('pesan from level 2', function(msg) {
                isiNotifikasiPesan();
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel2();
                }
            });

            socket.on('pesan from level 3', function(msg) {
                isiNotifikasiPesan();
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel3();
                }
            });

            socket.on('pesan from level 4', function(msg) {
                isiNotifikasiPesan();
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel4();
                }
            });

            socket.on('pesan from level 5', function(msg) {
                isiNotifikasiPesan();
                var indikatorbukapesan = $("#txtindikatorbukapesan").val();
                var idsuratpesan = $("#txtidsuratbukapesan").val();
                var idsuratON = $("#txttransidsuratPs").val();
                if (indikatorbukapesan == "ON" && idsuratpesan == idsuratON) {
                    ambilJumlahPesan();
                    isiPesanLevel5();
                }
            });
        });
        */
    </script>

</body>

</html>