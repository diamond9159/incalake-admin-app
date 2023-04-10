<?php
// echo json_encode($listview_ofertas);
//echo json_encode($idiomas_utilizados);
?>
<div class="container-fluid">
			<div class="headline">
				<div><span class="fa fa-th-list bg-success"></span> Lista de ofertas</div>
			</div>
	<div class="col-md-12 text-right">
		<div class="dropdown">
	      <a href="javascript:void(0)" class="dropdown-toggle btn btn-success" data-toggle="dropdown"><span class="fa fa-plus"></span> AGREGAR <span class="fa fa-caret-down"></span></a>
	      <ul class="dropdown-menu">
	      	<?php if ( !empty($idiomas_utilizados) ): ?>
	      		<?php foreach ($idiomas_utilizados as $key => $value): ?>
	      			<li>
	      				<a href="<?=base_url().'admin/oferta/add/'.strtolower($value['codigo']).'/';?>"><span class="fa fa-globe"></span> Idioma <?=ucwords(mb_strtolower($value['pais']));?></a>
	      			</li>
	        		<li class="divider"></li>
	      		<?php endforeach ?>
	      	<?php endif ?>
	      </ul>
	    </div>
	</div>

	

		<div class="col-md-12 header-list hidden-xs hidden-sm">
			<div>
				<div class="col-md-10">TOURS Y/O SERVICIOS</div>
				<div class="col-md-2"><div class="text-center">OPCIONES</div></div>
			</div>
		</div>
		<div class="col-md-12 div-tabla">
		<?php foreach ($listview_ofertas as $key => $value): ?>
			<div class="col-md-10 col-xs-10">
				<?='<b>['.$value['codigo'].']</b>   '.ucfirst($value['titulo_producto']);?>
			</div>
			<div class="col-md-2 text-center col-xs-2">
				<div class="btn-group">
					<a href="<?=base_url().'admin/oferta/edit/'.mb_strtolower($value['codigo']).'/'.$value['id_producto'];?>" class="btn btn-info btn-sm " title="Editar Paquete en Oferta"><span class="fa fa-pencil"></span></a>
					<a class="btn btn-success btn-sm" href="<?=$value['url_servicio']?>" title="Ver Paquete En Oferta"><span class="fa fa-eye"></span></a>
					<a href="javascript:void(0);" data-id="<?=$value['id_producto'];?>" class="btn btn-danger btn-sm btn-eliminar-oferta" title="Eliminar Paquete en Oferta"><span class="fa fa-close"></span></a>
				</div>
			</div>
		<?php endforeach ?>
		</div>

	

</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-eliminar-oferta', function(event) {
			event.preventDefault();
			var id_delete = $(this).data('id');
			swal({
			  title: "Estas seguro de eliminar esta oferta..?",
			  text: "Al eliminar la oferta esta ya no aparecerá en la sección de ofertas en la página web.",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Si, Quiero Eliminar!",
			  cancelButtonText: "No, Cancelar",
			  closeOnConfirm: false
			},
			function(){
				$.ajax({
					url: '<?=base_url().'admin/oferta/remove/';?>'+parseInt(id_delete),
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