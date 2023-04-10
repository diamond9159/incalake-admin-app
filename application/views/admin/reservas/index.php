<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<?php 
				//echo json_encode($reservas);
			?>
			<div id="data-reservas">
				<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-2 col-xs-12">
				  <input class="search form-control input-lg" autofocus="true" placeholder="Buscar reserva por código, nombres, e-mail, teléfono, etc." type="search" />
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th class="text-center">MET. PAGO</th>
									<th class="text-center">Código Reserva</th>
									<th>Nombres y Apellidos del Cliente</th>
									<th>Email</th>
									<th>Teléfono</th>
									<th>Estado de Reserva</th>
									<th>Más Opciones</th>
								</tr>
							</thead>
							<tbody class="list">
								<?php foreach ($reservas as $key => $value): ?>
									<tr>
										<td class="text-center">
											
											<img src="<?=base_url().'assets/img/metodos-de-pago/'.mb_strtolower(trim($value['metodo_pago'])).'.png';?>" class="img-thumbnail" title="<?=mb_strtoupper($value['metodo_pago']);?>"/>
											<!--
											<strong class="text-info"><?=mb_strtoupper($value['metodo_pago']);?></strong>
						-->					</td>										<td class="text-center codigo"><?=$value['codigo_reserva'];?></td>
										<td class="nombres"><?=mb_strtoupper($value['nombres_cliente'].' '.$value['apellidos_cliente']);?></td>
										<td class="email"><?=$value['email_cliente'];?></td>
										<td class="telefono"><?=$value['telefono_cliente'];?></td>
										<td><?=($value['confirmacion_pago']==1?"<strong class='label label-".((int)$value['pocentaje_pago']<100?'warning':'success')."'>PAGADO</strong> <span class='badge'>".($value['pocentaje_pago']?+$value['pocentaje_pago'].'%':null)."</span>":"<strong class='label label-danger'>NO PAGADO</strong> <span class='badge'>".($value['pocentaje_pago']?+$value['pocentaje_pago'].'%':null)."</span>");?> </td>
										<td>
										    <span data-id="<?=$value['id_reserva'];?>" class="btn btn-success btn-xs ver-detalles" title="Ver información completa de la Reserva" data-toggle="modal" data-target="#modal-ver-detalles"> <small>DETALLES</small></span>
										    <button onclick="location.href='<?=base_url('admin/reservas/datos_pasajeros/'.$value['id_reserva']);?>'" class="btn btn-info btn-xs" type="button" ><small>PASAJEROS</small></button>
										    <span class="btn btn-danger btn-xs btn-eliminar-reserva" data-idreserva="<?=@$value['id_reserva'];?>" title="Eliminar Reserva"><i class="fa fa-close"></i></span>
									</td>
										
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-ver-detalles" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
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

