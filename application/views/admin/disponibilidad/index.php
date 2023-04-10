<link rel='stylesheet' href='<?=base_url();?>assets/resources/fullcalendar/fullcalendar.min.css' />
<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap-select/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- <h4 class="text-center"><strong><span class="fa fa-calendar text-success"></span> DISPONIBILIDAD DE TOURS Y PAQUETES TURISTICOS</strong></h4><hr/> -->
            <div class="headline">
                <div><span class="div-numeracion">1</span> REQUERIR DISPONIBLIDAD ANTES DE LA COMPRA</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="checkbox">
                <label>
                    <strong><input type="checkbox" name="chckbxRequirirDisponibilidad" id="chckbxRequirirDisponibilidad" <?=(@$requerir_disponibilidad?'checked':'')?> ></strong>
                    <p><strong>Requirir disponibilidad antes de realizar la compra</strong> (Al activar este campo no se podrá comprar el servicio/actividad hasta antes de verificar la disponibilidad).</p>
                </label>
            </div>
        </div>
    </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <!-- <h4 class="text-center"><strong><span class="fa fa-calendar text-success"></span> DISPONIBILIDAD DE TOURS Y PAQUETES TURISTICOS</strong></h4><hr/> -->
      <div class="headline">
        <div><span class="div-numeracion">2</span> DISPONIBILIDAD, BLOQUEOS y OFERTAS</div>
      </div>
      </div>
    </div>
  <div class="row">
    <div class="col-md-5 col-sm-5 col-xs-12">
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
                           <div class="col-md-12" style="padding:0;">
                               <!-- <div class="headline">
                                  <div>DISPONIBILIDAD</div>
                               </div> -->

                             <!--  <div class="panel panel-info">
                               <div class="panel-heading"><strong><span class="fa fa-calendar-check-o"></span> DISPONIBILIDAD</strong></div>
                               <div class="panel-body">
                               <<<< -->
                               <div class="alert alert-danger"><strong><small><span class="fa fa-warning"></span> Para cualquier cambio haga click en GUARDAR DISPONIBILIDAD</small></strong></div>
                                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label><span class="div-numeracion">1</span> DESDE</label>
                                    <input type="text" name="txt_fecha_inicio_disponibilidad" id="txt_fecha_inicio_disponibilidad" class="form-control" placeholder="Seleccione fecha" required data-error="Seleccione fecha inicio de la disponibilidad de la actividad">
                                  </div>
                                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label><span class="div-numeracion">2</span>HASTA</label>
                                    <input type="text" name="txt_fecha_fin_disponibilidad" id="txt_fecha_fin_disponibilidad" class="form-control" placeholder="Seleccione fecha" required data-error="Seleccione fecha final de la Disponibilidad de la actividad">
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label><span class="div-numeracion">3</span> Días Disponibles</label><br/>

                                    <small>
                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="1" id="chckbx_dia_1" class="chckbx_dia">Lunes</label>
                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="2" id="chckbx_dia_2" class="chckbx_dia">Martes</label>
                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="3" id="chckbx_dia_3" class="chckbx_dia">Miércoles</label>
                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="4" id="chckbx_dia_4" class="chckbx_dia">Jueves</label>
                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="5" id="chckbx_dia_5" class="chckbx_dia">Viérnes</label>
                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="6" id="chckbx_dia_6" class="chckbx_dia">Sábado</label>
                                      <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="0" id="chckbx_dia_0" class="chckbx_dia">Domingo</label>
                                    </small>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label><span class="div-numeracion">4</span> Bloquear Feriados y Días Especiales </label><br/>
                                    <p><small>Al seleccionar se bloquearán las fechas de  todos los años que esten dentro de la disponibilidad</small></p>
                                    <small>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="dias_especiales[]" class="dias_especiales" value="25-12" id="dias_especiales_25-12"> <strong>NAVIDAD <small> (25 de Diciembre)</small></strong>
                                        </label>
                                      </div>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="dias_especiales[]" class="dias_especiales" value="31-12" id="dias_especiales_31-12"> <strong>FIN DE AÑO<small> (31 de Diciembre)</small></strong>
                                        </label>
                                      </div>
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="dias_especiales[]" class="dias_especiales" value="1-1" id="dias_especiales_1-1"> <strong>AÑO NUEVO<small> (01 de Enero)</small></strong>
                                        </label>
                                      </div>
                                    </small>
                                  </div>
                                  <div class="pull-left">
                                    <div class="btn btn-danger xl" id="btn-guardar-disponibilidad"><strong><span class="fa fa-save"></span> GUARDAR DISPONIBILIDAD</strong></div>
                                  </div><div class="row">
                                      <div class="col-md-12"><hr/>
                                  <input type="text" readonly name="txt_data_json_disponibilidad" id="txt_data_json_disponibilidad" class="form-control" required data-error="Por favor haga click en el botón GUARDAR DISPONIBILIDAD">
                                </div></div>
                            </div>
                      </div>
                </div>
               <div class="tab-pane fade" id="div_bloqueos">
                   <div class="typography">
                       <div class="col-md-12" style="padding:0;">
                          <!-- <div class="headline">
                               <div>BLOQUEOS</div>
                            </div> -->

                         <!--  <div class="panel panel-danger">
                           <div class="panel-heading"><strong><span class="fa fa-ban"></span> BLOQUEOS</strong></div>
                           <div class="panel-body"> -->
                              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                <label><span class="div-numeracion">1</span> DESDE</label>
                                <input type="text" name="txt_fecha_inicio_bloqueo" id="txt_fecha_inicio_bloqueo" class="form-control" placeholder="Seleccione fecha">
                              </div>
                              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                <label><span class="div-numeracion">2</span> HASTA</label>

                                <input type="text" name="txt_fecha_fin_bloqueo" id="txt_fecha_fin_bloqueo" class="form-control" placeholder="Seleccione fecha">
                              </div>
                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label><span class="div-numeracion">3</span> Motivo de Bloqueo</label>
                                <textarea name="txtr_motivo_bloqueo" id="txtr_motivo_bloqueo" class="form-control" placeholder="Describa el motivo del bloqueo"></textarea>
                              </div>
                              <div class="pull-left">
                                <div class="btn btn-danger btn-xl" id="btn-guardar-bloqueo"><strong><span class="fa fa-save"></span> GUARDAR BLOQUEOS</strong></div>
                              </div>
                              <input type="hidden" readonly name="txt_data_json_bloqueo" id="txt_data_json_bloqueo" class="form-control">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Lista de Bloqueos</label>
                                <div style="max-height: 12em; overflow-y: auto;">
                                  <ul class="list-group" id="list-group-bloqueo">
                                                    
                                  </ul>
                                </div>
                              </div>
                           <!--  </div>
                                                     </div> -->
                       </div>
                   </div>
               </div>
               <div class="tab-pane fade " id="div_ofertas">
                   <div class="typography">
                       <div class="col-md-12">
                         <!--  <div class="headline">
                                  <div>OFERTAS</div>
                            </div> -->
                            <!-- <div class="panel panel-success">
                              <div class="panel-heading"><strong><span class="fa fa-star-o"></span> OFERTAS</strong></div>

                              <div class="panel-body"> -->
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                  <label><span class="div-numeracion">1</span> DESDE</label>
                                  <input type="text" name="txt_fecha_inicio_oferta" id="txt_fecha_inicio_oferta" class="form-control" placeholder="Seleccione fecha">
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                  <label><span class="div-numeracion">2</span> HASTA</label>
                                  <input type="text" name="txt_fecha_fin_oferta" id="txt_fecha_fin_oferta" class="form-control" placeholder="Seleccione fecha">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                  <label><span class="div-numeracion">3</span> Descuento</label>

                                  <input type="number" min="1" name="txt_descuento_oferta" id="txt_descuento_oferta" class="form-control" placeholder="Ingrese descuento para la oferta">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
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
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="pull-left">
                                    <div class="btn btn-success btn-xl" id="btn-guardar-oferta"><strong><span class="fa fa-save"></span> GUARDAR OFERTAS</strong></div>
                                  </div>
                                  <input type="hidden" readonly name="txt_data_json_oferta" id="txt_data_json_oferta" class="form-control">
                                  <hr/>
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
    <div class="col-md-7 col-sm-7 col-xs-12">
      <!--
      <div class="form-group">      
        <select class="selectpicker form-control input-lg" name="slct_disponibilidad" id="slct_disponibilidad" data-live-search="true">
          <option value="">Seleccionar, Buscar...</option>
          <option value="1">Hot Dog, Fries and a Soda</option>
          <option value="2">Burger, Shake and a Smile</option>
          <option value="3">Sugar, Spice and all things nice</option>
        </select>    
      </div>
      -->
      <div id='calendario_incalake' style="display: block;"></div>
      <div style='clear:both'></div>
    </div>
  </div>
