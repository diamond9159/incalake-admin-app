<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preguntas extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo principal para este controlador
      $this->load->model('admin/preguntas_model');
   }
	public function index(){
		// obtener toda las preguntas 
		$datos['listaPreguntas'] = $this->preguntas_model->obtenerPreguntas();
		$this->load->view('admin/preguntas/index',$datos);
	}
	// metodo para ver detalladamente una pregunta
	public function ver(){
		// se retorna del modelo detalles de una pregunta (se obtiene el segmento 4 de la URL que viene ser el ID de la pregunta)
		$resultado['detalles_pregunta'] = $this->preguntas_model->detallesPregunta($this->uri->segment(4)?$this->uri->segment(4):0);
		// si hay resultado enviar datos a la vista de lo contrario redireccionar al index de este controlador
		if($resultado['detalles_pregunta']){
			$this->load->view('admin/preguntas/ver',$resultado);
		} else redirect(base_url().'admin/preguntas');
		
	}
	
	
	
    function remove($id_pregunta){
        $id = $this->input->post('id');
        $response = [];
        $guia = $this->pregunta_model->get_pregunta($id);
        if(isset($guia['id'])){
            $this->pregunta_model->delete_pregunta($id);
            $response['response'] = "success";
        }else{
            $response['response'] = "error";
        }
        echo json_encode($response);
    }
    
    
}
