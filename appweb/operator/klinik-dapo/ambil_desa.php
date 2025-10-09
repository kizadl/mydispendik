<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$kdkecamatan = $_POST['kdkecamatan'];
$kota = ("SELECT kd_desa,nama_desa,kd_kecamatan FROM tte_m_desa WHERE kd_kecamatan='$kdkecamatan' ORDER BY nama_desa");
$kecmt = mysqli_query($dbconn,$kota);

echo "<option>Pilih Desa / Kelurahan</option>";
while($k = mysqli_fetch_array($kecmt)){
echo "<option value=\"".$k['kd_desa']."\">".ucwords(strtolower($k['nama_desa']))."</option>\n";
}
?>