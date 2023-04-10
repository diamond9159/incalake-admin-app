<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo de procesamiento edades y nacionalidades
	  //$this->load->model('admin/confpreciosm');
	  // modelo que retorna idiomas
      //$this->load->model('admin/idioma_model');
    }

	public function index(){
		echo "Hola Mundo..!";
	}
}