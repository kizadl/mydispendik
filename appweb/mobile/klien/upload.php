<?php
$idsiswa=$_POST['value1'];$idsurveyor=$_POST['value2'];
$nmimg = $idsiswa.".jpg";

if(!is_dir("../../data-foto-ats/"))
mkdir("../../data-foto-ats",0777,true); 

move_uploaded_file($_FILES["file"]["tmp_name"], '../../data-foto-ats/'.$nmimg);
echo $nmimg.'-'.$idsiswa.'-'.$idsurveyor ;
?>