</div>


<!-- ---- MODAL FOR CLINK IN DAY -- -->
<div class="modal fade" id="modalFecha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center" id="exampleModalLabel"><small><strong><span class="fa fa-list text-success"></span> FECHA <span id="title_modalEditarFecha"></span></strong></small></h4>
            </div>
            <div class="modal-body" style="min-height: 20em;">
                <form id="formAddDisponibilidad">
                    <div class="form-group">
                      <input type="text" name="txt_fechas_modal" class="form-control txt_fechas_modal" id="txt_fechas_modal" >
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Seleccione...</label>
                        <select class="form-control validate[required]" name="slct_tipo_dia" id="slct_tipo_dia" >
                        <option value="">Seleccione...</option>
                        <option value="0">Bloqueo</option>
                        <option value="1">Oferta</option>
                        </select>
                        <p class="help-block">Seleccione una opción y establesca lo que ocurrrá con él rango de fecha seleccionada.</p>
                    </div>
                    <div id="modal_div_bloqueo" style="display: none;">
                      <div class="form-group">
                        <label for="message-text" class="control-label">Descripción del Motivo de Bloqueo <i>(OPCIONAL)</i>:</label>
                        <span class="pull-right"><strong><span id="span_letter_count">0/128</span></strong></span>
                        <textarea class="form-control" name="txtr_descripcion_bloqueo_modal" id="txtr_descripcion_bloqueo_modal"></textarea>
                        <p class="help-block">En <i>Descripción del Motivo de Bloqueo </i> describa una breve descripción acerca del Motivo de bloqueo. Ejemplo: Huelga: Huelga realizada por los pobladores que bloquearán la vía pública, lo cual no permitirá el acceso a la ciudad de Puno.</p>
                      </div>
                    </div>
                    <div id="modal_div_oferta" style="display: none;">
                      <div class="form-group col-md-6 col-sm-6 col-xs-6">
                        <label>Descuento para la oferta</label>
                        <input type="number" min="1" name="txt_descuento_oferta_modal" id="txt_descuento_oferta_modal" class="form-control" placeholder="Ingrese descuento para la oferta">
                      </div>
                      <div class="form-group col-md-3 col-sm-3 col-xs-3">
                        <label>&nbsp;</label>
                        <select name="slct_tipo_descuento_oferta_modal" id="slct_tipo_descuento_oferta_modal" class="form-control">
                          <option value="0">%</option>
                          <option value="1">$ USD</option>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <label>&nbsp;</label>
                        <select id="txt_color_oferta_modal" name="txt_color_oferta_modal" class="form-control input-lg txt_color_oferta">
                          <option value="#286090" data-color="#286090">Azul </option>
                          <option value="#449d44" data-color="#449d44" selected="selected">Verde Lima</option>
                          <option value="#31b0d5" data-color="#31b0d5">Celeste</option>
                          <option value="#f0ad4e" data-color="#f0ad4e">Naranja</option>
                          <option value="#d9534f" data-color="#d9534f">Rojo</option>
                          <option value="#ffffff" data-color="#ffffff">Blanco</option>
                        </select>
                      </div>      
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-guardar-modal">GUARDAR</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- -------------------------------------------------------------------------------------------------- -->

