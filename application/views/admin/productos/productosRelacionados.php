<!DOCTYPE html>
<html lang="es">
<head>
	<title>Actividades relacionadas></title>
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
			<div>
				<?php
//var_dump($resultados);
/*var_dump($resultados);*/
//var_dump($idiomas);

if($resultados['productos']){
	$titulo = '<div class="titulo-producto"><span class="fa fa-chevron-right" style="vertical-align: middle;color: #5cb85c;"> </span>'.$resultados['productos'][0]['titulo_pagina'].'</div>'.
	'<div class="col-md-12 header-list">'.
	'<div>'.
		'<div class="col-md-10">'.
		'traducciones de la Actividad'.
		'</div>'.
		'<div class="col-md-2">'.
		'OPCIONES'.
		'</div>'.
	'</div>'.
	'</div>';
	 $html = $titulo.'';
	 //var_dump($resultados['productos']);
	   foreach ($resultados['productos'] as $value) {
	   	$bandera='';
		if(strtolower($value['codigo'])=='en'){
		$bandera='us';	
		}else{
			$bandera=strtolower($value['codigo']);
		}

	   	if(!empty($value))
	   	$html.='<div class="col-md-12 div-tabla">'.
	   			'<div class="col-md-10" ><span class="flag flag-'.$bandera.'"></span>  '.
				   '<a title="Editar Actividad" href="'.base_url().'admin/productos/editar/'.$value['id_producto'].'"><strong>'.$value['titulo_producto'].'</strong>&nbsp;&nbsp;|&nbsp;&nbsp;'.$value['url_servicio'].'</a>

				   <!--button class="pull-right btn btn-warning btn_copiar" data-id="'.$value['id_producto'].'" data-codigo="'.$value['id_codigo_producto'].'">Copiar Precios</button-->
				   <div class="dropdown" style="display:inline-block;float:right">
					<button class="btn btn-warning dropdown-toggle" type="button" id="copiar_" data-toggle="dropdown">Copiar
					<span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="copiar_">
						<li><a href="#" class="btn_copiar" data-id="'.$value['id_producto'].'" data-codigo="'.$value['id_codigo_producto'].'"> Precios</a></li>
						<li role="presentation"><a class="btn_copiar_adelanto" href="#" data-id="'.$value['id_producto'].'" data-codigo="'.$value['id_codigo_producto'].'"> Adelanto</a></li>
					</ul>
					</div>
				   
				   </div>'.
	   			'<div class="col-md-2">'.
	   			'<div class="text-center">'.
		   			'<a title="Editar Actividad" href="'.base_url().'admin/productos/editar/'.$value['id_producto'].'" class="btn btn-info btn-sm">'.
		   				'<span class="fa fa-pencil"></span>'.
		   			'</a>'.
		   			'<a title="Ver Actividad" target="_blank" href="'.$value['url_servicio'].'" class="btn btn-success btn-sm">'.
		   				'<span class="fa fa-eye"></span>'.
		   			'</a>'.
		   			//'<button title="Eliminar Producto" class="btn btn-danger btn-sm" onclick="location.href = '."'".base_url().'admin/productos/remove/'.$value['id_producto']."'".'"><span class="fa fa-close"></span></button>'.
		   			'<button title="Eliminar Actividad" class="btn btn-danger btn-sm btn-delete-producto" data-id="'.$value['id_producto'].'"><span class="fa fa-close"></span></button>'.
		   		'</div>'.
	   			'</div>'.
	   			'</div>';
	     $idiomasExistentes[$value['codigo']]=$value['pais'];
	   }
	   //se detecta si idioma ya esta agregado de lo contrario bloquea link
	   	   $idiomas_title = '<strong>También puedes añadir el paquete para los siguientes idiomas:</strong><br/>';
	   $idiomas = null;
	   foreach($resultados['idiomas'] as $value){
	   	  $urlAdd = base_url().'admin/productos/agregar/'.$value['id_servicio'].'/'.$resultados['productos'][0]['id_codigo_producto'];
	   	  $btnadd = '<button class="btn btn-danger" onclick="location.href=\''.$urlAdd.'\'">'.$value['pais'].'</button><br/>';
	      foreach($idiomasExistentes as $key => $val)if($value['codigo']==$key)$btnadd=null;
	      $idiomas .= $btnadd;
	   }
	 echo $html.' '.($idiomas?$idiomas_title.$idiomas:'');
	 echo  '&nbsp;<hr/><a href="'.base_url().'admin/servicio/add/'.$resultados['idiomas'][0]['cod_servicio'].'" class="btn btn-success">Agregar servicio en otros idiomas faltantes</a>';
} else {
	echo 'no hay resultados';
}
?>
			</div>
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
	</body>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-delete-producto', function(event) {
			event.preventDefault();
			var btn_click = $(this);
			var id_producto = $(this).data("id");
			console.log("ID PRODUCTO: " + id_producto);
			swal({
	          title: "Estas seguro de eliminar esta Actividad/Servicio..?",
	          text: "Si eliminas esta Actividad tambien se eliminaran automaticamente de la lista de Actividades.",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonColor: "#DD6B55",
	          confirmButtonText: "Si, Quiero Eliminar!",
	          cancelButtonText: "No, Cancelar",
	          closeOnConfirm: false
	        },
	        function(){
	            $.ajax({
					url: '<?=base_url();?>admin/productos/remove/'+parseInt(id_producto),
					type: 'DELETE',
					dataType: 'JSON',
					data: {id: id_producto},
				}).done(function(data) {
					if ( data.response === 'OK' ) {
                        swal("Confirmación","Se ha eliminado correctamente..!","success");
                        $(btn_click).parents('.div-tabla').remove();
                    }else{
                        swal("Oops..!","No se ha podido eliminar, Intente nuevamente por favor..!","error");
                    }
                    console.log(data);
				}).fail(function(e) {
					console.log(e.responseText);
					swal("ERROR CONECTANDO AL SERVIDOR",e.responseText,"error");
				});
	        });
		});
	});
	/*agregar llamada ajax para el correcto copiado de los precios*/
	$('.btn_copiar').click(function(){
		if(confirm("¿Seguro de copiar precios a toda las actividades relacionadas?")){
			$.post('<?=base_url();?>admin/productos/copiar_precios',{id_producto:$(this).data('id'),codigo_producto:$(this).data('codigo')},function(resultado){
				if(!isNaN(resultado)){
					alert('Exito! .. Toda las actividades relacionadas ya tienen el mismo precio');
				} else alert('Errores en el servidor');
			});
		}
	});

	/* copiar los adelantos a las actividades relacionadas */
	$('.btn_copiar_adelanto').click(function(){
		if(confirm('¿Seguro de copiar el adelanto (primera cuota) a las actividades relacionadas?')){
			$.post('<?=base_url();?>admin/productos/copiar_adelanto',{id_producto:$(this).data('id'),codigo_producto:$(this).data('codigo')},function(resultado){
				if(!isNaN(resultado)){
					alert('Exito! .. Toda las actividades relacionadas ya tienen el mismo porcentaje del adelanto (primera cuota) a pagar.');
				} else alert('Errores en el servidor');
			});
		}
		
	});
</script>
</html>

