<!DOCTYPE html>
<html lang="es">
<head>
	<title><?=nombre_incalake;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
			<?php
				$this->load->view('admin/lugar/edit');
			?>
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
</html>