
<div class="container-fluid" id="app">
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2">
			<h2 class="text-primary"><span class="fa fa-edit"></span> EDITAR PÁGINA WEB - <?=mb_strtoupper(@$pagina_web['titulo_pagina'])?></h2><hr/>
			<?php echo form_open('buses/page/edit/'.$pagina_web['id_pagina'].'/'.@$codigo_page.'/'.@$selected_idioma,array("class"=>"form-horizontal","id"=>"form_add_page")); ?>
				<input type="hidden" name="codigo_page" value="<?=$codigo_page?>" />
				<div class="form-group">
					<label for="url_pagina" class="col-md-12">Seleccione idioma <span class="text-danger fa fa-asterisk" title="Obligatorio"></span></label>
					<div class="col-md-12">
						<select name="id_idioma" id="id_idioma" class="form-control validate[required]" v-model="idioma">
							<option value="">Seleccione...</option>}
							<?php foreach (@$idiomas as $key => $value): ?>
								<?php 
									$selected = mb_strtolower($value['codigo'])==mb_strtolower($selected_idioma)?'selected':'';
								?>
								<option value="<?=$value['id_idioma']?>" <?=$selected;?> ><?=mb_strtoupper($value['pais'])?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="ubicacion_servicio" class="col-md-12">Ubicación del Servicio <span class="text-danger fa fa-asterisk" title="Obligatorio"></span></label>
					<div class="col-md-12">
						<input type="text" name="ubicacion_servicio" value="<?php echo ($this->input->post('ubicacion_servicio') ? $this->input->post('ubicacion_servicio') : $pagina_web['ubicacion_servicio']); ?>" class="form-control validate[required]" id="ubicacion_servicio" autofocus v-model="ubicacion_servicio"/>
						<span class="text-danger"><?php echo form_error('ubicacion_servicio');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="titulo_pagina" class="col-md-12">Título de la Página Web <span class="text-danger fa fa-asterisk" title="Obligatorio"></span></label>
					<div class="col-md-12">
						<input type="text" name="titulo_pagina" value="<?php echo ($this->input->post('titulo_pagina') ? $this->input->post('titulo_pagina') : $pagina_web['titulo_pagina']); ?>" class="form-control validate[required]" id="titulo_pagina" />
						<span class="text-danger"><?php echo form_error('titulo_pagina');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="descripcion_pagina" class="col-md-12">Descripción de la Página Web <span class="text-danger fa fa-asterisk" title="Obligatorio"></span></label>
					<div class="col-md-12">
						<textarea name="descripcion_pagina" class="form-control validate[required]" id="descripcion_pagina"><?php echo ($this->input->post('descripcion_pagina') ? $this->input->post('descripcion_pagina') : $pagina_web['descripcion_pagina']); ?></textarea>
						<span class="text-danger"><?php echo form_error('descripcion_pagina');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="uri_pagina" class="col-md-12">Url de la Página Web <span class="text-danger fa fa-asterisk" title="Obligatorio"></span></label>
					<div class="col-md-12">
						<div class="input-group">
						  	<span class="input-group-addon" id="spnUrlBase">
						  		<strong>http://bustickets.incalake.com/</strong>
						  	</span>
						  	<input type="text" name="uri_pagina" value="<?php echo ($this->input->post('uri_pagina') ? $this->input->post('uri_pagina') : $pagina_web['uri_pagina']); ?>" class="form-control validate[required]" id="uri_pagina" onkeypress="return validarCaracter(event)"/>
						</div>
						<span class="text-danger"><?php echo form_error('uri_pagina');?></span>
					</div>
				</div>
				<div class="form-group" style="display:none;">
					<label for="url_pagina" class="col-md-12">Url Página Web</label>
					<div class="col-md-12">
						<input type="text" name="url_pagina" value="<?php echo ($this->input->post('url_pagina') ? $this->input->post('url_pagina') : $pagina_web['url_pagina']); ?>" class="form-control" id="url_pagina" />
						<span class="text-danger"><?php echo form_error('url_pagina');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="imagen_principal" class="col-md-12">Imagen Principal para la Página Web</label>
					<div class="col-md-12">
				      	<!--input type="file" name="imagen_principal" value="<?php echo ($this->input->post('imagen_principal') ? $this->input->post('imagen_principal') : $pagina_web['imagen_principal']); ?>" class="form-control" id="imagen_principal" /-->
								<div class="galeriaDivs">
									<button onclick="openGaleria($(this),1,'Slider principal bus',[1200,400]);" type="button">
									<span class="fa fa-search-plus"></span> Seleccionar slider principal</button>
									<input type="text" class="inputImagenModal" value="<?=$pagina_web['imagen_principal_url'];?>" readonly>
									<input type="hidden" class="inputHideImagenModal" name="imagen_principal" value="<?=$pagina_web['imagen_principal'];?>">
								</div>
						<span class="text-danger"><?php echo form_error('imagen_principal');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="miniatura_pagina" class="col-md-12">Imágen en Miniatura para la Página Web</label>
					<div class="col-md-12">
						<!--input type="file" name="miniatura_pagina" value="<?php echo ($this->input->post('miniatura_pagina') ? $this->input->post('miniatura_pagina') : $pagina_web['miniatura_pagina']); ?>" class="form-control" id="miniatura_pagina" /-->
							<div class="galeriaDivs">
									<button onclick="openGaleria($(this),3,'Miniatura bus',[150,150]);" type="button">
									<span class="fa fa-search-plus"></span> Seleccionar miniatura</button>
									<input type="text" class="inputImagenModal" value="<?=$pagina_web['miniatura_pagina_url'];?>" readonly>
									<input type="hidden" class="inputHideImagenModal" name="miniatura_pagina" value="<?=$pagina_web['miniatura_pagina'];?>">
							</div>
						<span class="text-danger"><?php echo form_error('miniatura_pagina');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="ver_slider" class="col-md-12"> Mostrar Slider en la Página Web</label>
					<div class="col-md-12">
						<?php 
							//echo json_encode($pagina_web);
						?>
						<div class="checkbox">
							<?php 
								$checkedMostrarSlider = '';
								if ( (Integer)$pagina_web['ver_slider'] ){
									$checkedMostrarSlider = ' checked';			
								}
							?>
						  	<label><input type="checkbox" name="ver_slider" value="1" id="ver_slider" <?=$checkedMostrarSlider?> > Mostrar Slider/Ocultar Slider</label>
						</div>
						<span class="text-danger"><?php echo form_error('ver_slider');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="valoracion_pagina" class="col-md-12">Valoración Página</label>
					<div class="col-md-12 input-star-review">
						<input type="text" name="valoracion_pagina" value="<?php echo ($this->input->post('valoracion_pagina') ? $this->input->post('valoracion_pagina') : $pagina_web['valoracion_pagina']); ?>" class="form-control kv-ltr-theme-fa-star rating-loading" id="valoracion_pagina" data-size="xs" dir="ltr"/>
						<span class="text-danger"><?php echo form_error('valoracion_pagina');?></span>
					</div>
				</div>
				<div class="form-group container-fluid" style="padding: 0;">
		            <div class="col-md-12 col-xs-12 col-sm-12" id="div_txt_comentarios">
		                <div class="">
		                  <a href="javascript:void(0)" class="btn btn-warning btn-add-reviews">Agregar Comentarios..!</a>
		                  <a href="javascript:void(0)" title="Click para Ver Comentarios..!" class="btn-list-reviews"><strong><span class="fa fa-list"> </span> <span class="contador-reviews">0</span><span> Comentario(s)..!</span></strong></a> 
		                </div>
		                <textarea name="reviews_pagina" id="reviews_pagina" class="form-control" style="display: none;"><?=$pagina_web['reviews_pagina']?></textarea>
		            	<span class="text-danger"><?php echo form_error('reviews_pagina');?></span>
		            </div>
		        </div>

				<div class="form-group">
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-success">GUARDAR</button>
						<a href="<?=base_url()?>buses/page/" class="btn btn-danger">VOLVER</a>
			        </div>
				</div>
			<?php echo form_close(); ?>		
		</div>
	</div>
