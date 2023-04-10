<link rel='stylesheet' href='http://fullcalendar.io/js/fullcalendar-2.2.3/fullcalendar.css' />

<div class="container-fluid">
	<div class="">
		<!-- <h3 class="text-center text-info"><strong><span class="fa fa-edit"></span> CREAR NUEVA RESERVA RAPIDA</strong></h3>
		<hr/> -->
		
		<div class="col-md-7 tab-v1 col-md-sm-7 col-xs-12">
			<div class="headline">
					<div>CREAR NUEVA RESERVA RAPIDA</div>
			</div>
			<?php 
				//echo json_encode($es)."<br><br>";
				//echo json_encode($en);
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
                   		<?php echo form_open('admin/reservarapida/add',array("class"=>"","id"=>"form_add_reservarapida_espanol")); ?>
	                   		<div class="row">
			                   	<div class="col-md-12">
				                   	<div class="form-group">
						                <label><span class="div-numeracion">1</span> Seleccionar y/o Buscar un Tour</label>
						                <select class="form-control" name="slct_tour_espanol" id="slct_tour" data-live-search="true" data-lang="es">
										  <option value="">Buscar...</option>
										  <?php foreach ($es as $key => $value): ?>
										  	<option value="<?=$value['codigo_servicio_id_codigo_servicio'].'-'.$value['id_codigo_producto'].'-'.$value['id_producto'];?>"><?=ucwords( $value['titulo_producto'] );?></option>
										  <?php endforeach ?>
										</select>
									</div>
					                <div class="form-group">
										<label><span class="div-numeracion">2</span><span class="fa fa-user"></span> Nombre del Líder</label>
										<input type="text" name="txt_nombre_lider_reservarapida" id="txt_nombre_lider_reservarapida" class="form-control validate[required]">
									</div>
									<div class="row">
										<div class="col-md-12 row">
											<div class="col-md-12"><span class="div-numeracion">3</span> <label for="">Cantidad de Clientes</label></div>
											<div class=" col-md-6 col-sm-6 col-xs-6 bg-info">
												<div class="form-group">
													<label><span class="fa fa-users"></span> # Personas Adultos</label>
													<input type="number" min="1" name="txt_numero_adultos_reservarapida" id="txt_nombre_lider_reservarapida" value="1" class="form-control validate[required]">
												</div>
											</div>
											<div class=" col-md-6 col-sm-6 col-xs-6 bg-info">
												<div class="form-group">
													<label><span class="fa fa-users"></span> # de Niños</label>
													<input type="number" min="0" name="txt_numero_ninos_reservarapida" id="txt_nombre_lider_reservarapida" value="0" class="form-control">
												</div>
											</div>
										</div>
										<div class="col-md-12 row">
											<div class="col-md-12"><span class="div-numeracion">4</span> <label for="">Precio Por Cantidad de Clientes</label></div>
											<div class=" col-md-6 col-sm-6 col-xs-6 bg-success">
												<div class="form-group">
													<label><span class="fa fa-usd"></span> Precio Por Adulto</label>
													<input type="number" min="0" name="txt_precio_adultos_reservarapida" id="txt_nombre_lider_reservarapida" value="" class="form-control validate[required]">
												</div>
											</div>
											<div class=" col-md-6 col-sm-6 col-xs-6 bg-success">
												<div class="form-group">
													<label><span class="fa fa-usd"></span> Precio Por Niño</label>
													<input type="number" min="0" name="txt_precio_ninos_reservarapida" id="txt_nombre_lider_reservarapida" value="0" class="form-control validate[required]">
												</div>
											</div>
										</div>
									</div>
									<div class="container-tours" id="container-tours">
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<div class="form-group">
													<label><span class="div-numeracion">5</span><span class="fa fa-list"></span> Fecha Tour</label>
													<input type="text" name="txt_fecha_tour_reservarapida" class="form-control datepicker-fecha-tour validate[required]" placeholder="dia-mes-año">
												</div>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-12">	
												<div class="form-group">
													<label><span class="fa fa-list"></span> Nombre del Tour</label>
													<input type="text" name="txt_tour_reservarapida" id="txt_tour_reservarapida" class="form-control validate[required]">
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
												<label><span class="div-numeracion">6</span><span class="fa fa-list"></span> Pago Por:</label>
												<input type="text" name="txt_pago_reservarapida" id="txt_pago_reservarapida" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label><span class="div-numeracion">7</span><span class="fa fa-list"></span> Datos Adicionales:</label>
										<textarea name="txtr_datos_adicionales_reservarapida" id="txtr_datos_adicionales_reservarapida" row="5" class="form-control"></textarea>
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
		<div class="col-md-5 col-md-sm-5 col-xs-12 ">
		<div class="headline">
				<div>DATOS NECESARIOS PARA EL TOUR</div>
		</div>
			<!-- <h3 class="text-center"><strong><ins>DATOS NECESARIOS PARA EL TOUR</ins></strong></h3> -->
			<div class="typography">
				<div class="" style="">
					<div class="typography" id="div_datos_extra">
					
					</div>
					<div class="typography" id="div_contenedor_datos_adicionales_reservarapida">
				
					</div>
				</div>
				
			</div>
			<div class="headline">
						<div>CALENDARIO DISPONIBILIDAD</div>
				</div>
				<div class="calendario_reservarapida" id="calendario_reservarapida">
				</div>
		</div>
		
	</div>
