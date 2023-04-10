console.log("Loading Objects..!");

function Disponibilidad() {
	this.data = Array();
	this.get_datos_disponibilidad = get_datos_disponibilidad;
	this.set_datos_disponibilidad = set_datos_disponibilidad;
	this.dias                     = dias;
	this.fecha_disponible         = fecha_disponible;
	this.get_eliminar_disponibilidad 	= get_eliminar_disponibilidad;
	this.get_cantidad_disponibilidades 	= get_cantidad_disponibilidades;
}
function get_datos_disponibilidad(){
	return this.data;
}
function set_datos_disponibilidad(data){
	this.data.length = 0;
	this.data.push(data);
	return true;
}
function dias(){
	if ( this.fecha_inicio != 0 && this.fecha_fin != 0 ) {
		return ( moment(this.fecha_fin).diff( moment(this.fecha_inicio), 'days') ) + 1;
	}else{	return 0;	}
}
function fecha_disponible(f_inicio, f_fin){
	if ( moment(f_inicio).isBetween( moment(this.data[0]['start']).subtract(1,'days').format("YYYY-MM-DD"), moment(this.data[0]['end']).add(1,'days').format("YYYY-MM-DD") ) 
		 && moment(f_fin).isBetween( moment(this.data[0]['start']).subtract(1,'days').format("YYYY-MM-DD"), moment(this.data[0]['end']).add(1,'days').format("YYYY-MM-DD") )	
		) {
		return true;
	}else{	return false;	}
}
function get_eliminar_disponibilidad(){
	this.data.length = 0;
	return true;		
}
function get_cantidad_disponibilidades(){
	return this.data.length;
}
/************************************************************************************************/
function Bloqueo(){
	this.data = Array();
	this.set_datos_bloqueo 		= set_datos_bloqueo;
	this.get_datos_bloqueo 		= get_datos_bloqueo;
	this.get_fecha_es_bloqueo  	= get_fecha_es_bloqueo;
	this.get_cantidad_bloqueos  = get_cantidad_bloqueos;
	this.get_eliminar_bloqueo    = get_eliminar_bloqueo;
	this.get_vaciar_bloqueo     = get_vaciar_bloqueo;
}
function set_datos_bloqueo(data){
	this.data.push(data);
	return true;
}
function get_datos_bloqueo(){
	return this.data;
}
function get_fecha_es_bloqueo(f_inicio, f_fin){
	if ( this.data.length != 0 ) {
		for( var index in this.data ){
			if ( moment(f_inicio).isBetween(this.data[index]['start'], this.data[index]['end'] , null, '[]') || moment(f_fin).isBetween(this.data[index]['start'], this.data[index]['end'], null, '[]' ) ) {
				return true;
			}
		}
	}
	return false;
}

function get_cantidad_bloqueos(){
	return this.data.length;
}
function get_eliminar_bloqueo(f_inicio, f_fin){
	var id_objeto_bloqueo = null;
	var objeto_bloqueo_encontrado = false;
	for( var index in this.data ){
		if ( moment( f_inicio ).isSame( this.data[index]['start'] ) && moment(f_fin).isSame( this.data[index]['end'] ) ) {
			id_objeto_bloqueo = index;
			objeto_bloqueo_encontrado = true;
		}
	}
	if ( objeto_bloqueo_encontrado ) {
		(this.data).splice(id_objeto_bloqueo,1);
	}
	return true;
}

function get_vaciar_bloqueo(){
	this.data.length = 0;
	return true;	
}
/*************************************************************************************************/
function Oferta(){
	this.data = Array();
	this.set_datos_oferta 		= set_datos_oferta;
	this.get_datos_oferta 		= get_datos_oferta;
	this.get_fecha_es_oferta  	= get_fecha_es_oferta;
	this.get_cantidad_ofertas   = get_cantidad_ofertas;
	this.get_eliminar_oferta    = get_eliminar_oferta;
	this.get_vaciar_oferta      = get_vaciar_oferta;
}
function set_datos_oferta(data){
	this.data.push(data);
	return true;
}
function get_datos_oferta(){
	return this.data;
}  
function get_cantidad_ofertas(){
	return this.data.length;
}
function get_fecha_es_oferta(f_inicio, f_fin){
	if ( this.data.length != 0 ) {
		for( var index in this.data ){
			if ( moment(f_inicio).isBetween(this.data[index]['start'], this.data[index]['end'] , null, '[]') || moment(f_fin).isBetween(this.data[index]['start'], this.data[index]['end'], null, '[]' ) ) {
				return true;
			}
		}
	}
	return false;
}

function get_eliminar_oferta(f_inicio, f_fin){
	var id_objeto_oferta = null;
	var objeto_oferta_encontrado = false;
	for( var index in this.data ){
		if ( moment( f_inicio ).isSame( this.data[index]['start'] ) && moment(f_fin).isSame( this.data[index]['end'] ) ) {
			id_objeto_oferta = index;
			objeto_oferta_encontrado = true;
		}
	}
	if ( objeto_oferta_encontrado ) {
		(this.data).splice(id_objeto_oferta,1);
	}
	return true;
}

function get_vaciar_oferta(){
	this.data.length = 0;
	return true;	
}