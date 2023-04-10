<?php
	// var_dump($servicios_adicionales);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Servicios adicionales del bus</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
	<link href="<?=base_url()?>/recursos/css/fontawesome-iconpicker.min.css" rel="stylesheet">
	<link href="<?=base_url()?>/assets/resources/css/service_css/flaticon.css" rel="stylesheet">
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');

			?>
		</header>
		<content>
			<div class="container">
				<div class="panel-group">
					<div class="panel panel-primary">
						<div class="panel-heading">Lista de servicios adicionales<a class="btn btn-success pull-right" style="margin-top:-7px" href="<?=base_url('buses/servicios_adicionales/registro');?>">Agregar</a></div>
						<div class="panel-body">
										<table class="table" id="table_servicios_adicionales">
											<tr>
												<th>Nombre servicio</th>
												<th>Icono</th>
												<th>Acciones</th>
											</tr>
										<?php
											$html = null;
											foreach($servicios_adicionales as $value){
												$html .= "<tr data-id='{$value['id_servicio_adicional']}'><td>{$value['nombre_servicio_adicional']}</td><td><span class='flaticon-{$value['icono_servicio_adicional']}' > </span></td><td><button class='btn btn-success' type='button'><span class='fa fa-pencil'></span></button> <button class='btn btn-danger' type='button'><span class='fa fa-times'></span></button> </td></tr>";
											}
											echo $html;
										?>
										</table>
							
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
			var table_servicios = $('#table_servicios_adicionales');
			var btn_editar = table_servicios.find('.btn-success');
			var btn_eliminar = table_servicios.find('.btn-danger');
			btn_editar.click(function(){
				var id_servicio = $(this).parents('tr').data('id');
				console.log(id_servicio);
				location.href = '<?=base_url('buses/servicios_adicionales/editar').'/';?>'+id_servicio;
			});
			// eliminar
			btn_eliminar.click(function(){
				var tr = $(this).parents('tr');
				var id_servicio = tr.data('id');
				console.log(id_servicio);
				$.post('<?=base_url('buses/servicios_adicionales/eliminar');?>',{id_servicio:id_servicio},function(resp){
					console.log(resp);
					if(!isNaN(resp)){
						alert('Eliminado correctamente');
						tr.remove();
					} else alert('Problemas para eliminar');
				});
			});
		})();
	</script>
</html>