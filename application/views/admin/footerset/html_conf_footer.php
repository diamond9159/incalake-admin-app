<div class="container">
    <div class="panel panel-primary" id="panel-set">
	  <div class="panel-heading">Configuraciones del footer 
	     <span class="pull-right">
	       <i class="fa fa-language" aria-hidden="true"></i> Idiomas &nbsp;
	        <select class=" pull-right" id="change_idioma">
	     	<?=retornarIdiomas($idiomas);?>
	       </select>
	     </span>
	  </div>
	  <div class="panel-body">
	    <?php for($i=1;$i<=6;$i++): ?>
	  	 <div class="col-md-4">
	  	      <div class="panel panel-default">
			  <div class="panel-heading">Seccion <?=$i;?> <i class="fa fa-arrows-h pull-right" title="ampliar" aria-hidden="true"></i></div>
			  <div class="panel-body">
	  	 	    <textarea name="seccion[]" class="form-control" rows="10"></textarea>
	  	 	  </div>
	  	 	  </div>
	  	 	  <div>
	  	 	  	
	  	 	  </div>
	  	 </div>
	   <?php endfor; ?>
	   <div class="col-md-12"><button id="btn_guardar" class="btn btn-success pull-right"><span class="fa fa-save"></span> Guardar</button></div>
	  </div>
	</div>
</div>
<style>

 #panel-set textarea{
 	resize: none;
  transition: all 1s;
 }
 #panel-set select{
 	padding:3px;
 	color:#444;
 }
 #panel-set .col-md-4{
  transition: all 1s;
 }
 .col-md-ampliado{
  width: 100%;
 }
 .col-md-ampliado textarea{
   background: #333;
   color:white;

 }
</style>
<script>
$(function(){
  var parent_node = $('#panel-set');
  var textareas = parent_node.find('textarea');
  var change_idioma = $('#change_idioma');
  var bloques = parent_node.find('.pull-right');//se usara para controlar ancho de las mismas
   //console.log(textareas.length);
  /* parent_node.find('.btn-success').click(function(){
  	 alert('guardando');
   });*/
   bloques.click(function(){
    $(this).closest('.col-md-4').toggleClass('col-md-ampliado');
   });
    //////////////////////////////////////////////////////////////
    function buscarIdioma(){
     var idioma = $(this).val();
    	if(html_secciones[idioma]){
    	   textareas.each(function(i){
    		$(this).val(html_secciones[idioma][i]);
    		//console.log($(this).val());
    	   });	
    	} else textareas.val('');
    }
   change_idioma.change(buscarIdioma).trigger('change');
   //textareas.text('<div>Probando textareas</div>');
   parent_node.find('#btn_guardar').click(function(event) {
   	 var this_button = $(this);
   	 this_button.attr('disabled', 'disabled');
   	 //alert(change_idioma.val());
   	 var datos = textareas.serializeArray();
   	     datos.push({name:'idioma',value:change_idioma.val()});
   	  $.post('<?=base_url(uri_string());?>',datos,function(result){
   	  	if(!isNaN(result)){
   	  		alert('Cambios guardados');
   	  		var nuevo_array = [];//para actulizar array anterior con los nuevo svalores guardados
   	  		textareas.each(function(){
   	  			nuevo_array.push($(this).val());
   	  		});
   	  		html_secciones[change_idioma.val()] = nuevo_array;//asignar nuevo valor
   	  		//change_idioma.trigger('change');
   	  		console.log(html_secciones);
   	  	}
        else alert('Error al intentar guardar');
        this_button.removeAttr('disabled');
   	  });
   });
});

  
</script>
 <!-- fin del modal de la vista previa -->

