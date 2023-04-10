$(document).ready(function() {
/*HEADER HEIGHT*/
$("header").css("height","50px");
/*TOOLTIP*/
$('[data-toggle="popover"]').popover()


/*MENU BREADCRUMB*/

var pathArray = window.location.pathname.split( '/' );
var host= pathArray[1].split( '.' );
var urlDomain = window.location.host;
var ruta_url="";
var lista="";
//console.log("URL ",urlDomain);
$('content div').first().prepend('<ol class="row breadcrumb menu_ubicacion"></ol>');

var arrayUrl = (window.location.pathname).split('/');
console.log(arrayUrl);

var stringUrl = 'http://'+urlDomain+'/';
var stringText = '';
$('.menu_ubicacion').append('<li class="home-breadcrumb"><a href="http://'+urlDomain+'/" >'+urlDomain+'</a></li>')
arrayUrl.forEach((value,index)=>{
	if ( value.trim().length != 0 && isNaN(value)  ) {
		stringUrl += value+'/';
		stringText += value
		//console.log("URLS",stringUrl);
		//console.log("TEXT",stringText);
		$('.menu_ubicacion').append('<li><a href="'+stringUrl+'">'+value+'</a></li>');
	}
});

pathArray.forEach(ShowResults);

function ShowResults(value, index, ar) {

	if (index>1&&index<=4) {
		lista+='/'+value;
		ruta_url+='/'+value;
		//$('.menu_ubicacion').append('<li><a href="'+lista+'">'+value+'</a></li>');		
	}else if(index==0){
		lista+=host[0];		
		//$('.menu_ubicacion').append('<li class="home-breadcrumb"><a href="'+lista+'admin" >'+host[0]+'</a></li>');
		//$('.menu_ubicacion').append('<li class="home-breadcrumb"><a href="'+lista+'admin" >'+urlDomain+'</a></li>');
	}else if(index==1){
		lista+='/'+value;
		ruta_url+='/'+value;
	}
}


if ( (urlRightNavBar.trim()).length = 0) {
	urlRightNavBar = 'http://admin.incalake.com/';
}
if ((window.innerWidth>=970) ) {
console.log(window.innerWidth);
// $('.navbar').removeClass('navbar-inverse').addClass('navbar-default');
$('content div').first().addClass("col-md-12 div-derecha div-derecha-aling");
$('content').append('<div class="div-izquierda hidden-xs " id="aside">'+
	'<div id="menu-izquierda" style="height:100%;">'+
	'</div>'+
	'</div>');
	$("#menu-izquierda").html('<div class="text-center" style="    height: 100%;">'+
		'<nav class="navbar-inverse navbar sidebar" role="navigation">'+
		    '<div class="container-fluid">'+
		    	'<!-- Brand and toggle get grouped for better mobile display -->'+
				'<div class="navbar-header"  >'+
					/*'<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">'+
						'<span class="sr-only">Toggle navigation</span>'+
						'<span class="icon-bar"></span>'+
						'<span class="icon-bar"></span>'+
						'<span class="icon-bar"></span>'+
					'</button>'+
					'<a class="navbar-brand  toggle-btn" href="#">Brand <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-envelope"></span></a>'+*/
					'<a href="'+urlRightNavBar+'admin/reservasrapidas/add"><div class=" btn-success" style="padding: 5px;"><span class="fa fa-rocket"></span><span class="visible-txt-menu">Reserva Rapida</span></div></a>'+
				'</div>'+
				'<!-- Collect the nav links, forms, and other content for toggling -->'+
				'<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">'+
					'<ul class="nav navbar-nav" style="width:100%;">'+
						'<li class=""><a href="'+urlRightNavBar+'admin" title="dashboard"><span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-home"></span><span class="visible-txt-menu">Dashboard</span></a></li>'+
						/*'<li ><a href="#">Profile<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>'+
						'<li ><a href="#">Messages<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-envelope"></span></a></li>'+*/
						'<li class="dropdown" >'+
							'<a title="Servicios" href="#" class="dropdown-toggle" data-toggle="dropdown"><span  class="pull-left hidden-xs showopacity glyphicon glyphicon-list"> </span><span class="visible-txt-menu">Servicio</span><span class="pull-right glyphicon glyphicon-chevron-down"></span></a>'+
							'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="'+urlRightNavBar+'admin/servicio"><span class="fa fa-list"></span> Lista de servicios</a></li>'+
								'<li><a href="'+urlRightNavBar+'admin/servicio/add"><span class="fa fa-plus"></span> Nuevo servicio</a></li>'+
							'</ul>'+
						'</li>'+
						'<li class="" >'+
							'<a title="Productos" href="'+urlRightNavBar+'admin/productos" ><span  class="pull-left hidden-xs showopacity glyphicon glyphicon-list"> </span><span class="visible-txt-menu">Producto</span></a>'+
							/*'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="'+urlRightNavBar+'admin/producto"><span class="fa fa-list"></span> Lista de servicios</a></li>'+
								'<li><a href="'+urlRightNavBar+'admin/producto/add"><span class="fa fa-plus"></span> Nuevo servicio</a></li>'+
							'</ul>'+*/
						'</li>'+
						'<li class="dropdown" >'+
							'<a title="Idiomas" href="#" class="dropdown-toggle" data-toggle="dropdown"><span  class="pull-left hidden-xs showopacity glyphicon glyphicon-globe"></span><span class="visible-txt-menu">Idioma</span><span class="pull-right glyphicon glyphicon-chevron-down"></span></a>'+
							'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="'+urlRightNavBar+'admin/idioma"><span class="fa fa-list"></span> Lista de diomas</a></li>'+
								'<li><a href="'+urlRightNavBar+'admin/idioma/add"><span class="fa fa-plus"></span> Nuevo idioma</a></li>'+
							'</ul>'+
						'</li>'+
						'<li class="dropdown" >'+
							'<a title="Categorias" href="#" class="dropdown-toggle" data-toggle="dropdown"><span  class="pull-left hidden-xs showopacity glyphicon glyphicon-tag"></span> <span class="visible-txt-menu">Categoria</span> <span class="pull-right glyphicon glyphicon-chevron-down"></span></a>'+
							'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="'+urlRightNavBar+'admin/categoria"><span class="fa fa-list"></span> Lista de categorias</a></li>'+
								'<li><a href="'+urlRightNavBar+'admin/categoria/add"><span class="fa fa-plus"></span> Nueva categoria</a></li>'+
							'</ul>'+
						'</li>'+
						'<li class="dropdown" >'+
							'<a title="Recursos" href="#" class="dropdown-toggle" data-toggle="dropdown"><span  class="pull-left hidden-xs showopacity glyphicon glyphicon-gift"></span> <span class="visible-txt-menu">Recurso</span> <span class="pull-right glyphicon glyphicon-chevron-down"></span></a>'+
							'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="'+urlRightNavBar+'admin/recurso"><span class="fa fa-list"></span> Lista de recurso</a></li>'+
								'<li><a href="'+urlRightNavBar+'admin/recurso/add"><span class="fa fa-plus"></span> Nuevo recurso</a></li>'+
							'</ul>'+
						'</li>'+
						'<li class=""><a href="'+urlRightNavBar+'admin/disponibilidad/update" title="Disponibilidad"><span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-calendar"></span><span class="visible-txt-menu">Disponibilidad</span></a></li>'+
						/*'<li class="dropdown" >'+
							'<a title="Reservas" href="#" class="dropdown-toggle" data-toggle="dropdown"><span  class="pull-left hidden-xs showopacity glyphicon glyphicon-tags"></span> <span class="visible-txt-menu">Reserva</span> <span class="pull-right glyphicon glyphicon-chevron-down"></span></a>'+
							'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="'+urlRightNavBar+'admin/reservarapida"><span class="fa fa-list"></span> Lista reserva rapida</a></li>'+
								'<li><a href="'+urlRightNavBar+'admin/reservarapida/add"><span class="fa fa-plus"></span> Nueva reserva rapida</a></li>'+
							'</ul>'+
						'</li>'+
						'<li class="dropdown" >'+
							'<a title="Reservas" href="#" class="dropdown-toggle" data-toggle="dropdown"><span  class="pull-left hidden-xs showopacity glyphicon glyphicon-shopping-cart"></span> <span class="visible-txt-menu">Oferta</span> <span class="pull-right glyphicon glyphicon-chevron-down"></span></a>'+
							'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="'+urlRightNavBar+'admin/oferta"><span class="fa fa-list"></span> Lista oferta</a></li>'+
							'</ul>'+
						'</li>'+
						'<li><a href="#">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>'+
						'<li ><a href="#">Profile<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>'+
						'<li ><a href="#">Messages<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-envelope"></span></a></li>'+
						'<li class="dropdown">'+
							'<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>'+
							'<ul class="dropdown-menu forAnimate" role="menu">'+
								'<li><a href="#">Action</a></li>'+
								'<li><a href="#">Another action</a></li>'+
								'<li><a href="#">Something else here</a></li>'+
								'<li class="divider"></li>'+
								'<li><a href="#">Separated link</a></li>'+
								'<li class="divider"></li>'+
								'<li><a href="#">One more separated link</a></li>'+
							'</ul>'+
						'</li>'+*/
					'</ul>'+
				'</div>'+
				'<div id="menu-flotante" class="text-center btn btn-primary col-md-12 " >'+
				  '<span class="fa fa-chevron-left"></span>'+
				'</div>'+
			'</div>'+
		'</nav>'+					
	'</div>');

$('#menu-flotante').click(function(){
	if($('#menu-flotante').children().prop("class")=='fa fa-chevron-left'){
		$('#menu-flotante').children().removeClass('fa-chevron-left').addClass('fa-chevron-right');
		// $('#menu-izquierda').css("width","50px");
		$('.visible-txt-menu').css('display','none');

		console.log($('.div-derecha').parent().html());
		$('.div-derecha').removeClass('div-derecha').addClass('div-content');
		$("#aside").removeClass('div-izquierda').addClass('div-menu div-menu-mini-flotante');
		console.log("error");

	}else{
		$(this).children().removeClass('fa-chevron-right').addClass('fa-chevron-left');
		$('#menu-izquierda').css("width","100%");
		$('.div-derecha-aling').addClass('div-derecha').removeClass('div-content');
		$("#aside").addClass('div-izquierda').removeClass("div-menu div-menu-mini-flotante");
		$('.visible-txt-menu').css('display','inline');
	}
});

}
else{
console.log(window.innerWidth);
// $('content div').first().addClass("row");
// alert('Resolucion: Menos de 1024x768, a lo mejor es 800x600');
// $('.navbar').removeClass('navbar-default').addClass('navbar-inverse');
}


var color_div_active='#ddd';
$('.dropdown-menu li a[href="' + ruta_url + '"]').parent().parent().parent().addClass('active');
$('.dropdown-menu li a[href="' + ruta_url + '"]').parent().addClass('active');
$('.dropdown-menu li a[href="' + ruta_url + '"]').css({'color':color_div_active,'font-weight': 'bold'});
$('.navbar-header a[href^="' + ruta_url + '"]').css({'color':color_div_active,'font-weight': 'bold'});

$('.menu_ubicacion').children().last().children().css('color','rgb(93, 94, 95);');
$('.forAnimate li a[href="' + lista + '"]').parent().parent().parent().addClass('active');
$('.navbar-nav li a[href="' + lista + '"]').css({'color':color_div_active,'font-weight': 'bold'});
$('.navbar-nav li a[href="' + lista + '"]').parent().addClass('active');
/*console.log(lista);*/


$('.panel-title').append('<span id="icon-panel-producto" class="panel-icon glyphicon glyphicon-chevron-down"></span>');
$(".panel-heading").click(function(){
		if ($(this).children().find('span.panel-icon').prop("class")=='panel-icon glyphicon glyphicon-chevron-down') {
			$(".panel-icon",this).removeClass("glyphicon glyphicon-chevron-down");
			$(".panel-icon",this).addClass("glyphicon glyphicon-chevron-up");
			
		}else{
			$(".panel-icon",this).removeClass("glyphicon glyphicon-chevron-up");
			$(".panel-icon",this).addClass("glyphicon glyphicon-chevron-down");
		}	
	});


	// $("content>div:first-child").css("margin-top","60px");



});




