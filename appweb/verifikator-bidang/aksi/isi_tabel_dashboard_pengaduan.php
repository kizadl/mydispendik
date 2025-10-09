<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
include "../../services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');

$idbidang=trim($_POST['idbidang']);
$tglawal =trim($_POST['tglawal']);
$tglakhir = trim($_POST['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$sqlx = ("SELECT id_pengaduan,nik,nm_pengadu,alamat,no_telepon,uraian_masalah,tanggal,jam,stts_pengaduan 
	FROM pengaduan WHERE tanggal >= '".$tglawal."' AND tanggal <= '".$tglakhir."' ORDER BY id_pengaduan DESC");

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$uraianmasalah = strip_tags($t['uraian_masalah']); 
	$isi = substr($uraianmasalah,0,150); 
	$isi = substr($uraianmasalah,0,strrpos($isi," ")); 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idpengaduan']=$t['id_pengaduan'];
	$row_array['nmpengadu']=$t['nm_pengadu'];
	$row_array['nik']=$t['nik'];
	$row_array['alamat']=$t['alamat'];
	
	$row_array['notelepon']=$t['no_telepon'];
	$row_array['tanggal']=tgl_indo($t['tanggal']);
	$row_array['jam']=$t['jam'];
	$row_array['uraianmasalah']=$isi;	

	$row_array['sttspengaduan']=strtoupper($t['stts_pengaduan']);

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
