 <?php 
 	if ( empty($idioma['id_idioma']) ) {
 		return false;
 	}
 ?>	

<div class="container-fluid">
<div class="col-md-12">
	<?php echo validation_errors(); ?>
	<?php echo form_open('admin/idioma/edit/'.$idioma['id_idioma'],array("class"=>"")); ?>
	<div class="headline">
				<div>editar idioma</div>
				</div>

		<div class="col-md-4 col-md-offset-4">

		<div class="form-group">
						<label for="pais" class="control-label"><span class="div-numeracion">1</span> Nombre del Idioma <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Ingrese el nombre del nuevo idioma que quieres agregar. Por ejemplo: Francés, Alemán, Japonés, Etc."></span></label>	
						
						<input type="text" name="pais" value="<?php echo ($this->input->post('pais') ? $this->input->post('pais') : $idioma['pais']); ?>" class="form-control" id="Nombre del Idioma" />
					</div>
					<div class="form-group">
						<label for="codigo" class="control-label"><span class="div-numeracion">2</span> Código del Idioma <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Ingrese el código del nuevo idioma que quieres agregar. Por ejemplo: Para Francés es FR, Para Alemán es DE, Para Japonés es JP, Etc."></span></label>
						
						<input type="text" name="codigo" value="<?php echo ($this->input->post('codigo') ? $this->input->post('codigo') : $idioma['codigo']); ?>" class="form-control" id="codigo del país" />
						<div class="help-block alert alert-info">
						<span class="fa fa-question fa-2x"></span>
							<b> <a href="//es.wikipedia.org/wiki/ISO_3166-1" target="_blank">Lista de Paises Formato ISO 3166-1  CLICK</a></b>
						
						</div>
					</div>
		
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
				<a href="<?php echo site_url('admin/idioma'); ?>" class="btn btn-danger"> <span class="fa fa-chevron-left"></span> Volver</a>
				<button type="submit" class="btn btn-success"> <span class="fa fa-save"></span> Guardar</button>
	        </div>
		</div>
		</div>
		
		
	<?php echo form_close(); ?>
</div>

</div>