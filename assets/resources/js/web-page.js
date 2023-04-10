$(document).ready(function() {
	/*MENU BREADCRUMB*/

	var pathArray = window.location.pathname.split( '/' );
	var host= window.location.host.split( '.' );
	var host_con= window.location.hostname;
	
$('.home').html('<a href="//'+host_con+'">'+host_con+'</a>');
	var ruta_url="";
	var lista="";
	$('content div').first().prepend('<ol class="row breadcrumb menu_ubicacion"></ol>');
function ShowResults(value, index, ar) {

	if (index>1&&index<=4) {
		lista+='/'+value;
		ruta_url+='/'+value;
		$('.menu_ubicacion').append('<li><a href="//'+lista+'">'+value+'</a></li>');
		
	}else if(index==0){
		lista+=host[0];		
		$('.menu_ubicacion').append('<li class="home-breadcrumb"><a href="//'+lista+'/cms/admin" >'+host[0]+'</a></li>');
		
	}else if(index==1){
		lista+='/'+value;
		ruta_url+='/'+value;
	}
}

pathArray.forEach(ShowResults);
});