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

</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');

			?>
		</header>
		<content>
		 <div class="container">
		    <?php
		      //var_dump($listaPreguntas);
		    ?>
		    <div class="panel panel-default">
			  <div class="panel-heading">Consultas realizadas por los Clientes.</div>
			  <div class="panel-body">
			  	<table class="table table-hover" id="tabla_preguntas">
			  	 <thead><tr><th>Cliente</th><th>Actividad</th><th>Fecha</th><th>Estado</th></th><th class="text-center">Opciones</th></th></tr></thead>
			  	 <?php
			  	  $html_preguntas = null;
			  	  //var_dump($listaPreguntas);
			  	  foreach($listaPreguntas as $value){
			  	  	$html_preguntas .= '<tr '.(!$value['leido']?'class="no_leido"':'').' data-id="'.$value['id'].'">';
			  	  	$html_preguntas .= '<td>'.$value['nombre'].'</td>';
			  	  	$html_preguntas .= '<td>'.$value['actividad'].'</td>';
			  	  	$html_preguntas .= '<td>'.date_format(date_create($value['fecha']),'d-M-Y h:i A').'</td>';
			  	  	$html_preguntas .= '<td></td>';
			  	  	$html_preguntas .= '<td class="text-center">';
			  	  	$html_preguntas .= '<div class="btn-group">';
			  	  	$html_preguntas .= '<span class="btn btn-sm btn-primary btn-mas-detalles" title="Más Detalles" data-id="'.$value['id'].'"><i class="fa fa-bars"></i></span>';
			  	  	$html_preguntas .= '<span data-id="'.$value['id'].'" class="btn btn-sm btn-danger btn-eliminar-consulta" title="Eliminar">';
			  	  	$html_preguntas .= '<i class="fa fa-times"></i>';
                    $html_preguntas .= '</span>';
                    $html_preguntas .= '</div>';
                    $html_preguntas .= '</td>';
                    $html_preguntas .= '</tr>';
			  	  }
			  	  echo $html_preguntas;
			  	 ?>
			  	</table>
			  </div>
			</div>
		 </div>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<style>
		#tabla_preguntas{
          color:#333;
		}
		#tabla_preguntas tbody tr{
		  cursor: pointer;
		}
		#tabla_preguntas tr.no_leido{
		  background: #F4FFFA;
		  font-weight: bold;
		}
		</style>
		<script>
			$('#tabla_preguntas tr td .btn-mas-detalles').click(function(){
				location.href='<?=base_url();?>admin/preguntas/ver/'+$(this).data('id');
			});
			jQuery(document).ready(function($) {
				$(document).on('click', '.btn-eliminar-consulta', function(event) {
					event.preventDefault();
					var idConsulta = $(this).data('id');
					swal({
                        title: "Estas seguro para eliminar el registro..?",
                        text: "Si eliminas ya no podrás recuperar la información.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sí, Quiero ELiminar!",
                        closeOnConfirm: false
                    },function() {
                    	$.ajax({
                    		url: 'http://admin.incalake.com/admin/preguntas/remove/'+idConsulta,
                    		type: 'POST',
                    		dataType: 'JSON',
                    		data: {id:idConsulta},
                    	}).done(function(data) {
                    		if (data.response === 'success' ) {
                    			swal("Eliminado..!","El registro se ha eliminado correctamente.","success");
                    			//location.reload();
                    			
                    		}else{
                    			swal("Oops..!","El registro no se ha podido eliminar.","error");
                    		}
                    	}).fail(function(e) {
                    		swal("Error..!",e.responseText,"warning");
                    	});
                    });
					//console.log(idConsulta);
				});
			});
		</script>
	</body>
</html>