<?php
$idkecamatan=$_POST['value1'];$iddesa=$_POST['value2'];
$nmimg = $jumupdate.".jpg";

if(!is_dir("data-foto/".$idkecamatan."/".$iddesa."/".$idtps."/"))
mkdir("data-foto/".$idkecamatan."/".$iddesa."/".$idtps,0777,true); 

move_uploaded_file($_FILES["file"]["tmp_name"], 'data-foto/'.$idkecamatan.'/'.$iddesa.'/'.$idtps.'/'.$nmimg);
echo $nmimg.'-'.$idkecamatan.'-'.$iddesa ;
?>