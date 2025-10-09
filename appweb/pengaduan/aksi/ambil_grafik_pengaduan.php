<?php
error_reporting(0);
include '../../services/config.php';
include '../../services/tgl_indo.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$tglawal =trim($_POST['tglawal']);
$tglakhir = trim($_POST['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$tglawalindo = tgl_indo($tglawal);
$tglakhirindo = tgl_indo($tglakhir);

$sqlx = ("SELECT DISTINCT id_bidang,nm_bidang FROM m_bidang");
$resultx = mysqli_query($dbconn, $sqlx);
$data = array();
$totalbelum = 0;$totaldistribusi = 0;$totaltindaklanjut = 0;$totalselesai = 0;
$jmltotal = 0;
while ($t = mysqli_fetch_array($resultx)) {

	$sqlcount = ("SELECT COUNT(IF(stts_pengaduan='belum',0,null)) AS jumBlm, COUNT(IF(stts_pengaduan='distribusi',0,null)) AS jumDistribusi, COUNT(IF(stts_pengaduan='jawaban',0,null)) AS jumTindaklanjut
			, COUNT(IF(stts_pengaduan='selesai',0,null)) AS jumSelesai
			FROM pengaduan WHERE id_bidang = '" . $t['id_bidang'] . "' AND tanggal >= '".$tglawal."' AND tanggal <= '".$tglakhir."'");
	$resultcount = mysqli_query($dbconn, $sqlcount);
	$s = mysqli_fetch_assoc($resultcount);

	$totalbelum = $totalbelum + $s['jumBlm'];
	$totaldistribusi = $totaldistribusi + $s['jumDistribusi'];
	$totaltindaklanjut = $totaltindaklanjut + $s['jumTindaklanjut'];
	$totalselesai = $totalselesai + $s['jumSelesai'];

	$jmltotal = $jmltotal + $s['jumBlm'] + $s['jumDistribusi'] + $s['jumTindaklanjut'] + $s['jumSelesai'];
	if ( $totalbelum == 0 OR $totalbelum==NULL){
		$persenbelum =  0;
	} else {
		$persenbelum =  ($totalbelum / $jmltotal) * 100;
	}
	if ( $totaldistribusi == 0 OR $totaldistribusi==NULL){
		$persendistribusi =  0;
	} else {
		$persendistribusi =  ($totaldistribusi / $jmltotal) * 100;
	}
	if ( $totaltindaklanjut == 0 OR $totaltindaklanjut==NULL){
		$persentindaklanjut =  0;
	} else {
		$persentindaklanjut =  ($totaltindaklanjut / $jmltotal) * 100;
	}
	if ( $totalselesai == 0 OR $totalselesai==NULL){
		$persenselesai =  0;
	} else {
		$persenselesai =  ($totalselesai / $jmltotal) * 100;
	}

	$row_array = array();
	$row_array['nmbidang'] = $t['nm_bidang'];
	$row_array['jumBlm'] = $s['jumBlm'];
	$row_array['jumDistribusi'] = $s['jumDistribusi'];
	$row_array['jumTindaklanjut'] = $s['jumTindaklanjut'];
	$row_array['jumSelesai'] = $s['jumSelesai'];

	$row_array['totalbelum'] = $totalbelum;
	$row_array['totaldistribusi'] = $totaldistribusi;
	$row_array['totaltindaklanjut'] = $totaltindaklanjut;
	$row_array['totalselesai'] = $totalselesai;

	$row_array['persenbelum'] = $persenbelum;
	$row_array['persendistribusi'] = $persendistribusi;
	$row_array['persentindaklanjut'] = $persentindaklanjut;
	$row_array['persenselesai'] = $persenselesai;

	$row_array['tglawalindo']= $tglawalindo;
	$row_array['tglakhirindo']= $tglakhirindo;
	array_push($data, $row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
