(function(){
  // set de timepicker
  function set_timepicker(input){
    input.timepicker({
            minuteStep: 10,
            appendWidgetTo: 'body',
            showSeconds: false,
            showMeridian: true,
            defaultTime: false
    });
  }
  // funcion para retornar html de los horarios
  function retorna_html_horario(data){
    var data = data?data:[];
    return `
      <div style="padding-bottom:5px;" class="div_horarios">
        <div class="col-md-2 col-xs-2">
          <input required type="text" name="hora_salida[]" readonly class="inputTime form-control" value="${data.hora_partida || '12:00 AM'}">
        </div>
        <div class="col-md-2 col-xs-2">
          <input required type="number" step="0.1" name="duracion_viaje[]" value="${data.duracion || ''}" class="form-control">  
        </div>
        <div class="col-md-3 col-xs-3">
          <select  class="form-control" required name="servicio_bus[]">
            <option value="">-- Seleccione --</option>
            ${servicios_options(data.id_servicio)}
          </select> 
        </div>
        <div class="col-md-2 col-xs-2">
          <input required type="number" step="0.01"  class="form-control" value="${+data.precio_persona || ''}" name="precio_viaje[]">
        </div>
        <div class="col-md-2 col-xs-2">
          <label><span class="flag flag-bo"></span> Hora Boliviana: <input ${+data.zona_horaria?'checked':''} type="checkbox" class="zona_check" name="zona_horaria[]"  /> </label>
        </div>
        <div class="col-md-1 col-xs-2">
          <button class="btn btn-danger" type="button" onclick="$(this).closest('.div_horarios').remove()"><span class="fa fa-times"></span></button>
        </div>
        <div style="clear:both"></div>
      </div>
      `;
  }
  // // // 
 var horarios_container = $('#horarios_container');
 var btn_add_salidas = $('#btn_add_salidas');
// horarios_container.html(retorna_html_horario());
// set_timepicker($('.inputTime'));
 var json_servicios = (horarios_container.data('servicios'));
 
 var json_salidas = (horarios_container.data('horarios'));
 //var json_salidas = [];
 //try {json_salidas = JSON.parse(salidas);} catch(e) {json_salidas=false}
 // console.log(salidas instanceof Object);
 // obtener servicios
 function servicios_options(selected){
  var servicios_options = '';
  if(json_servicios instanceof Object){
   $.each(json_servicios,function(){
     servicios_options+=`<option ${this.id_servicio==selected?'selected':''} value="${this.id_servicio}">${this.nombre_servicio}</option>`;
   });
  }
  return servicios_options;
 }

// si existe data de horarios (cuando se edita) leerlos 
 if(json_salidas instanceof Object){
   $.each(json_salidas,function(){
    horarios_container.append(retorna_html_horario(this));
   });
 }
 btn_add_salidas.click(function(){
      horarios_container.append(retorna_html_horario());
      $('.inputTime:last-child').timepicker(timepickersettings);
 });

// manejar lugares

var origen_select = $('#origen_select');
var destino_select = $('#destino_select');
var lugares_multiple = $('#lugares_multiple');
var options_lugares = '';
$.each(json_lugares,function(){
  options_lugares += `<option value="${this.id_lugar}">${this.nombre_lugar}</option>`;
});
origen_select.append(options_lugares);
// leer data para preseleccionar en caso se edite
origen_select.val(origen_select.data('value'));

destino_select.append(options_lugares);
// leer data para preseleccionar en caso se edite
destino_select.val(destino_select.data('value'));

lugares_multiple.append(options_lugares);
// leer data para preseleccionar en caso se eite
var lugares_default = (lugares_multiple.data('value')+'').split(',');
lugares_multiple.val(lugares_default);
// ordenar options en preseleccionados
$.each(lugares_default,function(i){  
  if(this=='')return;
  lugares_multiple.find('option[value='+this+']').attr({'data-orden':i});
 // lugares_multiple.trigger('change');
  
});
//


// evitar precionar tecla de control para seleccionar en multiselects
 /* $('select[multiple] option').mousedown(function(e) {
      e.preventDefault();
      $(this).prop('selected', !$(this).prop('selected'));
      return false;
  });*/
// aplicar ckeditor a los textarea
 CKEDITOR.replaceClass = 'ck_textarea';
// agregar tabs adicionales
var addTabButton = $('#addTabButton');
var added_tabs = $('#added_tabs');

// variable para crear ids unicas en el textarea y aplicar ckeditor
var idkey = 0;
addTabButton.click(function(){
  added_tabs.append(addTab(++idkey));
  CKEDITOR.replace('ck_textarea'+idkey);
});
// agregar tabs si existe en data
var json_tabs = added_tabs.data('tabs');
if(json_tabs instanceof Object){
  $.each(json_tabs,function(){
    added_tabs.append(addTab(++idkey,this));
  });
}

// evento para agregar campos galeria
var contenedorGaleria = $('.galeriaDIV');
$('#addGaleriaSlider').click(function(){
  // alert('add galeria');
  var html = addFormGaleria();
  if(contenedorGaleria.find('.galeriaDivs').length)contenedorGaleria.eq(0).append(html);else contenedorGaleria.eq(0).html(html);
});
// agregar galeria si existe
var json_galeria = contenedorGaleria.data('galeria');
if(json_galeria instanceof Object){
  $.each(json_galeria,function(){
    contenedorGaleria.append(addFormGaleria(this));
  });
}

})();

