<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cupones extends CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('admin/cupones_model');
      $this->load->model('admin/idioma_model');
    //  $this->load->helper('url');
   }

	public function index(){
		//$this->load->view('main');
		//$data = $this->producto->recuperarServicio($this->uri->segment(3));
		//$this->load->view('admin/productos');
	/*	if($this->session->userdata('tipo_usuarios')!=1)redirect(base_url().'admin');//solo admin puede agregar 1 es el id del admin
		$datos['usuarios'] = $this->usuariosm->obtenerUsuarios();
		$this->load->view('admin/usuario/lista_usuarios',$datos);*/
		$datos['lista_cupones'] = $this->cupones_model->obtenerDatos();
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();

		$this->load->view('admin/cupones/index',$datos);
	//echo 'holaaaaaaaaaa';
		
	}
	public function regedit(){
		/*if($this->session->userdata('tipo_usuarios')!=1)redirect(base_url().'admin');//solo admin puede agregar 1 es el id del admin
		$this->load->helper('form');
		$this->load->view('admin/usuario/usuarios_procesar');*/
		//var_dump(@$this->input->post());
		$data['descripcion_cupon'] = $this->input->post('descripcion');
		$data['codigo_cupon'] = $this->input->post('codigo');
		$data['descuento_cupon'] = $this->input->post('descuento');
		$data['tipo_descuento_cupon'] = $this->input->post('tipo');
		$data['veces_activar'] = $this->input->post('veces');
		//$data['descripcion_etapa_edad'] = $this->input->post('descripcion');
		//$data['edad_min'] = $this->input->post('edad_min');
		//$data['edad_max'] = $this->input->post('edad_max');
		//$data['traducciones'] = json_encode($this->input->post('idiomas'));
		/*si hay id se editara*/
		$editar = $this->input->post('id')?$this->input->post('id'):false;

		echo $this->cupones_model->procesarCupones($data,$editar);
		//var_dump($_POST);

	}
	
	 public function delete()
	 {  // echo site_url('ccategoria');
	    echo $this->cupones_model->eliminar($this->input->post('id'));
	    
	 }
	 /*ahora para editar registrar eliminar naconalides*/
	 public function regedit_nac(){
		/*if($this->session->userdata('tipo_usuarios')!=1)redirect(base_url().'admin');//solo admin puede agregar 1 es el id del admin
		$this->load->helper('form');
		$this->load->view('admin/usuario/usuarios_procesar');*/
		//var_dump(@$this->input->post());
		$data['descripcion_nacionalidad'] = $this->input->post('descripcion');
		$data['traducciones_nacionalidad'] = json_encode($this->input->post('idiomas'));
		/*si hay id se editara*/
		$editar = $this->input->post('id')?$this->input->post('id'):false;

		echo $this->confpreciosm->procesarNacionalidades($data,$editar);

	}
	
	 public function eliminar_nac()
	 {  // echo site_url('ccategoria');
	    echo $this->confpreciosm->eliminarNacionalidad($this->input->post('id'));
	    
	 }
}
