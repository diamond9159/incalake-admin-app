<div class="container"> 
		<?php //echo base_url() ?>
		<div class="col-md-12 bg-primary text-light text-center" style="padding: 4px;text-transform: uppercase;">
			<div class="col-12 col-md-2">N°</div>
			<div class="col-12 col-md-4">nombre</div>
			<div class="col-12 col-md-4">email</div>
			<div class="col-12 col-md-2">opcion</div>
		</div>
		<?php //echo json_encode($all_idiomas) ?>
		<?php foreach ($all_suscripciones as $key => $value): ?>
			<div class="col-md-12" style="border: 1px solid #ddd;padding: 3px;margin: 0px">
				<div class="col-12 col-md-2"><?=$value['id_suscripcion']?></div>
				<div class="col-12 col-md-4"><?=$value['nombre_suscripcion']?></div>
				<div class="col-12 col-md-4"><?=$value['email_suscripcion']?></div>
				<div class="col-12 col-md-2 text-center">
					<span class="btn btn-success btn-xs btn_detalle_suscripcion" data-idsuscripcion="<?=$value['id_suscripcion']?>"><span class="fa fa-pencil"></span></span>
					<span class="btn btn-danger btn-xs btn_eliminar_suscripcion" data-idsuscripcion="<?=$value['id_suscripcion']?>"><span class="fa fa-close"></span></span>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<!-- Modal -->
	 <div class="modal fade" id="suscripcion_detalle" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Modal Header</h4>
	        </div>
	        <div class="modal-body">
	          <p>Some text in the modal.</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	      </div>
	      
	    </div>
	 </div>
	<script type="text/javascript">
		var base_url='<?=base_url()?>'
		$(document).on('click', '.btn_detalle_suscripcion', function(event) {
			event.preventDefault();
			var suscripcion_detalle_txt='';
			var idioma_txt='';
			
			console.log($(this).data('idsuscripcion'));
			$.ajax({
                     url: base_url+"admin/suscripcion/get_suscripcion",
                     type: 'POST',
                     dataType: 'json',
                     data: {id:$(this).data('idsuscripcion')},
                   })
                   .done(function(data) {
                     console.log("success",data);
                     suscripcion_detalle_txt+=`
                     <div class="col-md-12 bg-primary" style="padding:4px;">
	                     <div class="col-md-4">Nombre suscripcion</div>
	                     <div class="col-md-4">Email suscripcion</div>
	                     <div class="col-md-4">Fecha suscripcion</div>
                     </div>
                     <div class="col-md-12 bg-white" style="padding:3px;border:1px solid #ddd;">
	                     <div class="col-md-4">${data.suscripcion.nombre_suscripcion}</div>
	                     <div class="col-md-4">${data.suscripcion.email_suscripcion}</div>
	                     <div class="col-md-4">${data.suscripcion.fecha_suscripcion}</div>
                     </div>
                     <div class="col-md-12 " style="padding:4px;">
	                     <div class="bg-primary col-md-6">Idioma</div>
	                     <div class="col-md-6" id="idioma_txt">-</div>
                     </div>
                     <div class="col-md-12 bg-primary" style="padding:4px;">
	                     <div class="col-md-4">Destino</div>
	                     <div class="col-md-4">Duracion de viaje</div>
	                     <div class="col-md-4">Fecha de viaje</div>
                     </div>
                     `;
                     data.suscripcion_detalle.forEach(function(val,index){
                     	suscripcion_detalle_txt+=`
                     	<div class="col-md-12 bg-white" style="padding:3px;border:1px solid #ddd;">
		                     <div class="col-md-4">${data.destinos_footer[val.id_destino].nombre_destino}</div>
		                     <div class="col-md-4">${val.duracion_viaje}</div>
		                     <div class="col-md-4">${val.fecha_viaje}</div>
	                     </div>
                     	`;
                     	idioma_txt=data.destinos_footer[val.id_destino].id_idioma;
                     	
                     	// console.log('data.val',val);
                     });
                     $('#suscripcion_detalle').modal();
                     $('#suscripcion_detalle .modal-body').html(suscripcion_detalle_txt);
                     $('#idioma_txt').html(data.all_idiomas[idioma_txt].codigo);
                     // 
                     
                     
                   })
                   .fail(function(e) {
                    console.log(e.responseText)
                     console.log("error");
                   });
			/* Act on the event */
		});
		$(document).on('click', '.btn_eliminar_suscripcion', function(event) {
        	event.preventDefault();
        	
        	if (ConfirmDelete()) {
        		var data_id_suscripcion=$(this).data('idsuscripcion');
        		$.ajax({
        			url: base_url+"admin/suscripcion/delete_suscripcion",
        			type: 'POST',
        			dataType: 'json',
        			data: {id_suscripcion:data_id_suscripcion},
        		})
        		.done(function(data) {
        			console.log("success",data);
        			location.reload();
        		})
        		.fail(function(e) {
        			console.log("error");
        		});
        	}
        	
        	
        });
		function ConfirmDelete()
            {
              var x = confirm("Are you sure you want to delete?");
              if (x)
                  return true;
              else
                return false;
            }
	</script>