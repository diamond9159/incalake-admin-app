<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Reporte de actividades - Inca Lake</title>
	<link rel="stylesheet" href="">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
	<?php if ( !empty($data) ): ?>
		<h2 class="text-center text-primary">REPORTE DE SERVICIOS MAS VENDIDOS</h2>
		<table class="table-striped" style="width: 100%;">
			<thead>
				<tr> 
					<th class="text-center"># RESERVAS</th>
					<th>SERVICIO</th>
					<th class="text-center"># CLIENTES</th>
					<th class="text-right">TOTAL $</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$precioSubTotal = 0;
			?>
			<?php foreach ($data as $key => $value): ?>
			<?php 
				$precioSubTotal += (Float)$value['precio_total'];
			?>
				<tr>
					<td class="text-center"><?=$value['cantidad_servicio']?></td>
					<td><?=$value['nombre_servicio']?></td>
					<td class="text-center"><?=$value['cantidad_clientes']?></td>
					<td class="text-right"><?=number_format($value['precio_total'], 2, '.', ' ')?></td>
				</tr>
			<?php endforeach ?>
			<tr>
				<td colspan="3" class="text-right">SUB TOTAL $</td>
				<td class="text-right"><?=number_format($precioSubTotal, 2, '.',' ');?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">TOTAL CUPONES DESCUENTO $</td>
				<td class="text-right"><?=number_format($monto_cupones, '2', '.', ' ');?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">TOTAL $</td>
				<td class="text-right"><?=number_format(( (Float)$precioSubTotal -(Float)$monto_cupones ), 2, '.', ' ')?></td>
			</tr>
			</tbody>
		</table>
	<?php else: ?>
		<div class="alert alert-danger">
			<h3>No hay datos para su reporte...!</h3>
		</div>
	<?php endif ?>
</body>
</html>