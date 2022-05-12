<?php
/*
_   _         _    _   __  _                     _                 _____  _____   ___   _   _  _   _ 
| \ | |       | |  (_) / _|(_)                   (_)               |_   _||_   _| / _ \ | | | || | | |
|  \| |  ___  | |_  _ | |_  _   ___   __ _   ___  _   ___   _ __     | |    | |  / /_\ \| | | || | | |
| . ` | / _ \ | __|| ||  _|| | / __| / _` | / __|| | / _ \ | '_ \    | |    | |  |  _  || | | || | | |
| |\  || (_) || |_ | || |  | || (__ | (_| || (__ | || (_) || | | |  _| |_   | |  | | | |\ \_/ /| |_| |
\_| \_/ \___/  \__||_||_|  |_| \___| \__,_| \___||_| \___/ |_| |_|  \___/   \_/  \_| |_/ \___/  \___/ 
  
FUNCIONES PARA LA NOTIFICACION

*/

function campañactiva(){
    require("config.php"); /*No mover*/
    $sql = " -- not 
    SELECT * FROM notificaciones_vivienda WHERE activo=0 LIMIT 1";
    $rc= $conexion -> query($sql);
        if($f = $rc -> fetch_array())
        {
            return $f['referenciacampaña'];
                                
        }
        else
        {
            return 'FALSE';
        }
    }


    function numdeDocumento($consulta){
        require("config.php");
        $sql = "SELECT * FROM contadores WHERE id='0'";
        $rc= $conexion -> query($sql);
        if($f = $rc -> fetch_array()){
            if ($consulta==TRUE) {
                return $f['NumArchivo'];
            }else{ // sino es consulta entonces aumentarle y aumentar el contador 
                $n2 = $f['NumArchivo'] + 1;
                $sql="UPDATE contadores SET NumArchivo='".$n2."' WHERE id='0'";
                $resultado = $conexion -> query($sql);
                if ($conexion->query($sql) == TRUE) {
                    return TRUE;
                }else{
                    return  FALSE;
                }
            }
        }else{ 
            return FALSE;
        }
    }

    function traerDomicilioNotificacion($idcam, $contrato){
        require("config.php");

        $sql = "-- not 
        SELECT * FROM notificaciones_vivienda WHERE campaña=".$idcam." and numcontrato = ".$contrato."";
        //echo $sql;
        $rc= $conexion -> query($sql);
        if($f = $rc -> fetch_array())
        {
            return 'Colonia. '.$f['domicilio_colonia'].' Calle. '.$f['domicilio_calles'];              
        }
        else
        {
            return 'FALSE';
        }
    }

    function traerDomicilioLoteNotificacion($idcam, $contrato){
        require("config.php");

        $sql = " -- not 
        SELECT * FROM notificaciones_vivienda WHERE campaña=".$idcam." and numcontrato = ".$contrato."";
        
        //echo $sql;
        $rc= $conexion -> query($sql);
        if($f = $rc -> fetch_array())
        {
            return 'Colonia. '.$f['colonia'].' Mza-'.$f['manzana'].' Lote-'.$f['lote'];              
        }
        else
        {
            return 'FALSE';
        }
    }

    function obtenerDocumentos($idcam,$numcontrato){
    require("config.php");
        
        $sql = "select doc, nombre from not_documentos
            where idcam=".$idcam." and contrato=".$numcontrato."";    
        // echo $sql;
        $doc='';
        //echo $sql;
        $r = $conexion -> query($sql); 
        $res  = $r->num_rows;
        //echo $res;
        if($res>0){
            while($f = $r -> fetch_array()){
                $doc= $doc.$f['doc'].'_'.$f['nombre'].'/';
            }
            $doc= trim($doc, '/');    
            $docs = explode('/',$doc);
            
            return $docs;	
        }
        
 
    }

    function traerComentariosAnteriores($idcam, $numcontrato){
        require("config.php");
        
        $sql = "select comentarios from notificaciones_vivienda where campaña=".$idcam." and numcontrato=".$numcontrato."";    

       // echo $sql;
        $rc= $conexion -> query($sql);
        if($f = $rc -> fetch_array())
        {
            return $f['comentarios'];              
        }else{
            return 'FALSE';
        }
    }

    function existeComentarioDelAdministrador($idcam, $contrato){
        require("config.php");
        
        $sql = "select comentarios from notificaciones_vivienda where campaña=".$idcam." and numcontrato=".$contrato."";    

        //echo $sql;
        $rc= $conexion -> query($sql);
        
        if($f = $rc -> fetch_array())
        {
            $comentario = $f['comentarios'];              
        }else{
            $comentario = 'FALSE';
        }

        $pos = strpos($comentario, '/');
        $resultado = substr($comentario, $pos+1);

        if ($pos === false) {
            return 'FALSE';
        } else {
            return $resultado;
        }

    }

    function comentariosDelNotificador($idcam, $contrato){
        require("config.php");
        
        $sql = "select comentarios from notificaciones_vivienda where campaña=".$idcam." and numcontrato=".$contrato."";    

        //echo $sql;
        $rc= $conexion -> query($sql);
        
        if($f = $rc -> fetch_array())
        {
            $comentario = $f['comentarios'];              
        }else{
            $comentario = 'FALSE';
        }


        $pos = strpos($comentario, '/');
        $resultado = substr($comentario,0, $pos);

        if ($pos === false) {
            return $comentario;
            //return 'FALSE';
        } else {
            return $resultado;
        }

    }
?>