<script src='<?=base_url();?>assets/resources/moment/moment.min.js'></script>
<script src='<?=base_url();?>assets/resources/fullcalendar/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/gcal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/locale-all.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script src='<?=base_url();?>assets/resources/bootstrap-color-selector/js/bootstrap-colorselector.min.js'></script>

<script type="text/javascript" src="<?=base_url().'assets/js/objetos.js';?>"></script>

<script type="text/javascript">
  contador_letras('txtr_descripcion_bloqueo_modal','span_letter_count',128);
  $('.txt_color_oferta').colorselector();
  $(document).on('change', '#slct_tipo_dia', function(event) {
    event.preventDefault();
    var select_tipo  = $(this).val();
    switch(select_tipo){
      case '0':
        $("#modal_div_bloqueo").css("display", "block");
        $("#modal_div_oferta").css("display", "none");
        $("#txtr_descripcion_bloqueo_modal").focus();
      break;
      case '1':
        $("#modal_div_oferta").css("display", "block");
        $("#modal_div_bloqueo").css("display", "none");  
        $("#txt_descuento_oferta_modal").focus();
      break;
      default:
        $("#modal_div_bloqueo").css("display", "none");
        $("#modal_div_oferta").css("display", "none");  
      break;
    }
    console.log($(this).val() );
  });
</script>

<script type="text/javascript">
var js_disponibilidad = new Disponibilidad();
var js_bloqueo        = new Bloqueo();
var js_oferta         = new Oferta();  
var cantidad_dias_inicio_disponibilidad = '';
var cantidad_dias_fin_disponibilidad = '';
var array_dias_no_activos = new Array();
var array_dias_especiales = new Array();
var array_meses_inactivos = new Array();

$("#formAddDisponibilidad").validationEngine('attach', {
  relative: true,
  promptPosition:"bottomLeft"
});

