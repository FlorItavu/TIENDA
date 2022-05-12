<?php 	include("src/body_head.php");
 ?>
<?php
//SEGURIDAD
session_start();	
// echo "=>".$_SESSION['pdz_username'];

if (isset($_SESSION['NotITAVU_user'])){
		$NotITAVU_user = $_SESSION['NotITAVU_user'];
		//echo $NotITAVU_user;
}
else
{	
	$_SESSION = array(); session_destroy();		    
	header("location:login.php");		
	
}

?>
<?php

$id_aplicacion ="ap27";
$nivel =aplicacion_nivel($id_aplicacion,  $NotITAVU_user);
echo "<center><h5>".app_detalle($id_aplicacion)."</h5></center>";
if(isset($_POST['contrato']) and isset($_POST['campaña'])){


	
	$contrato = $_POST['contrato'];
	$idcam = $_POST['campaña'];
	$nombre = $_POST['nombre'];
	echo "<br>";
	echo '<input type="hidden" id="idcamGeo" name="idcamGeo" value='.$idcam.'>';
	echo '<input type="hidden" id="contratoGeo" name="contratoGeo" value='.$contrato.'>';
	echo '<input type="hidden" id="latitud" name="latitud">';
	echo '<input type="hidden" id="longitud" name="longitud">';
	echo '<input type="hidden" id="exactitud" name="exactitud">';

	// nivel 2 administrador-El solo revisa informacion que se capturo y da visto bueno o regreso 
	if($nivel == 2){
		$query = "select * from notificaciones_vivienda where campaña= '$idcam' and numcontrato='$contrato'"; 
		//echo $query;
		$rc= $conexion -> query($query);
		$numero_registros  = $rc->num_rows;
	
		if($numero_registros >0){			 
			while($f = $rc -> fetch_array()){ 
				echo '<center>';
				echo "<div class='ui form' style='width:90%;'>";
		
					echo '<h1 class="ui dividing header">Notificación '.$f['referenciacampaña'].'-'.$f['numcontrato'].'</h1>';
					echo '<div class="field">';
					echo '<p><b>Nombre: </b>'.$f['nombre'].'</p>';
					echo '<div class="two fields">';
						echo '<div class="field">';
							echo '<label>Fecha Entrega</label>';
							echo "<input type='date' id='fechaEntrega' name='fechaEntrega' value='".$f['fecha_entrega']."' readonly>";
						echo '</div>';
						echo '<div class="field">';
						echo '<label>Fecha Convenio</label>';
							echo "<input type='date' id='fechaConvenio' name='fechaConvenio' value='".$f['fecha_convenio']."' readonly>";
						echo '</div>';
					echo '</div>';
					echo '<div class="field">';
						echo '<label>¿Se entrego la notificación?</label>';
						
						if($f['status']==0){
							echo '<input value="No entregada" readonly>';
						}else if($f['status']==1){
							echo '<input value="Entregada Personalmente" readonly>';
						}else{
							echo '<input value="Entregada" readonly>';
						}	
						
					echo '</div>';

					echo '<div class="field">';
						echo '<label>¿Dondé se entrego la notificación?</label>';
						
						if($f['lugar_entrega']==0){
							echo '<input value="No entregada" readonly>';
						}else if($f['lugar_entrega']==1){
							echo '<input value="Colonia. '.$f['domicilio_colonia'].' Calle. '.$f['domicilio_calles'].'" readonly>';
						}else{
							echo '<input value="Colonia. '.$f['colonia'].' Mza-'.$f['manzana'].' Lote-'.$f['lote'].'" readonly>';
						}	
						
					echo '</div>';

					echo '<div class="field">';
						echo '<label>Estado del lote</label>';
					
						if($f['estado_lote']==1){
							echo '<input value="Comercio" readonly>';
						}else if($f['estado_lote']==2){
							echo '<input value="Habitado" readonly>';							
						}else if($f['estado_lote']==3){
							echo '<input value="Rentado" readonly>';
						}else if($f['estado_lote']==4){
							echo '<input value="Construcción" readonly>';
						}else if($f['estado_lote']==5){
							echo '<input value="Deshabitado" readonly>';
						}else if($f['estado_lote']==6){
							echo '<input value="Mixto" readonly>';
						}
						
					echo '</div>';
						

					//$sql1 = "SELECT * FROM not_documentos WHERE contrato=".$f['numcontrato']." and idcam=".$f['campaña'];
					$sql1 = "SELECT  * FROM not_documentos WHERE contrato=".$f['numcontrato']." and idcam=".$f['campaña']."
					and id=(select id from not_documentos where tipo=2 and contrato=".$f['numcontrato']." and idcam=".$f['campaña']." order by id DESC LIMIT 1 )
					or id=(select id from not_documentos where tipo=1 and contrato=".$f['numcontrato']." and idcam=".$f['campaña']." order by id DESC LIMIT 1 )";


					$rc1= $conexion -> query($sql1); 
					if ($rc1->num_rows>0){
					echo '<div class="field">';
					  echo "<label>Archivos</label>";
					  echo "<table id='archivos' class='ui celled striped table' >";
					  while($r1 = $rc1 -> fetch_array())    
					  {
						echo "<tr>";
							$archivo = "Notificadores/".$r1['doc'].'_'.$r1['nombre']."";
								//href='cp_descarga_archivo.php?ruta=".$archivo."'
								//echo $archivo; 
							$link = "<a id=".$r1['doc']." name='$archivo' href='descargar.php?nombre=".$archivo."' target='_self'  class='digitalizados_vinculos' onclick =''  title='Haga click aqui para descargar'>".$r1['nombre']."</a>";
							echo "<td >".$link;
							if($r1['tipo']==1)
							{$foto= "Foto vivienda";}else{$foto= "Foto notificación";} 
							echo "<br><span style='font-size:7pt;'>subido por ".nitavu_nombre($r1['nitavuSube'])." de ".nitavu_dpto_nombre($r1['nitavuSube'])." -> ".$foto."</span>";
							echo "</td>";//archivo
						
				  
						echo "</tr>";
					  }
					  echo "</table>";
					  echo '</div>';
					}
				  
				  echo "</div>";
		
					echo '<div class="field">';
						echo '<label>Comentarios</label>';
						echo '<textarea id="comentarios" name="comentarios" readonly>'.comentariosDelNotificador($f['campaña'], $f['numcontrato']).'</textarea>';
					echo '</div>';

					echo '<div class="ui modal">';
						echo '<i class="close icon"></i>';
						echo '<div class="field">';
							echo "<form action='index.php' method='POST' class='ui form' >";
							echo '<center>';
							echo '<label>Observaciones</label>';
							echo '<input type="hidden" id="idcamD" name="idcamD" value='.$f['campaña'].'>';
							echo '<input type="hidden" id="contratoD" name="contratoD" value='.$f['numcontrato'].'>';
							echo '<textarea id="observaciones" name="observaciones" required></textarea>';
							echo "<input type='submit' id='guardar' value='Guardar' class='ui button'>";
							echo "</center>";
							echo '</form>';
						echo "</div>";
					echo '</div>';

					echo '<div class="ui buttons">';
						//echo '<button class="ui button">Cancel</button>';
						echo "<input type='submit' id='guardar' value='Devolver al notificador' class='ui button' onclick='showmodal()'>";
						echo '<div class="or"></div>';
						//echo '<button class="ui positive button">Save</button>';
						echo "<form action='index.php' method='POST'>";
							echo '<input type="hidden" id="idcamVo" name="idcamVo" value='.$f['campaña'].'>';
							echo '<input type="hidden" id="contratoVo" name="contratoVo" value='.$f['numcontrato'].'>';
							echo "<input type='submit' id='guardar' value='Dar visto Bueno' class='ui positive button'>";
						echo "</form>";
					echo '</div>';
			
				echo "</div>";
				echo '</center>';
					
			}
		}
	}

	//nivel 3 notificador El captura informacion 
	if($nivel == 3){
		echo "<br>";
		if(existeComentarioDelAdministrador($idcam, $contrato)!='FALSE'){

			$query = "select * from notificaciones_vivienda where campaña= '$idcam' and numcontrato='$contrato'"; 
			//echo $query;
			$rc= $conexion -> query($query);
			$numero_registros  = $rc->num_rows;
		
			if($numero_registros >0){			 
				while($f = $rc -> fetch_array()){ 
					echo '<center>';
					echo "<div class='ui form' style='width:90%;'>";
					echo "<form method='POST' action='index.php' enctype='multipart/form-data' class='ui form' style='width:90%;'>";
						echo '<h1 class="ui dividing header">Notificación '.$f['referenciacampaña'].'-'.$f['numcontrato'].'</h1>';
						echo '<input type="hidden" id="contrato" name="contrato" value='.$contrato.'>';
						echo '<input type="hidden" id="idcam" name="idcam" value='.$idcam.'>';
						echo '<div class="field">';
						echo '<p><b>Nombre: </b>'.$f['nombre'].'</p>';
						echo '<div class="two fields">';
							echo '<div class="field">';
								echo '<label>Fecha Entrega</label>';
								echo "<input type='date' id='fechaEntrega' name='fechaEntrega' value='".$f['fecha_entrega']."'>";
							echo '</div>';
							echo '<div class="field">';
							echo '<label>Fecha Convenio</label>';
								echo "<input type='date' id='fechaConvenio' name='fechaConvenio' value='".$f['fecha_convenio']."'>";
							echo '</div>';
						echo '</div>';
						echo '<div class="field">';
							echo '<label>¿Se entrego la notificación?</label>';
							echo '<select id="recibido" name="recibido" class="ui search dropdown">';
							if($f['status']==0){
								echo '<option value="0" selected>No entregada</option>';
								echo '<option value="1">Entregada Personalmente</option>';
								echo '<option value="2">Entregada</option>';
							}else if($f['status']==1){
								echo '<option value="0" >No entregada</option>';
								echo '<option value="1" selected>Entregada Personalmente</option>';
								echo '<option value="2">Entregada</option>';
							}else{
								echo '<option value="0" >No entregada</option>';
								echo '<option value="1" >Entregada Personalmente</option>';
								echo '<option value="2" selected>Entregada</option>';
							}
							echo '</select>';							
						echo '</div>';

						echo '<div class="field">';
							echo '<label>¿Dondé se entrego la notificación?</label>';
							echo '<select id="lugarEntrega" name="lugarEntrega" class="ui search dropdown">';
							if($f['lugar_entrega']==0){
								echo '<option value="0" selected>No entregada</option>';
								echo '<option value="1">"Colonia. '.$f['domicilio_colonia'].' Calle. '.$f['domicilio_calles'].'"</option>';
								echo '<option value="2">"Colonia. '.$f['colonia'].' Mza-'.$f['manzana'].' Lote-'.$f['lote'].'"</option>';
							}else if($f['lugar_entrega']==1){
								echo '<option value="0">No entregada</option>';
								echo '<option value="1" selected>"Colonia. '.$f['domicilio_colonia'].' Calle. '.$f['domicilio_calles'].'"</option>';
								echo '<option value="2">"Colonia. '.$f['colonia'].' Mza-'.$f['manzana'].' Lote-'.$f['lote'].'"</option>';
							}else{
								echo '<option value="0">No entregada</option>';
								echo '<option value="1">"Colonia. '.$f['domicilio_colonia'].' Calle. '.$f['domicilio_calles'].'"</option>';
								echo '<option value="2" selected>"Colonia. '.$f['colonia'].' Mza-'.$f['manzana'].' Lote-'.$f['lote'].'"</option>';
							}
								echo '</select>';
							
						echo '</div>';

						echo '<div class="field">';
						echo '<label>Estado del lote</label>';
						echo '<select id="estadoLote" name="estadoLote" class="ui search dropdown">';
						if($f['estado_lote']==1){
							echo '<option value="1" selected>Comercio</option>';
							echo '<option value="2">Habitado</option>';
							echo '<option value="3">Rentado</option>';
							echo '<option value="4">Construcción</option>';
							echo '<option value="5">Deshabitado</option>';
							echo '<option value="6">Mixto</option>';
						}else if($f['estado_lote']==2){
							echo '<option value="1" >Comercio</option>';
							echo '<option value="2" selected>Habitado</option>';
							echo '<option value="3">Rentado</option>';
							echo '<option value="4">Construcción</option>';
							echo '<option value="5">Deshabitado</option>';
							echo '<option value="6">Mixto</option>';
						}else if($f['estado_lote']==3){
							echo '<option value="1" >Comercio</option>';
							echo '<option value="2" >Habitado</option>';
							echo '<option value="3" selected>Rentado</option>';
							echo '<option value="4">Construcción</option>';
							echo '<option value="5">Deshabitado</option>';
							echo '<option value="6">Mixto</option>';
						}else if($f['estado_lote']==4){
							echo '<option value="1" >Comercio</option>';
							echo '<option value="2" >Habitado</option>';
							echo '<option value="3" >Rentado</option>';
							echo '<option value="4" selected>Construcción</option>';
							echo '<option value="5">Deshabitado</option>';
							echo '<option value="6">Mixto</option>';
						}else if($f['estado_lote']==5){
							echo '<option value="1" >Comercio</option>';
							echo '<option value="2" >Habitado</option>';
							echo '<option value="3" >Rentado</option>';
							echo '<option value="4" >Construcción</option>';
							echo '<option value="5" selected>Deshabitado</option>';
							echo '<option value="6">Mixto</option>';
						}else if($f['estado_lote']==6){
							echo '<option value="1" >Comercio</option>';
							echo '<option value="2" >Habitado</option>';
							echo '<option value="3" >Rentado</option>';
							echo '<option value="4" >Construcción</option>';
							echo '<option value="5" >Deshabitado</option>';
							echo '<option value="6" selected>Mixto</option>';
						}
						echo '</select>';
					echo '</div>';

					if($f['nombreprop_actual']!=''){
						echo '<div class="field">';
							echo '<label>Nombre del propietario</label>';
							echo "<input type='text' name='propietario' id='propietario' value='".$f['nombreprop_actual']."'>";
						echo "</div>";
					}

						$sql1 = "SELECT  * FROM not_documentos WHERE contrato=".$f['numcontrato']." and idcam=".$f['campaña']."
						and id=(select id from not_documentos where tipo=2 and contrato=".$f['numcontrato']." and idcam=".$f['campaña']." order by id DESC LIMIT 1 )
						or id=(select id from not_documentos where tipo=1 and contrato=".$f['numcontrato']." and idcam=".$f['campaña']." order by id DESC LIMIT 1 )";
						
						$rc1= $conexion -> query($sql1); 
						if ($rc1->num_rows>0){
						echo '<div class="field">';
							echo "<label>Archivos</label>";
						
							echo "<table id='archivos' class='ui celled striped table'>";
							while($r1 = $rc1 -> fetch_array())    
							{
								echo "<tr>";
								$archivo = "Notificadores/".$r1['doc'].'_'.$r1['nombre']."";
								//href='cp_descarga_archivo.php?ruta=".$archivo."'
								//echo $archivo; 
								$link = "<a id=".$r1['doc']." name='$archivo' href='descargar.php?nombre=".$archivo."' target='_self'  class='digitalizados_vinculos' onclick =''  title='Haga click aqui para descargar'>".$r1['nombre']."</a>";
								echo "<td >".$link;
								if($r1['tipo']==1)
								{$foto= "Foto vivienda";}else{$foto= "Foto notificación";} 
								echo "<br><span style='font-size:7pt;'>subido por ".nitavu_nombre($r1['nitavuSube'])." de ".nitavu_dpto_nombre($r1['nitavuSube'])." -> ".$foto."</span>";
								echo "</td>";//archivo
						
								echo "</tr>";
							}
							echo "</table>";
						echo '</div>';
						}
					
						echo "</div>";

						echo '<div class="field">';
						echo "<label>Suba la Foto de la vivienda</label>";
						echo '<input id="fotoCasa" name="fotoCasa" type="file" >';
						echo '</div>';

						echo '<div class="field">';
						echo "<label>Suba la foto de la notificación firmada de recibido</label>";
						echo '<input id="fotoArchivo" name="fotoArchivo" type="file"  >';
						echo '</div>';

				
						echo '<div class="field">';
						//$comentarios = $f['comentarios'];
							//echo comentariosDelNotificador($f['campaña'], $f['numcontrato']);
							echo '<label>Observaciones</label>';
							echo '<textarea readonly>'.existeComentarioDelAdministrador($f['campaña'], $f['numcontrato']).'</textarea>';
							echo '<label>Comentarios</label>';
							echo '<textarea id="comentarios" name="comentarios" required></textarea>';
						echo '</div>';

						
						echo "<input type='submit' id='guardar' value='Guardar' class='ui button'>";

					echo "</from>";
					echo "</div>";
					echo '</center>';
						
				}
			}
		}else{
			echo '<center>';
			echo "<form method='POST' action='index.php' enctype='multipart/form-data' class='ui form' style='width:90%;'>";
				
				echo '<h1 class="ui dividing header">Notificadores</h1>';
				echo '<input type="hidden" id="contrato" name="contrato" value='.$contrato.'>';
				echo '<input type="hidden" id="idcam" name="idcam" value='.$idcam.'>';
				
				echo '<div class="field">';
					echo '<p><b>Número de Contrato: </b>'.$contrato.'</p>';
					echo '<p><b>Nombre: </b>'.$nombre.'</p>';
					echo '<div class="two fields">';
						echo '<div class="field">';
							echo '<label>Fecha Entrega</label>';
							echo "<input type='date' id='fechaEntrega' name='fechaEntrega' value='".$fecha."' required>";
						echo '</div>';
						echo '<div class="field">';
						echo '<label>Fecha Convenio</label>';
							echo "<input type='date' id='fechaConvenio' name='fechaConvenio' value='".$fecha."'>";
						echo '</div>';
					echo '</div>';

					
					echo '<div class="field">';
						echo '<label>¿Se entrego la notificación?</label>';
						echo '<select id="recibido" name="recibido" class="ui search dropdown">
							<option value="0">No entregada</option>
							<option value="1">Entregada Personalmente</option>
							<option value="2">Entregada</option>
						</select>';
					echo '</div>';
			
					echo '<div class="field">';
						echo '<label>¿Dondé se entrego la notificación?</label>';
						echo '<select id="lugarEntrega" name="lugarEntrega" class="ui search dropdown">
							<option value="0">No entregada</option>
							<option value="1">Domicilio: '.traerDomicilioNotificacion($idcam, $contrato).'</option>
							<option value="2">Lote: '.traerDomicilioLoteNotificacion($idcam, $contrato).'</option>
						</select>';
					echo '</div>';

					echo '<div class="field">';
						echo '<label>Estado del lote</label>';
						echo '<select id="estadoLote" name="estadoLote" class="ui search dropdown">
							<option value="1">Comercio</option>
							<option value="2">Habitado</option>
							<option value="3">Rentado</option>
							<option value="4">Construcción</option>
							<option value="5">Deshabitado</option>
							<option value="6">Mixto</option>
						</select>';
					echo '</div>';

					echo '<div class="field">';
					
						echo '<div class="ui form">
							<div class="inline fields">
							<label>¿Es el propietario: '.$nombre.'?</label>
								<div class="field">
								<div class="ui radio checkbox">
									<input type="radio" name="propietario" id="siespropietario" onclick="quitarInputNombre()">
									<label>Si</label>
								</div>
								</div>
								<div class="field">
								<div class="ui radio checkbox">
									<input type="radio" name="propietario" id="noespropietario" onclick="mostrarInputNombre()">
									<label>No</label>
								</div>
								</div>';
								echo '<div class="field" id="nombrePropietario" style="display:none; width: 100%;">';
									echo '<label>Nombre del propietario</label>';
									echo "<input type='text' name='propietario' id='propietario' style='width: 100%;'>";
								echo "</div>";

							echo '</div>';
							
						echo '</div>';
					echo "</div>";
					
					
		   

				echo '<div class="field">';
					echo '<label>Comentarios</label>';
					echo '<textarea id="comentarios" name="comentarios" required></textarea>';
				echo '</div>';
				
				echo '<div class="field">';
				echo "<label>Suba la Foto de la vivienda</label>";
				echo '<input id="fotoCasa" name="fotoCasa" type="file" required>';
				echo '</div>';

				echo '<div class="field">';
				echo "<label>Suba la foto de la notificación firmada de recibido</label>";
				echo '<input id="fotoArchivo" name="fotoArchivo" type="file"  required>';
				echo '</div>';

				echo "<input type='submit' id='guardar' value='Guardar' class='ui button' onclick='mostrarUbicacion()'>";
			echo "</form>";
			echo '</center>';
		}
		
	}

}


