// cargar 'preciosmanager' cuando se cargue el DOM 
$().ready(preciosmanager);

// etapas_edad,nacionalidades son arrays que contiene etapas el edad y nacionalidaes
// modificar array etapas_edad si setear visible para evitar duplicados en lo posterior
for(k in etapas_edad)etapas_edad[k].visible=true;
// modificar array nacionalidades si setear visible para evitar duplicados en lo posterior
for(k in nacionalidades)nacionalidades[k].visible=true;

// nuevo array global para control de duplicado en la seleccion 
nacionalides_array = [];
//var idiomas = {en:'Ingles',fr:'Frances',de:'Aleman',pt:'Portugues',it:'Italiano',ru:'Ruso',jp:'Japones',zh:'Chino',ko:'Coreano'}
// funcion que se usa en inputs de  'htmlCantPrec' para evitar en ingreso de valores menores a 0
 function avoidCero(elem){
 	if(parseInt(elem.value)<0)elem.value=1;
 }
 // funcion para retornar rows de tabla para cada precio
 function htmlCantPrec(edad,nacionalidad,desde,hasta,precio){
	 /*
	 edad: edad se refiere si es niè´–o,adulto,etc
	 nacionalidad: nacionalidad peruano, extranjero, etc
	 desde: edad desde donde se aplica el precio
	 hasta: edad hasta donde se aplica el precio
	 precio: precio para el rango de edad
	 */
 	  return '<tr>'+
 	  			'<td><input onchange="avoidCero(this)" name="precio['+edad+'][nacionalidades]['+nacionalidad+'][precios][desde][]" value="'+(desde?desde:'')+'" type="number" class="form-control"  placeholder="desde" /></td>'+
 	  			'<td> - </td>'+
 	  			'<td><input onchange="avoidCero(this)" name="precio['+edad+'][nacionalidades]['+nacionalidad+'][precios][hasta][]" value="'+(hasta?hasta:'')+'" type="number" placeholder="hasta" class="hasta_input form-control" /></td>'+
 	  			'<td> : </td>'+
 	  			'<td><input onchange="avoidCero(this)" step="any" name="precio['+edad+'][nacionalidades]['+nacionalidad+'][precios][precio][]" value="'+(precio?precio:'')+'" type="number" class="form-control" placeholder="precio" /></td>'+
 	  			'<td><span class="btn btn-danger fa fa-close" onclick="$(this).parents(\'tr\').remove();"></span></td>'+
 	  		   '</tr>';
 }

