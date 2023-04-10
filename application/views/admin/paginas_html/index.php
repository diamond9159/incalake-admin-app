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
				$this->load->view('admin/paginas_html/html_conf_pagina');
			?>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
</html>