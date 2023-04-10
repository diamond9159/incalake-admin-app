<?php
$data_disponibilidad = "[]";
$data_bloqueo = "[]";
$data_oferta = "[]";
$data_editar = 0;
$data_mapa = "[]";
$requerir_disponibilidad = false;
$arrayGuias = [];
$next_codigo_producto = null;
$checkedRecojo = 1; //por defecto 1 ->  Recojo desde hoteles.
$checkedPolitica = 1; //por defecto 1 -> Politica personalizada.
if (isset($servicio)) {
  $ideGeneral = $servicio['id_servicio'];
  $tituloProducto = $servicio['titulo_pagina'];
  $tituloPagina = 'Agregando nuevo';
  $formButton = 'Guardar';
  //    var_dump($servicio);

  $json_nacionalidades = $servicio["nacionalidades"];
  $json_edad = $servicio["etapas_edad"];
  $arrayGuias = $guias_disponibles;
} elseif (isset($producto)) {
  // var_dump($producto);
  $ideGeneral = $producto['id_producto'];
  $tituloProducto = $producto['titulo_producto'];
  $tituloPagina = 'Se esta editando: ' . $producto['titulo_producto'];
  $formButton = 'Actualizar';
  $servicio['pais'] = $producto['pais'];
  $servicio['id_servicio'] = $producto['id_servicio'];
  $servicio['url_servicio'] = $producto['url_servicio'];
  $servicio['codigo'] = $producto['codigo'];
  $servicio['politicas'] = trim($producto['politicas_producto']);
  $checkedRecojo = !empty($producto['tipo_recojo']) ? $producto['tipo_recojo'] : 0;
  $checkedPolitica = strlen(trim($producto['politicas_producto'])) == 0 ? 0 : 1; // 0 = politica Standar, 1 = politica personalizada 

  $json_nacionalidades = $producto["nacionalidades"];
  $json_edad = $producto["etapas_edad"];
  //var_dump($producto);
  $requerir_disponibilidad = $producto['requerir_disponibilidad'] ? true : false;
  /**************** VALIDA SI SON OBJETOS LOS RESULTADOS ****************/
  $data_disponibilidad = json_decode($producto['disponibilidad'], true);
  $data_bloqueo = json_decode($producto['bloqueo'], true);
  $data_oferta = json_decode($producto['oferta'], true);
  $arrayGuias = $guias;
  if (isset($producto['mapa_tab']) && trim($producto['mapa_tab']))
  //if ( count( trim($producto['mapa_tab']) ) != 0 ) 
  {
    $data_temp = json_decode($producto['mapa_tab'], true);
    $data_mapa = $data_temp['lugares'];
  }
  $data_editar = 1;
  /************** END VALIDA SI SON OBJETOS LOS RESULTADOS ****************/
}
if (isset($producto_relacionado)) {
  $producto['codigo_producto'] = $producto_relacionado['codigo_producto'];
  $producto['hora_inicio'] = $producto_relacionado['hora_inicio'];
  $producto['duracion'] = $producto_relacionado['duracion'];
  $producto['zona_horaria'] = $producto_relacionado['zona_horaria'];
  $producto['precios_full'] = $producto_relacionado['precios_full'];
  $producto['porcentaje_adelanto'] = $producto_relacionado['porcentaje_adelanto'];
  $producto['galeria'] = $producto_relacionado['galeria'];
  $producto['ciudad_cercana'] = $producto_relacionado['ciudad_cercana'];
  $producto['aeropuerto_cercano'] = $producto_relacionado['aeropuerto_cercano'];
  $producto['config_form'] = empty($producto_relacionado['config_form']) ? '' : $producto_relacionado['config_form'];
  $producto['id_codigo_producto'] = $this->uri->segment(5);

  $formularios = $producto_relacionado['demo'];
  $producto['tasas_impuestos'] = $producto_relacionado['data_producto']->tasas_impuestos;
  $producto['forms_multiple'] = $producto_relacionado['data_producto']->forms_multiple == 1 ? true : false;
  $producto['capacidad'] = $producto_relacionado['data_producto']->capacidad;
  $producto['anticipacion_reserva_producto'] = $producto_relacionado['data_producto']->anticipacion_reserva_producto;
  $checkedPolitica = strlen(trim($producto_relacionado['politicas_producto'])) == 0 ? 0 : 1; // 0 = politica Standar, 1 = politica personalizada 

  $requerir_disponibilidad = $producto_relacionado['requerir_disponibilidad'] ? true : false;
  /********************* VALIDA SI SON OBJETOS LOS RESULTADOS ***********************/
  $data_disponibilidad = json_decode($producto_relacionado['disponibilidad'], true);
  $data_bloqueo = json_decode($producto_relacionado['bloqueo'], true);
  $data_oferta = json_decode($producto_relacionado['oferta'], true);
  if (count(trim($producto_relacionado['data_mapa'])) != 0) {
    $data_mapa_temp = json_decode($producto_relacionado['data_mapa'], true);
    $data_mapa = $data_mapa_temp['lugares'];
  }
  //$arrayGuias          = $producto_relacionado['guias'];
  $arrayGuias = $guias_disponibles;
  $data_editar = 1;
  /******************* END VALIDA SI SON OBJETOS LOS RESULTADOS *********************/
}
//var_dump($idiomas);
$idiomasJSON = array();
foreach ($idiomas as $value)
  if ($value['codigo'] != 'ES')
    $idiomasJSON[strtolower($value['codigo'])] = strtolower($value['pais']);