jQuery(document).ready(function($) {
  var eventos = { items: [] };
  $('#calendario_incalake').fullCalendar({
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
      var start = moment(fstart,"DD-MM-YYYY").format("YYYY-MM-DD") + " 00:00:00";
      var string_end   = moment(fend,"DD-MM-YYYY").format("YYYY-MM-DD");
      var array_end    = string_end.split("-");
      var temp_end     = moment(fend,"DD-MM-YYYY").subtract(1,'days');
      //var end          = moment( array_end[0]+"-"+array_end[1]+"-"+( parseInt(array_end[2]) -1 ) ,"YYYY-MM-DD").format("YYYY-MM-DD");
      var end          = moment(temp_end).format("YYYY-MM-DD") + " 23:59:59"; 
      //console.log("INICIO: "+ start + "  -  " + "FIN: " + end );
      if ( dia_no_disponible( start ) ) {
        return false;
      }
      if ( js_disponibilidad.get_cantidad_disponibilidades() > 0 ) {
        var response_validez_fecha_bloqueo  = js_disponibilidad.fecha_disponible( start, end );         
        if ( response_validez_fecha_bloqueo === true ) {
          var response_validez_duplicidad_con_bloqueo = js_bloqueo.get_fecha_es_bloqueo( start, end );
          if ( response_validez_duplicidad_con_bloqueo === false ) {
            var response_validez_duplicidad_con_oferta  = js_oferta.get_fecha_es_oferta(start,end);
            if ( response_validez_duplicidad_con_oferta === false ) { 
              $("#txt_fechas_modal").empty().val( ( fstart.format() ) + ";" + ( fend.format() ) );
              $("#modal_div_bloqueo").css("display", "none");
              $("#modal_div_oferta").css("display", "none"); 
              $('#modalFecha').modal('show');
              console.log("Click..!");
            }else{
              //swal("ERROR","Esta fecha ya esta en oferta.","error");
            }
          }else{
            //swal("ERROR","Esta fecha ya esta bloqueada.","error");  
          }
        }else{
          swal("ERROR","Has seleccionado una fecha que está fuera de la fecha de disponibilidad.","error");
        }
      }else{
        swal("ERROR FECHA DISPONIBILIDAD","Antes de aplicar un bloqueo u oferta seleccione la fecha inicio de disponibilidad y fecha fin disponibilidad.","error");
      }
    },
    editable: true,
    eventLimit: true,
    eventClick: function(event) {
      switch(event.estado){
        case 'disponibilidad':
          swal( (event.estado).toUpperCase(),event.title,"success");
        break;
        case 'bloqueo':
          swal( (event.estado).toUpperCase(),"Desde el " + (event.start).format("DD-MM-YYYY") + " hasta el " + (event.end).format("DD-MM-YYYY") + ": " + event.title,"success");
        break;
        case 'oferta':
          swal( (event.estado).toUpperCase(),event.title,"success");
        break;
        default:
          swal(event.title,(event.start).format('DD-MM-YYYY'),"success");
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
          var dia_nombre = moment( date.format()).weekday();
          //console.log("DIA: ", dia_nombre,array_dias_no_activos );
          for(var i in array_dias_no_activos){
            var dia_no_activo_de_la_semana = (parseInt( array_dias_no_activos[i] ) - 1 );
            //En formato php empieza el domingo = 0 y sabado = 6; en fullcalendar lunes = 0 y domingo = 6, entonces si restamos -1 a los dias para el domingo caeria -1, por eso que si pasa eso se entiende que domingo es igual 6
            if ( dia_no_activo_de_la_semana < 0 ) { dia_no_activo_de_la_semana = 6; }
            if ( dia_no_activo_de_la_semana === parseInt(dia_nombre) ) {
            //if ( (parseInt( array_dias_no_activos[i] ) ) === dia_nombre ) {  
              //console.log( (array_dias_no_activos[i] )+" = "+dia_nombre);
              cell.css("background-color", "#f2dede");    
            }
          }
        }
      }
    }
  });

  /********************************* DATEPICKER'S *********************************/
  $("#txt_fecha_inicio_disponibilidad").datepicker(
    {
      dateFormat:'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      onSelect: function(selectedDate){
            $("#txt_fecha_fin_disponibilidad").datepicker("option", "minDate", selectedDate);
        }
    }
  );
  $("#txt_fecha_fin_disponibilidad").datepicker(
    {
      dateFormat:'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      minDate: 0,
    }
  );
  $("#txt_fecha_inicio_bloqueo").datepicker(
    {
      dateFormat:'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      onSelect: function(selectedDate){
            $("#txt_fecha_fin_bloqueo").datepicker("option", "minDate", selectedDate);
        }
    }
  );
  $("#txt_fecha_fin_bloqueo").datepicker(
    {
      dateFormat:'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      minDate: 0,
    }
  );
  $("#txt_fecha_inicio_oferta").datepicker(
    {
      dateFormat:'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      onSelect: function(selectedDate){
        $("#txt_fecha_fin_oferta").datepicker("option", "minDate", selectedDate);
      }
    }
  );
  $("#txt_fecha_fin_oferta").datepicker(
    {
      dateFormat:'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      minDate: 0,
    }
  );

  $(document).on('click', '#btn-guardar-disponibilidad', function(event) {
    event.preventDefault();
    var array_dias = new Array();
    var fecha_inicio_disponibilidad = $("#txt_fecha_inicio_disponibilidad").val();
    var fecha_fin_disponibilidad    = $("#txt_fecha_fin_disponibilidad").val();
    
    $('input:checkbox[name=chckbx_dia]:checked').each(function(){
         array_dias.push( $(this).val() );
    });
    if ( fecha_inicio_disponibilidad.length != 0 && fecha_fin_disponibilidad.length != 0 && array_dias.length > 0 ) {
      fecha_inicio_disponibilidad     = moment(fecha_inicio_disponibilidad,"DD-MM-YYYY").format("YYYY-MM-DD");
      fecha_fin_disponibilidad        = moment(fecha_fin_disponibilidad,"DD-MM-YYYY").format("YYYY-MM-DD");
      
      var data_disponibilidad = {
        id      : null,
        start   : fecha_inicio_disponibilidad+" 00:00:00",
        end     : fecha_fin_disponibilidad+" 23:59:59",
        title   : 'Disponible',
        color   : '#5bc0de',
        dias_activos: array_dias,
        dias_no_activos: array_dias_no_activos,
        dias_especiales: array_dias_especiales,
        meses_inactivos: array_meses_inactivos, 
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

  $(document).on('click', '#btn-guardar-bloqueo', function(event) {
    event.preventDefault();
    var fecha_inicio_bloqueo = $("#txt_fecha_inicio_bloqueo").val();
    var fecha_fin_bloqueo    = $("#txt_fecha_fin_bloqueo").val(); 
    fecha_inicio_bloqueo     = moment(fecha_inicio_bloqueo,"DD-MM-YYYY").format("YYYY-MM-DD");
    fecha_fin_bloqueo        = moment(fecha_fin_bloqueo,"DD-MM-YYYY").format("YYYY-MM-DD");
    var temp_disponibilidad  = js_disponibilidad.get_datos_disponibilidad();
    if ( ($("#txt_fecha_inicio_bloqueo").val()).length != 0 && ($("#txt_fecha_fin_bloqueo").val()).lenght != 0 && js_disponibilidad.get_cantidad_disponibilidades() > 0 ) {
      var bloqueo_fecha_disponible = js_disponibilidad.fecha_disponible(fecha_inicio_bloqueo+" 00:00:00", fecha_fin_bloqueo+" 23:59:59");
      if ( bloqueo_fecha_disponible === true ) {
        var bloqueo_fecha_bloqueo_disponible = js_bloqueo.get_fecha_es_bloqueo(fecha_inicio_bloqueo+" 00:00:00", fecha_fin_bloqueo+" 23:59:59");
        if ( bloqueo_fecha_bloqueo_disponible === false ) {
          var data_bloqueo = {
            id        : null,
            start     : fecha_inicio_bloqueo+" 00:00:00",
            end       : fecha_fin_bloqueo+" 23:59:59",
            title     : $("#txtr_motivo_bloqueo").val(),
            color     : '#d9534f',
          };
          js_bloqueo.set_datos_bloqueo(data_bloqueo);
          actualizar_eventos();
          swal("BLOQUEO","El Bloqueo se ha establecido correctamente.","success");
          $("#txt_fecha_inicio_bloqueo").val('');
          $("#txt_fecha_fin_bloqueo").val('');
          $("#txtr_motivo_bloqueo").val('')
        }else{
          swal("ERROR","La fecha que intentas boquear ya esta bloqueado..!","error");
        }
      }else{
        swal(
          "ERROR BLOQUEO",
          "La fecha de bloqueo: "+moment(fecha_inicio_bloqueo).format("DD-MMM-YYYY")+ " hasta el "+moment(fecha_fin_bloqueo).format("DD-MMM-YYYY")+
          " está fuera de la fecha de disponibilidad que es desde el "+ moment(temp_disponibilidad.start).format("DD-MMM-YYYY")+" hasta el "+moment(temp_disponibilidad.end).format("DD-MMM-YYYY")+".",
          "error"
        );
      }
    }else{
      swal("ERROR BLOQUEO","El bloqueo no se ha podido establecer, Asegúrese de haber completado las fecha de disponibilidad y luego establecer una fecha de bloqueo.","error");
    }
  });

  $(document).on('click', '#btn-guardar-oferta', function(event) {
    event.preventDefault();
    var fecha_inicio_oferta = $("#txt_fecha_inicio_oferta").val();
    var fecha_fin_oferta    = $("#txt_fecha_fin_oferta").val(); 
    var cantidad_descuento  = $("#txt_descuento_oferta").val();
    var tipo_descuento_oferta= $("#slct_tipo_descuento_oferta").val();
    var color_oferta        = $("#txt_color_oferta").val();

    fecha_inicio_oferta = moment(fecha_inicio_oferta,'DD-MM-YYYY').format("YYYY-MM-DD");
    fecha_fin_oferta    = moment(fecha_fin_oferta,'DD-MM-YYYY').format("YYYY-MM-DD");

    if (fecha_inicio_oferta.length != 0 && fecha_fin_oferta.length != 0 && cantidad_descuento.length != 0 && js_disponibilidad.get_cantidad_disponibilidades() > 0 ) {
      var oferta_fecha_disponible = js_disponibilidad.fecha_disponible(fecha_inicio_oferta+" 00:00:00", fecha_fin_oferta+" 23:59:59");
      if ( oferta_fecha_disponible === true ) {
        var oferta_fecha_bloqueo_disponible = js_bloqueo.get_fecha_es_bloqueo(fecha_inicio_oferta+" 00:00:00", fecha_fin_oferta+" 23:59:59"); 
        if ( oferta_fecha_bloqueo_disponible === false ) {
          var oferta_fecha_valida = js_oferta.get_fecha_es_oferta(fecha_inicio_oferta+" 00:00:00", fecha_fin_oferta+" 23:59:59");
          if ( oferta_fecha_valida === false ) {
              var string_tipo_descuento = parseInt(tipo_descuento_oferta) ? '$ USD' : '%';
              var data_oferta = {
                id        : null,
                start     : fecha_inicio_oferta+" 00:00:00",
                end       : fecha_fin_oferta+" 23:59:59",
                descuento : cantidad_descuento,
                tipo_descuento: tipo_descuento_oferta,
                title       : 'Oferta: '+"-"+cantidad_descuento+string_tipo_descuento,
                color       : color_oferta,
              };
              js_oferta.set_datos_oferta(data_oferta);
              actualizar_eventos();
              swal("OFERTA","La oferta se ha establecido correctamente.","success");
              $("#txt_fecha_inicio_oferta").val('');
              $("#txt_fecha_fin_oferta").val('');
              $("#txt_descuento_oferta").val('');     
          }else{
            swal("ERROR OFERTA","La fecha de oferta que seleccionaste ya está en uso por otro tipo de oferta.","error");
          }
        }else{
          swal("ERROR OFERTA","La fecha de oferta que seleccionaste esta bloqueado y no se puede aplicar oferta.","error");
        }
      }else{
        swal("ERROR OFERTA","La fecha de la oferta que has eligido esta fuera del rango de fecha de disponibilidad","error");
      }
    }else{
      swal("ERROR OFERTA","La oferta no se ha podido establecer","error");
    }  
  });

  $(document).on('click', '.btn-delete-objeto', function(event) {
    event.preventDefault();
    var string_fecha    = $(this).data('id');
    var string_tipo     = $(this).data('tipo');
    var string_idObjeto = $(this).data('idobjeto');
    var array_fechas    = string_fecha.split(';');
    console.log(string_idObjeto);
    //bloqueo = 0,  oferta = 1
    switch(parseInt(string_tipo)){
      case 0:
        js_bloqueo.get_eliminar_bloqueo(array_fechas[0],array_fechas[1]);
        actualizar_eventos();
        eliminarObjeto(string_idObjeto,'bloqueo');
      break;
      case 1:
        js_oferta.get_eliminar_oferta(array_fechas[0],array_fechas[1]);
        actualizar_eventos();
        eliminarObjeto(string_idObjeto,'oferta');
      break;
    }
  });
  

  $(document).on('click', '.btn-guardar-modal', function(event) {
    event.preventDefault();
    var select_tipo     = $("#slct_tipo_dia").val();
    var string_fechas   = $("#txt_fechas_modal").val();
    var array_fechas    = string_fechas.split(";"); 
    var fecha_end_tokens= array_fechas[1].split("-");
    var fecha_start     = moment(array_fechas[0], "YYYY-MM-DD").format("YYYY-MM-DD"); 
    var fecha_end       = moment(fecha_end_tokens[0]+"-"+fecha_end_tokens[1]+"-"+(parseInt(fecha_end_tokens[2]) - 1 ), "YYYY-MM-DD").format("YYYY-MM-DD");
    console.log("START: " +fecha_start+ " END: " + fecha_end);
    if ( !$.isNumeric( select_tipo ) ) {
      swal("ERROR","Seleccione tipo... ","error");
    }else{
      switch( parseInt(select_tipo) ){
        case 0:
          var descripcion_bloqueo = $("#txtr_descripcion_bloqueo_modal").val();
          var data_bloqueo_modal = {
            id        : null,
            start     : fecha_start + " 00:00:00",
            end       : fecha_end + " 23:59:59",
            title     : descripcion_bloqueo,
            color     : '#d9534f',
          };
          
          js_bloqueo.set_datos_bloqueo( data_bloqueo_modal );
          actualizar_eventos();
          $('#modalFecha').modal('hide');
          $("#txtr_descripcion_bloqueo_modal").val("");
          $('#slct_tipo_dia').prop('selectedIndex',0);
        break;
        case 1:
          // 0 = porcentaje, 1 = cantidad en USD 
          var descuento_oferta    = $("#txt_descuento_oferta_modal").val();
          var tipo_descuento_oferta   = $("#slct_tipo_descuento_oferta_modal").val();
          var string_descripcion_oferta_modal  = parseInt( tipo_descuento_oferta ) ? '$ USD' : '%';
          var color_oferta_modal    = $("#txt_color_oferta_modal").val();
          console.log(array_fechas[1]);
          var data_oferta_modal = {
            id        : null,
            start     : fecha_start + " 00:00:00",
            end       : fecha_end + " 23:59:59",
            title     : 'Oferta: -'+descuento_oferta+string_descripcion_oferta_modal,
            color       : color_oferta_modal,
            descuento   : descuento_oferta,
            tipo_descuento : tipo_descuento_oferta
          };

          js_oferta.set_datos_oferta( data_oferta_modal );
          actualizar_eventos();

          $('#modalFecha').modal('hide');
          $("#txt_descuento_oferta_modal").val("");
          $('#slct_tipo_dia').prop('selectedIndex',0);
        break;
        default:
          console.log("Default click..!");
        break;
      }
    }
  });

  $(document).on('change', '.chckbx_dia', function(event) {
    event.preventDefault();
    //var id_dia = $(this).val();
    array_dias_no_activos.length = 0;
    $('input:checkbox[name=chckbx_dia]').each(function(){
      if( $(this).is(':checked') ){
        //console.log("CHECK DIA: " + id_dia );
      }else{
        array_dias_no_activos.push( $(this).val() );
        //console.log("UNCHECK DIA: " + id_dia );
      }         
    });
    //console.log(array_dias_no_activos);
  });

  $(document).on('change', '.dias_especiales', function(event) {
    event.preventDefault();
    var  dia_especial = $(this).val();
    var fecha_inicioX = $("#txt_fecha_inicio_disponibilidad").val();
    var fecha_finX    = $("#txt_fecha_fin_disponibilidad").val();
    if ( fecha_inicioX.trim().length != 0 && fecha_finX.trim().length != 0 ) {
      if( $(this).is(':checked') ) {
        console.log("DIA ESPECIAL:",dia_especial);      
        fecha_inicioX     = moment(fecha_inicioX,"DD-MM-YYYY").format("YYYY-MM-DD");
        fecha_finX        = moment(fecha_finX,"DD-MM-YYYY").format("YYYY-MM-DD");
        bloquearDiaEspecial(dia_especial,fecha_inicioX,fecha_finX);
        addArrayDiasEspeciales(dia_especial.trim());
        console.log(JSON.stringify(array_dias_especiales));
      }else{
        //console.log("Un select..!");
        fecha_inicioX     = moment(fecha_inicioX,"DD-MM-YYYY").format("YYYY-MM-DD");
        fecha_finX        = moment(fecha_finX,"DD-MM-YYYY").format("YYYY-MM-DD");
        eliminarDiaEspecial(dia_especial,fecha_inicioX,fecha_finX);
        deleteArrayDiasEspeciales(dia_especial.trim());
        console.log(JSON.stringify(array_dias_especiales));
      }
    }else{
      swal("Notificación","Primero establezca las fechas de disponibilidad","warning");
      $(this).prop('checked', false);
    }
  });

});

function eliminarObjeto(id,uri){
  $.ajax({
    url: '<?=base_url();?>admin/'+uri+'/eliminar_'+uri,
    type: 'POST',
    dataType: 'json',
    data: {id: id},
  }).done(function(data) {
    console.log(data);
  }).fail(function(e) {
    console.log(e.responseText);
  });
}

function actualizar_disponibilidad(f_inicio,f_fin){
  cantidad_dias_inicio_disponibilidad = moment(f_inicio+" 23:59:59").diff( moment(),"days");
  cantidad_dias_fin_disponibilidad    = moment(f_fin+" 23:59:59").diff(f_inicio,"days");
  $('#calendario_incalake').fullCalendar( 'next' );
  $('#calendario_incalake').fullCalendar( 'prev' );     
}

function actualizar_eventos(){
  var html_bloqueo = '', html_oferta = '';
  $('#calendario_incalake').fullCalendar('removeEvents');
  $.each(js_bloqueo.get_datos_bloqueo(), function(index, val) {
    var fInicioBloqueo = moment(val.end).format("DD-MM-YYYY");
    var fFinBloqueo    = moment(val.start).format("DD-MM-YYYY");
    var descripcionBloqueo = (val.title.trim().length>0?val.title.trim():fInicioBloqueo+' Bloqueado' );
    html_bloqueo += '<li class="list-group-item">'+descripcionBloqueo+'<span class="pull-right fa fa-close text-danger btn btn-delete-objeto" data-id="'+val.start+';'+val.end+'" data-tipo="0" data-idobjeto="'+val.id+'" title="Eliminar Fecha Bloqueada"></span></li>';
    $('#calendario_incalake').fullCalendar('renderEvent', val, true);
    $('#calendario_incalake').fullCalendar('unselect');
  });
  $("#list-group-bloqueo").empty().append(html_bloqueo);
  $("#txt_data_json_bloqueo").empty().val(JSON.stringify( js_bloqueo.get_datos_bloqueo() ) );

  $.each(js_oferta.get_datos_oferta(), function(index, val) {
    html_oferta += '<li class="list-group-item">'+val.title+'<span class="pull-right fa fa-close text-danger btn btn-delete-objeto" data-id="'+val.start+';'+val.end+'" data-tipo="1" data-idobjeto="'+val.id+'" title="Eliminar fecha en Oferta"></span></li>';
    $('#calendario_incalake').fullCalendar('renderEvent', val, true);
    $('#calendario_incalake').fullCalendar('unselect');
  });
  $("#list-group-oferta").empty().append(html_oferta);
  $("#txt_data_json_oferta").empty().val(JSON.stringify(js_oferta.get_datos_oferta() ) );
}

function dia_no_disponible(date){
    var dia_nombre = moment(date).weekday();
    for(var i in array_dias_no_activos){
      //if ( (parseInt( array_dias_no_activos[i] ) - 1 ) === dia_nombre ) {
      if ( (parseInt( array_dias_no_activos[i] ) ) === dia_nombre ) {
        return true;    
      }
    }   
    return false;
}
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var target = $(e.target).attr("href"); // activated tab
  var fieldset = $(this).parents('fieldset');
  switch(target){
    case '#div_disponibilidad':

    break;
    case '#div_bloqueos':
      if ( fieldset.find('input#txt_fecha_inicio_disponibilidad').val().trim().length === 0  || 
           fieldset.find('input#txt_fecha_fin_disponibilidad').val().trim().length === 0 ) {
        activarTab();
        swal("Upps..!","Para bloquear fechas, Primero tienes que establecer la disponibilidad","warning");
      }        
    break;
    case '#div_ofertas':
      if ( $('#txt_fecha_inicio_disponibilidad').val().trim().length === 0  || 
           $('#txt_fecha_fin_disponibilidad').val().trim().length === 0 ) {
        activarTab();
        swal("Upps..!","Para poner ofertas, Primero tienes que establecer la disponibilidad","warning");
      }
    break;
    default:

    break;
  }
});

