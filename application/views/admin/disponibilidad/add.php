
<link rel='stylesheet' href='<?=base_url();?>assets/resources/fullcalendar/fullcalendar.min.css' />

<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap-select/css/bootstrap-select.min.css">

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <!-- <h4 class="text-center"><strong><span class="fa fa-calendar text-success"></span> DISPONIBILIDAD DE TOURS Y PAQUETES TURISTICOS</strong></h4><hr/> -->
      <div class="headline text-center text-info">
        <h3><strong><span class="fa fa-calendar"></span> DISPONIBILIDAD, BLOQUEOS y OFERTAS</strong></h3>
      </div>
      <div class="form-group col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">      
        <select class="selectpicker form-control input-lg" name="slct_disponibilidad" id="slct_disponibilidad" data-live-search="true">
          <option value="">Seleccionar, Buscar...</option>
          <option value="1">Hot Dog, Fries and a Soda</option>
          <option value="2">Burger, Shake and a Smile</option>
          <option value="3">Sugar, Spice and all things nice</option>
        </select>    
      </div>
      <span class="fa fa-chevron-left btn btn-danger pull-right" title="Volver"></span>
      <span class="fa fa-floppy-o btn btn-success pull-right" title="Guardar Disponibilidad"></span>
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
                           <div class="col-md-12">
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
                                <!-- </div>>>>>>
                                                              </div> -->
                            </div>
                      </div>
                </div>
               <div class="tab-pane fade" id="div_bloqueos">
                   <div class="typography">
                       <div class="col-md-12">
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
                              <!-- </div>
                                                          </div> -->
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
  <button class="btn btn-success"><span class="fa fa-floppy-o"></span> GUARDAR</button>
  <a href="<?=base_url().'admin/servicio';?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a><br/><br/><br/>
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

<!-- ------------------------------ -->

<script src='<?=base_url();?>assets/resources/moment/moment.min.js'></script>
<script src='<?=base_url();?>assets/resources/fullcalendar/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/gcal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/locale-all.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script src='<?=base_url();?>assets/resources/bootstrap-color-selector/js/bootstrap-colorselector.min.js'></script>

<script type="text/javascript" src="<?=base_url().'assets/js/script-calendar.js';?>"></script>

<script type="text/javascript">
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
</script>