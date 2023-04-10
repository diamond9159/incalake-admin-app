var objeto_disponibilidad = { disponibilidad: [] };
var objeto_bloqueo		  = { bloqueo: 		[] };
var objeto_oferta	 	  = { oferta: 	  [] };
var cantidad_dias_inicio_disponibilidad = '';
var cantidad_dias_fin_disponibilidad = '';
$(document).ready(function() {
	$("#formAddDisponibilidad").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});

	var eventos = { items: [] };
	$('#calendario_incalake').fullCalendar({
		lang: 'es',
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: true,
		droppable: true,
		drop: function() {
			if ($('#drop-remove').is(':checked')) {
				$(this).remove();
			}
		}, 
	  	dayClick: function() {
	    	//alert('a day has been clicked!');
	  	},
	  	navLinks: true,
		selectable: true,
		selectHelper: true,
		allDaySlot: false,
		rendering: 'inverse-background',
	  	select: function(fstart, fend) {
			//alert( start.format() );
			var start = moment(fstart,"DD-MM-YYYY").format("YYYY-MM-DD") + " 00:00:00";
			var string_end   = moment(fend,"DD-MM-YYYY").format("YYYY-MM-DD");
			var array_end    = string_end.split("-");
			var end          = moment( array_end[0]+"-"+array_end[1]+"-"+( parseInt(array_end[2]) -1 ) ,"YYYY-MM-DD").format("YYYY-MM-DD");
			if ( objeto_disponibilidad.disponibilidad.length != 0 ) {
				var response_validez_fecha_bloqueo  = comprobar_fecha_dentro_disponibilidad( objeto_disponibilidad, start, end );					
				if ( response_validez_fecha_bloqueo ) {
					var response_validez_duplicidad_con_bloqueo = detectar_duplicidad(objeto_bloqueo.bloqueo,start,end );
					if ( response_validez_duplicidad_con_bloqueo === false ) {
						var response_validez_duplicidad_con_oferta  = detectar_duplicidad(objeto_oferta.oferta,start,end);
						if ( response_validez_duplicidad_con_oferta === false ) {	
							$("#txt_fechas_modal").empty().val( ( fstart.format() ) + ";" + ( fend.format() ) );
							$("#modal_div_bloqueo").css("display", "none");
					        $("#modal_div_oferta").css("display", "none"); 
							$('#modalFecha').modal('show');
							console.log("Click..!");
						}else{
							//swal("ERROR","Esta fecha ya esta en oferta.","error");
						}
					}else{
						//swal("ERROR","Esta fecha ya esta bloqueada.","error");	
					}
				}else{
					swal("ERROR","Has seleccionado una fecha que está fuera de la fecha de disponibilidad.","error");
				}
			}else{
				swal("ERROR FECHA DISPONIBILIDAD","Antes de aplicar un bloqueo u oferta seleccione la fecha inicio de disponibilidad y fecha fin disponibilidad.","error");
			}
		},
		editable: true,
		eventLimit: true,
		eventClick: function(event) {
			switch(event.estado){
				case 'disponibilidad':
					swal( (event.estado).toUpperCase(),event.title,"success");
				break;
				case 'bloqueo':
					swal( (event.estado).toUpperCase(),"Desde el " + (event.start).format("DD-MM-YYYY") + " hasta el " + (event.end).format("DD-MM-YYYY") + ": " + event.description,"success");
				break;
				case 'oferta':
					swal( (event.estado).toUpperCase(),event.title,"success");
				break;
				default:
					swal("Information",event,"success");
				break;
			}			
			console.log(event);
			return false;
		},
		dayRender: function (date, cell) {
			if ( cantidad_dias_inicio_disponibilidad.length != 0 && cantidad_dias_fin_disponibilidad.length != 0 ) {
				console.log("RENDER CANTIDAD: " +(parseInt(cantidad_dias_inicio_disponibilidad)+1) + " RENDER CANTIDAD: " + (parseInt(cantidad_dias_fin_disponibilidad)+1) );				

		        var today = new Date();
		        var end = new Date();
		        
		        today.setDate(today.getDate() + (parseInt(cantidad_dias_inicio_disponibilidad)-1) );
		        end.setDate(today.getDate() + (parseInt(cantidad_dias_fin_disponibilidad)+1) );

		        /*
		        if (date.getDate() === today.getDate()) {
		            cell.css("background-color", "#7dafda");
		        }
		        */  
		        if(date >= today && date <= end) {
		            cell.css("background-color", "#dff0d8");
		        }
			}
		}
	});

	/********************************* DATEPICKER'S *********************************/
	$("#txt_fecha_inicio_disponibilidad").datepicker(
		{
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onSelect: function(selectedDate){
		        $("#txt_fecha_fin_disponibilidad").datepicker("option", "minDate", selectedDate);
		    }
		}
	);
	$("#txt_fecha_fin_disponibilidad").datepicker(
		{
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
		}
	);
	$("#txt_fecha_inicio_bloqueo").datepicker(
		{
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onSelect: function(selectedDate){
		        $("#txt_fecha_fin_bloqueo").datepicker("option", "minDate", selectedDate);
		    }
		}
	);
	$("#txt_fecha_fin_bloqueo").datepicker(
		{
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
		}
	);
	$("#txt_fecha_inicio_oferta").datepicker(
		{
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onSelect: function(selectedDate){
		        $("#txt_fecha_fin_oferta").datepicker("option", "minDate", selectedDate);
		    }
		}
	);
	$("#txt_fecha_fin_oferta").datepicker(
		{
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: 0,
		}
	);
	/*************************************************************************/
	$(document).on('click', '.btn-guardar-modal', function(event) {
		event.preventDefault();
		var select_tipo 	= $("#slct_tipo_dia").val();
		var string_fechas 	= $("#txt_fechas_modal").val();
		var array_fechas 	= string_fechas.split(";"); 
		var fecha_end_tokens= array_fechas[1].split("-");
		var fecha_start     = moment(array_fechas[0], "YYYY-MM-DD").format("YYYY-MM-DD"); 
		var fecha_end       = moment(fecha_end_tokens[0]+"-"+fecha_end_tokens[1]+"-"+(parseInt(fecha_end_tokens[2]) - 1 ), "YYYY-MM-DD").format("YYYY-MM-DD");
		//console.log("START: " +fecha_start+ " END: " + fecha_end);
		if ( !$.isNumeric( select_tipo ) ) {
			swal("ERROR","Seleccione tipo... ","error");
		}else{
			switch( parseInt(select_tipo) ){
				case 0:
					var descripcion_bloqueo = $("#txtr_descripcion_bloqueo_modal").val();
					var data_bloqueo_modal = {
		    			start    	: fecha_start + " 00:00:00",
						end		    : fecha_end + " 23:59:59",
						estado      : 'bloqueo',
						title 		: 'Bloqueado: '+descripcion_bloqueo,
						description : descripcion_bloqueo,
						color		: '#d9534f',
						dias_activos: [],	
			    	};
			    	objeto_bloqueo.bloqueo.push(data_bloqueo_modal);
			    	console.log("Insertando BLoqueo..!");	
			    	update_bloqueo_and_oferta(objeto_bloqueo.bloqueo,objeto_oferta.oferta);
					console.log(JSON.stringify(objeto_bloqueo.objeto));
					$("#txt_data_json_bloqueo").val(JSON.stringify(objeto_bloqueo.objeto));
					$('#modalFecha').modal('hide');
					$("#txtr_descripcion_bloqueo_modal").val("");
					$('#slct_tipo_dia').prop('selectedIndex',0);
				break;
				case 1:
					// 0 = porcentaje, 1 = cantidad en USD 
					var descuento_oferta 		= $("#txt_descuento_oferta_modal").val();
					var tipo_descuento_oferta 	= $("#slct_tipo_descuento_oferta_modal").val();
					var string_descripcion_oferta_modal  = parseInt( tipo_descuento_oferta ) ? '$ USD' : '%';
					var color_oferta_modal 		= $("#txt_color_oferta_modal").val();
					console.log(array_fechas[1]);
					var data_oferta_modal = {
		    			start    	: fecha_start + " 00:00:00",
						end		    : fecha_end + " 23:59:59",
						estado      : 'oferta',
						title 		: 'Oferta: -'+descuento_oferta+string_descripcion_oferta_modal,
						description : descripcion_bloqueo,
						color		: color_oferta_modal,
						dias_activos: [],	
			    	};

			    	objeto_oferta.oferta.push(data_oferta_modal);
			    	update_bloqueo_and_oferta(objeto_bloqueo.bloqueo,objeto_oferta.oferta);
					$("#txt_data_json_oferta").val( JSON.stringify(objeto_oferta.oferta) );
					$('#modalFecha').modal('hide');
					$("#txt_descuento_oferta_modal").val("");
					$('#slct_tipo_dia').prop('selectedIndex',0);
				break;
				default:
					console.log("Default click..!");
				break;
			}
		}
	});

	$(document).on('click', '#btn-guardar-disponibilidad', function(event) {
		event.preventDefault();
		var array_dias = new Array();
		var fecha_inicio_disponibilidad = $("#txt_fecha_inicio_disponibilidad").val();
		var fecha_fin_disponibilidad    = $("#txt_fecha_fin_disponibilidad").val();
		
		$('input:checkbox[name=chckbx_dia]:checked').each(function(){
	       array_dias.push( $(this).val() );
	    });
	    if ( fecha_inicio_disponibilidad.length != 0 && fecha_fin_disponibilidad.length != 0 && array_dias.length > 0 ) {
	    	fecha_inicio_disponibilidad     = moment(fecha_inicio_disponibilidad,"DD-MM-YYYY").format("YYYY-MM-DD");
			fecha_fin_disponibilidad        = moment(fecha_fin_disponibilidad,"DD-MM-YYYY").format("YYYY-MM-DD");
        	//console.log("DISPONIBILIDAD START: " +fecha_inicio_disponibilidad+ " END: " + fecha_fin_disponibilidad);
	    	var data_disponibilidad = {
    			start		: fecha_inicio_disponibilidad+" 00:00:00",
				end		    : fecha_fin_disponibilidad+" 23:59:59",
				estado      : 'disponible',
				title 		: 'Disponible',
				description : '',
				color		: '#5bc0de',
				dias_activos: array_dias,	
	    	};
	    	objeto_disponibilidad.disponibilidad.length=0;;
	    	objeto_disponibilidad.disponibilidad.push(data_disponibilidad);
	    	$("#txt_data_json_disponibilidad").val(JSON.stringify(objeto_disponibilidad.disponibilidad));

	    	cantidad_dias_inicio_disponibilidad = moment(fecha_inicio_disponibilidad+" 23:59:59").diff( moment(),"days");
	    	cantidad_dias_fin_disponibilidad    = moment(fecha_fin_disponibilidad+" 23:59:59").diff(fecha_inicio_disponibilidad,"days");
	    	

	    	pintar_disponibilidad(fecha_inicio_disponibilidad,fecha_fin_disponibilidad);

	    	swal("DISPONIBILIDAD","La disponibilidad se ha actualizado correctamente.","success");
	    }else{
	    	swal("ERROR DISPONIBILIDAD","Asegúrese de haber completado todos los campos como la fecha inicio de la disponibilidad, la fecha fin de disponibilidad y seleccionar los días disponibles. ","error");
	    }
	});

	$(document).on('click', '#btn-guardar-bloqueo', function(event) {
		event.preventDefault();
		var fecha_inicio_bloqueo = $("#txt_fecha_inicio_bloqueo").val();
		var fecha_fin_bloqueo    = $("#txt_fecha_fin_bloqueo").val(); 
		fecha_inicio_bloqueo     = moment(fecha_inicio_bloqueo,"DD-MM-YYYY").format("YYYY-MM-DD");
		fecha_fin_bloqueo        = moment(fecha_fin_bloqueo,"DD-MM-YYYY").format("YYYY-MM-DD");
		
		if ( ($("#txt_fecha_inicio_bloqueo").val()).length != 0 && ($("#txt_fecha_fin_bloqueo").val()).lenght != 0 && objeto_disponibilidad.disponibilidad.length != 0 ) {
			var response_validez_fecha_bloqueo  = comprobar_fecha_dentro_disponibilidad(objeto_disponibilidad,fecha_inicio_bloqueo,fecha_fin_bloqueo);
			if ( response_validez_fecha_bloqueo ) {
				var data_bloqueo = {
	    			start    	: fecha_inicio_bloqueo+" 00:00:00",
					end		    : fecha_fin_bloqueo+" 23:59:59",
					estado      : 'bloqueo',
					title 		: 'Bloqueado: '+$("#txtr_motivo_bloqueo").val(),
					description : $("#txtr_motivo_bloqueo").val(),
					color		: '#d9534f',
					dias_activos: [],	
		    	};
		    	
		    	var response_validez_duplicidad = detectar_duplicidad(objeto_bloqueo.bloqueo,fecha_inicio_bloqueo,fecha_fin_bloqueo);
		    	console.log("RESPONSE: " + response_validez_duplicidad);
		    	if ( response_validez_duplicidad === false ) {
		    		objeto_bloqueo.bloqueo.push(data_bloqueo);
					$("#txt_data_json_bloqueo").val(JSON.stringify(objeto_bloqueo.bloqueo));
					update_bloqueo_and_oferta(objeto_bloqueo.bloqueo,objeto_oferta.oferta);
					swal("BLOQUEO","Bloqueo establecido correctamente.","success");
			    	$("#txt_fecha_inicio_bloqueo").val('');
					$("#txt_fecha_fin_bloqueo").val('');
					$("#txtr_motivo_bloqueo").val('')
		    	}else{
		    		swal(
						"ERROR BLOQUEO",
						"La fecha de bloqueo: "+moment(fecha_inicio_bloqueo).format("DD-MMM-YYYY")+ " hasta el "+moment(fecha_fin_bloqueo).format("DD-MMM-YYYY")+
						" está dentro de otra fecha que ya ha sido bloqueada.",
						"error"
					);	
		    	}
			}else{
				swal(
					"ERROR BLOQUEO",
					"La fecha de bloqueo: "+moment(fecha_inicio_bloqueo).format("DD-MMM-YYYY")+ " hasta el "+moment(fecha_fin_bloqueo).format("DD-MMM-YYYY")+
					" está fuera de la fecha de disponibilidad que es desde el "+ moment(objeto_disponibilidad.disponibilidad[0].start).format("DD-MMM-YYYY")+" hasta el "+moment(objeto_disponibilidad.disponibilidad[0].end).format("DD-MMM-YYYY")+".",
					"error"
				);
			} 
		}else{
			swal("ERROR BLOQUEO","El bloqueo no se ha podido establecer, Asegúrese de haber completado las fecha de disponibilidad y luego establecer una fecha de bloqueo.","error");
		}
	});
	
	$(document).on('click', '#btn-guardar-oferta', function(event) {
		event.preventDefault();
		var fecha_inicio_oferta = $("#txt_fecha_inicio_oferta").val();
		var fecha_fin_oferta    = $("#txt_fecha_fin_oferta").val(); 
		var cantidad_descuento  = $("#txt_descuento_oferta").val();
		var tipo_descuento_oferta= $("#slct_tipo_descuento_oferta").val();
		var color_oferta        = $("#txt_color_oferta").val();

		fecha_inicio_oferta = moment(fecha_inicio_oferta,'DD-MM-YYYY').format("YYYY-MM-DD");
		fecha_fin_oferta    = moment(fecha_fin_oferta,'DD-MM-YYYY').format("YYYY-MM-DD");

		//console.log("Fecha fin Oferta: "+ $("#txt_fecha_fin_oferta").val() );
		if (fecha_inicio_oferta.length != 0 && fecha_fin_oferta.length != 0 && cantidad_descuento.length != 0 ) {
			var response_validez_fecha_oferta_dentro_de_disponibilidad = comprobar_fecha_dentro_disponibilidad(objeto_disponibilidad,fecha_inicio_oferta,fecha_fin_oferta);
			var response_validez_duplicidad_con_bloqueo = detectar_duplicidad(objeto_bloqueo.bloqueo,fecha_inicio_oferta,fecha_fin_oferta);
			var response_validez_duplicidad_con_oferta  = detectar_duplicidad(objeto_oferta.oferta,fecha_inicio_oferta,fecha_fin_oferta);
			
			if ( response_validez_fecha_oferta_dentro_de_disponibilidad ) {
				if (response_validez_duplicidad_con_bloqueo === false ) {
					if ( response_validez_duplicidad_con_oferta === false ) {
							var string_tipo_descuento = parseInt(tipo_descuento_oferta) ? '$ USD' : '%';
							var data_oferta = {
				    			start		: fecha_inicio_oferta+" 00:00:00",
								end		    : fecha_fin_oferta+" 23:59:59",
								estado      : 'oferta',
								descuento	: cantidad_descuento,
								tipo_descuento: tipo_descuento_oferta,
								title       : 'Oferta: '+"-"+cantidad_descuento+string_tipo_descuento,
								description : cantidad_descuento+string_tipo_descuento,
								color		: color_oferta,
								dias_activos: [],	
					    	};
					    	objeto_oferta.oferta.push(data_oferta);
					    	update_bloqueo_and_oferta(objeto_bloqueo.bloqueo,objeto_oferta.oferta);
							$("#txt_data_json_oferta").val(JSON.stringify(objeto_oferta.oferta));
							swal("OFERTA","La oferta se ha establecido correctamente.","success");
							$("#txt_fecha_inicio_oferta").val('');
							$("#txt_fecha_fin_oferta").val('');
							$("#txt_descuento_oferta").val('');			
					}else{
						swal("ERROR OFERTA","La fecha de oferta que seleccionaste ya está en uso por otro tipo de oferta.","error");
					}
				}else{
					swal("ERROR OFERTA","La fecha de oferta que seleccionaste esta bloqueado y no se puede aplicar oferta.","error");
				}
			}else{
				swal("ERROR OFERTA","La fecha de la oferta que has eligido esta fuera del rango de fecha de disponibilidad","error");
			}
		}else{
			swal("ERROR OFERTA","La oferta no se ha podido establecer","error");
		}
	});

	function comprobar_fecha_dentro_disponibilidad( copy_objeto_disponibilidad,start_fecha, end_fecha ){
		//Comprueba si una fecha inicio y fecha fin esta dentro de la fecha disponibilidad
		if ( moment( start_fecha ).isBetween( moment(copy_objeto_disponibilidad.disponibilidad[0].start).subtract(1,'days').format("YYYY-MM-DD"), moment(copy_objeto_disponibilidad.disponibilidad[0].end).add(1,'days').format("YYYY-MM-DD") )
			 && moment( end_fecha ).isBetween( moment(copy_objeto_disponibilidad.disponibilidad[0].start).subtract(1,'days').format("YYYY-MM-DD"), moment(copy_objeto_disponibilidad.disponibilidad[0].end).add(1,'days').format("YYYY-MM-DD") )					
		 	) {
			return true;
		}else{
			return false;
		}
	}
	
	function detectar_duplicidad(object,start_fecha, end_fecha){
		var estado = false;
		$.each(object, function(index, val) {
			if ( moment(start_fecha).isBetween(val.start, val.end , null, '[]') || moment(end_fecha).isBetween(val.start, val.end, null, '[]' ) ) {
				estado = true;
			}
		});
		return estado;
	}

	$(document).on('click', '.btn-delete-objeto', function(event) {
		event.preventDefault();
		var string_fecha = $(this).data('id');
		var string_tipo  = $(this).data('tipo');
		var array_fechas = string_fecha.split(';');
		//bloqueo = 0,	oferta = 1
		var opcion_eliminar  = true;

		if ( opcion_eliminar ) {
			eliminar_evento(objeto_bloqueo.bloqueo,objeto_oferta.oferta,array_fechas[0],array_fechas[1],string_tipo );
		}
	});

	function eliminar_evento(object_bloqueo,object_oferta,fecha_start,fecha_end,tipo){
		switch( parseInt(tipo) ){
			//bloqueo = 0,	oferta = 1
			case 0:
				var id_objeto_bloqueo = null;
				var objeto_bloqueo_encontrado = false;
				$.each(object_bloqueo, function(index, val) {
					if ( moment(fecha_start).isSame(val.start) && moment(fecha_end).isSame( val.end ) ) {
						id_objeto_bloqueo = index;
						objeto_bloqueo_encontrado = true;
					}
				});
				if ( objeto_bloqueo_encontrado ) {
					(objeto_bloqueo.bloqueo).splice(id_objeto_bloqueo,1);
				}
				update_bloqueo_and_oferta(object_bloqueo,object_oferta);
			break;
			case 1:
				var id_objeto_oferta = null;
				var objeto_oferta_encontrado = false;
				$.each(object_oferta, function(index, val) {
					if ( moment(fecha_start).isSame(val.start) && moment(fecha_end).isSame( val.end ) ) {
						id_objeto_oferta = index;
						objeto_oferta_encontrado = true;
					}
				});
				if ( objeto_oferta_encontrado ) {
					(objeto_oferta.oferta).splice(id_objeto_oferta,1);
				}
				update_bloqueo_and_oferta(object_bloqueo,object_oferta);
			break;
			default:
				console.log("CASE DEFAULT");
			break;
		}
	}
	
});  
function update_bloqueo_and_oferta(object_bloqueo,object_oferta){
	var html_bloqueo = '', html_oferta = '';
	$('#calendario_incalake').fullCalendar('removeEvents');
	$.each(object_bloqueo, function(index, val) {
		html_bloqueo += '<li class="list-group-item">'+val.title+'<span class="pull-right fa fa-close text-danger btn btn-delete-objeto" data-id="'+val.start+';'+val.end+'" data-tipo="0" title="Eliminar Fecha Bloqueada"></span></li>';
		$('#calendario_incalake').fullCalendar('renderEvent', val, true);
		$('#calendario_incalake').fullCalendar('unselect');
	});
	$("#list-group-bloqueo").empty().append(html_bloqueo);

	$.each(object_oferta, function(index, val) {
		html_oferta += '<li class="list-group-item">'+val.title+'<span class="pull-right fa fa-close text-danger btn btn-delete-objeto" data-id="'+val.start+';'+val.end+'" data-tipo="1" title="Eliminar fecha en Oferta"></span></li>';
		$('#calendario_incalake').fullCalendar('renderEvent', val, true);
		$('#calendario_incalake').fullCalendar('unselect');
	});
	$("#list-group-oferta").empty().append(html_oferta);
}

function pintar_disponibilidad(fecha_start,fecha_end){
	$('#calendario_incalake').fullCalendar( 'next' );
	$('#calendario_incalake').fullCalendar( 'prev' );
}