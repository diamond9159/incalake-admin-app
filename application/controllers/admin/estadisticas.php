<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Estadisticas extends CI_Controller {
	public function index(){
		echo 'Probando estadisticas';
	}
	public function actividades_top(){
		$this->load->view('admin/estadisticas/actividades_top');
	}

	public function servicios(){
		$this->load->view('admin/estadisticas/servicios');
	}

}
