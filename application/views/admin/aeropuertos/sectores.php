<?php
 // var_dump($sectores);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Aeropuertos CMS Inca Lake</title>
	<meta charset="utf-8">
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
		<div class="col-md-6">
		 <div class="panel panel-default">
			<div class="panel-heading">Lista de sectores de recojo</div>
			<div class="panel-body table-responsive">
				<table class="table table-striped" id="tabla_sectores">
	
						<thead>
							<tr>
								<th>ID del sector</th>
								<th width="150">#</th>
							</tr>
						</thead>
						<tbody>
								
						</tbody>
					</table>
					
					<button class="btn btn-primary" id="add_sector_button"><span class="fa fa-plus"></span> Agregar Sector</button>
			</div>
		</div>
		</div>
		<div class="col-md-6">
		 <div class="panel panel-default">
			<div class="panel-heading">Precios</div>
			<div class="panel-body">
				<table class="table table-striped" id="tabla_precios">
						<input type="hidden" name="id_sector" value="0" id="id_sector_precios" >
						<thead>
							<tr>
								<th>Cantidad</th>
								<th>Precio $</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					<button class="btn btn-primary" id="add_precios" disabled><span class="fa fa-plus"></span> Agregar Precio</button>
					<button class="btn btn-success" id="guardar_precios" disabled><span class="fa fa-floppy-o"></span> Guardar Precios</button>
			</div>
		</div>
		</div>
	</div>
			
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
	<script>
	(function(){
		    var json_sectores = <?=json_encode($sectores);?>;
			var tabla_sectores = $('#tabla_sectores tbody');
			var btn_add_precios = $('#add_precios');
			var btn_guardar_precios = $('#guardar_precios');
			var tabla_precios = $('#tabla_precios tbody');
			var num_personas = 1; // se usara para enumerar la tabla de los precios
			var id_sector_precios = $('#id_sector_precios');

			$('#add_sector_button').click(function(){
				tabla_sectores.append(agregarRowSector('',0));
			});
			// add event to add precio button
			btn_add_precios.click(function(){
				tabla_precios.append(retornaRowPrecios(num_personas++,''));
				verificar_precios(); // acitiva boton guardar
			});
			// si hay json de sectores entonces mostrar
			//console.log(json_sectores.length);
			if(json_sectores instanceof Object){
				$.each(json_sectores,function(){
					tabla_sectores.append(agregarRowSector(this.key_sector,this.id_sector));
				});
			}
			// funcion que retora rows para sectores
			
			function agregarRowSector(nombre,id){
				return `<tr>
								<td>Sector :</td>
										<td>
											<input type="text" class="form-control" name="key_name" value="${nombre}">
											<input type="hidden" name="id_sector" value="${id}">
										</td>
										<td>
											<button type="button" ${+id?'':'disabled'} class="btn btn-info" title="Ver lista de precios para este sector"><i class="fa fa-bars" aria-hidden="true"></i></button>
											<button type="button" class="btn btn-success" title="Guardar cambios"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
											<button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>
								</td></tr>`;
			}
			// funcion que retorna rows para precios
			function retornaRowPrecios(cantidad,monto){
				return `<tr>
							<td>${cantidad}</td>
							<td><input class="form-control" type="number" name="precios[]" value="${monto}" ></td>
							<td>
								<button type="button" class="btn btn-danger" title="Eliminar precio"><i class="fa fa-times" aria-hidden="true"></i></button></td>
						</tr>`;
			}
			// al presionar en el boton de guardar
			tabla_sectores.on('click','.btn-success',function(){
				var elem_padre = $(this).parents('tr');
				var inputs = elem_padre.find('input');
				var validador = true;
				inputs.each(function(i){
					if(!$(this).val()){
						console.log('hay elementos sin llenar');
						$(this).css('border-color','red');
						validador = false;
					}

				});
				// ENVIAR SI TODO ESTA BIEN
				if(validador){
					var data = inputs.serializeArray();
					$.post('<?=base_url();?>admin/aeropuertos/regedit_sector',data,function(result){
						// console.log(data);
						if(!isNaN(result)){
							alert('Guardado correctamente.');
							// si key name = 0 entonces actualizarlo con ultimo id reciido
							if(!(+inputs[1].value))inputs[1].value = result; 
							    // agregar nuevo elemento al array para su lectura
								json_sectores[result] = {"id_sector": result,"key_sector": inputs[0].value,"valores_sector": "[]"};
								elem_padre.find('.btn-info').removeAttr('disabled');
								// console.log(json_sectores);
						} else {
							alert('errores en el servidor');
						}
					});
				}
			});
			// al presionar en el boton de mas info ver precios
			tabla_sectores.on('click','.btn-info',function(){
				// dar focus al boton
				tabla_sectores.find('.btn-info').css('color','white');;
				$(this).css('color','orange');
				btn_add_precios.removeAttr('disabled');
				tabla_precios.html('');
				num_personas = 1;
				// asignar id para actualizar precios
				var id_sector = $(this).parents('tr').find('input:eq(1)').val();
				id_sector_precios.val(id_sector);
				// fin dar focus
				// preparar precios para mostrar
				var precios = JSON.parse(json_sectores[id_sector].valores_sector);
				$.each(precios,function(i,value){
					tabla_precios.append(retornaRowPrecios(num_personas++,value));
				});
				verificar_precios();
				
				// alert('Alertando detalles');
			});
			// eliminar sectores
			tabla_sectores.on('click','.btn-danger',function(){
				if(!confirm('Seguro de eliminar?'))return false;
				var elem_padre = $(this).parents('tr');
				var id_sector = elem_padre.find('input:eq(1)').val();
				$.post('<?=base_url();?>admin/aeropuertos/eliminar_sector',{id:id_sector},function(result){
						// console.log(data);
						
						if(!isNaN(result)){
							alert('Eliminado correctamente.');
							// actualizar array que contiene detalles de los precios
							elem_padre.remove();
							delete json_sectores[id_sector];
							tabla_precios.html('');
							//tabla_precios.parents('table').find('button').attr('disabled','disabled');
							btn_guardar_precios.attr('disabled','disabled');
							btn_add_precios.attr('disabled','disabled');
						} else {
							alert('errores en el servidor');
						}
				});
			});

			// eliminar un precio
			tabla_precios.on('click','.btn-danger',function(){
				// alert('eliminando');
				$(this).parents('tr').remove();
				verificar_precios(); // desactiva boton guardar
			});
			//
			// ACCIONES CUANDO SE GUARDA PRECIOS
			btn_guardar_precios.click(function(){
				var validador = true;
				var inputs = tabla_precios.parents('table').find('input');
				inputs.each(function(){
					if(!this.value){
						$(this).css('border-color','red');
						validador = false;
					}
				});
				if(validador){
					var data = inputs.serializeArray();
					$.post('<?=base_url();?>admin/aeropuertos/update_precios_sector',data,function(result){
						// console.log(data);
						var isValidJSON = true;
						try { JSON.parse(result) } 
						catch (e) { isValidJSON = false }
						if(isValidJSON){
							alert('Guardado correctamente.');
							// actualizar array que contiene detalles de los precios
							json_sectores[inputs[0].value]['valores_sector'] = result;
							console.log(json_sectores);
							
						} else {
							alert('errores en el servidor');
						}
					});
				}

			});
			// funcion para comprobar si existe precios para recien habilitar el boton de guardar
			function verificar_precios(){
				if(!tabla_precios.html()){
					btn_guardar_precios.attr('disabled','disabled');
					num_personas = 1;
				}
				else btn_guardar_precios.removeAttr('disabled');
			}
	})();

	</script>
</html>