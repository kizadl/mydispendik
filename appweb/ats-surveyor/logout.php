<?php
session_start();

unset($_SESSION['IDSURVEYOR']); 
unset($_SESSION['NMSURVEYOR']); 
unset($_SESSION['USERNAME']);
unset($_SESSION['IDUNIVERSITAS']);
unset($_SESSION['IDFAKULTAS']);
unset($_SESSION['IDKECAMATAN']);

session_destroy(); 
echo"
<script>
window.location='../home.html';
</script>";
exit; 
?>