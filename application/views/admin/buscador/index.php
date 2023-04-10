<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="headline">
				<div><span class="fa fa-list"></span> LISTA DE DESTINOS</div> 
			</div>
			<div class="alert alert-danger">
				<p class="text-justify"><span class="fa fa-exclamation-triangle"></span> 
					La lista de destinos seleccionados aparecerán en el mismo órden el la página del index al momento de hacer click en el buscador.
				</p>
			</div>
			<h3>DESTINOS SELECCIONADOS</h3>
			<ul class="list-group" id="lista-destinos-search">
				<?php if ( count($destinos) != 0 ): ?>
					<?php foreach ($destinos as $key => $value): ?>
						<?php if ( !empty( $value['id_servicio_search'] )): ?>
							<li class="list-group-item"><span class="pull-right"><span class="btn btn-danger btn-xs btn-eliminar_destino" title="" data-id="<?=$value['id_servicio']?>" data-ididioma="<?=$value['id_idioma']?>" data-idcodigo="<?=$value['id_codigo_servicio']?>" data-nombre="<?=$value['ubicacion_servicio']?>"><strong>ELIMINAR</strong></span></span><?=ucfirst($value['ubicacion_servicio'])?> </li>
						<?php endif ?>
					<?php endforeach ?>
				<?php else: ?>
					<li class="list-group-item">No hay destinos disponibles para seleccionar.</li>			
				<?php endif ?>
			</ul>
			<hr/>
			<h3>DESTINOS DISPONIBLES</h3>
			<ul class="list-group" id="lista-destinos">
				<?php if ( count($destinos) != 0 ): ?>
					<?php foreach ($destinos as $key => $value): ?>
						<?php if ( empty( $value['id_servicio_search'] )): ?>
							<li class="list-group-item"><?=ucfirst($value['ubicacion_servicio'])?> <span class="pull-right"><span class="btn btn-success btn-xs btn-add_destinos" title="Agregar a destinos seleccionados" data-id="<?=$value['id_servicio']?>" data-ididioma="<?=$value['id_idioma']?>" data-idcodigo="<?=$value['id_codigo_servicio']?>" data-nombre="<?=$value['ubicacion_servicio']?>"><strong>AGREGAR</strong></span></span></li>
						<?php endif ?>
					<?php endforeach ?>
				<?php else: ?>
					<!--
					<li class="list-group-item">No hay destinos disponibles para seleccionar.</li>
					-->			
				<?php endif ?>
			</ul> 
			<code>
				<?php //echo json_encode($destinos); 
				?>
			</code>

		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="headline">
				<div><span class="fa fa-list"></span> LISTA DE ACTIVIDADES</div> 
			</div>
			<div class="alert alert-danger">
				<p class="text-justify"><span class="fa fa-exclamation-triangle"></span> 
					La lista de actividades aparecerá en el mismo órden en la página del index al momento de hacer click en el buscador.
				</p>
			</div>
			<h3>ACTIVIDADES SELECCIONADOS</h3>
			<ul class="list-group" id="lista-actividades-search">
				<?php if ( count($actividades) != 0 ): ?>
					<?php foreach ($actividades as $key => $value): ?>
						<?php if ( !empty( $value['id_actividad_search'] ) ): ?>
							<li class="list-group-item"><span class="pull-right"><span class="btn btn-danger btn-xs btn-eliminar_actividad" title="Eliminar Actividad" data-id="<?=$value['id_producto']?>" data-ididioma="<?=$value['id_idioma']?>" data-idcodigo="<?=$value['id_codigo_producto']?>" data-nombre="<?=$value['titulo_producto']?>"><strong>ELIMINAR</strong></span></span><?=ucfirst($value['titulo_producto'])?> </li>
						<?php endif ?>
					<?php endforeach ?>
				<?php else: ?>
					<!-- 
					<li class="list-group-item">No hay actividades disponibles para seleccionar.</li> -->
				<?php endif ?>
			</ul>
			<hr/>
			<h3>ACTIVIDADES DISPONIBLES</h3>
			<ul class="list-group" id="lista-actividades">
				<?php if ( count($actividades) != 0 ): ?>
					<?php foreach ($actividades as $key => $value): ?>
						<?php if ( empty( $value['id_actividad_search'] ) ): ?>
							<li class="list-group-item"><span class="pull-right"><span class="btn btn-success btn-xs btn-add_actividades" title="Agregar a Actividades seleccionados" data-id="<?=$value['id_producto']?>" data-ididioma="<?=$value['id_idioma']?>" data-idcodigo="<?=$value['id_codigo_producto']?>" data-nombre="<?=$value['titulo_producto']?>"><strong>AGREGAR</strong></span></span> <?=ucfirst($value['titulo_producto'])?> </li>
						<?php endif ?>
					<?php endforeach ?>
				<?php else: ?>
					<li class="list-group-item">No hay actividades disponibles para seleccionar.</li>
				<?php endif ?>
			</ul>
			<code>
				<?php //echo json_encode($actividades); 
				?>
			</code>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-add_destinos', function(event) {
			event.preventDefault();
			var iddestino 	= $(this).data('id');
			var idcodigo 	= $(this).data('idcodigo');
			var ididioma 	= $(this).data('ididioma');
			var descripcion	= $(this).data('nombre');
			//console.log("DESTINO",iddestino,"CODIGO",idcodigo,"IDIOMA",ididioma,"DESCRIPCION",descripcion);
			addLista(iddestino,idcodigo,ididioma,descripcion,'destino', $(this) );
		});
		$(document).on('click', '.btn-add_actividades', function(event) {
			event.preventDefault();
			var idactividad = $(this).data('id');
			var idcodigo 	= $(this).data('idcodigo');
			var ididioma 	= $(this).data('ididioma');
			var descripcion	= $(this).data('nombre');
			//console.log("ACTIVIDAD",idactividad,"CODIGO",idcodigo,"IDIOMA",ididioma,"DESCRIPCION",descripcion);
			addLista(idactividad,idcodigo,ididioma,descripcion,'actividad',$(this) );
		});


		function addLista(id,idcodigo,ididioma,descripcion,type,btnClick ){
			var data_server = {
				id: id,
				idcodigo : idcodigo,
				ididioma : ididioma,
				descripcion : descripcion,
				type: type,
			};
			$.ajax({
				url: '<?=base_url();?>admin/buscador/insertaropcion',
				type: 'POST',
				dataType: 'JSON',
				data: {data: data_server},
			}).done(function(data) {
				console.log(data);
				if (data.response === 'OK') {
					if ( type === 'destino' ) {
						console.log('destinos');
						appendItem(data_server,'#lista-destinos-search','eliminar','destino',btnClick);
					}else if( type === 'actividad' ){
						console.log('actividades');
						appendItem(data_server,'#lista-actividades-search','eliminar','actividad',btnClick);
					}
				}
			}).fail(function(e) {
				console.log(e.responseText);
			});
		}

		function appendItem(data,idlist,option,classname,btnClick){
			btnClick.parents('li').remove();
			var html = '';
			if (option === 'agregar') {
				html = '<li class="list-group-item"><span class="pull-right"><span class="btn btn-success btn-xs btn-add_'+classname+'" title="" data-id="'+data.id+'" data-ididioma="'+data.ididioma+'" data-idcodigo="'+data.idcodigo+'" data-nombre="'+data.descripcion+'"><strong>AGREGAR</strong></span></span>'+data.descripcion+' </li>';
			}else if(option === 'eliminar'){
				html = '<li class="list-group-item"><span class="pull-right"><span class="btn btn-danger btn-xs btn-eliminar_'+classname+'" title="" data-id="'+data.id+'" data-ididioma="'+data.ididioma+'" data-idcodigo="'+data.idcodigo+'" data-nombre="'+data.descripcion+'"><strong>ELIMINAR</strong></span></span>'+data.descripcion+' </li>';
			}	
			$(idlist).append(html);
		}

		$(document).on('click', '.btn-eliminar_destino', function(event) {
			event.preventDefault();
			var iddestino= $(this).data('id');
			var idcodigo 	= $(this).data('idcodigo');
			var ididioma 	= $(this).data('ididioma');
			var descripcion	= $(this).data('nombre');
			console.log("DESTINO",iddestino,"CODIGO",idcodigo,"IDIOMA",ididioma,"DESCRIPCION",descripcion);
			deleteLista(iddestino,idcodigo,ididioma,descripcion,'destino',$(this) );
		});

		$(document).on('click', '.btn-eliminar_actividad', function(event) {
			event.preventDefault();
			var idactividad = $(this).data('id');
			var idcodigo 	= $(this).data('idcodigo');
			var ididioma 	= $(this).data('ididioma');
			var descripcion	= $(this).data('nombre');
			console.log("ACTIVIDAD",idactividad,"CODIGO",idcodigo,"IDIOMA",ididioma,"DESCRIPCION",descripcion);
			deleteLista(idactividad,idcodigo,ididioma,descripcion,'actividad',$(this) );
		});


		function deleteLista(id,idcodigo,ididioma,descripcion,type,btnClick ){
			var data_server = {
				id: id,
				idcodigo : idcodigo,
				ididioma : ididioma,
				descripcion : descripcion,
				type: type,
			};
			$.ajax({
				url: '<?=base_url();?>admin/buscador/eliminaropcion',
				type: 'POST',
				dataType: 'JSON',
				data: {data: data_server},
			}).done(function(data) {
				console.log(data);
				if (data.response === 'OK') {
					if ( type === 'destino' ) {
						console.log('destinos');
						appendItem(data_server,'#lista-destinos','agregar','destinos',btnClick);
					}else if( type === 'actividad' ){
						console.log('actividades');
						appendItem(data_server,'#lista-actividades','agregar','actividades',btnClick);
					}
				}
			}).fail(function(e) {
				console.log(e.responseText);
			});
		}

	});
</script>