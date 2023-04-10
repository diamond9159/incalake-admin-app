<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		<h3 class="text-info"><strong><span class="fa fa-pencil"></span> CONFIGURAR SLIDER DEL INDEX (<small>TODAS LAS PAGINAS WEB</small>)</strong></h3><hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?php echo form_open('admin/slider/add/',array("class"=>"","id"=>"form_add_slider")); ?>
			<?php 
				echo validation_errors(); 
			?>

			<div class="row">
			<?php foreach ($idiomas as $key => $value): ?>
				<?php
					if ( $value['codigo'] === 'ES' || $value['codigo'] === 'EN' ) {
						$validar =' validate[required]';						
					}else{
						$validar ='';
					}
				?>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label class="text-info"><span class="fa fa-building"></span> Título del Slider en (<?=mb_strtoupper($value['pais']);?>)</label>
						<input type="text" name="txt_titulo_slider[]" id="txt_titulo_slider_<?=mb_strtolower($value['codigo']);?>" class="form-control <?=$validar;?>">
						<input type="hidden" name="txt_idioma[]" value="<?=mb_strtolower($value['codigo']);?>">
					</div>	
				</div>
			<?php endforeach ?>
			</div>
			<div class="row">
			<?php foreach ($idiomas as $key => $value): ?>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label class="text-info"><span class="fa fa-building"></span> Descripción del Slider en (<?=mb_strtoupper($value['pais']);?>)</label>
						<textarea name="txt_descripcion_slider[]" id="txt_descripcion_slider_<?=mb_strtolower($value['codigo']);?>" class="form-control"></textarea>
					</div>	
				</div>
			<?php endforeach ?>
			</div>
			<div class="row">
			
			<?php foreach ($idiomas as $key => $value): ?>
				<?php
					if ( $value['codigo'] === 'ES' || $value['codigo'] === 'EN' ) {
						$validar =' validate[custom[url_incalake]]';						
					}else{
						$validar ='';
					}
				?>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label class="text-info"><span class="fa fa-building"></span> Url Destino del Slider en (<?=mb_strtoupper($value['pais']);?>)</label>
						<input type="text" name="txt_url_slider[]" id="txt_url_slider_<?=mb_strtolower($value['codigo']);?>" class="form-control <?=$validar;?>">
					</div>	
				</div>
			<?php endforeach ?>
			</div>

			<div class="col-md-6 col-sm-6 col-xs-12">
				<label class="text-info"><span class="fa fa-file-image-o"></span> Seleccione una Imágen para el slider</label>
				<div class="galeriaDivs" id="imagen_principal">
					<button onclick="openGaleria($(this),1); return false;" class="btn btn-success">
					<span class="fa fa-search-plus"></span> Seleccionar Imágen</button>
					<input type="text" class="inputImagenModal" value="" readonly />
					<input type="hidden" class="inputHideImagenModal" name="txt_img_slider" value="" />
				</div>
				<!--
				<input type="text" readonly name="txt_favicon" class="form-control" />
				-->
			</div>
			<hr/>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<a href="<?php echo base_url('admin/slider'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
					<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> GUARDAR</button>
		        </div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<code>
		
		<?=json_encode($idiomas); ?>
	</code>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $("#form_add_slider").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});	
	});
</script>