<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data-surveyor-survei.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: MYDISPENDIK");

error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function getBulan($bln)
{
	switch ($bln) {
		case 1:
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}
$tanggal = tgl_indo(date("Y-m-d"));

$idkecamatan = trim($_GET['idkecamatan']);
$iddesa = trim($_GET['iddesa']);
$namakecamatan = trim($_GET['namakecamatan']);
$namadesa = trim($_GET['namadesa']);
if ($idkecamatan == "all") {
	$ketkopexport = $namakecamatan;
} else if ($idkecamatan != "all" and $iddesa == "all") {
	$ketkopexport = $namakecamatan;
} else if ($idkecamatan != "all" and $iddesa != "all") {
	$ketkopexport = $namakecamatan . " - " . $namadesa;
}
?>
<center>DATA SURVEYOR SUDAH SURVEI ATS</center>
<center><?php echo $ketkopexport; ?></center>
<center>Cetak Tanggal <?php echo $tanggal; ?></center>

<table>
	<thead>
		<tr>
			<th style="background:#666;color:#fff;height:25px;width:50px">
				<center>NO</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:100px">
				<center>NIM</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:200px">
				<center>NAMA SURVEYOR</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:250px">
				<center>UNIVERSITAS</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:320px">
				<center>FAKULTAS</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:160px">
				<center>DESA/KELURAHAN</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:180px">
				<center>KECAMATAN</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>BELUM</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>SUDAH</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>JUMLAH</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:70px">
				<center>%</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($idkecamatan == "all") {
			$sqlx = ("SELECT DISTINCT a.id_surveyor,p.nm_surveyor,p.telepon,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		 FROM ats_detail_survei_2025 a
		 LEFT JOIN ats_surveyor_2025 p ON a.id_surveyor=p.id_surveyor
		 LEFT JOIN ats_universitas_2025 q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas_2025 r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");
		} else if ($idkecamatan != "all" and $iddesa == "all") {
			$sqlx = ("SELECT DISTINCT a.id_surveyor,p.nm_surveyor,p.telepon,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		 FROM ats_detail_survei_2025 a
		 LEFT JOIN ats_surveyor_2025 p ON a.id_surveyor=p.id_surveyor
		 LEFT JOIN ats_universitas_2025 q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas_2025 r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		 WHERE p.id_kecamatan = '" . $idkecamatan . "'
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");
		} else if ($idkecamatan != "all" and $iddesa != "all") {
			$sqlx = ("SELECT DISTINCT a.id_surveyor,p.nm_surveyor,p.telepon,q.nm_universitas,r.nm_fakultas,s.nama_kecamatan,t.nama_desa
		 FROM ats_detail_survei_2025 a
		 LEFT JOIN ats_surveyor_2025 p ON a.id_surveyor=p.id_surveyor
		 LEFT JOIN ats_universitas_2025 q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas_2025 r ON p.id_fakultas=r.id_fakultas
		 LEFT JOIN m_kecamatan s ON p.id_kecamatan=s.kd_kecamatan
		 LEFT JOIN m_desa t ON p.id_desa=t.kd_desa
		 WHERE p.id_desa = '" . $iddesa . "'
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");
		}
		$result = mysqli_query($dbconn, $sqlx);
		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;

			$sqlcount = ("SELECT COUNT(id_siswa) AS jumSiswa FROM ats_detail_survei_2025 WHERE id_surveyor = '" . $t['id_surveyor'] . "'");
			$resultcount = mysqli_query($dbconn, $sqlcount);
			$r = mysqli_fetch_assoc($resultcount);

			$sqltotal = ("SELECT COUNT(id_siswa) AS jumTotSiswa FROM tbl_ats_2025 WHERE id_surveyor = '" . $t['id_surveyor'] . "'");
			$resulttotal = mysqli_query($dbconn, $sqltotal);
			$s = mysqli_fetch_assoc($resulttotal);

			if ($s['jumTotSiswa'] >= 1 or $s['jumSiswa'] >= 1) {
				$jumTotSiswa = $s['jumTotSiswa'];
				$jumSurveyorSudah = $r['jumSiswa'];
				$jumSurveyorBelum = $s['jumTotSiswa'] - $r['jumSiswa'];
				$jumSurveyorPersen = number_format(($r['jumSiswa'] / $s['jumTotSiswa']) * 100, 2, ',', '.');
			} else {
				$jumTotSiswa = 0;
				$jumSurveyorSudah = 0;
				$jumSurveyorBelum = 0;
				$jumSurveyorPersen = 0;
			}

			if ($t['nm_universitas'] == NULL) {
				$nmuniversitas = "-";
			} else {
				$nmuniversitas = ucwords(strtolower($t['nm_universitas']));
			}
			if ($t['nm_fakultas'] == NULL) {
				$nmfakultas = "-";
			} else {
				$nmfakultas = ucwords(strtolower($t['nm_fakultas']));
			}
			if ($t['nama_kecamatan'] == NULL) {
				$nmkecamatan = "-";
			} else {
				$nmkecamatan = ucwords(strtolower($t['nama_kecamatan']));
			}
			if ($t['nama_desa'] == NULL) {
				$nmdesa = "-";
			} else {
				$nmdesa = ucwords(strtolower($t['nama_desa']));
			}

			$nmsurveyor = ucwords(strtolower($t['nm_surveyor']));
			$nim = $t['telepon'];
			echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$nim
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmsurveyor
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmuniversitas
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmfakultas
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmdesa
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmkecamatan
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumSurveyorBelum
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumSurveyorSudah
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumTotSiswa
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumSurveyorPersen %
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>