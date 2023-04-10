<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios_adicionales extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('buses/servicio_adicional_model');
       /* $this->load->model('admin/idioma_model');
        $this->load->model('admin/inicio_model');
        $this->load->model('admin/reservas_model');*/
        
    } 
	
	public function index(){
		$data['servicios_adicionales'] = $this->servicio_adicional_model->obtenerServiciosAdicionales();
		$this->load->view('buses/servicios_adicionales/index',$data);

	}
	public function registro(){
		
		$data['idiomas'] = $this->servicio_adicional_model->obtenerIdiomas();
		// $data['lugares'] = $this->modelo_buses->obtenerLugares();IT
		//$this->load->view('admin/admin',$count_servicio);
		$this->load->view('buses/servicios_adicionales/registro',$data);

	}

	public function editar(){
		// BUSCAR BUS SI NO EXISTE REDIRIGIR
		$id_servicio_adicional = $this->uri->segment(4);
		if(!$id_servicio_adicional)redirect(base_url('buses/servicios_adicionales/'));
		$data['servicio_adicional'] = $this->servicio_adicional_model->buscar_servicio_adicional($id_servicio_adicional);
		//var_dump($data); exit;
		if(!count($data['servicio_adicional']))redirect(base_url('buses/servicios_adicionales/'));
		// idiomas
		$data['idiomas'] = $this->servicio_adicional_model->obtenerIdiomas();
		//$this->load->view('admin/admin',$count_servicio);
		$this->load->view('buses/servicios_adicionales/registro',$data);

	}

	// aqui viene los formularios de registro,editar,clonar
	public function guardar(){
		// var_dump($this->input->post());exit;
		// 
		$data['nombre_servicio_adicional'] = $this->input->post('nombre_servicio_es');
		$data['icono_servicio_adicional'] = $this->input->post('icono_servicio');
		$data['traducciones_nombre'] = json_encode($this->input->post('nombre_servicio'));
		// si id_bus es igual a 0 se crea nuevo servicio de lo contrario se edita
		if(+$this->input->post('id_servicio_adicional')){
			// echo 'editar';
			echo $this->servicio_adicional_model->editar_servicio_adicional($data,$this->input->post('id_servicio_adicional'));
		} else {
			// echo 'registro';
			echo $this->servicio_adicional_model->registrar_servicio_adicional($data);
		}
		
	}

	public function eliminar(){
		echo $this->servicio_adicional_model->eliminar_servicio_adicional($this->input->post('id_servicio'));	
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
/*hola este es un comentario*/
