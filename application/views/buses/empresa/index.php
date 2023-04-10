	
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs 12">
			<div class="pull-right">
				<a href="<?php echo site_url('buses/empresa/add'); ?>" class="btn btn-success">AGREGAR</a> 
			</div>

			<table class="table table-striped table-bordered">
			    <tr>
					<th class="text-center">#</th>
					<th>Empresa</th>
					<th class="text-center">Logo</th>
					<th class="text-center">OPCIONES</th>
			    </tr>
				<?php foreach($empresas as $key => $e){ ?>
			    <tr>
					<td class="text-center"><?php echo ++$key?></td>
					<td><?php echo mb_strtoupper($e['nombre_empresa']); ?></td>
					<td class="text-center text-primary"><!--span class="fa fa-image fa-2x btn-logo-empresa btn" data-id="<?=$e['logo_empresa']?>"></span-->
						<?php
							if($e['logo_empresa']){
								echo '<img width="100px" src="//incalake.com/apps-incalake/web/galeria/admin/other-images/'.$e['logo_empresa']['carpeta_archivo'].'/'.$e['logo_empresa']['url_archivo'].'" />';
							}
						?>
					</td>
					<td class="text-center">
			            <a href="<?php echo site_url('buses/empresa/edit/'.$e['id_empresa']); ?>" class="btn btn-info btn-xs" title="Editar Empresa"><span class="fa fa-edit"></span></a> 
			            <a href="javascript:void(0);" class="btn btn-danger btn-xs btn-eliminar-empresa" data-id="<?=$e['id_empresa'];?>" title="Eliminar Empresa"><span class="fa fa-remove"></span></a>
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
		$(document).on('click', '.btn-eliminar-empresa', function(event) {
			event.preventDefault();
            var idEmpresa = $(this).data('id');
            confirmarEliminarEmpresa(idEmpresa,$(this));
		});

		function confirmarEliminarEmpresa(idEmpresa,$this){
			swal({
			  	title: "Desea eliminar la Empresa..?",
			  	text: "Si elimina el idioma también se eliminarán todos los registros relacionados a la Empresa.",
			  	icon: "warning",
			  	buttons: true,
			  	dangerMode: true,
			}).then((willDelete) => {
			  	if (willDelete) {
			  		$.ajax({
						url: '<?=base_url()?>buses/empresa/remove/'+idEmpresa,
						type: 'POST',
						dataType: 'json',
						data: {id: idEmpresa},
					}).done(function(data) {
						console.log(data);
						if( data.response ){
							swal("La empresa ha sido eliminado correctamente.");
							$this.parents("tr").remove(); // Removiendo el idioma eliminado de la base de datos.
						}else{
							swal("La empresa no se puede eliminar.");
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