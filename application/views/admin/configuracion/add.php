<script type="text/javascript">
	base_url = '<?=base_url();?>';
</script>
<div class="container-fluid">
	<div class="row">	
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-12">
			<h3 class="text-info text-center"><strong><span class="fa fa-list"></span> Agregar Configuraciones de la Página Web</strong></h3><hr/>
			<?php 
				echo validation_errors(); 
				//echo json_encode($all_idiomas);
			?>
			<?php echo form_open('admin/configuracion/add/',array("class"=>"","id"=>"form_add_configuracion")); ?>
				<div class="row">
				<?php  
					$clase_base = 'txt_nombre_empresa_es';

				?>
				<?php foreach ($idiomas as $key => $value): ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label class="text-info"><span class="fa fa-building"></span> Nombre de la Empresa en (<?=mb_strtoupper($value['pais']);?>)</label>
							<input type="text" name="txt_nombre_empresa[]" id="txt_nombre_empresa_<?=mb_strtolower($value['codigo']);?>" class="form-control <?=$clase_base;?> validate[required]">
							<input type="hidden" name="txt_idioma[]" value="<?=mb_strtolower($value['codigo']);?>">
						</div>	
					</div>
					<?php  
						$clase_base = 'txt_nombre_empresa';
					?>
				<?php endforeach ?>
				</div><hr/>
				<div class="row">
				<?php foreach ($idiomas as $key => $value): ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label class="text-info"><span class="fa fa-globe"></span> Título de la Página Web "INDEX" (<?=mb_strtoupper($value['pais']);?>)</label>
							<input type="text" name="txt_titulo_index[]" id="txt_titulo_index" class="form-control txt_titulo_index validate[required]">
						</div>	
					</div>		
				<?php endforeach ?>
				</div><hr/>
				<div class="row">
				<?php foreach ($idiomas as $key => $value): ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label class="text-info"><span class="fa fa-keyboard-o"></span> Keywords de la Página Web "INDEX" (<?=mb_strtoupper($value['pais']);?>)</label>
							<input type="text" name="txt_keywords[]" id="txt_keywords" class="form-control txt_keywords">
						</div>	
					</div>		
				<?php endforeach ?>
				</div><hr/>
				<div class="row">
				<?php foreach ($idiomas as $key => $value): ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label class="text-info"><span class="fa fa-keyboard-o"></span> Descripción de la Página Web "INDEX" (<?=mb_strtoupper($value['pais']);?>)</label>
							<input type="text" name="txt_descripcion[]" id="txt_descripcion" class="form-control txt_descripcion validate[required]">
						</div>	
					</div>		
				<?php endforeach ?>
				</div><hr/>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-sm-12">
						<label class="text-info"><span class="fa fa-picture-o"></span> Logo de la Página web (INDEX)</label>
						<div class="galeriaDivs" id="imagen_principal">
							<button onclick="openGaleria($(this),6,'Logo pagina web'); return false;"  class="btn btn-success">
							<span class="fa fa-search-plus"></span> Seleccionar Logo</button>
							<input type="text" class="inputImagenModal" value="" readonly />
							<input type="hidden" class="inputHideImagenModal" name="txt_logo" value=""/>
						</div>
						<!--
						<input type="readonly" readonly name="txt_logo" class="form-control" />
						-->
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<label class="text-info"><span class="fa fa-file-image-o"></span> Favicon (ICONO) de la Página web (INDEX)</label>
						<div class="galeriaDivs" id="imagen_principal">
							<button onclick="openGaleria($(this),6,'Favicon'); return false;" class="btn btn-success">
							<span class="fa fa-search-plus"></span> Seleccionar Favicon</button>
							<input type="text" class="inputImagenModal" value="" readonly />
							<input type="hidden" class="inputHideImagenModal" name="txt_favicon" value="" />
						</div>
						<!--
						<input type="text" readonly name="txt_favicon" class="form-control" />
						-->
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-sm-12">
						<label class="text-info"><span class="fa fa-code"></span> Código fuente de <strong>Google Analitics</strong></label>
						<textarea class="form-control validate[required]" name="txtr_script_google_analitics"></textarea>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<label class="text-info"><span class="fa fa-code"></span> Código fuente <strong>Zoopim (Chat)</strong></label>
						<textarea class="form-control validate[required]" name="txtr_script_zoopim" ></textarea>
					</div>
				</div>
				<hr/>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<a href="<?php echo base_url('admin/configuracion'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
						<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> GUARDAR</button>
			        </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<code>
		<?//=json_encode($idiomas);?>
	</code>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $("#form_add_configuracion").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});	

		$(document).on('keyup', '.txt_nombre_empresa_es', function(event) {
			event.preventDefault();
			var content = $(this).val();
			$(".txt_nombre_empresa").empty().val(content);
		});
	});
</script>