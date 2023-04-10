<?php
  if (!empty($first_servicio) ) {
    //echo json_encode($first_servicio);
  }
  //echo json_encode($first_servicio);
  //echo '<br/>'.$codigo_servicio;
?>
<div class="container-fluid">
  <div class="">
    <div class="">
      <div class="headline">
        <div class="text-info"> <?=!empty($first_servicio['titulo_pagina']) ? mb_strtoupper( "<small>CREAR SERVICIO EN OTRO IDIOMA PARA:</small> ".$first_servicio['titulo_pagina'] ) : mb_strtoupper("crear un nuevo servicio") ; ?> </div><br>
      </div>
      <!-- <h3 class="text-left bg-info text-info"><strong><span class="fa fa-pencil-square"></span> CREAR NUEVA PÁGINA WEB</strong></h3> -->
      
      <?php echo validation_errors(); ?>
      <?php echo form_open('admin/servicio/add/'.$codigo_servicio,array("class"=>"row","id"=>"form_servicio_add","enctype"=>"multipart/form-data")); ?>
        <div class="form-group text-center">
          <div class="col-sm-offset-4 col-sm-8">
            <a href="<?php echo site_url('admin/servicio'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> Volver</a> 
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar y Agregar actividades y/o Servicios</button>
            </div>
        </div>
        <div class="form-group col-md-7">
            
              <label for="id_idioma" class="control-label"><span class="div-numeracion">1</span>Selecciona Idioma del servicio
              <span  class=" btn btn-info btn-xs fa fa-question " data-placement="top" data-toggle="popover"  data-content="Seleccione un idioma en la que será creada el servicio"></span>
              </label>
            
              
            
              <select name="txt_id_idioma" class="form-control validate[required]" id="txt_id_idioma">
                <option value="">seleccione un idioma</option>
                <?php 
                foreach($all_idiomas as $idioma){
                  $selected = ($idioma['id_idioma'] == $this->input->post('id_idioma')) ? ' selected="selected"' : "";
                  echo '<option value="'.$idioma['id_idioma'].'" '.$selected.'>'.$idioma['pais'].'</option>';
                } 
                ?>
              </select>
            </div>
        <div class="col-md-12">
          <div class="col-md-7" style="padding: 0;">
            <div class="form-group col-md-12" style="padding: 0;">
              <label for="lugar_pagina" class="control-label"><span class="div-numeracion">2</span> Ciudad de salida del servicio <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Seleccione o busque el lugar donde esta ubicado el servicio que mostrarás"></span></label>
              
              <input type="text" name="txt_lugar_pagina" value="" class="form-control validate[required]" id="txt_lugar_pagina" placeholder="Buscar..."/>
            </div>

            <div class="form-group col-md-12" style="padding: 0;">
              <label for="titulo_pagina" class="control-label"><span class="div-numeracion">3</span>Título del servicio<span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Google muestra solo los primeros 70 caracteres en los títulos así que es importante que aproveche este poco espacio. Sea claro y conciso al detallar sobre de qué se trata el servicio."></span></label>
              
              <input type="text" name="txt_titulo_pagina" value="<?php echo $this->input->post('titulo_pagina'); ?>" class="form-control validate[required]" id="txt_titulo_pagina" />
            </div>
            <div class="form-group col-md-12" style="padding: 0;">
              <label for="url_servicio" class="control-label"><span class="div-numeracion">4</span>URL del servicio<span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="La URL debe contener al menos una palabra clave; la url debe ser adecuada de acuerdo al contenido del servicio."></span></label>
              <p class="help-block"><strong>Ejemplo:</strong> El servicio está en el idioma español y tendrá un contenido que afrecerá al "Tours al medio dia a la Isla de los Uros desde Puno". Tu <strong>URL</strong> debe ser algo asi: <i>http://www.tudominio.com/es/puno/<b>tour-uros-medio-dia-desde-puno</b></i></p>
              <p class="help-block">NOTA: "<strong>es</strong>" equivalente al idioma español, "<strong>en</strong>" equivalente al idioma inglés, etc.</p>
              <div class="alert alert-danger"><span class="fa fa-exclamation-circle"></span> No use carateres especiales ni mayúsculas.</div>
              <div class="input-group col-md-12">
                  <span class="input-group-addon" id="spn_url_base" style="font-weight: bold;">https://web.incalake.com/</span>
                  <input type="text" name="txt_url_servicio" value="<?php echo $this->input->post('url_servicio'); ?>" class="form-control validate[required]" id="txt_url_servicio" onkeyup="javascript:this.value=this.value.toLowerCase();" style="text-transform:lowercase;"/>
                  <input type="hidden" name="txt_url_pagina_web" id="txt_url_pagina_web">
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="alert alert-danger text-center" id="div-error-url" style="display: none;">
                  <strong><span class="fa fa-times-circle"></span> <span id="span-error-url"></span></strong>
                </div>
              </div>              
            </div>
            <div class="form-group col-md-12" style="padding: 0;">
              <label for="descripcion_pagina" class="control-label"><span class="div-numeracion">5</span>Descripción del servicio (recomendado 160 Caracteres) <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="La meta-descripción puede ser de cualquier tamaño pero Google solo muestra 160 caracteres. Describa en pocas palabras el contenido del servicio"></span></label>
              
              <textarea name="txt_descripcion_pagina" class="form-control validate[required]" id="txt_descripcion_pagina" rows="3"><?php echo $this->input->post('descripcion_pagina'); ?></textarea>
              <span class="pull-right"><strong><span id="span_letter_count_pagina_web">0/160</span></strong></span>
            </div>
          </div>
          <div class="col-md-5">
            <div class=" div_metas div-box" >
            <p><b>Previsualización del buscador de google</b></p>
            <div id="titulo_pagina" style="padding: 5px 0;font-size: 18px;color: #1f7ed0;font-family: arial,sans-serif;font-weight: bold;">
              Título del servicio
            </div>
          
              <div id="url_pagina" style="font-size: 13px;color: #006621;font-style: normal;    font-weight: 700;">
                http://www.tudominio.com/es/puno/tour-uros-medio-dia-desde-puno.html
                        
              </div>
              <div id="descripcion_pagina" style="    color: #6a6a6a">
                Las meta descripciones son breves descripciones que resumen el contenido de un documento,Incluye tus palabras clave, Describe lo que se puede encontrar en<span style="color: #ccc;"> tu página, Haz evidente tu propuesta de valor o beneficio.</span>
              </div>
            
          </div>
          </div>
          
        </div>
        <div class="col-md-12">
          <div class="col-md-7" style="padding: 0;">
            <div class="form-group col-md-12" style="padding: 0;">
              <div class="form-group container-fluid" style="padding: 0;">
                <label for="imagen_principal_" ><span class="div-numeracion">6</span>Imagen destacada del servicio<span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="La imágen destacada se muestra en forma de slider al inicio de la página creada. Su función es representar a todos los tours que se ofrecerán en el servicio, donde se muestran todos las actividades turísticas. Las dimensiones de la imágen principal es muy importante, los cuales son: Ancho XXX pixeles, YYY pixeles."></span></label>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <span class="tooltip-image">
                    <?php 
                    $uri_imagen_principal = '';
                    $uri_imagen_miniatura = '';
                    $class_validate = 'validate[required]';
                    if ( $codigo_servicio != 0 ): 
                      $uri_imagen_principal = $first_servicio['imagen_principal'];
                      $class_validate = ''; 
                      $uri_imagen_miniatura = $first_servicio['miniatura'];
                    ?>
                      <!--a href="" data-toggle="tooltip" title="<img class='img-thumbnail' src='http://localhost/cms/assets/galeria/slider/<?=$first_servicio['imagen_principal'];?>'>"><span class="fa fa-picture-o pull-left fa-2x"></span></a-->
                      <span class="fa fa-picture-o pull-left fa-2x" ></span>
                    <?php endif ?>
                  </span>
                  <!--input  type="file" name="imagen_principal" value="<?php echo $this->input->post('imagen_principal'); ?>" class="validate[required]" id="imagen_principal"/>
                  <input type="hidden" name="txt_imagen_principal" value="<?php echo $uri_imagen_principal; ?>" class="validate[required]" id="txt_imagen_principal"/-->
                  <div class="galeriaDivs" id="imagen_principal">
                    <button onclick="openGaleria($(this),1,'Slider principal',[1200,400,150,200]); return false;">
                    <span class="fa fa-search-plus"></span> Seleccionar Slider</button>
                    <input type="text" class="inputImagenModal" value="<?=!empty($slider['url_archivo']) ? $slider['url_archivo'] : '';?>" readonly />
                    <input type="hidden" class="inputHideImagenModal" name="txt_imagen_principal" value="<?php echo $uri_imagen_principal; ?>"/>
                  </div>
                </div>
              </div>
              <div class="form-group container-fluid" style="padding: 0;">
                <label for="ver_slider" class="control-label"><span class="div-numeracion">7</span>Mostrar Imagen destacada del servicio en el Slider <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="El check por defecto viene activado, lo que indica que la imágen principal se mostrará y si Usted no quiere que se muestre desactive el check."></span></label>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="txt_ver_slider" value="1" id="txt_ver_slider" />
                      Mostrar el servicio en el slider del index de la aplicacion.
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group container-fluid" style="padding: 0;">
              <label for="miniatura_" class="control-label"><span class="div-numeracion">8</span>Imagen Miniatura del servicio<span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="La miniatura es una imágen personalizada que se utiliza junto al nombre de la actividad y se muestra como actividades relacionadas en todas las páginas web que contienen activiades según la categoria a la que pertenecen."></span></label>
              
              <p class="help-block">Sube una imágen que mejor represente al contenido del servicio de preferencia en buena calidad.</p>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <span class="tooltip-image-thumbnail">
                  <?php if ( $codigo_servicio != 0 ): ?>
                    <!--a href="" data-toggle="tooltip" title="<img class='img-thumbnail' src='http://localhost/cms/assets/galeria/thumbnail/<?=$first_servicio['miniatura'];?>'>"><span class="fa fa-picture-o pull-left fa-2x"></span></a-->
                    <span class="fa fa-picture-o pull-left fa-2x"></span>
                  <?php endif ?>
                </span>
                <!--input type="file" name="miniatura" value="<?php echo $this->input->post('miniatura'); ?>" id="miniatura"/>
                <input type="hidden" name="txt_miniatura" value="<?php echo $uri_imagen_miniatura; ?>" id="txt_miniatura"/-->
                <div class="galeriaDivs" id="imagen_miniatura">
                  <button onclick="openGaleria($(this),3,'Imagen de los tours relacionados.',[150,150,50,100]); return false;">
                  <span class="fa fa-search-plus"></span> Seleccionar Miniatura</button>
                  <input type="text" class="inputImagenModal" value="<?=!empty($miniatura['url_archivo']) ? $miniatura['url_archivo']: '';?>" readonly />
                  <input type="hidden" class="inputHideImagenModal" name="txt_miniatura" value="<?php echo $uri_imagen_miniatura; ?>"/></div>
              </div>
            </div>
            <div class="form-group container-fluid" style="padding: 0;">
              <label for="valoracion" class="control-label"><span class="div-numeracion">9</span>Seleccione la valoración del servicio, según las visitas de los clientes <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Seleccione la valoración de tuservicio según a las visitas que realizan tus clientes."></span></label>
              
              <div class="col-md-12 col-sm-12 col-xs-12" id="div_txt_valoracion">
                <input type="text" name="txt_valoracion" value="4.5" class="form-control validate[required] kv-ltr-theme-fa-star rating-loading" id="txt_valoracion" data-size="xs" dir="ltr">
              </div>
            </div>
            <div class="form-group container-fluid" style="padding: 0;">
              <label for="reviews" class="control-label"><span class="div-numeracion">10</span>Comentarios para el servicio <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Los comentarios son mostrados al final de la página web. Estos comentarios son de los clientes que optaron el servicio. Agregue de acuerdo a lo que comentaron tus clientes."></span></label>
              
              <div class="col-md-12 col-xs-12 col-sm-12" id="div_txt_comentarios">
                <div class="">
                  <a href="javascript:void(0)" class="btn btn-warning btn-add-reviews">Agregar Comentarios..!</a>
                  <a href="javascript:void(0)" title="Click para Ver Comentarios..!" class="btn-list-reviews"><strong><span class="fa fa-list"> </span> <span class="contador-reviews">0</span><span> Comentario(s)..!</span></strong></a> 
                </div>
                <input type="hidden" name="txt_reviews" class="form-control" id="txt_reviews" value="<?php echo $this->input->post('reviews'); ?>" />
              </div>
            </div>
          </div>
          <div class="col-md-5  div-box">
            <div>
              <div class="col-md-12 div-box" id="div_img_principal" style="min-height: 100px">
              <div class="col-md-12 text-center" style="height: 100%;">
                Imagen destacada del servicio
              </div>
                
              </div>
              <div class="row">
                <div class="col-md-9">
                  <div class="col-md-12 div-box" id="div_contenido" style="min-height: 200px">
                    Contenido
                  </div>
                  <div class="col-md-12 div-box" id="div_valoracion">
                    Valoracion
                  </div>
                  <div class="col-md-12 div-box" id="div_comentarios">
                    Comentarios
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="col-md-12 div-box" style="min-height: 200px"  >

                    Servicios relacionados
                    <div class="col-md-12 div-box" id="div_relacionados">
                      <div class="col-md-6 div-box"></div>
                      <div class="col-md-6"></div>
                    </div>
                    <div class="col-md-12 div-box">
                      <div class="col-md-6 div-box"></div>
                      <div class="col-md-6"></div>
                    </div>
                    <div class="col-md-12 div-box">
                      <div class="col-md-6 div-box"></div>
                      <div class="col-md-6"></div>
                    </div>
                    <div class="col-md-12 div-box">
                      <div class="col-md-6 div-box"></div>
                      <div class="col-md-6"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr/>
        <div class="form-group">
          <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-success">Guardar y Agregar actividades</button>
            <a href="<?php echo site_url('admin/servicio'); ?>" class="btn btn-danger">Volver</a> 
              </div>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div> 