</div>


<!-- ---------------------------------------------------------- -->
<div id="modal-reviews" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Agregar Comentarios</strong></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="form-comentario">
            <div class="form-group">
              <label for="valoracion" class="col-md-4 control-label">Valoración/Page Rank</label>
              <div class="col-md-8 input-star-review">
                <input type="text" name="txt_valoracion2" value="5" class="form-control validate[required] kv-ltr-theme-fa-star rating-loading" id="txt_valoracion2" data-size="xs" dir="ltr">
              </div>
            </div>
            <div class="form-group">
          <label for="nombre_comentarista" class="col-md-4 control-label">Nombre del Comentarista</label>
          <div class="col-md-8">
            <input type="text" autofocus name="txt_nombre_comentarista" value="" style="text-transform: uppercase;" class="form-control validate[required]" id="txt_nombre_comentarista" />
          </div>
        </div>
        <div class="form-group">
          <label for="nacionalidad_comentarista" class="col-md-4 control-label">País del Comentarista</label>
          <div class="col-md-8">
            <input type="text" name="txt_nacionalidad_comentarista" class="form-control validate[required]" id="txt_nacionalidad_comentarista"/>
          </div>
        </div>
        <div class="form-group">
          <label for="comentario" class="col-md-4 control-label">Comentario</label>
          <div class="col-md-8">
            <textarea name="txt_comentario" value="" class="form-control validate[required]" id="txt_comentario" ></textarea>
          </div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-agregar-comentario"> Agregar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
  </div>
