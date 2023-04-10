<?php
// funcion para retornar html con toda las politicas
function retornarPoliticas($ruta,$idiomas){
 	// global $ruta;
   $html = null;
  // obtener las politicas en sus respectivos idiomas
 	foreach($idiomas as $value){ 
  // obtener la ruta completa en su respectivo idioma	
   $file = $ruta.$value['codigo'].'.txt';
  // variable que contiene la politica en texto
   $texto = null;
  // si archivo existe 
 	if(file_exists($file)){
      // abrir el archivo
      $myfile = fopen($file, "r");
      // leer archivo
      $texto = @fread($myfile,filesize($file));
      // cerrar boofer
	    fclose($myfile);
  }
    // add html de la politica en su idioma respectivo
    $html .= '<div class="col-md-6"><div class="panel panel-default">
		      <div class="panel-heading"><span class="panel-titulo">'.$value['pais'].' </span>
		       <button  style="float:right;margin:-5px 0 0 0" class="btn btn-success openModal" type="button">
		        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
 			   </button>
 			  </div>
		      <div class="panel-body"><textarea name="politicas_text['.$value['codigo'].']" rows="5" disabled class="form-control">'.$texto.'</textarea></div>
		    </div></div>';
  }	
  return $html;
 }
?>
<div class="container">
  <!-- html de las politicas -->
	<?=retornarPoliticas($ruta,$idiomas);?>
  <!-- fin html de las politicas -->
  <!-- modal lanzado para editar una politica -->
  <div class="modal fade" id="modal_editar" role="dialog">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-size: 15px">Editar politicas</h4>
        </div>
        <div class="modal-body">
          <p>Al parecer hubo un error.</p>
        </div>
        <div class="modal-footer">
          <span class="estado" style="color:#777"></span>
          <button type="button" class="btn btn-success" onclick="actualizarDatos($(this));"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- fin del modal para editar una politica -->
  
</div>
<script>
/*configuracion del CKeditor*/
CKEDITOR.config.toolbar = [
   ['Styles','Format','Font','FontSize'],
   '/',
   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
   '/',
   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
   ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
] ;
/*fin de la configuracion del CKeditor*/
    // el modal
    var el_modal = $('#modal_editar'),
    // cuerpo del modal
    modal_body = el_modal.find('.modal-body'),
    // titulo del modal
    modal_title = el_modal.find('.modal-title'),
    // ubicado al costado del boton de Guardar (su funcion es solo mostrar alertas)
    estado = el_modal.find('.estado');

  // al hacer click se nos mostrara un modal para posterior modificacion                
	$('.openModal').click(function(){
    // cambiar la alerta para indicar que se esta editando..
		estado.text('Editando');
    //  obtener el panel desde donde se hizo el click
		var panel_parent = $(this).parents('.panel');
    // cambiar el titulo del modal 
		modal_title.html('EDITAR POLITICAS PARA EL IDIOMA <b>'+panel_parent.find('.panel-titulo').text()+'</b>');
    // en el contenido del modal mostrar el CKeditor con el texto de la politica que se esta editando
		modal_body.html(panel_parent.find('textarea').clone().removeAttr('disabled').attr('rows','20').attr('id','ckedit')).focusin(function(){estado.text('')});
    // para evitar errores ckeditor
    CKEDITOR.replace('ckedit');
		// lanzar el modal
		el_modal.modal();
	});
	/*funcion para colectar datos y hacer una peticion ajax guardando cambios*/
	function actualizarDatos(element){
		 // deshabibiliar el boton de guardado para evitar el doble click
		 element.attr('disabled','disabled');
		 estado.text('Guardando...');
     //actualizar valores del CKeditor al texarea
     for (instance in CKEDITOR.instances )CKEDITOR.instances[instance].updateElement();
     // obtener el text area dentro del modal
		 var data = modal_body.find('textarea').serializeArray();
     // console.log(data);   
		 $.post("<?=base_url(uri_string());?>", data, function(result){
           // si resultado es un numero
           if(!isNaN(result)){
              // actualizar datos del textarea correspondiente al idioma editado
           		$('textarea[name="'+data[0].name+'"]').text(data[0].value);
              // notificar exito
           		estado.text('Guardado con exito.').css('color','#49AA8F');
           } else estado.text('Error al guardar.').css('color','#B15057');
           // habilitar de nuevo el boton guardar independientemente si hugo exito o no
           element.removeAttr('disabled');
   		 });
	}
 /* fin del script */
</script>