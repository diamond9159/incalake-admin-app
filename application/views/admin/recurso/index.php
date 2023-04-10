<div class="container-fluid">
	<!-- <div class="pull-left">
		<h3 class="text-info"><strong><span class="fa fa-list"></span> LISTA DE RECURSO</strong></h3> 
	</div> -->
	<?php
		// echo json_encode($idiomas);
		// echo json_encode($recursos);
	?>

	<?php if ( !empty($message) ): ?>
		<div class="alert alert-danger alert-dismissable fade in">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		    <strong>ALERTA !</strong> <?=$message;?>
		</div>
	<?php endif ?>

	<div class="headline">
				<div><span class="fa fa-th-list"></span> lista de recurso</div>
			</div>
	<div class="pull-right">
		<a href="<?php echo site_url('admin/recurso/add'); ?>" class="btn btn-success" title="Agregar Nueva Recurso"><strong><span class="fa fa-plus"></span> AGREGAR</strong></a> 
	</div>
 <div id="users">
	  <input class="search" placeholder="Buscar..." />
	  <button class="btn btn-info sort" data-sort="name">BUSCAR</button>
	    <!-- IMPORTANT, class="list" have to be at tbody -->
	    <div class="col-md-12 header-list text-center">
		    <div class="hidden-xs">
		    	<div class="col-md-1">#</div>			
					<div class="col-md-4">RECURSO</div>
					<div class="col-md-4">DESCRIPCION</div>
					<div class="col-md-1">PRECIO</div>
					<div class="col-md-2">OPCIONES</div>
			</div>
	    </div>
	    
	    <div class="list">
	    	<?php foreach ($recursos as $key => $value): ?>
			<div class=" col-md-12">
				<?php
					$html_nombre_recurso 		= '';
					$html_descripcion_recurso 	= '';
					$html_precio_recurso 		= '';
					$html_id_codigo_recurso 	= '';
					$json_nombre_recurso 	  = json_decode($value['nombre_recurso'],true);
					$json_descripcion_recurso = json_decode($value['descripcion_recurso'],true);
					$json_precio_recurso      = json_decode($value['precio_recurso'],true);
					//echo json_encode($json_nombre_recurso  );
					//echo json_encode($json_descripcion_recurso  );
					//echo json_encode($json_precio_recurso  );
				?>
				
				<?php foreach ($idiomas as $key2 => $val): ?>
					<?php 
					/*
					$html_nombre_recurso .= '<p><b>'.$val['codigo'].':</b> '.ucfirst($json_nombre_recurso[$val['codigo'] ]).'</p>'; 
					
					$html_descripcion_recurso .= '<p><b>'.$val['codigo'].':</b> '.ucfirst($json_descripcion_recurso[$val['codigo'] ] ).'</p>';
					$html_precio_recurso .= '<p><b>'.$val['codigo'].':</b> $'.ucfirst($json_precio_recurso[$val['codigo'] ] ).' <small>USD</small></p>';
					*/
					?>
				<?php endforeach ?>
				
				<?php 
					
					$html_nombre_recurso .= '<p class="name"><strong>'.($idiomas[0]['pais'] ? $idiomas[0]['pais'] : $idiomas[1]['pais']).'(<small>'.($idiomas[0]['codigo'] ? $idiomas[0]['codigo'] : $idiomas[1]['codigo']).'</small>): </strong>'.($json_nombre_recurso[ $idiomas[0]['codigo'] ] ? $json_nombre_recurso[ $idiomas[0]['codigo'] ] : $json_nombre_recurso[ $idiomas[1]['codigo'] ]).'</p>';
					
					$html_descripcion_recurso .= '<p><strong>'.($idiomas[0]['pais'] ? $idiomas[0]['pais'] : $idiomas[1]['pais']).'(<small>'.($idiomas[0]['codigo'] ? $idiomas[0]['codigo'] : $idiomas[1]['codigo']).'</small>): </strong>'.($json_descripcion_recurso[ $idiomas[0]['codigo'] ] ? $json_descripcion_recurso[ $idiomas[0]['codigo'] ] : $json_descripcion_recurso[ $idiomas[1]['codigo'] ] ).'</p>';
					$html_precio_recurso .= '<p>$'.ucfirst($json_precio_recurso[$idiomas[0]['codigo'] ] ).' <small>USD</small></p>';
					$html_id_codigo_recurso = $value['id_recurso'];
					
				?>
				<div class="col-md-12 name container-fluid lista div-<?=$key;?>">
					<div class="text-center col-md-1 col-xs-12"><?=($key+1);?></div>									
					<div class="col-md-4 col-xs-12"><?=$html_nombre_recurso;?></div>
					<div class="col-md-4 hidden-xs"><?=$html_descripcion_recurso;?></div>
					<div class="text-center col-md-1 col-xs-12" style="padding:0;"><?=$html_precio_recurso;?></div>
					<div class="text-center  col-md-2 col-xs-12">
						<div class="btn-group">
							<a href="javascript:void(0);" class="btn btn-warning btn-sm btnVerRecurso" title="Traducciones Recurso" data-toggle="modal" data-target="#modalVerRecurso" data-id="<?=$html_id_codigo_recurso;?>"><span class="fa fa-list"></span></a>

							<a href="<?=base_url();?>admin/recurso/edit/<?=$value['id_recurso'];?>" class=" btn btn-info btn-sm" title="Editar recurso"><span class="fa fa-pencil"></span></a>

							<?=$value['regalo_recurso']?'<div title="Recurso esta activo" class="btn btn-default btn-sm text-success btn-estado-recurso" data-id="'.$value['id_recurso'].'" data-estado="0"><span class="fa fa-check-square-o"></span></div>':'<div title="Recurso no esta activo" class="btn btn-default btn-sm text-danger btn-estado-recurso" data-id="'.$value['id_recurso'].'" data-estado="1"><span class="fa fa-square-o "></span></div>';?>
							<div class=" btn btn-primary btn-sm btn-asociar-recurso" title="Asociar Recurso" data-id="<?=$value['id_recurso'];?>"><span class="fa fa-gift"></span></div>
