<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$idpersyaratan = trim($_POST['idpersyaratan']);
$idsekolah = trim($_POST['idsekolah']);
$idlayanan = trim($_POST['idlayanan']);
$idtransaksi = trim($_POST['idtransaksi']);
$nmfile = trim($_POST['nmfile']);
$persyaratan = trim($_POST['persyaratan']);

if ($idlayanan == "1"){$folderlayanan = "mutasi-siswa";}
else if ($idlayanan == "2"){$folderlayanan = "pdb-mi";}
else if ($idlayanan == "3"){$folderlayanan = "mutasi-pendidik";}
else if ($idlayanan == "4"){$folderlayanan = "pergantian-kepsek";}
else if ($idlayanan == "5"){$folderlayanan = "perubahan-ptk";}
else if ($idlayanan == "6"){$folderlayanan = "pengajuan-npsn";}
else if ($idlayanan == "7"){$folderlayanan = "pengajuan-akun-operator";}
else if ($idlayanan == "8"){$folderlayanan = "pengajuan-npyp";}
//////// hapus file ///////////
$urlhapusfile = $_SERVER['DOCUMENT_ROOT']."/data-layanan/".$folderlayanan."/".$idtransaksi."/".$nmfile;
//////// //////////////////////

$sql2  = "UPDATE tte_detail_trans_persyaratan SET ket_persyaratan='TIDAK ADA' WHERE id_layanan='".$idlayanan."' AND id_transaksi='".$idtransaksi."' AND id_persyaratan='".$idpersyaratan."'";
$res=mysqli_query($dbconn,$sql2);	

function handle_error( $errno, $errstr, $errfile, $errline ) {
    die( $errstr );
}
set_error_handler( 'handle_error' );

if( ! @unlink( "$urlhapusfile" ) ) {
     echo "Gagal menghapus file ".$persyaratan;
} else {
     echo "Sukses menghapus file ".$persyaratan;
}

?>