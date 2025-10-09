<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlx = ("SELECT id_faq,judul_faq,uraian_faq FROM faq_ppdb
	ORDER BY id_faq DESC");

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$isipodcast = strip_tags($t['uraian_faq']); 
	$isi = substr($isipodcast,0,150); 
	$isi = substr($isipodcast,0,strrpos($isi," ")); 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idfaq']=$t['id_faq'];
	$row_array['judulfaq']=$t['judul_faq'];
	$row_array['uraianfaq']=$isi;	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
