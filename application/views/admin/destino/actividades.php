<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h3><span class="fa fa-th-list"></span> LISTA DE ACTIVIDADES ASOCIADAS A <big>"<?=mb_strtoupper(@$destino['descripcion_destino']);?>"</big></h3>
			<div class="alert alert-warning">
				<div class="container-fluid">
				<p>Las actividades seleccionadas o checkeadas se mostrarán en el index juntamente a los destinos.</p>
				</div>
			</div>
			<?php 
				//echo json_encode($actividades); 
			?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
				      <tr>
				        <th class="text-center">#</th>
				        <th>Actividad</th>
				        <th>Ubicación</th>
				        <th class="text-center">Asociar/Desasociar</th>
				      </tr>
				    </thead>
				    <tbody>
				    <?php $contador = 1; ?>
				    <?php foreach ($actividades as $key => $value): ?>
				    	<tr>
					        <td><?=@$contador++;?></td>
					        <td><?='<strong>['.@$value['codigo'].']</strong>   '.@$value['titulo_producto']?></td>
					        <td><?=@$value['ciudad_cercana']?></td>
					        <td>
					        	<?php
					        	$checked = '';
					        	if (!empty($value['actividad_asociado'])) {
					        		$checked = 'checked';
					        	}
					        	?>
					        	<input type="checkbox" name="chckbx_asociado_destino" id="" class="form-control chckbx_asociado_destino" <?=$checked;?> data-idactividad="<?=$value['id_producto']?>" data-iddestino="<?=$destino['id_destino'];?>" title="Asociar y/o Desasociar">

					        </td>
					      </tr>
				    <?php endforeach ?>
				    </tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
        $(document).on('change', '.chckbx_asociado_destino', function(event) {
        	event.preventDefault();
        	var idactividad = $(this).data('idactividad');
        	var iddestino   = $(this).data('iddestino');
        	var checked   = 0;
        	var url_server= '<?=base_url().'admin/destinos/delete_destino_producto';?>';
        	if ($(this).is(':checked') ) {
				checked = 1;
				url_server = '<?=base_url().'admin/destinos/add_destino_producto';?>';
			} 
			
			$.ajax({
				url: url_server,
				type: 'POST',
				dataType: 'json',
				data: {iddestino: iddestino, idactividad: idactividad},
			}).done(function(data) {
				console.log(data);
			}).fail(function(e) {
				console.log(e.responseText);
			});
		
      		//console.log("id",iddestino,"idactividad",idactividad,checked);
        });

	});

</script>