?>
<br>
<br>
<br>
<?php 	include("src/body_footer.php"); ?>

<script type="text/javascript">

function showmodal(){
	$('.ui.modal')
		.modal('show')
	;
}

function mostrarInputNombre(){
	
	//alert(id);
	//if($('input:radio[name=propietario]:checked')==true){
if($("#propietario").prop("checked", true)){
		//alert('entre');
		$("#nombrePropietario").css({'display':'inline-block',});
	}else{
		$("#nombrePropietario").css({'display':'none',});
	}

	
	
	
}


function quitarInputNombre(){
	
	//alert(id);
	//if($('input:radio[name=propietario]:checked')==true){
if($("#propietario").prop("checked", true)){
		//alert('entre');
		$("#nombrePropietario").css({'display':'none',});
	}else{
		$("#nombrePropietario").css({'display':'none',});
	}

	
	
	
}

	if ("geolocation" in navigator){ 
		navigator.geolocation.getCurrentPosition(function(position){ 
			console.log("Found your location nLat : "+position.coords.latitude+" nLang :"+ position.coords.longitude);
			var latitud = position.coords.latitude;
			var longitud = position.coords.longitude;
			var exactitud = position.coords.accuracy;	
			document.getElementById('latitud').value = latitud;
			document.getElementById('longitud').value =longitud;
			document.getElementById('exactitud').value =exactitud;
			//alert('valores'+idcam+'-'+contrato);
			
		});
	}else{
		console.log("Browser doesn't support geolocation!");
	}
      
	
	function mostrarUbicacion(contrato, idcam) {
		contrato = document.getElementById('contratoGeo').value;
		idcam =document.getElementById('idcamGeo').value;
		latitud = document.getElementById('latitud').value;
		longitud =document.getElementById('longitud').value;
		exactitud= document.getElementById('exactitud').value;	
		$.ajax({
		url: "guardarGeoLocalizacion.php",
		type: "post",
		data: {contrato: contrato, idcam: idcam, lat: latitud, long: longitud, exa: exactitud },
		success: function(data){
			console.log('éxito');
			
		}
		});
				
	}	

</script>

