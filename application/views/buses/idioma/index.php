
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-md-8 col-sm-offset-2 col-xs-12">
			<!--
			<div class="pull-left">
				<a href="<?=site_url('buses/dashboard/')?>" class="btn btn-danger">VOLVER</a>
			</div>
			-->
			<div class="pull-right">
				<a href="<?php echo site_url('buses/idioma/add'); ?>" class="btn btn-success"><span class="fa fa-plus-circle"></span> AGREGAR</a> 
			</div>

			<table class="table table-striped table-bordered">
			    <tr>
					<th class="text-center">#</th>
					<th>Idioma</th>
					<th>Código Idioma</th>
					<th class="text-center">OPCIONES</th>
			    </tr>
				<?php foreach($idiomas as $i){ ?>
			    <tr>
					<td class="text-center"><?=$i['id_idioma']; ?></td>
					<td><?=mb_strtoupper($i['pais']);?></td>
					<td><?=mb_strtoupper($i['codigo']);?></td>
					<td class="text-center">
			            <a href="<?php echo site_url('buses/idioma/edit/'.$i['id_idioma']); ?>" class="btn btn-info btn-xs" title="Editar Idioma"><span class="fa fa-edit"></span></a> 
			            <a href="javascript:void(0);" class="btn btn-danger btn-xs btn-eliminar-idioma" data-id="<?=$i['id_idioma']?>" title="Eliminar Idioma">
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
		$(document).on('click', '.btn-eliminar-idioma', function(event) {
			event.preventDefault();
            var idIdioma = $(this).data('id');
            confirmarEliminarIdioma(idIdioma,$(this));
		});

		function confirmarEliminarIdioma(idIdioma,$this){
			swal({
			  	title: "Desea eliminar el Idioma..?",
			  	text: "Si elimina el idioma también se eliminarán todos los registros relacionados al idioma.",
			  	icon: "warning",
			  	buttons: true,
			  	dangerMode: true,
			}).then((willDelete) => {
			  	if (willDelete) {
			  		$.ajax({
						url: '<?=base_url()?>buses/idioma/remove/'+idIdioma,
						type: 'POST',
						dataType: 'json',
						data: {id: idIdioma},
					}).done(function(data) {
						console.log(data);
						if( data.response ){
							swal("El idioma ha sido eliminado correctamente.");
							$this.parents("tr").remove(); // Removiendo el idioma eliminado de la base de datos.
						}else{
							swal("El idioma no se puede eliminar.");
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
