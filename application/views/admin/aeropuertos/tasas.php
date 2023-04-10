<?php
 // echo json_encode($configuraciones);
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
			<div class="panel-heading">Configurar Tasas, comisiones etc.</div>
			<div class="panel-body table-responsive">
				<table class="table table-striped" id="tabla_tasas">
	
						<thead>
							<tr><td>$ Tasas e impuestos</td><td><input name="impuesto" value="<?=$configuraciones['impuesto'];?>" class="form-control" ></td></tr>
							<tr><td>$ Comisión servicio</td><td><input name="comision" value="<?=$configuraciones['comision_servicio'];?>" class="form-control" ></td></tr>
							<tr><td>$ Precio transporte compartido</td><td><input name="precio_compartido" value="<?=$configuraciones['servicio_publico'];?>" class="form-control" ></td></tr>							
						</thead>
						<tbody>
								
						</tbody>
					</table>
					
					
			</div>
		</div>
		</div>
		<div class="col-md-6">
		 <div class="panel panel-default">
			<div class="panel-heading">Precios para servicio privado segun personas</div>
			<div class="panel-body table-responsive">
				<table class="table table-striped" id="tabla_precios_privado">
	
						<thead>
							<tr>
								<td>Cantidad personas</td>
								<td>Precio $</td>
								<td>#</td>
							</tr>
											
						</thead>
						<tbody>
								
						</tbody>
					</table>
					
					<button class="btn btn-primary pull-right" id="add_precio"><span class="fa fa-plus"></span> Agregar precio</button>
			</div>
		</div>
		</div>
		<hr style="clear:both">
		<div class="text-center"><button class="btn btn-success" id="guardar_todo"><span class="fa fa-floppy-o"></span> Guardar todo los cambios</button></div>
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
		    var json_precios = <?=$configuraciones['servicio_privado'];?>;
			var tabla_precios = $('#tabla_precios_privado tbody');
			var btn_add_vuelos = $('#add_precio');
			var guardar_todo_btn = $('#guardar_todo');
			var cantidad_personas = 1;

			btn_add_vuelos.click(function(){
				tabla_precios.append(agregarRowPrecio(''));
			});
			
			//console.log(json_sectores.length);
			if(json_precios instanceof Object){
				$.each(json_precios,function(){
					tabla_precios.append(agregarRowPrecio(this));
				});
			}
			// funcion que retora rows para sectores
			
			function agregarRowPrecio(precio){
				return `<tr>
							<td>${cantidad_personas++}</td>
							<td><input type="number" class="form-control" name="precio_privado[]" value="${precio}"></td>
							<td>
								<button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button>
							</td>
						</tr>`;
			}
			
			
			// eliminar sectores
			tabla_precios.on('click','.btn-danger',function(){
				if(!confirm('¿Seguro de eliminar?'))return false;
				$(this).parents('tr').remove();
			});

			guardar_todo_btn.click(function(){
				var inputs = $('.container input');
				// console.log(datos);
				var validador = true;
				inputs.each(function(i){
					if(!$(this).val()){
						console.log('hay elementos sin llenar');
						$(this).css('border-color','red');
						validador = false;
					}

				});
				if(validador){
					$.post('<?=base_url();?>admin/aeropuertos/regedit_tasas',inputs.serializeArray(),function(result){
							// console.log(data);
							if(!isNaN(result)){
								alert('Guardado correctamente');
							} else {
								alert('errores en el servidor');
							}
					});
				}
				
			});
			
	})();

	</script>
</html>