function bloquearFechasEspeciales(fecha_inicio,fecha_fin){
  var fecha_start = moment(fecha_inicio,'YYYY-MM-DD').subtract('1','days');
  var fecha_end   = moment(fecha_fin,'YYYY-MM-DD').add('1','days');
  
  var fecha_especial_inicio = fecha_start;
  for( var i = fecha_start.get('year'); i <= fecha_end.get('year') ; i++ ){
    var navidad =  moment(fecha_especial_inicio).get('year')+'-12-25';
    if ( moment( navidad ).isBetween(fecha_start,fecha_end) ) {               // NAVIDAD
        //fechaEspecial(navidad,'Navidad');
    }
    var vispira_new_year =  moment(fecha_especial_inicio).get('year')+'-12-31';
    if ( moment( vispira_new_year ).isBetween(fecha_start,fecha_end) ) {       // VISPIRA AÑO NUEVO
        //fechaEspecial(vispira_new_year,'Víspira Año Nuevo');
    }
    var new_year =  moment(vispira_new_year,'YYYY-MM-DD').add('1','days');
    if ( moment( new_year,'YYYY-MM-DD' ).isBetween(fecha_start,fecha_end) ) {   // AÑO NUEVO
        //fechaEspecial(new_year.format('YYYY-MM-DD'),'Año Nuevo');
    }
    fecha_especial_inicio.add('1','years');
  }
  actualizar_eventos();
}

