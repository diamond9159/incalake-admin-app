
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-2 col-sm-4 col-md-offset-2">
			<h3 class="text-primary"><span class="fa fa-edit"></span> AGREGAR NUEVO LUGAR</h3>
			<?php echo form_open('buses/lugar/add',array("class"=>"form-horizontal", "id"=>"form_add_lugar")); ?>
				<div class="form-group">
					<label for="nombre_lugar" class="col-md-12">Nombre Lugar <span class="text-danger fa fa-asterisk"></span></label>
					<div class="col-md-12">
						<input type="text" name="nombre_lugar" autofocus value="<?php echo $this->input->post('nombre_lugar'); ?>" class="form-control validate[required]" id="nombre_lugar" />
						<span class="text-danger"><?php echo form_error('nombre_lugar');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="coordenadas" class="col-md-12">Coordenadas <span class="text-danger fa fa-asterisk"></span></label>
					<div class="col-md-12">
						<input type="text" name="coordenadas" value="<?php echo $this->input->post('coordenadas'); ?>" class="form-control validate[required]" id="coordenadas" readonly/>
						<span class="text-danger"><?php echo form_error('coordenadas');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="tipo_lugar" class="col-md-12">Tipo Lugar <span class="text-danger fa fa-asterisk"></span></label>
					<div class="col-md-12">
						<select name="tipo_lugar" class="form-control validate[required]" id="tipo_lugar">
							<option value="">Seleccione</option>
							<?php 
							$all_types = ['Parada','Terminal Terrestre','Lugar Turístico','Otro'];
							foreach($all_types as $key => $at){
								echo '<option value="'.$key.'" >'.$at.'</option>';
							} 
							?>
						</select>
						<span class="text-danger"><?php echo form_error('tipo_lugar');?></span>
					</div>
				</div>				
		</div>
		<div class="col-md-4 col-sm-4">
			<div class="form-group">
				<h3 class="text-primary"><span class="fa fa-map-marker"></span> MAPA DEL LUGAR</h3>
		    	<div id="map"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12 text-center">
				<button type="submit" class="btn btn-success">GUARDAR</button>
				<a href="<?=base_url()?>buses/lugar" class="btn btn-danger"><span></span> VOLVER</a>
	        </div>
		</div>
			<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
  var map = null;
  function initMap() {
  	var puno = {lat:-15.8402218,lng:-70.02188050000001};
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: puno
    });
    
  	var autocomplete = new google.maps.places.Autocomplete(
	/** @type {!HTMLInputElement} */(document.getElementById('nombre_lugar')),
	{types: ['geocode']});

  	autocomplete.bindTo('bounds', map);

	var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
      map: map,
      anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
      	infowindow.close();
      	marker.setVisible(false);
      	var place = autocomplete.getPlace();
      	if (!place.geometry) {
        	// User entered the name of a Place that was not suggested and
        	// pressed the Enter key, or the Place Details request failed.
        	window.alert("No details available for input: '" + place.name + "'");
        	return;
      	}

      	// If the place has a geometry, then present it on a map.
      	if (place.geometry.viewport) {
        	map.fitBounds(place.geometry.viewport);
      	} else {
        	map.setCenter(place.geometry.location);
        	map.setZoom(17);  // Why 17? Because it looks good.
      	}

  		marker.setIcon(/** @type {google.maps.Icon} */({
    		url: place.icon,
    		size: new google.maps.Size(71, 71),
    		origin: new google.maps.Point(0, 0),
    		anchor: new google.maps.Point(17, 34),
    		scaledSize: new google.maps.Size(35, 35)
  		}));
  		marker.setPosition(place.geometry.location);
  		actualizarCoordenadas( place.geometry.location );

  		marker.setVisible(true);

      	var address = '';
      	if (place.address_components) {
        	address = [
          		(place.address_components[0] && place.address_components[0].short_name || ''),
          		(place.address_components[1] && place.address_components[1].short_name || ''),
          		(place.address_components[2] && place.address_components[2].short_name || '')
        	].join(' ');
      	}
	    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
	    infowindow.open(map, marker);
    });
  }

  function actualizarCoordenadas(coordenadas){
  	var stringCoordenadas = JSON.stringify(coordenadas);
  	document.getElementById("coordenadas").value = ( stringCoordenadas.replace('{"lat":', "") ).replace('"lng":',"").replace("}","");
  }
  jQuery(document).ready(function($) {
    $("#form_add_lugar").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});
  });
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places&callback=initMap">
</script>

<style>
   #map {
    height: 22em;
    width: 100%;
   }
</style>