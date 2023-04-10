<link rel='stylesheet' href='http://fullcalendar.io/js/fullcalendar-2.2.3/fullcalendar.css' />

<div class="container-fluid">
	<div class="row">
		<h3 class="text-center text-info"><strong><span class="fa fa-edit"></span> MODIFICAR RESERVA RAPIDA</strong></h3>
		<hr/>
		<div class="col-md-7 col-md-sm-7 col-xs-12">
			<?php 
				//echo json_encode($es)."<br><br>";
				//echo json_encode($en);
				//echo json_encode($reservarapida);
			?>
			<ul class="nav nav-tabs ">
               <li class="active">
                   <a href="#div_reserva_rapida_espanol" data-toggle="tab" aria-expanded="false">
                       <span class="flag flag-es" title="Reserva Rápida ESPAÑOL"></span>
                       <strong class="hidden-xs hidden-sm">ESPAÑOL</strong>
                   </a>
               </li>
               <li class="">
                   <a href="#div_reserva_rapida_ingles" data-toggle="tab" aria-expanded="false">
                       <span class="flag flag-eu" title="Reserva Rápida INGLES"></span>
                       <strong class="hidden-xs hidden-sm">INGLES</strong>
                   </a>
               </li>               
           </ul>
           <div class="tab-content">
               <div class="tab-pane fade active in" id="div_reserva_rapida_espanol">
                   <div class="typography">
                   		<!--
                   		<form id="form_add_reservarapida_espanol" class="form-search form-horizontal">
						-->
                   		<?php echo form_open('admin/reservarapida/edit/php'.$id_paquete,array("class"=>"","id"=>"form_edit_reservarapida_espanol")); ?>
	                   		<div class="row">
			                   	<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
				                   	<div class="form-group">
						                <label>Tour...</label>
						                <select class="form-control" name="slct_tour_espanol" id="slct_tour" data-live-search="true" data-lang="es">
										  <option value="">Buscar...</option>
										  <?php foreach ($es as $key => $value): ?>
										  	<?php 
										  		$id_paquete = $value['codigo_servicio_id_codigo_servicio'].'-'.$value['id_codigo_producto'].'-'.$value['id_producto']; 
										  		$selected  = '';
										  	?>
										  	<?php if ( $id_paquete === $reservarapida['id_paquete'] ): ?>
										  		<?php $selected = 'selected'; ?>
										  	<?php endif ?>
										  	<option value="<?=$id_paquete;?>" <?=$selected;?> ><?=ucwords( $value['titulo_producto'] );?></option>
										  <?php endforeach ?>
										</select>
									</div>
					                <div class="form-group">
										<label><span class="fa fa-user"></span> Nombre del Líder</label>
										<input type="text" name="txt_nombre_lider_reservarapida" id="txt_nombre_lider_reservarapida" class="form-control validate[required]" value="<?php echo $this->input->post('txt_nombre_lider_reservarapida') ? $this->input->post('txt_nombre_lider_reservarapida') : $reservarapida['nombre_lider']; ?>">
									</div>
									<div class="row">
										<div class=" col-md-3 col-sm-3 col-xs-6">
											<div class="form-group">
												<label><span class="fa fa-users"></span> # Personas Adultos</label>
												<input type="number" min="1" name="txt_numero_adultos_reservarapida" id="txt_nombre_lider_reservarapida" value="<?php echo $this->input->post('txt_numero_adultos_reservarapida') ? $this->input->post('txt_numero_adultos_reservarapida') : $reservarapida['nro_personas_adultas']; ?>" class="form-control validate[required]">
											</div>
										</div>
										<div class=" col-md-3 col-sm-3 col-xs-6">
											<div class="form-group">
												<label><span class="fa fa-users"></span> # de Niños</label>
												<input type="number" min="0" name="txt_numero_ninos_reservarapida" id="txt_nombre_lider_reservarapida" value="<?php echo $this->input->post('txt_numero_ninos_reservarapida') ? $this->input->post('txt_numero_ninos_reservarapida') : $reservarapida['nro_personas_menores']; ?>" class="form-control">
											</div>
										</div>
										<div class=" col-md-3 col-sm-3 col-xs-6">
											<div class="form-group">
												<label><span class="fa fa-usd"></span> P. Por Persona</label>
												<input type="number" min="0" name="txt_precio_adultos_reservarapida" id="txt_nombre_lider_reservarapida" value="<?php echo $this->input->post('txt_precio_adultos_reservarapida') ? $this->input->post('txt_precio_adultos_reservarapida') : $reservarapida['precio_personas_adultas']; ?>" class="form-control validate[required]">
											</div>
										</div>
										<div class=" col-md-3 col-sm-3 col-xs-6">
											<div class="form-group">
												<label><span class="fa fa-usd"></span> P. Por Niño</label>
												<input type="number" min="0" name="txt_precio_ninos_reservarapida" id="txt_nombre_lider_reservarapida" value="<?php echo $this->input->post('txt_precio_ninos_reservarapida') ? $this->input->post('txt_precio_ninos_reservarapida') : $reservarapida['precio_personas_menores']; ?>" class="form-control validate[required]">
											</div>
										</div>
									</div>
									<div class="container-tours" id="container-tours">
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<div class="form-group">
													<label><span class="fa fa-list"></span> Fecha Tour</label>
													<input type="text" name="txt_fecha_tour_reservarapida" class="form-control datepicker-fecha-tour validate[required]" placeholder="dia-mes-año" value="<?php echo $this->input->post('txt_fecha_tour_reservarapida') ? $this->input->post('txt_fecha_tour_reservarapida') : date_format(date_create($reservarapida['fecha_tour']),'d-M-Y' ); ?>">
												</div>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-12">	
												<div class="form-group">
													<label><span class="fa fa-list"></span> Nombre del Tour</label>
													<input type="text" name="txt_tour_reservarapida" id="txt_tour_reservarapida" class="form-control validate[required]" value="<?php echo $this->input->post('txt_tour_reservarapida') ? $this->input->post('txt_tour_reservarapida') : $reservarapida['nombre_tour']; ?>">
												</div>
											</div>
										</div>	
									</div>
									<!--
									<span class="btn btn-sm btn-danger pull-right btn-agregar-otro-tour"><strong>AGREGAR TOUR</strong></span>
									-->
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="form-group">
												<label><span class="fa fa-list"></span> Pago Por:</label>
												<input type="text" name="txt_pago_reservarapida" id="txt_pago_reservarapida" class="form-control" value="<?php echo $this->input->post('txt_pago_reservarapida') ? $this->input->post('txt_pago_reservarapida') : $reservarapida['pago']; ?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label><span class="fa fa-list"></span> Datos Adicionales:</label>
										<textarea name="txtr_datos_adicionales_reservarapida" id="txtr_datos_adicionales_reservarapida" row="5" class="form-control"><?php echo $this->input->post('txtr_datos_adicionales_reservarapida') ? $this->input->post('txtr_datos_adicionales_reservarapida') : $reservarapida['datos_adicionales']; ?></textarea>
									</div>
						        </div>
				            </div>
							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-8">
									<a href="<?php echo base_url('admin/reservarapida'); ?>" class="btn btn-danger"><strong><span class="fa fa-chevron-left"></span> VOLVER</strong></a>
									<button type="submit" class="btn btn-success"><strong><span class="fa fa-save"></span> GUARDAR</strong></button>
						        </div>
							</div>
			            <!--
			            </form>
			            -->
			            <?php echo form_close(); ?>
                   </div>
                </div>
               <div class="tab-pane fade" id="div_reserva_rapida_ingles">
                   <div class="typography">
                   		<form id="form_add_reservarapida_ingles" class="form-search form-horizontal">
	                   		<div class="row">
			                   	<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
					               <div class="form-group">
						                <label>Buscar tour...</label>
						                <select class="selectpicker form-control" name="slct_tour_ingles" id="slct_tour" data-live-search="true" data-lang="en">
										  <option value="">Search...</option>
										  <?php foreach ($en as $key => $value): ?>
										  	<option value="<?=$value['codigo_servicio_id_codigo_servicio'].'-'.$value['id_codigo_producto'].'-'.$value['id_producto'];?>"><?=ucwords( $value['titulo_producto'] );?></option>
										  <?php endforeach ?>
										</select>
									</div>
						        </div>
				            </div>
			            </form>
                   </div>
                </div>
            </div>
		</div>
		<div class="col-md-5 col-md-sm-5 col-xs-12 bg-info" style="display:none;">
			<h3 class="text-center"><strong><ins>DATOS NECESARIOS PARA EL TOUR</ins></strong></h3>
			<div class="typography">
				<div class="" style="min-height: 17em;">
					<div class="typography" id="div_datos_extra">
					
					</div>
					<div class="typography" id="div_contenedor_datos_adicionales_reservarapida">
				
					</div>
				</div>
				<div class="calendario_reservarapida" id="calendario_reservarapida">

				</div>
			</div>
		</div>
		
	</div>
