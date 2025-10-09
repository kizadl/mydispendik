<?php
error_reporting(0);

if (!headers_sent()) {ob_start("minify_output");}
function minify_output($buffer) {return preg_replace(['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'],['>', '<', '\\1'],$buffer);}

include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$idlayanan = $_GET['idlayanan'];
$mdidtransaksi = $_GET['idtransaksi'];
$mdsyarat = $_GET['kdsyarat'];

if ($idlayanan == "1"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_mutasi_siswa WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
} else if ($idlayanan == "2"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_verifikasi_pdb_mi WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
} else if ($idlayanan == "3"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_mutasi_pendidik WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
} else if ($idlayanan == "4"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_pergantian_kepsek WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
} else if ($idlayanan == "5"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_perubahan_ptk WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
} else if ($idlayanan == "6"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_pengajuan_npsn WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
} else if ($idlayanan == "7"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_pengajuan_akun_operator WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
} else if ($idlayanan == "8"){
    $sql = ("SELECT id_transaksi,id_sekolah FROM tte_trans_pengajuan_npyp WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
}

$resultx = mysqli_query($dbconn,$sql);$t= mysqli_fetch_assoc($resultx);
$idtransaksi = $t['id_transaksi'];$idsekolah = $t['id_sekolah'];

$sqlsy = ("SELECT nama_file FROM tte_m_persyaratan WHERE md5(id_persyaratan)='".$mdsyarat."'");	
$resultxsy = mysqli_query($dbconn,$sqlsy);$w= mysqli_fetch_assoc($resultxsy);
$nmfile = $w['nama_file'];

if ($idlayanan == "1"){
    $tempdir = "../data-layanan/mutasi-siswa/".$idtransaksi."/".$nmfile.".pdf";
} else if ($idlayanan == "2"){
    $tempdir = "../data-layanan/pdb-mi/".$idtransaksi."/".$nmfile.".pdf";
} else if ($idlayanan == "3"){
    $tempdir = "../data-layanan/mutasi-pendidik/".$idtransaksi."/".$nmfile.".pdf";
} else if ($idlayanan == "4"){
    $tempdir = "../data-layanan/pergantian-kepsek/".$idtransaksi."/".$nmfile.".pdf";
} else if ($idlayanan == "5"){
    $tempdir = "../data-layanan/perubahan-ptk/".$idtransaksi."/".$nmfile.".pdf";
} else if ($idlayanan == "6"){
    $tempdir = "../data-layanan/pengajuan-npsn/".$idtransaksi."/".$nmfile.".pdf";
} else if ($idlayanan == "7"){
    $tempdir = "../data-layanan/pengajuan-akun-operator/".$idtransaksi."/".$nmfile.".pdf";
} else if ($idlayanan == "8"){
    $tempdir = "../data-layanan/pengajuan-npyp/".$idtransaksi."/".$nmfile.".pdf";
}

mysqli_free_result($resultx);mysqli_free_result($resultxsy);
mysqli_close($dbconn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dokumen</title>
    <link href="favicon.png" rel="icon" />
    <style type="text/css">
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; 
        }
        #myiframe2 {
            width: 100%;
            height: 100%;
            border: none; 
        }
    </style>
</head>
<body>
<iframe name="myiframe2" id="myiframe2" src="<?php echo $tempdir . '?t=' . time(); ?>"></iframe>
</body>
</html>
<?php ob_end_flush(); ?>