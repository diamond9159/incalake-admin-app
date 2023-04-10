<?php

class Lugar extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/lugar_model');
    } 

    function index(){
        $data['lugares'] = $this->lugar_model->get_all_lugares();
        $this->load->view('admin/lugar',$data);
    }

    function add(){   
        $this->load->library('form_validation');
		$this->form_validation->set_rules('txt_nombre_lugar','Nombre Lugar','required');
		$this->form_validation->set_rules('txt_coordenadas','Coordenadas','required');
		$this->form_validation->set_rules('txt_tipo_lugar','Tipo Lugar','required');
		if($this->form_validation->run())     {   
            $params = array(
				'nombre_lugar'      => $this->input->post('txt_nombre_lugar'),
				'coordenadas'       => $this->input->post('txt_coordenadas'),
				'tipo_lugar'        => $this->input->post('txt_tipo_lugar'),
				'descripcion_lugar' => $this->input->post('txt_descripcion_lugar'),
            );
            
            $lugar_id = $this->lugar_model->add_lugar($params);
            if ($lugar_id != 0 ) {
                redirect('admin/lugar');   
            }else{
                $data['error'] = 'Oops..! No se ha podido guardar el registro..!';
                $this->load->view('admin/lugar-add',$data);
            }
        }else{
            $this->load->view('admin/lugar-add');
        }
    }  

    function edit($id_lugar){   
        $data['lugar'] = $this->lugar_model->get_lugar($id_lugar);
        if(isset($data['lugar']['id_lugar'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('txt_nombre_lugar','Nombre Lugar','required');
			$this->form_validation->set_rules('txt_coordenadas','Coordenadas','required');
			$this->form_validation->set_rules('txt_tipo_lugar','Tipo Lugar','required');
		
			if($this->form_validation->run()){   
                $params = array(
					'nombre_lugar'     => $this->input->post('txt_nombre_lugar'),
					'coordenadas'      => $this->input->post('txt_coordenadas'),
					'tipo_lugar'       => $this->input->post('txt_tipo_lugar'),
					'descripcion_lugar'=> $this->input->post('txt_descripcion_lugar'),
					//'id_servicio' => $this->input->post('id_servicio'),
                );

                $this->lugar_model->update_lugar($id_lugar,$params);            
                redirect('admin/lugar');
            }else{
				$this->load->model('admin/servicio_model');
				$data['all_servicio'] = $this->servicio_model->get_all_servicios();
                $this->load->view('admin/lugar-edit',$data);    
            }
        }else{
            show_error('The lugar you are trying to edit does not exist.');
        }
    } 

    function remove($id_lugar){
        $data['data']  = array();
        $lugar = $this->lugar_model->get_lugar($id_lugar);
        if(isset($lugar['id_lugar'])){
            $rpta = $this->lugar_model->delete_lugar($id_lugar);
            if ($rpta) {
                $data = array('response' => 'OK'); 
            }else{
                $data = array('response' => 'ERROR');
            }
            //redirect('admin/lugar');
        }else{
            $data = array('respose' => 'ERROR');
        }
        echo json_encode($data);
    }
    
}