</div>

<script src='<?=base_url();?>assets/resources/moment/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/gcal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/locale-all.js"></script>
<script type="text/javascript" src="<?=base_url().'assets/js/objetos.js';?>"></script>
<script type="text/javascript">
	var js_disponibilidad = new Disponibilidad();
	var js_bloqueo        = new Bloqueo();
	var js_oferta         = new Oferta();  
	var cantidad_dias_inicio_disponibilidad = '';
	var cantidad_dias_fin_disponibilidad = '';
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
					//console.log(data.oferta);
					//console.log(data.bloqueo);
					//console.log(data.disponibilidad);
					console.log(JSON.stringify(data.precio) );
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
					var json_data_disponibilidad = JSON.parse(data.disponibilidad);
					//console.log(JSON.stringify(json_disponibilidad[0]) );
					js_disponibilidad.set_datos_disponibilidad(json_data_disponibilidad[0]);
					actualizar_disponibilidad(moment(json_data_disponibilidad[0]['start']).format("YYYY-MM-DD"), moment(json_data_disponibilidad[0]['end']).format("YYYY-MM-DD") );

			        var json_data_bloqueo = JSON.parse(data.bloqueo);
			        $.each(json_data_bloqueo, function(index, val) {
			          js_bloqueo.set_datos_bloqueo( val );
			        });
			        $.each(JSON.parse(data.oferta.data_oferta), function(index, val) {
			          js_oferta.set_datos_oferta( val );
			        });
			        
			        actualizar_eventos();

				}).fail(function(e) {
					console.log(e.responseText);
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
		$("#calendario_reservarapida").fullCalendar({
			lang: 'es',
		    header: {
		      left: 'prev,next today',
		      center: 'title',
		      right: 'month,agendaWeek,agendaDay'
		    },
		    editable: true,
		    droppable: true,
		    drop: function() {
		      if ($('#drop-remove').is(':checked')) {
		        $(this).remove();
		      }
		    }, 
		    dayClick: function() {
		      //alert('a day has been clicked!');
		    },
		    navLinks: true,
		    selectable: true,
		    selectHelper: true,
		    allDaySlot: false,
		    rendering: 'inverse-background',
		    select: function(fstart, fend) {
		      
		    },
		    editable: true,
		    eventLimit: true,
		    eventClick: function(event) {
		      switch(event.estado){
		        case 'disponibilidad':
		          swal( (event.estado).toUpperCase(),event.title,"success");
		        break;
		        case 'bloqueo':
		          swal( (event.estado).toUpperCase(),"Desde el " + (event.start).format("DD-MM-YYYY") + " hasta el " + (event.end).format("DD-MM-YYYY") + ": " + event.description,"success");
		        break;
		        case 'oferta':
		          swal( (event.estado).toUpperCase(),event.title,"success");
		        break;
		        default:
		          swal("Information",event,"success");
		        break;
		      }     
		      console.log(event);
		      return false;
		    },
		    dayRender: function (date, cell) {
		      if ( cantidad_dias_inicio_disponibilidad.length != 0 && cantidad_dias_fin_disponibilidad.length != 0 ) {
		      //console.log("RENDER CANTIDAD DIAS: " +(parseInt(cantidad_dias_inicio_disponibilidad)+1) + " RENDER CANTIDAD DIAS: " + (parseInt(cantidad_dias_fin_disponibilidad)+1) );       
		        var today = new Date();
		        var end = new Date();
		        today.setDate(today.getDate() + (parseInt(cantidad_dias_inicio_disponibilidad)-1) );
		        end.setDate(today.getDate() + (parseInt(cantidad_dias_fin_disponibilidad)+1) );
		        if(date >= today && date <= end) {
		            cell.css("background-color", "#dff0d8");
		        }
		      }
		    }
		}); 
		

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
		$("#form_add_reservarapida_espanol").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});	


		
	});

function actualizar_eventos(){
  var html_bloqueo = '', html_oferta = '';
  $('#calendario_reservarapida').fullCalendar('removeEvents');
  $.each(js_bloqueo.get_datos_bloqueo(), function(index, val) {
    $('#calendario_reservarapida').fullCalendar('renderEvent', val, true);
    $('#calendario_reservarapida').fullCalendar('unselect');
  });

  $.each(js_oferta.get_datos_oferta(), function(index, val) {
    $('#calendario_reservarapida').fullCalendar('renderEvent', val, true);
    $('#calendario_reservarapida').fullCalendar('unselect');
  });
}
function actualizar_disponibilidad(f_inicio,f_fin){
  cantidad_dias_inicio_disponibilidad = moment(f_inicio+" 23:59:59").diff( moment(),"days");
  cantidad_dias_fin_disponibilidad    = moment(f_fin+" 23:59:59").diff(f_inicio,"days");
  $('#calendario_reservarapida').fullCalendar( 'next' );
  $('#calendario_reservarapida').fullCalendar( 'prev' );     
}

</script>
<style>

</style>