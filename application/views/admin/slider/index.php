<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
			<h3 class="text-center text-info"><strong><span class="fa fa-list"></span> CONFIGURACION DEL SLIDER DEL INDEX (<small>TODOS LOS IDIOMAS</small>)</strong></h3>
			<div class="pull-right">
				<a href="<?=base_url().'admin/slider/add';?>" class="btn btn-success" title="Agregar y configurar slider para las páginas web"><span class="fa fa-plus-square"></span> AGREGAR</a>					
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
					<table class="table">
						<thead class="bg-info">
							<tr>
							<th class="text-center">#</th>
							<th class="text-center">SLIDER</th>
							<th class="text-center">TITULO</th>
							<th class="text-center">DESCRIPCION</th>
							<th class="text-center">URL</th>
							<th class="text-center">OPTIONS</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($sliders as $k => $val): ?>
							<?php  
								$array_titulo = json_decode($val['titulo_slider'],true);
								$array_descripcion = json_decode($val['descripcion_slider'],true);
								$array_url = json_decode($val['url_destino'],true);
								$entrada = true;
							?>
							<?php foreach ($idiomas as $key => $value): ?>
								<tr>
								<?php if ($entrada): ?>
								<td rowspan="<?=count($idiomas);?>" class="text-center" style="vertical-align:middle;"><strong><?=$k+1;?></strong></td>	
								<td rowspan="<?=count($idiomas);?>" style="vertical-align:middle;">
									<img src="<?=$val['galeria']['full_url_archivo'];?>" class="img-responsive img-thumbnail"/>
									
								</td>
								<?php endif ?>
								<td><?='<strong>'.$value['codigo'].'</strong> - '.$array_titulo[$key][ mb_strtolower($value['codigo']) ];?></td>
								<td><?=$array_descripcion[$key][ mb_strtolower($value['codigo']) ];?></td>
								<td><?=$array_url[$key][ mb_strtolower($value['codigo']) ];?></td>
								<?php if ($entrada): ?>
								<td rowspan="<?=count($idiomas);?>" style="vertical-align:middle;" class="text-center">
									<a href="<?=base_url().'admin/slider/edit/'.$val['id_slider'];?>" class="btn btn-info btn-sm" title="Editar información del Slider"><span class="fa fa-edit"></span></a>
									<span class="btn btn-danger btn-sm btn-eliminar-slider" data-id="<?=$val['id_slider'];?>" title="Eliminar Slider"><span class="fa fa-close"></span></span>
								</td>
								<?php $entrada  =false; ?>
								<?php endif ?>
								</tr>
							<?php endforeach ?>
						<?php endforeach ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<code>
		
		<?//=json_encode($idiomas); ?>
		<br/><br/>
		<?//=json_encode($sliders); ?>		
	</code>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-eliminar-slider', function(event) {
            event.preventDefault();
            var object = $(this);
            var id_delete  =  $(this).data('id');
            console.log(id_delete);
            swal({
              title: "Estas seguro de eliminar el Slider..?",
              text: "Si eliminas el Slider ya no se mostrará en el Index de cada Web.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/slider/remove/';?>'+parseInt(id_delete),
                    type: 'DELETE',
                    dataType: 'json',
                    data: {},
                }).done(function(data) {
                    if ( data.response === 'OK' ) {
                        //$('.btn-eliminar-pagina-web').parent().parent().remove();
                        swal("Confirmación","Se ha eliminado correctamente..!","success");
                        setTimeout( recargar(), 7000 );
                        //$(object).parents('tr').remove();
                    }else{
                        swal("Oops..!","No se ha podido eliminar, Intente nuevamente por favor..!","error");
                    }
                    console.log(data);
                }).fail(function(e) {
                    console.log(e.responseText);
                });
            });
        });		
	});	
	function recargar(){
		location.reload();
	}
</script>