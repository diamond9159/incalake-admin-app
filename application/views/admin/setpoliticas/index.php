<?php
 // los archivos txt se encuentran en la siguiente carpeta en el sistema WEB
 // $ruta = '../web/assets/archivos/politicas_bus/'; ya viene desde el controlador
 // si se envia datos post en esta misma URL del controlador
    if($_POST){
     // obtener el idioma que fue enviado
	 $idioma = key($_POST['politicas_text']);
	 // obtener ruta completa del archivo a editar
  	 $ruta_edit=$ruta.$idioma.'.txt';
			// abres el fichero en modo lectura/escritura
			$open = fopen($ruta_edit,"w+"); 
			// escribes el contenido en el fichero e imprimes resultado
			echo @fwrite($open, $_POST['politicas_text'][$idioma]);
			// detener php 
		  	exit();
   }
?>
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
	<script src="<?=base_url()?>assets/resources/ckeditor/ckeditor.js"></script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');

			?>
		</header>
		<content>
			<?php
			    $data['ruta'] = $ruta;
				$this->load->view('admin/setpoliticas/html_set_politicas',$data);
			?>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
</html>