<div class="container-fluid">
<?php foreach ($idiomas as $key => $value): ?>
	<a href="<?=base_url()?>admin/reporteactividades/actividades/<?=strtolower($value['codigo'])?>">	<?=$value['codigo'];?></a>
<?php endforeach ?>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<?php 
				//echo json_encode($data); 
			?>
		
			<div class="headline">
				<div><span class="fa fa-list"></span> Ver precios de las actividades y/o servicios de cada página web</div>
			</div>
		
			<div id="reporteactividadeslist">
				<div class="row">
					<!--
					<div class="col-md-4 col-md-offset-4">
						<div class="text-center">
							<input type="search" name="txtSearch" id="txtSearch" placeholder="Buscar.." autofocus class="search form-control input-lg" />
						</div>
					</div>
				-->
				</div>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
					      <tr>
					        <th class="text-center">#</th>
					        <th>Actividad/Servicio</th>
					        <!--
					        <th class="text-center">Opciones</th>
					    	-->
					      </tr>
					    </thead>
					    <tbody class="list">
					    <?php 
					    	$servicios = [];
					    	if (!empty($data['productos'])) {
					    		$servicios = $data['productos'];
					    	}
					    ?>
					    
					    <?php foreach ($servicios as $key => $value): ?>
					    	<?php 
					    		$btnIdiomas = '';
					    		$btnIdiomas .= '<div class="btn-group"><a href="'.base_url().'admin/reporteactividades/actividad/'.strtolower(trim($value['codigo'])).'/'.$value["id_producto"].'" class="btn btn-info btn-sm" title="Ver vista previa de la actividad">Vista Previa</a>'.'<a href="'.base_url().'admin/reporteactividades/pdf/'.strtolower(trim($value['codigo'])).'/'.$value["id_producto"].'" class="btn btn-danger btn-sm" title="Imprimir (Esto puede tardar varios minutos)" target="_blank"><span class="fa fa-file-pdf-o"></span></a></div> ';
					    	?>
					      <tr>
					        <td class="text-center"><?=$key+1;?></td>
					        <td class="titulo_actividad"><?='<strong>('.str_pad($value['id_codigo_producto'], 3, "0", STR_PAD_LEFT).')</strong>  '.mb_strtoupper($value['titulo_producto']); ?></td>
					        <!--
					        <td class="text-center"><?=$btnIdiomas;?></td>
					    -->
					      </tr>
					    <?php endforeach ?>
					
					    </tbody>
					</table>
				</div>
			</div>
			<div class="form-group text-center">
				<a href="<?php echo site_url('admin/servicio'); ?>" class="btn btn-danger"><b><span class="fa fa-chevron-left"></span> VOLVER</b></a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var options = {
	  valueNames: [ 'titulo_actividad' ]
	};
	var userList = new List('reporteactividadeslist', options);	
</script>

