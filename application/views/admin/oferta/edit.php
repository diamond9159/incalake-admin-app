
<link rel='stylesheet' href='http://fullcalendar.io/js/fullcalendar-2.2.3/fullcalendar.css' />

<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap-select/css/bootstrap-select.min.css">

<form name="form_update_disponibilidad" id="form_update_disponibilidad">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- <h4 class="text-center"><strong><span class="fa fa-calendar text-success"></span> DISPONIBILIDAD DE TOURS Y PAQUETES TURISTICOS</strong></h4><hr/> -->
        <div class="headline text-center text-info">
          <h3><strong><span class="fa fa-calendar"></span> DISPONIBILIDAD, BLOQUEOS y OFERTAS</strong></h3>
        </div>
        <?php 
          //echo $id_servicio_referencia;
          //echo json_encode($productos[0]['disponibilidad']['data_disponibilidad']).'<br/><br/>';
          //echo json_encode($productos[0]['bloqueo']['data_disponibilidad']).'<br/><br/>';
          
          //echo json_encode($productos[0]['disponibilidad']).'<br/><br/>';
          //echo json_encode($productos[0]['bloqueo']).'<br/><br/>';
          //echo json_encode($productos[0]['oferta']).'<br/><br/>';
        ?>
        <div class="form-group col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">      
          <!--
          <select class="selectpicker form-control input-lg" name="slct_disponibilidad" id="slct_disponibilidad" data-live-search="true">
            <option value="">Seleccionar, Buscar...</option>
            <?php foreach ($productos as $key => $value): ?>
              <?php 
              $selected  = '';
              if ( (integer)$id_servicio_referencia === (integer)$value['id_servicio'] ){
                //$selected = 'selected';
              } 
              ?>
              <option value="<?=$value['id_producto'];?>" <?=$selected;?> ><?=$value[0]['codigo'].' - '.ucfirst($value['titulo_producto']);?></option>
            <?php endforeach ?>
          </select>
          -->  
          <input type="hidden" readonly name="slct_disponibilidad" id="slct_disponibilidad" value="<?=$id_servicio_referencia;?>">
          <h3 class="text-center text-danger"><strong><u><?=$productos[0]['producto']['titulo_producto'];?></u></strong></h3>  
        </div>
        <span class="fa fa-chevron-left btn btn-danger pull-right" title="Volver"></span>
        <span class="fa fa-floppy-o btn btn-success pull-right btn-guardar-disponiblidad" title="Guardar Disponibilidad"></span>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 col-sm-5 col-xs-12">
        <div class="text-left tab-v1 form-group container-fluid" style="padding: 0px;">
             <ul class="nav nav-tabs ">
                 <li class="">
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
                 <li class="active">
                     <a href="#div_ofertas" data-toggle="tab" aria-expanded="true">
                         <span class="fa fa-star-o"></span>
                         <strong class="hidden-xs hidden-sm">OFERTAS</strong>
                     </a>
                 </li>  
             </ul>
             <div class="tab-content">
                 <div class="tab-pane fade" id="div_disponibilidad">
                         <div class="typography">
                             <div class="col-md-12 bg-info">
                                 <!-- <div class="headline">
                                    <div>DISPONIBILIDAD</div>
                                 </div> -->
                               <!--  <div class="panel panel-info">
                                 <div class="panel-heading"><strong><span class="fa fa-calendar-check-o"></span> DISPONIBILIDAD</strong></div>
                                 <div class="panel-body">
                                 -->
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
                                        <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="1" id="chckbx_dia_1">Domingo</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="2" id="chckbx_dia_2">Lunes</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="3" id="chckbx_dia_3">Martes</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="4" id="chckbx_dia_4">Miércoles</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="5" id="chckbx_dia_5">Jueves</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="6" id="chckbx_dia_6">Viérnes</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="chckbx_dia" checked value="7" id="chckbx_dia_7">Sábado</label>
                                      </small>
                                    </div>
                                    <div class="pull-right">
                                      <div class="btn btn-info btn-sm" id="btn-guardar-disponibilidad"><strong><span class="fa fa-save"></span> GUARDAR</strong></div>
                                    </div>
                                    <input type="text" readonly name="txt_data_json_disponibilidad" id="txt_data_json_disponibilidad" class="form-control">
                                  <br/><br/><br/><br/>
                              </div>
                        </div>
                  </div>
                 <div class="tab-pane fade" id="div_bloqueos">
                     <div class="typography">
                         <div class="col-md-12 bg-danger">
                            <!-- <div class="headline">
                                 <div>BLOQUEOS</div>
                              </div> -->

                           <!--  <div class="panel panel-danger">
                             <div class="panel-heading"><strong><span class="fa fa-ban"></span> BLOQUEOS</strong></div>
                             <div class="panel-body"> -->
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
                              <br/><br/>
                         </div>
                     </div>
                 </div>
                 <div class="tab-pane fade active in" id="div_ofertas">
                     <div class="typography">
                         <div class="col-md-12 bg-success">
                           <!--  <div class="headline">
                                    <div>OFERTAS</div>
                              </div> -->
                              <!-- <div class="panel panel-success">
                                <div class="panel-heading"><strong><span class="fa fa-star-o"></span> OFERTAS</strong></div>

                                <div class="panel-body"> -->
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
                                <br/><br/>
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
        <div id='calendario_incalake'></div>
        <div style='clear:both'></div>
      </div>
    </div>
    <div class="text-center"><hr/>
    <button class="btn btn-success btn-guardar-disponiblidad" id="btn-guardar-disponiblidad"><b><span class="fa fa-floppy-o"></span> GUARDAR ACTUALIZACION</b></button>
    <a href="<?=base_url().'admin/oferta';?>" class="btn btn-danger"><b><span class="fa fa-chevron-left"></span> VOLVER</b></a><br/><br/><br/>
    </div>
  </div>