//
function addTab(idkey,data){// si tiene valor trabaja con php
  var data = data?data:[];
  //var icono = '';
  var fontawesome = {'address-book':'f2b9',
                       'car'               : 'f1b9',
                       'bars'              : 'f0c9',
                       'clock-o'           : 'f017',
                       'commenting'        : 'f27a',
                       'film'              : 'f008',
                       'bed'               : 'f236',
                       'exclamation-triangle':'f071',
                       'film'       : 'f008',
                       'th-large'   : 'f009',
                       'th'         : 'f00a',
                       'th-list'    : 'f00b',
                       'check'      : 'f00c',
                       'times'      : 'f00d'};
  var options = null;

  
  $.each(fontawesome,function(i){
      options +=`<option ${(data.icono_tab_adicional==i?'selected':'')} class="icon-${i}" value="${i}"> &#x${this}; ${i}</option>`;
  });

return `<div class="panel panel-info">
            <div class="panel-heading">
            <h4 class="panel-title"><span class="fa fa-chevron-right"></span><b> Tab adicional</b><span onclick="$(this).closest('.panel-info').remove();" class="fa fa-window-close fa-2x" style="float: right; cursor: pointer; color: #d22521;margin-top: -7px;"></span>
            </h4>
            </div>
            
            <div>
              <div class="panel-body">
                <div class="">
                  <label>Nombre Tab: </label>
                  <input class="form-control" value="${data.nombre_tab_adicional || ''}" type="text" name="addedTabs_nombre[]" />
                  <label>Icono Tab: </label>
                    <select style="font-family: FontAwesome, Helvetica" class="form-control" name="addedTabs_icono[]" id="addedTabs_icono">
                      <option value="">-- Icono --</option>${options}</select>
                      <div class="">
                        <label>Contenido HTML: </label>
                        <textarea id="ck_textarea${idkey}" class="form-control ck_textarea" name="addedTabs_contenido[]">
                        ${data.contenido_tab || ''}
                        </textarea>
                      </div>
                </div>
              </div>
          </div>
        </div>`;


  // $idtab++;
}
// funcion para agregar html del selects galeria
function addFormGaleria(data){
  var data = data?data:[];
  return `<div class="galeriaDivs">
      <button class="col-md-4 col-xs-3" onclick="openGaleria($(this),2,this.parentNode.parentNode.title${(2?',[800,400,100,150]':'')}); return false;">
        <span class="fa fa-search-plus"></span>
        <span class="hidden-xs"> Buscar imagen</span>
      </button>
      <input type="text" class="inputImagenModal col-md-5" value="${data.url_archivo || ''}" readonly />
      <input type="hidden" class="inputHideImagenModal" name="${(2?'sliderGaleria[]':'adjuntos_producto[]')}" value="${data.id_galeria || ''}" />
      <button class="col-md-3" onclick="$(this).parent().remove()">
          <span class="fa fa-close"></span>
      </button>
    </div>`;
}

