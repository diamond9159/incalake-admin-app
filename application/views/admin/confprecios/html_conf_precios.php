<?php
  

  $html_edades = null;
  $html_nacionalides = null;
  
 function retornarIdiomas($idiomas,$values=array()){
 	$idiomas_html = null;
 	foreach($idiomas as $value){
 	if($value['codigo']=='ES')continue;
    $idiomas_html .= '<li><label>'.$value['pais'].':</label> <input name="idiomas['.$value['codigo'].']" value="'.(@$values[$value['codigo']]).'" type="text"/></li>';
    }	
    return $idiomas_html;
 }
//var_dump(json_decode('{\'en\':"boy","fr":"boyyes"}',true));
?>

<div class="container">
  <div class="col-md-6">
	 <div class="panel panel-default">
	  <div class="panel-heading">Lista de etapas de edades</div>
	  <div class="panel-body table-responsive">
	  	<table class="table table-striped edad">

			    <thead>
			      <tr>
			        <th>Descripcion</th>
			        <th>Traducciones</th>
			        <th >Edad min.</th>
			        <th >Edad max.</th>
			        <th width="100">#</th>
			      </tr>
			    </thead>
			    <tbody>
<?php
            function retornarRowsEdades($values){
            	return '<tr>
  					  <td><input type="hidden" name="id" value="'.@$values['id_etapa_edad'].'" /><input class="form-control" type="text" required value="'.@$values['descripcion_etapa_edad'].'" name="descripcion" /></td>
  					  <td>
  					   <div class="btn-group">
					    <button type="button" title="Traducciones" class="btn btn-info btn-md dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span>
					    <span class="caret"></span></button>
					    <ul class="dropdown-menu" role="menu">'.retornarIdiomas($values['idiomas'],@$values['traducciones']?json_decode($values['traducciones'],true):array()).'
					      
					    </ul>
					   </div>
					  </td>
  					  <td><input class="form-control" required value="'.@$values['edad_min'].'" type="number" name="edad_min" /></td>
  					  <td><input class="form-control" required value="'.@$values['edad_max'].'" type="number" name="edad_max" /></td>
  					  <td><button class="btn btn-success" disabled title="Guardar" onclick="saveData($(this),1)"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>  <button title="Eliminar" onclick="eliminar_edad($(this),1)" class="btn btn-danger" '.(@$values['editar']=='0'?'disabled':'').'><i class="fa fa-window-close" aria-hidden="true"></i></button></td>

  					 </tr>';
            }

			       //$array_idiomas = json_decode($idiomas);
			        foreach($lista_datos['etapas_edad'] as $key=> $value){
				        $value['idiomas'] = $idiomas;
	  	                $html_edades .= retornarRowsEdades($value);
  					}
  echo $html_edades;
  $dato['idiomas']=$idiomas;