// funcion llamada despues que el DOM es cargado desde document.ready de jQuery
function preciosmanager(){
	//contenedor principal de todo el panel de precios
	var preciosManagerContain = $('#preciosManager');
	// contenedor de tabs
	var preciosManagerTabContain = $('#preciosManager').find('.tab-content');
	// boton (+) en la barra de navegacion de tabs, se usarè´° para crear nuevo tabs con edades
	var btnAddTab = preciosManagerContain.find('.addTabBtn');
	// idkey para se usara para enumerar los numeros de tabs y asi evitar conflictos
	var idkey=0;
	// llamar la funcion 'agregarTab' al hacer click en el de agregar tabs
    btnAddTab.click(agregarTab);

// funcion para generar select de edades
function retornaSelects(idkey,selected){//edades
	// idkey: numero de tab al que pertenece
	// selected: el <option> seleccionado por defecto

	// html select de edades
	var tabSelect = '<select class="etapas_edad_select"  onchange="cambiarEdad($(this),'+idkey+')"><option value="">- - - - - - - &darr;</option>';
    for(k in etapas_edad){
		// si la edad es visible (esto se usa para evitar duplicados)
    	if(etapas_edad[k].visible)
    	tabSelect += '<option '+(etapas_edad[k].id_etapa_edad==selected?'selected':'')+' data-num="'+k+'" value="'+etapas_edad[k].id_etapa_edad+'">'+etapas_edad[k].descripcion_etapa_edad+'</option>';

	}
	// cerrar tag select y retornar html completo
    tabSelect += '</select>';
    return tabSelect;
}

// inicio de funcion para generar nacionalidades
function retornaNacionalidades(idtab,selected){
	//console.log(nacionalides_array);
	// idtab: la identidad del tab padre y ubicar en el array
	// selected: option selecionado por defecto
	var nacSelect = '<select class="nacionalidades_select col-md-4 col-xs-12" '+(selected?'disabled':'')+' onchange="cambiarNac($(this))"><option value="">- - - - - - -</option>';

	// buscar el el array nacionalidades correspodientes al idtab que contiene las edades
    for(k in nacionalides_array[idtab]){
		// si es visible (aun no ha sido seleccionado anteriormente) proceder agregar los options
    	if(nacionalides_array[idtab][k].visible){
			// concatenar options
    		nacSelect += '<option '+(nacionalides_array[idtab][k].id_nacionalidad==selected?'selected':'')+' data-num="'+k+'" value="'+nacionalides_array[idtab][k].id_nacionalidad+'">'+nacionalides_array[idtab][k].descripcion_nacionalidad+'</option>';
    	}
	}
	// finalizar tag select
    nacSelect += '</select>';

    return nacSelect;
}

  // 'agregarTab' funcion para aè´–adir edades 
	  function agregarTab(id_edad){
	   // id_edad: para detectar en el array la edad seleccionada
	   // buscar el select de edades dentro del tab
	   var buscar_select = $('#preciosManager .nav-tabs select');
	   // obtener valor del select si no hay se le asigna el valor de 1
	   var last_select = buscar_select.length?buscar_select.last().val():1;
	   // si el ultimo select tiene valor agregar de lo contrario no hacer nada

	    if(last_select){
	    	// html del tab a agregar 
			$('<li class="'+(idkey?'':'active')+'"><div class="btn_tab" onmouseover="$(this).tab(\'show\')" href="#ntab'+idkey+'"><span class="tabName">'+retornaSelects(idkey,id_edad)+'</span> <span title="Eliminar etapa edad" class="fa fa-close" style="color:#EBB8B8;cursor:pointer" onclick="elimTab(event,$(this))"></span></div></li>').insertBefore($('.addTabBtn').parent());
			
			// html del contenido del tab
	    	 var htmlConf = '<div id="ntab'+idkey+'" class="tab-pane fade '+(idkey?'':'in active')+'"><div class="tabOptions">'+
					  '<button disabled type="button" class="btn btn-primary addnac"><span class="fa fa-plus-circle"></span> Agregar Nacionalidad</button>'+
					 '</div><div class="nacionalidades"></div></div>';
				
			// agregar html del tab 
			preciosManagerTabContain.append(htmlConf);
			
			// disparar el evento 'change' al ultimo select de edades agregado
	    	if(id_edad)$('.etapas_edad_select').last().trigger('change');
			
			// funcion de eliminar tabs
	    	elimTab = function (event,elemento){
				// event: el evento realizado, elemento: elemento donde se dispara el evento (this)
				// preguntar al usuario si esta seguro de eliminar
	    		if(confirm('Estas seguro de eliminar esta pestaè´–a?')){
					// buscar el padre del elemento 
	    			var el  = elemento.parent();
		    		// obtener el numero del option seleccionado .. 'option_selected' obtiene la clave del array 'etapas_edad'
					var option_selected = el.find('select option:selected').data('num');
					
					// si se ha seleccionado opcion de edad valida entonces proceder
					if(option_selected!=undefined)etapas_edad[option_selected].visible=true;
					
		    		// remover contenedor de tab relacionado
					$(el.attr('href')).remove();
					// remover tab
		    		el.remove();
		    		
				}
				// prevenir propagacion del evento
	    		event.stopPropagation();	
			}
			
			// se agrega array para posterior control del duplicado en nacionalidades
	    	nacionalides_array[idkey]=jQuery.extend(true, {}, nacionalidades);
	    	for(k in nacionalides_array[idkey])nacionalides_array[idkey][k].visible=true;
	        

			return idkey++;
	    // alertar si ultimo select de edad no se ha agregado
	    } else alert('No puede agregar nuevo segmento porque el ultimo que agregaste no tiene valor.');
	}
/*fin funcion agregar tabs*/

// funcion para agregar y eliminar nacionalidades
   eliminar_nac=function(element){
	// preguntar al usuario si esta seguro de eliminar nacionalidad  
   	if(confirm('Esta seguro de eliminar?')){
		  // buscar el padre del elemento donde se hizo el click
		  var parent = element.parents('.contenedorNacs');
		  // obtener el numero de tab (edad)
		  var id_tab = element.parents('.tab-pane').attr('id').replace(/[^0-9]/g, '');
		  // obtener numero de nacionalidad
   		  var select_value = parent.find('.headerNac option:selected').data('num');
		  // si el el numero de nacionalidad no esta vacio entonces desbloquearlo en el array para que pueda ser volver usado
		  if(select_value>=0)nacionalides_array[id_tab][select_value].visible = true;
		  // eliminar por completo DIV nacionalidad 
	      parent.remove();
   	    }
   }

// funccion para agregar html nacionalidades element = id del contenedor,tabname= el nombre del tab,nac= nacionalidad
 agregarNac=function (element_id,edad_id,id_nac,rango_edad,precios){
    // buscar nacionalidades dentro 
    element = $('#ntab'+element_id).find('.nacionalidades');
    // buscar los selects de nacionalidades
	var buscar_select = element.find('select');
	// buscar el ultimo select y extraer su valor y no hay selects entonces asignar valor por defecto 1
    var last_select = buscar_select.length?buscar_select.last().val():1;
	 
	// si ultimo select de nacionalidades tiene valor 
 	if(last_select){
	  // llamar a funcion retornaNacionalidades para que retorne las lista 
	   var nac = retornaNacionalidades(element_id,id_nac);
	  // html donde se ingresan rango de precios
 	  var htmlform = '<div class="contenedorNacs col-md-6 col-xs-12 table-responsive" data-tabname="'+edad_id+'"><div class="headerNac col-xs-12"><div class="btn-group col-md-2 col-xs-2">'+
 	  				  '<button type="button" class="btn btn-danger btn-md" onclick="eliminar_nac($(this))" title="Eliminar"><b class="fa fa-close"></b></button>'+
					'</div> <span class="tituloNac col-md-10 col-xs-10">'+nac+' <label class="col-md-5 text-center col-xs-6">Edad: <input onchange="avoidCero(this)" type="number" value="'+(rango_edad?rango_edad[0]:'')+'" /></label> '+
					  '<label class="col-md-3 col-xs-6"> - <input onchange="avoidCero(this)" value="'+(rango_edad?rango_edad[1]:'')+'" type="number" /></label></span></div>'+
					'<table class="inputsPrecios table"><tr><th>Desde</th><th></th><th>Hasta</th><th></th><th>$ precio unitario</th><th>#</th></tr></table>'+
					'<button disabled style="float:right" type="button" class="btn btn-primary btn-md addcp" data-idedad="'+edad_id+'" data-idnac="'+id_nac+'"><span class="fa fa-plus-circle"></span> Agregar Precio</button>'+
					'</div>';
	  // agregar html generado
	  element.append(htmlform);
	  // si hay id_nac disparar evento 'change'
      if(id_nac)element.find('.nacionalidades_select').last().trigger('change');

	  // si hay precios
 	  if(precios){
	  // variable vacia
	  var htmlprecios = '';
	  // bucle para devolver  filas de precios del rango
		for(i in precios.desde)htmlprecios += htmlCantPrec(edad_id,id_nac,precios.desde[i],precios.hasta[i],precios.precio[i]);
		// agregar a la ultima tabla los trs generados
 	  	var last_element_nac = element.find('.inputsPrecios').last();
 	  	last_element_nac.append(htmlprecios);
	  }
	   
	  // agregar al ultimo boton de 'Generar Precio' el evento click para agregar precio
 	  element.find('.addcp').last().click(function(){
		// ubicar la tabla donde esta relacionado el boton Agregar Precio
		var table_parent = $(this).siblings('.inputsPrecios');
	    // buscar el ultimo input del HASTA
		var last_cantidad_value = table_parent.find('.hasta_input').last().val();
		// volver en un entero el ultimo valor del HASTA si no existe darle el valor de 0
 	  	last_cantidad_value = last_cantidad_value?parseInt(last_cantidad_value):0;
 	  	// agregar row de precios con valores
 	  	table_parent.append(htmlCantPrec($(this).data('idedad'),$(this).data('idnac'),++last_cantidad_value));
	   });
	   
    // mostrar alerta si la ultima ultima nacionalidad no ha sido seleccionado
 	} else alert('La ultima nacionalidad creada no tiene valor.');
 }
////////////////////////////////// LECTURA DEL JSON CUANDO SE EDITA /////////////////////////////////////////
 	// si preciosManagerContain tiene data json se leera datos para editar
	var json = preciosManagerContain.data('json');
	// setear default_json en false se usara para una condicional para usar un json por defecto si no existe un json valido o vacio
	var default_json = false;
	// conprobar JSON es valido
    if(typeof json!== "object"){
		// si no es un json valido entonces asiganar uno por defecto con Adulto Extranjero 
		json = {"1":{"nacionalidades":{"1":[]}}};
		// default_json activar en true
    	default_json = true;
    }
    	// entrar en bucle JSON
		 $.each(json, function(id_edad,item) {
		    // agregar cantidad de tabs segun el JSON
		    var idTab = agregarTab(id_edad);
			// si tiene nacionalidades entonces seguir
		    if(item.nacionalidades){
				// blucle nacionalidades
		    	for(var j in item.nacionalidades){
					// si es un json por defecto 
					if(default_json)agregarNac(idTab,id_edad,j,false,false);
					// si es un JSON extraido
		    		else agregarNac(idTab,id_edad,j,[item.nacionalidades[j]['edad_min'],item.nacionalidades[j]['edad_max']],item.nacionalidades[j].precios);
		    	}
		    }
		});
   
// cuando se envia el formulario donde esta incrustado 
  preciosManagerContain.parents('form').submit(function(){
	// buscar inputs vacios para eliminarlo y evitar enivio de informacion vacio.
  	$('#preciosManager input').each(function(key){
  		if(!$(this).val().length)$(this).parents('tr').remove();
  	});
   });
}