//var_dump($servicio);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>
        <?= $tituloPagina; ?>
    </title>
    <meta charset="UTF-8">

    <script>
    <?= 'base_url = "' . base_url() . '";'; ?>
    //print nacionalidades and edades
    nacionalidades = <?= $json_nacionalidades; ?>;
    etapas_edad = <?= $json_edad; ?>;
    </script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/bootstrap-select/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/multi-select/css/multiselect.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/resources/jquery/jquery-ui.js" type="text/javascript"></script>
    <script src="<?= base_url(); ?>assets/resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="<?= base_url(); ?>assets/resources/ckeditor/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js" type="text/javascript">
    </script>
    <script src="<?= base_url(); ?>assets/resources/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript">
    </script>
    <script src="<?= base_url(); ?>assets/resources/jquery-validation/js/jquery.validationEngine.js"
        type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url(); ?>assets/resources/multi-select/js/multiselect.min.js" type="text/javascript"
        charset="utf-8"></script>

    <script src="<?= base_url(); ?>recursos/js/galeria.js"></script>
    <!--script src="<?= base_url(); ?>recursos/js/precios.js"></script-->
    <script src="<?= base_url(); ?>recursos/js/precios_2.js"></script>

    <script src="<?= base_url(); ?>recursos/js/validador.js"></script>
    <script src="<?= base_url(); ?>recursos/js/sisyphus.min.js"></script>
    <script src="<?= base_url(); ?>recursos/js/bootbox.min.js"></script>
    <script src="<?= base_url(); ?>recursos/js/timepicker.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/css/bootstrap-timepicker.min.css" />
    <script type="text/javascript">
    var urlRightNavBar = '<?= base_url(); ?>';
    </script>
    <script src="<?= base_url(); ?>assets/resources/js/admin.js" type="text/javascript"></script>

    <script src="<?= base_url(); ?>assets/resources/bootstrap-color-selector/js/bootstrap-colorselector.min.js"
        type="text/javascript"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>recursos/css/galeria.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>recursos/css/precios.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/resources/css/admin.css" />
    <link rel="stylesheet"
        href="<?= base_url(); ?>assets/resources/bootstrap-color-selector/css/bootstrap-colorselector.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/jquery-validation/css/validationEngine.jquery.css"
        type="text/css" />

    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/jquery/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/flags/flags.min.css">
    <script>
    <?php
    echo 'idiomas=' . json_encode($idiomasJSON) . ';'; //imprimir idiomas en json para precios.js
    
    function addInicios($inicio = null, $duracion = null, $tipo = null, $zona = null)
    {
      $optionsHTML = '<option value="">-- Tipo --</option>';
      $options = array('Minutos', 'Horas', 'Dias');
      foreach ($options as $key => $value)
        $optionsHTML .= '<option ' . ($tipo == $key && $tipo != null ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';

      return '<div class="container-fluid text-center form-group " style="padding:0; color: #000;">' .
        '<div class="col-md-3 col-xs-2" style="padding:0;"><div><input class="form-control inputTime" data-error="Falta establecer horas de inicios." required style="width:100%;" name="horasalida_prod[]" type="text" value="' . $inicio . '" placeholder="Hora de Inicio" /> </div></div>' .
        '<div class="col-md-4 col-xs-6 ">' .
        '<div class="input-group">' .
        '<div class="input-group-addon" style="padding: 0;border: none;">' .
        '<input data-error="Necesita establecer la duracion de las salidas." required class="form-control"  name="horaretorno_prod[]" style="border-right:none;border-radius:5px 0 0 5px" type="number" value="' . $duracion . '" placeholder="Duracion" />' .
        '</div>' .
        '<div class="input-group-addon" style="padding: 0;border: none;" >' .
        '<select style="border-radius:0 5px 5px 0"  required class="form-control" name="tipo_medida_duracion[]" data-error="Seleccione tipo de duracion Horas/Dias">' . $optionsHTML . '</select>' .
        '</div>' .
        '</div>' .
        '</div>' .
        '<div class="col-md-3 col-xs-2" style="padding:0;"><label><span class="flag flag-bo"></span> Hora Boliviana: <input type="hidden" name="zona_horaria[]" value="0"  /> <input type="checkbox" class="zona_check"  ' . ($zona ? 'checked' : null) . '  /> </label></div>' .
        ' <div class="col-md-2 col-xs-2 ><span fa fa-window-close fa-2x" title="Eliminar Horario" style="color: #d22521;cursor: pointer;" onclick="eliminarinicios($(this));"></span></div>' . '</div>';
    }
    $div_notiene_horarios = '<div class="div-sin-horario col-md-12 text-center alert alert-danger" ><b>No Posee horario de salida para el paquete turistico! </b></div>';
    //$idtab = 0;
    function addTab($nombre = null, $icono = null, $html = null, $textareaIDkey = false)
    { // si tiene valor trabaja con php
      $fontawesome = array(
        'address-book' => 'f2b9',
        'car' => 'f1b9',
        'bars' => 'f0c9',
        'clock-o' => 'f017',
        'commenting' => 'f27a',
        'film' => 'f008',
        'bed' => 'f236',
        'exclamation-triangle' => 'f071',
        'film' => 'f008',
        'th-large' => 'f009',
        'th' => 'f00a',
        'th-list' => 'f00b',
        'check' => 'f00c',
        'times' => 'f00d'
      );
      $options = null;


      foreach ($fontawesome as $key => $value) {
        $options .= '<option ' . ($icono == $key ? 'selected' : '') . ' class="icon-' . $key . '" value="' . $key . '"> &#x' . $value . '; ' . $key . '</option>';
      }
      return '<div class="panel panel-info"><div class="panel-heading"><h4 class="panel-title"><span class="fa fa-chevron-right"></span><b>Agregar Nuevo Tab</b><span onclick="$(this).parent().parent().parent().remove();" class="fa fa-window-close fa-2x" style="float: right; cursor: pointer; color: #d22521;margin-top: -7px;"></span></h4></div><div"><div class="panel-body"><div class=""><label>Nombre Tab: </label><input class="form-control" value="' . $nombre . '" type="text" name="addedTabs_nombre[]" /><label>Icono Tab: </label><select style="font-family: FontAwesome, Helvetica" class="form-control" name="addedTabs_icono[]" id="addedTabs_icono"><option value="">-- Icono --</option>' . $options . '</select><div class=""><label>Contenido HTML: </label><textarea id="htmlcontent' . (is_int($textareaIDkey) ? $textareaIDkey : 's\'+textareaIDkey+\'') . '" class="form-control" name="addedTabs_contenido[]">' . $html . '</textarea></div></div></div></div>';
      // $idtab++;
    }

    function addFormGaleria($id = null, $nombre = null, $folder = 0)
    {
      return '<div class="galeriaDivs"><button class="col-md-4 col-xs-3" onclick="openGaleria($(this),' . $folder . ',this.parentNode.parentNode.title' . ($folder ? ',[800,400,100,150]' : '') . '); return false;"><span class="fa fa-search-plus"></span><span class="hidden-xs"> Buscar ' . ($folder ? 'Imagen' : 'Documento') . '</span></button><input type="text" class="inputImagenModal col-md-5" value="' . $nombre . '" readonly /><input type="hidden" class="inputHideImagenModal" name="' . ($folder ? 'sliderGaleria[]' : 'adjuntos_producto[]') . '" value="' . $id . '" /><button class="col-md-3" onclick="$(this).parent().remove()"><span class="fa fa-close"></span></button></div>';
    }


    ?>
    ///////////////////////////////
    $().ready(manejarDOM);

    function manejarDOM() {
        $('.inputTime').timepicker({
            minuteStep: 10,
            appendWidgetTo: 'body',
            showSeconds: false,
            showMeridian: true,
            defaultTime: false
        });
        //funcion para agregar tabs
        textareaIDkey = 0;
        $('#addTabButton').click(function() {
            $('#added_tabs').append('<?= addTab() ?>');
            CKEDITOR.replace('htmlcontents' + textareaIDkey);
            textareaIDkey++;
            return false;
        });
        // fin de la funcion para agregar tabs
        // funcion ppara manejar salidas
        function cambiarBandera() {
            //var bandera = $(this).siblings('span');
            var hidden = $(this).siblings('input');
            if ($(this).is(':checked')) {
                //bandera.attr('class','flag flag-bo');
                hidden.val(1);
            } else {
                //bandera.attr('class','flag flag-pe');
                hidden.val(0);
            }
        }
        $(document).on('change', '.zona_check', cambiarBandera);
        $('.zona_check').each(cambiarBandera);
        ///
        var clicksSalidas = false;
        $('#addSalidasButton').click(function() {
            var varhtml = '<?= addInicios(); ?>';
            if (clicksSalidas) $('#added_salidas').append(varhtml);
            else $('#added_salidas').append(varhtml);
            $(".div-sin-horario").remove();
            $('.inputTime').timepicker({
                minuteStep: 10,
                appendWidgetTo: 'body',
                showSeconds: false,
                showMeridian: true,
                defaultTime: '00:00'
            });
            clicksSalidas = true;
            return false;
        });
        /**********************************************************/
        $('#generarSalidas').click(function() {
            $('#contenedorGenerador').toggle();
        });
        $('#btn_listo').click(function() {
            var inputs = $('#contenedorGenerador').find('input, select');
            inputs.focusin(function() {
                $(this).css('border-color', '#CCC');
            });

            var exito = true;
            inputs.each(function(i) {
                if (!$(this).val() && i != 5) {
                    $(this).css('border-color', 'red');
                    exito = false;
                }
            });
            if (exito) {
                var pm_settings = [];
                var addSalidasButton = $('#addSalidasButton');
                var div_ultimo, inputs2;
                var desde = inputs[0].value.split(' ');
                var hasta = inputs[1].value.split(' ');

                var desde_tiempo = desde[1];
                var hasta_tiempo = hasta[1];
                var desde_horamin = desde[0].split(':');
                var hasta_horamin = hasta[0].split(':');
                var desde_hora = desde_tiempo == 'AM' ? parseInt(desde_horamin[0]) : parseInt(desde_horamin[
                    0]) + 12;
                var hasta_hora = hasta_tiempo == 'AM' ? parseInt(hasta_horamin[0]) : parseInt(hasta_horamin[
                    0]) + 12;

                if (desde_hora <= hasta_hora) {
                    for (i = desde_hora; i <= hasta_hora; i += parseInt(inputs[2].value)) {
                        addSalidasButton.trigger('click');
                        div_ultimo = $('#added_salidas>div').last();
                        inputs2 = div_ultimo.find('input,select');

                        inputs2[0].value = (i < 13 ? i : i - 12) + ':' + desde_horamin[1] + (i < 13 ? ' AM' :
                            ' PM');
                        inputs2[1].value = inputs[3].value;
                        inputs2[2].value = inputs[4].value;
                        inputs2[4].checked = inputs[5].checked;

                    }
                    $('.zona_check').each(cambiarBandera);
                } else alert('Imposible generar porque DESDE es mayor que el HASTA');


                // alert(inputs[0].value+' :: '+inputs[1].value+' :: '+inputs[2].value);



            }
        });
        /**********************************************************/
        eliminarinicios = function(elemen) {
            elemen.parent().remove();
            if ($("#added_salidas").html() == "") {
                $("#added_salidas").html('<?= $div_notiene_horarios; ?>');
                clicksSalidas = false;
                console.log('vacio');
            }
        }

        // fin funcion para salidas
        //
        $('#formPrincipal').submit(function() {
            /*var text = [];
          $('#checkers input.config_cheks').each(function(key){
            text.push($(this).is(":checked")?1:0);
          });
   
          $('#check_configs').val(text.join());*/
            $(this).attr('disabled', 'disabled');
        });
        //agregar boton de guardado rapido en cada paso en la cabezera
        /*$('fieldset .headline:first-child').append(`
               <button type="button"  class="btn btn-success pull-right" onclick="$('#btnGuardar').trigger('click');">
                   Actualizar y guardar
               </button>
        `);*/

    }
    </script>
    <style type="text/css">
    #formPrincipal fieldset:not(:first-of-type) {
        display: none;
    }

    #formPrincipal .formError2 {
        border-color: #DC3D4A;
    }

    div.navform {
        clear: both;
        background: -webkit-linear-gradient(left, #ECB4B7, white, white, white, #ACB7CA);
        border: 1px solid #E7F0FF;
    }

    div.navform .panel-body {
        padding: 5px;
    }

    div.navform .nextStep {
        float: right;
    }

    div.navform .previousStep {
        float: left;
    }
    </style>
</head>

<body>
    <header>
        <?php
        $this->load->view('admin/vistas/header/menu');
        ?>
    </header>
    <content>
        <div class="container-fluid">
            <div class="titulo-producto">ACTIVIDAD<span class="fa fa-chevron-right"
                    style="vertical-align: middle;color: #5cb85c;"> </span> <?= $tituloProducto; ?></div>
            <div class="alert alert-info" style="padding:7px">
                <b>Idioma: </b><span
                    class="flag flag-<?= @$servicio['codigo'] == 'EN' ? 'us' : strtolower($servicio['codigo']); ?>"></span>
                <?= @$servicio['pais']; ?> | <strong>URL: </strong> <?= @$servicio['url_servicio']; ?>

                <?php
                if ($formButton == 'Actualizar') {
                  ?>

                <button style="margin-top:-7px" type="button" class="btn btn-success pull-right"
                    onclick="$('#btnGuardar').trigger('click');">Actualizar y guardar</button>
                <?php }
                ;
                ?>
            </div>
            <?php
            //echo json_encode($data_disponibilidad)."<br/>"; 
            //echo json_encode($data_bloqueo)."<br/>"; 
            //echo json_encode($data_oferta); 
            //echo "ESTADO VALOR EDITAR: ".$data_editar;
            //echo json_encode($data_mapa);
            //print_r($data_mapa);
            //echo "NEXT CODE: ".$next_codigo_producto;
            //echo json_encode($servicio);
            //echo "CHECK RECOJO: ".$checkedRecojo."<br/>";
            //echo "CHECK POLITICA: ".$checkedPolitica."<br/>";
            //echo json_encode($producto);
            //echo "POLITICAS: ".$producto['politicas_producto'];
            //echo "POLÍTICAS: ".$producto['politicas_producto'];
            //echo "<BR/>SET POLITICAS: ".$texto_politicas;
            //echo "REQUERIR DATOS: ".json_encode($requerir_disponibilidad);
            //echo json_encode($arrayGuias);
            ?>
            <form action="<?= base_url() ?>admin/productos/regedit" method="post" id="formPrincipal">
                <input type="hidden" name="ideGeneral" value="<?= $ideGeneral; ?>" />
                <input type="hidden" name="configuraciones" id="check_configs" />
                <input type="hidden" name="codigo_prod_2" value="<?= @$producto['id_codigo_producto']; ?>" />
                <!-- para agrupar por idiomas -->
                <div class="col-md-12" style="padding: 0;">
                    <!-- ideGeneral se usa dinamicamente puede usarse para poner el IDE de el servicio para agregar uno nuevo o el ide del producto para su edicion-->
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>

                    <fieldset class="text-center">
                        <div class="panel panel-primary navform">
                            <div class="panel-body">
                                <input type="button" name="next" class="nextStep  btn btn-primary" value="Siguiente" />
                            </div>
                        </div>
                        <div class="text-left">
                            <div class="headline">
                                <div>Paso 1: Información general</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2" for="titulo_prod">Titulo actividad <span
                                        class="btn btn-info btn-xs fa fa-question" data-placement="top"
                                        data-toggle="popover"
                                        data-content="Escribir el título de la actividad ubicado en el encabezado."></label>
                                <div class="col-md-10">
                                    <input required class="form-control"
                                        data-error="Necesita ingregar el titulo de la actividad." type="text"
                                        id="titulo_prod" name="titulo_prod"
                                        value="<?= @$producto['titulo_producto']; ?>" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2" for="subtitulo_prod">Subtitulo actividad <span
                                        class="btn btn-info btn-xs fa fa-question" data-placement="top"
                                        data-toggle="popover"
                                        data-content="Escribir el subtítulo de la actividad ubicado bajo el encabezado del título de actividad."></label>
                                <div class="col-md-10">
                                    <input class="form-control" id="subtitulo_prod" name="subtitulo_prod" type="text"
                                        value="<?= @$producto['subtitulo_producto']; ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2" for="codigo_prod">Codigo de actividad <span
                                        class="btn btn-info btn-xs fa fa-question" data-placement="top"
                                        data-toggle="popover"
                                        data-content="Escribir el código de la actividad de uso personal para el administrador."></label>
                                <div class="col-md-10">
                                    <input required placeholder="Ejemplo: UROS-MD-2017"
                                        data-error="Ingrese el Codigo de la actividad."
                                        <?= (isset($producto) or isset($producto_relacionado)) ? 'readonly' : ''; ?>
                                        class="form-control" id="codigo_prod" name="codigo_prod" type="text"
                                        value="<?= @$producto['codigo_producto']; ?>" />
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-md-2" for="ciudad_cercana">Ubicación de la Actividad Turistica<span
                                        class="btn btn-info btn-xs fa fa-question" data-placement="top"
                                        data-toggle="popover"
                                        data-content="Indique el nombre o la ciudad donde esta ubicado la actividad Turistica"></label>
                                <div class="col-md-10">
                                    <input required class="form-control" id="ciudad_cercana" name="ciudad_cercana"
                                        type="text" value="<?= @$producto['ciudad_cercana']; ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2" for="aeropuerto_cercano">Aeropuerto cercano
                                    <small>(OPCIONAL)</small> <span class="btn btn-info btn-xs fa fa-question"
                                        data-placement="top" data-toggle="popover"
                                        data-content="Escribir areopuerto cercano al producto."></label>
                                <div class="col-md-10">
                                    <input class="form-control" id="aeropuerto_cercano" name="aeropuerto_cercano"
                                        type="text" value="<?= @$producto['aeropuerto_cercano']; ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2" for="aeropuerto_cercano">Actividad Activo <span
                                        class="btn btn-info btn-xs fa fa-question" data-placement="top"
                                        data-toggle="popover"
                                        data-content="Estado de producto  visible/no vivisble, en la web."></label>
                                <div class="col-md-10">
                                    <input type="checkbox" name="estado_producto" value="1"
                                        <?= !isset($producto['estado_producto']) ? 'checked' : ((int) $producto['estado_producto'] ? 'checked' : ''); ?> /><small>
                                        Si esta activo este producto se muetra en la web de lo contrario no.</small>

                                </div>
                            </div>
                            <!-- salidas -->

                            <div class="col-md-12 form-group row">
                                <div class="col-md-12 text-center container-fluid"
                                    style="background: #286090; color: #fff; padding: 5px 0;">
                                    <div class="col-md-3 col-xs-2">SALIDA</div>
                                    <div class="col-md-4 col-xs-6">DURACIÓN APROXIMADA</div>
                                    <div class="col-md-3 col-xs-2">ZONA HORARIA</div>
                                    <div class="col-md-2 col-xs-2">OPERACION</div>
                                </div>
                                <div class="col-md-12" id="added_salidas" style="padding: 5px 0 0 0;">
                                    <?php
                                    if (!empty($producto['hora_inicio'])) {
                                      $html_inicios = null;
                                      $hora_inicio = explode(',', $producto['hora_inicio']);
                                      $duracion = explode(',', @$producto['duracion']);
                                      $zona_horaria = explode(',', @$producto['zona_horaria']);
                                      //var_dump($hora_inicio);
                                      foreach ($hora_inicio as $key => $value) {
                                        $durYtipo = explode('!', $duracion[$key]);
                                        $html_inicios .= addInicios($value, $durYtipo[0], $durYtipo[1], @$zona_horaria[$key]);
                                      }
                                      echo $html_inicios;
                                    } else {
                                      echo $div_notiene_horarios;
                                    }
                                    ?></div>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-success" id="addSalidasButton"
                                        title="(Usado mayormente en tours compartidos o de salida simple)"><span
                                            class="fa fa-plus"></span> Agregar Hora de salida</button>
                                    <button type="button" class="btn btn-warning" id="generarSalidas"
                                        title="(Usado mayormente en tours privados)"> Generar rango de salidas</button>
                                    <div><small>Agregar Hora de salida (Usado mayormente en tours compartidos o de
                                            salida simple) | Generar rango de salidas (Usado mayormente en tours
                                            privados)</small></div>


                                    <div id="contenedorGenerador">
                                        <div class="col-md-1" style="width:50px">
                                            <label>Desde: </label>
                                        </div>

                                        <div class="col-md-1">
                                            <input readonly type="text" value="7:00 AM"
                                                class="form-control inputTime" />
                                        </div>
                                        <div class="col-md-1" style="width:50px">
                                            <label>Hasta: </label>
                                        </div>
                                        <div class="col-md-1">
                                            <input readonly type="text" value="11:00 AM"
                                                class="form-control inputTime" />
                                        </div>

                                        <div class="col-md-1">
                                            <label>Cada: </label>
                                        </div>
                                        <div class="col-md-1">
                                            <select class="form-control">
                                                <option value="1">1 hora</option>
                                                <option value="2">2 horas</option>
                                                <option value="3">3 horas</option>
                                                <option value="4">4 horas</option>
                                                <option value="5">5 horas</option>
                                                <option value="6">6 horas</option>
                                                <option value="7">7 horas</option>
                                                <option value="8">8 horas</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Duraci&oacute;n de la actividad: </label>
                                        </div>

                                        <div class="col-md-1">
                                            <input type="number" class="form-control" />
                                        </div>
                                        <div class="col-md-1">
                                            <select class="form-control">
                                                <option value="0">Minutos</option>
                                                <option value="1">Horas</option>
                                                <option value="2">Dias</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label title="Hora Boliviana">HB: <input type="checkbox" /></label>
                                            <button type="button" id="btn_listo" class="btn btn-info"><i
                                                    class="fa fa-check" aria-hidden="true"></i></button>
                                            <button onclick="$('#generarSalidas').trigger('click')" type="button"
                                                id="btn_listo" class="btn btn-danger"><i class="fa fa-times"
                                                    aria-hidden="true"></i></button>
                                        </div><br><br>

                                    </div>

                                </div>
                            </div>
                        </div>



                    </fieldset>
                    <fieldset>
                        <div class="panel panel-primary navform">
                            <div class="panel-body">
                                <input type="button" name="previous" class="previousStep btn btn-danger"
                                    value="Volver" />
                                <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente" />
                            </div>
                        </div>
                        <div class="headline">
                            <div>Paso 2: Contenido de la actividad</div>
                        </div>
                        <div class="text-left tab-v1 form-group container-fluid" style="padding: 0px;">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#div_descripcion" data-toggle="tab" aria-expanded="false"
                                        data-div="div_descripcion">
                                        <span class="fa fa-building"></span>
                                        <strong>DESCRIPCIÓN</strong>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#div_itinerario" data-toggle="tab" aria-expanded="false"
                                        data-div="div_itinerario">
                                        <span class="fa fa-tasks"></span>
                                        <strong>ITINERARIO</strong>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#div_incluye" data-toggle="tab" aria-expanded="true"
                                        data-div="div_incluye">
                                        <span class="fa fa-plus-circle"></span>
                                        <strong>INCLUYE</strong>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#div_mapa" data-toggle="tab" aria-expanded="false" data-div="div_mapa">
                                        <span class="fa fa-map-marker"></span>
                                        <strong>MAPA</strong>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#div_informacion_importante" data-toggle="tab" aria-expanded="false"
                                        data-div="div_informacion_importante">
                                        <span class="fa fa-info-circle"></span>
                                        <strong>INFORMACION</strong>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#div_recomendacion" data-toggle="tab" aria-expanded="false"
                                        data-div="div_recomendacion">
                                        <span class="fa fa-info-circle"></span>
                                        <strong>RECOMENDACIÓN</strong>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#div_add_tabs" data-toggle="tab" aria-expanded="false"
                                        data-div="div_add_tabs">
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
                                                <div>Descripcion </div>
                                            </div>
                                            <textarea class="form-control" name="descripcion_prod"
                                                placeholder="descripcion del tour"
                                                id="txt_descripcion"><?= @$producto['descripcion_tab']; ?></textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="div_itinerario">
                                    <div class="typography">
                                        <div class="col-md-12">
                                            <div class="headline">
                                                <div>Itinerario</div>
                                            </div>
                                            <textarea class="form-control" name="itinerario_prod"
                                                placeholder="Itinerario"
                                                id="txt_itinerario"><?= @$producto['itinerario_ta']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="div_incluye">
                                    <div class="typography">
                                        <div class="col-md-12">
                                            <div class="headline">
                                                <div>Incluye</div>
                                            </div>
                                            <textarea class="form-control" name="incluye_prod"
                                                placeholder="Type the things that includes"
                                                id="txt_incluye"><?= @$producto['incluye_tab']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="div_mapa">
                                    <div class="typography">
                                        <div class="col-md-12">
                                            <div class="headline">
                                                <div>Mapa</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="text-justify">
                                                        <p>Seleccione la ruta del servicio, ponga los destinos a conocer
                                                        </p>
                                                        <p><strong>Ejemplo: </strong> Un vistante turistico una vez
                                                            llegado a Puno tiene programado visitar a la Isla de Los
                                                            Uros y en seguida visitar la Isla amantaní y finalmente a la
                                                            Isla de Taquile.</p>
                                                        <p>Para el ejemplo anterior se recomienda ingresar primero La
                                                            Isla de los Uros, después la Isla de Amantaní y al último a
                                                            la Isla de taquile; El orden del regisgtro de lugares
                                                            turísticos se debe realizar de acuerdo al orden de visitas.
                                                        </p>
                                                    </div>
                                                    <div class="mapa" id="mapa"></div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <!--form id="form_add_lugares" style="background:blue"-->
                                                    <div class="form-group">
                                                        <label for="inputLugar">Nombre del Lugar</label>
                                                        <input type="text" id="txt_nombre_lugar" class="form-control"
                                                            placeholder="Buscar Lugar">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputDescripcion">Descripción del Lugar</label>
                                                        <textarea id="txtr_descripcion_lugar" class="form-control"
                                                            placeholder="Descripción del Lugar"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputCoordenadas">Coordenadas</label>
                                                        <input type="text" readonly id="txt_coordenadas_lugar"
                                                            class="form-control" placeholder="Coordenadas">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputTipoLugar">Tipo Lugar</label>
                                                        <select id="slct_tipo_lugar" class="form-control">
                                                            <option value="">Seleccione...</option>
                                                            <option value="1">Punto de Parada</option>
                                                            <option value="2">Restaurant</option>
                                                            <option value="3">Lugar Turistico</option>
                                                            <option value="4">Aeropuerto</option>
                                                            <option value="5">Estación de Tren</option>
                                                            <option value="6">Terminal Terrestre (Bus)</option>
                                                            <option value="7">Museo</option>
                                                            <option value="8">Punto de Reunión</option>
                                                            <option value="9">Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <!--
                                                          <label for="inputNumerodeOrden"> Número de Orden</label>
                                                          <input type="number" id="txt_numero_orden_lugar" min="0" class="form-control" placeholder="# de Orden">
                                                          -->
                                                        <p class="">Por favor registre las rutas desde el inicio hasta
                                                            el final con estricto orden según a lo que se realizará el
                                                            tour.</p>
                                                    </div>
                                                    <button type="button" class="btn btn-success btn-add-point">
                                                        Add...
                                                    </button>
                                                    <button type="button" class="btn btn-info" id="btn_listar_lugares">
                                                        <span class="span_cantidad_lugares"
                                                            id="span_cantidad_lugares">0</span> Lugar(es)
                                                    </button>
                                                    <!--/form-->
                                                </div>
                                            </div>
                                            <textarea class="form-control" readonly name="map_prod" id="map_prod"
                                                placeholder="mapa del tour"><?= @$producto['mapa_tab']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="div_informacion_importante">
                                    <div class="typography">
                                        <div class="col-md-12">
                                            <div class="headline">
                                                <div>Informacion adicional</div>
                                            </div>
                                            <textarea class="form-control" name="info_prod"
                                                placeholder="informacion del tour"
                                                id="txt_informacion_adicional"><?= @$producto['informacion_tab']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="div_recomendacion">
                                    <div class="typography">
                                        <div class="col-md-12">
                                            <div class="headline">
                                                <div>Recomendación</div>
                                            </div>
                                            <textarea class="form-control" name="recomendaciones_prod"
                                                placeholder="recomendaciones"
                                                id="txt_recomendaiciones"><?= @$producto['recomendacion_tab']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="div_add_tabs">


                                    <div class=" col-md-12 form-group row">
                                        <div id="added_tabs">
                                            <?php

                                            if (!empty($producto['tab_adicional'])) {
                                              $html_tab = null;
                                              $html_IDtab = null;
                                              foreach ($producto['tab_adicional'] as $key => $value) {
                                                $html_tab .= addTab($value['nombre_tab'], $value['icono_tab_adicional'], $value['contenido_tab'], $key);
                                                $html_IDtab .= "CKEDITOR.replace( 'htmlcontent" . ($key) . "' ); ";
                                              }

                                              echo $html_tab . '<script>' . $html_IDtab . '</script>';
                                            }


                                            ?>
                                        </div>
                                        <div class="alert alert-info">
                                            <strong>Importante!</strong> Pulse Agregar Tab para crear nuevos tabs.
                                        </div>
                                        <button id="addTabButton" class="btn btn-primary"><span
                                                class="fa fa-plus"></span> Agregar Tab</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <fieldset>
                        <div class="panel panel-primary navform">
                            <div class="panel-body">
                                <input type="button" name="previous" class="previousStep btn btn-danger"
                                    value="Volver" />
                                <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente" />
                            </div>
                        </div>
                        <div class="headline">
                            <div>Paso 3: Galeria de Imagenes y Archivos Adjuntos</div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary panel-slider">
                                <div class="panel-heading">

                                    <span class="fa fa-file-image-o"></span>
                                    <b>GALERIA DEL SLIDER</b><span style="float:right;margin-top:-7px"
                                        class="btn btn-success btn-sm addGaleriaSlider"><span
                                            class="fa fa-plus-circle"></span></span>

                                </div>
                                <div class="panel-body galeriaDIV" title="Mini Slider">
                                    <?php
                                    if (isset($producto)) {
                                      if (count($producto['galeria'])) {
                                        $html_galeria = null; //esta variable se usa rtambien abajo para detectar si hay imagenes agregadas
                                        foreach ($producto['galeria'] as $value) {
                                          $html_galeria .= addFormGaleria($value['id_galeria'], $value['url_archivo'], 2);
                                        }
                                        echo $html_galeria;
                                      } else
                                        echo 'Este producto no tiene imagenes en su galeria (+) para agregar Fotos.';
                                    } else
                                      echo 'Click en el Boton (+) para agregar Fotos.';

                                    ?>
                                </div>
                                <div><button class="center-block btn btn-primary addGaleriaSlider"><span
                                            class="fa fa-plus-circle"></span> Agregar Campo de Slider</button><br></div>
                                <div class="alert bg-primary" style="margin: 0;">
                                    <div>
                                        <p><b> NOTA!</b></p>

                                        La <b>
                                            primera imagen</b> de la lista correspondera a la <b>imagen descata</b> de
                                        la actividad
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">

                                    <span class="fa fa-file-image-o"></span>
                                    <b>ARCHIVOS ADJUNTOS</b><span style="float:right;margin-top:-7px"
                                        class="btn btn-success btn-sm addGaleriaAdjunto"><span
                                            class="fa fa-plus-circle"></span></span>

                                </div>
                                <div class="panel-body galeriaDIV" title="Archivos Adjuntos">
                                    <?php
                                    if (!empty($producto['adjuntos_producto'])) {
                                      //var_dump($producto['adjuntos_producto']);
                                      if (count($producto['adjuntos_producto'])) {
                                        $html_galeria = null; //esta variable se usa rtambien abajo para detectar si hay imagenes agregadas
                                        //echo $producto['adjuntos_producto'][1][0]['url_imagen'];
                                        // var_dump($producto['adjuntos_producto']);
                                        foreach ($producto['adjuntos_producto'] as $value) {
                                          $html_galeria .= addFormGaleria($value['id_galeria'], $value['url_archivo'], 0);
                                        }
                                        echo $html_galeria;
                                      } else
                                        echo 'Este producto no tiene archivos adjuntos en su galeria pulse (+) para agregarlos.';
                                    } else
                                      echo 'Click en el Boton (+) para agregar Adjuntos.';



                                    ?>
                                </div>
                                <div><button class="center-block btn btn-primary addGaleriaAdjunto"><span
                                            class="fa fa-plus-circle"></span> Agregar Campo de Adjunto</button><br>
                                </div>
                            </div>
                            <!--div>
                      <button onclick="openGaleria($(this),0); return false;">Abrir Documentos</button>
                      <input required tyope="text" class="inputImagenModal" readonly />
                      <input type="hidden" class="inputHideImagenModal"  readonly name="adjuntos[]" />
                   </div-->
                        </div>

                    </fieldset>
                    <fieldset>
                        <div class="panel panel-primary navform">
                            <div class="panel-body">
                                <input type="button" name="previous" class="previousStep btn btn-danger"
                                    value="Volver" />
                                <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente"
                                    data-siguiente="calendario" />
                            </div>
                        </div>

                        <div class="headline">
                            <div>Paso 4: Precios generales
                            </div>
                            <table style="display: inline;" class="pull-right">
                                <tr>
                                    <td style="font-size: 14px;font-weight: bold;background: #ffffbd;"> Tasas e
                                        impuestos a aplicar &nbsp; &nbsp; </td>
                                    <td> <input type="text" name="tasas_impuestos"
                                            value="<?= @$producto['tasas_impuestos'] ? $producto['tasas_impuestos'] : 5 ?>"
                                            style="width:40px;text-align: center;font-weight: bold;" /> %</td>
                                    <td style="font-size: 14px;font-weight: bold;background: #d2ffe9;"> Porcentaje de
                                        primera cuota &nbsp; &nbsp; </td>
                                    <td> <input type="number" required name="porcentaje_adelanto"
                                            value="<?= @$producto['porcentaje_adelanto'] ? $producto['porcentaje_adelanto'] : 20 ?>"
                                            style="width:40px;text-align: center;font-weight: bold;" /> %</td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group text-left">
                            <div class="col-md-12">

                                <div class="form-group row">

                                    <div class="col-md-12">

                                        <div id="preciosManager" data-json='<?= @$producto['precios_full']; ?>'
                                            class="col-md-12">
                                            <ul class="nav nav-tabs">
                                                <li><a class="addTabBtn fa fa-plus" title="Agregar nuevo Segmento"></a>
                                                </li>
                                            </ul>
                                            <div class="tab-content"></div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>



                    </fieldset>
                    <fieldset>
                        <div class="panel panel-primary navform">
                            <div class="panel-body">
                                <input type="button" name="previous" class=" previousStep btn btn-danger"
                                    value="Volver" />
                                <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente"
                                    data-siguiente="datos-reserva" />
                            </div>
                        </div>
                        <?php
                        $data_view = array(
                          'requerir_disponibilidad' => $requerir_disponibilidad
                        );
                        $this->load->view("admin/disponibilidad/index", $data_view);
                        ?>
                        <br>


                    </fieldset>

                    <fieldset>
                        <div class="panel panel-primary navform">
                            <div class="panel-body">
                                <input type="button" name="previous" class="previousStep btn btn-danger"
                                    value="Volver" />
                                <input type="button" name="next" class=" nextStep btn btn-primary" value="Siguiente"
                                    data-siguiente="calendario" />
                            </div>
                        </div>
                        <div class="headline">
                            <div>Paso 6: Opciones para reservar</div>
                        </div>


                        <div class="form-group text-left" id="checkers">

                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading" data-toggle="collapse" href="#collapse-politicas">
                                        <h4 class="panel-title"><strong>
                                                <span class="badge" title="Paso 1"><big>1</big></span>
                                                POLÍTICAS y CANCELACIONES PARA LA ACTIVIDAD A RESERVAR</strong>
                                        </h4>
                                    </div>
                                    <div id="collapse-politicas" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label">SELECCIONE TIPO DE POLÍTICA: </label>
                                                <div class="radio">
                                                    <label><input type="radio" name="tipopolitica" class="tipopolitica"
                                                            id="tipopoliticaA" value="0"
                                                            <?= $checkedPolitica == 0 ? 'checked' : ''; ?>> Política
                                                        Stantard (Políticas pre-establecidas por Inca Lake)</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="tipopolitica" class="tipopolitica"
                                                            id="tipopoliticaB" value="1"
                                                            <?= $checkedPolitica == 1 ? 'checked' : ''; ?>> Política
                                                        Personalizada (Política personalizada para cada
                                                        actividad)</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label">DESCRIPCIÓN DE LAS POLÍTICAS PARA LA
                                                    ACTIVIDAD: </label>
                                                <!--
                                        <textarea class="form-control txt_politicas" id="txt_politicas_producto" name="politicas" rows="7"><?= @$producto['politicas_producto']; ?></textarea>
-->
                                                <textarea class="form-control txt_politicas" id="txt_politicas"
                                                    name="politicas" rows="7"><?= @$texto_politicas; ?></textarea>
                                            </div>
                                            <div style="padding-top:10px" class="col-md-12 form-horizontal">
                                                <?php
                                                $tipo_tiempo = array('Minutos', 'Horas', 'Dias');

                                                $tiempo_anticipacion[1] = NULL; //tipo de medida de tiempo
                                                $tiempo_anticipacion = @$producto['anticipacion_reserva_producto'];

                                                if (!empty($tiempo_anticipacion))
                                                  $tiempo_anticipacion = explode(':', $tiempo_anticipacion);

                                                $options_tiempo = NULL;
                                                foreach ($tipo_tiempo as $key => $value) {
                                                  $options_tiempo .= '<option ' . (@(int) $tiempo_anticipacion[1] === $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
                                                }
                                                //////////////// requerir datos /////////////////////////
                                                $requerir_datos = array('Antes de la compra', 'Despues de la compra', 'No requerir');

                                                $options_requerir = NULL;
                                                $requerimiento_datos = @$producto['requerimiento_datos'];
                                                foreach ($requerir_datos as $key => $value) {
                                                  $options_requerir .= '<option ' . ($requerimiento_datos == ($key + 1) ? 'selected' : '') . ' value="' . ($key + 1) . '">' . $value . '</option>';
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-success">
                                            <div class="panel-heading"><strong><span class="badge"
                                                        title="Paso 2"><big>2</big></span> INDIQUE TIEMPO DE
                                                    ANTICIPACIÓN PARA LA RESERVA</strong></div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="control-label">Tiempo de anticipación: </label>
                                                    <input value="<?= @$tiempo_anticipacion[0]; ?>"
                                                        onchange="if(this.value.length)$('#tip_antc').attr('required','required');else $('#tip_antc').removeAttr('required')"
                                                        type="number" name="anticipacion_reserva"
                                                        class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Seleccione tiempo en:</label>
                                                    <select name="anticipacion_reserva_tipo" class="form-control"
                                                        <?= @$producto['anticipacion_reserva_producto'] ? 'required' : ''; ?>
                                                        id="tip_antc">
                                                        <option value="">-- Seleccione --</option>
                                                        <?= $options_tiempo; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="panel-footer"></div> -->
                                        </div>


                                    </div>


                                </div>
                            </div>
                            <div class="col-md-12">
                                <div>
                                    <div>
                                        <div>

                                            <?php
                                            $theme_panel = [

                                              0 => "panel-success",
                                              1 => "panel-info",
                                              2 => "panel-warning",
                                              3 => "panel-danger",
                                              4 => "panel-primary",
                                              5 => "panel-default",
                                              6 => "panel-success",
                                              7 => "panel-info",
                                              8 => "panel-warning",
                                              9 => "panel-danger",
                                            ];

                                            $title = "";
                                            $i = 0;
                                            foreach ($formularios as $index => $form):
                                              ?>
                                            <?php
                                              $input = json_decode($form['nombre_campo']);
                                              $categoria = json_decode($form['nombre_campo_categoria']);
                                              ?>

                                            <?php if (strtolower($categoria->{'es'}) != $title): ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-4" style="padding:0;">

                                    <div class="panel <?= $theme_panel[$i++] ?>">
                                        <div class="panel-heading" style="text-transform: uppercase;">
                                            <strong><?= $categoria->{'es'} ?></strong>
                                            <?php $title = strtolower($categoria->{'es'}) ?>
                                        </div>
                                        <div class="panel-body">
                                            <?php endif; ?>
                                            <?php if ($index == 0): ?>
                                            <label style="cursor:pointer;">
                                                <input type="radio" name="forms_multiple" value="0"
                                                    <?= @$producto['forms_multiple'] ? '' : 'checked'; ?>>
                                                Requerir datos solo del lider
                                            </label> <br>
                                            <label style="cursor: pointer;">
                                                <input type="radio" name="forms_multiple" value="1"
                                                    <?= @$producto['forms_multiple'] ? 'checked' : ''; ?>>
                                                Requerir todos los datos de los clientes.
                                            </label><br>
                                            <label>
                                                <!--    <input <?= @$producto['forms_multiple'] ? ' checked' : ''; ?> name="forms_multiple" value="1" type="checkbox"> -->

                                                <!--    <strong>Requerir datos solo del Lider</strong></label>
                                       <p>Al seleccionar la casilla estas confirmando que para la actividad solo es necesario los datos del líder y no se requiere los datos de los demás clientes.</p> -->
                                                <hr>
                                                <?php endif; ?>
                                                <label style="font-weight: normal;display: block;">
                                                    <input type="checkbox" name="inputs[]"
                                                        value="<?= $form['input_id'] ?>"
                                                        <?php if ($form['checked'] == "true"): ?> checked
                                                        <?php endif; ?> />
                                                    <?= $input->{'es'} ?>
                                                </label>
                                                <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </fieldset>
                    <fieldset>
                        <div class="panel panel-primary navform">
                            <div class="panel-body">
                                <input type="button" name="previous" class="previousStep btn btn-danger"
                                    value="Volver" />
                                <input type="submit" id="btnGuardar" name="formButton" style="float:right"
                                    class="btn btn-success" value="<?= $formButton; ?>" />
                            </div>
                        </div>
                        <div class="headline">
                            <div>Paso 6: Opciones para reservar</div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-danger">
                                <div class="panel-heading"><strong><span class="badge"
                                            title="Paso 4"><big>1</big></span> INDIQUE OPCIONES DE RECOJO AL
                                        CLIENTE:</strong></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">Indique tipo de recojo: </label>
                                        <div class="radio">
                                            <label><input type="radio" name="tiporecojo" class="tiporecojo" value="0"
                                                    <?= $checkedRecojo == 0 ? 'checked' : ''; ?>> Punto de
                                                presentación</label>
                                        </div>
                                        <div class="container" id="container-punto-de-presentacion"
                                            style="display: <?= $checkedRecojo == 0 ? 'block' : 'none' ?>;">
                                            <div class="radio">
                                                <label><input type="radio" name="tiporecojoA" class="tiporecojoA"
                                                        value="0"> Los clientes deben presentarse en Plaza de armas de
                                                    la ciudad</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="tiporecojoA" class="tiporecojoA"
                                                        value="1"> Indicar donde debe presentarse el cliente</label>
                                            </div>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="tiporecojo" class="tiporecojo" value="1"
                                                    <?= $checkedRecojo == 1 ? 'checked' : ''; ?>> Recojo de
                                                hotel</label>
                                        </div>
                                        <div class="container" id="container-recojo-de-hotel"
                                            style="display: <?= $checkedRecojo == 1 ? 'block' : 'none' ?>;">
                                            <div class="radio">
                                                <label><input type="radio" name="tiporecojoB" class="tiporecojoB"
                                                        value="0"> Plaza de armas</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="tiporecojoB" class="tiporecojoB"
                                                        value="1"> Otros</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" id="lbl_lugar_encuentro">Indique hoteles aplicables
                                            para el recojo:</label>
                                        <textarea class="form-control" row="1" name="txt_lugar_encuentro"
                                            id="txt_lugar_encuentro"><?= @$producto['lugar_recojo']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Indique donde terminará la actividad
                                            (opcional):</label>
                                        <textarea class="form-control" rows="1" name="txt_lugar_finalizacion"
                                            id="txt_lugar_finalizacion"
                                            placeholder="Describa donde se les dejará a los clientes después de finalizar la excursión"><?= @$producto['lugar_finalizacion_actividad']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading"><strong><span class="badge"
                                            title="Paso 3"><big>2</big></span> AFORO y REQUERIMIENTO DE DATOS PARA LA
                                        RESERVA</strong></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">Aforo (cantidad máxima para reservar): </label>
                                        <input value="<?= @$producto['capacidad'] ? @$producto['capacidad'] : '30'; ?>"
                                            min="1" type="number" name="aforo" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Para reservar requerir datos: </label>
                                        <select name="requerimiento_datos" class="form-control"
                                            id="slct_requerimiento_datos">
                                            <?= $options_requerir; ?>
                                        </select>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="checkbox">

                                            <!--  <input <?= @$producto['forms_multiple'] ? ' checked' : null; ?> name="forms_multiple" value="1" type="checkbox">
                                            <strong>Requerir datos solo del Lider</strong><p class="help-block">Al seleccionar la casilla estas confirmando que para la actividad solo es necesario los datos del líder y no se requiere los datos de los demás clientes.</p>
                                          </label> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $arrayGuiasList = [];
                            $checkboxSelected = 0;
                            if (count($arrayGuias) != 0) {
                              $checkboxSelected = !empty($arrayGuias[0]['tipo_guia']) ? $arrayGuias[0]['tipo_guia'] : 0;
                              foreach ($arrayGuias as $key => $value) {
                                $selected = false;
                                if (!empty($value['p_id_producto'])) {
                                  $selected = true;
                                }
                                $arrayGuiasList[] = array(
                                  'id_producto' => @$producto['id_producto'],
                                  'id_codigo_producto' => @$producto['id_codigo_producto'],
                                  'id_guia' => $value['g_id_guia'],
                                  'id_codigo_guia' => $value['g_id_codigo_guia'],
                                  'id_idioma' => $value['g_id_idioma'],
                                  'selected' => $selected,
                                  'descripcion' => ucfirst(strtolower(trim($value['servicio_guia']))),
                                );
                              }
                            }
                            ?>
                            <div class="panel panel-success">
                                <div class="panel-heading"><strong><span class="badge"
                                            title="Paso 3"><big>3</big></span> ASOCIAR GUIAS A LA ACTIVIDAD/SERVICIO
                                        (OPCIONAL)</strong></div>
                                <div class="panel-body">
                                    <?php
                                    //echo json_encode($arrayGuiasList); 
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label">Indicar tipo de guia: </label>
                                        <div class="radio">
                                            <label><input type="radio" name="tipoguia" class="tipoguia" value="0"
                                                    <?= (integer) $checkboxSelected == 0 ? 'checked' : ''; ?>> Guía de
                                                tour en vivo</label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="tipoguia" class="tipoguia" value="1"
                                                    <?= (integer) $checkboxSelected == 1 ? 'checked' : ''; ?>> Audio
                                                Guía y Audífonos</label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="tipoguia" class="tipoguia" value="2"
                                                    <?= (integer) $checkboxSelected == 2 ? 'checked' : ''; ?>> Folletos
                                                informativos</label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="tipoguia" class="tipoguia" value="3"
                                                    <?= (integer) $checkboxSelected == 3 ? 'checked' : ''; ?>> Sin Guía
                                                / No es necesario seleccionar el lenguage (Ejemplo: Tickets de entrada,
                                                pasajes)</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="tipoguia" class="tipoguia" value="4"
                                                    <?= (integer) $checkboxSelected == 4 ? 'checked' : ''; ?> />
                                                No mostrar nada.
                                            </label>
                                        </div>
                                    </div>
                                    <div id="selected-tipoguias"
                                        style="display:<?= $checkboxSelected == 3 || $checkboxSelected == 4 ? 'none' : 'block'; ?>">
                                        <strong>
                                            <p id="txt-seleccionar-tipoguia">Seleccione idiomas del guía de tour en vivo
                                            </p>
                                        </strong>
                                        <select multiple name="slct_guias_seleccionados[]"
                                            id="slct_guias_seleccionados">
                                            <?php foreach ($arrayGuiasList as $key => $value): ?>
                                            <?php
                                              $text = $value['id_idioma'] . "*" . $value['id_producto'] . "*" . $value['id_codigo_producto'] . "*" . $value['id_guia'] . "*" . $value['id_codigo_guia'];
                                              ?>
                                            <option value="<?= $text; ?>" <?= $value['selected'] ? 'selected' : ''; ?>>
                                                <?= $value['descripcion']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <br /><br />
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </div>


                <!--h2>Tiempo</h2>
        <label for="hora_inicio">Hora de Inicio: </label> <input id="hora_inicio" name="hora_inicio" type="time" value="" /><br>
        <label for="duracion_tour">Duracion: </label> <input id="duracion_tour" name="duracion_tour" type="time" value="" /><br>
        <div style="background:#F2FFF9">
        <h2>Precio:</h2>
        <div><button>Precio General</button><button>Precio Personalizado</button></div-->


            </form>
        </div>
    </content>

    <div id="modal-points-list" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><strong><span class="fa fa-list"></span> Listar Lugares</strong>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="row">
                            <div class="modal-list-points">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
    #cerraragregartab {
        position: absolute;
        top: 0px;
        left: 0px;
        color: red;
    }
    </style>
    <!-- -------------------------------- ESTILOS PARAN EL MAPA ------------------------------ -->
    <style type="text/css">
    #mapa {
        width: 100%;
        height: 30em;
    }

    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    /*un poco de estilo a los inputs de la galeria*/
    div.galeriaDivs {
        margin-bottom: 3px;
        padding: 0;
        display: flex;
    }

    div.galeriaDivs input {
        padding: 5px;
        border: 1px solid #CCC;
        border-right: none;
        border-left: none;
        width: 250px;
    }

    div.galeriaDivs button {
        padding: 5px !important;
        height: 32px;
        border: 1px solid #CCC;
        background: #DDD;
    }

    div.galeriaDivs button:hover {
        background: #CCC;
    }

    /*generador de inicios*/
    #contenedorGenerador {
        display: none;
        margin-top: 5px;
        border-top: 1px solid #ddd;
        padding-top: 5px;
    }

    #contenedorGenerador>div {
        padding: 0;
    }
    </style>
