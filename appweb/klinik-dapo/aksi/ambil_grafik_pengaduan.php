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

$sqlx = ("SELECT DISTINCT bentuk_pendidikan FROM trans_pengaduan_dapodik");
$resultx = mysqli_query($dbconn, $sqlx);
$data = array();
$totalbelum = 0;$totaldistribusi = 0;$totaltindaklanjut = 0;$totalselesai = 0;
$jmltotal = 0;
while ($t = mysqli_fetch_array($resultx)) {

	$sqlcount = ("SELECT COUNT(IF(ket_status_akhir='belum',0,null)) AS jumBlm, COUNT(IF(ket_status_akhir='tolak',0,null)) AS jumDistribusi, COUNT(IF(ket_status_akhir='terima',0,null)) AS jumTindaklanjut
			, COUNT(IF(aktif='N' AND ket_status_akhir='terima',0,null)) AS jumSelesai
			FROM trans_pengaduan_dapodik WHERE bentuk_pendidikan = '" . $t['bentuk_pendidikan'] . "' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
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
		$persenbelum = number_format($persenbelum, 2);
	}
	if ( $totaldistribusi == 0 OR $totaldistribusi==NULL){
		$persendistribusi =  0;
	} else {
		$persendistribusi =  ($totaldistribusi / $jmltotal) * 100;
		$persendistribusi = number_format($persendistribusi, 2);
	}
	if ( $totaltindaklanjut == 0 OR $totaltindaklanjut==NULL){
		$persentindaklanjut =  0;
	} else {
		$persentindaklanjut =  ($totaltindaklanjut / $jmltotal) * 100;
		$persentindaklanjut = number_format($persentindaklanjut, 2);
	}
	if ( $totalselesai == 0 OR $totalselesai==NULL){
		$persenselesai =  0;
	} else {
		$persenselesai =  ($totalselesai / $jmltotal) * 100;
		$persenselesai = number_format($persenselesai, 2);
	}

	$row_array = array();
	$row_array['nmbidang'] = strtoupper($t['bentuk_pendidikan']?? "-");
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
