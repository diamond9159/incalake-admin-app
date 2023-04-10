<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Guia extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('buses/guia_model','Guia_model');
        $this->load->model('buses/idioma_model','Idioma_model');
    } 

    function index(){
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('guia/index?');
        $config['total_rows'] = $this->Guia_model->get_all_guias_count();
        $this->pagination->initialize($config);

        //$data['guias'] = $this->Guia_model->get_all_guias($params);
        $data['guias']		= $this->Guia_model->get_select_all_guias("es");
        $data['idiomas']	= $this->Idioma_model->get_select_all_idiomas();
        
        $data['_view'] = 'buses/guia/index';
        $this->load->view('buses/layouts/main',$data);
    }

    function add($codigoGuia,$idioma = null){  
	    $id_codigo_guia  = $codigoGuia;
	    if ($codigoGuia === 0 || $codigoGuia === "0") {
	    	$id_codigo_guia = $this->Guia_model->add_codigoGuia();
	    } 
        $this->load->library('form_validation');
		$data['idiomas']	= $this->Idioma_model->get_select_all_idiomas();
		$this->form_validation->set_rules('nombre_guia_es','Nombre Guía','required');
		
		if($this->form_validation->run()){   
            foreach ($data['idiomas'] as $key => $value) {
                $params = array(
                    'idioma_guia'     => $this->input->post( 'nombre_guia_'.mb_strtolower($value['codigo']) ),
                    'id_idioma'       => $value['id_idioma'],
                    'descripcion_guia'=> $this->input->post( 'nombre_guia_'.mb_strtolower($value['codigo']) ),
                    'id_codigo_guia'  => $id_codigo_guia,
                );
                $guia_id = $this->Guia_model->add_guia($params);
            }
            redirect('buses/guia/index');
        }else{            
            $data['_view'] = 'buses/guia/add';
            $this->load->view('buses/layouts/main',$data);
        }
    }  

    function edit( $id_guia, $codigo_guia = null ){   
        // check if the guia exists before trying to edit it
        $data['guia']       = $this->Guia_model->get_guia($id_guia);
        $data['editguia']   = $this->Guia_model->get_editGuia($codigo_guia); 
        $data['idiomas']	= $this->Idioma_model->get_select_all_idiomas();
        if(isset($data['guia']['id_guia'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('nombre_guia_es','Nombre Guía','required');
		
			if($this->form_validation->run()){   
                foreach ($data['idiomas'] as $key => $value) {
                    $params = array(
                        'idioma_guia'     => $this->input->post( 'nombre_guia_'.mb_strtolower($value['codigo']) ),
                        'descripcion_guia'=> $this->input->post( 'nombre_guia_'.mb_strtolower($value['codigo']) ),
                    );
                    $id_guia = @$this->input->post( 'txt_id_guia_'.mb_strtolower($value['codigo']) ); 
                    if ( @$this->input->post( 'txt_id_guia_'.mb_strtolower($value['codigo']) ) ) {
                        $this->Guia_model->update_guia($id_guia,$params);    
                    }else{
                        $params2 = array(
                            'idioma_guia'     => $this->input->post( 'nombre_guia_'.mb_strtolower($value['codigo']) ),
                            'id_idioma'       => $value['id_idioma'],
                            'descripcion_guia'=> $this->input->post( 'nombre_guia_'.mb_strtolower($value['codigo']) ),
                            'id_codigo_guia'  => $codigo_guia,
                        );
                        $guia_id2 = $this->Guia_model->add_guia($params2);        
                    }
                }            
                redirect('buses/guia/index');
            }else{
                $data['_view'] = 'buses/guia/edit';
                $this->load->view('buses/layouts/main',$data);
            }
        }else{
            //show_error('The guia you are trying to edit does not exist.');
            $data['_view'] = 'buses/guia/index';
            $this->load->view('buses/layouts/main',$data);
        }
    } 

    function remove($id_guia,$codigo_guia = null){
        $data = [];
        $guia = $this->Guia_model->get_guia($id_guia);
        // check if the guia exists before trying to delete it
        if(isset($guia['id_guia'])){
            $this->Guia_model->delete_guia($id_guia,$codigo_guia);
            $data['response'] = true;
            //redirect('buses/guia/index');
        }else{
            $data['response'] = false;
            //show_error('The guia you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }

    function disponibilidad(){
        $data['_view'] = 'buses/disponibilidad/index';
        $this->load->view('buses/layouts/main',$data);
    }
}
