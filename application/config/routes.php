<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'libraries/pigeon.php');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/


Pigeon::map(function($r) {
	$r->get('api/forms',  					'admin/CampoFormularioController@index');   // Listar inputs

	$r->get('api/forms-delete', 			'admin/CampoFormularioController@delete');  //
	$r->post('api/forms', 					'admin/CampoFormularioController@store');  // Almacenar input
	$r->post('api/forms/update',			'admin/CampoFormularioController@update');
	$r->post('api/forms/update/prioridad',	'admin/CampoFormularioController@updatePrioridad');

	$r->get('api/formscategoria', 			'admin/CampoCategoriaController@index');
	$r->post('api/formscategoria',  		'admin/CampoCategoriaController@store');
	$r->post('api/formscategoria-update', 	'admin/CampoCategoriaController@update');
	$r->get('api/formscategoria-delete', 	'admin/CampoCategoriaController@delete');
});

$route = Pigeon::draw();


$route['default_controller'] = "main";

$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */