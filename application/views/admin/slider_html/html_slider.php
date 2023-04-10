<?php 
// var_dump($servicios);
?>
<div class="container">
 <div class="col-md-3">
  <div class="panel panel-primary">
    <div class="panel-heading">Lista de Idiomas para el Slider principal </div>
    <div class="panel-body">
      <table class="table" id="tabla_idiomas">

       <tbody>
       </tbody>
      </table>
    </div>
  </div>
 </div>
 <div class="col-md-9">
  <div class="panel panel-primary">
    <div class="panel-heading">Lista Sliders
       <button type="button" class="btn btn-success pull-right" style="margin:-6px 0 0 3px" id="guardar_btn" disabled>Guardar</button> &nbsp;

       <button type="button" class="btn btn-info pull-right" id="add_btn" disabled title="agregar formulario de slider" style="margin-top:-6px;" ><i class="fa fa-plus" aria-hidden="true"></i></button> 
    </div>
    <div class="panel-body" id="contenedor_form">
      <p>Seleccione un idioma para mas opciones.</p>
    </div>
  </div>
 </div>
</div>

<!-- modal para buscar servicio  -->
<div id="vista_servicios" class="modal fade" role="dialog">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Seleccione servicio para extraer detalles</h4>
    </div>
    <div class="modal-body">
      <select class="form-control" id="lista_servicios">
      </select>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Seleccionar</button>
    </div>
  </div>
