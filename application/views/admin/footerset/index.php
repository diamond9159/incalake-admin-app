<?php
 $ruta = '../web/assets/footer/';
 //se edita si esque se hace un autollamado a la funcion
    if($_POST){
     //var_dump($_POST);exit;
  	 $ruta_edit=$ruta.$_POST['idioma'].'.txt';
      $open = fopen($ruta_edit,"w+"); //abres el fichero en modo lectura/escritura
	  echo @fwrite($open, json_encode($_POST['seccion']));//escribes el contenido en el fichero
	  exit();
   }
 function retornarIdiomas($idiomas){
 	$idiomas_html = '';
 	foreach($idiomas as $value)$idiomas_html .= '<option value="'.$value['codigo'].'">'.$value['pais'].'</option>';
    	
    return $idiomas_html;
 }
  

   function retornarJSONfooter($ruta,$idiomas){
 	//global $ruta;
 	$json = array();
 	foreach($idiomas as $value){
 	//if($value['codigo']=='ES')continue;
 	
 	$file = $ruta.$value['codigo'].'.txt';
 	$texto = null;
 	if(file_exists($file)){
  	    $myfile = fopen($file, "r");
	  	$texto = @fread($myfile,filesize($file));
	    fclose($myfile);
    }

    $json[$value['codigo']]= json_decode($texto);
    }	
    return $json;
 }

//var_dump(json_decode('{\'en\':"boy","fr":"boyyes"}',true));
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inca Lake Travel Agency - configuracion del footer</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
    <link href="<?=base_url()?>/recursos/css/fontawesome-iconpicker.min.css" rel="stylesheet">
    <script>
      html_secciones = <?=json_encode(retornarJSONfooter($ruta,$idiomas));?>;
    </script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');

			?>
		</header>
		<content>
			<?php
				$this->load->view('admin/footerset/html_conf_footer');
			?>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
</html>