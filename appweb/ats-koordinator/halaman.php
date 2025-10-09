<?php
error_reporting(0);
session_start();

if ($_SESSION['IDKOORDINATOR'] != "" or $_SESSION['IDUNIVERSITAS'] != "" or $_SESSION['IDFAKULTAS'] != "") {
    $idkoordinator = $_SESSION['IDKOORDINATOR'];
    $username = $_SESSION['USERNAME'];
    $nmkoordinator = $_SESSION['NMKOORDINATOR'];
    $iduniversitas = $_SESSION['IDUNIVERSITAS'];
    $idfakultas = $_SESSION['IDFAKULTAS'];
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

$qricbg = ("SELECT nm_universitas FROM ats_universitas WHERE id_universitas='" . $iduniversitas . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$nmcabang = ucwords(strtolower($c['nm_universitas']));
mysqli_free_result($dbcabang);

$qricbg2 = ("SELECT nm_fakultas FROM ats_fakultas WHERE id_fakultas='" . $idfakultas . "'");
$dbcabang2 = mysqli_query($dbconn, $qricbg2);
$fak = mysqli_fetch_assoc($dbcabang2);
$nmfakultas = ucwords(strtolower($fak['nm_fakultas']));
mysqli_free_result($dbcabang2);

$qrisrv = ("SELECT server_url,server_node,qr_url FROM set_server WHERE id_server='1'");
$dbsrv = mysqli_query($dbconn, $qrisrv);
$b = mysqli_fetch_assoc($dbsrv);
$ipserver = $b['server_url'] . "operator/";
$ipservernode = $b['server_node'];
$QRCodeUrl = $b['qr_url'];
mysqli_free_result($dbsrv);
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

    <title>Koordinator | <?php echo $judulhalaman; ?></title>

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

        <input type="text" id="lbleditor" value="<?php echo $idkoordinator; ?>" readonly="readonly" />
        <input type="text" id="lblnamaeditor" value="<?php echo $nmkoordinator; ?>" readonly="readonly" />
        <input type="text" id="lbliduniversitas" value="<?php echo $iduniversitas; ?>" readonly="readonly" />
        <input type="text" id="lblidfakultas" value="<?php echo $idfakultas; ?>" readonly="readonly" />

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
                                        <span class="badge rounded-pill ms-2 bg-danger" id="lbljummutasisiswa"></span>
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
                                    <a class="dropdown-item" href="logout.html">Sign Out</a>
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

    <script src="dashboard.js"></script>
    <script src="halaman.js"></script>
    <script src="master-ats.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            setTimeout(function() {
                document.body.style.cursor = "default";
                bersihkan();
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
                    isiSurveyorATS();
                    $("#area-surveyor-ats").fadeIn();
                } else if (halaman == "survei-ats") {
                    bersihkan();
                    isiHasilSurvei();
                    $("#area-survei-ats").fadeIn();
                }
                $("#loading").fadeOut("slow");
            }, 1000);
        });


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
                isiJumlahLayanan();
                isiNotifikasiStatus();
                if (halaman == "mutasisiswa") {
                    isiMutasiSiswa();
                }
            });

        });
    </script>

</body>

</html>