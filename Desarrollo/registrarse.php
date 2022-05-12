<?php 	require("src/funciones_heredadas.php"); ?>
<?php 	require("src/funciones.php"); ?>
<?php 	require("src/config.php"); ?>
<?php include("./src/body_head.php");?>
<!DOCTYPE html>
<html>

<body>
    <!--REGISTRAR NUEVO USUARIO -->
    <?php
    
    if ($_GET['r']){

        echo '<center>
        <form class="ui form" style="width:80%;" method="POST" action="registrarse.php">
          <div class="field">
            <label>Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre completo">
          </div>
          <div class="field">
            <label>Email</label>
            <input type="text" name="email" placeholder="Correo">
          </div>
          <div class="field">
            <label>Contraseña</label>
            <input type="text" name="password" placeholder="Contraseña">
          </div>
          
          <button class="ui button" type="submit">Guardar</button>
        </form>
        </center>';

    }else{




        if(isset($_POST['nombre']) and isset($_POST['email']) and isset($_POST['password'])){
            $nombre = $_POST['nombre'];
            $email =  $_POST['email'];
            $password = $_POST['password'];
            
            $sql = "INSERT INTO usuarios(idusuario, nombre, password, hash, email, fechacrea)
                VALUES ('', '$nombre', '$password', '', '$email', '$fecha')";
                echo $sql;
                if ($conexion->query($sql) == TRUE){
                    mensaje('Se ha registrado con éxito el nuevo usuario.', 'login.php');
                }
        } else{
            mensaje('Ocurrio un error, favor de intentarlo nuevamente.', 'registrarse.php?r=1');
        }
    }

?>


</body>

</html>
<?php include("./src/body_footer.php");?>