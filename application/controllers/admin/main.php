<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('admin/servicio_model');
        $this->load->model('admin/inicio_model');
        $this->load->model('admin/reservas_model');
/*        $this->load->model('admin/codigoservicio_model');
        $this->load->model('admin/idioma_model');*/
    } 
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		//$this->load->view('main');
		$data['numservicios']      = $this->servicio_model->get_count_servicio();
		$data['ultimas_preguntas'] = $this->inicio_model->obtener_ultimas_preguntas();
                $data['ultimas_reservas']  = $this->reservas_model->get_ultimas_reservas();
		$this->load->view('admin/admin',$data);
        
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

