<html>
<head>
<style type="text/css">
#myiframe {width:100%; height:100%;} 
</style>
</head>
<body>
<div id="scroller">
<?php
error_reporting(0);
include '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$mdidtransaksi = $_GET['mdidtransaksi'];
$sql = ("SELECT id_transaksi,ket_status_surat FROM tte_trans_mutasi_siswa WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
$resultx = mysqli_query($dbconn,$sql);$t= mysqli_fetch_assoc($resultx);
$idtransaksi = $t['id_transaksi'];

if ($t['ket_status_surat'] == "belum" OR $t['ket_status_surat'] == "tolak"){
    $tempdir = "../data-layanan/mutasi-siswa/".$idtransaksi."/surat-rekomendasi/".$idtransaksi.".pdf";
} else if ($t['ket_status_surat'] == "terima"){
    $tempdir = "../data-layanan/mutasi-siswa/".$idtransaksi."/surat-rekomendasi/".$mdidtransaksi.".pdf";
}

mysqli_free_result($resultx);mysqli_close($dbconn);

?>
<iframe name="myiframe" id="myiframe" src="<?php echo $tempdir;?>"></iframe>
</div>
</body>
</html>