// 'cambiarEdad' funcion que se ejecuta cuando se cambia la edad
function cambiarEdad(select,idtabcontent){
   // buscar el contenedor donde  se cambia la edad
   var contenedor = $('#ntab'+idtabcontent);
   // boton de agregar nacionalidad
   var buttonADD = contenedor.find('.addnac');
   // select donde se cambia la nacionalidad
   var selectNAC = contenedor.find('.headerNac select');
   
   // si lo seleccionado tiene el valor
   if(select.val()){
	  // cambiar el atributo javascript para actualizar los parametros de la funcion 'agregarNac';
   	  buttonADD.attr('onclick','agregarNac('+idtabcontent+',\''+select.val()+'\')');
	  // buscar el rango de edad previamente seteado cuando se crea los options
   	  var option_rango = select.find('option:selected');
	  // ubiedad array A usar para posterior control
   	  contenedor.data('ubiedad',option_rango.data('num'));
	  // ubicar en el arra y desactivarlo para evitar repeticiones
   	  etapas_edad[option_rango.data('num')].visible = false;
	  // activar el boton de agregar precio	
	  buttonADD[0].disabled=0;
	  // activar select nacionalidades
   	  selectNAC.removeAttr('disabled');
   	  // desactivar select edades
	  select.attr({disabled:'disabled'});
	  // no mostrar como select el tab de edadess
   	  select.css({background:'transparent',border:'none','font-weight':'bold'});
   }
   else {
	// desactivar boton de agregar precio
	buttonADD[0].disabled=1;
	// desactivar select de nacionalides
    selectNAC.attr('disabled','disabled');

   }
}
/*fin de la funcion para cambiar nombre del tab*/