function bloquearDiaEspecial(diaMes,fecha_inicio,fecha_fin){
  var fecha_start = moment(fecha_inicio,'YYYY-MM-DD').subtract('1','days');
  var fecha_end   = moment(fecha_fin,'YYYY-MM-DD').add('1','days');
  
  var fecha_especial_inicio = fecha_start;      
  for( var i = fecha_start.get('year'); i <= fecha_end.get('year') ; i++ ){
    var navidad =  moment(fecha_especial_inicio).get('year')+'-12-25';
    var vispira_new_year =  moment(fecha_especial_inicio).get('year')+'-12-31';
    var new_year =  moment(vispira_new_year,'YYYY-MM-DD').add('1','days');
    switch(diaMes){
      case '25-12': // NAVIDAD
        if ( moment( navidad ).isBetween(fecha_start,fecha_end) ) {               // NAVIDAD
            fechaEspecial(navidad,'Navidad');
        }
      break;
      case '31-12': // FIN DEAÑO
        if ( moment( vispira_new_year ).isBetween(fecha_start,fecha_end) ) {       // VISPIRA AÑO NUEVO
            fechaEspecial(vispira_new_year,'Víspira Año Nuevo');
        }
      break;
      case '1-1': // AÑO NUEVO
        if ( moment( new_year,'YYYY-MM-DD' ).isBetween(fecha_start,fecha_end) ) {   // AÑO NUEVO
            fechaEspecial(new_year.format('YYYY-MM-DD'),'Año Nuevo');
        }
      break;
    }
    fecha_especial_inicio.add('1','years');
  }
  actualizar_eventos();
}

