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

$sql1 = ("SELECT COUNT(id_pesan) AS jumoptsekolah FROM tte_detail_pesan WHERE id_transaksi='".$idtransaksi."' AND pengirim='operator sekolah' OR id_transaksi='".$idtransaksi."' AND penerima='operator sekolah'");			
$restjum1 = mysqli_query($dbconn,$sql1);$b= mysqli_fetch_assoc($restjum1);

$sql2 = ("SELECT COUNT(id_pesan) AS jumloptbidang FROM tte_detail_pesan WHERE id_transaksi='".$idtransaksi."' AND pengirim='operator bidang' OR id_transaksi='".$idtransaksi."' AND penerima='operator bidang'");		
$restjum2 = mysqli_query($dbconn,$sql2);$c= mysqli_fetch_assoc($restjum2);

$sql3 = ("SELECT COUNT(id_pesan) AS jumkasi FROM tte_detail_pesan WHERE id_transaksi='".$idtransaksi."' AND pengirim='kepala seksi' OR id_transaksi='".$idtransaksi."' AND penerima='kepala seksi'");		
$restjum3 = mysqli_query($dbconn,$sql3);$d= mysqli_fetch_assoc($restjum3);

$sql4 = ("SELECT COUNT(id_pesan) AS jumkabid FROM tte_detail_pesan WHERE id_transaksi='".$idtransaksi."' AND pengirim='kepala bidang' OR id_transaksi='".$idtransaksi."' AND penerima='kepala bidang'");		
$restjum4 = mysqli_query($dbconn,$sql4);$e= mysqli_fetch_assoc($restjum4);

$data = array();
$row_array['jumoptsekolah']=number_format($b['jumoptsekolah'],0,',','.');
$row_array['jumloptbidang']=number_format($c['jumloptbidang'],0,',','.');
$row_array['jumkasi']=number_format($d['jumkasi'],0,',','.');
$row_array['jumkabid']=number_format($e['jumkabid'],0,',','.');
array_push($data,$row_array);

echo json_encode($data);
$restjumtot->close();
$restjum1->close();$restjum2->close();$restjum3->close();$restjum4->close();
$dbconn->close();
