<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lugar extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('buses/lugar_model','Lugar_model');
    } 

    function index(){
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('lugar/index?');
        $config['total_rows'] = $this->Lugar_model->get_all_lugares_count();
        $this->pagination->initialize($config);

        $data['lugares'] = $this->Lugar_model->get_all_lugares($params);
        
        $data['_view'] = 'buses/lugar/index';
        $this->load->view('buses/layouts/main',$data);
    }

    function add(){   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('nombre_lugar','Nombre Lugar','required');
		$this->form_validation->set_rules('coordenadas','Coordenadas','required');
		$this->form_validation->set_rules('tipo_lugar','Tipo Lugar','required');

		if($this->form_validation->run()){   
            $params = array(
				'nombre_lugar'  => $this->input->post('nombre_lugar'),
				'coordenadas'   => $this->input->post('coordenadas'),
				'tipo_lugar'    => $this->input->post('tipo_lugar'),
                'orden_lugar'   => @$this->input->post('orden_lugar'),
            );
            
            $lugar_id = $this->Lugar_model->add_lugar($params);
            redirect('buses/lugar/');
        }else{
			$data['_view'] = 'buses/lugar/add';
            $this->load->view('buses/layouts/main',$data);
        }
    }  

    function edit($id_lugar){   
        // check if the lugar exists before trying to edit it
        $data['lugar'] = $this->Lugar_model->get_lugar($id_lugar);
        
        if(isset($data['lugar']['id_lugar'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('nombre_lugar','Nombre Lugar','required');
			$this->form_validation->set_rules('coordenadas','Coordenadas','required');
			$this->form_validation->set_rules('tipo_lugar','Tipo Lugar','required');
			
			if($this->form_validation->run()){   
                $params = array(
					'nombre_lugar' => $this->input->post('nombre_lugar'),
					'coordenadas' => $this->input->post('coordenadas'),
					'tipo_lugar' => $this->input->post('tipo_lugar'),
                );

                $this->Lugar_model->update_lugar($id_lugar,$params);            
                redirect('buses/lugar/index');
            }else{
				$data['_view'] = 'buses/lugar/edit';
                $this->load->view('buses/layouts/main',$data);
            }
        }else{
            show_error('The lugar you are trying to edit does not exist.');
        }
    } 

    function remove($id_lugar){
        $lugar = $this->Lugar_model->get_lugar($id_lugar);
        $data = [];
        // check if the lugar exists before trying to delete it
        if(isset($lugar['id_lugar'])){
            $this->Lugar_model->delete_lugar($id_lugar);
            $data['response'] = true;
            //redirect('buses/lugar/index');
        }else{
            $data['response'] = false;
            //show_error('The lugar you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }
    
}