</form>

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

<!-- ------------------------------ -->

<script src='<?=base_url();?>assets/resources/moment/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/gcal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/locale-all.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script src='<?=base_url();?>assets/resources/bootstrap-color-selector/js/bootstrap-colorselector.min.js'></script>

<script type="text/javascript" src="<?=base_url().'assets/js/objetos.js';?>"></script>

<script type="text/javascript">
  var id_servicio = '<?=$id_servicio_referencia;?>';
  contador_letras('txtr_descripcion_bloqueo_modal','span_letter_count',128);
  $('.txt_color_oferta').colorselector();
  $(document).on('change', '#slct_tipo_dia', function(event) {
    event.preventDefault();
    var select_tipo  =$(this).val();
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

var js_disponibilidad = new Disponibilidad();
var js_bloqueo        = new Bloqueo();
var js_oferta         = new Oferta();  
var cantidad_dias_inicio_disponibilidad = '';
var cantidad_dias_fin_disponibilidad = '';

var string_data_disponibilidad = '';
var string_data_bloqueo        = '';
var string_data_oferta         = '';

$("#formAddDisponibilidad").validationEngine('attach', {
  relative: true,
  promptPosition:"bottomLeft"
});

jQuery(document).ready(function($) {
  string_data_disponibilidad = '<?=$productos[0]["disponibilidad"];?>';
  string_data_bloqueo        = '<?=$productos[0]["bloqueo"];?>';
  string_data_oferta         = '<?=$productos[0]["oferta"];?>';

  /****************************************************************************************************************/
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
      var end          = moment( array_end[0]+"-"+array_end[1]+"-"+( parseInt(array_end[2]) -1 ) ,"YYYY-MM-DD").format("YYYY-MM-DD");
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
  /**************Cargando datos de Disponibilidad, bloqueo y oferta****************/
  $.each(JSON.parse(string_data_disponibilidad), function(index, val) {
    js_disponibilidad.set_datos_disponibilidad( val );
    $("#txt_fecha_inicio_disponibilidad").empty().val( moment(val['start']).format("DD-MM-YYYY") );
    $("#txt_fecha_fin_disponibilidad").empty().val( moment(val['end']).format("DD-MM-YYYY") );
    actualizar_disponibilidad(moment(val['start']).format("YYYY-MM-DD"), moment(val['end']).format("YYYY-MM-DD") );
  });
  
  $("#txt_data_json_disponibilidad").empty().val(JSON.stringify(js_disponibilidad.get_datos_disponibilidad() ) );
  $.each(JSON.parse(string_data_bloqueo), function(index, val) {
    js_bloqueo.set_datos_bloqueo( val );
  });
  $.each(JSON.parse(string_data_oferta), function(index, val) {
    js_oferta.set_datos_oferta( val );
  });
  
  actualizar_eventos();
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
        start   : fecha_inicio_disponibilidad+" 00:00:00",
        end     : fecha_fin_disponibilidad+" 23:59:59",
        estado  : 'disponible',
        title   : 'Disponible',
        description : '',
        color   : '#5bc0de',
        dias_activos: array_dias, 
      };
      
      js_disponibilidad.set_datos_disponibilidad(data_disponibilidad);
      var json_data_disponibilidad  =js_disponibilidad.get_datos_disponibilidad();
      $("#txt_data_json_disponibilidad").empty().val( JSON.stringify(json_data_disponibilidad) );
      actualizar_disponibilidad(fecha_inicio_disponibilidad,fecha_fin_disponibilidad);

      swal("DISPONIBILIDAD","La disponibilidad se ha actualizado correctamente.","success");
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
            start     : fecha_inicio_bloqueo+" 00:00:00",
            end       : fecha_fin_bloqueo+" 23:59:59",
            estado    : 'bloqueo',
            title     : 'Bloqueado: '+$("#txtr_motivo_bloqueo").val(),
            description : $("#txtr_motivo_bloqueo").val(),
            color     : '#d9534f',
            dias_activos: [], 
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
                start     : fecha_inicio_oferta+" 00:00:00",
                end       : fecha_fin_oferta+" 23:59:59",
                estado    : 'oferta',
                descuento : cantidad_descuento,
                tipo_descuento: tipo_descuento_oferta,
                title       : 'Oferta: '+"-"+cantidad_descuento+string_tipo_descuento,
                description : cantidad_descuento+string_tipo_descuento,
                color       : color_oferta,
                dias_activos: [], 
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
    var string_fecha = $(this).data('id');
    var string_tipo  = $(this).data('tipo');
    var array_fechas = string_fecha.split(';');
    //bloqueo = 0,  oferta = 1
    switch(parseInt(string_tipo)){
      case 0:
        js_bloqueo.get_elminar_bloqueo(array_fechas[0],array_fechas[1]);
        actualizar_eventos();
      break;
      case 1:
        js_oferta.get_eliminar_oferta(array_fechas[0],array_fechas[1]);
        actualizar_eventos();
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
            start     : fecha_start + " 00:00:00",
            end       : fecha_end + " 23:59:59",
            estado    : 'bloqueo',
            title     : 'Bloqueado: '+descripcion_bloqueo,
            description : descripcion_bloqueo,
            color       : '#d9534f',
            dias_activos: [], 
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
            start     : fecha_start + " 00:00:00",
            end       : fecha_end + " 23:59:59",
            estado    : 'oferta',
            title     : 'Oferta: -'+descuento_oferta+string_descripcion_oferta_modal,
            description : descripcion_bloqueo,
            color       : color_oferta_modal,
            dias_activos: [], 
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
});

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
    html_bloqueo += '<li class="list-group-item">'+val.title+'<span class="pull-right fa fa-close text-danger btn btn-delete-objeto" data-id="'+val.start+';'+val.end+'" data-tipo="0" title="Eliminar Fecha Bloqueada"></span></li>';
    $('#calendario_incalake').fullCalendar('renderEvent', val, true);
    $('#calendario_incalake').fullCalendar('unselect');
  });
  $("#list-group-bloqueo").empty().append(html_bloqueo);
  $("#txt_data_json_bloqueo").empty().val(JSON.stringify( js_bloqueo.get_datos_bloqueo() ) );

  $.each(js_oferta.get_datos_oferta(), function(index, val) {
    html_oferta += '<li class="list-group-item">'+val.title+'<span class="pull-right fa fa-close text-danger btn btn-delete-objeto" data-id="'+val.start+';'+val.end+'" data-tipo="1" title="Eliminar fecha en Oferta"></span></li>';
    $('#calendario_incalake').fullCalendar('renderEvent', val, true);
    $('#calendario_incalake').fullCalendar('unselect');
  });
  $("#list-group-oferta").empty().append(html_oferta);
  $("#txt_data_json_oferta").empty().val(JSON.stringify(js_oferta.get_datos_oferta() ) );
}

