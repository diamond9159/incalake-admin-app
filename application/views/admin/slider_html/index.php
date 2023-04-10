<!DOCTYPE html>
<html lang="es">
<head>
	<title>Slider Principal de la pagina de Inicio</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
    <link href="<?=base_url()?>/recursos/css/fontawesome-iconpicker.min.css" rel="stylesheet">
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');

			?>
		</header>
		<content>
			<?php
				$this->load->view('admin/slider_html/html_slider');
			?>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
</html>