?>
			    </tbody>
			  </table>
			  
			  <button class="btn btn-primary" onclick="$('table.edad tbody').append(html_row);addChangeEvent($('table.edad tr:last-child'));">Agregar etapa</button>
	  </div>
	</div>
  </div>
  <div class="col-md-6">
	 <div class="panel panel-default">
	  <div class="panel-heading">Lista de nacionalidades</div>
	  <div class="panel-body">
	  	<table class="table table-striped nac">

			    <thead>
			      <tr>
			        <th>Descripcion</th>
			        <th>Traducciones</th>
			        <th>#</th>
			      </tr>
			    </thead>
			    <tbody>
			     <?php
			     function retornarRowsNacionalidades($values){
		            	return '<tr>
		  					  <td><input type="hidden" name="id" value="'.@$values['id_nacionalidad'].'" /><input class="form-control" type="text" required value="'.@$values['descripcion_nacionalidad'].'" name="descripcion" /></td>
		  					  <td>
		  					   <div class="btn-group">
							    <button type="button" title="Traducciones" class="btn btn-info btn-md dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span>
							    <span class="caret"></span></button>
							    <ul class="dropdown-menu" role="menu">'.retornarIdiomas($values['idiomas'],@$values['traducciones_nacionalidad']?json_decode($values['traducciones_nacionalidad'],true):array()).'
							      
							    </ul>
							   </div>
							  </td>
		  					  
		  					  <td><button class="btn btn-success" disabled title="Guardar" onclick="saveData($(this),2)"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>  <button onclick="eliminar_edad($(this),2)" class="btn btn-danger" title="Eliminar" '.(@$values['editar']=='0'?'disabled':'').'><i class="fa fa-window-close" aria-hidden="true"></i></button></td>

		  					 </tr>';
		            }
		            $html_nacionalides = null;
		            foreach($lista_datos['nacionalidades'] as $key=> $value){
				        $value['idiomas'] = $idiomas;
	  	                $html_nacionalides .= retornarRowsNacionalidades($value);
					 }
					  echo $html_nacionalides;
					  $dato['idiomas']=$idiomas;
			     ?>
			    </tbody>
			  </table>
			  <button class="btn btn-primary" onclick="$('table.nac tbody').append(html_nac);addChangeEvent($('table.nac tr:last-child'));">Agregar Nacionalidad</button>
	  </div>
	</div>
  </div>
</div>

<script>
				var html_row = '<?=str_replace(PHP_EOL,"",retornarRowsEdades($dato));?>';
				var html_nac = '<?=str_replace(PHP_EOL,"",retornarRowsNacionalidades($dato));?>';
				function saveData(element,ruta){
					switch(ruta){
						case 1:ruta='regedit';break;
						case 2:ruta='regedit_nac';break;
					}

					var tr_parent = element.parents('tr');

					var fields = tr_parent.find( "input" );
					var validador = true;
					    fields.each(function(key){
					    	if(!$(this).val()&& $(this).attr('required')){
					    		validador=false;
					    		$(this).css('border-color','#B93B3B');
					    		return;
					    	}
					    });
					    if(validador){
					      var data = fields.serializeArray();
					       //fields.push({name:'id'});
					        $.post(base_url+"admin/confprecios/"+ruta, data, function(result){
						        //console.log(result);
						        if(parseInt(result)){
						        	fields.css('border-color','#52A07A');
						        	element.attr('disabled','disabled');
						        	if(fields[0].value=='')fields[0].value=parseInt(result);//agregar nuevo id para nuevos rregistros
						        }
						        else fields.css('border-color','#B93B3B');
						    });

					      //console.log(data);
					    } else alert('Hay alguno campos importantes vacios');
					    
					   /* jQuery.each( fields, function( i, field ) {
					      $( "#results" ).append( field.value + " " );
					    });*/
					  
				}
				function eliminar_edad(element,ruta){
					if(!confirm('Esta seguro de querer eliminar?'))return false;
					switch(ruta){
						case 1:ruta='eliminar';break;
						case 2:ruta='eliminar_nac';break;
					}
					var tr_parent = element.parents('tr');
					var ide= tr_parent.find('input[name=id]').val();

						if(ide){
							$.post(base_url+"admin/confprecios/"+ruta, {id:ide}, function(result){
							       console.log(result+'::::'+ide);
							        if(parseInt(result))tr_parent.remove();
							        else alert('No se ha podido eliminar.');
							});
						} else tr_parent.remove();

				}
				/*agregar evento de change para que solo si se cambio los valores se active boton guardar*/
				function addChangeEvent(element){
					element.find('input').change(function(){
						$(this).parents('tr').find('.btn-success').removeAttr('disabled');
					}).focusin(function(){
						$(this).css('border-color','#CCC');
					});

				}
				addChangeEvent($('table tbody'));
			</script>
			<style>
			 table .btn-group{
			 	
			 }
			 table .btn-group li{
			 	padding: 5px;

			 }
			 table .btn-group label{
	
			 	color:#999;
			 }
			 table .btn-group input{
			 	padding: 3px;
			 	border:1px solid #CCC;
			 }
			</style>