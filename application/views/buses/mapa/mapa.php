<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-12">
			<!--
			<form id="form_map_add_lugares">
			-->
	          <div class="form-group">
	              <label for="inputLugar">Nombre del Lugar</label>
	              <input type="text" id="txt_nombre_lugar" class="form-control"  placeholder="Buscar Lugar">
	          </div>
	          <div class="form-group">
	              <label for="inputDescripcion">Descripción del Lugar</label>
	              <textarea id="txtr_descripcion_lugar" class="form-control" placeholder="Descripción del Lugar"></textarea>
	          </div>
	          <div class="form-group">
	              <label for="inputCoordenadas">Coordenadas</label>
	              <input type="text" readonly id="txt_coordenadas_lugar" class="form-control" placeholder="Coordenadas">
	          </div>
	          <div class="form-group">
	              <label for="inputTipoLugar">Tipo Lugar</label>
	              <select id="slct_tipo_lugar" class="form-control">
	                <option value="">Seleccione...</option>
	                <option value="1">Punto de Parada</option>
	                <option value="2">Restaurant</option>
	                <option value="3">Lugar Turistico</option>
	                <option value="4">Aeropuerto</option>
	                <option value="5">Estación de Tren</option>
	                <option value="6">Terminal Terrestre (Bus)</option>
	                <option value="7">Museo</option>
	                <option value="8">Punto de Reunión</option>
	                <option value="9">Otro</option>
	              </select>
	          </div>
	          <div class="form-group">
	              <!--
	              <label for="inputNumerodeOrden"> Número de Orden</label>
	              <input type="number" id="txt_numero_orden_lugar" min="0" class="form-control" placeholder="# de Orden">
	              -->
	              <p class="">Por favor registre las rutas desde el inicio hasta el final con estricto orden según a lo que se realizará el tour.</p>
	          </div>
	          <button type="button" class="btn btn-success btn-add-point">
	           Add...
	          </button>
	          <button type="button" class="btn btn-info" id="btn_listar_lugares">
	           <span class="span_cantidad_lugares" id="span_cantidad_lugares">0</span> Lugar(es)
	          </button>
	          <!--
	     </form>
	 -->
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12">
			<div id="mapaLugares"></div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<textarea class="form-control" readonly name="map_prod" id="map_prod" placeholder="mapa del tour"></textarea>
		</div>
	</div>
</div>

<div id="modal-points-list" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center"><strong><span class="fa fa-list"></span> Listar Lugares</strong></h4>
        </div>
        <div class="modal-body">
          <div class="modal-body">
            <div class="row">
              <div class="modal-list-points">

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  </div>
</div>  
<script src="<?=base_url()?>assets/js/mapa.min.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		/*
		$("#form_map_add_lugares").validationEngine('attach', {
	  		relative: true,
	  		promptPosition:"bottomLeft"
	  	});
	  	*/
	});
</script>
<!--AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c-->
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH6k6rZ7O9_O-btoDkMe9QHdgdBGT5SF4&libraries=places&callback=initAutocomplete">
</script>

<style>
   #mapaLugares {
    height: 32em;
    width: 100%;
   }
</style>