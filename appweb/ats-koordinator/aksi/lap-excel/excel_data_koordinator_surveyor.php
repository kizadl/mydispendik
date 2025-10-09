<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data-koordinator-surveyor.xls");
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

$iduniversitas = trim($_GET['iduniversitas']);
?>
<center>DATA KOORDINATOR - SURVEYOR</center>
<center>Cetak Tanggal <?php echo $tanggal; ?></center>

<table>
	<thead>
		<tr>
			<th style="background:#666;color:#fff;height:25px;width:50px">
				<center>NO</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:210px">
				<center>KOORDINATOR</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:250px">
				<center>UNIVERSITAS</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:500px">
				<center>DATA SURVEYOR</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($iduniversitas == "all") {
			$sqlx = ("SELECT p.id_koordinator,p.nm_koordinator,p.id_universitas,p.id_fakultas,q.nm_universitas,r.nm_fakultas
		FROM ats_koordinator p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");
		} else {
			$sqlx = ("SELECT p.id_koordinator,p.nm_koordinator,p.id_universitas,p.id_fakultas,q.nm_universitas,r.nm_fakultas
		FROM ats_koordinator p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		WHERE p.id_universitas='" . $iduniversitas . "'
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");
		}
		$result = mysqli_query($dbconn, $sqlx);
		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;
			$nmkoordinator = ucwords(strtolower($t['nm_koordinator']));
			$nmuniversitas = ucwords(strtolower($t['nm_universitas']));

			$sqldet = ("SELECT p.nm_surveyor,p.telepon,q.nm_fakultas
		FROM ats_surveyor p LEFT JOIN ats_fakultas q ON p.id_fakultas=q.id_fakultas
		WHERE p.id_koordinator = '" . $t['id_koordinator'] . "' ORDER BY p.nm_surveyor ASC");
			$resultdet = mysqli_query($dbconn, $sqldet);
			$nod = 0;
			$listsurveyor = "";
			while ($s = mysqli_fetch_array($resultdet)) {
				$nod++;
				$listsurveyor = $listsurveyor . $nod . ". " . ucwords(strtolower($s['nm_surveyor'])) . " (" . $s['telepon'] . ") - ".ucwords(strtolower($s['nm_fakultas'])) ."<br>";
			}

			echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:top;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
        <td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$nmkoordinator
		</td>
        <td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$nmuniversitas
		</td>
		<td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$listsurveyor
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>