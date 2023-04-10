<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Idioma extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('buses/idioma_model','Idioma_model');
    } 

    function index(){
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('idioma/index?');
        $config['total_rows'] = $this->Idioma_model->get_all_idiomas_count();
        $this->pagination->initialize($config);

        $data['idiomas'] = $this->Idioma_model->get_all_idiomas($params);
        
        $data['_view'] = 'buses/idioma/index';
        $this->load->view('buses/layouts/main',$data);
    }

    function add(){   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('pais','Pais','required');
		$this->form_validation->set_rules('codigo','Codigo','required');
		
		if($this->form_validation->run()){   
            $params = array(
				'pais' => $this->input->post('pais'),
				'codigo' => $this->input->post('codigo'),
            );
            
            $idioma_id = $this->Idioma_model->add_idioma($params);
            redirect('buses/idioma/index');
        }else{            
            $data['_view'] = 'buses/idioma/add';
            $this->load->view('buses/layouts/main',$data);
        }
    }  

    function edit($id_idioma){   
        // check if the idioma exists before trying to edit it
        $data['idioma'] = $this->Idioma_model->get_idioma($id_idioma);
        
        if(isset($data['idioma']['id_idioma'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('pais','Pais','required');
			$this->form_validation->set_rules('codigo','Codigo','required');
		
			if($this->form_validation->run()){   
                $params = array(
					'pais' => $this->input->post('pais'),
					'codigo' => $this->input->post('codigo'),
                );

                $this->Idioma_model->update_idioma($id_idioma,$params);            
                redirect('buses/idioma/index');
            }else{
                $data['_view'] = 'buses/idioma/edit';
                $this->load->view('buses/layouts/main',$data);
            }
        }else{
            show_error('The idioma you are trying to edit does not exist.');
        }
    } 

    function remove($id_idioma){
        $data = [];
        $idioma = $this->Idioma_model->get_idioma($id_idioma);
        // check if the idioma exists before trying to delete it
        if(isset($idioma['id_idioma'])){
            $this->Idioma_model->delete_idioma($id_idioma);
            $data['response'] = true;
            //redirect('buses/idioma/index');
        }else{
            $data['response'] = false;
            //show_error('The idioma you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }

    /*
    function disponibilidad(){
        $data['_view'] = 'buses/disponibilidad/index';
        $this->load->view('buses/layouts/main',$data);
    }
    */
}
