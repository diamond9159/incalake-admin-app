<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller {
    public function __construct() {
      parent::__construct();
   }

	public function index(){
		$this->load->helper('form');
		// obtener el url actual para redireccionar en caso no este logeado
		$data['url'] = $this->input->get('url');
		
		$this->load->view('admin/usuario/login',$data);
	}

	public function validar(){
			// libreria de codeigniter de validación
		   $this->load->library('form_validation');
		   $this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|xss_clean|regex_match[/^[a-z0-9]+$/]');
		   $this->form_validation->set_rules('password', 'Clave', 'trim|required|xss_clean|callback_check_database');
		 
			 $this->form_validation->set_message('regex_match', 'El %s no cumple con el formato requerido (Caracteres Minusculas y numeros)');
			 // obtener el url actual para redireccionar en caso haya error
			 $data['url'] = $this->input->post('url');
			 // si validacion no es aceptada
			 if($this->form_validation->run() == FALSE) $this->load->view('admin/usuario/login',$data);
			 // si es valida redireccionar a la url desde de intentó acceder inicialmente
		   else redirect($this->input->post('url'));
		   
	}
   /* metodo para verificar nombre de usuario y contraseña */
	 function check_database($password) {
				 // llamar al modelo de login
				 $this->load->model('admin/loginm');
				 // llamar metodo de buscar usuario
			   $result = $this->loginm->buscar($this->input->post('username'), $password);
				 
				 // si existe usuario
			   if($result)
			   {
			     foreach($result as $row)
			     {
			       $sess_array = array(
			         'id_usuarios' => $row->id_usuarios,
			         'username_usuarios' => $row->username_usuarios,
			         'tipo_usuarios' => $row->tipo_usuarios
			       );
						 // set el usuario a la session
			       $this->session->set_userdata($sess_array);
			     }
			     return true;
			   }
			   else
			   {
			     $this->form_validation->set_message('check_database', '<b><span class="fa fa-exclamation-triangle"></span></b><span>Tu Nombre de usuario o Contraseña es incorrecta</span>');
			     return false;
			   }
	 }
	// metodo para cerra session
	 function out(){     
			$this->session->sess_destroy();
		    $this->load->helper('cookie');
				delete_cookie('user', '', '/'); 
				// al cerrar session redireccionar al login con la url donde se estaba anteriormente.
		   	redirect(base_url().'admin/login?url='.$this->input->get('url')); 
			
    }
}