function eliminarDiaEspecial(diaMes,fecha_inicio,fecha_fin){
  var fecha_start = moment(fecha_inicio,'YYYY-MM-DD').subtract('1','days');
  var fecha_end   = moment(fecha_fin,'YYYY-MM-DD').add('1','days');
  
  var fecha_especial_inicio = fecha_start;      
  for( var i = fecha_start.get('year'); i <= fecha_end.get('year') ; i++ ){
    var navidad =  moment(fecha_especial_inicio).get('year')+'-12-25';
    var vispira_new_year =  moment(fecha_especial_inicio).get('year')+'-12-31';
    var new_year =  moment(vispira_new_year,'YYYY-MM-DD').add('1','days');
    switch(diaMes){
      case '25-12': // NAVIDAD
        if ( moment( navidad ).isBetween(fecha_start,fecha_end) ) {               // NAVIDAD
            eliminarFechaEspecial(navidad+" 00:00:00",navidad+" 23:59:59");
        }
      break;
      case '31-12': // FIN DEAÑO
        if ( moment( vispira_new_year ).isBetween(fecha_start,fecha_end) ) {       // VISPIRA AÑO NUEVO
            eliminarFechaEspecial(vispira_new_year+" 00:00:00",vispira_new_year+" 23:59:59");
        }
      break;
      case '1-1': // AÑO NUEVO
        if ( moment( new_year,'YYYY-MM-DD' ).isBetween(fecha_start,fecha_end) ) {   // AÑO NUEVO
          eliminarFechaEspecial(new_year.format("YYYY-MM-DD")+" 00:00:00",new_year.format("YYYY-MM-DD")+" 23:59:59");
        }
      break;
    }
    fecha_especial_inicio.add('1','years');
  }
}