</body>
<script type="text/javascript">
var markers = [];
var bounds = null;

var map = null,
    markerBounds = null;
var points = {
    lugares: []
};
var markerPosition = null;
var newDataMarker = null;

function initAutocomplete() {
    bounds = new google.maps.LatLngBounds();
    //var haightAshbury = {lat: -15.8422, lng: -70.0199};
    /***************************************************************************************************/
    autocomplete = new google.maps.places.Autocomplete((document.getElementById('ciudad_cercana')), {
        types: ['establishment', 'geocode']
    });
    autocomplete2 = new google.maps.places.Autocomplete((document.getElementById('aeropuerto_cercano')), {
        types: ["establishment", "geocode"]
    });
    /***************************************************************************************************/
    map = new google.maps.Map(document.getElementById('mapa'), {
        center: {
            lat: -15.8422,
            lng: -70.0199
        },
        zoom: 13
    });
    /************************************** END AUTOCOMPLETADOR ****************************************/

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var div_name = $(this).data("div");
        //console.log("TAB: #"+div_name);
        switch (div_name) {
            case 'div_mapa':
                initAutocomplete();
                addMarker(points.lugares);
                break;
            default:

                break;
        }
    });

    markerBounds = new google.maps.LatLngBounds();
    autocomplete2 = new google.maps.places.Autocomplete((document.getElementById('txt_nombre_lugar')), {
        types: ["establishment", "geocode"]
    });
    autocomplete2.addListener('place_changed', setInformation);
    markerPosition = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: null,
        icon: 'http://www.googlemapsmarkers.com/v1/009900/'
    });
    map.addListener('click', function(event) {
        var latlngClick = JSON.parse(JSON.stringify(event.latLng));
        markerPosition.setPosition(event.latLng);
        setPositionMarker(event.latLng);
    });
    google.maps.event.addListener(markerPosition, "dragend", function(event) {
        setPositionMarker(event.latLng);
    });
}

