<!DOCTYPE html>
<html lang="es">

<head>
	<title>Paginas independientes</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
	$this->load->view('admin/vistas/header/css');
	$this->load->view('admin/vistas/header/js');
	?>
	<link href="<?= base_url() ?>/recursos/css/fontawesome-iconpicker.min.css" rel="stylesheet">
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
						<tr>
							<th width="45%">Titulo bus</th>
							<th width="45%">URL</th>
							<th>#</th>
						<tr>
							<?php
							$html = null;
							foreach ($buses_relacionados['buses'] as $value) {
								$idioma = preg_match('(en|EN)', @$value['idioma_pagina']) ? 'us' : strtolower($value['idioma_pagina']);
								$html .= "<tr data-idbus='{$value['id_bus']}'>
										<td><span class='flag flag-$idioma'></span> &raquo; {$value['titulo_bus']}</td>
											<td>{$value['url_pagina']}</td>
											<td>
												<button class='btn btn-danger'><span class='fa fa-times'></span></button>
												<button class='btn btn-success'><span class='fa fa-pencil'></span></button>

											</td>
										 </tr>";
								unset($buses_relacionados['paginas_web'][$value['id_pagina']]);
							}
							echo $html;
							// var_dump($buses_relacionados);
							?>
					</table>
					<hr>
					<div>
						<p>Esta pagina tiene
							<?= count($buses_relacionados['buses']); ?> buses en diferentes idiomas
							disponibles.
						</p>
						<?php
						if (count($buses_relacionados['paginas_web'])) {
							$botones = null;
							foreach ($buses_relacionados['paginas_web'] as $value) {
								$botones .= "<a href='" . base_url('buses/unidad/copiar/' . $value['id_pagina'] . '/' . @$buses_relacionados['buses'][0]['id_codigo_bus']) . "' class='btn btn-info'>{$value['lenguaje']}</a> ";
							}
							echo "<div class='alert alert-warning'><p>Hay paginas webs relacionadas sin este bus, click en sus botones para agregar. <hr></p>$botones</div>";
						}
						?>
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
	(function () {
		var lista_buses = $('#lista_buses');
		lista_buses.on('click', '.btn-success', function () {
			// alert($(this).closest('tr').data('codigoid'));
			location.href = '<?= base_url() . 'buses/unidad/editar/'; ?>' + $(this).closest('tr').data('idbus');
		});
		// eliminar bus
		lista_buses.on('click', '.btn-danger', function () {
			// alert($(this).closest('tr').data('codigoid'));
			if (confirm('¿Esta seguro de eliminar?')) {
				var parent = $(this).closest('tr');
				var id_bus = parent.data('idbus');
				$.post('<?= base_url('buses/unidad/eliminar'); ?>', {
					id_bus: id_bus
				}, function (response) {
					console.log(response);
					if (!isNaN(response)) {
						parent.remove();
						alert('Eliminado correctamente');
					} else alert('Problemas al eliminar');
				});
			}

		});

	})();
</script>

</html>