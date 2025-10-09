<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$ketfilter= trim($_POST['ketfilter']);
$iduniversitas= trim($_POST['iduniversitas']);
$idfakultas= trim($_POST['idfakultas']);
$idkecamatan= trim($_POST['idkecamatan']);
$iddesa= trim($_POST['iddesa']);
if ($ketfilter == "all"){
	$sqlx = ("SELECT p.id_surveyor,p.id_universitas,p.id_fakultas,p.nm_surveyor,p.telepon,p.status_hp,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan
		 FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");	
} else if ($ketfilter == "universitas"){
	$sqlx = ("SELECT p.id_surveyor,p.id_universitas,p.id_fakultas,p.nm_surveyor,p.telepon,p.status_hp,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan
		 FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 WHERE p.id_universitas = '".$iduniversitas."'
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");	
} else if ($ketfilter == "fakultas"){
	$sqlx = ("SELECT p.id_surveyor,p.id_universitas,p.id_fakultas,p.nm_surveyor,p.telepon,p.status_hp,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan
		 FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 WHERE p.id_fakultas = '".$idfakultas."'
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");	
} else if ($ketfilter == "kecamatan"){
	$sqlx = ("SELECT p.id_surveyor,p.id_universitas,p.id_fakultas,p.nm_surveyor,p.telepon,p.status_hp,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan
		 FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 WHERE p.id_kecamatan = '".$idkecamatan."'
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");	
} else if ($ketfilter == "desa"){
	$sqlx = ("SELECT p.id_surveyor,p.id_universitas,p.id_fakultas,p.nm_surveyor,p.telepon,p.status_hp,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan
		 FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 WHERE p.id_desa = '".$iddesa."'
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");	
}

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 

	if ($t['nm_universitas'] == NULL) {$nmuniversitas = "-";} else {$nmuniversitas = ucwords(strtolower($t['nm_universitas']));} 
	if ($t['nm_fakultas'] == NULL) {$nmfakultas = "-";} else {$nmfakultas = ucwords(strtolower($t['nm_fakultas']));} 
	if ($t['nama_kecamatan'] == NULL) {$nmkecamatan = "-";} else {$nmkecamatan = ucwords(strtolower($t['nama_kecamatan']));} 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsurveyor']=$t['id_surveyor'];
	$row_array['iduniversitas']=$t['id_universitas'];
	$row_array['idfakultas']=$t['id_fakultas'];
	$row_array['nmsurveyor']=ucwords(strtolower($t['nm_surveyor']));
	$row_array['telepon']=$t['telepon'];
	$row_array['nmuniversitas']=$nmuniversitas;
	$row_array['nmfakultas']=$nmfakultas;
	$row_array['nmkecamatan']=$nmkecamatan;
	$row_array['statushp']=$t['status_hp'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
