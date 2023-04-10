<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('admin/usuariosm');
   }

	public function index(){
		// solo admin puede agregar 1 es el id del admin
		if($this->session->userdata('tipo_usuarios')!=1)redirect(base_url().'admin');
		// si es el administrador
		$datos['usuarios'] = $this->usuariosm->obtenerUsuarios();
		$this->load->view('admin/usuario/lista_usuarios',$datos);
		
	}
	public function agregar(){
		// solo admin puede agregar 1 es el id del admin
		if($this->session->userdata('tipo_usuarios')!=1)redirect(base_url().'admin');
		$this->load->helper('form');
		$this->load->view('admin/usuario/usuarios_procesar');
	}
	// asegurar que solo el propietario de la cuenta pueda editar
	public function editar(){
		// tipo de usuario 1 = admin
		$idUsActual = $this->session->userdata('tipo_usuarios');
		// id del usuario
		$idEdicion = $this->uri->segment(4);
		// solo propietario de cuenta puede editar
		if($idUsActual!=$idEdicion and $idUsActual!=1)redirect(base_url().'admin');
		$this->load->helper('form');
		// recuperar datos del usuario
		$data['usuario'] = $this->usuariosm->obtenerUsuario($idEdicion);
		// si no existe usuario
		if(!$data['usuario'])redirect(base_url().'admin/usuarios');
		$this->load->view('admin/usuario/usuarios_procesar',$data);
	}

	// procesamiento (agregar y editar usuarios)
	public function regedit(){
		$this->load->library('form_validation');
		// identificar el tipo de proceso (cambiar:editar,Guardar: Crear uno nuevo)
		$editar = $this->input->post('tipoproceso')=='Cambiar'?true:false;
		// validar si se crea nuevo user
	    if(!$editar)$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|xss_clean|regex_match[/^[a-zA-Z0-9_.-]+$/]|callback_check_user');
	    $this->form_validation->set_rules('password', 'Clave', 'trim|xss_clean');
    // si validacion es correcta
    if($this->form_validation->run() != FALSE){
		if(!$editar)$param['username_usuarios'] = $this->input->post('username');
		$param['password_usuarios'] = $this->input->post('password');
		$param['nombre_usuarios'] = $this->input->post('nombre');
		$param['mail_usuarios'] = $this->input->post('email');
		
		// si se edita
		if($editar){
		  $idUsActual = $this->session->userdata('id_usuarios');
		  $tipoUs = $this->session->userdata('tipo_usuarios');
		  $idEdicion = $this->input->post('id');
		  // asegurar que solo el propietario pueda editar
		  if($idUsActual!=$idEdicion and $tipoUs!=1)redirect(base_url().'admin');
			$exito = $this->usuariosm->procesarUsuario($param,$idEdicion);

			// si hay exito asegurarse que solo admin pueda ser la lista de usuarios
			if($idUsActual==1 and $idEdicion!=1 and $exito)redirect(base_url().'admin/usuarios/');
			// de lo contrario cerrar session
			else redirect(base_url().'admin/login/out');
	    // si se crea nuevo usuario
		} else {
			$param['tipo_usuarios'] = $this->input->post('tipo_usuario');
			// rechazar si un usuario que no es el admin intenta crear
			if($this->session->userdata('tipo_usuarios')!=1)redirect(base_url().'admin');
			$exito = $this->usuariosm->procesarUsuario($param);
			// si fue exitosa mosatrar lista de usuarios
			if($exito)redirect(base_url().'admin/usuarios');
		}
	  }  else $this->load->view('admin/usuario/usuarios_errores'); //fin si ejecuciones del validador
	}
	// metodo para verificar usuario existente y evitar duplicados de user names
	 function check_user($username) {

			   $result = $this->usuariosm->checkUser($username);
			   if($result){
			   	$this->form_validation->set_message('check_user', 'Ya existe alguien con el mismo nombre de usuario.');
			   	return false;
			   } else return true;
			

	}
	// metodo de eliminacion de usuarios
	 public function eliminar()
	 {  
		 // asegurarse que solo admin pueda eliminar usuarios
		if($this->session->userdata('tipo_usuarios')!=1 or $this->uri->segment(4)==1)redirect(base_url().'admin/usuarios');
		// si exitoso entonces redireccionar a la lista de usuarios
	 	if($this->usuariosm->eliminar($this->uri->segment(4)))redirect(base_url().'admin/usuarios');
	 }
}
