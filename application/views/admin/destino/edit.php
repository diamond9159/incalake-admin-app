<div class="container-fluid">
	<div class="row">		
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="headline">
				<div><span class="fa fa-list"></span> AGREGAR NUEVO DESTINO</div> 
			</div>	
			<?php 
				//echo json_encode($imagen_slider)."<br/>";
				//echo json_encode($imagen_normal)."<r/>";
			?>
		<?php echo form_open('admin/destinos/edit/'.$destino[0]['id_destino'].'/'.$destino[0]['id_codigo_destino'],array("class"=>"form-horizontal","id" => "form_edit_destinos")); ?>
			<?php 
				$helpBlock = true; 
				$autofocus = 'autofocus';
				$replicate = 'txt_search_gogle';
			?>
			<?php
				// echo json_encode($idiomas) 
			?>
			<div class="row">
			<?php foreach ($idiomas as $key => $value): ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
					<?php echo validation_errors(); ?>	
						<div class="panel panel-success">
						<div class="panel-heading"><strong><span class="fa fa-list"></span> Descripción del destino en <?=$value['pais'];?></strong></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="container-fluid">
											<div class="form-group">
												<label for="" class=""><span class="div-numeracion">1</span> Nombre en común de las Actividades</label>
												<input type="text" name="txt_nombre_destino_<?=strtolower($value['codigo']);?>" <?=$autofocus;?> class="form-control validate[required]" id="txt_nombre_destino_<?=strtolower($value['codigo']);?>" placeholder="Ingrese nombre común de sus actividades" value="<?php echo ($this->input->post('txt_nombre_destino_'.strtolower($value['codigo'])) ? $this->input->post('txt_nombre_destino_'.strtolower($value['codigo'])) : @$destino[$key]['descripcion_destino']); ?>"/>
												<?php if ($helpBlock): ?>
												<p class="help-block alert alert-info"><span class="fa fa-hand-o-up"></span> Ingrese un nombre que describa su grupo de actividades. Ejemplo: Tour en el Lago Titicaca; Tours en Cusco, Tours en Bolivia</p>
												<?php endif ?>
											</div>
										</div>
										<div class="container-fluid">
											<div class="form-group">
												<label for="" class=""><span class="div-numeracion">2</span>Ubicación de la Actividades Turísticas</label>
												<input type="text" name="txt_uri_destino_<?=strtolower($value['codigo']);?>" class="form-control validate[required]  <?=$replicate;?>" id="txt_uri_destino_<?=strtolower($value['codigo']);?>" placeholder="Ingrese ubicación donde están situado sus actividades" value="<?php echo ($this->input->post('txt_uri_destino_'.strtolower($value['codigo'])) ? $this->input->post('txt_uri_destino_'.strtolower($value['codigo'])) : @$destino[$key]['nombre_destino']); ?>"/>
												<?php if ($helpBlock): ?>
												<p class="help-block alert alert-info"><span class="fa fa-hand-o-up"></span> Ingrese una ubicación en donde se encuentre su grupo de actividades. Ejemplo: Tour en el Lago Titicaca esta ubicado en la región de PUNO; Tours en Cusco esta ubicado en CUSCO, Tours en Bolivia esta ubicado en BOLIVIA</p>										
												<?php endif ?>
											</div>
											<input type="hidden" name="txt_idioma_<?=strtolower($value['codigo']);?>" id="txt_idioma_<?=strtolower($value['codigo']);?>" value="<?=$value['id_idioma'];?>" />
											<input type="hidden" name="txt_id_destino_<?=strtolower($value['codigo']);?>" id="txt_id_destino_<?=strtolower($value['codigo']);?>" value="<?=@$destino[$key]['id_destino'];?>">
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				<?php 
					$helpBlock = false; 
					$autofocus = '';
					$replicate = "txt_ubicacion_replicate";
				?>
			<?php endforeach ?>
			</div>
			<hr/>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="container-fluid">
							<div class="form-group">
								<label><span class="div-numeracion">1</span> Seleccione una imagen para mostrar en la cabecera de la página web</label>
								<div class="galeriaDivs">
									<button onclick="openGaleria($(this),1,this.innerText); return false;"  class="btn btn-success"><span class="fa fa-search-plus"></span> Buscar Imagen destacada</button>
									<input type="text" style="padding:5px;border-radius:5px;border:1px solid #CCC;" class="inputImagenModal validate[required]" value="<?=@$imagen_slider[0]['data']['url_archivo'];?>" readonly />
									<input type="hidden" class="inputHideImagenModal" name="txt_id_imagen_slider"  id="txt_id_imagen_slider" value="<?=@$imagen_slider[0]['id_imagen'];?>"/>
					 			</div>
								<p class="help-block"><span class="fa fa-hand-o-up"> La imágen se utilizará en forma de slider, asegúrese de que la imágen tenga las medidas necesarias</span></p>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-md-6 col-sm-12">
						<div class="container-fluid">
							<div class="form-group">
								<label><span class="div-numeracion">2</span> Seleccione una imagen para respresentar el destino</label>
								<div class="galeriaDivs">
									<button onclick="openGaleria($(this),3,this.innerText); return false;"  class="btn btn-success"><span class="fa fa-search-plus"></span> Buscar Imagen destacada</button>
									<input type="text" style="padding:5px;border-radius:5px;border:1px solid #CCC;" class="inputImagenModal validate[required]" value="<?=@$imagen_normal[0]['data']['url_archivo'];?>" readonly />
									<input type="hidden" class="inputHideImagenModal" name="txt_id_imagen_normal"  id="txt_id_imagen_normal" value="<?=@$imagen_normal[0]['id_imagen'];?>"/>
					 			</div>
								<p class="help-block"><span class="fa fa-hand-o-up"> La imágen se utilizará para representar el destino en en la página del index de cada idioma.</span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr/>
			<div class="col-md-12 form-group text-center">
				<a href="<?php echo site_url('admin/destinos'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
				<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> GUARDAR</button>
			</div>
		<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#form_edit_destinos").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});
	
	function initMap() {
		autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */(document.getElementById('txt_uri_destino_es')),
		{types: ['geocode']});
	}

	jQuery(document).ready(function($) {
		$(document).on("focusout","#txt_uri_destino_es",function(e){
			$(".txt_ubicacion_replicate").empty().val( $(this).val() );
		});
	});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places&callback=initMap" async defer></script>
	
<?php echo form_close(); ?>