$(document).on('change', '#slct_disponibilidad', function(event) {
  event.preventDefault();
  var id_servicio_disponibilidad = $(this).val();
  actualizar_calendario(id_servicio_disponibilidad);
});

function actualizar_calendario(id_producto) {
    $("#calendario_incalake").fullCalendar( 'refresh' );
    /*
    $("#txt_fecha_inicio_disponibilidad").val('');
    $("#txt_fecha_fin_disponibilidad").val('');
    $("#txt_data_json_bloqueo").val('');
    $("#txt_data_json_oferta").val('');
    */
    if ( id_producto.length === 0 ) { return 0; }
    $.ajax({
      url: '<?=base_url().'admin/disponibilidad/disponibilidad_bloqueo_oferta_json';?>',
      type: 'POST',
      dataType: 'json',
      data: { id_servicio : id_producto },
      success: function(data) {
        $.each(JSON.parse(data.disponibilidad), function(index, val) {
          js_disponibilidad.set_datos_disponibilidad( val );
          $("#txt_fecha_inicio_disponibilidad").empty().val( moment(val['start']).format("DD-MM-YYYY") );
          $("#txt_fecha_fin_disponibilidad").empty().val( moment(val['end']).format("DD-MM-YYYY") );
          actualizar_disponibilidad(moment(val['start']).format("YYYY-MM-DD"), moment(val['end']).format("YYYY-MM-DD") );
        });
        $("#txt_data_json_disponibilidad").empty().val(JSON.stringify(js_disponibilidad.get_datos_disponibilidad() ) );
        $.each(JSON.parse(data.bloqueo), function(index, val) {
          js_bloqueo.set_datos_bloqueo( val );
        });
        $.each(JSON.parse(data.oferta), function(index, val) {
          js_oferta.set_datos_oferta( val );
        });
        actualizar_eventos();
        $.unblockUI();
      },
      beforeSend:function(xhr){
        $.blockUI({ 
          message: '<h2><img src="<?=base_url().'assets/img/loading.gif';?>"></h2><h3>Espere un momento por favor...!</h3><h4>Estamos recuperando datos del servidor.</h4>',
          css: { 
            border: 'none', 
            padding: '5px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .7, 
            color: '#fff' 
          }
        });
      },
      error:function(xhr,status,error) {
        console.log(xhr.responseText);
        $.unblockUI();
        swal("ERROR",error,"error");
      }
    });
  }

