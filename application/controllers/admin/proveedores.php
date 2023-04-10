<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Proveedores extends CI_Controller {
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
        $this->load->model('admin/proveedores_model');
    } 
	public function index()
	{
		$data=array();
		$proveedores=$this->proveedores_model->get_all_proveedores();
		$data['proveedores']=$proveedores;
		$this->load->view('admin/page_proveedores',$data);
	}
	public function add(){
		$data_add_proveedor=$this->input->post('data_add_proveedor');
		$id_proveedor=$this->proveedores_model->add_proveedor($data_add_proveedor);
		echo json_encode($id_proveedor);
	}
	public function get_proveedores(){
		$data_id_proveedor=$this->input->post('id_proveedor');
		$data_proveedor=$this->proveedores_model->get_proveedores($data_id_proveedor);
		echo json_encode($data_proveedor);
	}
	public function delete_proveedor(){
		$data_id_proveedor=$this->input->post('id_proveedor');
		$data_proveedor=$this->proveedores_model->delete_proveedor($data_id_proveedor);
		if ($data_proveedor) {
			echo json_encode('success');
		}
	}
	public function get_ultimate_row(){
		$data_proveedor=$this->proveedores_model->get_ultimate_row();
		echo json_encode($data_proveedor);
	}
	public function update_proveedor(){
		$data_proveedor=$this->input->post('data_proveedor');
		$data_id_proveedor=$this->input->post('id_proveedor');
		$data_proveedor=$this->proveedores_model->update_proveedor($data_id_proveedor,$data_proveedor);
		if ($data_proveedor) {
			echo json_encode('success');
		}
	}
}
