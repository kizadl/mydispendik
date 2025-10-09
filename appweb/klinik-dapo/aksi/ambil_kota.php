<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$kdpropinsi = $_POST['kdpropinsi'];
$kota = ("SELECT kd_kota,nama_kota,kd_propinsi FROM tte_m_kota WHERE kd_propinsi='$kdpropinsi' ORDER BY nama_kota");
$dbkota = mysqli_query($dbconn,$kota);

echo "<option>Pilih Kabupaten</option>";
while($k = mysqli_fetch_array($dbkota)){
echo "<option value=\"".$k['kd_kota']."\">".ucwords(strtolower($k['nama_kota']))."</option>\n";
}
mysqli_free_result($dbkota);
mysqli_close($dbconn);
?>