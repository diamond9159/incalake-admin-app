<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
?>

<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=nombre_incalake;?></title>
	<?php $this->load->view('admin/vistas/header/js') ?>
	<?php $this->load->view('admin/vistas/header/css') ?>
	
	<script src="<?=base_url(); ?>assets/resources/listjs/js/list.min.js"></script>
	
	<link rel="stylesheet" href="<?=base_url();?>assets/resources/listjs/css/listjs.css">
</head>
<body>
<header>
	<?php $this->load->view('admin/vistas/header/menu') ?>
</header>
<content>
	<div class="">
	<!-- <?=json_encode($numservicios);?> -->
	    <!--	
		<div class="row" >
			<div class="col-md-3 col-sm-6 col-xs-12">						
				
				<div class="panel panel-danger">
					<div class="container-fluid row">
					  <div class="col-md-6 col-xs-6 ">
					  	<div class="col-md-12 row">
						  	<div><strong>P&aacute;ginas Web</strong></div>
						  	<div class="text-danger div_cantidades">
							  	<?=$numservicios[0]['total_servicios'];?>				
						  	</div>
					  	</div>
					  	<div class="col-md-12 row">
					  	<div><strong>Actividades</strong></div>
					  		<div class="text-danger div_cantidades">
					  			<?=$numservicios[1]['total_paquetes'];?>	
					  		</div>
					  	</div>
					  </div>
					  
					  <div class="col-md-6 col-xs-6 text-center">
					  	<div class="text-danger">
					  		<span class="fa fa-tags fa-5x"></span>
					  	</div>
					  </div>
					</div>
				  <div class="panel-heading" data-toggle="collapse" href="#collapse-productos">
				  	<h4 class="panel-title">
			          	<span class="fa fa-tags"></span>
						<b>SERVICIOS</b>
			        </h4>
				  </div>
				  <div id="collapse-productos" class="panel-collapse collapse">
				  	<div class="panel-body">
				  		<ul>
			        	    <li><a href="<?php echo site_url('admin/servicio'); ?>">Servicios</a></li>
			            </ul>
				  	</div>
				  </div>
				</div>
			    
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel panel-success">
				  <div class="panel-heading" data-toggle="collapse" href="#collapse-reservas">
				  	<h4 class="panel-title">
			          	<span class="fa fa fa-calendar-check-o"></span>
						<b>RESERVAS</b>
			        </h4>
				  </div>
				  <div id="collapse-reservas" class="panel-collapse collapse">
				  	<div class="panel-body">
				  		ssssssss
				  	</div>
				  </div>
				</div>	
			</div>		
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel panel-info">
				  <div class="panel-heading" data-toggle="collapse" href="#collapse-calendario">
				  	<h4 class="panel-title">
			          	<span class="fa fa fa-calendar"></span>
						<b>CALENDARIO</b>
			        </h4>
				  </div>
				  <div id="collapse-calendario" class="panel-collapse collapse">
				  	<div class="panel-body">
				  		ssssssss
				  	</div>
				  </div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
			    
				<div class="panel panel-warning">
				  <div class="panel-heading" data-toggle="collapse" href="#collapse-ofertas">
				  	<h4 class="panel-title">
			          	<span class="fa fa-usd"></span>
						<b>OFERTAS</b>
			        </h4>
				  </div>
				  <div id="collapse-ofertas" class="panel-collapse collapse">
				  	<div class="panel-body">
				  		ssssssss
				  	</div>
				  </div>
				</div>
			</div>
			
		</div>	
		-->
		<div class="row">
			<div class="col-md-8 ">
				<div class="panel panel-primary">
				  	<div class="panel-heading" data-toggle="collapse" href="#collapse1">
				  		<h4 class="panel-title"><strong><span class="fa fa-list"></span> RESERVAS PENDIENTES POR REALIZAR</strong></h4>
				  	</div>
				  	<?php 
				  		//echo json_encode($ultimas_reservas);
				  	?>
				  	<div id="collapse1" class="panel-collapse collapse in">
					  	<div class="panel-body">
					  		<div id="actividades_reservadas">
					  			<div class="form-group">
					  				<div class="col-md-8 col-sm-8 col-xs-12">
							  			<input class="search form-control" placeholder="Buscar..." autofocus/>
							  		</div>
							  		<button class="sort" data-sort="actividad_servicio">ORDENAR POR ACTIVIDAD</button>
							  	</div>
							  	<?php if (!empty($ultimas_reservas)): ?>
							  	<div class="container-fluid text-center bg-primary">
                                    <div class="col-md-2"><small>F. COMPRA</small></div>
							  		<div class="col-md-2"><small>F. RESERVA</small></div>
							  		<div class="col-md-6"><small>ACTIVIDAD/SERVICIO</small></div>
							  		<div class="col-md-2"><small>OPCIONES</small></div>
							  	</div>
							  	<?php foreach ($ultimas_reservas as $key => $value): ?>
                                                                <?php if ( true ): ?>
							  	<div class="list col-md-12 text-left">					
							  		<div>
						  				<div class="fecha_servicio col-md-2 text-center">
						  					<small>
						  					<?=date_format(date_create($value['fecha_creacion_reserva']),'d-M-Y') ?>
						  					</small>
						  				</div>
						  				<div class="fecha_servicio col-md-2 text-center">
						  					<small><strong>
						  					<?=date_format(date_create($value['fecha_servicio']),'d-M-Y') ?>
						  					</strong></small>
						  				</div>
						  				<div class="actividad_servicio col-md-6">
						  					<?php if (!empty($value['titulo_producto']) ): ?>
						  						<small title="Servicio vendido desde la Web"><?=mb_strtoupper($value['titulo_producto']) ?></small>
						  					<?php else: ?>
						  						<small class="text-warning" title="Servicio vendido desde el ENLACE DE PAGO"><?=mb_strtoupper($value['descripcion_servicio']) ?></small>
						  					<?php endif ?>
						  				</div>
						  				<div class="col-md-2 text-center"><span data-id="<?=$value['id_reserva'];?>" class="btn btn-success btn-xs ver-detalles" title="Ver mas información" data-toggle="modal" data-target="#modal-ver-detalles"><small> VER DETALLES</small></span></div>
						  			</div>
							  	</div>	
                                                                <?php endif ?>
							  	<?php endforeach ?>
								<ul class="pagination"></ul>
							  	<?php else: ?>
							  		<div class="col-md-12 text-center">
							  			<h3>No hay reservas pendientes..!</h3>
							  		</div>	
							  	<?php endif ?>						  
							</div>
					  	</div>
				  	</div>
				</div>
			</div>
			<div class="col-md-4 container-fluid">
				<div class="panel panel-primary">
				  <div class="panel-heading" data-toggle="collapse" href="#collapse2">
				  	<h4 class="panel-title">
			          Ultimas Consultas realizadas por usuarios.
			        </h4>
				  </div>
				  <div id="collapse2" class="panel-collapse collapse in">
				  	<div class="panel-body">
				  	  <table class="table">
				  	   <tr><th>Cliente/Actividad</th><th>Fecha</th></tr>
				  	  <?php
				  	   $row_preguntas = null;
				  	    foreach($ultimas_preguntas as $value){
				  	    	$row_preguntas.="<tr><td><a href='".base_url()."admin/preguntas/ver/{$value['id']}'>".ucwords(mb_strtolower($value['nombre']))."</a><br/><small>".$value['actividad']."</small></td><td><small>".date_format(date_create($value['fecha']),"d-M-Y h:i A")."</small></td></tr>";
				  	    }
				  	   echo $row_preguntas;
				  	   //var_dump($ultimas_preguntas);
				  	  ?>
				  	  </table>
				  	</div>
				  </div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="modal-ver-detalles" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><strong><span class="fa fa-th-list"></span> DETALLES DE LA RESERVA</strong>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	        </h5>
	      </div>
	      <div class="modal-body">
	        <div class="modal-body-ver-detalles" id="modal-body-ver-detalles">
	        </div>
	        <div class="modal-body-data-ver-detalles" id="modal-body-data-ver-detalles">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>

