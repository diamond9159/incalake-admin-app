
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-8 col-md-offset-4 col-sm-offset-4 col-xs-offset-2">
			<h2 class="text-primary"><span class="fa fa-edit"></span> AGREGAR NUEVO IDIOMA</h2><hr/>
			<?php echo form_open('buses/idioma/add',array("class"=>"form-horizontal" ,"id"=>"form_add_idioma")); ?>

				<div class="form-group">
					<label for="pais" class="col-md-12"><span class="fa fa-asterisk text-danger"></span>Idioma: Ejem: Español, Inglés, etc.</label>
					<div class="col-md-12">
						<input type="text" name="pais" value="<?php echo $this->input->post('pais'); ?>" class="form-control validate[required]" id="pais" autofocus/>
						<span class="text-danger"><?php echo form_error('pais');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="codigo" class="col-md-12"><span class="fa fa-asterisk text-danger"></span>Código Idioma: Ejem: EN = Inglés, ES = Español</label>
					<div class="col-md-12">
						<input type="text" name="codigo" value="<?php echo $this->input->post('codigo'); ?>" class="form-control validate[required,maxSize[2],,minSize[2]]" id="codigo" style="text-transform: uppercase;"/>
						<span class="text-danger"><?php echo form_error('codigo');?></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-success">GUARDAR</button>
						<a href="<?=base_url()?>buses/idioma" class="btn btn-danger">VOLVER</a>
			        </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
	    
	    $("#form_add_idioma").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});

	});
</script>