<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
include "../../services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');

$tglawal =trim($_POST['tglawal']);
$tglakhir = trim($_POST['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$sqlx = ("SELECT * FROM kunjungan WHERE tanggal >= '".$tglawal."' AND tanggal <= '".$tglakhir."' ORDER BY tanggal DESC");

$result = mysqli_query($dbconn,$sqlx);
$data = array();

while($t=mysqli_fetch_array($result)){
 	
	$row_array = array();

	$row_array['tanggal']=tgl_indo($t['tanggal']);
	$row_array['beranda']=$t['beranda'];
	$row_array['informasi']=$t['informasi'];
	$row_array['sarpras']=$t['sarpras'];
	$row_array['spm']=$t['spm'];
	$row_array['podcast']=$t['podcast'];
	$row_array['pengaduan']=$t['pengaduan'];
	$row_array['kegiatan']=$t['kegiatan_sekolah'];
	$row_array['total']=$t['total'];
	

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
