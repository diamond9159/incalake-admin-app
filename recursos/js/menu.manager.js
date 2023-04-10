    var container = $('.panel-group');
    var el_modal = $('#myModal');
    var titulo_modal = el_modal.find('.modal-title');
    var nombre_es = el_modal.find('input[name=\'nombres[ES]\']');
    var nombre_menu = el_modal.find('#nombre_menu')[0];
    var check_relacionar = $('#check_relacionar');
    var check_nueva_ventana = $('input[name=nueva_ventana]');
    var select_servicio = $('#select_servicio');
    var id_menu = $('input[name=id_menu]');
    var parent_menu = $('input[name=parent_menu]');
    var fa_icon = $('#fa_icon');
    var nombres_inputs = el_modal.find('input[name*=nombres]');
    var urls_inputs = el_modal.find('input[name*=urls]');
    var fondo_input = el_modal.find('input[name=color_menu]');
    //var msj_estado = el_modal.find('.msj-estado');
      /*eliminar un link menu*/
        container.find('.btn-danger').click(function(){
          if(confirm('¿Seguro de eliminar?')){
            var parent = $(this).parents('.panel').eq(0);
            var getid = parent.data('id');
            
            $.post("menu/eliminar_menu",{id:getid}, function(data){
          if(!isNaN(data)){
            if(parseInt(data)){
              alert('Eliminado con exito!');
              parent.remove();
              //console.log($(this).parents('.panel').eq(0));
            } else alert('Problemas para eliminar');
          } else alert('Errores en el servidor');

        });
          }
        });
        /*editar un link menu*/
        container.find('.btn-primary').click(function(){
          resetModal();//vaciar campos
          
          //console.log(json_links[$(this).data('parent')]);
          //console.log(panel_padre.find('h4')[0].innerText);
          var array_actual = json_links[$(this).parents('.panel').eq(0).data('parent')][$(this).data('key')];
          //console.log(array_actual);
          var nombre_temp = array_actual.menu_name;
          titulo_modal.text('Modificando: '+ array_actual.menu_name);

          id_menu.val(array_actual.menu_id);//id del menu es en caso de editar
          parent_menu.val(array_actual.parent_id);//id donde pertenece el menu en caso cero es primer nivel
          nombre_menu.value = nombre_temp;
          nombre_es.val(nombre_temp);
          fa_icon.attr('class',array_actual.icono);
          fondo_input.val(array_actual.background?array_actual.background:'#FFFFFF');
          //alert(array_actual.target);
          if(array_actual.target!=0)check_nueva_ventana.prop('checked', true);//activar si esta configurado asi
          if(array_actual.cod_servicio!=null){
            check_relacionar.prop('checked', true);
            select_servicio.removeAttr('disabled');
          }

          select_servicio.html(retorna_options_servicio(array_actual.cod_servicio));
          
          //console.log(JSON.parse(array_actual.idiomas_url));
          var idiomas_url = JSON.parse(array_actual.idiomas_url);
          var idiomas_nombre = JSON.parse(array_actual.idiomas_nombres);
          //console.log(idiomas_nombre);
          /*cambiar valores de urls y nombres*/
          nombres_inputs.each(function(i){
        var nombre = idiomas_nombre?idiomas_nombre[$(this).data('lang')]:'';
        var url = idiomas_url?idiomas_url[$(this).data('lang')]:'';
        urls_inputs[i].value=url?url:'';
        //var valor  = json_servicios[id_servicio][$(this).data('lang')].titulo_pagina;
        $(this).val(nombre?nombre:'');
        el_modal.modal();
          });
        });
        /*agregar un link menu*/
         container.find('.btn-success').click(function(){
          resetModal();
          titulo_modal.append(' a: '+$(this).parents('.panel').eq(0).find('.panel-title a').eq(0).text());
          select_servicio.html(retorna_options_servicio(0));
          parent_menu.val($(this).parents('.panel').eq(0).data('id'));
          el_modal.modal();
         });
         function resetModal(){
          titulo_modal.text('Agregando menu');
          fa_icon.removeAttr('class');
          nombre_menu.value = '';
          nombres_inputs.val('');
          urls_inputs.val('');
          fondo_input.val('#FFFFFF');
          check_nueva_ventana.prop('checked', false); 
          check_relacionar.prop('checked', false);
          //select_servicio.val('');
          select_servicio.attr('disabled','disabled');
          id_menu.val(0);
          parent_menu.val(0);
         }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function retorna_options_servicio(selected){
      var options_servicio = '';
        $.each(json_servicios,function(element,value) {
          //console.log(value['ES']);
       options_servicio += '<option '+(selected==element?'selected':'')+' value="'+element+'">'+value[Object.keys(value)[0]].titulo_pagina+'</option>';
  
    });
    return options_servicio;
     }
     
     
     /*agregar evento onchange*/
     select_servicio.change(function(){
      var id_servicio = $(this).val();
      //console.log(json_servicios[this.value]);
      //cambiar el nombre en español principal
      nombre_menu.value=json_servicios[id_servicio]['ES']?json_servicios[id_servicio]['ES'].titulo_pagina:'';
      //recorrer todo los campos inputs y colocar los valores correspondientes
      nombres_inputs.each(function(i){
        var array = json_servicios[id_servicio][$(this).data('lang')];
        urls_inputs[i].value=array?array.url_servicio:'';
        //var valor  = json_servicios[id_servicio][$(this).data('lang')].titulo_pagina;
        $(this).val(array?array.titulo_pagina:'');
      });
     });
     /*fin funcion para cambiar valores del form*/
     var btn_guardar = $('#btn_guardar');
     btn_guardar.click(function(){
      var dataform = $('#form_principal').serializeArray();
      var icono = fa_icon.attr('class');
          dataform.push({name:'icono',value:icono!='iconpicker-component'?icono:''});
      var button = $(this);
      button.attr('disabled','disabled').text('Guardando..');
      console.log(dataform);
      $.post( "menu/regedit_menu",dataform, function(data){
       // console.log(data);
         if(!isNaN(data)){
            if(parseInt(data))button.text('Guardado');
            else {
              button.removeAttr('disabled').text('Guardar');
              alert('Problemas para guardar');
            }
       } else {
        button.removeAttr('disabled').text('Guardar');
        alert('Errores en el servidor');
       }

    });
     });
     check_relacionar.change(function(){
      if($(this).is(':checked'))select_servicio.removeAttr('disabled');
      else select_servicio.attr('disabled','disabled');
     });
    

    el_modal.on('hidden.bs.modal', function() { 
    if(btn_guardar.attr('disabled'))location.reload();
   });
    ////////////////////////////////////funcion para mover DOM//////////////////////////////
  var arrow_buttons = $('.pull-up-down span');
  arrow_buttons.click(mover);
  function mover(){
      var _this = $(this);
      var elemento = _this.closest('.panel');
      var posicion = elemento.index();
      var elemento_anterior = elemento.prev();
      var elemento_siguiente = elemento.next();
      arrow_buttons.unbind("click");

      //console.log(elemento.data()); // obtiene todo los datas lo usare para enviar como data
      var datos = {
        parent: elemento.data('parent'),
        id_elemento: elemento.data('id'),
        rel_actual: elemento.data('relevancia'),
        rel_anterior: elemento_anterior.data('relevancia'),
        rel_siguiente: elemento_siguiente.data('relevancia'),
        direccion: _this.index()
      }
      //console.log(datos);
       /*enviando ajax para reordenar relevancia*/
       $.post( "menu/modificar_relevancia",datos, function(data){
            //console.log(data);
            if(!isNaN(data)){
              if(parseInt(data)){
                /*cuando todo este bien recien mover*/
                 if(!_this.index()){
                  //console.log(elemento.data());
                  elemento.data('relevancia',datos.rel_anterior);
                  //console.log(elemento.data());
                  elemento_anterior.data('relevancia',datos.rel_actual);
                  elemento.insertBefore(elemento_anterior);
                } else {
                  elemento.data('relevancia',datos.rel_siguiente);
                  elemento_siguiente.data('relevancia',datos.rel_actual);
                  elemento.insertAfter(elemento_siguiente);
                }
                /*finnn*/
              } else alert('No se pudo modificar relevancia');
            } else alert('errores en el servidor.');
            arrow_buttons.bind("click",mover);//volver habilitar botones
       });
 }
/*ahora generamos menu JSON*/
$('#generarJSON').click(function(){
   $.ajax({
      type: 'GET',
      url: 'menu/generar_json',
      cache:false,
      success: function(data){
        if(!isNaN(data)){
          $( '#menu_frame' ).attr( 'src', function ( i, val ) { return val; });
          //document.getElementById('menu_frame').contentDocument.location.reload(true);
          alert('Se actualizó el menu correctamente');
        }
        else alert('Errores en el servidor');
      }
    });

});