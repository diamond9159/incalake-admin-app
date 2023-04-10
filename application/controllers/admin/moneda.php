<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Moneda extends CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('admin/moneda_model');
    //  $this->load->helper('url');
    $this->load->model('admin/idioma_model');

   }

	public function index(){

		//$this->load->view('main');
		//$data = $this->producto->recuperarServicio($this->uri->segment(3));
		//$this->load->view('admin/productos');
		$datos['monedas'] = $this->moneda_model->obtenerMonedas();
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$this->load->view('admin/moneda/index',$datos);
		
	}
	public function guardar(){
		$data['nombre'] = $this->input->post('nombre');
		$data['codigo'] = $this->input->post('codigo');
		$data['simbolo'] = $this->input->post('simbolo');
		$data['traducciones'] = json_encode($this->input->post('idiomas'));
		/*si hay id se editara*/
		$editar = (int)$this->input->post('id');
		//var_dump($_POST);
		echo $this->moneda_model->procesarMonedas($data,$editar);
		
	}
	public function eliminar(){ 
	    echo $this->moneda_model->eliminar($this->input->post('id'));
	 }
	
}
