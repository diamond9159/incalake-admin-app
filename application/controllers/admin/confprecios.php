<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Confprecios extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo de procesamiento edades y nacionalidades
	  $this->load->model('admin/confpreciosm');
	  // modelo que retorna idiomas
      $this->load->model('admin/idioma_model');
   }

	public function index(){
		// retorna lista de nacionalidades y edades
		$datos['lista_datos'] = $this->confpreciosm->obtenerDatos();
		// retorna lista de idiomas
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();

		$this->load->view('admin/confprecios/index',$datos);
		
	}

	/* metodo para agregar y editar edades*/
	public function regedit(){
		
		$data['descripcion_etapa_edad'] = $this->input->post('descripcion');
		$data['edad_min'] = $this->input->post('edad_min');
		$data['edad_max'] = $this->input->post('edad_max');
		$data['traducciones'] = json_encode($this->input->post('idiomas'));
		/*si hay id se editara*/
		$editar = $this->input->post('id')?$this->input->post('id'):false;

		echo $this->confpreciosm->procesarEdades($data,$editar);

	}
	/* metodo de eliminar edades*/
	public function eliminar(){  
	    echo $this->confpreciosm->eliminar($this->input->post('id'));
	    
	}
	/* metodo para editar registrar nacionalidades */
	public function regedit_nac(){

		$data['descripcion_nacionalidad'] = $this->input->post('descripcion');
		$data['traducciones_nacionalidad'] = json_encode($this->input->post('idiomas'));
		/*si hay id se editara*/
		$editar = $this->input->post('id')?$this->input->post('id'):false;
		echo $this->confpreciosm->procesarNacionalidades($data,$editar);
	}
	/* metodo para eliminar nacionalidades */
	public function eliminar_nac(){  
	    echo $this->confpreciosm->eliminarNacionalidad($this->input->post('id'));
	 }
}
