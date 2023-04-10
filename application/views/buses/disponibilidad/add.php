<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
	        <div class="text-left tab-v1 form-group container-fluid" style="padding: 0px;">
	            <ul class="nav nav-tabs ">
	                <li class="active">
	                   <a href="#div_disponibilidad" data-toggle="tab" aria-expanded="false">
	                       <span class="fa fa-calendar-check-o"></span>
	                       <strong class="hidden-xs hidden-sm">DISPONIBILIDAD</strong>
	                   </a>
	                </li>
	                <li class="">
	                   <a href="#div_bloqueos" data-toggle="tab" aria-expanded="false">
	                       <span class="fa fa-ban"></span>
	                       <strong class="hidden-xs hidden-sm">BLOQUEOS</strong>
	                   </a>
	                </li>
	                <li class="">
	                   <a href="#div_ofertas" data-toggle="tab" aria-expanded="true">
	                       <span class="fa fa-star-o"></span>
	                       <strong class="hidden-xs hidden-sm">OFERTAS</strong>
	                   </a>
	               </li>
	           </ul>
	           <div class="tab-content">
	                <div class="tab-pane fade active in" id="div_disponibilidad">
	                        <div class="typography">
	                            <div class="col-md-12">
	                                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
	                                    <label><span class="div-numeracion">1</span> Inicio Disponibilidad</label>
	                                    <input type="text" name="txt_fecha_inicio_disponibilidad" id="txt_fecha_inicio_disponibilidad" class="form-control" placeholder="Seleccione fecha">
	                                  </div>
	                                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
	                                    <label><span class="div-numeracion">2</span>Fecha Fin Disponibilidad</label>
	                                    <input type="text" name="txt_fecha_fin_disponibilidad" id="txt_fecha_fin_disponibilidad" class="form-control" placeholder="Seleccione fecha">
	                                  </div>
	                                  <div class="form-group col-md-12">
	                                    <label><span class="div-numeracion">3</span> Días Disponibles</label><br/>

	                                    <small>
	                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="0" id="chckbx_dia_0" class="diasSemana">Domingo</label>
	                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="1" id="chckbx_dia_1" class="diasSemana">Lunes</label>
	                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="2" id="chckbx_dia_2" class="diasSemana">Martes</label>
	                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="3" id="chckbx_dia_3" class="diasSemana">Miércoles</label>
	                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="4" id="chckbx_dia_4" class="diasSemana">Jueves</label>
	                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="5" id="chckbx_dia_5" class="diasSemana">Viérnes</label>
	                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="6" id="chckbx_dia_6" class="diasSemana">Sábado</label>
	                                    </small>
	                                  </div>
	                                  <div class="pull-right">
	                                    <div class="btn btn-info btn-sm" id="btn-guardar-disponibilidad"><strong><span class="fa fa-save"></span> GUARDAR</strong></div>
	                                  </div>
	                                  <input type="text" readonly name="txt_data_json_disponibilidad" id="txt_data_json_disponibilidad" class="form-control">
	                        </div>
	                    </div>
	                </div>
	                <div class="tab-pane fade" id="div_bloqueos">
	                    <div class="typography">
	                        <div class="col-md-12">
	                              <div class="form-group col-md-6 col-sm-6 col-xs-6">
	                                <label><span class="div-numeracion">1</span> Fecha Inicio Bloqueo</label>
	                                <input type="text" name="txt_fecha_inicio_bloqueo" id="txt_fecha_inicio_bloqueo" class="form-control" placeholder="Seleccione fecha">
	                              </div>
	                              <div class="form-group col-md-6 col-sm-6 col-xs-6">
	                                <label><span class="div-numeracion">2</span> Fecha Fin Bloqueo</label>

	                                <input type="text" name="txt_fecha_fin_bloqueo" id="txt_fecha_fin_bloqueo" class="form-control" placeholder="Seleccione fecha">
	                              </div>
	                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
	                                <label><span class="div-numeracion">3</span> Motivo de Bloqueo</label>
	                                <textarea name="txtr_motivo_bloqueo" id="txtr_motivo_bloqueo" class="form-control" placeholder="Describa el motivo del bloqueo"></textarea>
	                              </div>
	                              <div class="pull-right">
	                                <div class="btn btn-danger btn-sm" id="btn-guardar-bloqueo"><strong><span class="fa fa-save"></span> GUARDAR</strong></div>
	                              </div>
	                              <input type="text" readonly name="txt_data_json_bloqueo" id="txt_data_json_bloqueo" class="form-control">
	                            <div class="col-md-12 col-sm-12 col-xs-12">
	                                <label>Lista de Ofertas</label>
	                                <div style="max-height: 12em; overflow-y: auto;">
	                                  <ul class="list-group" id="list-group-bloqueo">
	                                                    
	                                  </ul>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="tab-pane fade " id="div_ofertas">
	                    <div class="typography">
	                        <div class="col-md-12">
	                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
	                                  <label><span class="div-numeracion">1</span> Fecha Inicio Oferta</label>
	                                  <input type="text" name="txt_fecha_inicio_oferta" id="txt_fecha_inicio_oferta" class="form-control" placeholder="Seleccione fecha">
	                                </div>
	                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
	                                  <label><span class="div-numeracion">2</span> Fecha Fin Oferta</label>
	                                  <input type="text" name="txt_fecha_fin_oferta" id="txt_fecha_fin_oferta" class="form-control" placeholder="Seleccione fecha">
	                                </div>
	                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
	                                  <label><span class="div-numeracion">3</span> Descuento</label>

	                                  <input type="number" min="1" name="txt_descuento_oferta" id="txt_descuento_oferta" class="form-control" placeholder="Ingrese descuento para la oferta">
	                                </div>
	                                <div class="form-group col-md-4 col-sm-4 col-xs-6">
	                                  <label>&nbsp;</label>
	                                  <select name="slct_tipo_descuento_oferta" id="slct_tipo_descuento_oferta" class="form-control">
	                                    <option value="0">%</option>
	                                    <option value="1">$ USD</option>
	                                  </select>
	                                </div>

	                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
	                                  <label><span class="div-numeracion">4</span> Color:</label>

	                                  <select id="txt_color_oferta" name="txt_color_oferta" class="form-control input-lg txt_color_oferta">
	                                    <option value="#286090" data-color="#286090">Azul </option>
	                                    <option value="#449d44" data-color="#449d44" selected="selected">Verde Lima</option>
	                                    <option value="#31b0d5" data-color="#31b0d5">Celeste</option>
	                                    <option value="#f0ad4e" data-color="#f0ad4e">Naranja</option>
	                                    <option value="#d9534f" data-color="#d9534f">Rojo</option>
	                                    <option value="#ffffff" data-color="#ffffff">Blanco</option>
	                                  </select>
	                                </div>
	                                <div class="pull-right">
	                                  <div class="btn btn-success btn-sm" id="btn-guardar-oferta"><strong><span class="fa fa-save"></span> GUARDAR</strong></div>
	                                </div>
	                                <input type="text" readonly name="txt_data_json_oferta" id="txt_data_json_oferta" class="form-control">
	                                <div class="col-md-12 col-sm-12 col-xs-12">
	                                  	<label>Lista de Ofertas</label>
	                                  	<div style="max-height: 12em; overflow-y: auto;">
	                                    	<ul class="list-group" id="list-group-oferta">

	                                    	</ul>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>                                    
	            </div>
	        </div>			
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div id='loading'>loading...</div>
			<div id='calendar'></div>
		</div>
	</div>
