<!DOCTYPE html>
<html>

	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/jquery/jquery-ui.css">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/jquery/jquery.datetimepicker.min.css">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap-star-rating/css/star-rating.min.css">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/jquery-validation/css/validationEngine.jquery.css" type="text/css"/>

		<!-- <link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap-color-selector/css/bootstrap-colorselector.min.css"> -->

		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/flags/flags.min.css">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/admin.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url();?>recursos/css/galeria.css" />

	    <!-- JS Libs -->
    	<script type="text/javascript">base_url='<?=base_url();?>';</script>
		<script src="<?=base_url();?>assets/resources/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/resources/jquery/jquery-ui.js" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/resources/jquery/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
		<script src="<?=base_url(); ?>assets/resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			var urlRightNavBar = '<?=base_url();?>';
		</script>
		<script src="http://localhost/cmsv2/assets/resources/js/admin.js" type="text/javascript"></script>
		<script src="<?=base_url(); ?>assets/resources/bootstrap-star-rating/js/star-rating.min.js" type="text/javascript"></script>
		<script src="<?=base_url(); ?>assets/resources/jquery-validation/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url(); ?>assets/resources/jquery-validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script src="<?=base_url(); ?>assets/resources/blockui/jquery.blockui.js" type="text/javascript" charset="utf-8"></script>

		<script src="<?=base_url();?>assets/resources/ckeditor/ckeditor.js"></script>

		<script src="<?=base_url(); ?>assets/resources/bootstrap-color-selector/js/bootstrap-colorselector.min.js" type="text/javascript"></script>

		<script src="<?=base_url();?>assets/resources/bootstrap-select/js/bootstrap-select.min.js"></script>
		<script src="<?=base_url();?>recursos/js/galeria.js"></script>
		<script src="<?=base_url();?>assets/resources/spin.min.js" type="text/javascript"></script>
	</head>
	<body>

		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
			<div class="container">
			<?php	if(isset($_view) && $_view)
			    $this->load->view($_view);
			?>
			</div>
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
</html>
