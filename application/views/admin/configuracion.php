
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

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
			<?php
				$this->load->view('admin/configuracion/index');
			?>
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>

		<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
	</body>
<script type="text/javascript">
	$(document).ready(function() {
	  $('code').each(function(i, block) {
	    hljs.highlightBlock(block);
	  });
	});
</script>
<style>
.div-derecha{
	background: rgba(200, 202, 204, 0.42);
}
.card-title{
	background: #337ab7;
	color: #fff;
	margin: 0;
	padding-bottom: 1%;
	padding-top: 1%;
	font-weight: bold;
}
.card-title h4{
	
}
.card{
	background: #fff;
	padding-top: 1%;
}
.col-md-6,.card code{
	margin-bottom: 1%;
}
.text-success {
    color: #489e4a;
}
</style>
</html>