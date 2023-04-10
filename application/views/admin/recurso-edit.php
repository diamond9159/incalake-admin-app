
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
	<link rel="stylesheet" href="<?=base_url();?>assets/resources/listjs/css/listjs.css">
	<script src="<?=base_url(); ?>assets/resources/listjs/js/list.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>recursos/css/galeria.css" />
	<script type="text/javascript">
		var base_url = '<?=base_url();?>';
	</script>
	<script src="<?=base_url();?>recursos/js/galeria.js"></script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
			<?php
				$this->load->view('admin/recurso/edit');
			?>
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>

		<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
	</body>
</html>