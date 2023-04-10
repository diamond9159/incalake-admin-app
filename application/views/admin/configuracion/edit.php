<script type="text/javascript">
base_url = '<?=base_url();?>';
</script>

<div class="container-fluid">
	<div class="headline">
		<div>Agregar Configuraciones de la Página Web</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-sm-12">
			<?php 
				echo validation_errors(); 
				//echo json_encode($all_idiomas);
			?>
			<?php //echo json_encode( $data[0]['nombre_empresa'][0] ); 
				$array_nombre_empresa = json_decode($data[0]['nombre_empresa'],true);
				$array_titulo_pagina  = json_decode($data[0]['titulo_index'],true);
				$array_keywords		  = json_decode($data[0]['keywords_index'],true);
				$array_descripcion    = json_decode($data[0]['descripcion_index'],true);

				//echo json_encode($array_titulo_pagina);
			?>
			<?php echo form_open('admin/configuracion/edit/'.$data[0]["id_configuracion"],array("class"=>"","id"=>"form_edit_configuracion")); ?>
				
				<?php  
					$clase_base = 'txt_nombre_empresa_es';
				?>
				
				<div class="col-md-6">
					<div class=" panel panel-primary">
					  <div class="panel-heading"><span class="fa fa-building"></span> NOMBRE DE LA EMPRESA</div>
					  <div class="panel-body">
					  	<?php foreach ($idiomas as $key => $value): ?>
							<div class="form-group">
								<label class="text-info">  <?=mb_strtoupper($value['pais']);?></label>
								<input type="text" name="txt_nombre_empresa[]" id="txt_nombre_empresa_<?=mb_strtolower($value['codigo']);?>" class="form-control <?=$clase_base;?> validate[required]" value="<?=$array_nombre_empresa[$key][mb_strtolower($value['codigo'])]?>">
								<input type="hidden" name="txt_idioma[]" value="<?=mb_strtolower($value['codigo']);?>">
							</div>	
						<?php  
							$clase_base = 'txt_nombre_empresa';
						?>
					<?php endforeach ?>
					  </div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-primary">
					<div class="panel-heading"><span class="fa fa-globe"></span> TÍTULO DE LA PÁGINA WEB "INDEX"</div>
					<div class="panel-body">
						<?php foreach ($idiomas as $key => $value): ?>
									<div class="form-group">
										<label class="text-info">  <?=mb_strtoupper($value['pais']);?></label>
										<input type="text" name="txt_titulo_index[]" id="txt_titulo_index" class="form-control txt_titulo_index validate[required]" value="<?=$array_titulo_pagina[$key][mb_strtolower($value['codigo'])]?>">
									</div>		
						<?php endforeach ?>
					</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><span class="fa fa-globe"></span> KEYWORDS DE LA PÁGINA WEB "INDEX"</div>
						<div class="panel-body">
							<?php foreach ($idiomas as $key => $value): ?>
									<div class="form-group">
										<label class="text-info"><span class="fa fa-keyboard-o"></span>  <?=mb_strtoupper($value['pais']);?></label>
										<input type="text" name="txt_keywords[]" id="txt_keywords" class="form-control txt_keywords" value="<?=$array_keywords[$key][mb_strtolower($value['codigo'])];?>">	
								</div>		
							<?php endforeach ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><span class="fa fa-globe"></span> DESCRIPCIÓN DE LA PÁGINA WEB "INDEX"</div>
						<div class="panel-body">
							<?php foreach ($idiomas as $key => $value): ?>
									<div class="form-group">
										<label class="text-info"><span class="fa fa-keyboard-o"></span>  <?=mb_strtoupper($value['pais']);?></label>
										<input type="text" name="txt_descripcion[]" id="txt_descripcion" class="form-control txt_descripcion validate[required]" value="<?=$array_descripcion[$key][mb_strtolower($value['codigo'])];?>">
								</div>		
							<?php endforeach ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><span class="fa fa-picture-o"></span> IMAGENES DE LA PÁGINA WEB "INDEX"</div>
						<div class="panel-body">
							<label class="text-info"> Logo de la Página web (INDEX)</label>
						<div class="galeriaDivs" id="imagen_principal">
							<button onclick="openGaleria($(this),6,'Logo pagina web'); return false;"  class="btn btn-success">
							<span class="fa fa-search-plus"></span> Seleccionar Logo</button>
							<input type="text" class="inputImagenModal" value="<?=$data[0]['logo']['url_archivo'];?>" readonly />
							<input type="hidden" class="inputHideImagenModal" name="txt_logo" value="<?=$data[0]['logo']['id_galeria']?>"/>
						</div>
						<hr>
						<label class="text-info"> Favicon (ICONO) de la Página web (INDEX)</label>
						<div class="galeriaDivs" id="imagen_principal">
							<button onclick="openGaleria($(this),6,'Favicon'); return false;" class="btn btn-success">
							<span class="fa fa-search-plus"></span> Seleccionar Favicon</button>
							<input type="text" class="inputImagenModal" value="<?=$data[0]['favicon']['url_archivo'];?>" readonly />
							<input type="hidden" class="inputHideImagenModal" name="txt_favicon" value="<?=$data[0]['favicon']['id_galeria'];?>" />
						</div>


						</div>
					</div>
				</div>



				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><span class="fa fa-code"></span> CÓDIGO FUENTE</div>
						<div class="panel-body">
							<label class="text-info"> Código fuente de <strong>Google Analitics</strong></label><textarea class="form-control validate[required]" name="txtr_script_google_analitics"><?=!empty($data[0]['codigo_google_analitics']) ? $data[0]['codigo_google_analitics'] : '';?></textarea>
							<label class="text-info"> Código fuente <strong>Zoopim (Chat)</strong></label><textarea class="form-control validate[required]" name="txtr_script_zoopim" ><?=!empty($data[0]['codigo_zoopim']) ? $data[0]['codigo_zoopim'] : '';?></textarea>
						</div>
					</div>
				</div>


				<hr/>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<a href="<?php echo base_url('admin/configuracion'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
						<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> ACTUALIZAR</button>
			        </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<code>
		<?//=json_encode($idiomas);?>
		<br/><br/>
		<?//=json_encode($data);?>
		
	</code>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $("#form_edit_configuracion").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});	
	    /*
		$(document).on('keyup', '.txt_nombre_empresa_es', function(event) {
			event.preventDefault();
			var content = $(this).val();
			$(".txt_nombre_empresa").empty().val(content);
		});
		*/
	});
</script>