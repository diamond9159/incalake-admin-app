<div class="col-md-12">
	<div class="headline">
		<div>Lista de ubicaciones</div>
	</div>
	
	<div class="pull-right">
		<a href="<?php echo site_url('admin/lugar/add'); ?>" class="btn btn-success"><span class="fa fa-plus"></span> Agregar</a> 
	</div>	
	<div id="users">
	  <input class="search" placeholder="Search" />
	  <button class="sort" data-sort="name">
	    Buscar
	  </button>
	  <div class="col-md-12 header-list hidden-xs hidden-sm">
	  	<div class="col-md-12">
	  		<div class="col-md-1">Id Lugar</div>
			<div class="col-md-3">Nombre Lugar</div>
			<div class="col-md-2">Tipo Lugar</div>
			<div class="col-md-3">Descripcion Lugar</div>
			<div class="col-md-3">Actions</div>
	  	</div>
	  </div>
	  <div class="list">
	  	<?php foreach($lugares as $l){ 
	  		$coordenada_general=$l['coordenadas'];
	  		$cor_geo=explode(',',$coordenada_general);
	  		?>

	    <div class="container-fluid  col-md-12">
			<div class="container-fluid col-md-12 col-xs-12 name">
				<div class="col-md-1 col-sm-1 col-xs-2"><?php echo $l['id_lugar']; ?></div>
				<div class="col-md-3 col-sm-3 col-xs-6"><?php echo $l['nombre_lugar']; ?></div>
				<div class="col-md-2 col-sm-2 hidden-xs"><?php echo $l['tipo_lugar']; ?></div>
				<div class="col-md-3 col-sm-3 hidden-xs"><?php echo $l['descripcion_lugar']; ?></div>
				<div class=" col-md-3 col-sm-3 col-xs-4">
					<a href="javascript:void(0);" data-url="<?=site_url('admin/lugar/remove/'.$l['id_lugar']);?>" class="pull-right btn btn-danger btn-delete btn-sm"><span class="fa fa-close"></span></a>
					<a href="<?php echo site_url('admin/lugar/edit/'.$l['id_lugar']); ?>" class="pull-right btn btn-info btn-sm"><span class="fa fa-pencil"></span></a> 
					<a href="#myMapModal" class="pull-right btn btn-primary btn-sm modal-map" data-toggle="modal" data-center="{&quot;lat&quot;:<?=$cor_geo[0];?>,&quot;lng&quot;:<?=$cor_geo[1];?>}" data-lugar="<?=$l['nombre_lugar'];?>" data-tipolugar="<?=$l['tipo_lugar']; ?>"><span class="fa fa-map-marker"></span><span class="hidden-xs"> Mapa</span></a>
				</div>
			</div>
	    </div>
		<?php } ?>
	  </div>
	  <ul class="pagination"></ul>
	</div>

<div class="modal fade" id="myMapModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                 <h4 class="modal-title">Modal title</h4>

            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div id="map-canvas" </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
<style>
	#map-canvas {
  width:500px;
  height:480px;
}
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkqZZvNYDZpUmH0mKFNm2vk2H80rkzsDU&libraries=places" async defer></script>
<script type="text/javascript">

jQuery(document).ready(function($) {
	console.log("Loading Javascript..!");
// modal map
// $('.modal-map').click(function(){
// 	var coordenadas = $(this).data('coordenadas');
// var lista = coordenadas.split(",");
// // var concadenar='{&quot;lat&quot;:'+lista[0]+',&quot;lng&quot;:'+lista[1]+'}';
// console.log(lista[0]);
// $(this).data('center',{lat :lista[0],lng :lista[1]});
// console.log($(this).data('center'));
// });

var map;        
            var myCenter=new google.maps.LatLng(53, -1.33);
var marker=new google.maps.Marker({
    position:myCenter
});

function initialize() {
  var mapProp = {
      center:myCenter,
      zoom: 10,
      draggable: true,
      scrollwheel: true,
      mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
  map=new google.maps.Map(document.getElementById("map-canvas"),mapProp);
  marker.setMap(map);
    
  
};
google.maps.event.addDomListener(window, 'load', initialize);

google.maps.event.addDomListener(window, "resize", resizeMap());
// google.maps.event.addListener(marker, 'click', function(e) { 
//        alert($(e.relatedTarget).data('center')); 
//     }); 

$('#myMapModal').on('shown.bs.modal', function(e) {
   console.log($(e.relatedTarget).data('center'));
   resizeMap($(e.relatedTarget).data('center'),$(e.relatedTarget).data('tipolugar'),$(e.relatedTarget).data('lugar'));

});
  var infowindow = new google.maps.InfoWindow({
    content: 'null'
  });
google.maps.event.addListener(marker, 'click',function(){
	console.log('sin funcion aun');
}); 

function resizeMap(center,tipolugar,lugar) {
   if(typeof map =="undefined") return;
   google.maps.event.trigger(map, "resize");
   map.setCenter(center); 
   marker.setPosition(center);
    infowindow.setContent('<b>'+tipolugar+'</b>: '+lugar);
    infowindow.open(map, marker);
    
 
   // console.log(parseInt($('.modal-body').css('width')));
   $('#map-canvas').css('width',function( index ) {
  return parseInt($('.modal-body').css('width'))-30;
});

}


// fin modal map




/*	$(".modal-map").click(function(){
		$('.modal-body').empty();

		var coordenadas = $(this).data('coordenadas');
		console.log(coordenadas);
		$('.modal-body').html('//maps.google.com?q='+coordenadas);
		$('#modalMapa').modal({show:true});
	});*/
	/*$('#modalMapa').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget);
	  var coordenadas = button.data('coordenadas');
	  var lugar 	  = button.data('lugar');
	  var modal = $(this)
	  modal.find('.modal-title').text(lugar);
	});	
*/
	$(document).on('click', '.btn-delete', function(event) {
		event.preventDefault();
		var url = $(this).data('url');
		console.log(url);
		swal({
		  title: "Estas seguro de Eliminar..?",
		  text: "Si lo eliminas ya no aparecerá hasta que vuelvas a registrarlo..!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Si, Quiero Eliminar",
		  cancelButtonText: "No, cancelar",
		  closeOnConfirm: false,
		  closeOnCancel: true
		},
		function(isConfirm){
			if (isConfirm) {
			  	$.ajax({
			  		url: url,
			  		type: 'POST',
			  		dataType: 'JSON'
			  	}).done(function(data) {
			  		console.log(data);
			  		if (data['response'] === 'OK' ) {
					    swal({
						  title: "Eliminado..!",
						  text: "Se ha eliminado el registro..!",
						  type: "success",
						  closeOnConfirm: true
						},
						function(){
						  window.location.reload();
						});
			  		}else{
					    swal("Error..!", "No se ha eliminado el registro..!.", "danger");	
			  		}
			  	}).fail(function(e) {
			  		console.log(e.responseText);
			  	});		  	
			} else {
			    //swal("Cancelled", "Your imaginary file is safe :)", "error");
			}
		});
	});
	
});
</script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkqZZvNYDZpUmH0mKFNm2vk2H80rkzsDU&libraries=places" async defer></script> -->