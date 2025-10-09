<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id_sekolah,p.npsn,p.nama,p.bentuk_pendidikan,p.alamat_jalan,p.desa_kelurahan,p.kecamatan
FROM tbl_api_dispendik p");	

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['namasekolah']=$t['nama'];
	$row_array['npsn']=$t['npsn'];
	$row_array['alamat']=ucwords(strtolower($t['alamat_jalan']));
	$row_array['desa']=ucwords(strtolower($t['desa_kelurahan']));
	$row_array['kecamatan']=ucwords(strtolower($t['kecamatan']));
	$row_array['bentukpendidikan']=$t['bentuk_pendidikan'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
