<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

function anti_injection($data){
    global $dbconn;
    $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
    return $filter;
}

$idsurat = anti_injection(trim($_POST['idsurat']));

$sql1 = ("SELECT COUNT(id_pesan) AS jumlevel1 FROM detail_pesan WHERE id_surat='".$idsurat."' AND ket_level='1' OR id_surat='".$idsurat."' AND send_level='1' AND ket_level='1'");			
$restjum1 = mysqli_query($dbconn,$sql1);$b= mysqli_fetch_assoc($restjum1);

$sql2 = ("SELECT COUNT(id_pesan) AS jumlevel2 FROM detail_pesan WHERE id_surat='".$idsurat."' AND ket_level='2' OR id_surat='".$idsurat."' AND send_level='2' AND ket_level='1'");			
$restjum2 = mysqli_query($dbconn,$sql2);$c= mysqli_fetch_assoc($restjum2);

$sql3 = ("SELECT COUNT(id_pesan) AS jumlevel3 FROM detail_pesan WHERE id_surat='".$idsurat."' AND ket_level='3' OR id_surat='".$idsurat."' AND send_level='3' AND ket_level='1'");			
$restjum3 = mysqli_query($dbconn,$sql3);$d= mysqli_fetch_assoc($restjum3);

$sql4 = ("SELECT COUNT(id_pesan) AS jumlevel4 FROM detail_pesan WHERE id_surat='".$idsurat."' AND ket_level='4' OR id_surat='".$idsurat."' AND send_level='4' AND ket_level='1'");			
$restjum4 = mysqli_query($dbconn,$sql4);$e= mysqli_fetch_assoc($restjum4);

$sql5 = ("SELECT COUNT(id_pesan) AS jumlevel5 FROM detail_pesan WHERE id_surat='".$idsurat."' AND ket_level='5' OR id_surat='".$idsurat."' AND send_level='5' AND ket_level='1'");			
$restjum5 = mysqli_query($dbconn,$sql5);$f= mysqli_fetch_assoc($restjum5);

$sql6 = ("SELECT COUNT(id_pesan) AS jumlevel6 FROM detail_pesan WHERE id_surat='".$idsurat."' AND ket_level='6' OR id_surat='".$idsurat."' AND send_level='6' AND ket_level='1'");			
$restjum6 = mysqli_query($dbconn,$sql6);$g= mysqli_fetch_assoc($restjum6);

$sql7 = ("SELECT COUNT(id_pesan) AS jumlevel7 FROM detail_pesan WHERE id_surat='".$idsurat."' AND ket_level='7' OR id_surat='".$idsurat."' AND send_level='7' AND ket_level='1'");			
$restjum7 = mysqli_query($dbconn,$sql7);$h= mysqli_fetch_assoc($restjum7);

$data = array();
$row_array['jumlevel1']=number_format($b['jumlevel1'],0,',','.');
$row_array['jumlevel2']=number_format($c['jumlevel2'],0,',','.');
$row_array['jumlevel3']=number_format($d['jumlevel3'],0,',','.');
$row_array['jumlevel4']=number_format($e['jumlevel4'],0,',','.');
$row_array['jumlevel5']=number_format($f['jumlevel5'],0,',','.');
$row_array['jumlevel6']=number_format($g['jumlevel6'],0,',','.');
$row_array['jumlevel7']=number_format($h['jumlevel7'],0,',','.');
array_push($data,$row_array);

echo json_encode($data);
$restjumtot->close();
$restjum1->close();$restjum2->close();$restjum3->close();$restjum4->close();
$restjum5->close();$restjum6->close();$restjum7->close();
$dbconn->close();