$(document).on('click', '.btn-guardar-disponiblidad', function(event) {
  event.preventDefault();
  var id_producto_select = $("#slct_disponibilidad").val();
  var data_disponibilidad = $("#txt_data_json_disponibilidad").val();
  var data_bloqueo = $("#txt_data_json_bloqueo").val();
  var data_oferta = $("#txt_data_json_oferta").val();

  if (id_producto_select.length === 0 && data_disponibilidad.length === 0) {
      swal("ERROR", "Asegurese de haber seleccionado un producto y luego seleccionar la fecha de disponiblidad.", "error");
      return false;
  }

  $.ajax({
      url: "<?=base_url().'admin/disponibilidad/add_ajax';?>",
      type: 'POST',
      dataType: 'json',
      data: {
          id_producto: id_producto_select,
          json_disponiblidad: data_disponibilidad,
          json_bloqueo: data_bloqueo,
          json_oferta: data_oferta
      },
      success: function(data) {
          $.unblockUI();
          if (data.response === 'OK') {
              swal("INFORMACIÓN", "Información actualizada correctamente..!", "success");
              location.reload(true);
          }
          console.log(data);
      },
      beforeSend: function(xhr) {
          $.blockUI({
              message: '<h2><img src="<?=base_url().'assets/img/loading.gif';?>"></h2><h3>Espere un momento por favor...!</h3><h4>Estamos enviando toda la información al servidor..!</h4>',
              css: {
                  border: 'none',
                  padding: '5px',
                  backgroundColor: '#000',
                  '-webkit-border-radius': '10px',
                  '-moz-border-radius': '10px',
                  opacity: .7,
                  color: '#fff'
              }
          });
      },
      error: function(xhr, status, error) {
          $.unblockUI();
          swal("ERROR", error, "error");
      },
  });
});
</script>