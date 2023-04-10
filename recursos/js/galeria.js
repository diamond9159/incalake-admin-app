(function(){
//base_url = 'http://localhost/cms/';
var recursoPHP = base_url+'recursos/ajax/getimg.php';
var modalGaleria,galeriaActual,inputGaleria,medidasImagen,$sidebarCarpetas,$fileShower,btnSeleccionarArchivo;//contenedor de vista de archivos
function modalGaleriaHTML(tipo){//tipo si es true o num 0 es que se usara en un FORM, y false o num -1 para usarlo solo para gestion de archivos
  return '<div id="modalGaleria" class="modal fade" role="dialog">'+
  '<div class="modal-dialog modal-lg">'+
    '<div class="modal-content">'+
      '<div class="modal-header">'+
        '<button type="button" class="close" onclick="eliminarModal(false);">&times;</button>'+
        '<h4 class="modal-title">Galeria de Archivos</h4>'+
      '</div>'+
      '<div class="modal-body tab-v1">'+

      '<ul class="nav nav-tabs">'+
      '<li class="active"><a data-toggle="tab" href="#carpetasGaleria">Carpetas y Archivos</a></li>'+
      '<li><a data-toggle="tab" href="#formSubidaGaleria">Subir Archivo</a></li>'+
      '<li><a data-toggle="tab" href="#crearCarpetaTAB">Crear Carpeta</a></li>'+
      '</ul>'+

    '<div class="tab-content" style="padding:0">'+
    '<div id="carpetasGaleria" class="tab-pane fade in active">'+
           '<ul id="carpetasNavGaleria"></ul>'+
           '<div id="contenedorGaleriaModal">'+
          '</div><div style="clear:both"></div>'+
    '</div>'+
    '<div id="formSubidaGaleria" class="tab-pane fade">'+
    '</div>'+
     '<div id="crearCarpetaTAB" class="tab-pane fade">'+
    '</div>'+
    '</div>'+


      '</div>'+
      '<div class="modal-footer">'+
        '<span id="nombreImagenGaleriaModal" value="">...</span>&nbsp;&nbsp;'+
        '<button type="button" class="btn btn-primary" id="btnSeleccionar" '+(tipo?'disabled':'')+' onclick="eliminarModal('+(tipo?'true':'false')+')">'+(tipo?'Seleccionar':'Cerrar')+'</button>'+
      '</div>'+
    '</div>'+
  '</div>'+
'</div>';
}
////////////////////////////////////
//////////////////////////////////////////////////
function adddesc(){
  /*agregar idiomas al select*/
      if(!htmlIdiomas.length){
        $.ajax({url: recursoPHP+'?getidiomas',async:false, success: function(result){
           if(result != 'session'){ 
            var dato = JSON.parse(result);
            for(i in dato) htmlIdiomas += '<option value="'+dato[i].codigo+'">'+dato[i].pais+'</option>';
           } else alert('Error obteniendo idiomas puede que su session haya expirado.');
          
        }});
      }

   /*fin agregar idiomas al select*/
   var deschtml =  '<div><select class="form-control" required name="idioma_archivo[]"><option value="">--Idioma--</option>'+htmlIdiomas+'</select><input class="form-control" name="titulo_archivo[]" placeholder="Nombre del archivo" required type="text"  /> <span class="detallesclosser btn btn-danger btn-sm" onclick="$(this).parent().remove()" class="btn btn-danger"><span class="fa fa-close"></span></span><p class="textarea"><textarea name="descripcion_archivo[]" class="form-control" placeholder="Descripcion del archivo"></textarea></p></div>';
   $('#descripciones_imagenes').append(deschtml);

}
/////////////////////////////////////////////////////////
  function validarTamanio(){
    var elem = this;
    function cambiaurl(){document.formSubida.url_archivo.value = (elem.value.split('\\').pop().split('.')[0]);}
   // if(medidasImagen!=undefined){
       var _URL = window.URL || window.webkitURL;
      
        var file, img;
        if ((file = elem.files[0])) {
            img = new Image();
            img.onload = function () {
              //if(this.width!=medidasImagen[0] || this.height!=medidasImagen[1]){
              if(this.width<this.height){
                elem.value = '';
               // alert('Las medidas aceptadas para este tipo de imagen son las siguientes: '+medidasImagen[0]+'*'+medidasImagen[1]);
                  alert('El alto no puede ser mayor al ancho, por favor seleccione otra imagen.');
             } else cambiaurl();
               // alert(this.width + " " + this.height);
            };
            img.src = _URL.createObjectURL(file);
        }

   // } else cambiaurl();
  }
/////////////////////////////////////////////////
function formularioDeSubida(options){
///////////////////////////
    return '<form name="formSubida" action="recursoPHP.php" method="post">'+
    '<div class="alert-warning">En el select de Carpeta seleccione la carpeta de destino si esta cuenta con sub-carpetas puede seleccionar una, de no seleccionar una sub-carpeta se guardar&aacute; en la carpeta principal, Luego en el campo de texto ingrese la url de esta ejemplo: uros-paisaje, muy importante no usar caracteres especiales y no ingresar la extencion o tipo de archivo (.png, .jpg, .doc, .pdf).</div>'+
    '<input name="file" type="file" required accept="'+(/(0|5|7)/.test($folder)?'.doc,.docx,.pdf':'image/x-png,image/jpeg')+'"  />'+
    '<select required class="form-control"  id="carpetaselect" name="carpetaselect" >'+options+'</select>'+
    '<select required class="form-control"  id="subcarpetaselect" name="subcarpetaselect" disabled><option value="">Sub Carpeta</option></select>'+
    '<input class="form-control" pattern="[a-zA-Z0-9\-\_]{2,50}" maxlength="50" id="url_archivo" name="url_archivo" placeholder="URL del archivo ej: mi-archivo-prueba (Opcional)" type="text"  />'+
    '<input class="btn btn-success" type="submit" value="Subir" name="btn_subir" />'+
        '<div style="clear:both;border-bottom:1px solid #EEE;padding:5px 0 5px 0;height:45px"><input type="button" class="btn btn-warning" name="adddesc" value="Agregar Descripcion" /></div>'+
    '<div id="descripciones_imagenes" ></div>'+
    '</form>'
}
htmlIdiomas = '';
function formCrearCarpetas(){
    return '<form class="upCarpeta">'+
             '<div class="alert-warning">Caracteres aceptados para crear carpetas: (A-Z,a-z,0-9, Guiones y Subguiones), en caso de no seleccionar ninguna carpeta se crear&aacute; una carpeta independiente.</div><br>'+
             '<input pattern="[a-zA-Z0-9\-\_]{2,50}" class="form-control" placeholder="Ingrese Nueva Carpeta" id="nuevacarpeta" name="nueva_carpeta" type="text" required   /><label> Crear dentro de: </label><select class="form-control" name="folderPrincipal" id="folderPrincipalSelect"></select>'+
             '<input style="margin:0 5px 0 5px" class="btn btn-warning" type="submit" value="Crear" />'+
           '</form><div style="clear:both"></div>';
}
function crearCarpeta(event){
  event.preventDefault();
  var nueva_carpeta = $('#nuevacarpeta').val();
  var folderPrincipalSelect = $('#folderPrincipalSelect').val();
  var validador = true;
    if(folderPrincipalSelect.length){
      for(i in $carpetas[folderPrincipalSelect])if(i==nueva_carpeta){validador = false;break;}
    } else for(i in $carpetas)if(i==nueva_carpeta){validador = false;break;}

       if(validador){
          $.post(recursoPHP+'?crearCarpeta', { folder: $folder, nuevacarpeta: nueva_carpeta,folderPrincipal:folderPrincipalSelect },function(result) {
            if(!isNaN(result)){
                if(parseInt(result)){
                    alert('La carpeta "'+nueva_carpeta+'" ha sido creado satisfactoriamente.');
                    obtenerListaDeCarpetas();
                }
                else alert('Errores al crear carpeta, Intente de nuevo.');
            } else alert('Error: session expirada.');

            });

       } else alert('Ya existe una carpeta o subcarpeta con ese nombre');
    
       
}
/*buscar subcarpetas al cambiar select de carpetas*/
function cambiarSelectSubcarpeta(){
  var carpeta = this.value;
  var subElem = $('#subcarpetaselect');
  var options = '';
  subElem.removeAttr('disabled');
  if(carpeta.length) for(i in $carpetas[carpeta])options += '<option value="'+carpeta+'/'+i+'">'+i+'</option>';
  if(!carpeta.length || !options.length) subElem.attr('disabled', 'disabled');
  
  subElem.html('<option value="'+carpeta+'">--Sub Carpeta--</option>'+options);
}
/*fin de buscar de subcarpetas*/
function obtenerListaDeCarpetas(){
  $fileShower.html('<center id="textoTemporalGaleria">Galeria de archivos de incalake</center>')
  $sidebarCarpetas.html('<center><img src="'+base_url+'recursos/img/ajax-loader.gif" style="position: relative;top:130px" /></center>');
     $.ajax({url: recursoPHP+'?getCarpetas='+$folder,async:true,cache:false, success: function(result){
       if(result != 'session'){
          var $options = '<option value="">--Carpeta--</option>';
          $carpetas = JSON.parse(result);
          $lies = '';
         // for(i in dato) htmlIdiomas += '<option value="'+dato[i].codigo+'">'+dato[i].pais+'</option>';
          for(i in $carpetas){
            var submenu = '';
            for(e in $carpetas[i])submenu+='<li data-folder="'+i+'/'+e+'"><span class="fa fa-folder"></span> '+e+'</li>';
            if (submenu.length)submenu='<ul class="subfolders">'+submenu+'</ul>';

            $options += '<option value="'+i+'">'+i+'</option>';
            $lies += '<li data-folder="'+i+'" ><span class="fa fa-folder"></span> '+i+submenu+'</li>';
          }
          
          $('#formSubidaGaleria').html(formularioDeSubida($options));
          document.formSubida.onsubmit=uploadImages;//sunir dorm
          document.formSubida.file.onchange=validarTamanio;//validar tamanio
          document.formSubida.carpetaselect.onchange=cambiarSelectSubcarpeta;
          document.formSubida.adddesc.onclick = adddesc;
//////////////////////////////////////////////////////////////////////////////////////////////////
          $('#folderPrincipalSelect').html($options);//select que se muestra al crear nueva carpeta
          //var $navFolders = $sidebarCarpetas;
          $sidebarCarpetas.html($lies.length?$lies:'<p style="padding:5px;color:#DDD">No tiene carpetas.</p>');
          $sidebarCarpetas.find('li').click(cambiaCarpeta);

          $sidebarCarpetas.find('.subfolders li').click(function(event) {
             $(this).siblings('li').removeClass('subfolderactive');
             $(this).addClass('subfolderactive');
          });
       } else alert('Error: al parecer su session ha expirado');
       
               
     }});
}  

   openGaleria = function(actualButton,folder,titulo,medidas){// si es multi son varios selects dinamicos, medidas= array[ancho,alto]
    if(medidas instanceof Array) medidasImagen=medidas;else medidasImagen=undefined;
    galeriaActual = actualButton;
    inputGaleria = galeriaActual.siblings(".inputHideImagenModal");//input oculto, si no tiene se mostrara boton cerrar.
    //alert(inputGaleria.length);
    $folder = folder; // hacer de esta carpeta accesible ya que es la parpeta que determina si es slider o minislider
    $('body').append(modalGaleriaHTML(inputGaleria.length));
    
    mostradorMensajeGaleria = $('#nombreImagenGaleriaModal');
    modalGaleria = $('#modalGaleria');
    modalGaleria.find('.modal-title').html('Galeria de '+(/(0|5|7)/.test($folder)?'Documentos':'Im&aacute;genes')+' <i style="color:#80A4B8">('+(titulo?titulo.trim():'*')+(medidasImagen?' :: '+medidasImagen[0]+' * '+medidasImagen[1]+'px':'')+(medidasImagen?(medidasImagen[3]?' :: '+medidasImagen[2]+' - '+medidasImagen[3]+' KB':''):'')+')</i>');//titulo modal

    var valorInput = galeriaActual.siblings(".inputImagenModal").attr('value');
  
    if(valorInput!=undefined)mostradorMensajeGaleria.html(valorInput.length?valorInput:'Seleccione su archivo');
    else mostradorMensajeGaleria.html('Click en un archivo para detalles.');

    modalGaleria.modal('show');
    modalGaleria.on('hidden.bs.modal', function () {$(this).remove();})//eliminar por completo cuando modal desparece
    btnSeleccionarArchivo = $('#btnSeleccionar');

    //btnSeleccionarArchivo.attr('disabled','disabled');

   // obtenerImagenesAjax();

    $sidebarCarpetas = $('#carpetasNavGaleria');//navegador de archivos
    $fileShower = $('#contenedorGaleriaModal');//contenedor de vista de archivos

 $('#crearCarpetaTAB').html(formCrearCarpetas());//CREAR FORM DE CREAR CARPETAS
 $('.upCarpeta').submit(crearCarpeta);
 //obtenerListaDeArchivos(true);
 obtenerListaDeCarpetas();
    //fin de las funciones para subir imagenes
    return false;
  }
  //////////////////////////////////fin open galeria ////////////////////////////////////////

 //funcion de subir imagenes//
 function uploadImages(){
    //var nueva_carpeta = $('#nuevacarpeta').val()
    var formulario = this;
/////////////////////
    var url_archivo = formulario.url_archivo.value;//$('#url_archivo').val();
    var carpetaselect =  formulario.carpetaselect.value;//$('#carpetaselect').val();
    var subcarpetaselect = formulario.subcarpetaselect.value;//$('#subcarpetaselect').val();
        subcarpetaselect = subcarpetaselect.split('/');
    var validador = true;
    //var datosArray = null;
    //evitar que se dupliquen nombres de archivos tanto en carpetas y subcarpetas
    if(subcarpetaselect.length==2){
      for(i in $carpetas[carpetaselect][subcarpetaselect[1]]){
          if($carpetas[carpetaselect][subcarpetaselect[1]][i].split('.')[0]==url_archivo){
            validador = false;
            alert('Ya existe un URL de archivo similar en la subcarpeta seleccionada');
            break;
          }
      }

    } 
    /*si todo esta conforme se procede a la busqueda de imagenes.*/
   if(validador){
    console.log(new FormData(formulario));
    $('#formSubidaGaleria').html('<img style="display:block;margin:5px auto 5px auto" src="'+base_url+'recursos/img/ajax-loader.gif" /><br><div class="alert alert-warning">Subiendo el archivo espere por favor...</div>');
   //llamada ajax para el procesamiendo de datos//
      $.ajax({
        url: recursoPHP+'?folder='+$folder,
        type: "POST",
        data:  new FormData(formulario),
        contentType: false,
        processData:false,
        success: function(data)
          {  console.log(data);
             if(!isNaN(data)){
                var mensaje = '<div class="alert alert-danger">El archivo tuvo errores al subir por favor cambie de nombre al archivo o intente de nuevo.</div>'
                if(data=='1') mensaje ='<div class="alert alert-success">El archivo se subio de manera correcta, puede a&ntilde;adir otro archivo pulsando el boton de Subir otro archivo</div>';
             } else var mensaje = ('Error: al parecer su session se encuentra expirada.');


             $('#formSubidaGaleria').html(mensaje+'<button class="btn btn-warning" id="upOtroArchivo">Subir otro archivo</button><div>&nbsp;</div>');
             $('#upOtroArchivo').click(obtenerListaDeCarpetas);
            // obtenerListaDeCarpetas();//actualizar carpetas
          },
          error: function(){ alert('Error desconocido al subir, puede deberse a que su session  ha expirado.');}
       });
     //fin del ajax
   }
    return false;
 }
 ////////////////////////////////////////////////////
 function cambiaCarpeta(event){
     event.stopPropagation();
     var elemento = $(this);
     elemento.siblings('li').removeClass('folderactive');
     elemento.addClass('folderactive');
     $('.subfolders li').removeClass('subfolderactive');
     //alert(contenedor.innerHeight());
         $fileShower.html('<img style="display:block;margin:'+($fileShower.innerHeight()/3)+'px auto 5px auto" src="'+base_url+'recursos/img/ajax-loader.gif" />');

      $.ajax({
        url: recursoPHP+"?getArchivos="+$folder+"&customfolder="+elemento.data('folder'),
        async: false,
        cache:false,
        success: function(datos){if(datos != 'session')procesarArchivos(JSON.parse(datos));else alert("Error: su session ha expirado.");}
      });
    
    function procesarArchivos(datos){
      var html = '';
         for(i in datos){
            //var detallesIMG = datos[i]['detalles_imagen'];alert(detallesIMG);
            var title = datos[i].url_archivo;
            if(datos[i]['detalles_archivo']){
              var detallesIMG = JSON.parse(datos[i]['detalles_archivo']);
                  title = detallesIMG.ES!=undefined?detallesIMG.ES.titulo:title;
            }
            if(!(/(0|5|7)/.test($folder)))html += '<img onclick="cambiarValue(this);" ide="'+datos[i]['id_galeria']+'" title="'+title+'" class="img-thumbnail resultRow" width="150" src="http://incalake.com/apps-incalake/web/galeria/'+datos[i].user+'/'+datos[i].tipo_archivo+'/'+datos[i].carpeta_archivo+'/thumbs/'+datos[i].url_archivo+'" />';
            else {
              var extencion = datos[i].url_archivo.split('.')[1];//para detectar y mostrar el icono correcto de font awesome
              switch(extencion){
                case 'pdf' : extencion = 'pdf';iconColor='#C14838';break;
                case 'doc' : extencion = 'word';iconColor='#386BC1';break;
                case 'docx' : extencion = 'word';iconColor='#386BC1';break;
                default : extencion = 'code';iconColor='#9C9C9C';break;
              }
              html+= '<div onclick="cambiarValue(this);" title="'+title+'" ide="'+datos[i]['id_galeria']+'" class="docRow resultRow"><span class="fa fa-file-'+extencion+'-o" style="color:'+iconColor+'"></span> '+datos[i].url_archivo+'</div>';
            }
         }

         $fileShower.html(html.length?html:'<span style="color:#777">No hay archivos en esta carpeta.</span>');
      //   alert(datos.length);
  }
     
 }
 //funcion que se ejecuta al hacer click en las imagenes
cambiarValue = function(elemento){
          // var mostrador = $('#nombreImagenGaleriaModal');
          $fileShower.find('.resultRow').css('background','white');
           elemento.style.background = !(/(0|5|7)/.test($folder))?'orange':'#E8E8FF';
           mostradorMensajeGaleria.html(elemento.title);
           mostradorMensajeGaleria.attr('value',elemento.getAttribute('value'));
           mostradorMensajeGaleria.attr('ide',elemento.getAttribute('ide'));
           btnSeleccionarArchivo.removeAttr('disabled');
}
///////////////////////////////

    eliminarModal = function(tipo){ //tipo = true y false : si es true se cambia el input de lo contrario no

           modalGaleria.modal('hide');
          /* modalGaleria.on('hidden.bs.modal', function () {
              //modalGaleria.html('');
              modalGaleria.remove();
            });*/
        if(tipo){

          galeriaActual.siblings(".inputImagenModal").attr('value',mostradorMensajeGaleria.html());
          inputGaleria.attr('value',mostradorMensajeGaleria.attr('ide'));

        }
   }
})();