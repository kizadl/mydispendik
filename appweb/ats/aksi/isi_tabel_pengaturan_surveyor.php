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
	$sqlx = ("SELECT p.id_surveyor,p.nm_surveyor,p.id_universitas,p.id_fakultas,p.id_kecamatan,
		q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");
} else if ($ketfilter == "universitas"){
	$sqlx = ("SELECT p.id_surveyor,p.nm_surveyor,p.id_universitas,p.id_fakultas,p.id_kecamatan,
		q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		WHERE p.id_universitas='".$iduniversitas."'
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");	
} else if ($ketfilter == "fakultas"){
	$sqlx = ("SELECT p.id_surveyor,p.nm_surveyor,p.id_universitas,p.id_fakultas,p.id_kecamatan,
		q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		WHERE p.id_fakultas='".$idfakultas."'
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");	
} else if ($ketfilter == "kecamatan"){
	$sqlx = ("SELECT p.id_surveyor,p.nm_surveyor,p.id_universitas,p.id_fakultas,p.id_kecamatan,
		q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		WHERE p.id_kecamatan='".$idkecamatan."'
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");		
} else if ($ketfilter == "desa"){
	$sqlx = ("SELECT p.id_surveyor,p.nm_surveyor,p.id_universitas,p.id_fakultas,p.id_kecamatan,
		q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		FROM ats_surveyor p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		WHERE p.id_desa='".$iddesa."'
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");		
}

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$sqldet = ("SELECT nama_siswa,nik
		FROM tbl_ats WHERE id_surveyor = '".$t['id_surveyor']."' ORDER BY nama_siswa ASC");			
	$resultdet = mysqli_query($dbconn,$sqldet);
	$nod=0;$listsurveyor ="";
	while($s=mysqli_fetch_array($resultdet)){
		$nod++;
		$listsurveyor = $listsurveyor.$nod.". ".ucwords(strtolower($s['nama_siswa']))." (".$s['nik'].")<br>";
	}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsurveyor']=$t['id_surveyor'];
	$row_array['iduniversitas']=$t['id_universitas'];
	$row_array['idfakultas']=$t['id_fakultas'];
	$row_array['idkecamatan']=$t['id_kecamatan'];
	$row_array['nmsurveyor']=ucwords(strtolower($t['nm_surveyor']));
	$row_array['nmuniversitas']=ucwords(strtolower($t['nm_universitas']));
	$row_array['nmfakultas']=ucwords(strtolower($t['nm_fakultas']));
	$row_array['namakecamatan']=ucwords(strtolower($t['nama_kecamatan']));
	$row_array['namadesa']=ucwords(strtolower($t['nama_desa']));
	$row_array['listsurveyor']=$listsurveyor;	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultdet->close();
$dbconn->close();
?>  
