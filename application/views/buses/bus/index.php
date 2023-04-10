<!DOCTYPE html>
<html lang="es">
<head>
	<title>Lista de buses</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
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
					<div class="panel-heading">Lista de buses pertenecientes a una pagina</div>
					<div class="panel-body">
						<table class="table" id="lista_buses">
							<thead><tr><th>Titulo bus</th><th>Subtitulo del bus</th><th>#</th></tr></thead>
							<tbody>
						<?php
							$html = null;
							foreach($buses as $value){
								$html .= "<tr data-codigoid='{$value['id_codigo_bus']}'>
											<td>{$value['titulo_bus']}</td>
											<td>{$value['subtitulo_bus']}</td>
											<td>
												<button class='btn btn-success'>Ver</button>
											</td>
										 </tr>";
							}
							echo $html;
							//var_dump($buses);
						?>
							</tbody>
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
	</body>
	<script>
		(function(){
			var lista_buses = $('#lista_buses');
			lista_buses.on('click','.btn-success',function(){
				// alert($(this).closest('tr').data('codigoid'));
				location.href = '<?=base_url().'buses/unidad/buses_relacionados/';?>'+$(this).closest('tr').data('codigoid');
			});
			lista_buses.DataTable();
		})();
	</script>
</html>