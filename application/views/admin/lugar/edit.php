<?php echo validation_errors(); ?>
<style type="text/css">
	#map {
		width: 100%;
		height: 21em;
	}
	.controls {
	  margin-top: 10px;
	  border: 1px solid transparent;
	  border-radius: 2px 0 0 2px;
	  box-sizing: border-box;
	  -moz-box-sizing: border-box;
	  height: 32px;
	  outline: none;
	  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
	}
	#pac-input {
	  background-color: #fff;
	  font-family: Roboto;
	  font-size: 15px;
	  font-weight: 300;
	  margin-left: 12px;
	  padding: 0 11px 0 13px;
	  text-overflow: ellipsis;
	  width: 300px;
	}
	#pac-input:focus {
	  border-color: #4d90fe;
	}
	.pac-container {
	  font-family: Roboto;
	}
	#type-selector {
	  color: #fff;
	  background-color: #4d90fe;
	  padding: 5px 11px 0px 11px;
	}
	#type-selector label {
	  font-family: Roboto;
	  font-size: 13px;
	  font-weight: 300;
	}
</style>

<div class="container-fluid">
	<div class="headline">
		<div>Editar Ubicación</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-12">
			<input id="pac-input" class="controls" type="text"
	        placeholder="Buscar ubicación">
		    <!--
		    <div id="type-selector" class="controls">
		      <input type="radio" name="type" id="changetype-all" checked="checked">
		      <label for="changetype-all">All</label>

		      <input type="radio" name="type" id="changetype-establishment">
		      <label for="changetype-establishment">Establishments</label>

		      <input type="radio" name="type" id="changetype-address">
		      <label for="changetype-address">Addresses</label>

		      <input type="radio" name="type" id="changetype-geocode">
		      <label for="changetype-geocode">Geocodes</label>
		    </div>
		    -->
		    <div id="map"></div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12">	
			<?php echo form_open('admin/lugar/edit/'.$lugar['id_lugar'],array("class"=>"","id"=>"form_addlugar","onKeyPress"=>"return disableEnterKey(event)")); ?>
				<div class="form-group">
					<label for="nombre_lugar" class=" control-label"><span class="div-numeracion">1</span>Nombre Lugar</label>
					<div class="">
						<input type="text" name="txt_nombre_lugar" autofocus value="<?php echo ($this->input->post('nombre_lugar') ? $this->input->post('nombre_lugar') : $lugar['nombre_lugar']); ?>" class="form-control" id="txt_nombre_lugar" />
					</div>
				</div>
				<div class="form-group">
					<label for="coordenadas" class=" control-label">Coordenadas</label>
					<div class="">
						<input type="text" readonly name="txt_coordenadas" value="<?php echo ($this->input->post('coordenadas') ? $this->input->post('coordenadas') : $lugar['coordenadas']); ?>" class="form-control" id="txt_coordenadas" />
					</div>
				</div>
				<div class="form-group">
					<label for="tipo_lugar" class=" control-label"><span class="div-numeracion">2</span>Tipo Lugar</label>
					<div class="">
						<input type="text" name="txt_tipo_lugar" value="<?php echo ($this->input->post('tipo_lugar') ? $this->input->post('tipo_lugar') : $lugar['tipo_lugar']); ?>" class="form-control" id="txt_tipo_lugar" list="dtlst_lugares" />
						<datalist id="dtlst_lugares">
						    <option value="Parada"></option>
						    <option value="Punto de Partida"></option>
						    <option value="Punto de Llegada"></option>
						    <option value="Provincia"></option>
						    <option value="Distrito"></option>
						    <option value="Aeropuerto"></option>
						    <option value="Puerto"></option>
						    <option value="Estación de Tren"></option>
						    <option value="Restaurant"></option>
						    <option value="Hotel"></option>
						    <option value="Terminal Terrestre"></option>
						</datalist>
					</div>
				</div>
				<div class="form-group">
					<label for="descripcion_lugar" class=" control-label"><span class="div-numeracion">3</span>Descripcion Lugar</label>
					<div class="">
						<textarea name="txt_descripcion_lugar" class="form-control " id="txt_descripcion_lugar" rows="3">
							<?php echo ($this->input->post('descripcion_lugar') ? $this->input->post('descripcion_lugar') : $lugar['descripcion_lugar']); ?>
						</textarea>
					</div>
				</div>
				<!--
				<div class="form-group">
					<label for="id_servicio" class="col-md-4 control-label">Selecciona al Servicio que pertenece el Lugar</label>
					<div class="col-md-8">
						<select name="slct_servicio" id="slct_servicio" class="form-control">
							<option value="">select servicio</option>
							<?php 
							foreach($all_servicio as $servicio){
								$selected = ($servicio['id_servicio'] == $this->input->post('id_servicio')) ? ' selected="selected"' : "";
								echo '<option value="'.$servicio['id_servicio'].'" '.$selected.'>'.$servicio['nombre_servicio'].'</option>';
							} 
							?>
						</select>
					</div>
				</div>
				-->
				<div class="form-group">
				<?php
					if ( isset( $error ) ) {
						echo '<div class="alert alert-danger alert-lg">'.$error.'</div>';
					}
				?>
				</div>
				<div class="form-group">
					<div class="text-center">
						<a href="<?php echo site_url('admin/lugar'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> Volver</a>
						<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button>
			        </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<?php
	$latitud  = -15.8422 ;
	$longitud = -70.0199 ;
	if ( !empty( $lugar['coordenadas'] ) ) {
		$coordenadas_array = explode(',',$lugar['coordenadas']);
		$latitud = $coordenadas_array[0];
		$longitud= $coordenadas_array[1]; 
	}
