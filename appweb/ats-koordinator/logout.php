<?php
session_start();

unset($_SESSION['IDKOORDINATOR']); 
unset($_SESSION['USERNAME']); 
unset($_SESSION['NMKOORDINATOR']);
unset($_SESSION['IDUNIVERSITAS']);
unset($_SESSION['IDFAKULTAS']);

session_destroy(); 
echo"
<script>
window.location='../home.html';
</script>";
exit; 
?>