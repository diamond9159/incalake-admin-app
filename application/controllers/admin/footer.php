<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo de idiomas
      $this->load->model('admin/idioma_model');
   }

	public function index(){
		// obtener idiomas ingresados desde la base de datos
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$this->load->view('admin/footerset/index',$datos);	
	}
}
