<?php
 // echo json_encode($vuelos);
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
		<div class="col-md-12">
		 <div class="panel panel-default">
			<div class="panel-heading">Lista de vuelos</div>
			<div class="panel-body table-responsive">
				<table class="table table-striped" id="tabla_vuelos">
	
						<thead>
							<tr>
								<th># Vuelo</th>
								<th>Compañia Vuelo</th>
								<th>Hora partida</th>
								<th>Hora llegada</th>
								<th>Hora recojo</th>
								<th>Hora salida</th>
								<th>Hora arribo</th>
								<th width="150">#</th>
							</tr>
						</thead>
						<tbody>
								
						</tbody>
					</table>
					
					<button class="btn btn-primary" id="add_vuelos"><span class="fa fa-plus"></span> Agregar Vuelo</button>
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
		    var json_vuelos = <?=json_encode($vuelos);?>;
			var tabla_vuelos = $('#tabla_vuelos tbody');
			var btn_add_vuelos = $('#add_vuelos');

			btn_add_vuelos.click(function(){
				tabla_vuelos.append(agregarRowVuelo([]));
			});
			
			//console.log(json_sectores.length);
			if(json_vuelos instanceof Object){
				$.each(json_vuelos,function(){
					tabla_vuelos.append(agregarRowVuelo(this));
				});
			}
			// funcion que retora rows para sectores
			
			function agregarRowVuelo(datos){
				return `<tr>
							<input type="hidden" value="${datos.id_vuelo || 0}" name="id_vuelo">
							<td><input type="text" class="form-control" name="num_vuelo" value="${datos.num_vuelo || ''}"></td>
							<td><input type="text" class="form-control" name="compania_vuelo" value="${datos.compania_vuelo || ''}"></td>
							<td><input type="text" class="form-control" name="horapartida_vuelo" value="${datos.horapartida_vuelo || ''}"></td>
							<td><input type="text" class="form-control" name="horallegada_vuelo" value="${datos.horallegada_vuelo || ''}"></td>
							<td><input type="text" class="form-control" name="recojo_bus" value="${datos.recojo_bus || ''}"></td>
							<td><input type="text" class="form-control" name="salida_bus" value="${datos.salida_bus || ''}"></td>
							<td><input type="text" class="form-control" name="arribo_bus" value="${datos.arribo_bus || ''}"></td>
							<td>
								
								<button type="button" class="btn btn-success" title="Guardar cambios"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
								<button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>
							</td>
						</tr>`;
			}
			
			// al presionar en el boton de guardar
			tabla_vuelos.on('click','.btn-success',function(){
				var elem_padre = $(this).parents('tr');
				var inputs = elem_padre.find('input');
				var validador = true;
				inputs.each(function(i){
					if(i==3 || i==4)return; // evitar que hora recojo y llegada sea obligatotio
					if(!$(this).val()){
						$(this).css('border-color','red');
						validador = false;
					}

				});
				// ENVIAR SI TODO ESTA BIEN
				if(validador){
					var data = inputs.serializeArray();
					$.post('<?=base_url();?>admin/aeropuertos/regedit_vuelos',data,function(result){
						// console.log(data);
						if(!isNaN(result)){
							alert('Guardado correctamente.');
							// si key name = 0 entonces actualizarlo con ultimo id reciido
							if(!(+inputs[0].value))inputs[0].value = result; 
							// agregar nuevo elemento al array para su lectura
								
						} else {
							alert('errores en el servidor');
						}
					});
				}
			});
			
			// eliminar sectores
			tabla_vuelos.on('click','.btn-danger',function(){
				if(!confirm('¿Seguro de eliminar?'))return false;
				var elem_padre = $(this).parents('tr');
				var id_vuelo = elem_padre.find('input:eq(0)').val();
				$.post('<?=base_url();?>admin/aeropuertos/eliminar_vuelo',{id:id_vuelo},function(result){
						// console.log(data);
						
						if(!isNaN(result)){
							alert('Eliminado correctamente.');
							elem_padre.remove();
						} else {
							alert('errores en el servidor');
						}
				});
			});
			
	})();

	</script>
</html>