<!--
							<div class=" btn btn-success btn-sm btn-galeria-recurso" title="Imagen Recurso" data-id="<?=$value['id_recurso'];?>" data-nombre='<?=$value['nombre_recurso'];?>'><span class="fa fa-picture-o"></span> </div>
-->
							<div class=" btn btn-danger btn-sm btn-eliminar-recurso" title="Eliminar Recurso" data-id="<?=$value['id_recurso'];?>"><span class="fa fa-close"></span></div>
							
						</div>
					</div>
				</div>
    		</div> 
	    	<?php endforeach ?>
		<div class="text-center">	
			<ul class="pagination"></ul>       
	    </div>
	</div>
</div>

<div class="modal fade" id="modal_recursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center" id="exampleModalLabel"><strong><span class="fa fa-list"></span> Lista de Paquetes Turísticos</strong></h4>
                <input type="hidden" name="txt_id_recurso_modal" id="txt_id_recurso_modal">
            </div>
            <div class="modal-body">
                <h4>Al seleccionar o asociar el recurso a un tour en Español esto tambien se asociará en los demás idiomas ofrecidos.</h4>
                <div class="container-fluid text-success"><strong>Tours y/o Paquetes Disponibles en el Idioma Español:</strong></div>
                <div class="container-fluid" id="container_list_productos">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">GUARDAR</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerRecurso" tabindex="-1" role="dialog" aria-labelledby="VerRecurso">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel"><span class="fa fa-tag"></span> RECURSO</h4>
            </div>
            <div class="modal-body" style="min-height: 12em;">
            	<div class="modalLoading" id="modalLoading"></div>
            	<div class="modalContent" id="modalContent"></div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-success btnEditarRecurso" id="btnEditarRecurso" title="Editar Información del Recurso">EDITAR</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar Modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		// $('.numeracion').css('line-height','');
		var spinner = new Spinner({
			lines: 12, // The number of lines to draw
			length: 5, // The length of each line
			width: 3, // The line thickness
			radius: 7, // The radius of the inner circle
			color: '#000', // #rbg or #rrggbb
			speed: 1, // Rounds per second
			trail: 70, // Afterglow percentage
			shadow: true // Whether to render a shadow
		}).spin(document.getElementById("modalLoading"));

		console.log($('.name').css('height'));
		$(document).on('click', '.btn-eliminar-recurso', function(event) {
			event.preventDefault();
			var id_delete = $(this).data('id');
			swal({
                title: "Estas seguro para eliminar el registro..?",
                text: "Si eliminas ya no aparecerá en la lista de registro.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, Quiero ELiminar!",
                closeOnConfirm: false
            },
            function() {
            	$.ajax({
            		url: '<?=base_url();?>admin/recurso/remove/'+id_delete,
            		type: 'POST',
            		dataType: 'JSON',
            		data: {id:id_delete},
            	}).done(function(data) {
            		if (data.data === 'OK' ) {
            			swal("Eliminado..!","El registro se ha eliminado correctamente.","success");
            			location.reload();
            		}else{
            			swal("Oops..!","El registro no se ha podido eliminar.","error");
            		}
            	}).fail(function(e) {
            		swal("Error..!",e.responseText,"warning");
            	});
            });								
		});

		$(document).on('click', '.btn-galeria-recurso', function(event) {
			event.preventDefault();
			var id_recurso 		= $(this).data("id");
			var nombre_recurso 	= $(this).data("nombre");
			//console.log(id_recurso);
			$.ajax({
				url: '<?=base_url()?>admin/recurso/imagenRecurso',
				type: 'POST',
				dataType: 'JSON',
				data: {id: id_recurso},
			}).done(function(data) {
				console.log(data);
			}).fail(function(e) {
				console.log(e.responseText);
			});
		});

		$(document).on('click', '.btn-asociar-recurso', function(event) {
			event.preventDefault();
			var id_recurso = $(this).data('id');
			console.log("ID RECURSO: " + id_recurso);
			$('#modal_recursos').modal('show');
			$("#txt_id_recurso_modal").empty().val(id_recurso);
			$.ajax({
				url: '<?=base_url();?>admin/recurso/productos_by_idioma',
				type: 'POST',
				dataType: 'json',
				data: {id_recurso: id_recurso},
			}).done(function(data) {
				//console.log( JSON.stringify(data) );
				//console.log(data.idiomas);
				//console.log(data.productos);
				var html_paquetes_turisticos = '';
				var array_html_idiomas = [];
				var html_content_idiomas = '';
                $.each(data.idiomas, function(index, val) {
                	//console.log(val.pais);
                	html_paquetes_turisticos = '';
                	html_paquetes_turisticos += '<ul class="list-group">';
	                $.each(data.productos, function(indexes, value) {
	                	$.each(value, function(i, j) {
	                		//console.log(j.codigo);
	                		var checked = j.asociado ? 'checked' : '';
	                		if ( j['codigo'] === val['codigo'] && j['codigo'] === "ES" ) { // && j['codigo'] === "ES"  => FILTRA TODOS LOS PAQUETES EN ESPAÑOL
		                		html_paquetes_turisticos += '<li class="list-group-item">'+j.titulo_producto+
																'<span class="pull-right">'+
																	'<input type="checkbox" '+checked+' name="chckbx_producto" class="chckbx_producto" data-id="'+j.id_producto+'" data-icp="'+j.id_codigo_producto+'">'+
																'</span>'+
															'</li>';
							}
	                	});
	                });
	                html_paquetes_turisticos += '</ul>'; 
	                array_html_idiomas[ val.codigo ] = html_paquetes_turisticos;
                });


                //console.log(array_html_idiomas );
                $.each(data.idiomas, function(index, val) {
                	html_content_idiomas += array_html_idiomas[ val.codigo ];
                });
                $("#container_list_productos").empty().append(html_content_idiomas);
			}).fail(function(e) {
				console.log(e.responseText);
				swal("Error..!",e.responseText,"error");
			});	
		});

		$(document).on('change', '.chckbx_producto', function(event) {
			event.preventDefault();
			var id_producto	 		= $(this).data("id");
			var id_codigo_producto 	= $(this).data("icp"); // icp = id_codigo_prodcuto
			var id_recurso  		= $("#txt_id_recurso_modal").val();
			//console.log("ID PRODUCTO: " + id_producto + " ID RECURSO: " + id_recurso );
			if($(this).is(':checked')){
				console.log("checkeado..!");
				operacion(id_producto,id_recurso,id_codigo_producto,1);
			}else{
				console.log("No checkeado..!");
				operacion(id_producto,id_recurso,id_codigo_producto,0);
			}
		});

		$(document).on('click', '.btn-estado-recurso', function(event) {
			event.preventDefault();
			var id_recurso = $(this).data('id');
			var estado = $(this).data('estado');
			//console.log("ID_RECURSO: " + id_recurso + "  ESTADO: " + estado);
			$.ajax({
				url: '<?=base_url();?>admin/recurso/update_estado_recurso',
				type: 'POST',
				dataType: 'JSON',
				data: { id_recurso: id_recurso,estado: estado},
			}).done(function(data) {
				console.log(data);
			}).fail(function(e) {
				console.log(e.responseText);
				swal("ERROR",e.responseText,"error");
			});
			
			if(estado=='0'){
				$(this).data( "estado", 1 );
				$(this).children('span').removeClass('fa-check-square-o').addClass('fa-square-o');
			}
			else{
				$(this).data( "estado", 0 );
				$(this).children('span').removeClass('fa-square-o').addClass('fa-check-square-o');
			}
		});

		//MUESTRA MODAL DE UN RECURSO CON SUS TRADUCCIONES
		$(document).on('click', '.btnVerRecurso', function(event) {
			event.preventDefault();
			var id = $(this).data("id");
			var modal = null, button = null,html = "";
			$('#modalVerRecurso').on('show.bs.modal', function (event) {
				button = $(event.relatedTarget);
				modal = $(this);
				modal.find('.modal-body>#modalContent').empty(); 
				modal.find('.modal-body>#modalLoading').css('display', 'block');
			});

			$.ajax({
				url: '<?=base_url();?>admin/recurso/traduccionesRecurso',
				type: 'POST',
				dataType: 'json',
				data: {id:id},
			}).done(function(data) {
				if (data.length > 0 ) {
					html = '<div class="list-group">';
					$.each(data, function(index, val) {
						html += '<a href="javascript:void(0);" class="list-group-item">'+
							    	'<span class="badge"><big><strong>$ '+val['precio']+' USD</strong></big></span>'+
							    	'<h5 class="list-group-item-heading" style="text-transform: uppercase;"><strong>'+val['idioma']+' ('+val['codigo']+')</strong>: '+val['nombre']+'</h5>'+
							    	'<p class="list-group-item-text">'+val['descripcion']+'</p>'+

							  	'</a>';
					});		
					html += '</div>';
				}else{	html = "<p>No hay traducciones para la categoria.</p>"; }
				$("#modalVerRecurso").find(".modal-body>#modalContent").empty().html(html);
				$("#modalVerRecurso").find('.modal-body>#modalLoading').css('display', 'none');
				var btnEditar = document.getElementById("btnEditarRecurso");
				btnEditar.innerHTML = 'EDITAR';
			    btnEditar.href = "<?=base_url();?>admin/recurso/edit/"+id;
			}).fail(function(e) {
				$("#modalVerRecurso").find('.modal-body>#modalLoading').css('display', 'none');
				$("#modalVerRecurso").find(".modal-body>#modalContent").empty().html(e.responseText);
				console.log(e.responseText);
			});
		});


	});

	function operacion(id_producto,id_recurso,id_codigo_producto,estado){
		$.ajax({
			//url: '<?=base_url();?>admin/recurso/recurso_asociar_producto', // URL para asociar recurso y producto mediante id_recurso y id_producto
			url: '<?=base_url();?>admin/recurso/recursoAsociarIdCodigoProducto', // URL para asociar productos y recurso mediante id_codigo_producto y id_recurso
			type: 'POST',
			dataType: 'json',
			data: {id_producto: id_producto,id_recurso:id_recurso,estado:estado,icp:id_codigo_producto},
		}).done(function(data) {
			if (data.response === 'OK' ) {
				switch(parseInt(estado)){
					case 0:
						//Desactivar Botón Check
					break;
					case 1:
						//Activar Botón Check
					break;
					default:
						//No Hacer nada
					break;
				}
			}
			//console.log(data);
		}).fail(function(e) {
			console.log(e.responseText);
			swal("Error..!",e.responseText,"error");
		});
	}
</script>
<style type="text/css">
@media (max-width: 700px) {
    .name>div:first-child{
        background: #337ab7;
    color: #fff;
    }
}
    
</style>