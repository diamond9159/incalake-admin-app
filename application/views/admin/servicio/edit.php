<?php
	if (!empty($first_servicio) ) {
		//echo json_encode($first_servicio);
	}
	//echo json_encode($idioma_seleccionado);
?>
<div class="container-fluid">
	<div class="headline">
		<div>Editar página web</div>
	</div>
	<h3 class="text-left  text-info"><strong><span class="fa fa-pencil-square"></span> EDITAR: "<ins><?=mb_strtoupper($servicio['titulo_pagina']);?></ins>" EN EL IDIOMA <?=$idioma_seleccionado['pais']?></strong></h3>
	<hr/>
	<?php echo validation_errors(); ?>
	<?php echo form_open('admin/servicio/edit/'.$servicio['id_servicio'],array("class"=>"form-horizontal","id"=>"form_servicio_edit")); ?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
				<button type="submit" class="btn btn-success">Guardar y Agregar Producto</button>
				<a href="<?php echo site_url('admin/servicio'); ?>" class="btn btn-danger">Volver</a> 
		    </div>
		</div><hr/>
		<div class="form-group">
			<label for="id_idioma" class="col-md-4 control-label">Seleccionar Idioma</label>
			<div class="col-md-8">
				<select name="txt_id_idioma" class="form-control validate[required]" id="txt_id_idioma">
					<?php 
					foreach($all_idiomas as $idioma){
						$selected = ($idioma['id_idioma'] ==  $servicio['idioma_id_idioma'] ) ? ' selected="selected"' : "";
						echo '<option value="'.$idioma['id_idioma'].'" '.$selected.'>'.$idioma['pais'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="lugar_pagina" class="control-label col-md-4"> Ciudad de salida del tour <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Seleccione o busque el lugar donde esta ubicado el tour que mostrarás en la página web.."></span></label>
			<div class="col-md-8">
				<input type="text" name="txt_lugar_pagina" value="<?php echo ($this->input->post('txt_lugar_pagina') ? $this->input->post('txt_lugar_pagina') : $servicio['ubicacion_servicio']); ?>" class="form-control validate[required]" id="txt_lugar_pagina" placeholder="Buscar..."/>
			</div>
		</div>
		<div class="form-group">
			<label for="titulo_pagina" class="col-md-4 control-label">Titulo de la Página Web</label>
			<div class="col-md-8">
				<input type="text" name="txt_titulo_pagina" value="<?php echo ($this->input->post('titulo_pagina') ? $this->input->post('titulo_pagina') : $servicio['titulo_pagina']); ?>" class="form-control validate[required]" id="txt_titulo_pagina" />
			</div>
		</div>
		<div class="form-group">
			<label for="url_servicio" class="col-md-4 control-label">Url de la Página Web</label>
			<div class="col-md-8">
				<!--
				<input type="text" name="txt_url_servicio" value="<?php echo ($this->input->post('url_servicio') ? $this->input->post('url_servicio') : $servicio['url_servicio']); ?>" class="form-control validate[required]" id="txt_url_servicio"/>
				-->
				<?php 
					$url = trim($servicio['url_servicio']);
					$dominio = '';
					if ( !empty($url) ) {
						$array_url = explode("/",$url);
						$dominio = $array_url[0].'/'.$array_url[1].'/'.$array_url[2].'/'.$array_url[3].'/'.$array_url[4].'/';
					}
					//echo json_encode($array_url);
				?>
				<div class="input-group col-md-12">
				    <span class="input-group-addon" id="spn_url_base" style="font-weight: bold;"><?=$dominio;?></span>
				    <input type="text" name="txt_url_servicio" value="<?php echo ($this->input->post('url_servicio') ? $this->input->post('url_servicio') : str_replace(".html" ,"" ,$array_url[5]) ); ?>" class="form-control validate[required]" id="txt_url_servicio" onkeyup="javascript:this.value=this.value.toLowerCase();" style="text-transform:lowercase;" />
				    
				</div>
				<input type="text" name="txt_url_pagina_web" value="<?php echo ($this->input->post('url_servicio') ? $this->input->post('url_servicio') : $servicio['url_servicio']); ?>" id="txt_url_pagina_web" class="form-control" onkeyup="javascript:this.value=this.value.toLowerCase();" style="text-transform:lowercase;">
			</div>
		</div>
		<div class="form-group">
			<label for="descripcion_pagina" class="col-md-4 control-label">Descripción de la Página</label>
			<div class="col-md-8">
				<textarea name="txt_descripcion_pagina" class="form-control validate[required]" id="txt_descripcion_pagina"><?php echo ($this->input->post('descripcion_pagina') ? $this->input->post('descripcion_pagina') : $servicio['descripcion_pagina']); ?></textarea>
			</div>
		</div>
		<?php //echo json_encode($slider); ?>
		<div class="form-group">
			<label for="imagen_principal_" class="col-md-4 control-label">Slider/Imágen Principal</label>
			<div class="col-md-8">
				<!--span class="tooltip-image"></span>
				<input type="file" name="imagen_principal" value="<?php echo ($this->input->post('imagen_principal') ? $this->input->post('imagen_principal') : $servicio['imagen_principal']); ?>" class="" id="imagen_principal"/>
				<input type="hidden" name="txt_imagen_principal" value="<?php echo ($this->input->post('imagen_principal') ? $this->input->post('imagen_principal') : $servicio['imagen_principal']); ?>" class="validate[required]" id="txt_imagen_principal"/-->
					<div class="galeriaDivs">
						<button onclick="openGaleria($(this),1,'Slider principal',[1200,400,150,200]); return false;">
						<span class="fa fa-search-plus"></span> Seleccionar Slider</button>
						<input type="text" class="inputImagenModal" value="<?=@$slider['url_archivo']; ?>" readonly />
					    <input type="hidden" class="inputHideImagenModal" name="txt_imagen_principal" value="<?=@$servicio['imagen_principal']; ?>" />
				   </div>
			</div>
		</div>
		<div class="form-group">
			<label for="ver_slider" class="col-md-4 control-label">Mostrar la imágen como slider en el index de la Página Web.</label>
			<div class="col-md-8">
				<input type="checkbox" name="txt_ver_slider" value="1"  <?php echo ($servicio['ver_slider']==1 ? 'checked="checked"' : ''); ?>  id="txt_ver_slider" />
			</div>
		</div>
		<?php //echo json_encode($miniatura); ?>
		<?php 
			
			//echo $miniatura['url_archivo'];
		?>
		<div class="form-group">
			<label for="miniatura_" class="col-md-4 control-label">Miniatura</label>
			<div class="col-md-8"><!--span class="tooltip-image-thumbnail"></span>
				<input type="file" name="miniatura" value="<?php echo ($this->input->post('miniatura') ? $this->input->post('miniatura') : $servicio['miniatura']); ?>" id="miniatura"/>
				<input type="hidden" name="txt_miniatura" value="<?php echo ($this->input->post('miniatura') ? $this->input->post('miniatura') : $servicio['miniatura']); ?>" id="txt_miniatura"/-->
					<div class="galeriaDivs">
						<button onclick="openGaleria($(this),3,'Imagen de los tours relacionados.',[150,150,50,100]); return false;">
						<span class="fa fa-search-plus"></span> Seleccionar Miniatura</button>
						<input type="text" class="inputImagenModal" value="<?=@empty($servicio['miniatura'])?'':$miniatura['url_archivo']; ?>" readonly />
					    <input type="hidden" class="inputHideImagenModal" name="txt_miniatura" value="<?=@$servicio['miniatura'];?>" />
				   </div>
			</div>
		</div>
		<div class="form-group">
			<label for="valoracion" class="col-md-4 control-label">Valoración/Page Rank</label>
			<div class="col-md-8">
				<input type="text" name="txt_valoracion" value="<?=$servicio['valoracion'];?>" class="form-control validate[required] kv-ltr-theme-fa-star rating-loading" id="txt_valoracion" data-size="xs" dir="ltr">
			</div>
		</div>
		<div class="form-group">
			<label for="reviews" class="col-md-4 control-label">Reviews/Comentarios de los Clientes</label>
			<div class="col-md-8">
				<div class="">
					<a href="javascript:void(0)" class="btn btn-warning btn-add-reviews">Agregar Comentarios..!</a>
					<a href="javascript:void(0)" title="Click para Ver Comentarios..!" class="btn-list-reviews"><strong><span class="fa fa-list"> </span> <span class="contador-reviews">0</span><span> Comentario(s)..!</span></strong></a> 
				</div>
				<input type="hidden" name="txt_reviews" class="form-control" id="txt_reviews" value="<?php echo ($this->input->post('txt_reviews') ? $this->input->post('txt_reviews') : $servicio['reviews']); ?>" />
			</div>
		</div>
		<hr/>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
				<button type="submit" class="btn btn-success">Guardar</button>
				<a href="<?php echo site_url('admin/servicio'); ?>" class="btn btn-danger">Volver</a> 
	        </div>
		</div>

	<?php echo form_close(); ?>
</div>
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
						<input type="text" autofocus name="txt_nombre_comentarista" value="" class="form-control validate[required]" id="txt_nombre_comentarista" />
					</div>
				</div>
				<div class="form-group">
					<label for="nacionalidad_comentarista" class="col-md-4 control-label">Nacionalidad del Comentarista</label>
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
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    	

<script type="text/javascript">
	$(document).ready(function(){
	     $('#txt_valoracion').rating({
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
    	$("#form_servicio_add").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});
		$("#form-comentario").validationEngine('attach', {
			relative: true,
			promptPosition:"bottomLeft"
		});

	    $(document).on('change', '#txt_id_idioma', function(event) {
	    	event.preventDefault();
	    	var idioma = ( $(this).val() ).toLowerCase();
	    	var lugar  = ( $("#txt_lugar_pagina").val() ).toLowerCase();
	    	generar_url(idioma,lugar);	    	
	    });

	    $(document).on('change focusout', '#txt_lugar_pagina', function(event) {
	    	event.preventDefault();
	    	var lugar  = ( $(this).val() ).toLowerCase();
	    	var idioma = ( $("#txt_id_idioma").val() ).toLowerCase();
	    	generar_url( idioma,lugar );
	    });

		$(document).on('focusout', '#txt_url_servicio', function(event) {
			event.preventDefault();
			
			var urlBase   = $("#spn_url_base").text();
			var uriPagina = $(this).val();
			var fullUrl   = "";
			var tempUriPagina = "";
			for (var i = uriPagina.length - 1; i >= 0; i--) {
				if (uriPagina[i] === "-") {
					tempUriPagina = uriPagina.substr(0,i);
				}else{
					break;
				}
			}
			if ( tempUriPagina.length > 0 ) {
				uriPagina = tempUriPagina;
			}
			$(this).val(uriPagina);
			$("#txt_url_pagina_web").val(urlBase+uriPagina);
		});
	
	});
</script>
<style type="text/css">
	/*** Style para mostrar el buscador de Google Place en el Modal [Agregar Comentario] ***/
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<script>
    var fileExtension = "";
    $('#imagen_principal:file').change(function(){
        var file = $(this)[0].files[0];
        var fileName = file.name;
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        var fileSize = file.size;
        var fileType = file.type;
        var formData = new FormData($("#form_servicio_add")[0]);
        var message = ""; 
        if ( (/\.(jpg|png|gif)$/i).test(file.name) ) {
        	$.ajax({
	            url: '<?=base_url();?>assets/php/slider-upload.php',  
	            type: 'POST',
	            data: formData,
	            cache: false,
	            contentType: false,
	            processData: false,
	            beforeSend: function(){
	                $.blockUI({ message: '<h3>Loading...</h3><h4>Wait a moment please..!</h4>' }); 
	            },
	            success: function(data){
	            	var response = $.parseJSON(data);
	                $.unblockUI();
	                if ( response.response === 'OK' ) {
		                $("#txt_imagen_principal").empty().val(response.imagen);
		                var tooltip = '<a href="" data-toggle="tooltip" title="<img class=\'img-thumbnail\' src=\''+response['url']+'\'>"><span class="fa fa-picture-o pull-left fa-2x"></span></a>';
		                $('.tooltip-image').empty().html(tooltip);
		                $('a[data-toggle="tooltip"]').tooltip({
						    animated: 'fade',
						    placement: 'right',
						    html: true
						});				                	
	                }else{
	                	$("#txt_imagen_principal").empty().val('');
        	        	swal("Oops..!","Problemas internos en el servidor..!","warning");	
	                }
	            },
	            error: function(){
	            	$.unblockUI();
	                swal("Error..!","No se ha podido conectar con el servidor..!","error");
	            }
	        });
        }else{
        	swal("Oops..!","Selecciona una imágen por favor..!","warning");
        }
    });

    $('#miniatura:file').change(function(){
        var file = $(this)[0].files[0];
        var fileName = file.name;
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        var fileSize = file.size;
        var fileType = file.type;
        var formData = new FormData($("#form_servicio_add")[0]);
        var message = ""; 
        if ( (/\.(jpg|png|gif)$/i).test(file.name) ) {
        	$.ajax({
	            url: '<?=base_url();?>assets/php/thumbnail-upload.php',  
	            type: 'POST',
	            data: formData,
	            cache: false,
	            contentType: false,
	            processData: false,
	            beforeSend: function(){
	                $.blockUI({ message: '<h3>Loading...</h3><h4>Wait a moment please..!</h4>' }); 
	            },
	            success: function(data){
	            	var response = $.parseJSON(data);
	                $.unblockUI();
	                if ( response.response === 'OK' ) {
		                $("#txt_miniatura").empty().val(response.imagen);
		                var tooltip = '<a href="" data-toggle="tooltip" title="<img class=\'img-thumbnail\' src=\''+response['url']+'\'>"><span class="fa fa-picture-o pull-left fa-2x"></span></a>';
		                $('.tooltip-image-thumbnail').empty().html(tooltip);
		                $('a[data-toggle="tooltip"]').tooltip({
						    animated: 'fade',
						    placement: 'right',
						    html: true
						});					                	
	                }else{
	                	$("#txt_miniatura").empty().val('');
        	        	swal("Oops..!","Problemas internos en el servidor..!","warning");	
	                }
	            },
	            error: function(){
	            	$.unblockUI();
	                swal("Error..!","No se ha podido conectar con el servidor..!","error");
	            }
	        });
        }else{
        	swal("Oops..!","Selecciona una imágen por favor..!","warning");
        }
    });

    /*********************** BEGIN SCRIPT GESTIONAR REVIEWS *********************/

    var reviews = {items: [] };
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
    	var rating_c 		= $('#txt_valoracion2').val();
    	var nombre_c 		= $('#txt_nombre_comentarista').val();
    	var nacionalidad_c 	= $('#txt_nacionalidad_comentarista').val();
    	var comentario_c 	= $('#txt_comentario').val();

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
	    	$('#txt_reviews').empty().val(JSON.stringify(reviews));

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

	function initMap() {
		autocomplete = new google.maps.places.Autocomplete(
	    /** @type {!HTMLInputElement} */(document.getElementById('txt_nacionalidad_comentarista')),
	    {types: ['geocode']});
	    autocompletelugar = new google.maps.places.Autocomplete(
	    /** @type {!HTMLInputElement} */(document.getElementById('txt_lugar_pagina')),
	    {types: ['geocode']});
	}

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
    	$('#txt_reviews').empty().val(JSON.stringify(reviews));
    	console.log(reviews.items);
    	$('.contador-reviews').empty().append(reviews.items.length);
    	$('#modal-reviews-list').modal('show');
	});
    /*********************** END  SCRIPT GESTIONAR  REVIEWS *********************/
    jQuery(document).ready(function($) {  
		var tooltip = '<a href="" data-toggle="tooltip" title="<img class=\'img-thumbnail\' src=\'http://localhost/cms/assets/galeria/slider/<?=$servicio['imagen_principal'];?>\'>"><span class="fa fa-picture-o pull-left fa-2x"></span></a>';
        $('.tooltip-image').empty().html(tooltip);
        $('a[data-toggle="tooltip"]').tooltip({
		    animated: 'fade',
		    placement: 'right',
		    html: true
		}); 
		var tooltip_miniatura = '<a href="" data-toggle="tooltip" title="<img class=\'img-thumbnail\' src=\'http://localhost/cms/assets/galeria/thumbnail/<?=$servicio['miniatura'];?>\'>"><span class="fa fa-picture-o pull-left fa-2x"></span></a>';
        $('.tooltip-image-thumbnail').empty().html(tooltip_miniatura);
        $('a[data-toggle="tooltip"]').tooltip({
		    animated: 'fade',
		    placement: 'right',
		    html: true
		});	
<?php
$temp_c=json_decode($servicio['reviews']) ;
?>
        var string_comentarios = <?=json_encode($temp_c);?>;
        console.log(string_comentarios);
        if ( string_comentarios.length === 0 ) {
        	string_comentarios = '{"items":[]}';
        }
        // var json_comentarios = JSON.parse( string_comentarios );
		var json_comentarios = string_comentarios;
        
        $('.contador-reviews').empty().append(json_comentarios.items.length);
        var db_reviews_html  = '';

    	if ( json_comentarios.items.length === 0 ) {
    		$('.modal-list-reviews').empty().append('No hay comentarios..!');
    	}else{
    		$.each( json_comentarios.items, function(index, val) {
    			reviews.items.push(val);
    		});
    	}
    	$("#txt_reviews").empty().val(JSON.stringify(reviews));
    });
