<div class="container-fluid">
	<div class="row">	
		<div class="col-md-12 col-sm-12 col-sm-12">
		<div class="headline">
			<div>Configuraciones de la Página Web</div>
			</div>
				<div class="col-md-12">
					<span class="pull-right">
						<?php if ( count($data) === 0 ): ?>
							<a href="<?=base_url().'admin/configuracion/add';?>" class="btn btn-success"><strong><span class="fa fa-pencil-square"></span> AGREGAR CONFIGURACIÓN</strong></a>
						<?php else: ?>
							<a href="<?=base_url().'admin/configuracion/edit/'.$data[0]['id_configuracion'];?>" class="btn btn-info "><strong><span  class="fa fa-pencil"></span> EDITAR CONFIGURACIÓN</strong></a>
						<?php endif ?>	
					</span>
				</div>

			<?php if ( count($data) != 0 ): ?>
				
			
			<?php //echo json_encode( $data[0]['nombre_empresa'][0] ); 
				$array_nombre_empresa = json_decode($data[0]['nombre_empresa'],true);
				$array_titulo_pagina  = json_decode($data[0]['titulo_index'],true);
				$array_keywords		  = json_decode($data[0]['keywords_index'],true);
				$array_descripcion    = json_decode($data[0]['descripcion_index'],true);
				//echo json_encode($array_titulo_pagina);
			?>
			<div class="col-md-6">
				<div class="card-title col-md-12">
					<span class="fa fa-building"></span> NOMBRE DE LA EMPRESA
				</div>
				<div class="card col-md-12">
					
					<?php foreach ($idiomas as $key => $value): ?>
							<p><span class="fa fa-check-square text-success"></span> <?='<strong>'.mb_strtoupper($value['codigo']).' </strong>: '.$array_nombre_empresa[$key][mb_strtolower($value['codigo'])];?></p>
					<?php endforeach ?>	
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-title col-md-12">
					<span class="fa fa-globe"></span> TÍTULO DE LA PÁGINA WEB (INDEX)
				</div>
				<div class="col-md-12 card">
					<?php foreach ($idiomas as $key => $value): ?>
							<p><span class="fa fa-check-square text-success"></span> <?='<strong>'.mb_strtoupper($value['codigo']).'</strong> : '.$array_titulo_pagina[$key][mb_strtolower($value['codigo'])];?></p>
					<?php endforeach ?>	
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-title col-md-12">
					<span class="fa fa-keyboard-o"></span> KEYWORDS DE LA PÁGINA WEB (INDEX)
				</div>
				<div class="col-md-12 card">
						<?php foreach ($idiomas as $key => $value): ?>
								<p><span class="fa fa-check-square text-success"></span> <?='<strong>'.mb_strtoupper($value['codigo']).'</strong> : '.$array_keywords[$key][mb_strtolower($value['codigo'])];?></p>
						<?php endforeach ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-title col-md-12">
					<span class="fa fa-building"></span> DESCRIPCIÓN DE LA PÁGINA WEB (INDEX)
				</div>
				<div class="col-md-12 card">
					<?php foreach ($idiomas as $key => $value): ?>
							<p><span class="fa fa-check-square text-success"></span> <?='<strong>'.mb_strtoupper($value['codigo']).'</strong> : '.$array_descripcion[$key][mb_strtolower($value['codigo'])];?></p>
					<?php endforeach ?>	
				</div>
			</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="card-title col-md-12">
						<span class="fa fa-picture-o"></span> LOGO DE LA PÁGINA WEB (INDEX)
					</div>
					<div class="col-md-12 card">
						<div class="tipografy text-center">
						<img src="<?=$data[0]['logo']['full_url_archivo'];?>" class="img-responsive img-thumbnail" />
						</div>
					</div>
				</div>
				<div class=" col-md-6 col-sm-6 col-xs-12">
					<div class="card-title col-md-12">
						<span class="fa fa-file-image-o"></span> FAVICON (ICONO) DE LA PÁGINA WEB (INDEX)
					</div>
					<div class="col-md-12 card">
						<div class="tipografy text-center">
							<img src="<?=$data[0]['favicon']['full_url_archivo'];?>" class="img-responsive img-thumbnail" />
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="card-title col-md-12">
						<span class="fa fa-code"></span> CÓDIGO FUENTE DE GOOGLE ANALITICS
					</div>
					<div class="col-md-12 card">
						<div class="tipografy">
						<code class=""><?=!empty($data[0]['codigo_google_analitics']) ? $data[0]['codigo_google_analitics'] : '<i>Sin código de Google Analitics</i>';?>
						</code>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="card-title col-md-12">
						<span class="fa fa-code"></span> CÓDIGO FUENTE ZOOPIM (CHAT)
					</div>
					<div class="col-md-12 card">
						<div class="tipografy">
						<code class=""><?=!empty($data[0]['codigo_zoopim']) ? $data[0]['codigo_zoopim'] : '<i>Sin código de Zoopim (Chat)</i>';?>
						</code>	
						</div>
					</div>
				</div>
			<?php endif ?>	
			<div class="text-center col-md-12">
				<hr/> <a href="<?=base_url().'admin/servicio/';?>" class="btn btn-success"><span class="fa fa-chevron-left"></span><strong> VOLVER</strong></a>
				<br/><br/><br/> 
			</div>
		</div>
	</div>
	<code>
		<?//=json_encode($data);?>
	</code>
