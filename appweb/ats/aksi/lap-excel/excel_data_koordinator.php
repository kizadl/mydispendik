<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data-koordinator.xls");
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

?>
<center>DATA KOORDINATOR</center>
<center>SURVEI ATS</center>
<center>Cetak Tanggal <?php echo $tanggal; ?></center>

<table>
	<thead>
		<tr>
			<th style="background:#666;color:#fff;height:25px;width:50px">
				<center>NO</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:180px">
				<center>NAMA KOORDINATOR</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:250px">
				<center>UNIVERSITAS</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:320px">
				<center>FAKULTAS</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:180px">
				<center>USERNAME</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$sqlx = ("SELECT p.nm_koordinator,p.username,q.nm_universitas,r.nm_fakultas
		 FROM ats_koordinator p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");
		$result = mysqli_query($dbconn, $sqlx);
		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;
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

			$nmkoordinator = ucwords(strtolower($t['nm_koordinator']));
			$username = $t['username'];
			echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$nmkoordinator
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmuniversitas
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmfakultas
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$username
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>