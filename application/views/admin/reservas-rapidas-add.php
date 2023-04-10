
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
	<!--
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/resources/bootstrap-datepicker/css/datepicker.css">
	-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
	<!--
	<script src="<?=base_url()?>assets/resources/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="<?=base_url()?>assets/resources/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
	-->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <!--
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    -->
    <script type="text/javascript" src="//incalake.com/assets/resources/js/helpers.js"></script>
    <script type="text/javascript" src="//incalake.com/assets/resources/js/dev_.js"></script>
    <!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.2.31/vue.global.prod.min.js" integrity="sha512-aHDp6BDlnbRLDTxmY5GIqQA0RQd6dmeKIDDDiEJlRrKNQPZbo2mjsR/DGMUzupcCpE4XgPyeIPnDQdJNUmeEhw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.2.31/vue.runtime.global.prod.min.js" integrity="sha512-EpVg3t4U+HlWyCTlzQjwvKh8qjbHbxqIghWifD+gFL68Os7z4Y0JIpS3z8xdsrsQBKu38BPyFeNOeAb1rB4PGQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	-->
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/es.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
			<?php
				$this->load->view('admin/reservas-rapidas/add');
			?>
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>

	</body>
</html>