</div>

<div id="modal-reviews" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Agregar Comentarios</strong></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="form-comentario">
            <div class="form-group">
              <label for="valoracion" class="col-md-4 control-label">Valoración/Page Rank</label>
              <div class="col-md-8 input-star-review">
                <input type="text" name="txt_valoracion2" value="5" class="form-control validate[required] kv-ltr-theme-fa-star rating-loading" id="txt_valoracion2" data-size="xs" dir="ltr">
              </div>
            </div>
            <div class="form-group">
          <label for="nombre_comentarista" class="col-md-4 control-label">Nombre del Comentarista</label>
          <div class="col-md-8">
            <input type="text" autofocus name="txt_nombre_comentarista" value="" style="text-transform: uppercase;" class="form-control validate[required]" id="txt_nombre_comentarista" />
          </div>
        </div>
        <div class="form-group">
          <label for="nacionalidad_comentarista" class="col-md-4 control-label">País del Comentarista</label>
          <div class="col-md-8">
            <input type="text" name="txt_nacionalidad_comentarista" class="form-control validate[required]" id="txt_nacionalidad_comentarista"/>
          </div>
        </div>
        <div class="form-group">
          <label for="comentario" class="col-md-4 control-label">Comentario</label>
          <div class="col-md-8">
            <textarea name="txt_comentario" value="" class="form-control validate[required]" id="txt_comentario" ></textarea>
          </div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-agregar-comentario"> Agregar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  </div>
