
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
			<h3 class="text-primary"><span class="fa fa-edit"></span> AGREGAR NUEVA GUÍA</h3><hr/>
			<?php echo form_open('buses/guia/add/'.$this->uri->segment(4)."/".$this->uri->segment(5),array("class"=>"form-horizontal", "id"=>"form_add_guia")); ?>
				<?php 
					$autofocus = " autofocus ";
				?>
				<?php foreach ($idiomas as $key => $value): ?>
					<div class="panel panel-success">
						<div class="panel-heading">
							<h4>INFORMACIÓN DEL GUIA EN <?=mb_strtoupper($value['pais'])?></h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="nombre_empresa" class="col-md-12">Nombre del Guía <span class="text-danger fa fa-asterisk"></span></label>
								<div class="col-md-12">
									<input type="text" name="nombre_guia_<?=mb_strtolower($value['codigo'])?>" class="form-control validate[required]" id="nombre_guia" <?=$autofocus?> />
									<span class="text-danger"><?php echo form_error('nombre_guia_<?=mb_strtolower($value["codigo"])?>');?></span>
									<input type="hidden" name="txt_idioma_<?=mb_strtolower($value['codigo'])?>" value="<?=$value['id_idioma']?>" class="form-control">
								</div>
							</div>
							<!--
							<div class="form-group">
								<label for="nombre_empresa" class="col-md-12">Descripción del Guía <span class="text-danger fa fa-asterisk"></span></label>
								<div class="col-md-12">
									<input type="text" name="descripcion_guia_<?=mb_strtolower($value['codigo'])?>" value="<?php echo $this->input->post('descripcion_guia'); ?>" class="form-control" id="descripcion_guia" />
									<span class="text-danger"><?php echo form_error('descripcion_guia');?></span>
								</div>
							</div>
						 	-->
						</div>
					</div>
					<?php $autofocus = "" ?>
				<?php endforeach ?>
				<div class="form-group">
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-success">GUARDAR</button>
						<a href="<?=base_url()?>buses/guia/" class="btn btn-danger">VOLVER</a>
			        </div>
				</div>
			<?php echo form_close(); ?>	
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {   
	    $("#form_add_guia").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});
	});
</script>