</content>
<footer>
	<?php $this->load->view('admin/vistas/footer/footer') ?>
</footer>
</body>
<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
<script type="text/javascript">
	var monkeyList = new List('actividades_reservadas', {
	  	valueNames: [ 'fecha_servicio', 'actividad_servicio' ],
	  	page: 10,
	  	pagination: true
	});
	jQuery(document).ready(function($) {
		$(document).on('click', '.ver-detalles', function(event) {
			event.preventDefault();
			$(document).find('.modal-body>#modal-body-ver-detalles').empty().append(loading());
			var id_reserva = $(this).data('id');
			$.ajax({
				url: '<?=base_url();?>admin/reservas/detallereserva',
				type: 'POST',
				dataType: 'JSON',
				data: {id: id_reserva},
			}).done(function(data) {
				//console.log(JSON.stringify(data));
				verDetalleReservaHTML(data);
			}).fail(function(e) {
				console.log(e.responseText);
			});

			/****************** end ver detalle reserva ******************/
			function verDetalleReservaHTML(data){
				var detalleReservaHTML = '';
				detalleReservaHTML += '<div class="row">';
				$.each(data, function(index, val) {
					detalleReservaHTML += '<div class="col-md-5">';
						detalleReservaHTML += '<h5><strong>CÓDIGO RESERVA:</strong></h5>'+
											  '<h5><strong>FECHA DE COMPRA:</strong></h5>'+
											  '<h5><strong>NOMBRES:</strong></h5>'+
											  '<h5><strong>E-MAIL:</strong></h5>'+
											  '<h5><strong>N° TELÉFONO:</strong></h5>'+
											  '<h5><strong>ESTADO DE PAGO:</strong></h5>';
					detalleReservaHTML += '</div>';
					detalleReservaHTML += '<div class="col-md-7">';
						detalleReservaHTML += '<h5><strong>'+val['codigo_reserva']+'</strong></h5>'+  
						                      '<h5><strong>'+val['fecha_compra']+'</strong></h5>'+
						                      '<h5><strong>'+val['nombres_cliente']+'</strong></h5>'+
											  '<h5><strong>'+val['email']+'</strong></h5>'+
											  '<h5><strong>'+val['telefono']+'</strong></h5>'+
											  '<h5><strong>'+val['texto_pagado']+'</strong></h5>';
					detalleReservaHTML += '</div><hr/>';
					//detalleReservaHTML += '<div class="container-fluid">';
					$.each(val['detalle_servicio'], function(i, v) {
					detalleReservaHTML +=	'<div class="container-fluid">'+
											'<div class="row">'+
											'<div class="col-md-12">'+
												'<div class="alert alert-success container-fluid">'+
													'<div class="col-md-5">FECHA DE SERVICIO:</div><div class="col-md-7"><strong>'+v['fecha_servicio']+'</strong></div>'+
													'<div class="col-md-5">SERVICIO:</div><div class="col-md-7"><strong>'+v['titulo_producto']+'</strong></div>'+
													'<div class="col-md-5">PRECIO TOTAL</div><div class="col-md-7"><strong>$ '+v['precio_total']+' <small>USD</small></strong></div>'+
													'<div class="col-md-12"><strong>CANTIDADES</strong></div>';
							$.each(v['resumen'], function(j, k) {
								detalleReservaHTML += '<div class="col-md-12"><p>'+k['cantidad']+' '+k['tipo_articulo']+'s '+k['nombre_articulo']+'</p></div>';
							});								
						detalleReservaHTML +=	'</div>'+
											'</div>'+
											'</div>'+
											'</div>';	
					});
					//detalleReservaHTML += '</div>';																
				});
				detalleReservaHTML += '</div>';
				$(document).find('.modal-body>#modal-body-ver-detalles').empty().append(detalleReservaHTML);
			}	
		});
	});
	function loading(){
		return ('<div class="text-center"><img src="<?=base_url()?>assets/img/loading.gif" alt="Wait a moment, please..!"></div>');
	}
</script>
</html>