
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
			<?php echo validation_errors(); ?>

			<?php
			//echo json_encode($id_producto);
			//echo json_encode($ofertas[0]['pais']);
			$idioma_titulo = mb_strtoupper($idioma);
			if (!empty($ofertas[0]['pais']) ) {
				$idioma_titulo = ucwords(mb_strtolower($ofertas[0]['pais']));
			}

			?>
			<h3 class="text-center"><span class="fa fa-pencil-square text-success"></span> Crear Nueva Oferta para el Idioma <?=$idioma_titulo;?> <span id="nombre_paquete"></span></h3>
			<hr/>
			<?php echo form_open('admin/oferta/add/'.$idioma.'/'.$id_producto,array("class"=>"form-horizontal","id"=>"form_addoferta")); ?>
			  <div class="form-group">
			    <label for="PaqueteTuristico">Seleccione Paquete</label>
			    <select name="slct_paquete_oferta" id="slct_paquete_oferta" class="form-control validate[required]">
			    	<option value="">Select...</option>
			    	<?php if ( !empty($ofertas) ): ?>
			    		<?php foreach ($ofertas as $key => $value): ?>
			    			<?php 
			    				$selected = ($value['id_producto'] == $id_producto) ? ' selected="selected"' : ""; 
			    			?>
			    			<option value="<?=$value['id_producto'];?>" <?=$selected;?> ><?=$value['titulo_producto'];?></option>
			    		<?php endforeach ?>
			    	<?php endif ?>
			    </select>
			  </div>
			  <div class="form-group">
			  	<label>Fecha Inicio Oferta</label>
			  	<input type="text" name="txt_inicio_oferta" id="txt_inicio_oferta" class="form-control validate[required]">
			  </div>
			  <div class="form-group">
			  	<label>Fecha Fin Oferta</label>
			  	<input type="text" name="txt_fin_oferta" id="txt_fin_oferta" class="form-control validate[required]">
			  </div>
			  <div class="form-group">
			  	<label>Descripción Oferta</label>
			  	<textarea name="txtr_descripcion_oferta" id="txtr_descripcion_oferta" class="form-control">
			  	</textarea>
			  </div>
			  <div class="form-group">
			  	<label>Tipo de Descuento</label>
			  	<select name="slct_tipo_descuento_oferta" id="slct_tipo_descuento_oferta" class="form-control validate[required]">
			  		<option value="">Select...</option>
			  		<option value="0">Porcentaje</option>
			  		<option value="1">Cantidad, Unidad</option>
			  	</select>
			  </div>
			  <div class="form-group">
			  	<label>Descuento Oferta</label>
			  	<input type="text" name="txt_descuento_oferta" id="txt_descuento_oferta" class="form-control validate[required,custom[number]]">
			  </div><hr/>	
			  <div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<button type="submit" class="btn btn-success">GUARDAR</button>
					<a href="<?php echo site_url('admin/oferta'); ?>" class="btn btn-danger">VOLVER</a>
		        </div>
			</div>  
			<?php echo form_close();?>
		</div>
	</div>
</div>



<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#form_addoferta").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});

		$("#txt_inicio_oferta").datepicker(
			{
				dateFormat:'dd/mm/yy',
				changeMonth: true,
				changeYear: true,
				minDate: 0,
				onSelect: function(selectedDate){
			        $("#txt_fin_oferta").datepicker("option", "minDate", selectedDate);
			    }
			}
		);
		$("#txt_fin_oferta").datepicker(
			{
				dateFormat:'dd/mm/yy',
				changeMonth: true,
				changeYear: true,
				minDate: $("#txt_inicio_oferta").val()
			}
		);
		$(document).on('change', '#slct_paquete_oferta', function(event) {
			event.preventDefault();
			$.blockUI({ message: '<h3>Loading...</h3><h4>Wait a moment please..!</h4>' }); 	
			$.ajax({
				url: '<?=base_url();?>admin/oferta/find_oferta',
				type: 'POST',
				dataType: 'JSON',
				data: {id_paquete: $(this).val()},
				beforeSend: function(){
	                $.blockUI({ message: '<h3>Loading...</h3><h4>Wait a moment please..!</h4>' }); 
	            },
	            success: function(data) {
					$.unblockUI();
					if (data.response === 'OK' ) {
						var array_fecha_inicio = (data.data.inicio_oferta).split(' ');
						var array_fecha_fin    = (data.data.fin_oferta).split(' ');
						$("#txt_inicio_oferta").val(array_fecha_inicio[0]);
						$("#txt_fin_oferta").val(array_fecha_fin[0]);
						$("#txtr_descripcion_oferta").val(data.data.descripcion_oferta);
						$('#slct_tipo_descuento_oferta> option[value="'+data.data.tipo_descuento+'"]').attr('selected', 'selected');
						$("#txt_descuento_oferta").val(data.data.descuento);
					}
				},
				error: function(e){
	            	$.unblockUI();
	                swal("Error..!","No se ha podido conectar con el servidor..!","error");
	            }
			});
		});
	});
</script>