function setInformation() {
    var place = autocomplete2.getPlace();
    var latlng = JSON.parse(JSON.stringify(place.geometry.location));

    document.getElementById("txtr_descripcion_lugar").value = place.formatted_address;
    document.getElementById("txt_coordenadas_lugar").value = latlng.lat + "," + latlng.lng;
    markerPosition.setPosition(place.geometry.location);
}

function addMarker(dataJsonMarkers) {
    if (dataJsonMarkers.length != 0) {
        for (var i in dataJsonMarkers) {
            var arrayCoordenadas = (dataJsonMarkers[i]['coordenadas']).split(',');
            new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(arrayCoordenadas[0]), parseFloat(arrayCoordenadas[
                    1])),
                map: map,
                label: "" + (parseInt(i) + 1),
                title: "" + dataJsonMarkers[i]['nombre'],
            });
            markerBounds.extend(new google.maps.LatLng(parseFloat(arrayCoordenadas[0]), parseFloat(arrayCoordenadas[
                1])));
        }
        map.fitBounds(markerBounds);
        document.getElementById("map_prod").value = JSON.stringify(points);
    } else {
        map.setCenter({
            lat: -15.8422,
            lng: -70.0199
        });
    }
}

$(document).on('click', '.btn-add-point', function(event) {
    event.preventDefault();
    var txt_nombre_lugar = $("#txt_nombre_lugar").val();
    var txt_descripcion_lugar = $("#txtr_descripcion_lugar").val();
    var txt_coordenadas = $("#txt_coordenadas_lugar").val();
    var txt_tipo_lugar = $("#slct_tipo_lugar").val();
    //var txt_orden_lugar       = $("#txt_numero_orden_lugar").val();
    if (txt_nombre_lugar.length === 0) {
        swal("Error..!", "Complete el campo Nombre del Lugar", "warning");
        $("#txt_nombre_lugar").focus();
    } else if (txt_coordenadas.length === 0) {
        swal("Error..!", "Busque el lugar o escriba para seleccionar un lugar y obtener sus coordenadas.",
            "warning");
        $("#txt_nombre_lugar").focus();
    } else if (txt_tipo_lugar.length === 0) {
        swal("Error..!", "Seleccione el tipo de Lugar", "warning");
    } else {
        var marker = {
            id: null,
            nombre: txt_nombre_lugar,
            descripcion: txt_descripcion_lugar,
            coordenadas: txt_coordenadas,
            tipo: txt_tipo_lugar,
            orden: (points.lugares.length + 1)
        };
        points.lugares.push(marker);
        addMarker(points.lugares);

        $('.span_cantidad_lugares').empty().append(points.lugares.length);
        //$('#map_prod').empty().val(JSON.stringify(points));

        $("#txt_nombre_lugar").val('');
        $("#txtr_descripcion_lugar").val('');
        $("#txt_coordenadas_lugar").val('');
        $("#slct_tipo_lugar").val('');
        //$("#txt_numero_orden_lugar").val(parseInt(txt_orden_lugar) + 1);
    }
});

