<?php 	require("src/funciones.php"); ?>
<?php 	require("src/config.php"); ?>
<?php 


$nitavu="";
 //Crear sesión
 session_start();
 //Vaciar sesión
 $_SESSION = array();


//  SESSION_close(session_id());
 //Destruir Sesión
 session_destroy();

 if(isset($_COOKIE[session_name()])) { 
    setcookie(session_name(), '', time() - 42000, '/'); 
  } 
  

 //Redireccionar a login.php

header("location:login.php");

?>