<!DOCTYPE html>
<html lang="es">
<head>
	<title>Datos de pasajeros</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
	<link rel="stylesheet" href="<?=base_url();?>assets/resources/listjs/css/listjs.css">
	<script src="<?=base_url(); ?>assets/resources/listjs/js/list.min.js"></script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
			<div class="container">
				<div class="panel panel-default">
					<div class="panel-heading">Pasajeros de la reserva</div>
					<div class="panel-body">
						  
							<?php
							  if(count($pasajeros)){
										//echo json_encode($pasajeros);
										$html = '<div id="contenedor_pasajeros">';
										/*$pasajeros[9]['datos_clientes'][] =$pasajeros[9]['datos_clientes'][0];
										$pasajeros[9]['datos_clientes'][] =$pasajeros[9]['datos_clientes'][0];*/
										foreach($pasajeros as $value){
												$html.='<div style="clear:both"><h2>'.$value['titulo_producto'].'</h2>';
												
												$table = '';
												foreach($value['datos_clientes'] as $key => $value2){
													$table .= '<div class="col-md-6"><table class="table">';
														$table .= '<tr><th colspan="2">Cliente '.($key+1).'</th></tr>';
														foreach($value2 as $value3){
																$nombre_campo = json_decode($value3['nombre_campo']);
																$table .= '<tr><td>'.@$nombre_campo->es.'</td><td>: '.$value3['value_campo_formulario'].'</td></tr>';
														}
													$table .= '</table></div>';
												}
												
												$html .= $table.'</div>';
										}
						
										echo $html.'</div>';;
								} else {
									echo 'No se ha enviado pasajeros para esta reserva!';
								}
							
							?>
					</div>
				</div>
			</div>
			
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<style>
			 #contenedor_pasajeros{

			 }
			 #contenedor_pasajeros h2{
				 font:bold 1.5em sans-serif;
				 color:#6db6b6;
				 padding-left:15px;
				}
		</style>					
		<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
	</body>
</html>