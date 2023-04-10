<?php
  //var_dump($idiomas);
?>
<div class="container">
   <div class="col-md-6">
    <div class="panel panel-primary">
      <div class="panel-heading">Nombre de paginas <button id="add_name" class="btn btn-success" type="button">Agregar nombre de pagina</button></div>
      <div class="panel-body">
        <table class="table" id="tabla_nombres">
         <tr><th>Nombre</th><th>#</th></tr>  
        </table>
      </div>
    </div>
   </div>
   <div class="col-md-6">
    <div class="panel panel-primary">
      <div class="panel-heading">Lista detallada paginas 
      <div class="dropdown pull-right" style="margin-top:-5px">
        <button class="btn btn-success dropdown-toggle" type="button" id="add_pagina" data-toggle="dropdown">Agregar Pagina
        <span class="caret"></span></button>
        <ul class="dropdown-menu">

        </ul>
      </div>
      </div>
      <div class="panel-body">
        <p>* Ninguna pagina seleccionada</p>
        <table style="display:none" class="table" id="tabla_paginas">
         <tr>
           <th>Titulo</th>
           <th>Idioma</th>
           <th>#</th>
        </tr>  
        </table>
      </div>
    </div>
   </div>
</div>


 <!-- inicio del modal de para setear pagina -->
 <div id="modal_form" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:95%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Páginas HTML</h4>
      </div>
      <div class="modal-body">
        <input name="idioma" type="hidden" value="0" />
        <input name="pagina" type="hidden" value="0" />
        <input name="id" type="hidden" value="0" />
        
        <div>
          <div class="col-md-2">
            <label>Titulo de la Pagina</label>
          </div>
          <div class="col-md-5">
            <input class="form-control" name="titulo" type="text" />
          </div>
          <div class="col-md-2">
            <label>Palabras Clave (Keywords)</label>
          </div>
          <div class="col-md-3">
            <input class="form-control" name="keywords" type="text" />
          </div>
          <div style="clear:both"></div>
        </div>

          <div  style="margin:10px 0 10px 0 !important">
          <div class="col-md-2">
            <label>Descripción</label>
          </div>
          <div class="col-md-5">
            <input class="form-control" name="descripcion" type="text" />
          </div>
          <div class="col-md-2">
            <label>URL</label>
          </div>
          <div class="col-md-3">
            <input class="form-control" name="url" type="text" />
          </div>
        </div>


        <div class="col-md-12"  style="margin-top:10px">
            <textarea id="html_editor" name="contenido"></textarea>
        </div>
        <div style="clear:both"></div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_guardar_html">Guardar</button>
      </div>
    </div>
  </div>
</div>
 <!-- fin del modal para setear vista previa -->


<script>
CKEDITOR.replace('html_editor');

