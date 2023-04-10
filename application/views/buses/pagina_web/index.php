<?
//var_dump($grupo_paginas_web);
?>
<br/><br/><br/><br/>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="pull-right">
				<!--
				<a href="<?php echo site_url('buses/page/add'); ?>" class="btn btn-success"><span class="fa fa-plus-circle"></span> AGREGAR</a> 
				-->
				<div class="dropdown">
				  	<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">AGREGAR
				  	<span class="caret"></span></button>
				  	<ul class="dropdown-menu dropdown-menu-right">
				  		<?php foreach (@$idiomas as $key => $value): ?>
				    	<li><a href="<?=site_url('buses/page/add/0/'.mb_strtolower($value['codigo']))?>"><span class="fa fa-globe"></span> <?=mb_strtoupper($value['pais'])?></a></li>				  			
				  		<?php endforeach ?>
				  	</ul>
				</div>
			</div>
			<?php
				//echo json_encode($grupo_paginas_web);
			?>
			<table class="table table-striped table-bordered">
			    <tr>
					<th class="text-center">#</th>
					<th class="text-center">Idioma</th>
					<th>Url Página Web</th>
					<th>Titulo Página Web</th>
					<!--th class="text-center">Slider</th-->
					
					<th>Ubicación Servicio</th>
					<th class="text-center">Reviews</th>
					<th>Relaciones</th>
					<th class="text-center">OPCIONES</th>
			    </tr>
				<?php foreach($grupo_paginas_web as $p){ ?>
					<tr class="bg-danger">
						<td colspan="7">
							<h5>
								<strong>
									<span class="fa fa-caret-right"></span> <?=mb_strtoupper($p['titulo_pagina'])?>
								</strong>
							</h5>
						</td>
						<td>
							<div class="dropdown">
							  	<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">AGREGAR
							  	<span class="caret"></span></button>
							  	<ul class="dropdown-menu dropdown-menu-right">
							  		<?php foreach (@$p['idiomas'] as $key => $value): ?>
							    	<li><a href="<?=site_url('buses/page/add/'.$p['id_codigo_pagina'].'/'.mb_strtolower($value['codigo']))?>"><span class="fa fa-globe"></span> PÁGINA EN <?=mb_strtoupper($value['pais'])?></a></li>  			
							  		<?php endforeach ?>
							  	</ul>
							</div>
						</td>
					</tr>
					
					<?php 
						// generar links para copiar bus
					/*	function opciones_copiado($id_pagina){
							$html_opciones_copiar = null;
							foreach(@$p['paginas_web'][0]['lista_buses'] as $value){
								$html_opciones_copiar.='<li><a href="'.base_url('buses/unidad/copiar/'.$id_pagina.'/'.$value['id_codigo_bus']).'">'.$value['titulo_bus'].'</a></li>';
							}
						}*/
						
						// fin generar links
						
						foreach ($p['paginas_web'] as $key => $value): 
					?>
					<tr>
						<td class="text-center"><?php echo $value['id_pagina']; ?></td>
						<td class="text-center"><?php echo mb_strtoupper($value['codigo']); ?></td>
						<td><?php echo $value['url_pagina']; ?></td>
						<td><?php echo $value['titulo_pagina']; ?></td>
						<!--td class="text-center text-primary" title="Slider"><span class="fa fa-image fa-2x" data-img="<?=$value['imagen_principal']?>"></span></td-->
						
						<td><?php echo $value['ubicacion_servicio']; ?></td>
						<td class="text-center">
							<?php
								$arrayComentarios = strlen(trim($value['reviews_pagina']))>0?json_decode($value['reviews_pagina'], true):[];
								echo count($arrayComentarios)." Comentarios";
							?>
						</td>
						<td>
							<?php 

								$html_opciones_copiar = null;
								if(count(@$p['paginas_web'][0]['lista_buses'])){
									//var_dump($p['paginas_web'][0]['lista_buses']);
									// siguiente variable se usa para almacenar opciones de copiado
									
									foreach(@$p['paginas_web'][0]['lista_buses'] as $value3){
										// var_dump($value3);
										$html_opciones_copiar.='<li><a href="'.base_url('buses/unidad/copiar/'.$value['id_pagina'].'/'.$value3['id_codigo_bus']).'">'.$value3['titulo_bus'].'</a></li>';
									}
								}
								if($key && $html_opciones_copiar){
								

							?>
							<div class="dropdown pull-right">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" title="Copiar detalles importantes desde el idioma español para crear nuevo bus"><i class="fa fa-window-restore" aria-hidden="true"></i>
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
								  <?=@$html_opciones_copiar;?>
                                </ul>
                            </div>
							<?php } ?>
							<a href="<?=base_url('buses/unidad/contenido_pagina/'.$value['id_pagina']);?>" class="btn btn-info">Ver buses (<?=@$value['cantidad_servicios'];?>)</a>
						</td>
						<td class="text-center">
				            <a href="<?php echo site_url('buses/page/edit/'.$value['id_pagina'].'/'.$value['id_codigo_pagina_web'].'/'.$value['codigo']); ?>" class="btn btn-info btn-xs" title="Editar Página Web"><span class="fa fa-edit"></span></a>

							<a href="<?php echo site_url('buses/unidad/registro/'.$value['id_pagina'].'/');?>" class="btn btn-success btn-xs" title="Agregar nuevo bus a esta actividad"><span class="fa fa-plus"></span></a>

				            <a href="javascript:void(0);" class="btn btn-danger btn-xs btn-eliminar-pagina-web" title="Eliminar Página Web" data-id="<?=$value['id_pagina']?>"><span class="fa fa-remove"></span></a>
				        </td>
				    </tr>				    			
		    		<?php endforeach ?>	
				<?php } ?>
			</table>
			<div class="pull-right">
			    <!--
			    <?php echo $this->pagination->create_links(); ?>    
			    -->
			</div>
		</div>
	</div>
</div>		



<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-eliminar-pagina-web', function(event) {
			event.preventDefault();
			var idPaginaWeb = $(this).data('id');
			confirmarEliminarPagina(idPaginaWeb, $(this) );
		});

		function confirmarEliminarPagina(idPagina,$this){
			swal({
			  	title: "Desea eliminar la Página..?",
			  	text: "Si elimina la Página también se eliminarán todos los registros relacionados a la Página.",
			  	icon: "warning",
			  	buttons: true,
			  	dangerMode: true,
			}).then((willDelete) => {
			  	if (willDelete) {
			  		$.ajax({
						url: '<?=base_url()?>buses/page/remove/'+idPagina,
						type: 'POST',
						dataType: 'json',
						data: {id: idPagina},
					}).done(function(data) {
						console.log(data);
						if( data.response ){
							swal("la página ha sido eliminado correctamente.");
							$this.parents("tr").remove(); // Removiendo el idioma eliminado de la base de datos.
						}else{
							swal("la págna no se puede eliminar.");
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