</div>

<script src='<?=base_url();?>assets/resources/moment/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/gcal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/locale-all.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('change', '#slct_tour', function(event) {
			event.preventDefault();
			var data_select = $(this).val();
			var idioma 		= $(this).data("lang");
			var html_extra  = '';
			if ( data_select.length != 0 ) {
				console.log(data_select+" - "+idioma);
				$.ajax({
					url: '<?=base_url();?>admin/reservarapida/reservarapida_producto_idioma',
					type: 'POST',
					dataType: 'json',
					data: {data: data_select,lang:idioma},
				}).done(function(data) {
					console.log(data);
					var string_duracion = data.producto.duracion;
					var array_duracion  = null;
					var html_duracion   = '';
					if ( string_duracion.length != 0 ) {
						array_duracion = string_duracion.split('!');
						switch( parseInt(array_duracion[1]) ){
							case 0:
								html_duracion += array_duracion[0]+' Minutos';
							break;
							case 1:
								html_duracion += array_duracion[0]+' Horas';
							break;
							case 2:
								html_duracion += array_duracion[0]+' Días';
							break;
							default:
								html_duracion += ' <i>No definido..!</i>';
							break;
						}
					}
					
					//$("#div_contenedor_datos_adicionales_reservarapida").empty().append( JSON.stringify(data) );
					html_extra += '<div class=""><strong>HORA DE INICIO: </strong> '+data.producto.hora_inicio+' | <span><strong>Duración:</strong> '+html_duracion+'</span></div><br/>';
					$("#div_datos_extra").empty().append(html_extra);
					$("#div_contenedor_datos_adicionales_reservarapida").empty().append(data.datos_reserva);
					$("#txt_tour_reservarapida").val(data.producto.titulo_producto);
				}).fail(function(e) {
					swal("ERROR",e.responseText,"error");
				});
				$("#txt_nombre_lider_reservarapida").focus();
			}else{
				//console.log( "Está vacío..!" );	
			}
		});
		$(".datepicker-fecha-tour").datepicker({
			changeMonth: true,
			changeYear: true,
			minDate: "0",
			dateFormat: 'dd-M-yy'
		});
		$("#calendario_reservarapida").fullCalendar(); 
		
		$(document).on('click', '.btn-agregar-otro-tour', function(event) {
			event.preventDefault();
			var html_agregar_otro_tour = '<div class="row">'+
											'<div class="col-md-3 col-sm-3 col-xs-12">'+
												'<div class="form-group">'+
													'<label><span class="fa fa-list"></span> Fecha Tour</label>'+
													'<input type="text" name="txt_fecha_tour_reservarapida[]" class="form-control datepicker-fecha-tour" placeholder="dia-mes-año">'+
												'</div>'+
											'</div>'+
											'<div class="col-md-9 col-sm-9 col-xs-12">'+	
												'<div class="form-group">'+
													'<label><span class="fa fa-list"></span> Nombre del Tour</label>'+
													'<span class="fa fa-close btn btn-xs btn-danger pull-right" title="Eliminar" onclick="$(this).parent().parent().parent().remove();" ></span>'+
													'<input type="text" name="txt_tour_reservarapida[]" class="form-control">'+
												'</div>'+
											'</div>'+
										'</div>';
			$("#container-tours").append(html_agregar_otro_tour);
			console.log("Inserted..!");
			$(".datepicker-fecha-tour").datepicker({
				changeMonth: true,
				changeYear: true,
				minDate: "0",
				dateFormat: 'dd-M-yy'
			});
		});
		$("#form_edit_reservarapida_espanol").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});	
	});
</script>