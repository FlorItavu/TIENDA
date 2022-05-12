<?php 	require("src/funciones_heredadas.php"); ?>
<?php 	require("src/funciones.php"); ?>
<?php 	require("src/config.php"); ?>
<?php // error_reporting(E_ALL ^ E_NOTICE);



?>
<!DOCTYPE html>
<html>
	<head>
		<title>NOTIFICACION ITAVU</title>
		
		<meta charset="utf-8" />		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<meta name="robots" content="index,follow">
		<meta name="googlebot" content="index,follow">
		<meta name="geo.region" content="MX-TAM">
		
		<script src="src/jquery-3.3.1.min.js"></script>	
		<link rel="stylesheet" href="src/estilonotificacion.css">
        <link rel="stylesheet" href="src/flor_css.css">
				
		<script src="src/push.js"></script>
		<script src="src/push.min.js"></script>        
	    <script src="src/jquery.modalpdz.js"></script> <link rel="stylesheet" href="src/jquery.modalcsspdz.css" />
        <script src="src/pdz_functions.js"></script>
        <script src='src/pdz_sintetizadodevoz.js'></script>
        <link rel="stylesheet" type="text/css" href="semantic/semantic.min.css">
        <script src="semantic/semantic.min.js"></script>
	
		<style>
		
		</style>
		

</head>

<center>
<div style='margin-top:10%;'>
    <div style='margin-bottom: -30px;'>
        <img src='img/login.png' style='width:85px; height:85px;'>
    </div>
    <div  class="first" style='top:20%; left:20%;  width:40%; padding:30px; border-radius: 5px;'>
       
        <h1  style='font-size:14pt;'>Indentificate</h1>

        <?php 
        if(isset($_GET['busqueda'])){
            $busqueda = $_GET['busqueda'];
            echo " <form id='login' method='POST' action='login.php?busqueda=".$busqueda."'>";
        }else{
            echo " <form id='login' method='POST' action='login.php'>";
        }
        
        ?>
        
       
            <table>
                <td>
                    <div class="ui left icon input">
                        <input type="text" name='login_username'placeholder='Usuario' style='font-size: 12pt;'>
                        <i class="user icon"></i>
                    </div>
                </td>
                <tr>
                <td>
                    <div class="ui left icon input">
                        <input type='password' name='login_nip' placeholder='Escriba su NIP' style='font-size: 12pt;'>
                        <i class="lock icon"></i>
                    </div>
                </td>
                <tr>
                <td>    
                <center>  
                
                <input type='submit' value='Entrar' name='login_btn' id='login_btn' class='ui large blue button'><br><br>
                <a href='registrarse.php?r=1'>Registrarse</a>
                </center>     
                
                </td>
            </table>
        </form>
    </div>
</div>
</center>

<?php
//Si lee QR y no esta logueado 
if(isset($_GET['busqueda'])){
    $busqueda = $_GET['busqueda'];
    
    if (isset($_POST['login_btn'])){

        $username = $_POST['login_username'];
        $nip = $_POST['login_nip'];
    
        
    
        $sql="SELECT * FROM usuarios 
        WHERE email='".$username."' and password='".$nip."'";
        echo $sql;
        $r = $conexion -> query($sql); 
        if($f = $r -> fetch_array())	
        {
            if ($f['password']== $nip){
                session_start();
                $_user = $f['idusuario'];	
                global  $_user;
                $_SESSION['_user']=$f['idusuario'];			
                
                
                $infoequipo=detectar();
               // historia($NotITAVU_user,'ACCESO A NOTIFICACION ITAVU: <br>'.$infoequipo.'','LOGIN');			    
                // SESSION_init(session_id(), $NotITAVU_user, session_name(), '');    
                echo '<script>window.location.replace("index.php?busqueda='.$busqueda.'")</script>'; 
            }
            else {
                //historia('','NOTIFICACION ITAVU: Error al loguearse del usuario '.$username.' con el nip '.$nip,'LOGIN');
            }
        }
        else {
            //historia('','NOTIFICACION ITAVU: Intento fallido del usuario '.$username.' con el nip '.$nip,'LOGIN');
            mensaje("ERROR: Usuario ".$username." incorrecto",'login.php?busqueda='.$busqueda.'');
    
        }
    
    }
    
}else{
    if (isset($_POST['login_btn'])){

        $username = $_POST['login_username'];
        $nip = $_POST['login_nip'];
    
       echo 'user'.$username;
       echo 'NIp'.$nip;
    
        $sql="SELECT * FROM usuarios 
        WHERE email='".$username."' and password='".$nip."'";
       echo $sql;
       $r = $conexion -> query($sql); 
       if($f = $r -> fetch_array())	
        {
            if ($f['password']== $nip){
                session_start();
                $_user = $f['idusuario'];	
                global  $_user;
                $_SESSION['_user']=$f['idusuario'];			
                
                
                $infoequipo=detectar();
                //historia($NotITAVU_user,'ACCESO A NOTIFICACION ITAVU: <br>'.$infoequipo.'','LOGIN');			    
                // SESSION_init(session_id(), $NotITAVU_user, session_name(), '');    
                echo '<script>window.location.replace("index.php?home=")</script>'; 
            }
            else {
               // historia('','NOTIFICACION ITAVU: Error al loguearse del usuario '.$username.' con el nip '.$nip,'LOGIN');
            }
        }
        else {
            //historia('','NOTIFICACION ITAVU: Intento fallido del usuario '.$username.' con el nip '.$nip,'LOGIN');
            mensaje("ERROR: Usuario ".$username." incorrecto",'login.php');
    
        }
    
    }
}


?>


<body>






</body>
</html>