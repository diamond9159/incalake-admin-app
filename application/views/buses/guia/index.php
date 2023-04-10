
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-md-8 col-sm-offset-2 col-xs-12">
			<!--
			<div class="pull-left">
				<a href="<?=site_url('buses/dashboard/')?>" class="btn btn-danger">VOLVER</a>
			</div>
			-->
			<div class="pull-right">
				<!--
				<a href="<?php echo site_url('buses/page/add'); ?>" class="btn btn-success"><span class="fa fa-plus-circle"></span> AGREGAR</a> 
				-->
				<div class="dropdown">
				  	<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">AGREGAR
				  	<span class="caret"></span></button>
				  	<ul class="dropdown-menu dropdown-menu-right">
				  		<?php foreach (@$idiomas as $key => $value): ?>
				    	<li><a href="<?=site_url('buses/guia/add/0/'.mb_strtolower($value['codigo']))?>"><span class="fa fa-globe"></span> <?=mb_strtoupper($value['pais'])?></a></li>				  			
				  		<?php endforeach ?>
				  	</ul>
				</div>
			</div>

			<table class="table table-striped table-bordered">
			    <tr>
					<th class="text-center">#</th>
					<th>Guía</th>
					<th>Idioma</th>
					<th class="text-center">OPCIONES</th>
			    </tr>
				<?php foreach($guias as $g){ ?>
			    <tr>
					<td class="text-center"><?=$g['id_guia']; ?></td>
					<td><?=mb_strtoupper($g['idioma_guia']);?></td>
					<td><?=mb_strtoupper($g['descripcion_guia']);?></td>
					<td class="text-center">
			            <a href="<?php echo site_url('buses/guia/edit/'.$g['id_guia']).'/'.$g['id_codigo_guia']; ?>" class="btn btn-info btn-xs" title="Editar Guía"><span class="fa fa-edit"></span></a> 
			            <a href="javascript:void(0);" class="btn btn-danger btn-xs btn-eliminar-guia" data-id="<?=$g['id_guia']?>" data-codigoguia="<?=$g['id_codigo_guia']?>" title="Eliminar Guía">
			            	<span class="fa fa-remove"></span>
			            </a>
			        </td>
			    </tr>
			    
			    <?php } ?>
			</table>
			<div class="pull-right">
			    <?php echo $this->pagination->create_links(); ?>    
			</div>			
			<hr/>
			<div class="text-center">
				<a href="<?=site_url('buses/page/')?>" class="btn btn-danger">VOLVER</a>
			</div>
		</div>

	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-eliminar-guia', function(event) {
			event.preventDefault();
            var idGuia 		= $(this).data('id');
            var codigoGuia 	= $(this).data('codigoguia');
            confirmarEliminarGuia(idGuia,codigoGuia,$(this));
		});

		function confirmarEliminarGuia(idGuia,codigoGuia,$this){
			swal({
			  	title: "Desea eliminar el Guía..?",
			  	text: "Si elimina el Guía también se eliminarán todos los registros relacionados al guía.",
			  	icon: "warning",
			  	buttons: true,
			  	dangerMode: true,
			}).then((willDelete) => {
			  	if (willDelete) {
			  		$.ajax({
						url: '<?=base_url()?>buses/guia/remove/'+idGuia+'/'+codigoGuia,
						type: 'POST',
						dataType: 'json',
						data: {id: idGuia,codigoguia: codigoGuia},
					}).done(function(data) {
						console.log(data);
						if( data.response ){
							swal("El Guía ha sido eliminado correctamente.");
							$this.parents("tr").remove(); // Removiendo el idioma eliminado de la base de datos.
						}else{
							swal("El Guía no se puede eliminar.");
						}
					}).fail(function(e) {
						swal("Ha surgido un error en el servidor, por favor contáctese con el administrador.");
						console.log(e.responseText);
					});
			  	} else {
			    	//swal("Su idioma aun seguirá en la base de datos.");
			  	}
			});
		}
	});
</script>