/*************** FUNCION PUBLICA PARA CONTROLAR CANTIDAD DE CARACTERES EN UN INPUT O TEXTAREA *******************/
/*
	IdInputName 		= Nombre del Input o Textarea a contar sus caracteres ingresados 
	idNameContador		= Nombre del span o div en la que mostrará la cantidad de caracteres que contiene IdInputName.
	CantidadMaxina		= Cantidad Máxima de Caracteres que debe contener IdInputName. EjemplO: 140.
	Ejemplo : <span><span id="idNameContador">0</span>/140</span><textarea id="idInputName"></textarea>
*/
function contador_letras(idInputName,idNameContador,cantidadMaxima){
	$("#"+idInputName).keyup(function(){
        actualizar_contador(idInputName, idNameContador,cantidadMaxima);
    });
	$("#"+idInputName).change(function(){
        actualizar_contador(idInputName, idNameContador,cantidadMaxima);
	});
}
function actualizar_contador(idInputName, idNameContador,cantidadMaxima){
    var contador = $("#"+idNameContador);
    var input =     $("#"+idInputName);
    contador.empty().append("0/"+cantidadMaxima);
    
    contador.empty().append( input.val().length+"/"+cantidadMaxima );
    if(parseInt( input.val().length) > cantidadMaxima ){
        input.val(input.val().substring(0,cantidadMaxima-1));
        contador.empty().append(cantidadMaxima+"/"+cantidadMaxima);
    }
}

/*	Funcion global para poner primera letra en mayuscula 	*/
function primera_letra_mayuscula(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}
/*************** FIN FUNCION PUBLICA PARA CONTROLAR CANTIDAD DE CARACTERES EN UN INPUT O TEXTAREA *******************/
