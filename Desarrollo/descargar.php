<?php
require ("src/funciones.php");
require ("src/funciones_heredadas.php");
ob_end_clean();
if (isset($_GET['nombre'])){
    $archivo = $_GET['nombre'];
    if (FTP_existe_archivo($archivo)=="TRUE"){
        if (FTP_descargar($archivo)=="TRUE"){
           $file = "tmp/".$archivo;//nombre;
            header('Content-Disposition: attachment; filename="' . $file .'"'); 
            //header("Content-disposition: attachment; filename=$file");
            header("Content-type: application/octet-stream");
            readfile($file);
        }else{
            echo "No lo puede descargar";
        }
    }else{				
        echo "No existe el archivo";//archivo
    }
}else{
    echo 'no recibi nombre';
}
?>