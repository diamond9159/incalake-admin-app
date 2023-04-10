<div class="container-fluid">
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="headline">
			<div><span></span> Lista de Métodos de Pago</div>
		</div>
		<!-- <h2 class="text-center"> <span class="fa fa-list"></span> LISTA DE IDIOMAS</h2><hr/>	 -->
		<div class="pull-right">
				<a href="<?php echo site_url('admin/metodopago/add'); ?>" class="btn btn-success" title="Agregar Nuevo Método de Pago"><strong><span class="fa fa-plus"></span> AGREGAR</strong></a> 
			</div>
	<div id="users">
	  <input class="search" placeholder="Search" />
	  <button class="sort" data-sort="name">
	    Buscar
	  </button>
			

			<div class="col-md-12 text-center hidden-xs header-list text-center">
				<div class="col-md-12">
					<div class="col-md-3 col-sm-3">#</div>
					<div class="col-md-3 col-sm-3">METODO DE PAGO</div>
					<div class="col-md-3 col-sm-3">DESCRIPCION</div>
					<div class="col-md-3 col-sm-3">ACTIONS</div>
				</div>
			</div>
			<div class="list">
				<?php if ( !empty($metodopago) ): ?>
					<?php foreach($metodopago as $i){ ?>
					<div class="col-md-12">
						<div class="container-fluid col-md-12 name">
							<div class="col-md-3 col-sm-3 col-xs-2 text-center"><?php echo $i['id_metodo_pago']; ?></div>
							<div class="col-md-3 col-sm-3 col-xs-7"><?php echo mb_strtoupper($i['nombre_metodo_pago']); ?></div>
							<div class="col-md-3 col-sm-3 hidden-xs text-center"><?php echo mb_strtoupper($i['descripcion_metodo_pago']); ?></div>
							<div class="col-md-3 col-sm-3 col-xs-3 text-center">
								<div class="btn-group">
								<a href="<?php echo site_url('admin/metodopago/edit/'.$i['id_metodo_pago']); ?>" class="btn btn-info btn-sm" title="Editar Método de Pago"><span class="fa fa-pencil"></span></a>
								<a href="<?php //echo site_url('admin/metodopago/remove/'.$i['id_metodo_pago']); ?>" class="btn btn-danger btn-sm btn-eliminar-metodopago" data-id="<?=$i['id_metodo_pago'];?>" title="Eliminar Eliminar Método de Pago"><span class="fa fa-close"></span></a>	           
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				<?php endif ?>
			</div>
			<div class="text-center">
				<ul class="pagination"></ul>
			</div>
	</div>
	</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-eliminar-metodopago', function(event) {
			event.preventDefault();
			var id_eliminar = $(this).data('id');
			console.log(id_eliminar);
			// swal("Excepción","Los idiomas no se pueden eliminar ya que pueden afectar seriamente a los demas páginas web.","warning");
			swal({
              title: "Estas seguro de eliminar el Método de Pago...?",
              text: "Para volver a ver el Método de Pago tienes que registrar nuevamente.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/metodopago/remove/';?>'+parseInt(id_eliminar),
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
	});
</script>