?>
<script>
	function disableEnterKey(e){
		var key;
		if(window.event){
			key = window.event.keyCode;
		}else{
			key = e.which;
		}
		if(key==13){
			return false;
		}else{
			return true;
		}
	}
	var map = null, placeSearch, autocomplete2;
	function initMap() {
		autocomplete2 = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */(document.getElementById('txt_nombre_lugar')),
		{types: ['geocode']});
		autocomplete2.addListener('place_changed', fillInAddress);
		
		/***********************************************************************************/
		map = new google.maps.Map(document.getElementById('map'), {
	    	center: {lat: parseFloat('<?=$latitud;?>'), lng: parseFloat('<?=$longitud;?>')}, 
	    	zoom: 13
	  	});
	    /****************************BEGIN MARCAR CON COORDENAS DESDE BD*********************************/
		var infowindowDB = new google.maps.InfoWindow();
	  	var markerDB = new google.maps.Marker({
	    	map: map,
	    	anchorPoint: new google.maps.Point(0, -29)
	  	});
		markerDB.setIcon(/** @type {google.maps.Icon} */({
      		url: 'https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png',
	      	size: new google.maps.Size(71, 71),
	      	origin: new google.maps.Point(0, 0),
	      	anchor: new google.maps.Point(17, 34),
	      	scaledSize: new google.maps.Size(35, 35)
	    }));
	    var latlng = new google.maps.LatLng('<?=$latitud;?>', '<?=$longitud;?>');
	    markerDB.setPosition(latlng);
	    markerDB.setVisible(true);
	    var address = '';
	    
	    infowindowDB.setContent('<div><strong><?=$lugar['nombre_lugar'];?></strong><br>' + address);
	    infowindowDB.open(map, markerDB);
	    /*****************************END MARCAR CON COORDENAS DESDE BD*********************************/

	  	var input = /** @type {!HTMLInputElement} */(document.getElementById('pac-input'));
	  	var types = document.getElementById('type-selector');
	  	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	  	map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

	  	var autocomplete = new google.maps.places.Autocomplete(input);
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
			var place_string = JSON.stringify(place);
			document.getElementById('txt_nombre_lugar').value = place.formatted_address;
	    	var place_json = JSON.parse(place_string);
	    	document.getElementById('txt_coordenadas').value = place_json.geometry.location.lat+','+place_json.geometry.location.lng;
	    	if (!place.geometry) {
	      		window.alert("Autocomplete's returned place contains no geometry");
	      		return;
	    	}

	    	if (place.geometry.viewport) {
	      	map.fitBounds(place.geometry.viewport);
	    	} else {
	      		map.setCenter(place.geometry.location);
	      		map.setZoom(17);
	    	}
	    	marker.setIcon(/** @type {google.maps.Icon} */({
	      		url: place.icon,
		      	size: new google.maps.Size(71, 71),
		      	origin: new google.maps.Point(0, 0),
		      	anchor: new google.maps.Point(17, 34),
		      	scaledSize: new google.maps.Size(35, 35)
		    }));
		    marker.setPosition(place.geometry.location);
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

		// Sets a listener on a radio button to change the filter type on Places
		// Autocomplete.
		/*
		function setupClickListener(id, types) {
		var radioButton = document.getElementById(id);
		radioButton.addEventListener('click', function() {
		  autocomplete.setTypes(types);
		});
		}

		setupClickListener('changetype-all', []);
		setupClickListener('changetype-address', ['address']);
		setupClickListener('changetype-establishment', ['establishment']);
		setupClickListener('changetype-geocode', ['geocode']);
		*/
	}

	function fillInAddress() {
		var place = autocomplete2.getPlace();

		var infowindow = new google.maps.InfoWindow();
	  	var marker = new google.maps.Marker({
	    	map: map,
	    	anchorPoint: new google.maps.Point(0, -29)
	  	});
	  	infowindow.close();
	    marker.setVisible(false);
	    if (!place.geometry) {
      		window.alert("Autocomplete's returned place contains no geometry");
      		return;
    	}

    	if (place.geometry.viewport) {
      	map.fitBounds(place.geometry.viewport);
    	} else {
      		map.setCenter(place.geometry.location);
      		map.setZoom(17);
    	}
    	marker.setIcon(/** @type {google.maps.Icon} */({
      		url: place.icon,
	      	size: new google.maps.Size(71, 71),
	      	origin: new google.maps.Point(0, 0),
	      	anchor: new google.maps.Point(17, 34),
	      	scaledSize: new google.maps.Size(35, 35)
	    }));
	    marker.setPosition(place.geometry.location);
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

		var place_string = JSON.stringify(place);
		document.getElementById('txt_nombre_lugar').value = place.formatted_address;
    	var place_json = JSON.parse(place_string);
    	document.getElementById('txt_coordenadas').value = place_json.geometry.location.lat+','+place_json.geometry.location.lng;
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkqZZvNYDZpUmH0mKFNm2vk2H80rkzsDU&libraries=places&callback=initMap" async defer></script>
