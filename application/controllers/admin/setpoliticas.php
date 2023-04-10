<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setpoliticas extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo para obtener idiomas
      $this->load->model('admin/idioma_model');
   }

	public function index(){
		// obtener toda la lista de idiomas.
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$datos['ruta'] = '../web/assets/archivos/politicas/';
		$this->load->view('admin/setpoliticas/index',$datos);
	}
	public function bus(){
		// obtener toda la lista de idiomas.
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$datos['ruta'] = '../web/assets/archivos/politicas_bus/';
		$this->load->view('admin/setpoliticas/index',$datos);
	}
}
