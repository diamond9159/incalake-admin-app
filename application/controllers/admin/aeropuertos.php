<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Aeropuertos extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo de procesamiento aeropuertos
	  $this->load->model('admin/aeropuertos_model');

   }

	public function index(){
		// $datos['lista_datos'] = $this->confpreciosm->obtenerDatos();
		// retorna lista de idiomas
	    $datos['sectores'] = $this->aeropuertos_model->obtenerSectores();

		$this->load->view('admin/aeropuertos/sectores',$datos);
		// 
	}

	/* metodo para agregar y editar edades*/
	public function regedit_sector(){
	
		$data['key_sector'] = $this->input->post('key_name');
		
		$editar = $this->input->post('id_sector') ? $this->input->post('id_sector') : false;

		echo $this->aeropuertos_model->procesarSectores($data,$editar);
		//var_dump($_POST);

	}
	/* metodo de eliminar sectores*/
	public function eliminar_sector(){  
	    echo $this->aeropuertos_model->eliminar_sector($this->input->post('id'));
	    
	}
	/* metodo de eliminar vuelos*/
	public function eliminar_vuelo(){  
	    echo $this->aeropuertos_model->eliminar_vuelo($this->input->post('id'));
	    
	}
	/* metodo para editar registrar nacionalidades */
	public function update_precios_sector(){

		$data['valores_sector'] = json_encode($this->input->post('precios'));
		$id_sector = $this->input->post('id_sector');
		
		$result = $this->aeropuertos_model->update_precios($data,$id_sector);
		echo $result?$data['valores_sector']:0;
	}
	
	///// controladores para procesar lista de vuelos
	public function vuelos(){
		$datos['vuelos'] = $this->aeropuertos_model->obtenerVuelos();
		$this->load->view('admin/aeropuertos/vuelos',$datos);
	} 
	// guardar y editar vuelos
	public function regedit_vuelos(){
		$data['num_vuelo'] = $this->input->post('num_vuelo');
		$data['compania_vuelo'] = $this->input->post('compania_vuelo');
		$data['horapartida_vuelo'] = $this->input->post('horapartida_vuelo');
		$data['horallegada_vuelo'] = $this->input->post('horallegada_vuelo');
		$data['recojo_bus'] = $this->input->post('recojo_bus');
		$data['salida_bus'] = $this->input->post('salida_bus');
		$data['arribo_bus'] = $this->input->post('arribo_bus');

		$editar = $this->input->post('id_vuelo') ? $this->input->post('id_vuelo') : false;
		echo $this->aeropuertos_model->procesarVuelos($data,$editar);
	}

	///// controladores para configurar las tasas
	public function tasas(){
		$datos['configuraciones'] = $this->aeropuertos_model->obtenerConfiguraciones();
		$this->load->view('admin/aeropuertos/tasas',$datos);
	}
	public function regedit_tasas(){
		$data['servicio_publico'] = $this->input->post('precio_compartido');
		$data['servicio_privado'] = $this->input->post('precio_privado')?json_encode($this->input->post('precio_privado')):NULL;
		$data['comision_servicio'] = $this->input->post('comision');
		$data['impuesto'] = $this->input->post('impuesto');

		// $editar = $this->input->post('id_vuelo') ? $this->input->post('id_vuelo') : false;
		echo $this->aeropuertos_model->procesarTasas($data);
	}
}
