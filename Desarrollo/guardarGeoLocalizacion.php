<?php 	require("src/funciones.php"); ?>
<?php 	require("src/config.php"); ?>
<?php

if(isset($_POST['contrato']) and isset($_POST['idcam'])){
    $contrato = $_POST['contrato'];
    $idcam = $_POST['idcam'];
    $lat = $_POST['lat'];
    $long = $_POST['long'];
    $exa = $_POST['exa'];

    $sql = 'UPDATE notificaciones_vivienda SET latitud="'.$lat.'", longitud="'.$long.'", exactitud='.$exa.' WHERE numcontrato="'.$contrato.'" and campaña='.$idcam.'';
    echo $sql;
    $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE) {
        echo 'okey';
    }else{
        echo 'No guarde';
    }
}

?>