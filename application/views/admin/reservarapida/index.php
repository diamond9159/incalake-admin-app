<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-md-sm-12 col-xs-12">
		<div class="headline">
				<div>LISTA DE RESERVAS RAPIDAS</div>
			</div>
			<div class="pull-right">
				<a href="<?=base_url().'admin/reservarapida/add';?>" class="btn btn-success"><span class="fa fa-plus"></span> RESERVA RAPIDA</a>
			</div>
			<h3 class="text-center text-info"><strong><span class="fa fa-list"></span> LISTA DE RESERVAS RAPIDAS</strong></h3>
			<hr/>
			<?php 
				//echo json_encode($reservarapidas);
			?>			
			<?php foreach ($reservarapidas as $key => $value): ?>
				<div class="alert alert-success">
					<span class="fa fa-close pull-right btn btn-danger btn-xs btn-eliminar-reservarapida" data-id="<?=$value['id_reservarapida'];?>" data-idpaquete="<?=$value['id_paquete'];?>" title="Eliminar Reserva Rápida"></span><a href="<?=base_url().'admin/reservarapida/edit/'.$value['id_reservarapida'];?>" class="fa fa-edit btn btn-info bt-xs pull-right" title="Editar Reserva Rápida"></a>
					<h4 class="text-info"><strong><?=mb_strtoupper($value['nombre_lider']);?></strong></h5>
					<h5 class="text-info"><strong><?=strtoupper(date_format(date_create($value['fecha_tour']),'d-M-Y' ) );?>&nbsp;&nbsp;-&nbsp;&nbsp;<?=mb_strtoupper($value['nombre_tour']);?></strong></h6>
					<h6 class="text-info">
						<strong>
						<?php if ( (integer)$value['nro_personas_adultas'] > 0 ): ?>
							<?=$value['nro_personas_adultas'];?> Persona(s) Adulta(s), $ <?=( (integer)$value["nro_personas_adultas"] * (integer)$value["precio_personas_adultas"] )?><small class="text-info"> USD</small>
						<?php endif ?>
						<?php if ( (integer)$value['nro_personas_menores'] > 0 ): ?>
							<?=$value['nro_personas_menores'];?> Persona(s) Adulta(s), $ <?=( (integer)$value["nro_personas_menores"] * (integer)$value["precio_personas_menores"] )?><small class="text-info"> USD</small>
						<?php endif ?>
						</strong>	
					</h6>
					<h6 class="text-info"><strong>
						<?php if ( !empty($value['pago']) ): ?>
							<?='PAGO MEDIANTE: '.$value['pago'];?>		
						<?php endif ?>	
					</strongl>
					</h6>
					<h6 class="text-info"><strong>
						<?php if ( !empty($value['datos_adicionales']) ): ?>
							<?='DATOS ADICIONALES: '.$value['datos_adicionales'];?>		
						<?php endif ?>	
					</strong>
					</h6>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-eliminar-reservarapida', function(event) {
			event.preventDefault();
			var data_id = $(this).data('id');
			swal({
              title: "Estas seguro de eliminar esta Reserva Rápida...?",
              text: "Confirma que estas seguro de eliminar, una vez eliminado no podrás recuperar el registro.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/reservarapida/remove/';?>'+parseInt(data_id),
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
                	swal("ERROR",e.responseText,"error");
                    console.log(e.responseText);
                });
            });
		});
	});
</script>