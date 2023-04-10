<!--
<! DOCTYPE html>
<html>
<head>
	<title><?=mb_strtoupper(@$actividad['titulo_producto']);?></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
-->
<?php 
    header('Content-Type: text/html; charset=utf-8');
    ini_set('default_charset', 'utf-8');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3 class="text-center text-info" style="text-align:center;"><?=mb_strtoupper(@$actividad['titulo_producto']);?></h3>
			<h4 class="text-center text-info" style="text-align:center;"><?=mb_strtoupper(@$actividad['subtitulo_producto']);?></h4><hr />	<br/><br/>
			<div class="text-center" style="text-align:center;">
				<?php foreach ($galeria as $key => $value): ?>
					<?php if ( $key < 3 ): ?>
						<img src="<?=@$value;?>" class="img-thumbnail" alt="">&nbsp;
					<?php endif ?>
				<?php endforeach ?>
			</div>
			<div class="text-justify">
				<h4 class="text-info"><strong>HORARIOS DE SALIDA DISPONIBLE</strong></h4>
				<?php
					$arrayHorasIncio = explode(",",@$actividad['hora_inicio']);
					$arrayDuraciones = explode(",",@$actividad['duracion']);
					$arrayZonaHoraria= explode(",",@$actividad['zona_horaria']);

				?>
				<?php if ( !empty($arrayHorasIncio) ): ?>
					<div class="table-responsive">
						<table class="table" border="1" cellspacing="0">
							<thead>
								<tr>
								<th style="padding: 0.2em 0.3em 0.2em 0.3em;">HORA INICIO</th>
								<th style="padding: 0.2em 0.3em 0.2em 0.3em;"><?=htmlentities("DURACIÓN")?></th>
								<th style="padding: 0.2em 0.3em 0.2em 0.3em;">ZONA HORARIA</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($arrayHorasIncio as $key => $value): ?>
									<?php
										$arrayTipoDuracion = explode("!",$arrayDuraciones[$key]);
										$tipoDuracion = "";
										switch ($arrayTipoDuracion[1]) {
											case 0:
												$tipoDuracion = @$arrayTipoDuracion[0]==1?" Minuto": " Minutos";
											break;
											case 1:
												$tipoDuracion = @$arrayTipoDuracion[0] == 1 ?" Hora":" Horas";
											break;
											case 2:
												$tipoDuracion = @$arrayTipoDuracion[0] == 1 ?htmlentities(" Día") :htmlentities(" Días");
											break;
											default:
												$tipoDuracion = " Días";
											break;
										}
									?>
									<tr>
										<td style="padding: 0.2em 0.3em 0.2em 0.3em;"><?=$value;?></td>
										<td style="padding: 0.2em 0.3em 0.2em 0.3em;"><?=@$arrayTipoDuracion[0].$tipoDuracion;?></td>
										<td style="padding: 0.2em 0.3em 0.2em 0.3em;"><?=@$arrayZonaHoraria[$key]==0?"Hora Peruana":"Hora Boliviana";?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				<?php else: ?>
					<h5 class="text-danger"><strong>* Sin horarios de Salida.</strong></h5>
				<?php endif ?>
			</div>
			<div class="text-justify">
				<?php if ( !empty($tabs['tabs']['descripcion_tab']) ): ?>
						<h4 class="text-info"><strong>DESCRIPCION</strong></h4>
						<?=@$tabs['tabs']['descripcion_tab'];?>
				<?php endif ?><hr/>
				<?php if ( !empty($tabs['tabs']['itinerario_ta']) ): ?>
						<h4 class="text-info"><strong>ITINERARIO</strong></h4>
						<?=@$tabs['tabs']['itinerario_ta'];?>
				<?php endif ?><hr/>
				<?php if ( !empty($tabs['tabs']['incluye_tab']) ): ?>
						<!--
						<h4 class="text-info"><strong>INCLUYE</strong></h4>
						-->	
						<?=$tabs['tabs']['incluye_tab'];?>
				<?php endif ?><hr/>
				<?php if ( !empty($tabs['tabs']['informacion_tab']) ): ?>
						<!--
						<h4 class="text-info"><strong>MAS INFORMACION</strong></h4>
						-->
						<?=@$tabs['tabs']['informacion_tab'];?>
				<?php endif ?><hr/>
			<!--
				<div style="page-break-after:always;"></div> 
			-->
				<h4 class="text-info"><strong>PRECIOS</strong></h4>
				
					<?=@$precios;?>
				
			</div>
			<div class="text-justify">
				<h3 class="text-center text-info"><strong>POLITICAS Y CANCELACIONES DEL SERVICIO</strong></h3><hr />
				<?php 
					echo @$actividad['politicas_producto'];
				?>
			</div>
		</div>
	</div>
</div>
<!--
</body>
</html>
-->