</div>

<div id="modal-reviews-list" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Listar Comentarios</strong></h4>
        </div>
        <div class="modal-body">
          <div class="modal-body">
            <div class="row">
              <div class="modal-list-reviews">

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
<!-- ---------------------------------------------------------- -->

<script type="text/javascript">
	var arrayIdiomas = JSON.parse('<?=json_encode(@$idiomas);?>');
	var codigo_idioma = "<?=$selected_idioma?>"+"/";
	var base_url = "http://bustickets.incalake.com/";

	jQuery(document).ready(function($) {    
	    $("#form_add_page").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});

	    $(document).on('change', '#id_idioma', function(event) {
			event.preventDefault();
			generarUrl( $(this) );
		});

		$(document).on('change', '#ubicacion_servicio', function(event) {
			event.preventDefault();
			generarUrl( $(this) );
		});
		generarUrl($);
       $('#valoracion_pagina').rating({
	        hoverOnClear: false,
	        theme: 'krajee-fa',
	        min: 0, 
	        max: 5, 
	        step: 1, 
	        stars: 5
	    });
       $('#txt_valoracion2').rating({
	        hoverOnClear: false,
	        theme: 'krajee-fa',
	        min: 0, 
	        max: 5, 
	        step: 1, 
	        stars: 5
	    });

	});

	function generarUrl($this){
		var id_idioma			= '';
		var ubicacion_servicio 	= '';
		var subUriString = '';
		window.setTimeout(()=>{
			id_idioma			= $("#id_idioma").val();
        	ubicacion_servicio  = $("#ubicacion_servicio").val();
			subUriString 		= subUri(id_idioma,ubicacion_servicio);
			baseUrl(subUriString);
        }, 100);
	}

	function subUri(id_idioma,ubicacion_servicio){
		/** Obteniendo codigo idioma **/
		$.each(arrayIdiomas, function(index, val) {
			if( parseInt(val.id_idioma) === parseInt(id_idioma) ){
				codigo_idioma = val.codigo+"/";
			}
		});
		/** Obteniendo el primer token de la ubicación **/
		if(ubicacion_servicio.trim().length > 0 ){
			return codigo_idioma+( ( ubicacion_servicio.trim().split(',') )[0] ).replace(" ", "-").toLowerCase()+"/";
		}else{
			return codigo_idioma;
		}
	}
	function baseUrl(uri){ /** Completando base url en el span **/
		$("#spnUrlBase").empty().html("<strong>"+base_url+uri+"</strong>");
		$("#url_pagina").empty().val(base_url+uri);
	}
	function validarCaracter(e){
		var key = window.event ? e.keyCode : e.which;
		//console.log(key);
    	if ( (48 <= key && key <= 57) || (key == 0) || (key == 8) || ( 97 <= key && key <= 122 ) || key == 45 || key == 95 ) { 
    		return true; 
    	} else { 
    		return false; 
    	}   
	}

	function initAutocomplete() {
		autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */(document.getElementById('ubicacion_servicio')),
		{types: ['geocode']});

		autocompleteComentarista = new google.maps.places.Autocomplete(
      	/** @type {!HTMLInputElement} */(document.getElementById('txt_nacionalidad_comentarista')),
      	{types: ['geocode']});
	}

	/** COMENTARIOS **/
	$("#form-comentario").validationEngine('attach', {
      relative: true,
      promptPosition:"bottomLeft"
    });
    /*********************** BEGIN SCRIPT GESTIONAR REVIEWS *********************/
    var reviews = {items: [] };

   /***************** CARGAR COMENTARIOS *********************/
   var stringComentarios = '<?=@$pagina_web["reviews_pagina"]?>';
   var arrayComentarios = [];
   if( stringComentarios.trim().length > 0 ){
		arrayComentarios = JSON.parse(stringComentarios);		   		
   }
   
   $.each(arrayComentarios, function(index, val) {
		var item_comentario = {
		    rating			: val['rating'],
		    nombres			: val['nombres'],
		    nacionalidad	: val['nacionalidad'],
		    comentario 		: val['comentario'],
		    fecha			: ''
		};
		reviews.items.push(item_comentario);
   });
   $('.contador-reviews').empty().append(reviews.items.length);
   $('#reviews_pagina').empty().val(JSON.stringify(reviews.items));
   /**********************************************************/

  
  $('#modal-reviews').modal(
    { show: false }
  ).on('shown',function(){
      initMap();
      $('#txt_nombre_comentarista').focus();
  });
    
    $(document).on('click', '.btn-add-reviews', function(event) {
      event.preventDefault();
      $('#modal-reviews').modal('show');  
    });
    
    $(document).on('click', '.btn-agregar-comentario', function(event) {
      event.preventDefault();
      var rating_c    = $('#txt_valoracion2').val();
      var nombre_c    = $('#txt_nombre_comentarista').val();
      var nacionalidad_c  = $('#txt_nacionalidad_comentarista').val();
      var comentario_c  = $('#txt_comentario').val();
      if ( $("#form-comentario").validationEngine('validate') ) {
        $('#form-comentario')[0].reset();
        $('#modal-reviews').modal('hide');  

        if (rating_c==0) {
          rating_c==4;
        }
        var item_comentario = {
          rating:rating_c,
          nombres: nombre_c,
          nacionalidad: nacionalidad_c,
          comentario: comentario_c,
          fecha: ''
        };
        reviews.items.push(item_comentario);
        $('.contador-reviews').empty().append(reviews.items.length);
        $('#reviews_pagina').empty().val(JSON.stringify(reviews.items));

      }
    });
    $(document).on('click', '.btn-list-reviews', function(event) {
      event.preventDefault();
      var reviews_html  = '';
      if ( reviews.items.length === 0 ) {
        $('.modal-list-reviews').empty().append('No hay comentarios..!');
      }else{
        $.each( reviews.items, function(index, val) {
          var rating_coments =val.rating;
          if((val.rating)==null){
            rating_coments = 4+' default';
          }
          reviews_html += '<div class="alert alert-warning container-fluid">'+
                  '<div class="col-md-5" style="padding:0px;"><p><span class="fa fa-star"></span> '+rating_coments+'</p><p>'+val.nombres+'</p>'+
                            '<p>'+val.nacionalidad+'</p>'+
                            '</div>'+
                            '<div class="col-md-6">'+val.comentario+'</div>'+
                            '<div class="col-md-1"><span class="fa fa-close btn-eliminar-review" data-id="'+index+'"></span></div>'+
                          '</div>';
        });
        $('.modal-list-reviews').empty().append(reviews_html);
      }
      $('#modal-reviews-list').modal('show');
    });

  $(document).on('click', '.btn-eliminar-review', function(event) {
    event.preventDefault();
    console.log($(this).data('id'));
    reviews.items.splice( parseInt( $(this).data('id')) , 1 );
    var reviews_html  = '';
      if ( reviews.items.length === 0 ) {
        $('.modal-list-reviews').empty().append('No hay comentarios..!');
      }else{
        $.each( reviews.items, function(index, val) {
          var rating_coments =val.rating;
          if((val.rating)==null){
            rating_coments = 4+' default';
          }
          reviews_html += '<div class="alert alert-warning container-fluid">'+
                  '<div class="col-md-5" style="padding:0px;"><p><span class="fa fa-star"></span> '+rating_coments+'</p><p>'+val.nombres+'</p>'+
                            '<p>'+val.nacionalidad+'</p>'+
                            '</div>'+
                            '<div class="col-md-6">'+val.comentario+'</div>'+
                            '<div class="col-md-1"><span class="fa fa-close btn-eliminar-review" data-id="'+index+'"></span></div>'+
                          '</div>';
        });
        $('.modal-list-reviews').empty().append(reviews_html);
      }
      $('#reviews_pagina').empty().val(JSON.stringify(reviews.items));
      $('.contador-reviews').empty().append(reviews.items.length);
      $('#modal-reviews-list').modal('show');
  });
  /*********************** END  SCRIPT GESTIONAR  REVIEWS *********************/

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places&callback=initAutocomplete" async defer></script>
<style type="text/css">
  /*** Style para mostrar el buscador de Google Place en el Modal [Agregar Comentario] ***/
    .pac-container {
        z-index: 10000 !important;
    }
</style>