/*funcion para registrar y editar el nombre de la pagina (agrupador)*/
(function(){
 // json nombres contiene el JSON de nombres que ya existen  
 var json_nombres = <?=json_encode($lista_nombres);?>;
 var idiomas = <?=json_encode($idiomas);?>;
 
 var tabla_nombres = $('#tabla_nombres');
 //ahora se crea una variable para asignar un valor un key a cada tr para su facil ubicacion en el JSON 
 var key_tr = 0;
 var tr_nuevo = function(nombre){
     return `<tr data-key="${key_tr++}">
               <td>${nombre}</td>
               <td width='150' style="padding-right:  0px;">
                    <button type='button' class='btn btn-info'><span class='fa fa-list'></span></button>
                    <button type='button' class='btn btn-success'><span class='fa fa-pencil'></span></button>
                    <button type='button' class='btn btn-danger'><span class='fa fa-close'></span></button>
                </td>
            </tr>
            `;
 }
//si hay nombres ya registrados entonces imprimirlos
 json_nombres.forEach(function(elem){
    tabla_nombres.append(tr_nuevo(elem.nombre_pagina)); 
 });
//funcion para agregar y editar luego envia por ajax
  function regEdit(value,id,elem){
    //elem solo se usara en la edicion de datos para evitar recarga
    if(value instanceof Object)value='';// si viene como objetos quedara como vacio
   // var valor =  value?value:'';
    var ide =  id?parseInt(id):0;// si id existe se enviara el ide para editar de lo contrario se envia 0
    var nombre_val = prompt('Ingrese nombre de pagina',value);
    if(nombre_val){
      $.post('<?=base_url();?>admin/paginahtml/regedit_nombres',{nombre:nombre_val,tipo:ide},function(result){
        //console.log(result);
        if(!ide){
          alert('Agregado correctamente');
          location.reload();
        }
        else {
           alert('Se ha editado correctamente.');
           elem.text(nombre_val);
        }
        
      });      
    }
    
 }
/*fin de la funcion*/
    $('#add_name').on('click',regEdit);
    //buscar paginas html relacionadas a este nombre
     tabla_nombres.on('click','.btn-info',buscarRelacionados);
    //editar
    tabla_nombres.on('click','.btn-success',function(){
        var tr = $(this).parents('tr');
        var elem = tr.find('td').eq(0);
        var datos = json_nombres[tr.data('key')];
       // console.log(ide);
       regEdit(datos.nombre_pagina,datos.id_pagina,elem);

     });
    //eliminar
    tabla_nombres.on('click','.btn-danger',function(){
         if(confirm('Seguro de que desea eliminar?')){
          var tr = $(this).parents('tr');
          var datos = json_nombres[tr.data('key')];

          $.post('<?=base_url();?>admin/paginahtml/eliminar_nombres',{id:datos.id_pagina},function(result){
            //console.log(result);
            if(!isNaN(result))tr.remove();
            else alert('No se puede eliminar hay errores en el servidor.');
          });   
         }
     });
//ahora una funciones para el control de idiomas, se busca idiomas asociadas a un nombre/titulo
var tabla_paginas = $('#tabla_paginas');
var modal_form = $('#modal_form');
var add_pagina = $('#add_pagina');// boton de agregar pagina

var alerta = tabla_paginas.siblings('p');
var tr_nuevo_paginas = function(key1,key2,titulo,idioma){
     return `<tr data-key1="${key1}" data-key2="${key2}">
               <td>${titulo}</td>
               <td><span class="flag flag-${idioma=='EN'?'us':idioma.toLowerCase()}"></span> ${idioma}</td>
               <td width="150">
                    <button type='button' class='btn btn-success'><span class='fa fa-pencil'></span></button>
                    <button type='button' class='btn btn-danger'><span class='fa fa-close'></span></button>
                </td>
            </tr>
            `;
 }
  function buscarRelacionados(){
    /* poner los idiomas correspondientes al menu idiomas */
    add_pagina[0].disabled = false;//activar boton agregar
    

    console.log(idiomas);
    var html_li = '';
    idiomas.forEach(function(elem){
        html_li += `<li data-idioma="${elem.id_idioma}"><a href="#">${elem.pais}</a></li>`;
    });
    add_pagina.siblings('ul').html(html_li);
    ////
    tabla_paginas.hide();
    var tr = $(this).parents('tr');
    var datos = json_nombres[tr.data('key')];

    var html_paginas = '';
    inputs[1].value = datos.id_pagina;//set id nombre de pagina en formulario del modal

    $.each(datos.pages,function(key2,value){
      html_paginas += tr_nuevo_paginas(tr.data('key'),key2,value.titulo,value.codigo);
      $('li[data-idioma='+value.id_idioma+']').remove();//eliminar del boton agregar el idioma que ya existe
    });
    //console.log(datos.pages);
    
    if(html_paginas){
      alerta.hide();
      tabla_paginas.find('tbody').html('');
      tabla_paginas.append(html_paginas);
      tabla_paginas.show();
    } else {
      alerta.show();
      alerta.text('* No hay paginas.');
    }
  }
 ///////////////////////////////// formulario de agregar pagina ////////////////////////////////////
 add_pagina[0].disabled = true;
 var inputs = $('#modal_form input,#modal_form textarea');

 add_pagina.siblings('ul').on('click','li',function(){
  inputs[0].value = $(this).data('idioma');//setear idioma
  inputs[2].value = 0;//0 para agregar y no enviar id para editar
  inputs[3].value = '';
  inputs[4].value = '';
  inputs[5].value = '';
  inputs[6].value = '';
  CKEDITOR.instances.html_editor.setData('');
  lanzarModal();
 });
/////////////// funcion para disparar el modal ////////////////
  function lanzarModal(){  
    inputs.css('border-color','#ccc');
    modal_form.modal('show');
    //console.log(inputs);
  }
  //////////// al precionar el boton guardar ////////////////
  $('#btn_guardar_html').click(function(){
    var exito = true;
    for (instance in CKEDITOR.instances )CKEDITOR.instances[instance].updateElement();// actualizar ckeditor

    inputs.each(function(){
      if($(this).val()==''){
        exito = false;
        $(this).css('border-color','red');
      }
    });

    // si es exitoso enviar peticion ajax
    if(exito){
      
      var datos = inputs.serializeArray();
      console.log(datos);
      $.post('<?=base_url();?>admin/paginahtml/regedit_pagina',datos,function(result){
        if(!isNaN(result)){
          alert('Guardado correctamente!.');
          location.reload();
        } else {
          alert('Errores al guardar.');
        }
      });
    } else {
      alert('Todo los campos son obligatorios.');
    }
    
  });
  // editar
  tabla_paginas.on('click','.btn-success',function(){
    var parent = $(this).parents('tr');
    var datos = json_nombres[parent.data('key1')]['pages'][parent.data('key2')];
    console.log(inputs);
   /* inputs[0].value = 0;
    inputs[1].value = 0;*/
    inputs[2].value = datos.id;
    inputs[3].value = datos.titulo;
    inputs[4].value = datos.keywords;
    inputs[5].value = datos.descripcion;
    inputs[6].value = datos.url;
    //inputs[7].innerHTML = datos.contenido;
    CKEDITOR.instances.html_editor.setData(datos.contenido);
    lanzarModal();
  });
  //eliminar
  tabla_paginas.on('click','.btn-danger',function(){
    var elem = $(this).parents('tr');
    if(confirm('Esta seguro de eliminar?')){
      var ide = json_nombres[elem.data('key1')]['pages'][elem.data('key2')]['id'];//obtener id de la pagina
      $.post('<?=base_url();?>admin/paginahtml/eliminar_pagina',{id:ide},function(result){
        if(!isNaN(result)){
          elem.remove();
        } else {
          alert('Errores al eliminar');
        }
        console.log(result);
      });
    }
  });
})();


</script>