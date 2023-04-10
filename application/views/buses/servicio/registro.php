<?php
    // var_dump($servicio);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Servicios de bus</title>
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
						<div class="panel-heading">Detalles del servicio</div>
						<div class="panel-body" id="form_container">
                            <input type="hidden" name="id_servicio" value="<?=@$servicio['id_servicio']?$servicio['id_servicio']:0;?>" />
							<div class="col-md-6">
								<div class="panel panel-info">
									<div class="panel-heading">Detalles del servicio en español</div>
									<div class="panel-body ">
										<div class="form-group">
											<label class="control-label col-sm-4" >Nombre del servicio:</label>
											<div class="col-sm-8">
											<input type="text" value="<?=@$servicio['nombre_servicio'];?>" name="nombre_servicio_es" required  class="form-control" >
											</div>
										</div>
										<br><br>
										<div class="form-group">
											<label class="control-label col-sm-4">Detalles del servicio:</label>
											<div class="col-sm-8"> 
												<textarea name="descripcion_servicio_es" required class="form-control"><?=@$servicio['descripcion_servicio'];?></textarea>
											</div>
										</div>
										<br>
										<br>
										<hr>
										<button class="btn btn-success pull-right" type="button" id="enviar_btn"><?=@$servicio['id_servicio']?'Actualizar':'Registrar';?></buttton>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-info">
									<div class="panel-heading">Detalles del servicio en otros idiomas</div>
									<div class="panel-body">
									<?php
                                        $html = null;
                                        // si servicio existe caso se edite;
                                        if(@$servicio){
                                            $nombre_traducciones = json_decode($servicio['nombre_traducciones'],true);
                                            $descripcion_traducciones = json_decode($servicio['descripcion_traducciones'],true);
                                        }
                                        
										foreach($idiomas as $value){
                                            // if($value['codigo']=='es')continue;
											$html .= '
                                            <fieldset>
                                            <legend>'.$value['pais'].'</legend>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Nombre del servicio:</label>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" value="'.@$nombre_traducciones[$value['codigo']].'" name="nombre_servicio['.$value['codigo'].']">
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Detalles del servicio:</label>
                                                <div class="col-sm-8"> 
                                                    <textarea class="form-control" name="descripcion_servicio['.$value['codigo'].']">'.trim(@$descripcion_traducciones[$value['codigo']]).'</textarea>
                                                </div>
                                            </div>
                                            </fieldset>
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
        $('#enviar_btn').click(function(){
            var inputs = $('#form_container input,#form_container textarea');
                //console.log(inputs.serializeArray());
                var validador = true; 
                inputs.each(function(){
                    if ($(this).attr('required') && !$(this).val()){
                        validador = false;
                        $(this).css('border-color','red');
                    }
                });

            if(!validador)return;
            $.post('<?=base_url('buses/servicio/guardar');?>',inputs.serializeArray(),function(result){
                if(!isNaN(result)){
					alert('Guardado correctamente');
					location.href='<?=base_url('buses/servicio');?>';
				}
                else alert('Error al guardar intente de nuevo');
            });
            
        });
    </script>
</html>