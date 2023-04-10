<div class="container-fluid">
<div class="pull-right"><a href="<?=base_url();?>admin/destinos/add" class="btn btn-success" title="Agregar Nuevo destino">AGREGAR</a></div>
	<table border="1" width="100%" class="table">
	    <tr>
			<th class="text-center">#</th>
			<th>Destino</th>
			<th>Descripción</th>
			<th class="text-center">ACCIONES</th>
	    </tr>
	    <?php $cantidad = 1; ?>
		<?php foreach($destinos as $d){ ?>
	    <tr>
			<td class="text-center"><?=$cantidad++; ?></td>
			<td><?php echo $d['nombre_destino']; ?></td>
			<td><?php echo $d['descripcion_destino']; ?></td>
			<td class="text-center">
	            <a href="<?php echo site_url('admin/destinos/edit/'.$d['id_destino']).'/'.$d['id_codigo_destino']; ?>" class="btn btn-info" title="Editar"><span class="fa fa-pencil"></span></a>
	            <a href="javascript:void(0);" class="btn btn-warning btnTraduccionesDestino" data-toggle="modal" data-target="#modalVerDestinos" data-id="<?=$d['id_destino']?>" data-idcodigo="<?=$d['id_codigo_destino']?>" title="Ver Traducciones"><span class="fa fa-th-list"></span></a>
	            <a href="<?=base_url();?>admin/destinos/Actividades/<?=$d['id_destino'].'/'.$d['id_codigo_destino'];?>" class="btn btn-success " data-id="<?=$d['id_destino']?>" data-idcodigo="<?=$d['id_codigo_destino']?>" title="Ver Actividades Asociadas"><span class="fa fa-list-ol"></span></a>
	            <a href="<?=base_url();?>admin/destinos/Actividades/<?=$d['id_destino'].'/'.$d['id_codigo_destino'];?>" class="btn btn-info" data-id="<?=$d['id_destino']?>" data-idcodigo="<?=$d['id_codigo_destino']?>" title="Agregar Actividad"><span class="fa fa-plus-square"></span></a> 
	            <a href="javascript:void(0);" data-id="<?=$d['id_destino']?>" data-idcodigo="<?=$d['id_codigo_destino']?>" class="btn btn-danger btnEliminarDestino" title="Eliminar"><span class="fa fa-times"></span></a>
	        </td>
	    </tr>
		<?php } ?>
	</table>
</div>


<div class="modal fade" id="modalVerDestinos" tabindex="-1" role="dialog" aria-labelledby="VerDestinos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel"><span class="fa fa-tag"></span> DESTINOS</h4>
            </div>
            <div class="modal-body" style="min-height: 12em;">
            	<div class="modalLoading" id="modalLoading"></div>
            	<div class="modalContent" id="modalContent"></div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-success btnEditarDestinoGrupo" id="btnEditarDestinoGrupo" title="Editar Información del Destino">EDITAR</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar Modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		new Spinner().spin(document.getElementById("modalLoading"));
		
		$(document).on('click', '.btnEliminarDestino', function(event) {
			event.preventDefault();
			var id_eliminar = $(this).data('id');
			var idcodigoDestino = $(this).data('idcodigo');
			console.log(id_eliminar,idcodigoDestino);
			// swal("Excepción","Los idiomas no se pueden eliminar ya que pueden afectar seriamente a los demas páginas web.","warning");
			swal({
              title: "Estas seguro de eliminar el Destino...?",
              text: "Al eliminar el destino esta ya no aprecerá en la página del index y otras páginas.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/destinos/remove_codigo_destino/';?>'+parseInt(id_eliminar),
                    type: 'POST',
                    dataType: 'json',
                    data: {id:id_eliminar,idcodigo: idcodigoDestino},
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

		$(document).on('click', '.btnTraduccionesDestino', function(event) {
			console.log("Click..!");
			event.preventDefault();
			var id = $(this).data('id');
			var idCodigo = $(this).data('idcodigo');
			
			var modal = null, button = null,html = "";
			$('#modalVerDestinos').on('show.bs.modal', function (event) {
				button = $(event.relatedTarget);
				modal = $(this);
				modal.find('.modal-body>#modalContent').empty(); 
				modal.find('.modal-body>#modalLoading').css('display', 'block');
			});

			$.ajax({
				url: '<?=base_url();?>admin/destinos/traducciones',
				type: 'POST',
				dataType: 'json',
				data: {id:id,idcodigo:idCodigo},
			}).done(function(data) {
				//console.log(JSON.stringify(data));
				if (data.length > 0 ) {
					html = '<div class="list-group">';
					$.each(data, function(index, val) {
						html += '<a href="javascript:void(0);" class="list-group-item">'+
							    	'<h5 class="list-group-item-heading" style="text-transform: uppercase;"><strong>'+val['codigo']+'</strong>: '+val['descripcion_destino']+'</h5>'+
							    	'<p class="list-group-item-text">'+val['nombre_destino']+'</p>'+
							  	'</a>';
					});		
					html += '</div>';
				}else{	html = "<p>No hay traducciones para el Destino.</p>"; }
				$("#modalVerDestinos").find(".modal-body>#modalContent").empty().html(html);
				$("#modalVerDestinos").find('.modal-body>#modalLoading').css('display', 'none');
				var btnEditar = document.getElementById("btnEditarDestinoGrupo");
				btnEditar.innerHTML = 'EDITAR';
			    btnEditar.href = "<?=base_url();?>admin/destinos/edit/"+id+"/"+idCodigo;
			}).fail(function(e) {
				$("#modalVerDestinos").find('.modal-body>#modalLoading').css('display', 'none');
				$("#modalVerDestinos").find(".modal-body>#modalContent").empty().html(e.responseText);
				console.log(e.responseText);
			});		        
		});
	});
</script>