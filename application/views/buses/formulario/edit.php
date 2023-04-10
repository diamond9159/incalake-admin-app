
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-8 col-md-offset-4 col-sm-offset-4 col-xs-offset-2">
			<h2 class="text-primary"><span class="fa fa-edit"></span> EDITAR CAMPO DEL FORMULARIO</h2><hr/>
			<?php echo form_open('buses/formulario/edit/'.$this->uri->segment(4).'/'.$this->uri->segment(5),array("class"=>"form-horizontal" ,"id"=>"form_add_formulario")); ?>
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
										<?php 
											$selected = $value['id_categoria_formulario'] == $campo_texto[0]['id_categoria_formulario']?"selected":"";
										?>
										<option value="<?=$value['id_categoria_formulario']?>" <?=$selected?> ><?=mb_strtoupper($value['nombre_categoria_formulario'])?></option>
									<?php endforeach ?>
								</select>
								<input type="hidden" name="id_codigo_campo_formulario" value="<?=$campo_texto[0]['id_codigo_categoria_formulario'];?>" class="form-control">
							</div>
						</div>
					</div>
				</div>

				<?php foreach ($campo_texto as $key => $value): ?>
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h4>Información del campo de texto en Idioma <?=mb_strtoupper($value['pais'])?></h4>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="codigo" class="col-md-12"><span class="fa fa-asterisk text-danger"></span>Nombre del Campo de Formulario</label>
							<div class="col-md-12">
								<input type="text" name="nombre_campo_<?=mb_strtolower($value['codigo'])?>" value="<?=$value['nombre_campo_formulario']; ?>" class="form-control validate[required]" id="nombre_campo" style="text-transform: uppercase;"/>
								<span class="text-danger"><?php echo form_error('nombre_campo');?></span>
								<input type="hidden" name="id_nombre_campo_<?=mb_strtolower($value['codigo'])?>" value="<?=$value['id_campo_formulario'];?>" class="form-control">
								
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
	    $("#form_edit_formulario").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});
	});
</script>