</div>
</div>
<!-- fin del modal de buscar servicio -->
<script>
(function(){
var idiomas = <?=json_encode($idiomas);?>;
var sliders = <?=json_encode($sliders);?>;
var servicios = <?=json_encode($servicios);?>;
/* imprimir servicios */
var lista_servicios = $('#lista_servicios');
var html_select_servicios = '';
$.each(servicios,function(key,elem){
  var titulo = elem[1]?elem[1].titulo_pagina:(elem[2]?elem[2].titulo_pagina:'Desconocido--');
  html_select_servicios += `<option value="${key}">${titulo}</option>`;
});
lista_servicios.html(html_select_servicios);
/* fin imprimir servicios */
function tr_idiomas(ide,nombre){
  return `<tr>
             <td>${nombre}</td>
             <td>
                 <button data-key="${ide}" type="button" class="btn btn-primary btn_idiomas_detalles">Ver</button>
             </td>
          </tr>`;
}

var html_idiomas = '';
var tabla_idiomas = $('#tabla_idiomas tbody');
$.each(idiomas,function(key,value){
  html_idiomas += tr_idiomas(value.id_idioma,value.pais);
});
tabla_idiomas.html(html_idiomas);
///////////////////////////////////////////
function retornaForms(titulo,subtitulo,destino,imagen){
          return `<div class="form_parent">
                    <div class="col-md-6"><input name="slider[titulo][]" title="Titulo del Slider" value="${titulo?titulo:''}" placeholder="Titulo del Slider" class="form-control" /></div>
                    <div class="col-md-5"><input name="slider[subtitulo][]"  title="Subtitulo del Slider" value="${subtitulo?subtitulo:''}" placeholder="Subtitulo del Slider" class="form-control" /></div>
                    <div class="col-md-1">
                      
                      <button type="button" class="btn btn-info">
                          <i class="fa fa-search" aria-hidden="true"></i>  
                      </button>
                      <div class="pull-up-down">
                                      <span title="Mover arriba" class="fa fa-chevron-circle-up"></span>
                                      <span title="Mover abajo" class="fa fa-chevron-circle-down"></span>
                                    </div> 
                    </div>
                    <div class="col-md-6"><input name="slider[destino][]"  title="Url del destino" value="${destino?destino:''}" placeholder="URL destino" class="form-control" /></div>
                    <div class="col-md-5"><input name="slider[imagen][]"  title="Url de la imagen" value="${imagen?imagen:''}" placeholder="URL imagen" class="form-control" /></div>
                    <div class="col-md-1">
                    <button type="button" class="btn btn-danger">
                        <i class="fa fa-times" aria-hidden="true"></i>  
                    </button>
                       
                  </div>
                  <div style="clear:both"></div>
                  </div>`;
}
var limite = 1;
var contenedor_form = $('#contenedor_form');
var guardar_btn = $('#guardar_btn');
var add_btn = $('#add_btn');
var vista_servicios = $('#vista_servicios');//modal
//var html_form = '<input type="" name="ide" />';
$('.btn_idiomas_detalles').click(function(){
  tabla_idiomas.find('tr').removeClass('activo');//elimiar clase sombreado
  $(this).parents('tr').addClass('activo');//agregar combreado

  var key = $(this).data('key');
  var html_form = `<input type="hidden" value="${key}" name="idioma" />`;
  
  var slider = sliders[key];
  
  if(slider){
    var values = JSON.parse(slider.detalles);
    console.log(values);
    for(var i = 0;i<values.length;i++){
      html_form += retornaForms(values[i].titulo,values[i].subtitulo,values[i].destino,values[i].imagen);

    }
  } else {
    for(var i = 0;i<limite;i++){
      html_form += retornaForms();
 
    }
  }

  contenedor_form.html(html_form);
  guardar_btn.removeAttr('disabled');
  add_btn.removeAttr('disabled');
});
/* btn agregar form slider */
add_btn.click(function(){
  contenedor_form.append(retornaForms());
});
/* boton de guardar */
guardar_btn.click(function(){
  var datos = contenedor_form.find('input');
  var exito = true;
  datos.each(function(key){
      if(!this.value){
        $(this).css('border-color','red');
        exito = false;
      } else {
        $(this).css('border-color','green');
      }
  });
 // si todo los inputs tienen valor entoces se procede a guardar
  if(exito){
    $.post('<?=base_url();?>admin/slider_index/regedit_slider',datos.serializeArray(),function(result){
      if(!isNaN(result)){
        alert('Guardado correctamente');
      } else {
        alert('errores al guardar');
        
      }
      console.log(result);
    });
  }
  
});
 
////// botones de control //////
contenedor_form.on('click','.btn-danger',function(){
   if(confirm('Seguro de eliminar?'))$(this).parents('.form_parent').remove();
});
////////////////////////////////////funcion para mover DOM//////////////////////////////
contenedor_form.on('click','.pull-up-down span',function(){
    var elemento = $(this).parents('.form_parent');
    var elemento_anterior = elemento.prev();
    var elemento_siguiente = elemento.next();
    if(!$(this).index()) elemento.insertBefore(elemento_anterior);
    else  elemento.insertAfter(elemento_siguiente);
});
////////// boton buscar servicios //////////////////////
contenedor_form.on('click','.btn-info',function(){
  vista_servicios.modal('show');
  
  inputs = $(this).closest('.form_parent').find('input');
  //inputs.css('background','red');
  console.log(inputs);

});


vista_servicios.on('click','.btn-primary',function(){
     //alert(lista_servicios.val());
     var valores = servicios[lista_servicios.val()];
    
     var id_idioma = $('input[name=idioma]').val();

     var valores = servicios[lista_servicios.val()];
     valores = valores[id_idioma]?valores[id_idioma]:valores[1];
     
     
     inputs[0].value = valores.titulo_pagina;
     inputs[1].value = valores.descripcion_pagina;
     inputs[2].value = valores.url_servicio;
     inputs[3].value = 'https://web.incalake.com/galeria/admin/full-slider/'+valores.carpeta_archivo+'/'+valores.url_archivo;
  });
})();
</script>
<style>
#contenedor_form > div{
  margin-top:10px;
  padding:5px;
  border-radius:5px;
}
#contenedor_form > div:nth-child(even){
  background:#e9e9e9;
}
#contenedor_form > div > div{
  margin-top:5px;
}
/*botones para mover posicion*/
.pull-up-down{
  width:10px;
  position:relative;
  left:10px;
  top:20px;
  float:right;
  z-index:30;
}

.pull-up-down span{
  color:#6a6a00;
  cursor: pointer;
}
.pull-up-down span:hover{
  color:#aaaa00;
}
tr.activo{
  background:#e6ffe6 !important;
}
</style>