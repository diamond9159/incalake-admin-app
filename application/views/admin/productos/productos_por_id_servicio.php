<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title><?=nombre_incalake;?></title>
	
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
					// var_dump($resultados);
					/*var_dump($resultados);*/
					//var_dump($idiomas);
					//echo json_encode($resultados);
					//echo json_encode($idioma);
					if($resultados){
						 $html = '<div class="container-fluid"><div class="titulo-producto">SERVICIO<span class="fa fa-chevron-right" style="vertical-align: middle;color: #5cb85c;"> </span>'.$resultados[0]['titulo_pagina'].'</div><div class="alert alert-info" style="padding:7px;"><b>URL:</b><a>'.$resultados[0]['url_servicio'].'</a>'.
						 '<p><b>DESCRIPCIÓN: </b>'.$resultados[0]['descripcion_pagina'].'</p>'.
						 '</div>'.
						 '<span></span>'.
						 '<div class="text-right"><button class=" btn btn-success" onclick="location.href=\''.base_url().'admin/productos/agregar/'.$this->uri->segment(4).'\';"><span class="fa fa-plus"></span> Agregar Actividad</button></div>'.
						 '<div class="col-md-12 header-list hidden-xs hidden-sm">'.
						 	'<div>'.
						 	'<div class="col-md-2">Código</div>'.
							'<div class="col-md-7">Actividades Asociadas</div>'.
							'<div class="col-md-3">Operaciones</div>'.
							'</div>'.
						'</div>';
						 foreach ($resultados as $key=>$value) {
						 	$numeracion='';
						 	$numeracion=$key+1;
							   	$html.='<div class="col-md-12 div-tabla">'.
							   	'<div class="col-md-2 div-id-actividad">'.ucwords(strtolower(str_pad($value['id_codigo_producto'],3,"0",STR_PAD_LEFT) )).'</div>'.
							   	'<div class="col-md-7" >'.
							   	'<a  href="'.base_url().'admin/productos/codproducto/'.$value['id_codigo_producto'].'">'.ucwords(strtolower($value['titulo_producto'])).'</a>'.
							   	'</div>'.
    					'<div class="col-md-3 text-center " >'.
    					'<div class="btn-group">'.
					    '<a title="METODO DE PAGO DEL SERVICIO" href="javascript:void(0);" class="btn btn-success btn-sm btn-metodo-pago-actividad" data-id="'.@$value['id_producto'].'" data-codigo="'.@$value['id_codigo_producto'].'"><span class="fa fa-credit-card"></span></a>'.
					    '<a title="Email del Operador de la Actividad" href="javascript:void(0);" class="btn btn-warning btn-sm btn-operador-actividad" data-id="'.@$value['id_producto'].'" data-codigo="'.@$value['id_codigo_producto'].'"><span class="fa fa-envelope-o"></span></a>'.
					    '<a title="Editar Actividad" href="'.base_url().'admin/productos/editar/'.$value['id_producto'].'" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a>'.
					    '<a title="Ver Actividades relacionadas en otros idiomas" href="'.base_url().'admin/productos/codproducto/'.$value['id_codigo_producto'].'" class="btn btn-warning btn-sm"><span class="fa fa-list"></span></a>'.
					    '<a title="Ver y Asociar Categorias" href="javascript:void(0);" data-id="'.$value['id_producto'].'" data-idioma="'.$idioma['codigo'].'" class="btn btn-success btn-sm btn-asociar-categoria"><span class="fa fa-tag"></span></a>'.
					    '<a title="Ver recursos de la Actividad" href="javascript:void(0);" class="btn btn-default btn-sm btn-asociar-recurso" data-id="'.$value['id_producto'].'" data-idioma="'.$idioma['codigo'].'"><span class="fa fa-gift"></span></a>'.
					    '<a href="javascript:void(0);" class="btn btn-danger btn-sm btn-eliminar-paquete-web" data-id="'.$value['id_producto'].'" title="Eliminar Actividad"><span class="fa fa-close"></span></a>'.
					    '</div>'.
					    '</div>'.
					    '</div>';
						 }
						 $html.='</div><div class="alert text-center"><a href="'.base_url().'admin/servicio"><div class="btn btn-danger"><span class="fa fa-chevron-left"></span> Regresar</div></a></div>';
						} else $html = '<div class="alert alert-danger"><b>No hay resultados..!</b></div>';
					echo $html;
					?>
		</div>

		</content>
		<!-- ---------------------- MODAL ------------------ -->
		<div class="modal fade" id="modal_recursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
		                </button>
		                <h4 class="modal-title text-center" id="exampleModalLabel"><strong><span class="fa fa-list"></span> Lista de Recursos</strong></h4>
		                <input type="hidden" name="txt_id_recurso_modal" id="txt_id_recurso_modal">
		            </div>
		            <div class="modal-body">
		                <h4>Seleccione y/o asocie el Paquete Turistico a cualquiera de los recursos.</h4>
		                <div class="container-fluid" id="container_list_productos">
		                	<h5>Cargando...</h5>
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-success" data-dismiss="modal">GUARDAR</button>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="modal_categorias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
		                </button>
		                <h4 class="modal-title text-center" id="exampleModalLabel"><strong><span class="fa fa-list"></span> Lista de Categorias</strong></h4>
		                <input type="hidden" name="txt_id_categoria_modal" id="txt_id_categoria_modal">
		            </div>
		            <div class="modal-body">
		                <h4>Seleccione y/o asocie el Paquete Turistico a la  categoria correspondiente.</h4>
		                <div class="container-fluid" id="container_list_categorias">
		                	<h5>Cargando...</h5>
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-success" data-dismiss="modal">GUARDAR</button>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="modal_operador" tabindex="-1" role="dialog" aria-labelledby="modal_operador">
		    <div class="modal-dialog modal-lg" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
		                </button>
		                <h4 class="modal-title text-center" id="exampleModalLabel"><strong><span class="fa fa-list"></span> Operador del Servicio</strong></h4>
		                <input type="hidden" name="txtIdServicioModal" id="txtIdServicioModal">
		                <input type="hidden" name="txtICPServicioModal" id="txtICPServicioModal">
		            </div>
		            <div class="modal-body">
		                <div class="container-fluid">
							<div class="row">
								<div class="col-md-5 col-sm-5 col-xs-12 bg-warning">
									<h4>AGREGAR NUEVO OPERADOR</h4>	
									<div class="form-group">
									    <label for="Nombre_Operador">Ingrese Nombre del Operador del Servicio</label>
									    <input type="text" class="form-control" name="txtNombreOperador" id="txtNombreOperador" placeholder="Nombre del Operador" autofocus="true">
									</div>
									<div class="form-group">
									    <label for="Email_Operador">Ingrese E-mail del Operador del Servicio</label>
									    <input type="text" class="form-control" name="txtEmailOperador" id="txtEmailOperador" placeholder="E-mail del Operador">
									</div>
									<div class="checkbox">
									    <label>
									      <input type="checkbox" name="chckbxClonable" id="chckbxClonable"> Activar el E-mail del operador para todas las versiones del Idioma del Servicio.
									    </label>
									</div>
									<div class="text-center">
										<button class="btn btn-info btnGuardarOperador" id="btnGuardarOperador">GUARDAR</button>
										<br/><br/>
									</div>
								</div>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<h3 class="text-info">OPERADORES DISPONIBLES</h3>
									<div class="container-fluid" id="container_list_operadores">
					                	<h5>Cargando...</h5>
					                </div>
								</div>
							</div>
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-danger" data-dismiss="modal">GUARDAR Y CERRAR</button>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="modal_metodo_pago" tabindex="-1" role="dialog" aria-labelledby="modal_metodo_pago">
		    <div class="modal-dialog modal-xs" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
		                </button>
		                <h4 class="modal-title text-center" id="exampleModalLabel"><strong><span class="fa fa-list"></span> METODO DE PAGO DEL SERVICIO</strong></h4>
		                <input type="hidden" name="txtIdServicioModal" id="txtIdServicioModal">
		                <input type="hidden" name="txtICPServicioModal" id="txtICPServicioModal">
		            </div>
		            <div class="modal-body">
		                <div class="container-fluid">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 bg-warning">
									<h4>SELECCIONAR METODO DE PAGO:</h4>
									<div class="radio">
										<label><input type="radio" name="rdbtnMetodoDePago" value="0" id="rdbtnMetodoDePagoTodos">Todos (Habilitar todos los Metodos de Pago)</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="rdbtnMetodoDePago" value="1" id="rdbtnMetodoDePagoPaypal">PAYPAL</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="rdbtnMetodoDePago" value="2" id="rdbtnMetodoDePagoCulqiPayme">CULQI, PAYME</label>
									</div>
									<br/>
									<div class="checkbox">
									    <label>
									      <input type="checkbox" name="chckbxClonableMetodoDePago" id="chckbxClonableMetodoDePago"> Activar el Metodo de pago seleccionado para todas las versiones del Idioma del Servicio.
									    </label>
									</div>
									<div class="checkbox">
										<div class="text-center" id="divSpinnerLoading" style="display: none;">
											<p id="spinnerLoading"></p><br/><br/><br/>
											<p class="text-info" id="loadingText"><strong>GUARDANDO!</strong></p>
										</div>		
									</div>
								</div>
								<div class="col-md-12">

								</div>
							</div>
		                </div>
		            </div>
		            <div class="modal-footer">
		            <!--   
		                <button type="button" class="btn btn-danger" data-dismiss="modal">GUARDAR Y CERRAR</button>
		            -->
		            	<div class="btn btn-success btn-metodo-pago-modal">GUARDAR Y CERRAR</div>
		            </div>
		        </div>
		    </div>
		</div>
		<!-- -------------------------------------------------- -->

		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
	</body>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$(document).on('click', '.btn-eliminar-paquete-web', function(event) {
	            event.preventDefault();
	            var id_delete  =  $(this).data('id');
	            console.log(id_delete);
	            swal({
	              title: "Estas seguro de eliminar este Paquete Turístico..?",
	              text: "Si eliminas este Paquete web tambien se eliminaran automaticamente de la lista de Actividades.",
	              type: "warning",
	              showCancelButton: true,
	              confirmButtonColor: "#DD6B55",
	              confirmButtonText: "Si, Quiero Eliminar!",
	              cancelButtonText: "No, Cancelar",
	              closeOnConfirm: false
	            },
	            function(){
	                $.ajax({
	                    url: '<?=base_url().'admin/productos/remove/';?>'+parseInt(id_delete),
	                    type: 'DELETE',
	                    dataType: 'json',
	                    data: {},
	                }).done(function(data) {
	                    if ( data.response === 'OK' ) {
	                        //$('.btn-eliminar-pagina-web').parent().parent().remove();
	                        swal("Confirmación","Se ha eliminado correctamente..!","success");
	                        location.reload();
	                    }else{
	                        swal("Oops..!","No se ha podido eliminar, Intente nuevamente por favor..!","error");
	                    }
	                    console.log(data);
	                }).fail(function(e) {
	                    console.log(e.responseText);
	                });
	            });
	        });

			$(document).on('click', '.btn-asociar-recurso', function(event) {
				event.preventDefault();
				var id_producto = $(this).data('id');
				var codigo_idioma = $(this).data('idioma');
				console.log("ID Producto: " + id_producto + " CODIGO IDIOMA: " + codigo_idioma);
				$('#modal_recursos').modal('show');
				$("#txt_id_recurso_modal").empty().val(id_producto);
				$.ajax({
					url: '<?=base_url();?>admin/recurso/list_all_recursos',
					type: 'POST',
					dataType: 'json',
					data: {id_producto: id_producto},
				}).done(function(data) {
					console.log(data);
					var html_paquetes_turisticos = '';
					if (data['recursos'] != 0 ) {
						$.each(data['recursos'], function(index, val) {
							var json_nombre_recurso = JSON.parse(val.nombre_recurso);
							var checked = '';
							if ( val['asociado'] === true ) { checked = 'checked'; }
	                		
	                		html_paquetes_turisticos += '<li class="list-group-item">'+primera_letra_mayuscula(json_nombre_recurso[codigo_idioma])+
															'<span class="pull-right">'+
																'<input type="checkbox" '+checked+' name="chckbx_producto" class="chckbx_producto" data-id="'+val['id_recurso']+'">'+
															'</span>'+
														'</li>';
						});
	                }else{
	                	html_paquetes_turisticos = '<strong><small>No hay recursos registrados en la base de datos.<small></strong>';
	                }
	                $("#container_list_productos").empty().append(html_paquetes_turisticos);
				}).fail(function(e) {
					console.log(e.responseText);
					swal("Error..!",e.responseText,"error");
				});	
			});

			$(document).on('change', '.chckbx_producto', function(event) {
				event.preventDefault();
				var id_producto = $("#txt_id_recurso_modal").val();
				var id_recurso  = $(this).data("id");
				console.log("ID PRODUCTO: " + id_producto + " ID RECURSO: " + id_recurso );
				if($(this).is(':checked')){
					console.log("checkeado..!");
					operacion(id_producto,id_recurso,1);
				}else{
					console.log("No checkeado..!");
					operacion(id_producto,id_recurso,0);
				}
			});

			$(document).on('click', '.btn-asociar-categoria', function(event) {
				event.preventDefault();
				var id_producto = $(this).data("id");
				var id_idioma      = $(this).data('idioma');
				console.log("ID PRODUCTO: " + id_producto + "   " + "IDIOMA: " + id_idioma);
				$('#modal_categorias').modal('show');
				$("#txt_id_categoria_modal").empty().val(id_producto);
				$.ajax({
					url: '<?=base_url();?>admin/categoria/get_categoria_json',
					type: 'POST',
					dataType: 'JSON',
					data: {id: id_producto,language: id_idioma},
				}).done(function(data) {
					console.log(data);
					var html_categorias = '';
					if (data.length != 0 ) {
						$.each(data, function(index, val) {
							var checked = '';
							if ( val['id_producto'] ) { checked = 'checked'; }
	                		console.log(val['id_producto']);
	                		html_categorias += '<li class="list-group-item"><span class="fa fa-tag text-success"></span> '+primera_letra_mayuscula(val['nombre_categoria'])+
															'<span class="pull-right">'+
																'<input type="checkbox" '+checked+' name="chckbx_categoria" class="chckbx_categoria" data-id="'+val['id_categoria']+'">'+
															'</span>'+
														'</li>';
						});
					}else{
						html_categorias = '<strong><small>No hay categorias registradas en la base de datos.<small></strong>';
					}
					$("#container_list_categorias").empty().append(html_categorias);
				}).fail(function(e) {
					console.log(e.responseText);
				});
			});
			$(document).on('change', '.chckbx_categoria', function(event) {
				event.preventDefault();
				var id_producto = $("#txt_id_categoria_modal").val();
				var id_categoria= $(this).data("id");
				console.log("ID PRODUCTO: " + id_producto + " ID CATEGORIA: " + id_categoria );
				if($(this).is(':checked')){
					console.log("checkeado..!");
					operacion_categoria(id_producto,id_categoria,1);
				}else{
					console.log("No checkeado..!");
					operacion_categoria(id_producto,id_categoria,0);
				}
			});
		});
		
		function operacion(id_producto,id_recurso,estado){
			$.ajax({
				url: '<?=base_url();?>admin/recurso/recurso_asociar_producto',
				type: 'POST',
				dataType: 'json',
				data: {id_producto: id_producto,id_recurso:id_recurso,estado:estado},
			}).done(function(data) {
				console.log(data);
			}).fail(function(e) {
				console.log(e.responseText);
			});
		}
		function operacion_categoria(id_producto,id_categoria,estado){
			$.ajax({
				url: '<?=base_url();?>admin/categoria/categoria_asociar_producto',
				type: 'POST',
				dataType: 'json',
				data: {id_producto: id_producto,id_categoria:id_categoria,estado:estado},
			}).done(function(data) {
				console.log(data);
			}).fail(function(e) {
				console.log(e.responseText);
			});
		}
		$(document).on('click', '.btn-metodo-pago-actividad', function(event) {
			event.preventDefault();
			var idProducto 			= $(this).data('id');
			var idCodigoProducto 	= $(this).data("codigo");
			//console.log("ID PRODUCTO: " + idProducto + " ID CODIGO PRODUCTO: " + idCodigoProducto );
			$("#modal_metodo_pago").modal("show");
			$("#modal_metodo_pago").find('#txtIdServicioModal').val(idProducto);
			$("#modal_metodo_pago").find('#txtICPServicioModal').val(idCodigoProducto);
			$('#modal_metodo_pago').find('#txtNombreOperador').focus();
			
			actualizarMetodoPago(idProducto);
			
			//listarOperadores(idProducto,idCodigoProducto);			
		});
		$(document).on('click', '.btn-operador-actividad', function(event) {
			event.preventDefault();
			var idProducto 			= $(this).data('id');
			var idCodigoProducto 	= $(this).data("codigo");
			//console.log("ID PRODUCTO: " + idProducto + " ID CODIGO PRODUCTO: " + idCodigoProducto );
			$("#modal_operador").modal("show");
			$("#modal_operador").find('#txtIdServicioModal').val(idProducto);
			$("#modal_operador").find('#txtICPServicioModal').val(idCodigoProducto);
			$('#modal_operador').find('#txtNombreOperador').focus();
			
			listarOperadores(idProducto,idCodigoProducto);			
		});
		$(document).on('click', '#btnGuardarOperador', function(event) {
			event.preventDefault();
			var idProducto 			= $('#modal_operador').find('#txtIdServicioModal').val();
			var idCodigoProducto 	= $('#modal_operador').find('#txtICPServicioModal').val();
			var nombreOperador 		= $('#modal_operador').find('#txtNombreOperador').val();
			var emailOperador 		= $('#modal_operador').find('#txtEmailOperador').val();
			var clonable			= false ;
			if ($('#modal_operador').find('#chckbxClonable').is(':checked') ) {
				clonable = true;
			}
			if (nombreOperador.trim().length <= 0  ) {
				$('#modal_operador').find('#txtNombreOperador').focus();
				return false;
			}
			if ( emailOperador.trim().length <= 0 ) {
				$('#modal_operador').find('#txtEmailOperador').focus();
				return false;
			}else{
				if ( !emailValido( emailOperador ) ) {
					$('#modal_operador').find('#txtEmailOperador').focus();
					swal("Email Inválido","Ingrese un email válido...!","warning");	
					return false;
				}
			}
			//$("#modal_operador").modal('hide');
			$.ajax({
				url: '<?=base_url();?>admin/operador/addAjax',
				type: 'POST',
				dataType: 'JSON',
				data: { id_producto: idProducto,id_codigo_producto: idCodigoProducto, nombre_operador: nombreOperador, email_operador: emailOperador, clonable: clonable },
			}).done(function(data) {
				console.log(data);
				listarOperadores(idProducto,idCodigoProducto);
			}).fail(function(e) {
				console.log(e.responseText);
			});
			resetFormOperador();
		});

		$(document).on('click', '.chckbx_operador', function(event) {
			event.preventDefault();
			var idProducto 			= $(this).data('id');
			var idCodigoProducto 	= $(this).data('codigo');
			var idOperador 			= $(this).data('ido');
			var activado 			= $(this).data('val');
			console.log("ID PRODUCTO",idProducto,"idCodigoProducto",idCodigoProducto,"ID OPERADOR",idOperador,"ACTIVADO",activado);
			//console.log("ID PRODUCTO",idProducto,"ICP",idCodigoProducto);
			updateCheckBox(idProducto,idCodigoProducto,idOperador,activado);
			
		});
		
		$(document).on('click', '.btn-eliminar-operador', function(event) {
			event.preventDefault();
			var idProducto 			= $(this).data('id');
			var idCodigoProducto 	= $(this).data('codigo');
			var idOperador 			= $(this).data('ido');
			console.log("ID PRODUCTO",idProducto,"ICP",idCodigoProducto,"ID OPERADOR",idOperador);
			eliminarOperador(idProducto,idCodigoProducto,idOperador);
		});
		$(document).on('click', '.btn-metodo-pago-modal', function(event) {
			event.preventDefault();
			$('#divSpinnerLoading').css('display','block');
			$(".btn-metodo-pago-modal").attr("disabled", true);
			var spinner = new Spinner({
				lines: 12, // The number of lines to draw
				length: 7, // The length of each line
				width: 5, // The line thickness
				radius: 10, // The radius of the inner circle
				color: '#000', // #rbg or #rrggbb
				speed: 1, // Rounds per second
				trail: 100, // Afterglow percentage
				shadow: true // Whether to render a shadow
			}).spin(document.getElementById("spinnerLoading"));

			var idProducto 			= $('#modal_metodo_pago').find('#txtIdServicioModal').val();
			var idCodigoProducto 	= $('#modal_metodo_pago').find('#txtICPServicioModal').val();
			var metodoPago 		    = $('#modal_metodo_pago').find('input:radio[name=rdbtnMetodoDePago]:checked').val();
			var clonable			= false ;
			if ($('#modal_metodo_pago').find('#chckbxClonableMetodoDePago').is(':checked') ) {
				clonable = true;
			}
			cambiarMetodoPago(idProducto,idCodigoProducto,metodoPago,clonable);
			//$('#loadingText').text("GUARDADO CON ÉXITO!");
			setTimeout(function() {
				$('#divSpinnerLoading').css('display','none');
				$(".btn-metodo-pago-modal").attr("disabled", false);
				$('#modal_metodo_pago').find('#chckbxClonableMetodoDePago').prop('checked', false);
				$("#modal_metodo_pago").modal("hide");
			}, 2500);
			//console.log("ID PRODUCTO",idProducto,"ICP",idCodigoProducto,"METODO PAGO",metodoPago,"CLONABLE",clonable);
		});

		function cambiarMetodoPago(idProducto,idCodigoProducto,metodoPago,clonable){
			$.ajax({
				url: '<?=base_url()?>admin/metodopago/actualizar',
				type: 'POST',
				dataType: 'JSON',
				data: {idProducto: idProducto, idCodigoProducto: idCodigoProducto, metodoPago: metodoPago,clonable: clonable},
			}).done(function(data) {
				console.log(data);
			}).fail(function(e) {
				console.log(e.responseText);
			});
		}
		function actualizarMetodoPago(idProducto){
			$.ajax({
				url: '<?=base_url()?>admin/metodopago/metodo',
				type: 'POST',
				dataType: 'JSON',
				data: {idProducto: idProducto},
			}).done(function(data) {
				//console.log(data);
				$("input:radio[name=rdbtnMetodoDePago]").each(function(index, el) {
					var value = $(this).val();
					if( parseInt(value) === parseInt(data['metodo_pago']) ){
						$(this).prop( "checked", true );
					}
				});
			}).fail(function(e) {
				console.log(e.responseText);
			});
		}
		function resetFormOperador(){
			//$('#modal_operador').find('#txtIdServicioModal').val('');
			//$('#modal_operador').find('#txtICPServicioModal').val('');
			$('#modal_operador').find('#txtNombreOperador').val('');
			$('#modal_operador').find('#txtEmailOperador').val('');
		}
		function emailValido(email){
		    var reg=/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
		    if(reg.test(email)){
		    	return true; // Email correcto
		    }else{
		    	return false; // Email incorrecto
		    }
		}
		function updateCheckBox(id_producto,id_codigo_producto,id_operador,activado){
			$.ajax({
				url: '<?=base_url();?>admin/operador/updatecb',
				type: 'POST',
				dataType: 'JSON',
				data: {idProducto: id_producto, idCodigoProducto: id_codigo_producto, idOperador: id_operador, activado: activado},
			}).done(function(data) {
				console.log(data);
				listarOperadores(id_producto,id_codigo_producto);
			}).fail(function(e) {
				console.log(JSON.stringify(e))
			});
		}
		function eliminarOperador(id_producto,id_codigo_producto,id_operador){
			$.ajax({
				url: '<?=base_url();?>admin/operador/eliminar',
				type: 'POST',
				dataType: 'JSON',
				data: { idProducto: id_producto, idCodigoProducto: id_codigo_producto, idOperador: id_operador },
			}).done(function(data) {
				console.log(data);
				listarOperadores(id_producto,id_codigo_producto);
			}).fail(function(e) {
				console.log(JSON.stringify(e));
			});
		}
		function listarOperadores(id_producto,id_codigo_producto){
			$.ajax({
				url: '<?=base_url();?>admin/operador/operadores',
				type: 'POST',
				dataType: 'json',
				data: { idProducto: id_producto, idCodigoProducto: id_codigo_producto },
			}).done(function(data) {
				//console.log(JSON.stringify(data));
				var htmlOperadores = '';
				$.each(data, function(index, val) {
					if (val.o_id_producto === true) {
						if ( val.activo === true && parseInt(val.id_producto) === parseInt(id_producto) ) {
							htmlOperadores += '<li class="list-group-item bg-success" style="background:#76D7C4;"><strong> '+val.nombre_operador+'</strong> ('+val.email_operador+')'+
								'<span class="pull-right"><span class="btn-group"><span class="fa fa-check-square-o btn btn-success btn-xs chckbx_operador" title="Operador Seleccionado" data-val="0" data-id="'+val.id_producto+'" data-codigo="'+val.id_codigo_producto+'" data-ido="'+val.id_operador+'"></span><span class="fa fa-remove btn btn-xs btn-danger btn-eliminar-operador" data-id="'+val.id_producto+'" data-codigo="'+val.id_codigo_producto+'" data-ido="'+val.id_operador+'" title="Eliminar Operador"></span></span></span></li>';
						}else{
							htmlOperadores += '<li class="list-group-item" style="background:#F5B7B1;"><strong>'+val.nombre_operador+'</strong> ('+val.email_operador+')'+
								'<span class="pull-right"><span class="btn-group"><span class="fa fa-square-o btn btn-warning btn-xs chckbx_operador" title="Seleccionar Operador" data-id="'+val.id_producto+'" data-codigo="'+val.id_codigo_producto+'" data-ido="'+val.id_operador+'" data-val="1"></span><span class="fa fa-remove btn btn-xs btn-danger btn-eliminar-operador" data-id="'+val.id_producto+'" data-codigo="'+val.id_codigo_producto+'" data-ido="'+val.id_operador+'" title="Eliminar Operador"></span></span></span></li>';
						}
					}
				});
				$("#container_list_operadores").empty().append(htmlOperadores);
			}).fail(function(e) {
				console.log(e.responseText);
			});
		}		
	</script>
	<style type="text/css">
	@media screen and (max-width: 480px){
		.div-id-actividad{
			color: #fff;
    		background-color: #337ab7;
		}
	}
	</style>
</html>