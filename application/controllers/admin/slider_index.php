<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Slider_index extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo principal
      $this->load->model('admin/slider_principal_model');
      $this->load->model('admin/idioma_model');
   }

	public function index(){
		// obtiene toda la lista de todo los sliders
		$datos['sliders'] = $this->slider_principal_model->obtenerSliders();
		// obtener la lista de los servicios
		$datos['servicios'] = $this->slider_principal_model->obtenerServicios();
		// obtener lista de idiomas 
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$this->load->view('admin/slider_html/index',$datos);	
	}
	// edita y agrega un slider
    public function regedit_slider(){
		// idioma del slider
		$data['idioma'] = $this->input->post('idioma');
		$result = array();
		// si hay datos post
		if($this->input->post('slider')){
			$slider_val = $this->input->post('slider');
			// recorrer todo los titulos enviados
			foreach($slider_val['titulo'] as $key => $value){
				$result[$key]['titulo'] =  $value;
				$result[$key]['subtitulo'] =  $slider_val['subtitulo'][$key];
				$result[$key]['destino'] =  $slider_val['destino'][$key];
				$result[$key]['imagen'] =  $slider_val['imagen'][$key];
			}

		} 
		$data['detalles'] = json_encode($result);
		// ENVIAR JSON AL MODELO PARA PROCESAR
		echo $this->slider_principal_model->procesar_slider($data);
       
    }

	 
}