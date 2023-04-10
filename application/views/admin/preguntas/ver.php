<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inca Lake Travel Agency</title>
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
		    <div class="panel panel-default">
		      <div class="panel-heading">Detalles de pregunta:</div>
			  <div class="panel-body">
                 <table class="table table-striped">
                   <tr><td>Nombre</td><td>: <?=$detalles_pregunta['nombre'];?></td></tr>
                   <tr><td>Email</td><td>: <?=$detalles_pregunta['email'];?></td></tr>
                   <tr><td>Actividad</td><td>: <?=$detalles_pregunta['actividad'];?></td></tr>
                   <tr><td>Fecha</td><td>: <?=$detalles_pregunta['fecha'];?></td></tr>
                   <tr><td>URL</td><td>: <?=$detalles_pregunta['url'];?></td></tr>
                   <tr><td>Descripcion</td><td>: <?=$detalles_pregunta['descripcion'];?></td></tr>
                 </table>
			  </div>
			</div>
		 </div>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<style>
		.table-striped tr td:first-child{
			font-weight: bold;
		}
		.table-striped tr td:last-child{
           color:#2D5590;
		}
		 
		</style>
		<script>
			$('#tabla_preguntas tr').click(function(){
				alert('redirigiendo');
			});
		</script>
	</body>
</html>