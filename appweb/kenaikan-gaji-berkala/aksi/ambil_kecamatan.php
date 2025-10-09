<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$kdkota = $_POST['kdkota'];
$kota = ("SELECT kd_kecamatan,nama_kecamatan,kd_kota FROM tte_m_kecamatan WHERE kd_kota='$kdkota' ORDER BY nama_kecamatan");
$istri = mysqli_query($dbconn,$kota);

echo "<option>Pilih Kecamatan</option>";
while($k = mysqli_fetch_array($istri)){
echo "<option value=\"".$k['kd_kecamatan']."\">".ucwords(strtolower($k['nama_kecamatan']))."</option>\n";
}
?>