$(document).on('click', '#btn_listar_lugares', function(event) {
    event.preventDefault();
    listarLugares();

    $('#modal-points-list').modal('show');
});

$(document).on('click', '.btn-eliminar-points', function(event) {
    event.preventDefault();
    //console.log($(this).data('id'));
    points.lugares.splice(parseInt($(this).data('id')), 1);
    listarLugares();

    $('#map_prod').empty().val(JSON.stringify(points));
    $('.span_cantidad_lugares').empty().append(points.lugares.length);
    $('#modal-reviews-list').modal('show');
});

function listarLugares() {
    var points_html = '';
    if (points.lugares.length === 0) {
        $('.modal-list-points').empty().append('No hay Lugares..!');
    } else {
        points_html += '<ul class="list-group">';
        $.each(points.lugares, function(index, val) {
            points_html += '<li class="list-group-item"><strong>' + val.orden + '.</strong> ' + val.nombre +
                ' <span class="fa fa-close btn-eliminar-points pull-right" data-id="' + index +
                '"></span></li>';
        });
        points_html += '</ul>';
        $('.modal-list-points').empty().append(points_html);
    }
}

$(document).on('click', '.nextStep', function(event) {
    event.preventDefault();
    var valor = $(this).data("siguiente");
    if (valor === "calendario") {
        $("#calendario_incalake").fullCalendar('render');
    }
});

