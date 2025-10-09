<?php
error_reporting(0);
include '../../services/config.php';
include '../../services/tgl_indo.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$tglawal = trim($_POST['tglawal']);
$tglakhir = trim($_POST['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$tglawalindo = tgl_indo($tglawal);
$tglakhirindo = tgl_indo($tglakhir);


$data = array();
$sqlcount = ("SELECT SUM(beranda) AS jumBeranda,SUM(informasi) AS jumInformasi,SUM(sarpras) AS jumSarpras,SUM(spm) AS jumSPM,
		SUM(podcast) AS jumPodcast,SUM(pengaduan) AS jumPengaduan,SUM(kegiatan_sekolah) AS jumKegiatan,SUM(total) AS jumTotal
 		FROM kunjungan WHERE tanggal >= '".$tglawal."' AND tanggal <= '".$tglakhir."'");
	$resultcount = mysqli_query($dbconn, $sqlcount);
	$s = mysqli_fetch_assoc($resultcount);

	$row_array = array();

	$row_array['jumBeranda'] = $s['jumBeranda'];
	$row_array['jumInformasi'] = $s['jumInformasi'];
	$row_array['jumSarpras'] = $s['jumSarpras'];
	$row_array['jumSPM'] = $s['jumSPM'];
	$row_array['jumPodcast'] = $s['jumPodcast'];
	$row_array['jumPengaduan'] = $s['jumPengaduan'];
	$row_array['jumKegiatan'] = $s['jumKegiatan'];
	$row_array['jumTotal'] = $s['jumTotal'];

	$row_array['tglawalindo']= $tglawalindo;
	$row_array['tglakhirindo']= $tglakhirindo;
	array_push($data, $row_array);

echo json_encode($data);
$resultcount->close();
$dbconn->close();
