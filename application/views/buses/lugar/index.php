

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
			<div class="pull-right">
				<a href="<?php echo site_url('buses/lugar/add'); ?>" class="btn btn-success"><span class="fa fa-plus-square"></span> AGREGAR</a> 
			</div>

			<table class="table table-striped table-bordered">
			    <tr>
					<th class="text-center">#</th>
					<th>Lugar</th>
					<th class="text-center">Coordenadas</th>
					<th>Tipo Lugar</th>
					<th class="text-center">OPCIONES</th>
			    </tr>
				<?php 
				$all_types = ['Parada','Terminal Terrestre','Lugar Turístico','Otro'];
				foreach($lugares as $key => $l){ ?>
			    <tr>
					<td class="text-center"><?php echo ++$key; ?></td>
					<td><?php echo $l['nombre_lugar']; ?></td>
					<td class="text-center text-primary"><span class="fa fa-map btn-mapa-lugar btn" data-coordenadas="<?=$l['coordenadas']?>" title="Ver Mapa" data-toggle="modal" data-target="#modalMapa"></span></td>
					<td><?php echo @$all_types[ @$l['tipo_lugar'] ]; ?></td>
					<td class="text-center">
			            <a href="<?php echo site_url('buses/lugar/edit/'.$l['id_lugar']); ?>" class="btn btn-info btn-xs" title="Editar Lugar"><span class="fa fa-edit"></span></a> 
			            <a href="javascript:void(0);" data-id="<?=$l['id_lugar']?>" class="btn btn-danger btn-xs btn-eliminar-lugar" title="Eliminar Lugar"><span class="fa fa-remove"></span></a>
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

<div id="modalMapa" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Mapa del Lugar</h4>
      </div>
      <div class="modal-body">
        <div id="map-canvas"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
			
<script type="text/javascript">
	var markerPosition = [];
	jQuery(document).ready(function($) {
		$('.btn-mapa-lugar').on('click', function (event2) { 
		    event2.preventDefault();
			var coordenadas = $(this).data('coordenadas');
		    if ( coordenadas.length > 0 ) {
		    	markerPosition = coordenadas.split(","); 
		    }
			$('#modalMapa').on('shown.bs.modal', function () {
				google.maps.event.trigger(map, 'resize');
		        map.setCenter(center);
		    	initialize();
		    });
		});

		$(document).on('click', '.btn-eliminar-lugar', function(event) {
			event.preventDefault();
            var idLugar = $(this).data('id');
            confirmarEliminarLugar(idLugar,$(this));
		});

		function confirmarEliminarLugar(idLugar,$this){
			swal({
			  	title: "Desea eliminar el Lugar..?",
			  	text: "Si elimina el lugar también se eliminarán todos los registros relacionados al lugar.",
			  	icon: "warning",
			  	buttons: true,
			  	dangerMode: true,
			}).then((willDelete) => {
			  	if (willDelete) {
			  		$.ajax({
						url: '<?=base_url()?>buses/lugar/remove/'+idLugar,
						type: 'POST',
						dataType: 'json',
						data: {id: idLugar},
					}).done(function(data) {
						console.log(data);
						if( data.response ){
							swal("El lugar ha sido eliminado correctamente.");
							$this.parents("tr").remove(); // Removiendo el idioma eliminado de la base de datos.
						}else{
							swal("El lugar no se puede eliminar.");
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
<script type="text/javascript">
var center = null;
function initialize() {
	center =  new google.maps.LatLng(parseFloat(markerPosition[0]), markerPosition[1]);
    var mapOptions = {
        zoom: 7,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: center
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    var marker = new google.maps.Marker({
        map: map,
        position: center
    });
}	
</script>
<style type="text/css">
	#map-canvas {
	    height: 22em;
	    width: 100%;
	}
</style>
<!--
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places&callback=initialize" async defer></script>
-->