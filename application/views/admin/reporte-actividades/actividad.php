<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3 class="text-center text-info"><?=mb_strtoupper(@$actividad['titulo_producto']);?></h3>
			<h4 class="text-center text-info"><?=mb_strtoupper(@$actividad['subtitulo_producto']);?></h4><hr />	
			<div class="text-center">
				<?php foreach ($galeria as $key => $value): ?>
					<?php if ($key < 3 ): ?>
						<img src="<?=$value;?>" class="img-thumbnail" alt="">&nbsp;						
					<?php else: ?>
						<? break; ?>
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
						<table class="table">
							<thead>
								<tr>
								<th>Hora Inicio</th>
								<th>Duración</th>
								<th>Zona Horaria</th>
							</tr>
							</thead>
							<tbody>
								<?php foreach ($arrayHorasIncio as $key => $value): ?>
									<?php
										$arrayTipoDuracion = explode("!",$arrayDuraciones[$key]);
										$tipoDuracion = "";
										switch ($arrayTipoDuracion[1]) {
											case 0:
												$tipoDuracion = " Minutos";
											break;
											case 1:
												$tipoDuracion = " Horas";
											break;
											case 2:
												$tipoDuracion = " Días";
											break;
											default:
												$tipoDuracion = " Días";
											break;
										}
									?>
									<tr>
										<td><?=$value;?></td>
										<td><?=@$arrayTipoDuracion[0].$tipoDuracion;?></td>
										<td><?=@$arrayZonaHoraria[$key]==0?"Hora Peruana":"Hora Boliviana";?></td>
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
						<?=$tabs['tabs']['descripcion_tab'];?>
				<?php endif ?><hr/>
				<?php if ( !empty($tabs['tabs']['itinerario_ta']) ): ?>
						<h4 class="text-info"><strong>ITINERARIO</strong></h4>
						<?=$tabs['tabs']['itinerario_ta'];?>
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
						<?=$tabs['tabs']['informacion_tab'];?>
				<?php endif ?><hr/>	
			<!--
				<div style="page-break-after:always;"></div> 
			-->
				<h4 class="text-info"><strong>PRECIOS</strong></h4>
				<small>
					<!--
				<?php if ( count($data) != 0 ): ?>			
					<?php foreach ($data as $key => $value): ?>
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
			-->
				<?=$precios;?>
				</small>
			</div>
			<div class="text-justify">
				<h3 class="text-center text-info"><strong>POLITICAS Y CANCELACIONES DEL SERVICIO</strong></h3><hr />
				<?php 
					echo @$actividad['politicas_producto'];
				?>
			</div>
		</div>
		<div class="col-md-8 col-md-offset-2">
			<div class="text-center">
				<hr />
				<a href="<?=base_url();?>admin/reporteactividades/pdf/<?=strtolower(trim(@$actividad['codigo']))?>/<?=@$actividad['id_producto'];?>/Actividad" class="btn btn-warning btn-lg" title="Imprimir (Esto puede tardar varios minutos)" target="_blank"><span class="fa fa-file-pdf-o"></span></a>
				<a href="<?=base_url();?>admin/reporteactividades/" class="btn btn-danger btn-lg">VOLVER</a>
			</div><br /><br />
		</div>
	</div>
</div>