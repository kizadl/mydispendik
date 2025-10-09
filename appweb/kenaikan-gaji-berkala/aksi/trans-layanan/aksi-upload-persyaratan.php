<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set('Asia/Jakarta');	

$idlayanan= trim($_GET['idlayanan']);
$idsekolah= trim($_GET['idsekolah']);
$ketfile= trim($_GET['ketfile']);
$nmfile= trim($_GET['nmfile']);
$idtransaksi= trim($_GET['idtransaksi']);
$idpersyaratan= trim($_GET['idpersyaratan']);

if ($idlayanan == "1"){
  if (!is_dir("../../../data-layanan/mutasi-siswa/" . $idtransaksi))
  mkdir("../../../data-layanan/mutasi-siswa/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/mutasi-siswa/" . $idtransaksi . "/";
} else if ($idlayanan == "2"){
  if (!is_dir("../../../data-layanan/pdb-mi/" . $idtransaksi))
  mkdir("../../../data-layanan/pdb-mi/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/pdb-mi/" . $idtransaksi . "/";
} else if ($idlayanan == "3"){
  if (!is_dir("../../../data-layanan/mutasi-pendidik/" . $idtransaksi))
  mkdir("../../../data-layanan/mutasi-pendidik/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/mutasi-pendidik/" . $idtransaksi . "/";
} else if ($idlayanan == "4"){
  if (!is_dir("../../../data-layanan/pergantian-kepsek/" . $idtransaksi))
  mkdir("../../../data-layanan/pergantian-kepsek/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/pergantian-kepsek/" . $idtransaksi . "/";
} else if ($idlayanan == "5"){
  if (!is_dir("../../../data-layanan/perubahan-ptk/" . $idtransaksi))
  mkdir("../../../data-layanan/perubahan-ptk/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/perubahan-ptk/" . $idtransaksi . "/";
} else if ($idlayanan == "6"){
  if (!is_dir("../../../data-layanan/pengajuan-npsn/" . $idtransaksi))
  mkdir("../../../data-layanan/pengajuan-npsn/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/pengajuan-npsn/" . $idtransaksi . "/";
} else if ($idlayanan == "7"){
  if (!is_dir("../../../data-layanan/pengajuan-akun-operator/" . $idtransaksi))
  mkdir("../../../data-layanan/pengajuan-akun-operator/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/pengajuan-akun-operator/" . $idtransaksi . "/";
} else if ($idlayanan == "8"){
  if (!is_dir("../../../data-layanan/pengajuan-npyp/" . $idtransaksi))
  mkdir("../../../data-layanan/pengajuan-npyp/" . $idtransaksi, 0777, true);
  $dest_folder = "../../../data-layanan/pengajuan-npyp/" . $idtransaksi . "/";
}

if (!empty($_FILES)) {

  $sql2  = "UPDATE tte_detail_trans_persyaratan SET ket_persyaratan='ADA' WHERE id_transaksi='".$idtransaksi."' AND id_persyaratan='".$idpersyaratan."'";
					$res=mysqli_query($dbconn,$sql2);	

	if(!file_exists($dest_folder) && !is_dir($dest_folder)) mkdir($dest_folder);

    foreach($_FILES['file']['tmp_name'] as $key => $value) {
        $tempFile = $_FILES['file']['tmp_name'][$key];
        $targetFile =  $dest_folder. $nmfile;
        move_uploaded_file($tempFile,$targetFile);
    }
 
    $data = [
    	"file" => $_POST["file"],
    	"dropzone" => $_POST["dropzone"],
    ];
    header('Content-type: application/json');
    echo json_encode($data);
    exit();
}