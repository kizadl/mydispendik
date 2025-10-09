<?php
error_reporting(0);
if (!headers_sent()) {ob_start("minify_output");}
function minify_output($buffer) {return preg_replace(['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'],['>', '<', '\\1'],$buffer);}

include '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$mdidtransaksi = $_GET['mdidtransaksi'];
$sql = ("SELECT id_transaksi FROM trans_pengaduan_dapodik WHERE md5(id_transaksi)='".$mdidtransaksi."'");	
$resultx = mysqli_query($dbconn,$sql);$t= mysqli_fetch_assoc($resultx);
$idtransaksi = $t['id_transaksi'];

$tempdir = "../data-layanan/pengaduan-dapodik/".$idtransaksi.".pdf";
mysqli_free_result($resultx);mysqli_close($dbconn);
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