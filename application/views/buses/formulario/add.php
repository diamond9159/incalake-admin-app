
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-8 col-md-offset-4 col-sm-offset-4 col-xs-offset-2">
			<h2 class="text-primary"><span class="fa fa-edit"></span> AGREGAR CAMPO DEL FORMULARIO</h2><hr/>
			<?php echo form_open('buses/formulario/add/0',array("class"=>"form-horizontal" ,"id"=>"form_add_formulario")); ?>
				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>Categoria del campo de texto</h4>
					</div>
					<div class="panel panel-body">
						<div class="form-group">
							<label for="pais" class="col-md-12"><span class="fa fa-asterisk text-danger"></span>Categoria de Campo de Texto</label>
							<div class="col-md-12">
								<span class="text-danger"><?php echo form_error('categoria_campo_es');?></span>
								<select name="categoria_campo" id="categoria_campo" class="form-control validate[required]">
									<option value="">Seleccione...</option>
									<?php foreach (@$categoria_campo as $key => $value): ?>
										<option value="<?=$value['id_categoria_formulario']?>" ><?=mb_strtoupper($value['nombre_categoria_formulario'])?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<?php foreach ($idiomas as $key => $value): ?>
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h4>Información del campo de texto en Idioma <?=mb_strtoupper($value['pais'])?></h4>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="codigo" class="col-md-12"><span class="fa fa-asterisk text-danger"></span>Nombre del Campo de Formulario</label>
							<div class="col-md-12">
								<input type="text" name="nombre_campo_<?=mb_strtolower($value['codigo'])?>" value="<?php echo $this->input->post('nombre_campo'); ?>" class="form-control validate[required]" id="nombre_campo" style="text-transform: uppercase;"/>
								<span class="text-danger"><?php echo form_error('nombre_campo');?></span>
							</div>
						</div>
					</div>	
				</div>
				<?php endforeach ?>
				<div class="form-group">
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-success">GUARDAR</button>
						<a href="<?=base_url()?>buses/formulario" class="btn btn-danger">VOLVER</a>
			        </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $("#form_add_formulario").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});
	});
</script>