<?php

//PUNTO DE VENTA

date_default_timezone_set('Mexico/General');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
$urlsite = 'https://plataformaitavu.tamaulipas.gob.mx'; global $urlsite;


//DATOS DE CONECCION
// $dbhost = '192.168.159.5';	
// // $dbhost = 'localhost';	
// $dbuser = 'root';
// $dbpass = '3LS4NT0*'; // PmTwrXcxUZ3oML9V
// $dbname = 'puntodeventa';

$dbhost = 'localhost';	
$dbuser = 'root';
$dbpass = ''; 
$dbname = 'puntodeventa';

	if (function_exists('mysqli_connect')) {
//mysqli está instalado
	//echo 'Si';
	$conexion = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	$acentos = $conexion->query("SET NAMES 'utf8'"); // para los acentos
	global $conexion;
}else{
	mensaje("ERROR: Hay un problema con la coneccion",'');


	// echo phpinfo();
	// echo "<h1 style='background-color:red;color:white;'>Hay un error al conectar con la base de datos (MySQLi)".var_dump(function_exists('mysqli_connect'))."</h1>";
}

	//KEYS GOOGLE
	$key_geo="AIzaSyDFrRZEYqnAuGMggPnDdD2qEm-bOpDdoNA";
	$key_map_static="AIzaSyCc2fdtBRrEiHBG4mEAIrFZ6kUrFbw3VL8";
	$completar1_fecha = "2017-08-03";

//PARAMETROS DE PREFERENCIA
 	global $moneda, $moneda_sufijo;
 	$fecha = date('Y-m-d');
	$hora =  date ("H:i:s");

	global $fecha, $hora, $tolerancia;
	
// CONFIGURACION DEL CORREO
	$correo_limite=1500; global $correo_limite;

	ini_set('max_execution_time', 0);
	

	$URLwebserviceVivienda = "http://172.16.91.3";
?>