<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('buses/empresa_model','Empresa_model');
    } 

    function index(){
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('empresa/index?');
        $config['total_rows'] = $this->Empresa_model->get_all_empresas_count();
        $this->pagination->initialize($config);

        $data['empresas'] = $this->Empresa_model->get_all_empresas($params);
        
        $data['_view'] = 'buses/empresa/index';
        $this->load->view('buses/layouts/main',$data);
    }

    function add(){   
        $this->load->library('form_validation');
		$this->form_validation->set_rules('nombre_empresa','Nombre Empresa','required');
		if($this->form_validation->run()){   
            $params = array(
				'nombre_empresa' => $this->input->post('nombre_empresa'),
				'logo_empresa' => $this->input->post('logo_empresa'),
				'uri_nombre_empresa' => $this->uri_amigable( $this->input->post('nombre_empresa') ),
            );
            
            $empresa_id = $this->Empresa_model->add_empresa($params);
            redirect('buses/empresa/');
        }else{            
            $data['_view'] = 'buses/empresa/add';
            $this->load->view('buses/layouts/main',$data);
        }
    }  

    function edit($id_empresa){   
        // check if the empresa exists before trying to edit it
        $data['empresa'] = $this->Empresa_model->get_empresa($id_empresa);
        
        if(isset($data['empresa']['id_empresa'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('nombre_empresa','Nombre Empresa','required');
		
			if($this->form_validation->run()){   
                $params = array(
					'nombre_empresa' => $this->input->post('nombre_empresa'),
					'logo_empresa' => $this->input->post('logo_empresa'),
					'uri_nombre_empresa' => $this->uri_amigable( $this->input->post('nombre_empresa') ),
                );

                $this->Empresa_model->update_empresa($id_empresa,$params);            
                redirect('buses/empresa/');
            }else{
                $data['_view'] = 'buses/empresa/edit';
                $this->load->view('buses/layouts/main',$data);
            }
        }else{
            show_error('The empresa you are trying to edit does not exist.');
        }
    } 

    function remove($id_empresa){
        $empresa = $this->Empresa_model->get_empresa($id_empresa);
        $data = [];
        // check if the empresa exists before trying to delete it
        if(isset($empresa['id_empresa'])){
            $this->Empresa_model->delete_empresa($id_empresa);
            $data['response'] = true;
            //redirect('buses/empresa/');
        }else{
            $data['response'] = false;
            //show_error('The empresa you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }
    
    function uri_amigable($token){
        $find       = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
        $replace    = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
        $uri = str_replace($find, $replace, mb_strtolower( trim($token) ) );
        return mb_strtolower( str_replace( ' ', '-', $uri ) );
    }
}
