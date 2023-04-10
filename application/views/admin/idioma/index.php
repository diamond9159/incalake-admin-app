<div class="container-fluid">
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="headline">
			<div>lista de idiomas</div>
		</div>
		<!-- <h2 class="text-center"> <span class="fa fa-list"></span> LISTA DE IDIOMAS</h2><hr/>	 -->
		<div class="pull-right">
				<a href="<?php echo site_url('admin/idioma/add'); ?>" class="btn btn-success" title="Agregar Nuevo Idioma"><strong><span class="fa fa-plus"></span> AGREGAR</strong></a> 
			</div>
	<div id="users">
	  <input class="search" placeholder="Search" />
	  <button class="sort" data-sort="name">
	    Buscar
	  </button>
	
			<div class="col-md-12 text-center hidden-xs header-list text-center">
				<div class="col-md-12">
					<div class="col-md-3 col-sm-3">#</div>
					<div class="col-md-3 col-sm-3">IDIOMA</div>
					<div class="col-md-3 col-sm-3">CODIGO</div>
					<div class="col-md-3 col-sm-3 text-center">OPCIONES</div>
				</div>
			</div>
			<div class="list">
				<?php if ( !empty($idiomas) ): ?>
					<?php foreach($idiomas as $i){ ?>
					<div class="col-md-12">
						<div class="container-fluid col-md-12 name">
							<div class="col-md-3 col-sm-3 col-xs-2 text-center"><?php echo $i['id_idioma']; ?></div>
							<div class="col-md-3 col-sm-3 col-xs-7"><span class="flag flag-<?=mb_strtolower($i['codigo']);?>"></span>&nbsp;&nbsp;&nbsp;<?php echo mb_strtoupper($i['pais']); ?></div>
							<div class="col-md-3 col-sm-3 hidden-xs text-center"><?php echo mb_strtoupper($i['codigo']); ?></div>
							<div class="col-md-3 col-sm-3 col-xs-3 text-center">
								<div class="btn-group">
								<a href="<?php echo site_url('admin/idioma/edit/'.$i['id_idioma']); ?>" class="btn btn-info btn-sm" title="Editar"><span class="fa fa-pencil"></span></a>
								<a href="<?php //echo site_url('admin/idioma/remove/'.$i['id_idioma']); ?>" class="btn btn-danger btn-sm btn-eliminar-idioma" data-id="<?=$i['id_idioma'];?>" title="Eliminar"><span class="fa fa-close"></span></a>	           
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
		$(document).on('click', '.btn-eliminar-idioma', function(event) {
			event.preventDefault();
			var id_eliminar = $(this).data('id');
			swal("Excepción","Los idiomas no se pueden eliminar ya que pueden afectar seriamente a los demas páginas web.","warning");
		});
	});
</script>


