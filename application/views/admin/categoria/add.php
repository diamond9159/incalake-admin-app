<div class="container-fluid">
	<div class="col-md-12">
		<div >
			<?php 
				echo validation_errors(); 
				//echo json_encode($all_idiomas);
			?>
			<?php echo form_open('admin/categoria/add/'.$codigo_categoria,array("class"=>"","id"=>"form_add_categoria")); ?>
			<div class="headline">
			<div>crear nueva categoria para todos los idiomas</div>
			</div>
				<!-- <h2 class="text-center"><span class="fa fa-pencil-square text-success"></span> </h2><hr/> -->
				<?php
					$primera_entrada  = true;
					$background = 'panel-primary';
					foreach ($all_idiomas as $key => $value) {
					// if ( $primera_entrada ) {
					// 	$primera_entrada  = false;
					// 	$background = 'panel-primary';	w
					// }else{
					// 	$primera_entrada = true;
					// 	$background = 'panel-primary';	
					// }
				?>
						<div class="panel panel-primary">
						  <div class="panel-heading" data-toggle="collapse" href="#collapse-<?=$key?>" aria-expanded="true">
						  	<h4 class="panel-title">
						  	<span class="div-numeracion"><?=$key+1?></span>
							<b>Categoria en <?=ucwords(mb_strtolower($value['pais']));?></b>
							<span class="fa fa-tags"></span>
					        </h4>
						  </div>
						  <div id="collapse-<?=$key?>" class="panel-collapse collapse in" aria-expanded="true">
						  	<div class="panel-body">
							  	<div class="form-group col-md-6">
							  		<div class="">
										<label for="pais" class="control-label">Nombre Categoria en <?=ucwords(mb_strtolower($value['pais']));?> <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Escriba un nombre para su categoria. Ejemplo: Turismo Vivencial, Turismo Cultural."></span></label> 
										<input type="text" name="txt_nombre_categoria[]" value="<?php echo $this->input->post('nombre_categoria'); ?>" class="form-control validate[required]" id="txt_nombre_categoria" />
									</div>
							  	</div>
						  		<div class="col-md-6">
							  		<div class="">
										<label for="codigo" class="control-label">Descripción Categoria en <?=ucwords(mb_strtolower($value['pais']));?> <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Describa su categoria por ejemplo: TURISMO VIVENCIAL: Se entiende por vivencial aquel turismo que se desarrolla con la convivencia entre el visitante y una familia receptora quien le enseña sus hábitos y costumbres."></span></label>
										<textarea name="txt_descripcion_categoria[]" value="<?php echo $this->input->post('txt_descripcion_categoria'); ?>" class="form-control validate[required]" id="txt_descripcion_categoria"></textarea>
										<input type="hidden" name="txt_idioma[]" class="form-control" id="txt_idioma" value="<?=$value['id_idioma'];?>" />
										
									</div>
							  	</div>

								
						  	</div>
						  </div>
						</div>
					
				<?php
					}
				?><hr/>
				        <div class="galeriaDivs">
							<button onclick="openGaleria($(this),6,this.innerText); return false;"  class="btn btn-success">
							<span class="fa fa-search-plus"></span> Buscar Imagen destacada</button>
							<input type="text" style="padding:5px;border-radius:5px;border:1px solid #CCC;" class="inputImagenModal" value="" readonly />
							<input type="hidden" class="inputHideImagenModal" name="img_destacada" value=""/>
						</div>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<a href="<?php echo base_url('admin/categoria'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
						<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> GUARDAR</button>
			        </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
    $("#form_add_categoria").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});	
</script>