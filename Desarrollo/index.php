<?php
//SEGURIDAD
session_start();	
// echo "=>".$_SESSION['pdz_username'];
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

if (isset($_SESSION['_user'])){
	$NotITAVU_user = $_SESSION['_user'];
	//echo $NotITAVU_user;
}else{	
	if(isset($_GET['busqueda'])){
		$busqueda = $_GET['busqueda'];
		$_SESSION = array(); session_destroy();	
		header("location:login.php?busqueda=".$busqueda."");
	}else{
		$_SESSION = array(); session_destroy();	
		header("location:login.php");
	}
			
	
}

?>

<?php include ("src/body_head.php");
include("src/config.php");
?>
<?php

echo 'entre al index';

?>

	
    
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include ("src/body_footer.php"); ?>

