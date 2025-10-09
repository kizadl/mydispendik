<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idsekolah = trim($_POST['idsekolah']);
$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);

$sqljum = ("SELECT COUNT(id_persyaratan) AS jumlahsyarat
FROM tte_m_persyaratan  WHERE aktif='Y' AND id_layanan='" . $idlayanan . "'");	
$resultjum = mysqli_query($dbconn,$sqljum);
$c = mysqli_fetch_assoc($resultjum);
$jumlahsyarat = $c['jumlahsyarat'];

$sqlx = ("SELECT p.id_persyaratan,p.id_layanan,p.persyaratan,p.nama_file,p.mode_upload
FROM tte_m_persyaratan p WHERE p.aktif='Y' AND p.id_layanan='" . $idlayanan . "'");	
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
$jumlahfile=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

  if ($idlayanan == "1"){
    $dir = "../../../data-layanan/mutasi-siswa/".$idtransaksi."/".$t['nama_file'].".pdf";
  } else if ($idlayanan == "2"){
    $dir = "../../../data-layanan/pdb-mi/".$idtransaksi."/".$t['nama_file'].".pdf";
  } else if ($idlayanan == "3"){
    $dir = "../../../data-layanan/mutasi-pendidik/".$idtransaksi."/".$t['nama_file'].".pdf";
  } else if ($idlayanan == "4"){
    $dir = "../../../data-layanan/pergantian-kepsek/".$idtransaksi."/".$t['nama_file'].".pdf";
  } else if ($idlayanan == "5"){
    $dir = "../../../data-layanan/perubahan-ptk/".$idtransaksi."/".$t['nama_file'].".pdf";
  } else if ($idlayanan == "6"){
    $dir = "../../../data-layanan/pengajuan-npsn/".$idtransaksi."/".$t['nama_file'].".pdf";
  } else if ($idlayanan == "7"){
    $dir = "../../../data-layanan/pengajuan-akun-operator/".$idtransaksi."/".$t['nama_file'].".pdf";
  } else if ($idlayanan == "8"){
    $dir = "../../../data-layanan/pengajuan-npyp/".$idtransaksi."/".$t['nama_file'].".pdf";
  }

  if(file_exists($dir)){
    $sttsfile = "Y";$jumlahfile++;
  }else{
    $sttsfile = "N";
  }

	$row_array = array();
	$row_array['no']=$no;
  $row_array['jumlahfile']=$jumlahfile;$row_array['jumlahsyarat']=$jumlahsyarat;
  $row_array['mdtransaksi']=md5($idtransaksi);
  $row_array['mdsyarat']=md5($t['id_persyaratan']);
	$row_array['idpersyaratan']=$t['id_persyaratan'];
	$row_array['persyaratan']=ucwords(strtolower($t['persyaratan']));
  $row_array['modeupload']=strtoupper($t['mode_upload']);
	$row_array['nmfile']=$t['nama_file'].".pdf";
  $row_array['sttsfile']=$sttsfile;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultjum->close();
$dbconn->close();
?>  
