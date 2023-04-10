<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h3><span class="fa fa-list"></span> GUÍAS DISPONIBLES PARA ASOCIAR CON UNA ACTIVIDAD y/o SERVICIO</h3>
			<?php 
				//echo json_encode($guias);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12l">
			<div class="pull-right"><a href="<?=base_url();?>admin/guia/add" class="btn btn-success" title="Agregar Nuevo Guía">AGREGAR</a></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
			<table class="table table-hover">
			        <thead>
			            <tr>
			                <th class="text-center">ID</th>
			                <th>Decripción</th>
			                <th class="text-center">OPCIONES</th>
			            </tr>
			        </thead>
			        <tbody>
			<?php foreach ($guias as $key => $value): ?>
			            <tr>
			                <td class="text-center">
			                	<?=$key+1;?>
			                </td>
			                <td>
			                	<!--
			                	<strong><?=$value['pais'];?>(<?=$value['codigo'];?>)</strong>  
								-->
		                		<?=$value['servicio_guia'];?></td>
			                <td class="text-center">
			                	<div class="btn-group">
			                		<span class="btn btn-warning btn-traducciones-guia" title="Ver traducciones" data-id="<?=$value['id_guia'];?>" data-idcodigo="<?=$value['id_codigo_guia'];?>" data-toggle="modal" data-target="#modal-traducciones-guia">
			                			<span class="fa fa-th-list"></span>
			                		</span>
			                		<a href="<?=base_url();?>admin/guia/edit/<?=$value['id_codigo_guia'];?>" class="btn btn-info" title="Editar Guía"><span class="fa fa-edit"></span></a>
<!--
			                		<span class="btn btn-success btn-asociar-guia" title="Ver y Asociar Guía a Actividades" data-id="<?=$value['id_guia'];?>" data-idcodigo="<?=$value['id_codigo_guia'];?>" data-toggle="modal" data-target="#modal-asociar-guia">
			                			<span class="fa fa-gift"></span>
			                		</span>
-->
			                		<span class="btn btn-danger btn-eliminar-guia" title="Eliminar Guía" data-id="<?=$value['id_guia'];?>" data-idcodigo="<?=$value['id_codigo_guia'];?>">
			                			<span class="fa fa-times"></span>
			                		</span>
			                	</div>
			                </td>
			            </tr>
			        
			<?php endforeach ?>
					</tbody>
			    </table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-traducciones-guia" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal-title-traducciones-guia"><span class="fa fa-tags text-success"></span> TRADUCCIONES</h4>
        </div>
        <div class="modal-body" style="min-height: 12em;">
        	<div class="modalLoading" id="modalLoading"></div>
        	<div class="modalContent" id="modalContent"></div>
        </div>
        <div class="modal-footer modal-footer-traducciones-guia">
        <a href="" class="btn btn-success btnEditarGuiaGrupo" id="btnEditarGuiaGrupo" title="Editar Información del Guía">EDITAR</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>	      
    </div>
</div>

