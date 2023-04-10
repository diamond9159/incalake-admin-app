$(document).ready(function() {
	/*MENU BREADCRUMB*/

	var pathArray = window.location.pathname.split( '/' );
	var host= window.location.host.split( '.' );
	var host_con= window.location.hostname;
	
$('.home').html('<a href="//'+host_con+'">'+host_con+'</a>');

});