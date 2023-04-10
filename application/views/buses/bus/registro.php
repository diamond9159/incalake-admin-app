<?php
    //@var_dump($servicios);
    $dataDisponibilidad     = [];
    $dataBloqueos           = [];
    $dataOfertas            = [];
    $dataLugares            = [];
    $dataGuias              = @$guias;
    $arrayDatosPersonales   = @$datospersonales;
    $requerirDisponibilidad = 0;
    $selectedGuias          = 3;

    if(@$bus_copiado){
        //var_dump($bus_copiado);
        // asignar toda las variables a bus
        $bus = $bus_copiado;
        // quitar id_bus para evitar que sea detectado como edicion
        $bus['id_bus'] = 0;
        // quitar tabs adicionales
        $bus['tabs_adicionales'] = null;

        $dataDisponibilidad = $disponibilidad;
        $dataBloqueos       = $bloqueos;
        $dataOfertas        = $ofertas;
        $dataLugares        = $arrayLugares;
        $arrayDatosPersonales   = $datospersonales;
        $dataGuias              = $guias;
        $requerirDisponibilidad = $bus['requerir_disponibilidad']?1:0;
    }
    // si variable bus existe es que se tiene que editar
    if(@$bus){
        // Tabla bus
        $busdetails['id_bus'] = $bus['id_bus'];
        $busdetails['id_codigo_bus'] = $bus['id_codigo_bus'];
        $busdetails['titulo_bus'] = $bus['titulo_bus'];
        $busdetails['subtitulo_bus'] = $bus['subtitulo_bus'];
        $busdetails['estado_bus'] = $bus['estado_bus'];
        $busdetails['hora_anticipacion'] = $bus['hora_anticipacion'];
        $busdetails['politicas_bus'] = $bus['politicas_bus'];
        $busdetails['tasas_impuestos'] = +$bus['tasas_impuestos'];
        $busdetails['id_empresa'] = $bus['id_empresa'];
        $busdetails['origen_bus'] = $bus['origen_bus'];
        $busdetails['destino_bus'] = $bus['destino_bus'];
        $busdetails['pago_minimo'] = $bus['pago_minimo'];
        $busdetails['servicios_adicionales_bus'] = $bus['servicios_adicionales'];
        $busdetails['lugar_partida'] = $bus['lugar_partida'];
        $busdetails['lugar_llegada'] = $bus['lugar_llegada'];
        // tab
        $busdetails['descripcion_bus'] = $bus['descripcion_tab'];
        $busdetails['itinerario_bus'] = $bus['itinerario_tab'];
        $busdetails['incluye_bus'] = $bus['incluye_tab'];
        $busdetails['informacion_bus'] = $bus['informacion_tab'];
        $busdetails['recomendacion_bus'] = $bus['recomendacion_tab'];
        $busdetails['recojo_opcion']     = $bus['recojo_opcion'];
        $busdetails['recojo_opcion']     = $bus['recojo_opcion'];
        $busdetails['recojo_subopcion']  = $bus['recojo_subopcion'];
        $busdetails['recojo_inicio_servicio']  = $bus['recojo_inicio_servicio'];
        $busdetails['recojo_fin_servicio']     = $bus['recojo_fin_servicio'];
        $busdetails['tipo_guia']               = $bus['tipo_guia'];
        // 

        $dataDisponibilidad     = $disponibilidad;
        $dataBloqueos           = $bloqueos;
        $dataOfertas            = $ofertas;
        $dataLugares            = $arrayLugares;
        $arrayDatosPersonales   = $datospersonales;
        $dataGuias              = $guias;
        $requerirDisponibilidad = $bus['requerir_disponibilidad']?1:0;
        $selectedGuias          = $bus['tipo_guia'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Especificaciones del bus</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
    <script src="<?=base_url();?>recursos/js/timepicker.min.js"></script>
    <script src="<?=base_url();?>recursos/js/validador.js"></script>
    <script src="<?=base_url();?>recursos/js/bootbox.min.js"></script>
    <link rel="stylesheet" href="http://bustickets.incalake.com/assets/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/resources/multi-select/css/multiselect.min.css">
    
    <script src="<?=base_url();?>assets/resources/multi-select/js/multiselect.min.js" type="text/javascript" charset="utf-8"></script>

    <!--script src="<?=base_url();?>recursos/js/jquery.bootstrap-duallistbox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>recursos/css/bootstrap-duallistbox.css"-->
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');

			?>
		</header>
		<content>
		<div class="container">
            <div class="titulo-producto">BUS: <span class="fa fa-chevron-right" style="vertical-align: middle;color: #5cb85c;"> </span> <?=$pagina_web['titulo_pagina'];?></div>
            <div class="alert alert-info" style="padding:7px">
            <b>Idioma: </b><span class="flag flag-<?=preg_match('(en|EN)',@$pagina_web['cod_idioma'])?'us':strtolower(@$pagina_web['cod_idioma']);?>"></span> <?=@$pagina_web['nombre_idioma'];?> | <strong>URL: </strong> <?=@$pagina_web['url_pagina'];?>
            
            </div>

          <form id="formPrincipal" method="post" action="<?=base_url('buses/unidad/registro_datos')?>">

          <input type="hidden" name="id_bus" value="<?=@$busdetails['id_bus']?$busdetails['id_bus']:0;?>" />
          <input type="hidden" name="id_pagina" value="<?=@$pagina_web['id_pagina'];?>" />
          <input type="hidden" name="id_codigo_bus" value="<?=@$busdetails['id_codigo_bus']?$busdetails['id_codigo_bus']:0;?>" />

          <div class="progress">
               <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <fieldset class="text-center">
                  <div class="panel panel-primary navform">
                          <div class="panel-body">
                                 <!--input type="button" name="previous" class="previousStep btn btn-danger" value="Anterior" /-->
                                 <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente" data-siguiente="calendario"/>
                          </div>
                  </div>
                                                    <div class="text-left">
                                                      <div class="headline">
                                                          <div>Paso 1: Información general</div>
                                                      </div>
                                                      <div class="col-md-6">
                                                       <div class="form-group row">
                                                          <label class="col-md-4" for="titulo_bus">Titulo bus <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Escribir el título del bus ubicado en el encabezado."></span></label>
                                                          <div class="col-md-8">
                                                             <input required class="form-control" data-error="Necesita ingregar el titulo del bus" type="text" id="titulo_bus" name="titulo_bus" value="<?=@$busdetails['titulo_bus'];?>" autocomplete="off"/>
                                                          </div>
                                                       </div>
                                                       <div class="form-group row">
                                                          <label class="col-md-4" for="subtitulo_bus">Subtitulo bus <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Escribir el subtítulo ubicado bajo el encabezado del título del bus."></span></label>
                                                          <div class="col-md-8">
                                                             <input  class="form-control" id="subtitulo_bus" name="subtitulo_bus" type="text" value="<?=@$busdetails['subtitulo_bus'];?>" />
                                                          </div>
                                                       </div>
                                                     
                                                       <div class="form-group row">
                                                          <label class="col-md-4">Dirección de partida <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Indique el lugar de partida del bus."></span></label>
                                                          <div class="col-md-8">
                                                             <input required class="form-control" name="lugar_partida" type="text" value="<?=@$busdetails['lugar_partida'];?>" />
                                                          </div>
                                                       </div>
                                                      
                                                       <div class="form-group row">
                                                          <label class="col-md-4">Dirección de llegada <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Ciudad de llegada del bus."></span></label>
                                                          <div class="col-md-8">
                                                             <input required class="form-control" name="lugar_llegada" type="text" value="<?=@$busdetails['lugar_llegada'];?>" />
                                                          </div>
                                                       </div>
                                                       
                                                       <div class="form-group row">
                                                          <label class="col-md-4">Tasas e impuestos <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Tasas e impuestos"></span></label>
                                                          <div class="col-md-8">
                                                             <input class="form-control" name="tasas_impuestos" id="tasas_impuestos" type="number" data-value="<?=@$busdetails['tasas_impuestos'];?>" />
                                                          </div>
                                                       </div>
                                                       <div class="form-group row">
                                                          <label class="col-md-4">Pago minimo (% adelanto) <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Pago minimo requerido al momento de la reserva"></span></label>
                                                          <div class="col-md-8">
                                                             <input type="number" class="form-control" name="pago_minimo" value="<?=@+$busdetails['pago_minimo'];?>" />
                                                          </div>
                                                        </div>
                                                       
                                                       
                                                      </div>
                                                      <div class="col-md-6">
                                                      <div class="form-group row">
                                                          <label class="col-md-4" >Empresa de transporte </label>
                                                          <div class="col-md-8">
                                                            <select class="form-control" required name="empresa_transporte">
                                                              <option value="">-- Seleccione --</option>
                                                             <?php
                                                             $html_select = null;
                                                             

                                                             foreach($empresas as $value){
                                                            
                                                              $html_select .= "<option ".(@$busdetails['id_empresa']==$value['id_empresa']?'selected':null)." value='{$value['id_empresa']}'>{$value['nombre_empresa']}</option>";
                                                             }
                                                             echo $html_select;
                                                             ?>
                                                             </select>
                                                          </div>
                                                       </div>
                                                        <div class="form-group row">
                                                          <label class="col-md-4">Origen <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Origen (ciudad donde parte el bus)"></span></label>
                                                          <div class="col-md-8">
                                                             <select class="form-control" required id="origen_select" name="origen_bus" data-value="<?=@$busdetails['origen_bus'];?>">
                                                              <option value="">-- Seleccione --</option>
                                                             </select>
                                                          </div>
                                                        </div>
                                                        <div class="form-group row">
                                                          <label class="col-md-4">Destino <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Destino (ciudad donde llega el bus)"></span></label>
                                                          <div class="col-md-8">
                                                             <select class="form-control" required id="destino_select" name="destino_bus" data-value="<?=@$busdetails['destino_bus'];?>">
                                                              <option value="">-- Seleccione --</option>
                                                             </select>
                                                          </div>
                                                        </div>

                                                        <div class="form-group row">
                                                          <label class="col-md-4">Bus Activo <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Indicar si este bus se mostrará en la web."></span></label>
                                                          <div class="col-md-8">
                                                             <input type="checkbox" name="estado_bus" value="1" <?=!isset($busdetails['estado_bus'])?'checked':((int)$busdetails['estado_bus']?'checked':'');?> /><small> Si esta activo este bus se muestra en la web de lo contrario no.</small>
                                                             
                                                          </div>
                                                       </div><hr>

                                                        <div class="form-group row">
                                                            <label class="col-md-4">Servicios adicionales <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Servicios adicionales ofrecidos dentro del bus"></span></label>
                                                            <div class="col-md-8 serv_adicional">
                                                              <?php
                                                             // var_dump($servicios_adicinales);
                                                              $html_cheks = null;
                                                              // valores recuperados del bus para editar
                                                              $servicios_adicionales_bus = @$busdetails['servicios_adicionales_bus']?explode(',',@$busdetails['servicios_adicionales_bus']):[];
                                                              
                                                                foreach($servicios_adicionales as $value){
                                                                 $checked = in_array($value['id_servicio_adicional'], $servicios_adicionales_bus)?'checked':null;

                                                                  $html_cheks .= "<label>{$value['nombre_servicio_adicional']} <input value='{$value['id_servicio_adicional']}' type='checkbox' $checked name='servicios_adicionales[]'></label> ";
                                                                }
                                                              echo $html_cheks;
                                                              ?>
                                                            </div>
                                                       
                                                        </div>
                                                        
                                                      </div>
                                                       <!-- salidas -->
                                                        
                                                       <div class="col-md-12 form-group row">
                                                                <div class="col-md-12 text-center container-fluid" style="background: #286090; color: #fff; padding: 5px 0;">
                                                                                  <div class="col-md-2 col-xs-3">HORA PARTIDA</div>
                                                                                  <div class="col-md-2 col-xs-2">DURACIÓN EN HORAS</div>
                                                                                  <div class="col-md-3 col-xs-3">SERVICIO</div>
                                                                                  <div class="col-md-2 col-xs-3">PRECIO EN DOLARES</div>
                                                                                  <div class="col-md-2 col-xs-3">ZONA HORARIA</div>
                                                                                  <div class="col-md-1 col-xs-1">OPERACION</div>
                                                                </div>
                                                                 <div class="col-md-12" data-servicios='<?=@json_encode($servicios);?>' data-horarios='<?=@json_encode($bus['horarios']);?>' id="horarios_container" style="padding: 5px 0 0 0;" >
                                                                   
                                                                 </div>
                                                                 
                                                                 
                                                                 <div class="text-center" style="margin-top:5px;clear:both">
                                                                   
                                                                   <hr>
                                                                   <button type="button" class="btn btn-primary" id="btn_add_salidas">Agregar horario salida</button>
                                                                 </div>
                                                                
                                                             </div>
                                                    </div>   
              </fieldset>
              <fieldset>
                <div class="panel panel-primary navform">
                      <div class="panel-body">
                          <input type="button" name="previous" class="previousStep btn btn-danger" value="Anterior" />
                          <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente" data-siguiente=""/>
                      </div>
                </div>
                
                <div class="headline">
                <div>Paso 2: Descripción y detalles acerca del bus</div>
              </div>
                <div class="text-left tab-v1 form-group container-fluid" style="padding: 0px;">
                      <ul class="nav nav-tabs ">
                          <li class="active">
                              <a href="#div_descripcion" data-toggle="tab" aria-expanded="false" data-div="div_descripcion">
                                  <span class="fa fa-building"></span>
                                  <strong>DESCRIPCIÓN</strong>
                              </a>
                          </li>
                          <li class="">
                              <a href="#div_itinerario" data-toggle="tab" aria-expanded="false" data-div="div_itinerario">
                                  <span class="fa fa-tasks"></span>
                                  <strong>ITINERARIO</strong>
                              </a>
                          </li>
                          <li class="">
                              <a href="#div_incluye" data-toggle="tab" aria-expanded="true" data-div="div_incluye">
                                  <span class="fa fa-plus-circle"></span>
                                  <strong>INCLUYE</strong>
                              </a>
                          </li>
                          <li class="">
                              <a href="#div_informacion_importante" data-toggle="tab" aria-expanded="false" data-div="div_informacion_importante">
                                  <span class="fa fa-info-circle"></span>
                                  <strong>INFORMACION</strong>
                              </a>
                          </li>
                          <li class="">
                              <a href="#div_recomendacion" data-toggle="tab" aria-expanded="false" data-div="div_recomendacion">
                                  <span class="fa fa-info-circle"></span>
                                  <strong>RECOMENDACIÓN</strong>
                              </a>
                          </li>

                          
                          <li class="">
                              <a href="#div_mapa" data-toggle="tab" aria-expanded="false" data-div="div_mapa">
                                  <span class="fa fa-map-marker"></span>
                                  <strong>MAPA</strong>
                              </a>
                          </li>
                          <li class="" style="background:#eaeaf4;">
                              <a href="#div_add_tabs" data-toggle="tab" aria-expanded="false" data-div="div_add_tabs">
                                  <span class="fa fa-plus-circle"></span>
                                  <strong>AGREGAR TABS</strong>
                              </a>
                          </li>
                      </ul>

                      <div class="tab-content">
                           

                          <div class="tab-pane fade active in" id="div_descripcion">
                                  <div class="typography">
                                      
                                      <div class="col-md-12">
                                          <div class="headline">
                                             <div>Descripción </div>
                                          </div>
                                             <textarea class="form-control ck_textarea" name="descripcion_bus" placeholder="descripcion del bus" ><?=@$busdetails['descripcion_bus'];?></textarea>
                                       </div>

                                 </div>
                           </div>
                          <div class="tab-pane fade" id="div_itinerario">
                              <div class="typography">
                                  <div class="col-md-12">
                                     <div class="headline">
                                          <div>Itinerario</div>
                                       </div>
                                       <textarea class="form-control ck_textarea" name="itinerario_bus" placeholder="Itinerario"><?=@$busdetails['itinerario_bus'];?></textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane fade " id="div_incluye">
                              <div class="typography">
                                  <div class="col-md-12">
                                     <div class="headline">
                                             <div>Incluye</div>
                                       </div>
                                       <textarea class="form-control ck_textarea" name="incluye_bus" placeholder="El bus incluye" ><?=@$busdetails['incluye_bus'];?></textarea>
                                  </div>
                              </div>
                          </div>
                          
                          <div class="tab-pane fade" id="div_informacion_importante">
                              <div class="typography">
                                 <div class="col-md-12">
                                    <div class="headline">
                                                <div>Informacion adicional</div>
                                       </div>
                                    <textarea class="form-control ck_textarea" name="info_adicional_bus" placeholder="informacion adicional del bus" ><?=@$busdetails['informacion_bus'];?></textarea>
                                 </div>
                              </div>
                          </div>

                          <div class="tab-pane fade" id="div_recomendacion">
                              <div class="typography">
                                 <div class="col-md-12">
                                    <div class="headline">
                                                <div>Recomendación</div>
                                       </div>
                                    <textarea class="form-control ck_textarea" name="recomendaciones_bus" placeholder="Recomendaciones"><?=@$busdetails['recomendacion_bus'];?></textarea>
                                 </div>
                              </div>
                          </div>

                          <div class="tab-pane fade" id="div_add_tabs" > 
                               
                    
                                 <div class=" col-md-12 form-group row">
                                 <div id="added_tabs" data-tabs='<?=@json_encode($bus['tabs_adicionales']);?>'>
                                 </div>
                                 <div class="alert alert-info">
                                   <strong>Importante!</strong> Pulse Agregar Tab para crear nuevos tabs.
                                 </div>
                                 <button id="addTabButton" class="btn btn-primary" type="button"><span class="fa fa-plus"></span> Agregar Tab</button>

                                 </div>
                          </div>
                          <div class="tab-pane fade" id="div_mapa">
                              <div class="typography">
                                 <div class="col-md-12">
                                    <div class="headline">
                                      <div>MAPA</div>
                                    </div>
                                    <?php
                                      $this->load->view("buses/mapa/mapa");
                                    ?>            
                                 </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </fieldset>
              <fieldset>
                     <div class="panel panel-primary navform">
                          <div class="panel-body">
                               <input type="button" name="previous" class="previousStep btn btn-danger" value="Volver" />
                               <input type="button" name="next" class="nextStep btn btn-primary" value="Siguiente"  data-siguiente="calendario"/>
                          </div>
                     </div>
                      <div class="headline">
                       <div>Paso 3: Galeria de Imagenes y politicas de reserva</div>
                      </div>
                          <div class="col-md-6">
                            <div class="panel panel-primary panel-slider">
                                <div class="panel-heading">
                                  <span class="fa fa-file-image-o"></span>
                                  <b>SLIDER DEL BUS</b>
                                </div>
                                <div class="panel-body galeriaDIV" title="Mini Slider" data-galeria='<?=@json_encode($bus['galeria']);?>'>
                                                                
                                </div>
                                <div>
                                  <p class="text-center text-warning"><small>Click en boton "Agregar slider" para agregar campo de galeria</small></p>
                                  <button class="center-block btn btn-primary" id="addGaleriaSlider" type="button"><span class="fa fa-plus-circle"></span> Agregar Slider</button><br>
                                </div>
                                <div class="alert bg-primary" style="margin: 0;">
                                  <div>
                                       <p><b> NOTA!</b></p> La <b>
                                        primera imagen</b> de la lista correspondera a la <b>imagen descata</b> del bus
                                   </div>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                              <div class="panel panel-primary">
                                   <div class="panel-heading">
                                     <span class="fa fa-file-image-o"></span>
                                      <b>Politicas de reserva</b>           
                                    </div>
                                         <div class="panel-body">
                                            <div class="form-group row">
                                                <label class="col-md-4">Anticipación reserva en horas</label>
                                                <div class="col-md-8">
                                                    <input required class="form-control" name="anticipacion_reserva" type="text" value="<?=@$busdetails['hora_anticipacion'];?>" />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label class="control-label">SELECCIONE TIPO DE POLÍTICA: </label>
                                                <div class="radio">
                                                    <label><input type="radio" name="tipopolitica" class="tipopolitica" value="0" checked> Política Stantard (Políticas pre-establecidas por Inca Lake)</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="tipopolitica" class="tipopolitica" value="1"> Política Personalizada (Política personalizada para cada bus)</label>
                                                </div>
                                            </div>
                                            <textarea id="politicas_reserva_text" name="politicas_reserva"><?=@$busdetails['politicas_bus'];?></textarea>
                                         </div>
                                        
                                  </div>
                            </div>
                 </fieldset>
                 <fieldset>
                    <div class="panel panel-primary navform">
                      <div class="panel-body">
                        <input type="button" name="previous" class="previousStep btn btn-danger" value="Volver" />
                        <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente"  data-siguiente=""/>
                      </div>
                    </div>
                    <div class="headline">
                        <div>Paso 4: Bloqueos y disponibilidad</div>
                    </div>
                    <div>
                        <?php $this->load->view('buses/disponibilidad/index'); ?>
                    </div>
                    <br/>
                </fieldset>
                <fieldset>
                  <div class="panel panel-primary navform">
                    <div class="panel-body">
                      <input type="button" name="previous" class="previousStep btn btn-danger" value="Volver" />
                      <button type="submit" id="btnGuardar" style="float:right" class="btn btn-success">
                        <?=@$busdetails['id_bus']?'Guardar cambios':'Registrar';?>
                      </button>
                    </div>
                  </div>
                  <div class="headline">
                    <div>Paso 5: Información adicional sobre la reserva</div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="panel panel-info">
                        <div class="panel-heading" style="text-transform: uppercase;">
                            <strong><span class="badge" title="Paso 1"><big>1</big></span> Información Personal</strong>
                        </div>
                        <div class="panel-body">
                          <p class="text-danger"><span class="fa fa-asterisk text-danger"></span> La información seleccionada será pedido al cliente o pasajero en el momento de la compra.</p>
                          <?php foreach ($arrayDatosPersonales as $key => $value): ?>
                            <label style="font-weight: normal;display: block;">
                            <input type="checkbox" name="chckbxDatosPersonales[]" value="<?=$value['id_campo_formulario']?>" <?=$value['cfhb_id_bus']?"checked":""?> > 
                            <?=mb_strtoupper($value['nombre_campo_formulario'])?></label>
                          <?php endforeach ?>
                          <?php 
                          //echo json_encode($arrayDatosPersonales);
                          ?>
                        </div>
                    </div>
                    <div class="panel panel-success">
                      <div class="panel-heading" style="text-transform: uppercase;">
                          <strong><span class="badge" title="Paso 2"><big>2</big></span> ASOCIAR GUIAS AL SERVICIO (OPCIONAL)</strong>
                      </div>
                      <div class="panel-body">
                        <?php 
                          $checkboxSelected = $selectedGuias;
                          //echo "GUIA: ".$selectedGuias." --> ".$checkboxSelected;
                        ?>
                          <div class="form-group">
                            <label class="control-label">Indicar tipo de guia: </label>
                            <div class="radio">
                              <label><input type="radio" name="tipoguia" class="tipoguia" value="0" <?=(integer)$checkboxSelected == 0?'checked':'' ;?> > Guía de tour en vivo</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="tipoguia" class="tipoguia" value="1" <?=(integer)$checkboxSelected == 1?'checked':'' ;?> > Audio Guía y Audífonos</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="tipoguia" class="tipoguia" value="2" <?=(integer)$checkboxSelected == 2?'checked':'' ;?> > Folletos informativos</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="tipoguia" class="tipoguia" value="3" <?=(integer)$checkboxSelected == 3?'checked':'' ;?> > Sin Guía / No es necesario seleccionar el lenguage (Ejemplo: Tickets de entrada, pasajes)</label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="tipoguia" class="tipoguia" value="4" <?=(integer)$checkboxSelected == 4?'checked':'' ;?>/>
                                    No mostrar nada.
                                </label>
                            </div>
                          </div>
                          <?php 
                            //echo json_encode($dataGuias);
                          ?>
                          <div id="selected-tipoguias" style="display:<?=$checkboxSelected == 3 || $checkboxSelected == 4?'none':'block';?>" >
                            <strong>
                              <p id="txt-seleccionar-tipoguia">Seleccione idiomas del guía de tour en vivo</p>
                            </strong>
                            <select multiple name="slct_guias_seleccionados[]" id="slct_guias_seleccionados">
                              <?php foreach ($dataGuias as $key => $value): ?>
                                <?php 
                                  //$text = $value['id_idioma']."*".$value['id_producto']."*".$value['id_codigo_producto']."*".$value['id_guia']."*".$value['id_codigo_guia'];
                                  $text = $value['id_guia'];
                                  ?>
                                <option value="<?=$text;?>" <?=$value['ghb_id_bus']?'selected':'';?> ><?=$value['idioma_guia'];?></option>      
                              <?php endforeach ?>
                            </select>
                          </div>
                          <br/><br/>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading"><strong><span class="badge" title="Paso 3"><big>3</big></span> INDIQUE OPCIONES DE RECOJO AL CLIENTE:</strong></div>
                        <?php 
                          $opcion     = "OP0";
                          $subOpcion  = "SOP00";
                          if ( !empty($busdetails['recojo_opcion']) ) {
                            if ( $busdetails['recojo_opcion'] === "0" || $busdetails['recojo_opcion'] === 0 ) {
                              $opcion     = "OP0";
                              $subOpcion  = $busdetails['recojo_subopcion']=="0"?"SOP00":"SOP01";    
                            }
                            if ( $busdetails['recojo_opcion'] === "1" || $busdetails['recojo_opcion'] === 1 ) {
                              $opcion     = "OP1";
                              $subOpcion  = $busdetails['recojo_subopcion']=="0"?"SOP10":"SOP11";    
                            }
                          }
                        ?>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label">Indique tipo de recojo: </label>
                                <div class="radio">
                                    <label><input type="radio" name="tiporecojo" class="tiporecojo" value="0" <?=$opcion==="OP0"?"checked":"";?> > Punto de presentación</label>
                                </div>
                                <div class="container" id="container-punto-de-presentacion" style="display:<?=$opcion==='OP0'?"block":"none";?>;">
                                    <div class="radio">
                                        <label><input type="radio" name="tiporecojoA" class="tiporecojoA" value="0" <?=$subOpcion==="SOP00"?"checked":"";?> > Los clientes deben presentarse en Plaza de armas de la ciudad</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="tiporecojoA" class="tiporecojoA" value="1" <?=$subOpcion==="SOP01"?"checked":"";?> > Indicar donde debe presentarse el cliente</label>
                                    </div>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="tiporecojo" class="tiporecojo" value="1" <?=$opcion==="OP1"?"checked":"";?> > Recojo de hotel</label>
                                </div>
                                <div class="container" id="container-recojo-de-hotel" style="display:<?=$opcion==='OP1'?"block":"none";?>;">
                                    <div class="radio">
                                        <label><input type="radio" name="tiporecojoB" class="tiporecojoB" value="0" <?=$subOpcion==="SOP10"?"checked":"";?> > Plaza de armas</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="tiporecojoB" class="tiporecojoB" value="1" <?=$subOpcion==="SOP11"?"checked":"";?> > Otros</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" id="lbl_lugar_encuentro">Indicar el Lugar de Presentación para Iniciar la actividad:</label>
                                <textarea class="form-control" row="1" name="txt_lugar_encuentro" id="txt_lugar_encuentro" style="margin: 0px 4.51563px 0px 0px; height: 142px; width: 616px;"><?=@$busdetails['recojo_inicio_servicio'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Indique donde terminará la actividad (opcional):</label>
                                <textarea class="form-control" rows="1" name="txt_lugar_finalizacion" id="txt_lugar_finalizacion" placeholder="Describa donde se les dejará a los clientes después de finalizar el servicio" style="margin: 0px 1.51563px 0px 0px; height: 135px; width: 619px;"><?=@$busdetails['recojo_fin_servicio'];?></textarea>
                            </div>
                        </div>
                    </div>
                  </div>
                </fieldset>
          </form>
			</div>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
    </footer>
    <script>
      // variable usada desde regedit_buses.js
      json_lugares = <?=json_encode($lugares);?>;
    </script>
    <script src="<?=base_url();?>recursos/js/regedit_buses.js"></script>
    <style type="text/css">
    /*un poco de estilo a los inputs de la galeria*/
        div.galeriaDivs{
            margin-bottom:3px;
            padding: 0;
            display: flex;
        }
        div.galeriaDivs input{
            padding:5px;
            border:1px solid #CCC;
            border-right: none;
            border-left: none;
            width: 250px;
        }
        div.galeriaDivs button{
            padding:5px !important;
            height:32px;
            border:1px solid #CCC;
            background:#DDD;
        }
        div.galeriaDivs button:hover{
            background:#CCC;
        }

      /* estilos del los botones de navegacion */
      #formPrincipal fieldset:not(:first-of-type) {
        display: none;
      }
      #formPrincipal .formError2{
        border-color:#DC3D4A;
      }
      div.navform{
        clear:both;
        background: -webkit-linear-gradient(left,#ECB4B7,white,white,white,#ACB7CA);
        border:1px solid #E7F0FF;
      }
      div.navform .panel-body{
        padding: 5px;
      }
      div.navform .nextStep{
        float: right;
      }
        div.navform .previousStep{
        float: left;
      }
      /* servicios adicionales */ 
      .serv_adicional label{
        background:#e4e4c9;
        padding:3px;
      }
      label .fa-question{
        float:right;
      }
    </style>
    <script>
        var timepickersettings = {
                  minuteStep: 10,
                  appendWidgetTo: 'body',
                  showSeconds: false,
                  showMeridian: true,
                  defaultTime: false
              };
         $('.inputTime').timepicker(timepickersettings);
         var bus_copiado = <?=@$bus_copiado?1:0?>;
         // si es un bus copiado (clonado) se vacia ciertos campos necesitan traduccion
         if(bus_copiado){
            $('#titulo_bus').val('');
            $('#subtitulo_bus').val('');
            // tabs
            $('.ck_textarea').val('');
         }
     
        //

        // ckeditor para politicas de reserva
        var ckeditor = CKEDITOR.replace( 'politicas_reserva_text', {
            toolbar: [
                { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	
                [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],'/',												
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock',
   'Image','Table','-','Link','Flash','Smiley','TextColor','BGColor' ] }
            ]
        });

        // set tasas impuestos si existe
        var tasas_impuestos = $('#tasas_impuestos');
        tasas_impuestos.val(tasas_impuestos.data('value'));
      // imprimir politicas estandar para posterior uso
      var politicas_reserva_text = $('#politicas_reserva_text');
      var tipo_politicas_check = $('.tipopolitica');
      var politicas_estandar = `<?php @include('../web/assets/archivos/politicas_bus/'.@strtoupper(@$pagina_web['cod_idioma']).'.txt'); ?>`;
      tipo_politicas_check.on('change',function(event){
          if(+this.value)ckeditor.setData('');
          else ckeditor.setData(politicas_estandar);
      });
      ckeditor.on('change',function(){
        // cambiar el foco si text es cambiado controlando error que solo cuando el change es realizado desde el mismo textarea se genera evento
         if(!tipo_politicas_check.eq(0).is(":focus"))tipo_politicas_check[1].checked = true;

     });
     // en caso de editar set default
     if(politicas_reserva_text.val())tipo_politicas_check[1].checked = true;
     else ckeditor.setData(politicas_estandar);
     /* console.log('val: '+politicas_reserva_text.val());
      politicas_reserva_text.val(politicas_estandar);*/
      //
      /******************** OPERAR DISPONIBILIDAD, BLOQUEOS Y OFERTAS *******************/
      var jsonDisponibilidad  = JSON.parse('<?=json_encode($dataDisponibilidad)?>');
      var jsonBloqueos        = JSON.parse('<?=json_encode($dataBloqueos)?>');
      var jsonOfertas         = JSON.parse('<?=json_encode($dataOfertas)?>');
      
      console.log("Disponibilidad",jsonDisponibilidad);
      console.log("Bloqueos",jsonBloqueos);
      console.log("ofertas",jsonOfertas);    
      /**********************************************************************************/
      if ( jsonDisponibilidad.length != 0 ) {
        array_dias_no_activos.length = 0;
        array_dias_no_activos         = jsonDisponibilidad[0]['dias_no_activos'];
        editar_array_dias_especiales  = jsonDisponibilidad[0]['dias_especiales'];
        editar_array_meses_inactivos  = jsonDisponibilidad[0]['meses_inactivos'];
        $.each(jsonDisponibilidad, function(index, val) {
          js_disponibilidad.set_datos_disponibilidad( val );
          $("#txt_fecha_inicio_disponibilidad").empty().val( moment(val['start']).format("DD-MM-YYYY") );
          $("#txt_fecha_fin_disponibilidad").empty().val( moment(val['end']).format("DD-MM-YYYY") );
          actualizar_disponibilidad(moment(val['start']).format("YYYY-MM-DD"), moment(val['end']).format("YYYY-MM-DD") );
        });
        $("#txt_data_json_disponibilidad").empty().val(JSON.stringify(js_disponibilidad.get_datos_disponibilidad() ) );
        
        //console.log("DATA BLOQUEOS",JSON.stringify(jsonBloqueos));
        $.each(jsonBloqueos, function(index, val) {
          js_bloqueo.set_datos_bloqueo( val );
        });
        $.each(jsonOfertas, function(index, val) {
          js_oferta.set_datos_oferta( val );
        });

        for(var i in array_dias_no_activos){
          $("#chckbx_dia_"+array_dias_no_activos[i]).prop("checked", false);
        }
        for(var i in editar_array_dias_especiales){
          $("#dias_especiales_"+editar_array_dias_especiales[i]).prop("checked", true);
          //Actualiza los dias_especiales seleccionados
          array_dias_especiales.push(editar_array_dias_especiales[i]);
        }
        
        actualizar_eventos();      
      }
      /************* ACTUALIZAR REQUERIR DISPONIBILIDAD *************/
      var requerirDisponibilidad = '<?=$requerirDisponibilidad?>';
      console.log("Disponibilidad",requerirDisponibilidad);
      if (parseInt(requerirDisponibilidad)) {
        $("#chckbxRequirirDisponibilidad").prop('checked', 'checked');
      }
      /***************** END ACTUALIZAR DISPONIBILIDAD **************/      

      /*********************** ACTUALIZAR MAPA **********************/
      var arrayLugares = JSON.parse('<?=json_encode($dataLugares);?>');
      console.log("Lugares",arrayLugares);
      if ( arrayLugares.length ) {
        $.each(arrayLugares, function(index, val) {
          points.lugares.push(val);
        });
        addMarker(points.lugares);
        $("#span_cantidad_lugares").empty().text(points.lugares.length);
      }
      /********************* END ACTUALIZAR MAPA *********************/

      /********************** OPCIONES DE RECOJO *********************/
      $(document).on('change', '.tiporecojoA', function(event) {
        var value = $(this).val();
        var message = "";
        var contentValue = "";
        
        switch(parseInt(value)){
          case 0:
            //$("#txt_lugar_encuentro").val(tokens['lugar_de_presentacion'][(idioma_actividad).toLowerCase()]);
          break;
          case 1:
            //$("#txt_lugar_encuentro").val("");
          break;
        }
        //$("#txt_lugar_finalizacion").val(tokens['retorno_plaza_de_armas'][(idioma_actividad).toLowerCase()]);
        console.log("Click first..!");
      });

      $(document).on('change', '.tiporecojoB', function(event) {
        var value = $(this).val();
        var message = "";
        var contentValue = "";
        
        switch(parseInt(value)){  
          case 0:
            //$("#txt_lugar_encuentro").val(tokens['recojo_de_hotel'][(idioma_actividad).toLowerCase()]);
          break;
          case 1:
            //$("#txt_lugar_encuentro").val("");
          break;
        }
        //$("#txt_lugar_finalizacion").val(tokens['lugar_de_finalizacion_actividad'][(idioma_actividad).toLowerCase()]);
        console.log("Click Second..!");
      });
      $(document).on('change', '.tiporecojo', function(event) {
        event.preventDefault();
        var value = $(this).val();
        var message = "";
        var contentValue = "";
        switch(parseInt(value)){
          case 0:
            message       = "Indicar el Lugar de Presentación para Iniciar la actividad:";
            contentValue  = "Jr. Cajamarca 619, oficina #04 (Inca Lake)";
            $("#container-recojo-de-hotel").slideUp("slow");
            $("#container-punto-de-presentacion").slideDown();
            $("#txt_lugar_encuentro").val("");
            removerCheck("tiporecojoA",false);
          break;
          case 1:
            message       = "Indicar hoteles aplicables para el recojo:";
            contentValue  = "Hoteles ubicados alrededor de la plaza de armas de Puno";
            $("#container-punto-de-presentacion").slideUp("slow");
            $("#container-recojo-de-hotel").slideDown();
            $("#txt_lugar_encuentro").val("");
            removerCheck("tiporecojoB",false);
          break;
        }    
        $('#lbl_lugar_encuentro').text(message);
        //$('#txt_lugar_encuentro').val(contentValue);
        $('#txt_lugar_encuentro').focus();
      });
      function removerCheck(className,status){
        $('.'+className).each(function(){
          $(this).prop('checked', status);  
        });
      }
      /******************** END OPCIONES DE RECOJO ********************/

      /******************* SELECCIONAR TIPO GUIA **********************/
      $(document).on('change', '.tipoguia', function(event) {
        var value = $(this).val();
        var message = "";
        var contentValue = "";
        //console.log("CLICK ",value);
        switch(parseInt(value)){  
          case 0:
            //$("#txt_lugar_encuentro").val(tokens['recojo_de_hotel'][(idioma_actividad).toLowerCase()]);
            $("#txt-seleccionar-tipoguia").empty().text("Seleccionar idiomas del Guía de tour en vivo");
            $("#selected-tipoguias").slideDown('slow');
          break;
          case 1:
            //$("#txt_lugar_encuentro").val("");
            $("#txt-seleccionar-tipoguia").empty().text("Seleccionar idiomas del Audio Guía");
            $("#selected-tipoguias").slideDown('slow');
          break;
          case 2:
            $("#txt-seleccionar-tipoguia").empty().text("Seleccionar idiomas de Folletos informativos");
            $("#selected-tipoguias").slideDown('slow');
          break;
          case 3:
            $("#txt-seleccionar-tipoguia").empty().text(" ");
            $("#selected-tipoguias").slideUp('slow');
          break;
          case 4:
            $("#txt-seleccionar-tipoguia").empty().text(" ");
            $("#selected-tipoguias").slideUp('slow');
          break;
           
        }
        //$("#txt_lugar_finalizacion").val(tokens['retorno_plaza_de_armas'][(idioma_actividad).toLowerCase()]);
      });
      /***************** END SELECCIONAR TIPO GUIA ********************/
    </script>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        
        /*** Script es para renderizar nuevamente el calendario de dispoinbilidad cuando ya llegue a ese paso ***/ 
        $(document).on('click', '.nextStep', function(event) {
          event.preventDefault();
          var valor = $(this).data("siguiente");
          if (valor === "calendario") {
            $("#calendario_incalake").fullCalendar('render');
          }
        });

      }); 
      $("#slct_guias_seleccionados").multiselect({
          title: "Seleccionar...",
          //maxSelectionAllowed: 5
        });
    </script>
	</body>
</html>