<div class="modal fade" id="modal-asociar-guia" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal-title-asociar-guia"><span class="fa fa-tags text-success"></span> ASOCIAR GUIA A ACTIVIDADES</h4>
        </div>
        <div class="modal-body" style="min-height: 12em;">
        	<div class="modalLoading" id="modalLoading2"></div>
        	<div class="modalContent" id="modalContent"></div>
        </div>
        <div class="modal-footer modal-footer-asociar-guia">
          <button type="button" class="btn btn-success" data-dismiss="modal">GUARDAR</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
        </div>
      </div>	      
    </div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		new Spinner().spin(document.getElementById("modalLoading"));
		new Spinner().spin(document.getElementById("modalLoading2"));

		$(document).on('click', '.btn-traducciones-guia', function(event) {
			event.preventDefault();
			var idguia   = $(this).data('id');
			var idcodigo = $(this).data('idcodigo'); 
			var modal = null, button = null,html = "";
		    $('#modal-traducciones-guia').on('show.bs.modal', function (event) {
				button = $(event.relatedTarget);
				modal = $(this);
				modal.find('.modal-body>#modalContent').empty(); 
				modal.find('.modal-body>#modalLoading').css('display', 'block');
			});
			$.ajax({
				url: '<?=base_url();?>admin/guia/traduccionesJson',
				type: 'POST',
				dataType: 'json',
				data: {id:idguia,idcodigo:idcodigo},
			}).done(function(data) {
				console.log(data);
				if (data.guia.length > 0 ) {
					html = 	'<div class="list-group">';
					$.each(data.guia, function(index, val) {
						html += '<a href="javascript:void(0);" class="list-group-item">'+
							    	'<h5 class="list-group-item-heading" style="text-transform: uppercase;"><strong>'+
							    	    //val['codigo']+'</strong>: '+val['servicio_guia']+'</h5>'+
								    	'</strong><strong>'+val['servicio_guia']+'</strong></h5>'+
							    	'<p class="list-group-item-text"><strong><small>IDIOMA: </small></strong><small>'+val['pais']+'</small></p>'+
							  	'</a>';
					});		
					html += '</div>';
				}else{	html = "<p>No hay traducciones para el registro seleccionado.</p>"; }
				$("#modal-traducciones-guia").find(".modal-body>#modalContent").empty().html(html);
				$("#modal-traducciones-guia").find('.modal-body>#modalLoading').css('display', 'none');
				var btnEditar = document.getElementById("btnEditarGuiaGrupo");
				btnEditar.innerHTML = 'EDITAR';
			    btnEditar.href = "<?=base_url();?>admin/guia/edit/"+idcodigo;
			}).fail(function(e) {
				$("#modal-traducciones-guia").find('.modal-body>#modalLoading').css('display', 'none');
				$("#modal-traducciones-guia").find(".modal-body>#modalContent").empty().html(e.responseText);
				console.log(e.responseText);
			});
			
		});

		$(document).on('click', '.btn-asociar-guia', function(event) {
			event.preventDefault();
			var idguia   = $(this).data('id');
			var idcodigo = $(this).data('idcodigo'); 
			var modal = null, button = null,html = "";
		    $('#modal-asociar-guia').on('show.bs.modal', function (event) {
				button = $(event.relatedTarget);
				modal = $(this);
				modal.find('.modal-body>#modalContent').empty(); 
				modal.find('.modal-body>#modalLoading').css('display', 'block');
			});
			$.ajax({
				url: '<?=base_url();?>admin/guia/asociarGuiaProducto',
				type: 'POST',
				dataType: 'json',
				data: {id: idguia,idcodigo:idcodigo},
			}).done(function(data) {
				//console.log(data);
				var contador = 0;
				html_content = '';
				if (data.actividades.length != 0) {
					$.each(data.idiomas, function(index, value) {
						html_content += '<div class="panel panel-success">'+
											'<div class="panel-heading"><strong>ACTIVIDADES EN EL IDIOMA '+value['pais']+'</strong></div>'+
												'<div class="panel-body">'+
													'<div class="list-group">'
						contador = 0;
						$.each(data.actividades, function(i, val) {
							if ( val['codigo'] === value['codigo'] ) {
								checked = '';
								if ( val['id_producto'] ) {
									checked = 'checked';
								}
								contador++;
								html_content += 
								'<a href="javascript:void(0);" class="list-group-item">'+
							    	'<span class="list-group-item-heading" style="text-transform: uppercase;"><strong><span class="fa fa-street-view"></span> '+val['titulo_producto']+'</span>'+
							    	'<span class="pull-right"><input type="checkbox" class="chckbx_asociado" name="chckbx_asociado[]" data-idproducto="'+val['idproducto']+'" data-ididioma="'+val['id_idioma']+'" data-idguia="'+idguia+'" '+checked+' value=""></<span>'+
							  	'</a>';
							}
						});
						html_content += '</div>'+
									'</div>'+ 
								'<div class="panel-footer"><small>'+contador+' Actividades Disponibles.</small></div>'+
								'</div>';
						return false;//Entra una sola vez y mostrará solo las actividades en el idioma Español
					});
				}else{
					html_content = 'strong>No hay actividades registradas en la base de datos.</strong>';
				}
				$("#modal-asociar-guia").find(".modal-body>#modalContent").empty().html(html_content);
				$("#modal-asociar-guia").find('.modal-body>#modalLoading2').css('display', 'none');
			}).fail(function(e) {
				console.log(e.responseText);
			});
			

		});

		$(document).on('click', '.btn-eliminar-guia', function(event) {
			event.preventDefault();
			var $this = $(this); 
			var idguia   = $(this).data('id');
			var idcodigo = $(this).data('idcodigo'); 
			swal({
              title: "Estas seguro de eliminar el Registro del Guía...?",
              text: "Al eliminar el Guía también se eliminarán las traducciones y ya no estará disponible para asociar a una actividad y/o servicio.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/guia/remove_codigo_guia/';?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {id:idguia,idcodigo: idcodigo},
                }).done(function(data) {
                    if ( data.response === 'success' ) {
                        $this.parents('tr').remove();
                        swal("Confirmación","Se ha eliminado correctamente..!","success");
                    }else{
                        swal("Oops..!","No se ha podido eliminar, Intente nuevamente por favor..!","error");
                    }
                    console.log(data);
                }).fail(function(e) {
                    console.log(e.responseText);
                });
            });
		});

		$(document).on('change', '.chckbx_asociado', function(event) {
			event.preventDefault();
			var idproducto = $(this).data('idproducto');
			var ididioma   = $(this).data('ididioma');
			var idguia     = $(this).data('idguia');
			if($(this).is(':checked')){
				console.log("checkeado..!");
				operarAsociacion(idproducto,ididioma,idguia,1);
			}else{
				console.log("No checkeado..!");
				operarAsociacion(idproducto,ididioma,idguia,0);
			}
			//console.log("CLICK CHECK  "+idproducto+ " --> " + ididioma +  " --> " + idguia );
		});
	});

	function operarAsociacion(idproduct,idlang,idgude,operation){
		$.ajax({
			url: '<?=base_url();?>admin/guia/operarAsociacion',
			type: 'POST',
			dataType: 'JSON',
			data: {idproducto: idproduct,ididioma:idlang ,idguia: idgude,operacion: operation},
		}).done(function(data) {
			console.log(data);
		}).fail(function(e) {
			console.log(e.responseText);
		});
	}

</script>