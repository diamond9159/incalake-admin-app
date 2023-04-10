<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title><?=nombre_incalake;?></title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
	<link rel="stylesheet" href="<?=base_url();?>assets/resources/listjs/css/listjs.css">
	<script src="<?=base_url(); ?>assets/resources/listjs/js/list.min.js"></script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
<div class="container-fluid">
<?php 
	//echo json_encode($resultados);
?>
<div id="test-list">
	  <input class="search" placeholder="Search" />
	  <button class="sort" data-sort="name">
	    Buscar
	  </button>
			

			<div class="col-md-12 text-center hidden-xs header-list text-center">
				<div class="col-md-12">
					<div class="col-md-10 col-sm-10">TOURS Y/O SERVICIOS</div>
					<div class="col-md-2 col-sm-2">OPCIONES</div>
				</div>
			</div>
			<div class="list">
				<?php 
					function get_first_element_string($token){
				        if (!empty($token)) {
				            $temp_separte_destino=explode(",",$token);
				        }
				        return $temp_separte_destino[0];
				    }

					foreach ($resultados as $key => $value) {
	   				if(!empty($value)){?>
	   				<?php foreach ($value as $k => $val): ?>
   					<?php 
   					$urlWeb = 'https://web.incalake.com/';
   					$url_actividad = $urlWeb.strtolower($val['codigo']).'/'.strtolower(get_first_element_string($val['ubicacion_servicio'])).'/'.$val['uri_servicio'];
   					?>
	   				<div class="col-md-12">
						<div class="container-fluid col-md-12 name ">
							<div class="col-md-10 col-sm-10 col-xs-10 " title="Actividad en idioma <?=$val['pais']?>">
								<a href="<?=mb_strtolower($url_actividad);?>" target="_blank">
								<span class="flag flag-<?=(@$val['codigo']==='EN'?'us':mb_strtolower(@$val['codigo']) );?>"></span>&nbsp;&nbsp;<?php echo "[<b>".str_pad($val['id_codigo_producto'],3,"0",STR_PAD_LEFT)."</b>] ".$val['titulo_producto']; ?>
								</a>
							</div>
							<div class="col-md-2 text-center">
								<?php echo'<a title="Editar Producto" href="'.base_url().'admin/productos/editar/'.$val['id_producto'].'"><span class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></span></a>'.
										'<a title="Ver productos relacionados" href="'.base_url().'admin/productos/codproducto/'.$val['id_codigo_producto'].'"><span class="btn btn-warning btn-sm"><span class="fa fa-list"></span></span></a>'.
							    		//'<a title="Ver recursos de producto" href="'.base_url().'/'.'"><span class="btn btn-default btn-sm"><span class="fa fa-gift"></span></span></a>'.
										'<span class="btn-eliminar-paquete-web" data-id="'.$val['id_producto'].'" title="Eliminar Producto"><span class="btn btn-danger btn-sm"><span class="fa fa-close"></span></span></span>';
								?>
							</div>
						</div>
					</div>	
	   				<?php endforeach ?>
					<?php }else{
						echo 'Sin productos!!';
						} }?>
	
			</div>
			<div class="text-center">
				<ul class="pagination"></ul>
			</div>
</div>
	</div>

</content>
		<!-- ---------------------- MODAL ------------------ -->
		<div class="modal fade" id="modal_recursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
		                </button>
		                <h4 class="modal-title text-center" id="exampleModalLabel"><strong><span class="fa fa-list"></span> Lista de Recursos</strong></h4>
		                <input type="hidden" name="txt_id_recurso_modal" id="txt_id_recurso_modal">
		            </div>
		            <div class="modal-body">
		                <h4>Seleccione y/o asocie el Paquete Turistico a cualquiera de los recursos.</h4>
		                <div class="container-fluid" id="container_list_productos">
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
		            </div>
		        </div>
		    </div>
		</div>
		<!-- -------------------------------------------------- -->
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$(document).on('click', '.btn-eliminar-paquete-web', function(event) {
	            event.preventDefault();
	            var id_delete  =  $(this).data('id');
	            console.log(id_delete);
	            swal({
	              title: "Estas seguro de eliminar este Paquete Turístico..?",
	              text: "Si eliminas este Paquete web tambien se eliminaran automaticamente de la lista de productos.",
	              type: "warning",
	              showCancelButton: true,
	              confirmButtonColor: "#DD6B55",
	              confirmButtonText: "Si, Quiero Eliminar!",
	              cancelButtonText: "No, Cancelar",
	              closeOnConfirm: false
	            },
	            function(){
	                $.ajax({
	                    url: '<?=base_url().'admin/productos/remove/';?>'+parseInt(id_delete),
	                    type: 'DELETE',
	                    dataType: 'json',
	                    data: {},
	                }).done(function(data) {
	                    if ( data.response === 'OK' ) {
	                        //$('.btn-eliminar-pagina-web').parent().parent().remove();
	                        swal("Confirmación","Se ha eliminado correctamente..!","success");
	                        location.reload();
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
		var monkeyList = new List('test-list', {
		  valueNames: ['name'],
		  page: 20,
		  pagination: true
		});
	</script>
	</body>
</html>