/*controlar cantidad inputs de la galeria*/
var contenedorGaleria = $('.galeriaDIV');

$('.addGaleriaSlider').click(function(event) {
    var html = '<?= addFormGaleria(null, null, 2); ?>';
    event.stopPropagation();
    if (contenedorGaleria.eq(0).find('.galeriaDivs').length) contenedorGaleria.eq(0).append(html);
    else contenedorGaleria.eq(0).html(html);
    return false;
});
$('.addGaleriaAdjunto').click(function(event) {
    var html = '<?= addFormGaleria(null, null, 0); ?>';
    event.stopPropagation();
    if (contenedorGaleria.eq(1).find('.galeriaDivs').length) contenedorGaleria.eq(1).append(html);
    else contenedorGaleria.eq(1).html(html);
    return false;
});
/*fin de la funcion para controlar galeria*/
/*controlar perdida de datos al apagar o cerrar navegador*/
$(function() {
    $("#formPrincipal").sisyphus({
        locationBased: true,
        onRestore: function() {
            bootbox.confirm({
                message: "Se ha encontrado datos aun sin almacenar en este formulario. ¿desea restablecerlos?",
                buttons: {
                    confirm: {
                        label: 'Si'
                    },
                    cancel: {
                        label: 'No'
                    }
                },
                callback: function(result) {
                    if (!result) {
                        localStorage.clear();
                        location.reload();
                    }
                }
            });
        }
    })
});
/*fin evitar pedidad de datos*/
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    if (parseInt(data_editar) === 1 && editar_data_disponibilidad.length != 0) {
        //console.log(editar_data_disponibilidad[0]['dias_no_activos'] );
        array_dias_no_activos.length = 0;
        array_dias_no_activos = editar_data_disponibilidad[0]['dias_no_activos'];
        editar_array_dias_especiales = editar_data_disponibilidad[0]['dias_especiales'];
        editar_array_meses_inactivos = editar_data_disponibilidad[0]['meses_inactivos'];
        $.each(editar_data_disponibilidad, function(index, val) {
            js_disponibilidad.set_datos_disponibilidad(val);
            $("#txt_fecha_inicio_disponibilidad").empty().val(moment(val['start']).format(
                "DD-MM-YYYY"));
            $("#txt_fecha_fin_disponibilidad").empty().val(moment(val['end']).format("DD-MM-YYYY"));
            actualizar_disponibilidad(moment(val['start']).format("YYYY-MM-DD"), moment(val['end'])
                .format("YYYY-MM-DD"));
        });
        $("#txt_data_json_disponibilidad").empty().val(JSON.stringify(js_disponibilidad
            .get_datos_disponibilidad()));

        console.log("DATA BLOQUEOS", JSON.stringify(editar_data_bloqueo));
        $.each(editar_data_bloqueo, function(index, val) {
            js_bloqueo.set_datos_bloqueo(val);
        });
        $.each(editar_data_oferta, function(index, val) {
            js_oferta.set_datos_oferta(val);
        });

        for (var i in array_dias_no_activos) {
            $("#chckbx_dia_" + array_dias_no_activos[i]).prop("checked", false);
        }
        for (var i in editar_array_dias_especiales) {
            $("#dias_especiales_" + editar_array_dias_especiales[i]).prop("checked", true);
            //Actualiza los dias_especiales seleccionados
            array_dias_especiales.push(editar_array_dias_especiales[i]);
        }

        actualizar_eventos();
    }

    $(document).on('change', '.tiporecojo', function(event) {
        event.preventDefault();
        var value = $(this).val();
        var message = "";
        var contentValue = "";
        switch (parseInt(value)) {
            case 0:
                message = "Indicar el Lugar de Presentación para Iniciar la actividad:";
                contentValue = "Jr. Cajamarca 619, oficina #04 (Inca Lake)";
                $("#container-recojo-de-hotel").slideUp("slow");
                $("#container-punto-de-presentacion").slideDown();
                $("#txt_lugar_encuentro").val("");
                removerCheck("tiporecojoA", false);
                break;
            case 1:
                message = "Indicar hoteles aplicables para el recojo:";
                contentValue = "Hoteles ubicados alrededor de la plaza de armas de Puno";
                $("#container-punto-de-presentacion").slideUp("slow");
                $("#container-recojo-de-hotel").slideDown();
                $("#txt_lugar_encuentro").val("");
                removerCheck("tiporecojoB", false);
                break;
        }
        $('#lbl_lugar_encuentro').text(message);
        //$('#txt_lugar_encuentro').val(contentValue);
        $('#txt_lugar_encuentro').focus();
    });

    function removerCheck(className, status) {
        $('.' + className).each(function() {
            $(this).prop('checked', status);
        });
    }
    var tokens = {
        recojo_de_hotel: {
            es: 'El recojo está incluido solamente si su hotel se encuentra cerca de la plaza de armas (máximo 3 cuadras alejada de la misma). Si su hotel se encuentra fuera de este rango, habrá cargos adicionales, contáctenos a reservas@incalake.com para preguntar sobre los cargos adicionales.',
            en: 'Pick up is included only of your hotel is located near Plaza de Armas (max 3 blocks away from it) Otherwise, it may have extra charges for picking you up. If you have any doubts contact us to reservas@incalake.com to ask about this extra charges.',
            fr: 'Le ramassage est inclus seulement si votre hôtel est près de la place principale (maximum 3 blocs). Si votre hôtel est en dehors de cette plage, il y aura des frais supplémentaires, contactez-nous à reservas@incalake.com pour connaître les frais supplémentaires.',
            br: 'A recolhida é incluída apenas se o seu hotel estiver perto da praça principal (máximo de 3 quarteirões de distância). Se o seu hotel estiver fora desse intervalo, haverá cobranças adicionais, contate-nos em reservas@incalake.com para obter informações sobre os custos adicionais.',
            de: 'Pick up is included only of your hotel is located near Plaza de Armas (max 3 blocks away from it) Otherwise, it may have extra charges for picking you up. If you have any doubts contact us to reservas@incalake.com to ask about this extra charges.',
            it: 'Il pick up è incluso solo se il vostro hotel è situato vicino alla piazza principale (massimo 3 isolati di distanza da esso). Se il vostro hotel è al di fuori di questa gamma, ci saranno costi aggiuntivi, contattateci all\'indirizzo reservas@incalake.com per chiedere informazioni sulle spese aggiuntive.',
        },
        lugar_de_presentacion: {
            es: 'Los clientes deben presentarse en Plaza de armas de la ciudad.',
            en: 'Clients must to present on Plaza de Armas or Main Plaza of the city.',
            fr: 'Les clients doivent se présenter à la place de la ville.',
            br: 'Os clientes devem se apresentar na Praça da Cidade. ',
            de: 'Clients must to present on Plaza de Armas or Main Plaza of the city.',
            it: 'I clienti devono presentarsi alla piazza della città.',
        },
        retorno_plaza_de_armas: {
            es: 'Al retornar, se les dejará en la plaza principal o cerca de ella.',
            en: 'At the return,  you will be dropped off close to the Plaza.',
            fr: 'À leur retour, ils seront laissés sur la place principale ou à proximité.',
            br: 'Ao retornar, eles serão deixados no quadrado principal ou perto dele.',
            de: 'At the return,  you will be dropped off close to the Plaza.',
            it: 'Al ritorno, saranno lasciati nella piazza principale o in prossimità.'
        },
        lugar_de_finalizacion_actividad: {
            es: 'Al final el tour, se les dejará en la plaza principal o cerca de ella.',
            en: 'At the end of the tour, you will be dropped off near Plaza de Armas.',
            fr: 'A la fin de la tournée, Vous seront laissés sur la place principale ou à proximité.',
            br: 'No final do passeio, eles serão deixados na praça principal ou perto dele.',
            de: 'At the end of the tour, you will be dropped off near Plaza de Armas.',
            it: 'Alla fine del tour, saranno lasciati nella piazza principale o nei pressi di esso.'
        }
    };

    $(document).on('change', '.tiporecojoA', function(event) {
        var value = $(this).val();
        var message = "";
        var contentValue = "";

        switch (parseInt(value)) {
            case 0:
                $("#txt_lugar_encuentro").val(tokens['lugar_de_presentacion'][(idioma_actividad)
                    .toLowerCase()
                ]);
                break;
            case 1:
                $("#txt_lugar_encuentro").val("");
                break;
        }
        $("#txt_lugar_finalizacion").val(tokens['retorno_plaza_de_armas'][(idioma_actividad)
            .toLowerCase()
        ]);
        console.log("Click first..!");
    });

    $(document).on('change', '.tiporecojoB', function(event) {
        var value = $(this).val();
        var message = "";
        var contentValue = "";

        switch (parseInt(value)) {
            case 0:
                $("#txt_lugar_encuentro").val(tokens['recojo_de_hotel'][(idioma_actividad)
                    .toLowerCase()
                ]);
                break;
            case 1:
                $("#txt_lugar_encuentro").val("");
                break;
        }
        $("#txt_lugar_finalizacion").val(tokens['lugar_de_finalizacion_actividad'][(idioma_actividad)
            .toLowerCase()
        ]);
        console.log("Click Second..!");
    });

    $(document).on('change', '.tipoguia', function(event) {
        var value = $(this).val();
        var message = "";
        var contentValue = "";
        console.log("CLICK ", value);
        switch (parseInt(value)) {
            case 0:
                //$("#txt_lugar_encuentro").val(tokens['recojo_de_hotel'][(idioma_actividad).toLowerCase()]);
                $("#txt-seleccionar-tipoguia").empty().text(
                    "Seleccionar idiomas del Guía de tour en vivo");
                $("#selected-tipoguias").slideDown('slow');
                break;
            case 1:
                //$("#txt_lugar_encuentro").val("");
                $("#txt-seleccionar-tipoguia").empty().text("Seleccionar idiomas del Audio Guía");
                $("#selected-tipoguias").slideDown('slow');
                break;
            case 2:
                $("#txt-seleccionar-tipoguia").empty().text(
                    "Seleccionar idiomas de Folletos informativos");
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

    $(document).on('change', '.tipopolitica', function(event) {
        event.preventDefault();
        var value = $(this).val();
        switch (parseInt(value)) {
            case 0:
                cargarPoliticasStandar(idioma_actividad);
                break;
            case 1:
                //$('#txt_politicas_producto').val('').focus();    
                //$('#txt_politicas').val('').focus(); 
                CKEDITOR.instances['txt_politicas'].setData('');
                //document.getElementById('txt_politicas').readOnly = false;   
                break;
        }
    });

    var rdbtnPoliticaSelected = null,
        rdbtnRecojoSelected = null;
    //var rdbtnPolitica = document.getElementsByName("tipopolitica");
    var rdbtnRecojo = document.getElementsByName("tiporecojo");
    /*
    for(var i=0;i<rdbtnPolitica.length;i++){
      if(rdbtnPolitica[i].checked){
          rdbtnPoliticaSelected = rdbtnPolitica[i].value;
      }
    }
    */
    for (var i = 0; i < rdbtnRecojo.length; i++) {
        if (rdbtnRecojo[i].checked) {
            rdbtnRecojoSelected = rdbtnRecojo[i].value;
        }
    }

    //Código para inicializar los radioButtons de Politicas y Recojo 
    console.log("ESTADO BTN POLITICAS ", rdbtnPoliticaSelected);
    /*
    switch( parseInt(rdbtnPoliticaSelected) ){
        case 0:
          cargarPoliticasStandar(idioma_actividad);
        break;
        case 1:
          //$('#txt_politicas_producto').val('').focus(); 
          console.log("No hacer nada a campo políticas");   
          //$('#txt_politicas').val('').focus();
          CKEDITOR.instances['txt_politicas'].setData('');  
          //document.getElementById('txt_politicas').readOnly = false;  
        break;
    }
    */
    var messageLoadRecojo = "";
    switch (parseInt(rdbtnRecojoSelected)) {
        case 0:
            messageLoadRecojo = "Indicar el Lugar de Presentación para Iniciar la actividad:";
            break;
        case 1:
            messageLoadRecojo = "INDICAR HOTELES APLICABLES PARA EL RECOJO:";
            break;
    }
    $('#lbl_lugar_encuentro').text(messageLoadRecojo);
    /*******************************************************************/
    if (parseInt(data_editar) === 0) {
        $.ajax({
            url: '<?= base_url(); ?>admin/productos/nextCodigoProducto',
            type: 'POST',
            dataType: 'JSON',
            data: {
                lang: idioma_actividad,
                idservicio: id_servicio
            },
        }).done(function(data) {
            //console.log(data);
            if (data.length != 0) {
                document.getElementById("codigo_prod").value = data;
                document.getElementById("codigo_prod").readOnly = true;
            } else {
                document.getElementById("codigo_prod").readOnly = false;
            }
        }).fail(function(e) {
            console.log(e.responsetext);
        });
    }

    CKEDITOR.replace('txt_descripcion');
    CKEDITOR.add
    CKEDITOR.replace('txt_itinerario');
    CKEDITOR.add
    CKEDITOR.replace('txt_incluye');
    CKEDITOR.add
    CKEDITOR.replace('txt_informacion_adicional');
    CKEDITOR.add
    CKEDITOR.replace('txt_recomendaiciones');
    CKEDITOR.add
    CKEDITOR.replace('txt_politicas');
    CKEDITOR.add
    CKEDITOR.instances['txt_politicas'].on('key', function() {
        var politicasStandarChange = CKEDITOR.instances['txt_politicas'].getData().trim().length;
        if (politicasStandarChange > politicasStandarLength) {
            $("#tipopoliticaA").prop('checked', false);
            $("#tipopoliticaB").prop('checked', true);
        }
    });
});

//Para controlar los checks de politcas
var politicasStandarLength = 0;

function cargarPoliticasStandar(language) {
    var contenido_politicas = '';
    $.ajax({
        url: '<?= base_url(); ?>admin/documento/politicasStandar',
        type: 'POST',
        dataType: 'json',
        data: {
            lang: language
        },
    }).done(function(data) {
        //console.log(data);
        if (data.response === "success") {
            contenido_politicas = data.message;
            //$('#txt_politicas_producto').empty().val(data.message);
            //$('#txt_politicas').empty().val(data.message);
            politicasStandarLength = (data.message).trim().length;
            CKEDITOR.instances['txt_politicas'].setData(data.message);
            //document.getElementById('txt_politicas').readOnly = true;
        }
        //console.log(data.message);
    }).fail(function(e) {
        console.log(e.responsetext);
    });

    return contenido_politicas;
}

var idioma_actividad = '<?= @$servicio['codigo'] ?>';
var id_servicio = '<?= @$servicio['id_servicio']; ?>';
//console.log("IDIOMA ",idioma_actividad);
//console.log("ID SERVICIO ",id_servicio);
/************** ACTUALIZAR ARRAY DISPONIIBILIDAD, BLOQUEO y OFERTA ***********/
var data_editar = '<?= $data_editar; ?>';
//console.log("EDITAR: ",data_editar);
if (parseInt(data_editar) === 1) {
    var editar_data_disponibilidad = JSON.parse('<?= json_encode($data_disponibilidad); ?>');
    var editar_data_bloqueo = JSON.parse('<?= json_encode($data_bloqueo); ?>');
    var editar_data_oferta = JSON.parse('<?= json_encode($data_oferta); ?>');
    /****************** SETEANDO MARKERS DEL SERVICIO y/o TOUR *************************/
    var data_mapa = JSON.parse('<?= json_encode($data_mapa); ?>');
    for (var i in data_mapa) {
        points.lugares.push(data_mapa[i]);
    }
    $('.span_cantidad_lugares').empty().append(points.lugares.length);
    /**************** END SETEANDO MARKERS DEL SERVICIO y/o TOUR ***********************/
} else {
    $("#slct_requerimiento_datos option").eq(1).attr('selected', 'selected');
}

$("#slct_guias_seleccionados").multiselect({
    title: "Seleccionar...",
    //maxSelectionAllowed: 5
});
$(".panel-slider").find('.galeriaDivs').first().find('button').first().css({
    background: '#337ab7',
    color: '#fff'
});
</script>

<style>
.selectWrap>.select-content {
    display: inline !important;
}

.open-options.clickable {
    margin-top: auto !important;
}
</style>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places&callback=initAutocomplete"
    async defer></script>

</html>