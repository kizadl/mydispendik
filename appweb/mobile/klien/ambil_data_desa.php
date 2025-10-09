<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idkecamatan= trim($_POST['idkecamatan']);

$sqlx = ("SELECT kd_desa,nama_desa FROM m_desa WHERE kd_kecamatan='".$idkecamatan."' ORDER BY nama_desa DESC");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['iddesa']=$t['kd_desa'];
	$row_array['nmdesa']=ucwords(strtolower($t['nama_desa']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>