// funcion para cambiar nombre de nacionalidades
function cambiarNac(elemento){
	// buscar contenedor padre de los precios     
	var container = elemento.parents('.contenedorNacs');
	// buscar el boton de Agregar Precio
	var btn_add_precios = container.find('.addcp');
	// buscar el padre (edad)
	var parent_tab = elemento.parents('.tab-pane');

	// si se selecciono correctamente
	if(elemento.val()){
		// buscar id nacionalidad a traves del data del boton agregar precio
		btn_add_precios.data('idnac',elemento.val());
		// activar el boton agregar precio
		btn_add_precios.removeAttr('disabled');
		// desactivar el select de nacionalidades
		elemento.attr('disabled','disabled');

	  // actualizar id de nacionalidad 
	  container.data('nacname',elemento.val());
	  
	  // inputs del rango de edad 
	  var botones_rango_edad = container.find('.headerNac input');
	  // obtener id de edad
	  var id_edad = parent_tab.data('ubiedad');
	  // obtener rango de edad segun el id de edad seleccionado
	  var rangos_temp = etapas_edad[id_edad];
	  // si no tiene valor la edad minima setear lo que viene por defecto desde el array (se evita que se sobreescriba cuando se edita) 
	  if(!botones_rango_edad.eq(0).val())botones_rango_edad.eq(0).val(rangos_temp['edad_min']);
	  // actualizar en atributo name de edad minima para que se adecue al array que se enviara con el formulario
	  botones_rango_edad.eq(0).attr('name',"precio["+container.data('tabname')+"][nacionalidades]["+elemento.val()+"][edad_min]");
	  // si no tiene valor la edad maxima setear lo que vieve por defecto desde el array
	  if(!botones_rango_edad.eq(1).val())botones_rango_edad.eq(1).val(rangos_temp['edad_max']);
	  // actualizar en atributo name de edad maxima para que se adecue al array que se enviara con el formulario
   	  botones_rango_edad.eq(1).attr('name',"precio["+container.data('tabname')+"][nacionalidades]["+elemento.val()+"][edad_max]");
	}
	// de lo contrario desactivar boton de agregar precio
	else btn_add_precios[0].disabled=1;
	
	// obtener el id de la edad
	var id_tab = parent_tab.attr('id').replace(/[^0-9]/g, '');
	// desactivar para evitar duplicados la nacionalidad dentro de la edad seleccionada
	nacionalides_array[id_tab][elemento.find('option:selected').data('num')]['visible'] = false;

}
/*fin de la funcion para cambiar nombre de nacionalidades*/