</div>

<div id="modal-reviews-list" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Listar Comentarios</strong></h4>
        </div>
        <div class="modal-body">
          <div class="modal-body">
            <div class="row">
              <div class="modal-list-reviews">

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
  .color{
    background: #feff65;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    document.getElementById("txt_url_servicio").disabled = true;
    window.addEventListener("keypress", function(event){
          //Desactivando tecla ENTER
          if (event.keyCode == 13){
              event.preventDefault();
          }
      }, false);
    
    var string_lugar = "<?=!empty($first_servicio['ubicacion_servicio']) ? trim($first_servicio['ubicacion_servicio']) : '';?>";
    $("#txt_lugar_pagina").val(string_lugar.trim());
    $( "#txt_titulo_pagina" ).on("mouseover mouseout focusin focusout",function(){
      $('#titulo_pagina').toggleClass('color');
    });
    $("#txt_titulo_pagina").keyup(function () {
              var value = $(this).val();
              $("#titulo_pagina").html(value);
          });
    $( "#txt_url_servicio" ).on("mouseover mouseout focusin focusout",function(){
      $('#url_pagina').toggleClass('color');
    });
    $("#txt_url_servicio").keypress(function(e){ 
      evt = e ? e : event;
      tcl = (window.Event) ? evt.which : evt.keyCode;
      //console.log("KEY: "+tcl);
      /* tecla + = 43 */
      if( tcl === 32 ){
        document.getElementById("txt_url_servicio").value = document.getElementById("txt_url_servicio").value + "-";
        return false;
      }else{
        return ( tcl != 44 && tcl != 46 && tcl != 59 && tcl != 58 && tcl != 43);
      }
    });
    $("#txt_url_servicio").keyup(function (e) {
      var url_base = $("#spn_url_base").text();
      var value = $(this).val().trim();
            
      $("#url_pagina").html(url_base+value);
      return true;
        });
    $( "#txt_descripcion_pagina" ).on("mouseover mouseout focusin focusout",function(){
      $('#descripcion_pagina').toggleClass('color');
    });
    $("#txt_descripcion_pagina").keyup(function () {
      var value = $(this).val();
      
      $("#descripcion_pagina").html(value);
      if($(this).val().length>158){
        $("#descripcion_pagina").append('...');
      }
        });

    /* MAQUETA WEB EN DIVS*/
    $( "#imagen_principal" ).on("mouseover mouseout focusin focusout",function(){
      $('#div_img_principal').toggleClass('color');
    });
    $( "#imagen_miniatura" ).on("mouseover mouseout focusin focusout",function(){
      $('#div_relacionados').toggleClass('color');
    });
    $( "#div_txt_valoracion" ).on("mouseover mouseout focusin focusout",function(){
      $('#div_valoracion').toggleClass('color');
    });
    $( "#div_txt_comentarios" ).on("mouseover mouseout focusin focusout",function(){
      $('#div_comentarios').toggleClass('color');
    });

    /*-------------------------------------------------*/

    $('a[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        placement: 'right',
        html: true
    });

       $('#txt_valoracion').rating({
        hoverOnClear: false,
        theme: 'krajee-fa',
        min: 0, 
        max: 5, 
        step: 1, 
        stars: 5
    });
       $('#txt_valoracion2').rating({
        hoverOnClear: false,
        theme: 'krajee-fa',
        min: 0, 
        max: 5, 
        step: 1, 
        stars: 5
    });
      $("#form_servicio_add").validationEngine('attach', {
      relative: true,
      promptPosition:"bottomLeft"
    });
    $("#form-comentario").validationEngine('attach', {
      relative: true,
      promptPosition:"bottomLeft"
    });
      $(document).on('click', '#txt_id_idioma', function(event) {
        event.preventDefault();
        var idioma = ( $(this).val() ).toLowerCase();
        var lugar  = ( $("#txt_lugar_pagina").val() ).toLowerCase();
        generar_url(idioma,lugar);
      });

      $(document).on('change', '#txt_lugar_pagina', function(event) {
        event.preventDefault();

        var lugar  = ( $(this).val() ).toLowerCase();
        var idioma = ( $("#txt_id_idioma").val() ).toLowerCase();
        generar_url( idioma,lugar );
      });
      /*
      $(document).on('focus', '#txt_titulo_pagina', function(event) {
        event.preventDefault();
        var lugar  = ( $("#txt_lugar_pagina").val() ).toLowerCase();
        var idioma = ( $("#txt_id_idioma").val() ).toLowerCase();
        generar_url( idioma,lugar );
      });
      */
  });


  function generar_url(idioma,lugar2){
    var lugar  = ( $("#txt_lugar_pagina").val() ).toLowerCase();
    if (lugar.length != 0 ) {
        //lugar       = lugar.replace(/ /gi,"-");
        array_lugar = (lugar.trim()).split(",");
      lugar = (array_lugar[0]).replace(/[ ]/gi,"-");
        
        var especiales = new Array('á','é','í','ó','ú','ñ',' ','´',':',',',';','.');
      var normales   = new Array('a','e','i','o','u','n','','','','','','');
      i=0;
      while (i<especiales.length) {
        lugar = lugar.split(especiales[i]).join(normales[i]);
        i++;
      }
      lugar = lugar + '/';
    }else{
      lugar = '';
    }
      console.log(lugar);
      $.ajax({
        url: '<?=base_url();?>admin/idioma/codigo',
        type: 'POST',
        dataType: 'json',
        data: {id: idioma},
      }).done(function(data) {
        if ( data.response === 'OK' ) {
          //var url_base = 'http://incalake.com/'+ (data.data.codigo).toLowerCase()+'/'+lugar;
          var url_base = 'https://web.incalake.com/'+ (data.data.codigo).toLowerCase()+'/'+lugar;
          //$('#txt_url_servicio').val('http://incalake.com/'+ (data.data.codigo).toLowerCase()+'/'+lugar );
          $("#spn_url_base").empty().text(url_base);
        } 
        /*console.log(data.data.codigo.toLowerCase() );*/
      }).fail(function(e) {
        console.log(e.responseText);
      });
  }

  function validar_url(url){
    //return true;//resuelto por emergencia
    var regex = new RegExp("^(http|https):\/\/([w]{3}\\.|[a-z0-9]+)\\.[a-z]{3}\/[a-z]{2}\/[a-z0-9-_]+\/[a-z0-9-_]+");
    //if( regex.test(url) ){
    if(true){
      var total_caracteres = url.length;
      var temp_url = url.substring(total_caracteres-5, total_caracteres);
      /*if ( temp_url != '.html' ) {
        url = url + '.html';
      }*/
      verificar_duplicidad(url);
      $('#txt_url_pagina_web').empty().val(url);
        return true;
      }else{
        return false;
      }
  }

  $(document).on('focusout', '#txt_id_idioma', function(event) {
    event.preventDefault();
    if ( $(this).val().trim().length > 0 && $("#txt_lugar_pagina").val().trim().length > 0 ) {
      document.getElementById("txt_url_servicio").disabled = false;
    }else{
      document.getElementById("txt_url_servicio").disabled = true;
    }
  });

  $(document).on('focusout', '#txt_lugar_pagina', function(event) {
    event.preventDefault();
    if ( $(this).val().trim().length > 0 && $("#txt_id_idioma").val().trim().length > 0 ) {
      document.getElementById("txt_url_servicio").disabled = false;
    }else{
      document.getElementById("txt_url_servicio").disabled = true;
    }
  });

  $(document).on('focusout', '#txt_url_servicio', function(event) {
    event.preventDefault();
    
    var url_base   = $("#spn_url_base").text();
    var url_pagina = $(this).val().trim();
    temp_url_pagina= "";
    for (var i = url_pagina.length - 1; i >= 0; i--) {
      if (url_pagina[i] === "-") {
        temp_url_pagina = url_pagina.substr(0,i);
      }else{
        break;
      }
    }
    if (temp_url_pagina.length > 0 ) {
      url_pagina = temp_url_pagina;
    }
    $(this).val(url_pagina);

    var url_extension = $("#spn_extension_url").text();
    var url = url_base+url_pagina;

    if ( validar_url(url) ){
      return true;
    }else{
      if (url_pagina.trim().length > 0 ) {
        swal({
          title: "URL NO VÁLIDA",
          text: "La URL no es válida; por favor asegurate que cumple con el siguiente formato: http://incalake.com/idioma/lugar/mi-pagina-web, EJEMPLO: http://incalake.com/es/uros/tour-a-la-isla-de-los-uros.",
          type: "error",
          showCancelButton: false,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Voy a Corregirlo.!",
          closeOnConfirm: true
        },
        function(){
          if( $("#txt_lugar_pagina").val().length != 0 ) {
            $("#txt_url_servicio").focus();
          }else{
            $("#txt_lugar_pagina").focus();
          }
        });
      }
    }
  });
  function verificar_duplicidad(url){
    $.ajax({
      url: '<?=base_url();?>admin/servicio/verificar_url',
      type: 'POST',
      dataType: 'json',
      data: {url: url},
    }).done(function(data) {
      console.log(data);
      if ( data.response === 'ERROR' ) {
        $("#txt_url_servicio").val('').focus();
        $('#div-error-url').css('display','block');
        $("#span-error-url").empty().text( url + "; YA ESTÁ EN USO." );
      }else{
        $('#div-error-url').css('display','none');
      }
    }).fail(function(e) {
      console.log(e.responseText);
      swal("ERROR","Hay problemas con la conexión al servidor, Por favor asegurese que la url no tenga duplicidad.","error");
    }); 
  }

