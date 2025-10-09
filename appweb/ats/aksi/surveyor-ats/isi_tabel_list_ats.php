<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idsurveyor = trim($_POST['idsurveyor']);
$idkecamatan = trim($_POST['idkecamatan']);

$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.nisn,p.alamat,p.desa,p.kecamatan,
p.bentuk_pendidikan,p.tingkat_pendidikan,p.status_ats
FROM tbl_ats p WHERE p.kd_kecamatan='" . $idkecamatan . "' AND (p.id_surveyor) IS NULL OR p.kd_kecamatan='" . $idkecamatan . "' AND p.id_surveyor='".$idsurveyor."'");	

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsiswa']=$t['id_siswa'];
	$row_array['namasiswa']=ucwords(strtolower($t['nama_siswa']));
	$row_array['nisn']=$t['nisn'];
	$row_array['alamat']=ucwords(strtolower($t['alamat']));
	$row_array['desa']=ucwords(strtolower($t['desa']));
	$row_array['kecamatan']=ucwords(strtolower($t['kecamatan']));
	$row_array['bentukpendidikan']=$t['bentuk_pendidikan'];
	$row_array['tingkatpendidikan']=$t['tingkat_pendidikan'];
	$row_array['statusats']=$t['status_ats'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
