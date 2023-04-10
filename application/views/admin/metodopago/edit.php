<div class="container-fluid">
	<div class="">
		<div class="">
			<div class="headline">
			<div>EDITAR DATOS DEL METODO DE PAGO</div> 
			</div>
			<?php echo validation_errors(); ?>
			<?php echo form_open('admin/metodopago/edit/'.$metodopago['id_metodo_pago'],array("class"=>"","id" => "form_edit_metodopago")); ?>
			<!-- form-horizontal -->
				<div class="col-md-4 col-md-offset-4">
					<div class="form-group">
						<label for="nombre" class="control-label"><span class="div-numeracion">1</span>Nombre del Método de Pago <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Ingrese el nombre del nuevo método de pago. EJEMPLO: Pagos por Culqi, Paypal, Etc."></span></label>	
						<input type="text" name="txt_nombre_metodopago" autofocus class="form-control validate[required]" id="txt_nombre_metodopago" placeholder="Ingrese nombre del Método de Pago" value="<?=$metodopago['nombre_metodo_pago'];?>"/>

						<!-- <p class="help-block alert alert-info"><span class="fa fa-hand-o-up"></span> Ingrese el nombre del nuevo idioma que quieres agregar. Por ejemplo: Francés, Alemán, Japonés, Etc.</p> -->
					</div>
					<div class="form-group">
						<label style="width: 100%;" for="descripción" class="control-label"><span class="div-numeracion">2</span>Decripción del Método de Pago<span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Ingrese una breve descripción del Método de Pago. EJEMPLO: Pagos por Culqi: Este pago permite el cobro de dólares americanos."></span></label>
						<textarea name="txtr_descripcion_metodopago" class="form-control" id="txtr_descripcion_metodopago" placeholder="Escriba una breve descripción del método de pago." /><?=$metodopago['descripcion_metodo_pago'];?></textarea>
					</div>
				</div>
				
				<hr/>
				<div class="col-md-12 form-group text-center">
					<a href="<?php echo site_url('admin/metodopago'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
					<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> GUARDAR</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>


<script type="text/javascript">
    $("#form_edit_metodopago").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});
</script>