function eliminarFechaEspecial(fecha_inicio,fecha_fin){
  var id_objeto_eliminado = js_bloqueo.get_eliminar_bloqueo(fecha_inicio,fecha_fin);
  actualizar_eventos();
  console.log("ELIMINADO ",id_objeto_eliminado);
  if (id_objeto_eliminado) {
    eliminarObjeto(id_objeto_eliminado,'bloqueo');
  }
}

function fechaEspecial(fecha,descripcion){
  var data_bloqueo_dias_especiales = {
    id        : null,
    start     : fecha+" 00:00:00",
    end       : fecha+" 23:59:59",
    title     : moment(fecha,'YYYY-MM-DD').format('DD-MM-YYYY')+"  "+descripcion,
    color     : '#d9534f',
  };
  js_bloqueo.set_datos_bloqueo(data_bloqueo_dias_especiales);
}

function activarTab(){
  $('[href="#div_disponibilidad"]').tab('show');
}

function addArrayDiasEspeciales(diaEspecial){
  deleteArrayDiasEspeciales(diaEspecial.trim());
  if (diaEspecial.trim().length != 0 ) {
    array_dias_especiales.push(diaEspecial);
  }
}

function deleteArrayDiasEspeciales(diaEspecial){
  if (diaEspecial.trim().length != 0 ) {
    for (var i = 0 ; i < array_dias_especiales.length ; i++) {
      if ( array_dias_especiales[i].trim() === diaEspecial.trim() ) {
        array_dias_especiales.splice(i,1);   
        return true;
      } 
    }
  }
}

</script>