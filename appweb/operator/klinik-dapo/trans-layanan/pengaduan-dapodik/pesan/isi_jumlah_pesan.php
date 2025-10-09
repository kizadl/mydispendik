<?php
error_reporting(0);
include '../../../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

function anti_injection($data){
    global $dbconn;
    $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
    return $filter;
}

$idtransaksi = anti_injection(trim($_POST['idtransaksi']));

$sql1 = ("SELECT COUNT(id_pesan) AS jumoptsekolah FROM pesan_pengaduan_dapodik WHERE id_transaksi='".$idtransaksi."'");			
$restjum1 = mysqli_query($dbconn,$sql1);$b= mysqli_fetch_assoc($restjum1);

$data = array();
$row_array['jumoptsekolah']=number_format($b['jumoptsekolah'],0,',','.');
array_push($data,$row_array);

echo json_encode($data);
$restjumtot->close();
$restjum1->close();$restjum2->close();$restjum3->close();$restjum4->close();
$dbconn->close();
