<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicio extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('buses/servicio_model');
       /* $this->load->model('admin/idioma_model');
        $this->load->model('admin/inicio_model');
        $this->load->model('admin/reservas_model');*/
        
    } 
	
	public function index(){
		$data['servicios'] = $this->servicio_model->obtenerServicios();
		$this->load->view('buses/servicio/index',$data);

	}
	public function registro(){
		
		$data['idiomas'] = $this->servicio_model->obtenerIdiomas();
		// $data['lugares'] = $this->modelo_buses->obtenerLugares();
		//$this->load->view('admin/admin',$count_servicio);
		$this->load->view('buses/servicio/registro',$data);

	}

	public function editar(){
		// BUSCAR BUS SI NO EXISTE REDIRIGIR
		$id_servicio = $this->uri->segment(4);
		if(!$id_servicio)redirect(base_url('buses/servicio/'));
		$data['servicio'] = $this->servicio_model->buscar_servicio($id_servicio);
		//var_dump($data); exit;
		if(!count($data['servicio']))redirect(base_url('buses/servicio/'));
		// idiomas
		$data['idiomas'] = $this->servicio_model->obtenerIdiomas();
		//$this->load->view('admin/admin',$count_servicio);
		$this->load->view('buses/servicio/registro',$data);

	}

	// aqui viene los formularios de registro,editar,clonar
	public function guardar(){
		// var_dump($this->input->post());exit;
		// 
		$data['nombre_servicio'] = $this->input->post('nombre_servicio_es');
		$data['descripcion_servicio'] = $this->input->post('descripcion_servicio_es');
		$data['nombre_traducciones'] = json_encode($this->input->post('nombre_servicio'));
		$data['descripcion_traducciones'] = json_encode($this->input->post('descripcion_servicio'));
		// si id_bus es igual a 0 se crea nuevo servicio de lo contrario se edita
		if(+$this->input->post('id_servicio')){
			echo $this->servicio_model->editar_servicio($data,$this->input->post('id_servicio'));
		} else {
			echo $this->servicio_model->registrar_servicio($data);
		}
		
	}

	public function eliminar(){
		echo $this->servicio_model->eliminar_servicio($this->input->post('id_servicio'));	
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
/*hola este es un comentario*/
