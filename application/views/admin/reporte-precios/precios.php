<! DOCTYPE html>
<html>
<head>
	<title> Reporte de Precios </title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>

	<?php 
	//echo json_encode($ids);
	?>
<div class="container-fluid">
	<div id="imprimir-documento">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
				<?php if ( count($data) != 0 ): ?>			
				<?php foreach ($data as $key => $value): ?>
					<h3 class="text-center text-info"> <small>REPORTE DE PRECIOS PARA LAS ACTIVIDADES DE LA PÁGINA WEB</small><br/><big><?=mb_strtoupper($value['titulo_pagina']).' ('.$value['pais'].')';?></big></h3>
					<h3 class="text-success">ACTIVIDAD: <?=mb_strtoupper($value['titulo_producto']);?></h3>
					<?php foreach ($value['detalle_precios'] as $k => $val): ?>
						<strong><h4 class="text-warning">PRECIOS: <?=mb_strtoupper($val['descripcion'])?></h4></strong>
					<?php if ( count($val['precios']) != 0 ): ?>
					<table class="table-striped table-bordered" style="width: 100%;" > 
						<tr>
							<th class="text-center"> # Personas </th> 
							<th class="text-center"> Precio Unitario USD</th> 
							<th class="text-right" style="padding-right: 10px;"> Precio Total USD</th> 
						</tr>
						<?php foreach ($val['precios'] as $j => $v): ?>
							<tr>
								<td class="text-center"> <?=$v['cantidad'];?> </td> 
								<td class="text-center"> $ <strong><?=number_format($v['monto'],2,'.',' ');?></strong> <small>USD</small></td> 
								<td class="text-right" style="padding-right: 10px;"> $ <strong><?=number_format(($v['cantidad']*$v['monto']),2,'.',' ' );?></strong> <small>USD</small></td> 
							</tr>
						<?php endforeach ?>
					</table>	
					<?php else: ?>
						<div class="alert alert-danger">
						<div class="text-center text-danger"><span class="fa fa-exclamation-circle"></span> No hay precios para esta actividad..!</div>
						</div>
					<?php endif ?>
					<?php endforeach ?>
					<br/><hr/><br/>
				<?php endforeach ?>
				<?php else: ?>
					<div class="alert alert-danger">
						<h4 class="text-danger text-center"><span class="fa fa-exclamation-circle"></span> NO HAY DATOS PARA REALIZAR LOS REPORTES DE PRECIOS.</h4>
					</div>
				<?php endif ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="text-center">
				<div class="col-md-8 col-md-offset-2">
					<div class="alert alert-warning">
						<p><span class="fa fa-exclamation-circle"></span> Generar precios para imprimir puede demorar varios minutos..!</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="text-center">
				<a href="<?=base_url();?>admin/reporteprecios" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
				<a href="<?=base_url();?>admin/reporteprecios/pdf/<?=$ids['idioma'].'/'.$ids['idproducto']?>" class="btn btn-success" target="_blank"><span class="fa fa-file-pdf-o"></span> IMPRIMIR</a>
				<br/><br/><br/><hr/>
			</div>
		</div>
	</div>
</div>

</body>
</html>