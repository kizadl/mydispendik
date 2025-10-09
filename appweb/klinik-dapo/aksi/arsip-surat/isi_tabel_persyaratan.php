<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idinstansi = trim($_POST['idinstansi']);
$idsurat = trim($_POST['idsurat']);
$idlayanan = trim($_POST['idlayanan']);

$sqljum = ("SELECT COUNT(id_persyaratan) AS jumlahsyarat
FROM m_persyaratan_layanan  WHERE aktif='Y' AND id_layanan='" . $idlayanan . "'");	
$resultjum = mysqli_query($dbconn,$sqljum);
$c = mysqli_fetch_assoc($resultjum);
$jumlahsyarat = $c['jumlahsyarat'];

$sqlx = ("SELECT p.id_persyaratan,p.id_layanan,p.persyaratan,p.nama_file
FROM m_persyaratan_layanan p WHERE p.aktif='Y' AND p.id_layanan='" . $idlayanan . "'");	

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
$jumlahfile=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

  $dir = "../../../data-persyaratan/".$idinstansi."/".$idsurat."/".$t['nama_file'].".pdf";

  if(file_exists($dir)){
    $sttsfile = "Y";$jumlahfile++;
  }else{
    $sttsfile = "N";
  }

	$row_array = array();
	$row_array['no']=$no;
  $row_array['jumlahfile']=$jumlahfile;$row_array['jumlahsyarat']=$jumlahsyarat;
  $row_array['mdsurat']=md5($idsurat);
  $row_array['mdsyarat']=md5($t['id_persyaratan']);
	$row_array['idpersyaratan']=$t['id_persyaratan'];
	$row_array['persyaratan']=$t['persyaratan'];
	$row_array['nmfile']=$t['nama_file'].".pdf";
  $row_array['sttsfile']=$sttsfile;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultjum->close();
$dbconn->close();
?>  
