<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
include "../../../services/tgl_indo.php";

$filterinfo = trim($_POST['filterinfo']);

if ($filterinfo == "semua"){
	$sqlx = ("SELECT id_pengumuman,judul,headline,isi_pengumuman,hari,tanggal,jam FROM pengumuman
	ORDER BY id_pengumuman DESC");
} else if ($filterinfo == "Y"){
	$sqlx = ("SELECT id_pengumuman,judul,headline,isi_pengumuman,hari,tanggal,jam FROM pengumuman
	WHERE aktif='Y' ORDER BY id_pengumuman DESC");
} else if ($filterinfo == "N"){
	$sqlx = ("SELECT id_pengumuman,judul,headline,isi_pengumuman,hari,tanggal,jam FROM pengumuman
	WHERE aktif='N' ORDER BY id_pengumuman DESC");
}

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$isipengumuman = strip_tags($t['isi_pengumuman']); 
	$isi = substr($isipengumuman,0,150); 
	$isi = substr($isipengumuman,0,strrpos($isi," ")); 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idpengumuman']=$t['id_pengumuman'];
	$row_array['judul']=ucwords(strtolower($t['judul']));
	$row_array['headline']=$t['headline'];
	$row_array['hari']=$t['hari'];
	$row_array['tanggal']=tgl_indo($t['tanggal']);
	$row_array['jam']=$t['jam'];
	$row_array['isipengumuman']=$isi;	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
