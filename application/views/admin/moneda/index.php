<?php
//var_dump($idiomas);
/* function retornarIdiomas($idiomas,$values=array()){
 	$idiomas_html = null;
 	foreach($idiomas as $value){
 	if($value['codigo']=='ES')continue;
    $idiomas_html .= '<li><label>'.$value['pais'].':</label> <input name="idiomas['.$value['codigo'].']" value="'.(@$values[$value['codigo']]).'" type="text"/></li>';
    }	
    return $idiomas_html;
 }*/
?>
<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title>Tipo de cambio</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>

</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
		 <div class="container">
		    <?php
		      /*$monedas[]='"BOB"';
		      $monedas[]='"PEN"';
		      $monedas = implode(',',$monedas);*/

		    ?>
		    <div class="panel panel-primary">
			  <div class="panel-heading">Tipos de cambio</div>
			  <div class="panel-body">
				  <div class="col-md-6">
				    <div class="panel panel-default">
					  <div class="panel-heading">Cambio</div>
					  <div class="panel-body">
                       <table class="table" id="cambioTabla">
                        <thead>
                        	<tr> 
                        	   <th>Codigo ISO</th>
						        <th>Precio del Dolar</th>
						        <th >Ultima actualización</th>
						    </tr>
                        </thead>
                        <tbody></tbody>
                       </table>
					  </div>
					</div>
				  </div>
				  <div class="col-md-6">
				  	<div class="panel panel-default">
					  <div class="panel-heading">Monedas</div>
					  <div class="panel-body">

					  	<table class="table table-striped" id="tabla_monedas">
						    <thead>
						      <tr>
						        <th>Nombre</th>
						        <th>Traducciones</th>
						        <th >Código ISO</th>
						        <th >simbolo</th>
						        <th width="100">#</th>
						      </tr>
						    </thead>
						    <tbody>
 						    </tbody>
			  			</table>
			  
			  			<button class="btn btn-primary" onclick="$('#tabla_monedas tbody').append(agregaRow);">Agregar moneda</button>
					  </div>
					</div>
				  </div>
			  </div>
			</div>

		 </div>





		 <script>
		   $idiomas_DB = <?=json_encode($monedas);?>;
		   //console.log($idiomas_DB);
		   
		   /*$.getJSON('https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(<?=$monedas;?>)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=',function(result){
             console.log(result);
		   });*/
		  var json_idiomas = <?=json_encode($idiomas)?>;
		  function idiomas(values){
		  	var idiomas_html = '';
		 	for(i in json_idiomas){
		 	//if(value['codigo']=='ES')continue;
		    idiomas_html += '<li><label>'+json_idiomas[i]['pais']+':</label> <input name="idiomas['+json_idiomas[i]['codigo']+']" type="text" value="'+(values[json_idiomas[i]['codigo']]?values[json_idiomas[i]['codigo']]:'')+'" /></li>';
		    }	
		    return idiomas_html;
		  }

		  function agregaRow(values){
		  	var nombre = '';
		  	var codigo = '';
		  	var simbolo = '';
		  	var traducciones = [];
		  	var id = 0;

		  	if(values){
		      nombre = values['nombre'];
		  	  codigo = values['codigo'];
		  	  simbolo = values['simbolo'];
		  	  traducciones = JSON.parse(values['traducciones']);
		  	  id = values['id'];
		  	}
		  	
		  	var html = '<tr>'+
  					  '<td>'+
  					   '<input type="hidden" name="id" value="'+id+'" />'+
  					   '<input class="form-control" type="text" required value="'+nombre+'" name="nombre" />'+
  					   '</td>'+
  					  '<td>'+
  					   '<div class="btn-group">'+
					    '<button type="button" title="Traducciones" class="btn btn-info btn-md dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span>'+
					    '<span class="caret"></span></button>'+
					    '<ul class="dropdown-menu" role="menu">'+idiomas(traducciones)+
					    '</ul>'+
					   '</div>'+
					  '</td>'+
  					  '<td><input class="form-control" required value="'+codigo+'" maxlength="3" type="text" name="codigo" /></td>'+
  					  '<td><input class="form-control" required value="'+simbolo+'" maxlength="10" type="text" name="simbolo" /></td>'+
  					  '<td><button class="btn btn-success guardar_button" disabled title="Guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>  <button title="Eliminar" class="btn btn-danger eliminar_button"><i class="fa fa-window-close" aria-hidden="true"></i></button></td>'+

  			'</tr>';
  			return html;
		  }

		   var tabla_monedas = $('#tabla_monedas');
		   var tabla_body = tabla_monedas.find('tbody');
		   /*leer datos para mostrar como lista*/
		   for(i in $idiomas_DB){
			  tabla_body.append(agregaRow($idiomas_DB[i]));
		   }
		   verCambioActual();
		  /*fin de mostrar datos*/



		   tabla_monedas.on('click','.eliminar_button',eliminarRow);
		   tabla_monedas.on('change','input[type=text]',function(){
		  	 $(this).parents('tr').find('.guardar_button').removeAttr('disabled');
		  });
		  /*funcion para guardar*/

		  tabla_monedas.on('click','.guardar_button',function(){
		  	var validador = true;
		  	var elem_btn = $(this);
		  	var fields = elem_btn.parents('tr').find( "input" );
				fields.each(function(key){
					if(!$(this).val()&& $(this).attr('required')){
					   validador=false;
					   $(this).css('border-color','#B93B3B');
					   return;
				    }
			});
			
			if(validador){
				//console.log(fields.serializeArray());
				var datos = fields.serializeArray()
				$.post('<?=base_url()?>admin/moneda/guardar',datos,function(resultado){
					if(!isNaN(resultado)){
					 if(parseInt(resultado)){
						   fields.css('border-color','#52A07A');
						   elem_btn.attr('disabled','disabled');
						   if(!parseInt(datos[0]['value']))fields[0].value=resultado;//agregar nuevo id para nuevos rregistros
						   verCambioActual();//actualizar
					    }
					 else fields.css('border-color','#B93B3B');		
					} else alert('Errores en el server.');
			  	
			    });
			}

		  });
		  /*fin de la funcion para guardar*/
		  /*funcion para eliminar row*/
		  function eliminarRow(){
					if(!confirm('Esta seguro de querer eliminar?'))return false;
					
					var tr_parent = $(this).parents('tr');
					var ide= tr_parent.find('input[name=id]').val();

						if(parseInt(ide)){
							$.post("<?=base_url()?>admin/moneda/eliminar", {id:ide}, function(result){
							       //console.log(result+'::::'+ide);
							        if(parseInt(result)){
							        	tr_parent.remove();
							        	verCambioActual();//actualizar
							        }
							        else alert('No se ha podido eliminar.');
							});
						} else tr_parent.remove();

		  }
		  /*funcion de vista previa*/
		 var elemento_principal = $('#cambioTabla tbody');
		  function verCambioActual(){

		  	var inputs_isos = $('input[name=codigo]');
		  	var query = [];
		  	    inputs_isos.each(function(){
		  	      if($(this).val().length==3)query.push('"'+$(this).val()+'"');
		  	      
		  	    });
		  	  console.log(query.join());
		  	 if(query.length){
		  	 	var url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20('+(query.join())+')&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';
		  	 	//console.log(url);
		  	 	$.getJSON(url,function(result){
                   //console.log(result.query.results.rate);
                   var html = '';
                   $.each(result.query.results.rate,function(i,elem){
                   	 html+='<tr><td>'+elem.Name+'</td><td>'+elem.Ask+'</td><td>'+elem.Date+' - '+elem.Time+'</td></tr>';
                   });
                   //console.log(html);
                   elemento_principal.html(html);
		        })
		  	 }
		  }
		 </script>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<style>
		#tabla_preguntas{
          color:#333;
		}
		#tabla_preguntas tbody tr{
		  cursor: pointer;
		}
		#tabla_preguntas tr.no_leido{
		  background: #F4FFFA;
		  font-weight: bold;
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

		<script>
			$('#tabla_preguntas tr').click(function(){
				location.href='<?=base_url();?>admin/preguntas/ver/'+$(this).data('id');
			});
		</script>
	</body>
</html>