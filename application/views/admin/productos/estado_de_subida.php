
<html>
<head>
<title>
Estado la publicacion de: <?=$titulo_prod;?>
</title>
</head>
<body>
<?php
 if(isset($datos)){
 	if($datos){
 ?>
 <div class="alert alert-success">
  <strong>Exito!</strong> El producto: <b><?=$titulo_prod;?></b>, se ha agregado de manera correcta; ahora puedes agregar mas productos en diferentes idiomas disponibles a continuacion:
  <div id="botonesIdiomas">
  	<?php
  	$buttons = null;
  	foreach ($datos as $value) {
  		$buttons .= '<a class="btn btn-primary" href="'.base_url().'admin/productos/agregar/'.$value['id_servicio'].'/'.$id_codigo_producto.'" title="'.$value['titulo_pagina'].'">'.$value['pais'].'</a> ';
  	}
  	echo $buttons;
  	?>
  </div>
</div>
 <?php
 	 //var_dump($datos);
 	} else {
?>
 <div class="alert alert-success">
  <strong>Exito!</strong> El producto: <b><?=$titulo_prod;?>, se ha actualizado de manera correcta.</b><br>
  <center><a class="btn btn-success" href="<?=base_url();?>admin/servicio">Ver lista de servicios.</a></center>
</div>
<?php
 	}
 } else {

?>


<div class="alert alert-danger">
  <strong>Hubo Errores!</strong> No se pudo salvar la  informacion de: <b><?=$titulo_prod;?></b><br>
  <center><button class="btn btn-danger" onclick="window.history.back()">Intentar de Nuevo</button></center>
</div>
<?php
 	$mensaje = '';
 }

?>
</body>
</html>