<script type="text/javascript">
jQuery(document).ready(function($) {
	/******************** start list js search *******************/
	var options = {
	  valueNames: [ 'codigo','nombres','email','telefono' ]
	};
	var userList = new List('data-reservas', options);	
	/********************* end list js search ********************/

	/***************** start ver detalle reserva *****************/
	$(document).on('click', '.ver-detalles', function(event) {
		event.preventDefault();
                $(document).find('.modal-body>#modal-body-ver-detalles').empty().append( loading() );
		var idReserva = $(this).data('id');
		//console.log(idReserva);
		//$(document).find('.modal-body>#modal-body-ver-detalles').text("ID: "+idReserva);
		$.ajax({
			url: '<?=base_url();?>admin/reservas/detallereserva',
			type: 'POST',
			dataType: 'JSON',
			data: {id: idReserva},
		}).done(function(data) {
			//console.log(JSON.stringify(data));
			//$(document).find('.modal-body>#modal-body-data-ver-detalles').text(JSON.stringify(data));
			verDetalleReservaHTML(data);
		}).fail(function(e) {
			console.log(e.responseText);
		});	
	});
	
	$(document).on('click', '.btn-eliminar-reserva', function(event) {
		event.preventDefault();
		var idreserva=$(this).data('idreserva');
        var $this = $(this);
        
        swal({
          title: "Estas seguro de eliminar esta reserva...?",
          text: "Si eliminas esta reserva se perderán toda la información acerca de esta reserva.",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, Quiero Eliminar!",
          cancelButtonText: "No, Cancelar",
          closeOnConfirm: false
        },
        function(){
            $.ajax({
            	url: '<?=base_url()?>admin/reservas/remove',
            	type: 'POST',
            	dataType: 'json',
            	data: {id: idreserva},
            }).done(function(data) {
            	if (data.response === "success" ) {
            	    swal("Confirmación","Se ha eliminado correctamente..!","success");
            	    $this.parents('tr').remove();	
            	}else{
            	    swal("Error","No se ha podido eliminar el registro","error");
            		console.log("Error eliminando reserva.");
            	}
            	//console.log(data);
            }).fail(function(e) {
            	swal("Error","No se ha podido conectar al servidor.","error");
            	console.log(e.responseText);
            });
        });
	});

	$(document).on('click', '.btn_editar_comentario', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id=$(this).data('idreserva');
		$('.textarea_comentario_'+id).removeAttr('readonly');
		$('.textarea_comentario_'+id).focus();
	});
	$(document).on('click', '.btn_guardar_comentario', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id=$(this).data('idreserva');
		var comentario=$('.textarea_comentario_'+id).val();
		console.log('cometnario',comentario);

		$.ajax({
			url: '<?=base_url();?>admin/reservas/editar_comentario_reserva',
			type: 'POST',
			dataType: 'JSON',
			data: {idreserva: id,comentario:comentario},
		})
		.done(function(data) {
			// console.log("success",data);
			$('.msn_comentario').html(data);
		})
		.fail(function() {
			console.log("error");
		});
		
	});
	/****************** end ver detalle reserva ******************/
	function verDetalleReservaHTML(data){
		var detalleReservaHTML = '';
		detalleReservaHTML += '<div class="row" style="padding:5px">';
		
		$.each(data, function(index, val) {
			var mtotal = +(100 / +val['porcentaje_pago'] * +val['monto_adelanto']).toFixed(2);
				mtotal = mtotal?mtotal:0;
			detalleReservaHTML += '<table class="table">'+
					'<tr><td>CÓDIGO RESERVA:</td><td>'+val['codigo_reserva']+'</td></tr>'+
					'<tr><td>FECHA DE COMPRA:</td><td>'+val['fecha_compra']+'</td></tr>'+
					'<tr><td>NOMBRES:</td><td>'+val['nombres_cliente']+'</td></tr>'+
					'<tr><td>E-MAIL:</td><td>'+val['email']+'</td></tr>'+
					'<tr><td>N° TELÉFONO:</td><td>'+val['telefono']+'</td></tr>'+
					'<tr><td>ESTADO DE PAGO:</td><td id="cont_porce_pago"><strong>'+val['texto_pagado']+'</strong> <strong> '+val['porcentaje_pago']+'% ($'+val['monto_adelanto']+' de $'+mtotal+')</strong> - <strong>'+(val['metodo_pago']).toUpperCase()+'</strong></td></tr>'+
					'<tr><td>FECHA DE LAS CUOTAS</td><td>'+(val['fecha_cuotas'] || '---')+'</td></tr>'+
					'<tr><td>#:</td><td>'+(+val['porcentaje_pago']<100 && +val['porcentaje_pago']?'<div><label>Completar el pago <input title="activar form para completar pago" class="check_cancelar" type="checkbox"></label> <input disabled type="number" name="monto" value="'+ +(mtotal - +val['monto_adelanto']).toFixed(2)+'" style="width:100px"> <input disabled name="detalles" type="text" placeholder="Detalles"> <input type="hidden" name="porcentaje" value="'+(100 - +val['porcentaje_pago'])+'" > <input type="hidden" name="id_reserva" value="'+val['id_reserva']+'" > <button disabled class="btn btn-success enviar_form" type="button"><i class="fa fa-check"></i></button></div>':val['detalle_cuota'] || 'Esta reserva aun no ha sido pagada.')+'</td></tr>'+
					'<tr class="div_comentario"><td>Comentario:</td><td><div class="pull-right"><span class="btn btn-primary btn-sm btn_editar_comentario" data-idreserva="'+val['id_reserva']+'">editar</span><span class="btn btn-success btn-sm btn_guardar_comentario" data-idreserva="'+val['id_reserva']+'">guardar</span></div><textarea readonly class="form-control textarea_comentario_'+val['id_reserva']+'" rows="4">'+(val['comentario']?val['comentario']:'')+'</textarea><div class="msn_comentario"></div></td></tr>'+
			'</table>';

			

			//detalleReservaHTML += '<div class="container-fluid">';
			$.each(val['detalle_servicio'], function(i, v) {
			detalleReservaHTML +=	'<div class="container-fluid">'+
									'<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="alert alert-success container-fluid">'+
											'<div class="col-md-5">FECHA DE SERVICIO:</div><div class="col-md-7"><strong>'+v['fecha_servicio']+' a las '+v['hora_inicio_servicio']+'</strong></div>'+
											'<div class="col-md-5">SERVICIO:</div><div class="col-md-7"><strong>'+v['titulo_producto']+'</strong></div>'+
											'<div class="col-md-5">PRECIO TOTAL</div><div class="col-md-7"><strong>$ '+v['precio_total']+' <small>USD</small></strong></div>'+
											'<div class="col-md-12"><strong>CANTIDADES</strong></div>';
					$.each(v['resumen'], function(j, k) {
						detalleReservaHTML += '<div class="col-md-12"><p>'+k['cantidad']+' '+k['tipo_articulo']+'s '+k['nombre_articulo']+'</p></div>';
					});	
					if(v['email_operador']){
					    if( parseFloat(v['operador_confirmado']) ){
							detalleReservaHTML += '<div class="col-md-5">Información sobre el Operador</div><div class="col-md-7"><span class="fa fa-envelope-o text-success"></span> E-mail enviado al Operador</div>';				
						}else{
							detalleReservaHTML += '<div class="col-md-5">Información sobre el Operador</div><div class="col-md-7 text-danger"><span class="fa fa-envelope-o text-danger"></span> No se pudo enviar el E-mail, envié los datos a <strong>'+v['email_operador']+'</strong></div>';
						}
					}							
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

	/* scripts para guardar precios faltantes cancelar la ultima cuota */
	$('#modal-body-ver-detalles').on('change','.check_cancelar',function(){
		// buscar los campos del formulario 
		var elementos = $(this).closest('div').find('input,button');
		// si check esta activado
		if($(this).is(":checked")){
			// activar elementos del form
			elementos.removeAttr('disabled');	
		}
		else {
			// desactivar elementos del form
			elementos.attr('disabled','disabled');
			// activar el check ya que se desabilitó por la sentencia anterior por alcance
			$(this).removeAttr('disabled');
		}
	});

	// al hacer click en el boton de enviar form marcado con una aspa
	$('#modal-body-ver-detalles').on('click','.enviar_form',function(){
			// recuperar valor del boton del click
		    var btn = $(this);
		    var elem_padre = btn.parent();
			// obtener los inputs del form 
			var data = elem_padre.find('input');
			
			// console.log(data.serializeArray());
			// declarar variable del validador en true (se usará para detectar que todo los campos esten debidamente completados)
			var validador = true;
			// bucle a los campos del formulario para detectar campos vacios
			data.each(function(i){
				if(!$(this).val()){
					//alert($(this).val());
					// resaltar el borde de color rojo el input en caso este vacio
					$(this).css('border-color','#ff3e3e').focusin(function(){$(this).css('border-color','#CCC')});
					// validacion no exitosa
					validador = false;
				}
			});
			// si todo esta correcto enviar la informacion por ajax
			if(validador){
				// desabilitar el boton del form para evitar dblclick
				btn.attr('disabled','disabled');
				$.post('<?=base_url();?>admin/reservas/guardar_cuota',data.serializeArray(),function(datos){
					if(!isNaN(datos)){
						elem_padre.html(data.eq(2).val());
						// actualizar datos de los indicadores de porcentaje
						var indicadores = $('#cont_porce_pago strong');
						indicadores.eq(0).find('span').attr('class','label label-success');
						indicadores.eq(1).html('(100%)');

					} else {
						// si el servidor no retorna un valor numerico entoces hubo un error 
						alert('Errores al guardar intente de nuevo');
						// habilitar otra vez el boton de envio
						btn.removeAttr('disabled');
					}
				});
			}
			
	});
	/* fin de cancelar precios faltantes */
});
function loading(){
	return ( '<div class="text-center"><img src="https://shop.incalake.com/img/index.gif" alt="Wait a moment please..!"></div> ' );
}
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var mm2 = today.getMonth();
var yyyy = today.getFullYear();
if(dd<10) {
    dd = '0'+dd;
} 
if(mm<10) {
    mm = '0'+mm;
} 
if(mm2<10) {
    mm2 = '0'+mm2;
} 
today =yyyy+'-'+mm+'-'+dd;
antes=yyyy+'-'+mm2+'-'+dd;
console.log('today',antes+' '+today);
$('.search').parent().parent().append('<a class="text-white btn btn-danger" href="<?=base_url()?>admin/reservas/analytics/'+antes+'/'+today+'"><span class="fa fa-area-chart"></span> Analytics</a>');
</script>
<style>
/* estilos de la tabla para ver detalles en el modal */
 #modal-ver-detalles table.table tr td:first-child{
	 font-weight:bold;
	 background:#f8fcfc;
 }
 #modal-ver-detalles table.table{
	 border-width:0;
 }
 .text-white{
 	color: #fff!important;
 }
 /* fin de los estilos de la tabla dentro de modalesS*/
</style>