<div class="container-fluid">
	<div class="">
		<div class="">
			<?php if ( !empty($data) ): ?>
				<div class="alert alert-danger">
					<strong><span class="fa fa-close fa-2x"></span>  <?=$data;?></strong>
				</div>
			<?php endif ?>
			<div class="headline">
			<div>AGREGAR NUEVO IDIOMA</div> 
			</div>
			<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-danger text-justify">
						<strong>NOTA: </strong>Después de agregar el nuevo idioma serás redirigido a un nuevo formulario donde agregarás las traducciones de las palabras de las categorías existentes para el nuevo idioma.
						</div>
					</div>			
				</div>
						<!-- <div class="alert alert-success text-justify">
							<p>Al crear un nuevo idioma podrás agregar páginas web que serán ofrecidas en la internet para usuarios del mismo idioma.</p>
							<p><strong>Ejemplo:</strong> Puedes agregar un idioma llamado <strong>Japonés</strong>, y su código del idioma es <strong>JP</strong> </p>		
						</div> -->
			<!-- <h2 class="text-center"><span class="fa fa-pencil-square-o text-success"></span> AGREGAR NUEVO IDIOMA</h2><hr/> -->
			<?php echo validation_errors(); ?>
			<?php echo form_open('admin/idioma/add',array("class"=>"","id" => "form_add_idioma")); ?>
			<!-- form-horizontal -->
				<div class="col-md-4 col-md-offset-4">
					<div class="form-group">
						<label for="pais" class="control-label"><span class="div-numeracion">1</span>Nombre del Idioma <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Ingrese el nombre del nuevo idioma que quieres agregar. Por ejemplo: Francés, Alemán, Japonés, Etc."></span></label>	
						<input type="text" name="pais" autofocus value="<?php echo $this->input->post('pais'); ?>" class="form-control validate[required]" id="pais" placeholder="Ingrese nombre del idioma"/>

						<!-- <p class="help-block alert alert-info"><span class="fa fa-hand-o-up"></span> Ingrese el nombre del nuevo idioma que quieres agregar. Por ejemplo: Francés, Alemán, Japonés, Etc.</p> -->
					</div>
					<div class="form-group">
						<label style="width: 100%;" for="codigo" class="control-label"><span class="div-numeracion">2</span>Código del Idioma <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Ingrese el código del nuevo idioma que quieres agregar. Por ejemplo: Para Francés es FR, Para Alemán es DE, Para Japonés es JP, Etc."></span>
						<input type="text" name="codigo" value="<?php echo $this->input->post('codigo'); ?>" class="form-control validate[required,custom[onlyLetterSp],maxSize[2],minSize[2]]" id="codigo" placeholder="Ingrese código del idioma" />

						<div class="help-block alert alert-info">
						<span class="fa fa-question fa-2x"></span>
							<b> <a href="//es.wikipedia.org/wiki/ISO_3166-1" target="_blank">Lista de Paises Formato ISO 3166-1  CLICK</a></b>
						
						</div>
					</div>
				</div>
				
				<hr/>
				<div class="col-md-12 form-group text-center">
					<a href="<?php echo site_url('admin/idioma'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
					<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> GUARDAR</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>


<script type="text/javascript">
    $("#form_add_idioma").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});


	jQuery(document).ready(function($) {
		$(document).on('keyup', '#codigo', function(event) {
			event.preventDefault();
			var txt_codigo  = $(this).val();
			if ( txt_codigo.length == 2 ) {
				$.blockUI({ message: '<h3>Loading...</h3><h4>Espere un momento por favor, estamos comprobando disponibilidad del Idioma..!</h4>' });
				$.ajax({
					url: '<?=base_url().'admin/idioma/duplicidad';?>',
					type: 'POST',
					dataType: 'json',
					data: {codigo: txt_codigo},
				}).done(function(data) {
					$.unblockUI();
					if ( data.response === 'OK' ) {

					}else{
						$('#codigo').val('').focus();
						swal("Error","El código de idioma que acabas de introducir ya está en uso..!","error");
					}
					console.log(data);
				}).fail(function(e) {
					console.log(e.responseText);
				});				
			}

		});
	});
</script>