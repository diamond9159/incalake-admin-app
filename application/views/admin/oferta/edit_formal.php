<br/><br/><br/>
<div class="container-fluid">
<?php echo validation_errors(); ?>

<?php

//echo json_encode($idioma);
//echo json_encode($oferta);
echo json_encode($oferta);
$idioma_titulo = ucwords(mb_strtolower($idioma['pais']));

?>
<h3>Editar y Modificar Oferta para el Idioma <?=$idioma_titulo;?> <span id="nombre_paquete"></span></h3>
<hr/>
	<?php //echo form_open('admin/oferta/edit/'.strtolower($idioma['codigo']).'/'.$oferta['id_oferta'],array("class"=>"form-horizontal","id"=>"form_editoferta")); ?>
	<form name="form_edit_oferta" id="form_edit_oferta" >
	  <div class="form-group">
	    <label for="PaqueteTuristico">Seleccione Paquete</label>
	    <select name="slct_paquete_oferta" id="slct_paquete_oferta" class="form-control validate[required]">
	    	<option value="">Select...</option>
	    	<!--
	    	<?php if ( !empty($all_ofertas) ): ?>
	    		<?php foreach ($all_ofertas as $key => $value): ?>
	    			<?php 
	    				$selected = ($value['id_producto'] == $oferta['id_producto']) ? ' selected="selected"' : ""; 
	    			?>
	    			<option value="<?=$value['id_producto'];?>" <?=$selected;?> ><?=$value['titulo_producto'];?></option>
	    		<?php endforeach ?>
	    	<?php endif ?>
	    	-->
	    </select>
	  </div>
	  <!--
	  <div class="form-group">
	  	<label>Fecha Inicio Oferta</label>
	  	<input type="text" name="txt_inicio_oferta" id="txt_inicio_oferta" value="<?=date_format( date_create($oferta['inicio_oferta']),'d-m-Y');?>" class="form-control validate[required]">
	  </div>
	  <div class="form-group">
	  	<label>Fecha Fin Oferta</label>
	  	<input type="text" name="txt_fin_oferta" id="txt_fin_oferta" value="<?=date_format( date_create($oferta['fin_oferta']),'d-m-Y');?>" class="form-control validate[required]">
	  </div>
	  <div class="form-group">
	  	<label>Descripción Oferta</label>
	  	<textarea name="txtr_descripcion_oferta" id="txtr_descripcion_oferta" class="form-control">
	  	<?php echo ($this->input->post('txtr_descripcion_oferta') ? $this->input->post('txtr_descripcion_oferta') : $oferta['descripcion_oferta']); ?>
	  	</textarea>
	  </div>
	  <div class="form-group">
	  	<label>Tipo de Descuento</label>
	  	<select name="slct_tipo_descuento_oferta" id="slct_tipo_descuento_oferta" class="form-control validate[required]">
	  		<option value="">Select...</option>
	  		<?php 
				$tipo_descuento_values = array(

					'0'=>'Porcentaje',
					'1'=>'Cantidad, Unidad',
				);

				foreach($tipo_descuento_values as $value => $display_text){
					$selected = ($value == $oferta['tipo_descuento']) ? ' selected="selected"' : "";
					echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
				} 
			?>
	  	</select>
	  </div>
	  <div class="form-group">
	  	<label>Descuento Oferta</label>
	  	<input type="text" name="txt_descuento_oferta" id="txt_descuento_oferta" value="<?=$oferta['descuento'];?>" class="form-control validate[required,custom[number]]">
	  </div>	
	  <div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Actualizar</button>
			<a href="<?php echo site_url('admin/oferta'); ?>" class="btn btn-danger">Volver</a>
        </div>
	</div>  
	-->
	<?php echo form_close();?>
</div>



<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#form_editoferta").validationEngine('attach', {
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