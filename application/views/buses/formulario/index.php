	
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs 12">
			<div class="pull-right">
				<a href="<?php echo site_url('buses/formulario/add'); ?>" class="btn btn-success">AGREGAR</a> 
			</div>
			<?php
				//echo json_encode($formularios);
		  	?>
			<table class="table table-striped table-bordered">
			    <tr>
					<th class="text-center">#</th>
					<th>Campo de Texto</th>
					<th class="text-center">Categoria</th>
					<th class="text-center">OPCIONES</th>
			    </tr>
				<?php foreach($formularios as $key => $e){ ?>
			    <tr>
					<td class="text-center"><?php echo ++$key?></td>
					<td><?php echo mb_strtoupper($e['nombre_campo_formulario']); ?></td>
					<td class="text-center text-primary"><?=mb_strtoupper($e['nombre_categoria_formulario'])?></td>
					<td class="text-center">
			            <a href="<?php echo site_url('buses/formulario/edit/'.$e['id_campo_formulario'].'/'.$e['name_campo_formulario']); ?>" class="btn btn-info btn-xs" title="Editar Formulario"><span class="fa fa-edit"></span></a> 
			            <a href="javascript:void(0);" class="btn btn-danger btn-xs btn-eliminar-formulario" data-id="<?=$e['id_campo_formulario'];?>" data-namecampo="<?=$e['name_campo_formulario']?>" title="Eliminar Formulario"><span class="fa fa-remove"></span></a>
			        </td>
			    </tr>
				<?php } ?>
			</table>
			<div class="pull-right">
			    <?php echo $this->pagination->create_links(); ?>    
			</div>
			<div class="text-center">
				<hr/>
				<div class="text-center">
					<a href="<?=site_url('buses/page/')?>" class="btn btn-danger">VOLVER</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-eliminar-formulario', function(event) {
			event.preventDefault();
            var idFormulario = $(this).data('id');
            var namecampo = $(this).data('namecampo');
            confirmarEliminarFormulario(idFormulario,namecampo,$(this));
		});

		function confirmarEliminarFormulario(idFormulario,namecampo,$this){
			swal({
			  	title: "Desea eliminar el campo de texto..?",
			  	text: "Si elimina el registro también se eliminarán todos los registros relacionados al campo de texto.",
			  	icon: "warning",
			  	buttons: true,
			  	dangerMode: true,
			}).then((willDelete) => {
			  	if (willDelete) {
			  		$.ajax({
						url: '<?=base_url()?>buses/formulario/remove/'+idFormulario+'/'+namecampo,
						type: 'POST',
						dataType: 'json',
						data: {id: idFormulario,namecampo: namecampo},
					}).done(function(data) {
						console.log(data);
						if( data.response ){
							swal("El registro ha sido eliminado correctamente.");
							$this.parents("tr").remove(); // Removiendo el idioma eliminado de la base de datos.
						}else{
							swal("EL registro no se puede eliminar.");
						}
					}).fail(function(e) {
						console.log(e.responseText);
						swal("Ha surgido un error en el servidor, por favor contáctese con el administrador.");
					});
			  	} else {
			    	//swal("Su idioma aun seguirá en la base de datos.");
			  	}
			});
		}
	});
</script>