</script>
<script type="text/javascript">
	
	function generar_url(idioma,lugar){
		if (lugar.length != 0 ) {
	    	//lugar       = lugar.replace(/ /gi,"-");
	    	array_lugar = (lugar.trim()).split(",");
			lugar = (array_lugar[0]).replace(/[ ]/gi,"-");
	    	
	    	var especiales = new Array('á','é','í','ó','ú','ñ',' ','´',':',',',';','.');
			var normales   = new Array('a','e','i','o','u','n','','','','','','');
			i=0;
			while (i<especiales.length) {
				lugar = lugar.split(especiales[i]).join(normales[i]);
				i++;
			}
			lugar = lugar + '/';
		}else{
			lugar = '';
		}
    	console.log(lugar);
    	$.ajax({
    		url: '<?=base_url();?>admin/idioma/codigo',
    		type: 'POST',
    		dataType: 'json',
    		data: {id: idioma},
    	}).done(function(data) {
    		if ( data.response === 'OK' ) {
    			//var url_base = 'http://incalake.com/'+ (data.data.codigo).toLowerCase()+'/'+lugar;
    			var url_base = 'https://web.incalake.com/'+ (data.data.codigo).toLowerCase()+'/'+lugar;
    			//$('#txt_url_servicio').val('http://incalake.com/'+ (data.data.codigo).toLowerCase()+'/'+lugar );
    			$("#spn_url_base").empty().text(url_base);
    			var base_url = $("#spn_url_base").text();
		    	var uri_servicio = $("#txt_url_servicio").val();
    			validar_url(base_url+uri_servicio);
    		}	
    		/*console.log(data.data.codigo.toLowerCase() );*/
    	}).fail(function(e) {
    		console.log(e.responseText);
    	});
	}

	function validar_url(url){
		var regex = new RegExp("^(http|https):\/\/([w]{3}\\.|[a-z0-9]+)\\.[a-z]{3}\/[a-z]{2}\/[a-z0-9-_]+\/[a-z0-9-_]+");
		if( regex.test(url) ){
			var total_caracteres = url.length;
			var temp_url = url.substring(total_caracteres-5, total_caracteres);
			if ( temp_url != '.html' ) {
				url = url + '';
			}
			verificar_duplicidad(url);
			$('#txt_url_pagina_web').empty().val(url);
    		return true;
    	}else{
	    	return false;
	    }
	}
	function verificar_duplicidad(url){
		$.ajax({
			url: '<?=base_url();?>admin/servicio/verificar_url',
			type: 'POST',
			dataType: 'json',
			data: {url: url},
		}).done(function(data) {
			console.log(data);
			if ( data.response === 'ERROR' ) {
				$("#txt_url_servicio").val('').focus();
				$('#div-error-url').css('display','block');
				$("#span-error-url").empty().text( url + "; YA ESTÁ EN USO." );
			}else{
				$('#div-error-url').css('display','none');
			}
		}).fail(function(e) {
			console.log(e.responseText);
			swal("ERROR","Hay problemas con la conexión al servidor, Por favor asegurese que la url no tenga duplicidad.","error");
		});	
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places&callback=initMap" async defer></script>