</div>

<!-- ---------------------------------------- MOMENT JS ------------------------------------------------ -->
<script src="https://momentjs.com/downloads/moment.min.js" type="text/javascript"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js" type="text/javascript"></script>   

<!-- -------------------------------------- FULL CALENDAR ---------------------------------------------- -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.js
" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.print.css" media="print">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/resources/bootstrap-color-selector/css/bootstrap-colorselector.min.css">
<!-- --------------------------------------------------------------------------------------------------- -->  

<style type="text/css">
  #loading {
    display: none;
    position: absolute;
    top: 3em;
    right: 3em;
  }

</style>

<script type="text/javascript">
	var objectDisponibilidad 	= {};
	var objectBloqueo			= {};
	var objectOferta			= {};
	var arrayDiasActivos        = ['0','1','2','3','4','5','6']; // Por defecto activo todos los días
	var arrayDiasNoActivos      = [];
	jQuery(document).ready(function($) {
		$('.txt_color_oferta').colorselector();
		$(document).on('change', '.diasSemana', function(event) {
			event.preventDefault();
			arrayDiasActivos.length = 0;
			arrayDiasNoActivos.length = 0;
			//$('input:checkbox[name=chckbx_dia]:checked').each(function(){
			$('input:checkbox[name=chckbx_dia]').each(function(){
			    if ( $(this).is(':checked') ) {
			    	arrayDiasActivos.push( $(this).val() );
			    }else{
			    	arrayDiasNoActivos.push( $(this).val() );
			    }
			});
		});
		$('#calendar').fullCalendar({
		    header: {
		      left: 'prev,next today',
		      center: 'title',
		      right: 'month',//,agendaWeek,agendaDay
		    },
   		    lang: 'es',
		    editable: true,
		    droppable: true,
		    navLinks: true,
		    selectable: true,
		    selectHelper: true,
		    allDaySlot: false,
		    rendering: 'inverse-background',
		    displayEventTime: false, // don't show the time column in list view
		    events: [
		        {
		          title: 'All Day Event',
		          start: '2018-02-01'
		        },
		        {
		          title: 'Long Event',
		          start: '2018-02-07',
		          end: '2018-02-10'
		        },
		    ],
		    drop: function() {
		      if ($('#drop-remove').is(':checked')) {
		        $(this).remove();
		      }
		    }, 
		    dayClick: function() {
		      alert('a day has been clicked!');
		    },
		    select: function(start, end) {
		    	var title = prompt('Event Title:');
		        var eventData;
		        if (title) {
					eventData = {
						title: title,
						start: start,
						end: end
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true);
		        }
		        $('#calendar').fullCalendar('unselect');
		    },
		    eventClick: function(event) {
		    	alert( event );
		    	console.log(event);
		    },
		    dayRender: function (date, cell) {

		    },
		    loading: function(bool) {
		        $('#loading').toggle(bool);
		    }
    	});

		$(document).on('click', '#btn-guardar-disponibilidad', function(event) {
			event.preventDefault();
			var fecha_inicio_disponibilidad = $("#txt_fecha_inicio_disponibilidad").val();
			var fecha_fin_disponibilidad    = $("#txt_fecha_fin_disponibilidad").val();
			
			if ( fecha_inicio_disponibilidad.length != 0 && fecha_fin_disponibilidad.length != 0 && arrayDiasActivos.length > 0 ) {
			  fecha_inicio_disponibilidad     = moment(fecha_inicio_disponibilidad,"DD-MM-YYYY").format("YYYY-MM-DD");
			  fecha_fin_disponibilidad        = moment(fecha_fin_disponibilidad,"DD-MM-YYYY").format("YYYY-MM-DD");
			  
			  var data_disponibilidad = {
			    id      : null,
			    start   : fecha_inicio_disponibilidad+" 00:00:00",
			    end     : fecha_fin_disponibilidad+" 23:59:59",
			    title   : 'Disponible',
			    color   : '#5bc0de',
			    dias_activos: arrayDiasActivos,
			    dias_no_activos: arrayDiasNoActivos,
			    //dias_especiales: array_dias_especiales,
			    //meses_inactivos: array_meses_inactivos, 
			  };
			  
			  js_disponibilidad.set_datos_disponibilidad(data_disponibilidad);
			  var json_data_disponibilidad  =js_disponibilidad.get_datos_disponibilidad();
			  $("#txt_data_json_disponibilidad").empty().val( JSON.stringify(json_data_disponibilidad) );
			  actualizar_disponibilidad(fecha_inicio_disponibilidad,fecha_fin_disponibilidad);

			  swal("DISPONIBILIDAD","La disponibilidad se ha actualizado correctamente.","success");
			  //bloquearFechasEspeciales(fecha_inicio_disponibilidad,fecha_fin_disponibilidad);
			}else{
			  swal("ERROR DISPONIBILIDAD","Asegúrese de haber completado todos los campos como la fecha inicio de la disponibilidad, la fecha fin de disponibilidad y seleccionar los días disponibles. ","error");
			}
		});



		/********************************* DATEPICKER'S *********************************/
		$("#txt_fecha_inicio_disponibilidad").datepicker({
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onSelect: function(selectedDate){
				$("#txt_fecha_fin_disponibilidad").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#txt_fecha_fin_disponibilidad").datepicker({
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
		});
		$("#txt_fecha_inicio_bloqueo").datepicker({
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onSelect: function(selectedDate){
				$("#txt_fecha_fin_bloqueo").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#txt_fecha_fin_bloqueo").datepicker({
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
		});
		$("#txt_fecha_inicio_oferta").datepicker({
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onSelect: function(selectedDate){
				$("#txt_fecha_fin_oferta").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#txt_fecha_fin_oferta").datepicker({
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
		});
	});
</script>