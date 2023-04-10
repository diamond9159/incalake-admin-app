<?php
	 //var_dump($servicio_adicional);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Agregar y editar Servicios adicionales</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
    <link href="<?=base_url()?>/recursos/css/fontawesome-iconpicker.min.css" rel="stylesheet">
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');

			?>
		</header>
		<content>
			<div class="container">
				<div class="panel-group">
					<div class="panel panel-primary">
						<div class="panel-heading">Detalles del servicio adicional</div>
						<div class="panel-body" id="form_container">
                            <input type="hidden" name="id_servicio_adicional" value="<?=@$servicio_adicional['id_servicio_adicional']?$servicio_adicional['id_servicio_adicional']:0;?>" />
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-heading">Detalles del servicio en español</div>
									<div class="panel-body ">
										<div class="form-group">
											<label class="control-label col-sm-4" >Nombre del servicio:</label>
											<div class="col-sm-8">
											<input type="text" value="<?=@$servicio_adicional['nombre_servicio_adicional'];?>" name="nombre_servicio_es" required  class="form-control" >
											</div>
										</div>
										<br><br>
										<div class="form-group">
											<label class="control-label col-sm-4">Icono del servicio adicional:</label>
											<div class="col-sm-8"> 
												<select id="icono_servicio" class="form-control" data-value="<?=@$servicio_adicional['icono_servicio_adicional'];?>" required name="icono_servicio">
													<option value="">-- Seleccione --</option>
													<option value="alarm-clock">Reloj</option>
													<option value="armchair">Sillón</option>
													<option value="bathtub">Bañera</option>
													<option value="bed">Cama</option>
													<option value="bellboy">Botones</option>
													<option value="chair">Silla</option>
													<option value="chandelier">Candelabro</option>
													<option value="chimney">Chimenea</option>
													<option value="closet">Closet</option>
													<option value="cocktail">Coctel</option>
													<option value="coffee-maker">Cafetera</option>
													<option value="credit-card">Tarjeta de credito</option>
													<option value="cup">Taza</option>
													<option value="cushion">Cojin</option>
													<option value="cutlery">Cubiertos</option>
													<option value="door">Puerta</option>
													<option value="dumbbell">Pesas</option>
													<option value="elevator">Elevador</option>
													<option value="hair-dryer">Secadora</option>
													<option value="iron">Plancha</option>
													<option value="knob">Pomo</option>
													<option value="lamp">Lampara</option>
													<option value="mirror">Espejo</option>
													<option value="mobile-phone">Celular</option>
													<option value="modem">Modem WIFI</option>
													<option value="newspaper">Periodico</option>
													<option value="nightstand">Mesita</option>
													<option value="palm-tree">Palmera</option>
													<option value="perfume">Perfume</option>
													<option value="plant">Planta con maceta</option>
													<option value="razor">Rasuradora</option>
													<option value="reception">Recepcion postre</option>
													<option value="remote-control">Control remoto</option>
													<option value="room-key">Llave de cuarto</option>
													<option value="room-service">Servicio de cuarto</option>
													<option value="safebox">Caja fuerte</option>
													<option value="shampoo">Shampoo</option>
													<option value="sink">Fregadero</option>
													<option value="soap">Jabón</option>
													<option value="suitcase">Maleta</option>
													<option value="swimming-pool">Piscina</option>
													<option value="television">Televisor</option>
													<option value="tennis">Raqueta de tenis</option>
													<option value="toilet">Inodoro</option>
													<option value="toothbrush">Cepillo de dientes</option>
													<option value="toothpaste">Pasta de dientes</option>
													<option value="towel">Toalla</option>
													<option value="vacuum-cleaner">Aspiradora</option>
													<option value="washing-machine">Lavadora</option>
													<option value="window">Ventana</option>
												</select>
											</div>
										</div>
										<br>
										<br>
										<hr>
										<button class="btn btn-success pull-right" type="button" id="enviar_btn"><?=@$servicio_adicional['id_servicio_adicional']?'Actualizar':'Registrar';?></buttton>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-heading">Nombres del servicio adicional en otros idiomas</div>
									<div class="panel-body">
									<?php
                                        $html = null;
                                        // si servicio existe caso se edite;
                                        if(@$servicio_adicional){
                                            $traducciones_servicio_adicional = json_decode($servicio_adicional['traducciones_nombre'],true);
                                        }
                                        
										foreach($idiomas as $value){
                                            // if($value['codigo']=='es')continue;
											$html .= '
                                            <div class="form-group">
												<label class="control-label col-md-4">'.strtoupper($value['pais']).':</label>
												<div class="col-md-8">
													<input type="text" class="form-control" value="'.@$traducciones_servicio_adicional[$value['codigo']].'" name="nombre_servicio['.$value['codigo'].']">
												</div>
                                            </div>
											<br><br>
										';
										}
										echo $html;
									?>

									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
    </body>
    <script>
		(function(){
			$('#enviar_btn').click(function(){
				var inputs = $('#form_container input,#form_container select');
					//console.log(inputs.serializeArray());
					var validador = true; 
					inputs.each(function(){
						if ($(this).attr('required') && !$(this).val()){
							validador = false;
							$(this).css('border-color','red');
						}
					});
				if(!validador)return;
				$.post('<?=base_url('buses/servicios_adicionales/guardar');?>',inputs.serializeArray(),function(result){
					console.log(result);
					if(!isNaN(result)){
						alert('Guardado correctamente');
						location.href='<?=base_url('buses/servicios_adicionales');?>';
					}
					else alert('Error al guardar intente de nuevo');
				});
				
			});
		// set default value icono_servicio
			var icono_servicio = $('#icono_servicio');
			icono_servicio.val(icono_servicio.data('value'));
		})();
        
    </script>
</html>