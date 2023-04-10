<?php 
	// echo json_encode($productos);
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="headline">
				<div><span class="fa fa-edit"></span> agregar nuevo recurso</div>
			</div>
		<!-- <h3 class="text-center"><strong><span class="fa fa-list"></span> </strong></h3><hr> -->
			<?php echo validation_errors(); ?>
			<?php echo form_open('admin/recurso/add',array("class"=>"","id" => "form_add_recurso")); ?>
				<?php
					$cantidad_idiomas = 0;
					$array_idiomas = array();
				?>

				<?php foreach ($idiomas as $key => $value): ?>
					
					<?php
					$inicio_div='';
					$fin_div='';
						$cantidad_idiomas++;
						array_push($array_idiomas, strtolower($value['codigo']) );
						$validate_name  = '';
						$validate_price = '';
						if ( $value['codigo']  === "ES" || $value["codigo"] === "EN") {
							$validate_name  = 'validate[required]';
							$validate_price = 'validate[required,custom[number]]';
						}
						if($key==0){
							echo '<div class="row">';
						}elseif($key%3==0){
							echo '</div><div class="row">';
						}


					?>
					<div class="col-md-4">
						<div class="panel panel-primary">
							<div class="panel-heading" data-toggle="collapse" href="#collapse-<?=$key; ?>" aria-expanded="true">
							  	<h4 class="panel-title">
							  	<span class="div-numeracion"><?=$key+1; ?></span>
								<b>Recurso en <?=$value['pais']; ?></b>
								<span class="fa fa-gift"></span>
						        </h4>
							  </div>
							<div id="collapse-<?=$key; ?>" class="panel-collapse collapse in" aria-expanded="true">
						  	<div class="panel-body">
								<div class="form-group">
									<label><!-- <span class="div-numeracion">1</span> -->Nombre del Recurso [<?php echo $value['pais']; ?>]<span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover" data-content="Escriba el nombre que le corresponde a la artesanía. Ejemplo: Ponchito, chompa, balsa de totora, etc." data-original-title="" title=""></span></label>
									<input type="text" name="txt_nombre_recurso_<?=strtolower($value['codigo']);?>" autofocus class="form-control txt_nombre_recurso <?=$validate_name;?>" id="txt_nombre_recurso_<?=strtolower($value['codigo']);?>">
								</div>
								<div class="form-group">
									<label><!-- <span class="div-numeracion">2</span> -->Descripción del recurso [<?php echo $value['pais']; ?>]<span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover" data-content="Describa su recurso. Ejemplo: Ponchito sirve para la protección y está fabricada con fibra natural obtenido de los camélidos de la Región de Puno." data-original-title="" title=""></span></label>
									<textarea name="txtr_descripcion_recurso_<?=strtolower($value['codigo']);?>" class="form-control txtr_descripcion_recurso" id="txtr_descripcion_recurso_<?=strtolower($value['codigo']);?>"></textarea>
								</div>
								<div class="form-group">
									<label><!-- <span class="div-numeracion">3</span> -->Precio del Recurso $ USD [<?php echo $value['pais']; ?>]</label>
									<div class="input-group col-md-6">
                                                                  <span class="input-group-addon">$</span>
                                                                  <input type="text" name="txt_precio_recurso_<?=strtolower($value['codigo']);?>" min="0" class="txt_precio_recurso form-control <?=$validate_price;?>" id="txt_precio_recurso_<?=strtolower($value['codigo']);?>">
                                                                  <span class="input-group-addon">USD</span>
                                                                </div>

									
								</div>
							</div>
							</div>
						</div>
					</div>
					
				
				<?php endforeach ?>
				<?='</div>';$cantidad_idiomas++;?>
				<div class="col-md-12">
					<div class="form-group">
						<label><span class="div-numeracion"><?=$cantidad_idiomas++;?></span>Este Recurso está activo y se mostrará en cualquier tour que lo requiera.</label>
						<div class="">
							<label class=""><input type="checkbox" value="1" checked name="chckbx_regalo_recurso" class="chckbx_regalo_recurso "> <span style="font-weight: normal;">Este Recurso está activo y se mostrará en cualquier tour que lo requiera.</span> </label>
						</div>
					</div>
					<div class="form-group">
						<label><span class="div-numeracion"><?=$cantidad_idiomas++;?></span>Seleccione imágen para el recurso</label>
						<!--input type="file" name="fl_imagen_recurso" class=" fl_imagen_recurso" id="fl_imagen_recurso"-->
						<div class="galeriaDivs">
						<button onclick="openGaleria($(this),4,'Recursos incluidos'); return false;" class="btn btn-primary">
						<span class="fa fa-search-plus"></span> Seleccionar Miniatura</button>
						<input type="text" class="inputImagenModal" readonly />
						<input type="hidden" class="inputHideImagenModal" name="fl_imagen_recurso" /></div>
					</div>
				
				<hr/>
				<div class="form-group text-center">
					<a href="<?php echo site_url('admin/recurso'); ?>" class="btn btn-danger"><b><span class="fa fa-chevron-left"></span> VOLVER</b></a>
					<button type="submit" class="btn btn-success"><b><span class="fa fa-save"></span> GUARDAR</b></button>
				</div>
				</div>
			<?php echo form_close(); ?>
			
		</div>
	</div>
</div>

<script type="text/javascript">
    $("#form_add_recurso").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});	
</script>
<style>
input[type="checkbox"] {

    width: 20px;
    height: 20px;
}
</style>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var cantidad_idiomas = '<?=$cantidad_idiomas;?>';
		var string_idiomas   = '<?=json_encode($array_idiomas);?>';
        var array_idiomas    = JSON.parse(string_idiomas);
		console.log(cantidad_idiomas);
		console.log( array_idiomas );

		$(document).on('keyup paste change', '#txt_precio_recurso_es', function(event) {
			event.preventDefault();
			var texto = $(this).val();
			$.each(array_idiomas, function(index, val) {
				$("#txt_precio_recurso_"+val).empty().val(texto);
			});
		});
	});
</script>