</script>
<style type="text/css">
  /*** Style para mostrar el buscador de Google Place en el Modal [Agregar Comentario] ***/
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<script>

    /*********************** BEGIN SCRIPT GESTIONAR REVIEWS *********************/

    var reviews = {items: [] };
  
  $('#modal-reviews').modal(
    { show: false }
  ).on('shown',function(){
      initMap();
      $('#txt_nombre_comentarista').focus();
  });
    
    $(document).on('click', '.btn-add-reviews', function(event) {
      event.preventDefault();
      $('#modal-reviews').modal('show');  
    });
    
    $(document).on('click', '.btn-agregar-comentario', function(event) {
      event.preventDefault();
      var rating_c    = $('#txt_valoracion2').val();
      var nombre_c    = $('#txt_nombre_comentarista').val();
      var nacionalidad_c  = $('#txt_nacionalidad_comentarista').val();
      var comentario_c  = $('#txt_comentario').val();
      if ( $("#form-comentario").validationEngine('validate') ) {
        $('#form-comentario')[0].reset();
        $('#modal-reviews').modal('hide');  

        if (rating_c==0) {
          rating_c==4;
        }
        var item_comentario = {
          rating:rating_c,
          nombres: nombre_c,
          nacionalidad: nacionalidad_c,
          comentario: comentario_c,
          fecha: ''
        };
        reviews.items.push(item_comentario);
        $('.contador-reviews').empty().append(reviews.items.length);
        $('#txt_reviews').empty().val(JSON.stringify(reviews));

      }
    });
    $(document).on('click', '.btn-list-reviews', function(event) {
      event.preventDefault();
      var reviews_html  = '';
      if ( reviews.items.length === 0 ) {
        $('.modal-list-reviews').empty().append('No hay comentarios..!');
      }else{
        $.each( reviews.items, function(index, val) {
          var rating_coments =val.rating;
          if((val.rating)==null){
            rating_coments = 4+' default';
          }
          reviews_html += '<div class="alert alert-warning container-fluid">'+
                  '<div class="col-md-5" style="padding:0px;"><p><span class="fa fa-star"></span> '+rating_coments+'</p><p>'+val.nombres+'</p>'+
                            '<p>'+val.nacionalidad+'</p>'+
                            '</div>'+
                            '<div class="col-md-6">'+val.comentario+'</div>'+
                            '<div class="col-md-1"><span class="fa fa-close btn-eliminar-review" data-id="'+index+'"></span></div>'+
                          '</div>';
        });
        $('.modal-list-reviews').empty().append(reviews_html);
      }
      $('#modal-reviews-list').modal('show');
    });

  function initMap() {
    autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('txt_nacionalidad_comentarista')),
      {types: ['geocode']});
      //autocomplete.addListener('place_changed', fillInAddress);
      autocompletelugar = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('txt_lugar_pagina')),
      {types: ['geocode']});
  }

  $(document).on('click', '.btn-eliminar-review', function(event) {
    event.preventDefault();
    console.log($(this).data('id'));
    reviews.items.splice( parseInt( $(this).data('id')) , 1 );
    var reviews_html  = '';
      if ( reviews.items.length === 0 ) {
        $('.modal-list-reviews').empty().append('No hay comentarios..!');
      }else{
        $.each( reviews.items, function(index, val) {
          var rating_coments =val.rating;
          if((val.rating)==null){
            rating_coments = 4+' default';
          }
          reviews_html += '<div class="alert alert-warning container-fluid">'+
                  '<div class="col-md-5" style="padding:0px;"><p><span class="fa fa-star"></span> '+rating_coments+'</p><p>'+val.nombres+'</p>'+
                            '<p>'+val.nacionalidad+'</p>'+
                            '</div>'+
                            '<div class="col-md-6">'+val.comentario+'</div>'+
                            '<div class="col-md-1"><span class="fa fa-close btn-eliminar-review" data-id="'+index+'"></span></div>'+
                          '</div>';
        });
        $('.modal-list-reviews').empty().append(reviews_html);
      }
      $('#txt_reviews').empty().val(JSON.stringify(reviews));
      $('.contador-reviews').empty().append(reviews.items.length);
      $('#modal-reviews-list').modal('show');
  });
    /*********************** END  SCRIPT GESTIONAR  REVIEWS *********************/

</script>
<script type="text/javascript">
  //contador_letras('txt_descripcion_pagina','span_letter_count_pagina_web',160);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places&callback=initMap" async defer></script>
