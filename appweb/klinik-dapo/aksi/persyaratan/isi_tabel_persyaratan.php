<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idlayanan = trim($_POST['idlayanan']);

$sqlx = ("SELECT p.id_persyaratan,p.id_layanan,p.persyaratan,p.nama_file,p.mode_upload
FROM tte_m_persyaratan p WHERE p.aktif='Y' AND p.id_layanan='" . $idlayanan . "'");	

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['iddetail']=$t['id_persyaratan'];
	$row_array['persyaratan']=ucwords(strtolower($t['persyaratan']));
	$row_array['nmfile']=$t['nama_file'].".pdf";
	$row_array['modeupload']=ucwords(strtolower($t['mode_upload']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
