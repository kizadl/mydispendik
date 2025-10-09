<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
include "../../../services/tgl_indo.php";

$filterinfo = trim($_POST['filterinfo']);

if ($filterinfo == "semua"){
	$sqlx = ("SELECT id_podcast,judul,headline,isi_podcast,link_youtube,hari,tanggal,jam FROM podcast
	ORDER BY id_podcast DESC");
} else if ($filterinfo == "Y"){
	$sqlx = ("SELECT id_podcast,judul,headline,isi_podcast,link_youtube,hari,tanggal,jam FROM podcast
	WHERE aktif='Y' ORDER BY id_podcast DESC");
} else if ($filterinfo == "N"){
	$sqlx = ("SELECT id_podcast,judul,headline,isi_podcast,link_youtube,hari,tanggal,jam FROM podcast
	WHERE aktif='N' ORDER BY id_podcast DESC");
}

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$isipodcast = strip_tags($t['isi_podcast']); 
	$isi = substr($isipodcast,0,150); 
	$isi = substr($isipodcast,0,strrpos($isi," ")); 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idpodcast']=$t['id_podcast'];
	$row_array['judul']=$t['judul'];
	$row_array['headline']=$t['headline'];
	$row_array['hari']=$t['hari'];
	$row_array['tanggal']=tgl_indo($t['tanggal']);
	$row_array['jam']=$t['jam'];
	$row_array['isipodcast']=$isi;	
	$row_array['linkyoutube']=$t['link_youtube'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
