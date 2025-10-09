<?php
error_reporting(0);
session_start();

if ($_SESSION['AKSES'] == "administrator") {
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
$tglserver = date('Y-m-d');

$editor = $iduser;

$qriup = ("SELECT server_url FROM set_server WHERE id_server='1'");
$dbupload = mysqli_query($dbconn, $qriup);
$b = mysqli_fetch_assoc($dbupload);
$serverurl = $b['server_url'];
mysqli_free_result($dbupload);

$qricbg = ("SELECT nm_instansi,kota FROM m_instansi WHERE id_instansi='" . $idinstansi . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$nmcabang = ucwords(strtolower($c['nm_instansi']));
$nmkotains = ucwords(strtolower($c['kota']));
mysqli_free_result($dbcabang);
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

    <title>My Dispendik | LPPD</title>

    <link href="favicon.png" rel="icon" />
    <link href="favicon.png" rel="apple-touch-icon" />
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../assets/js/config.js"></script>
    <script src="../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

    <link href="../vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

    <link href="../vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendors/select2/css/select2.min.css">

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
            opacity: 0.7;
            filter: alpha(opacity=70);
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
        <input type="text" id="lblhalaman" value="" readonly="readonly" />
        <input type="text" id="lblnminstansi" value="<?php echo $nmcabang; ?>" readonly="readonly" />

        <input type="text" id="lbleditor" value="<?php echo $editor; ?>" readonly="readonly" />
        <input type="text" id="lblakses" value="<?php echo $akses; ?>" readonly="readonly" />
        <input type="text" id="lblidinstansi" value="<?php echo $idinstansi; ?>" readonly="readonly" />

        <input type="text" id="lblkodekabupaten-datamart" value="052400" readonly="readonly" />

        <input type="text" id="lbllatitude" value="" readonly="readonly" />
        <input type="text" id="lbllongitude" value="" readonly="readonly" />

        <input type="text" id="txttransid" value="" readonly="readonly" />
        <input type="text" id="txttransketerangan" value="" readonly="readonly" />
        <input type="text" id="txttransnmwilayah" value="" readonly="readonly" />

        <input type="text" id="txttransiddetailsekolah" value="" readonly="readonly" />
        <input type="text" id="txttransketkurikulum" value="" readonly="readonly" />
    </div>

    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">

            <div class="content">

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">
                        <div class="col-sm-auto d-flex align-items-center"><img class="ms-n2" src="../assets/img/illustrations/crm-bar-chart.png" alt="" width="90" />
                            <div>
                                <h4 class="text-primary fw-bold mb-0">LPPD <span class="text-info fw-medium">DISPENDIK KABUPATEN JEMBER</span></h4>
                            </div><img class="ms-n4 d-md-none d-lg-block" src="../assets/img/illustrations/crm-line-chart.png" alt="" width="150" />
                        </div>

                    </ul>

                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <div class="col-auto text-center pe-card">
                            <select class="form-select form-select-sm mb-3" id="cbokecamatanspm" style="width:200px;">
                                <option value="all">Kabupaten Jember</option>
                                <?php
                                $menuutama = mysqli_query($dbconn, "SELECT DISTINCT id_kecamatan,kecamatan FROM spm_sekolah GROUP BY id_kecamatan ASC");
                                while ($dm = mysqli_fetch_array($menuutama)) {
                                    $idkec = $dm['id_kecamatan'];
                                    $nmkecamatan = $dm['kecamatan'];
                                    echo "<option value='$idkec'>$nmkecamatan</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-auto text-center pe-card">
                            <select class="form-select form-select-sm mb-3" id="cbodesaspm" style="width:200px;">
                            </select>
                        </div>
                        <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="../assets/img/team/avatar.png" alt="" />
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <a class="dropdown-item" href="logout.html">Menu Administrator</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div id="area-halaman-utama">

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Angka Partisipasi berdasarkan Usia <span class="lblkopgrafik1"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentPartisipasi" data-echart-responsive="true">
                                        <canvas id="hitungChartPartisipasi" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Guru Bersertifikasi <span class="lblkopgrafik1"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentSertifikasi" data-echart-responsive="true">
                                        <canvas id="hitungChartSertifikasi" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Jumlah Tenaga Kependidikan <span id="lblkopgrafik2"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartTenagaKependidikan" data-echart-responsive="true">
                                        <canvas id="hitungTenagaKependidikan" height="250px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">

                                    <div class="row align-items-center g-0">
                                        <div class="col light">
                                            <p class="fs--1 fw-semi-bold">Grafik Jumlah Sekolah <span class="lblkopgrafik1"></span></p>
                                        </div>
                                    </div>

                                    <div class="chart h-100" id="hitungUmurChart" data-echart-responsive="true">
                                        <canvas id="umurChart" height="250px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Status Sekolah <span id="lblkopgrafik2"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentADMIN" data-echart-responsive="true">
                                        <canvas id="hitungChartADMIN" height="250px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-header d-flex flex-between-center bg-light py-2">
                                    <h6 class="mb-0">Analisa Kebutuhan Guru Sekolah Dasar (SD) <span class="lblkopgrafik1"></span></h6>
                                </div>
                                <div class="card-body text-white pb-0 position-relative">

                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Jumlah Kebutuhan Minimal Guru Sekolah Dasar</p>
                                    </div>
                                    <div class="chart" id="hitungChartKebutuhanSD">
                                        <canvas id="hitungKebutuhanSD" height="300px"></canvas>
                                    </div>

                                    <div class="table-responsive scrollbar mx-ncard mt-3">
                                        <table class="table fs--1 mb-0">
                                            <thead class="bg-200 text-800">
                                                <tr>
                                                    <th class="text-left">K-13</th>
                                                    <th class="text-left">K-MB</th>
                                                    <th class="text-left">Rombel</th>
                                                    <th class="text-left">Guru</th>
                                                    <th class="text-left">Ideal Guru</th>
                                                    <th class="text-left">Kurang / Lebih</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list bg-light">
                                                <tr>
                                                    <td width="17%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotk13"></span></td>
                                                    <td width="17%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotkmb"></span></td>
                                                    <td width="16%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotrombel"></span></td>
                                                    <td width="16%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotguru"></span></td>
                                                    <td width="17%" class="align-middle fw-semi-bold text-primary"><span id="txtjumtotidealguru"></span></td>
                                                    <td width="17%" class="align-middle fw-semi-bold text-danger"><span id="txtjumtotkurangguru"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-header d-flex flex-between-center bg-light py-2">
                                    <h6 class="mb-0">Analisa Kebutuhan Guru Sekolah Menengah Pertama (SMP) <span class="lblkopgrafik1"></span></h6>
                                </div>
                                <div class="card-body text-white pb-0 position-relative">

                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Jumlah Kebutuhan Minimal Guru Sekolah Menengah Pertama</p>
                                    </div>
                                    <div class="chart" id="hitungChartKebutuhanSMP">
                                        <canvas id="hitungKebutuhanSMP" height="300px"></canvas>
                                    </div>

                                    <div class="table-responsive scrollbar mx-ncard mt-3">
                                        <table class="table fs--1 mb-0">
                                            <thead class="bg-200 text-800">
                                                <tr>
                                                    <th class="text-left">K-13</th>
                                                    <th class="text-left">K-MB</th>
                                                    <th class="text-left">Rombel</th>
                                                    <th class="text-left">Guru</th>
                                                    <th class="text-left">Ideal Guru</th>
                                                    <th class="text-left">Kurang / Lebih</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list bg-light">
                                                <tr>
                                                    <td width="17%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotk13smp"></span></td>
                                                    <td width="17%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotkmbsmp"></span></td>
                                                    <td width="16%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotrombelsmp"></span></td>
                                                    <td width="16%" class="align-middle fw-semi-bold sessions"><span id="txtjumtotgurusmp"></span></td>
                                                    <td width="17%" class="align-middle fw-semi-bold text-primary"><span id="txtjumtotidealgurusmp"></span></td>
                                                    <td width="17%" class="align-middle fw-semi-bold text-danger"><span id="txtjumtotkuranggurusmp"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-6 px-xxl-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Status Akreditasi Sekolah <span id="lblkopgrafik4"></span></p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentAkreditasi" data-echart-responsive="true">
                                        <canvas id="hitungChartAkreditasi" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--halaman sekolah-->
                <div id="area-halaman-sekolah" style="display:none;">

                    <!----------------- DETAIL SEKOLAH ---------------->
                    <div id="hal-detail-sekolah"></div>

                </div><!--halaman sekolah-->

            </div><!--content-->


        </div><!--container-->
    </main>

    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/anchorjs/anchor.min.js"></script>

    <script src="../vendors/fontawesome/all.min.js"></script>
    <script src="../vendors/lodash/lodash.min.js"></script>

    <script src="../vendors/jquery/jquery.min.js"></script>

    <script src="../assets/lib/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
    <script src="../assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

    <script src="../assets/js/theme.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <script src="dashboard.js"></script>
    <script src="master.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            setTimeout(function() {
                document.body.style.cursor = "default";
                bersihkan();

                $("#area-halaman-sekolah").fadeOut("slow");
                $("#area-halaman-utama").fadeIn();

                $("#txttransketerangan").val("kota");
                var nmwilayah = "Kabupaten Jember";
                $(".lblkopgrafik1").text(nmwilayah);
                $("#lblkopgrafik2").text(nmwilayah);
                $("#lblkopgrafik3").text(nmwilayah);
                $("#lblkopgrafik4").text(nmwilayah);

                hitungGrafikTotalSekolah();
                isiGrafikStatus();

                hitungGrafikKebutuhanGuruSD();
                hitungGrafikKebutuhanGuruSMP();

                isiGrafikAkreditasi();
                isiGafikUsia();
                isiGrafikSertifikasi();
                isiGrafikTenagaKependidikan();

                $("#lblhalaman").val("dashboard");
                $("#loading").fadeOut("slow");
            }, 1000);

        });
    </script>

</body>

</html>