<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Clientesavt extends CI_Controller {
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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct(){
        parent::__construct();
        $this->load->model('admin/clientesavt_model');
    } 
	public function index()
	{
		$data=array();
		$clientes=$this->clientesavt_model->get_all_clientes();
		$data['clientes']=$clientes;
		$this->load->view('admin/page_clientes',$data);
	}
	public function add(){
		$data_add_cliente=$this->input->post('data_add_cliente');
		$id_cliente=$this->clientesavt_model->add_cliente($data_add_cliente);
		echo json_encode($id_cliente);
	}
	public function get_clientes(){
		$data_id_cliente=$this->input->post('id_cliente');
		$data_cliente=$this->clientesavt_model->get_clientes($data_id_cliente);
		echo json_encode($data_cliente);
	}
	public function delete_cliente(){
		$data_id_cliente=$this->input->post('id_cliente');
		$data_cliente=$this->clientesavt_model->delete_cliente($data_id_cliente);
		if ($data_cliente) {
			echo json_encode('success');
		}
	}
	public function get_ultimate_row(){
		$data_cliente=$this->clientesavt_model->get_ultimate_row();
		echo json_encode($data_cliente);
	}
	public function update_cliente(){
		$data_cliente=$this->input->post('data_cliente');
		$data_id_cliente=$this->input->post('id_cliente');
		$data_cliente=$this->clientesavt_model->update_cliente($data_id_cliente,$data_cliente);
		if ($data_cliente) {
			echo json_encode('success');
		}
	}
}
