<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Jan";
			break;
		case 2:
			return "Feb";
			break;
		case 3:
			return "Mar";
			break;
		case 4:
			return "Apr";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Agu";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Okt";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Des";
			break;
	}
} 

function anti_injection($data){
    global $dbconn;
    $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
    return $filter;
}

$idsurat = anti_injection(trim($_POST['idsurat']));

$sqlx = ("SELECT p.isi_pesan,p.ket_level,p.send_level,p.ket_verifikator,p.waktu_pesan,q.nm_operator
		FROM detail_pesan p 
		LEFT JOIN m_operator q ON p.id_verifikator=q.id_operator
		WHERE p.id_surat='".$idsurat."' AND p.ket_level = '2' OR p.id_surat='".$idsurat."' AND p.send_level = '2' ORDER BY p.id_pesan ASC");
		
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	

	$row_array = array();
	$row_array['isipesan']=$t['isi_pesan'];
	$row_array['tglpesan']=tgl_indo($t['waktu_pesan']);
	$row_array['jampesan']= date("H:i", strtotime($t['waktu_pesan']));
	$row_array['ketlevel']=$t['ket_level'];
	$row_array['sendlevel']=$t['send_level'];
	$row_array['ketverifikator']=$t['ket_verifikator'];
	$row_array['nmoperator']=ucwords(strtolower($t['nm_operator']));

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
