<?php

class Buscador extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/buscador_model');
    } 

    function index(){
        $data['destinos'] = $this->buscador_model->get_destinos_disponibles('es');
        $data['actividades'] = $this->buscador_model->get_actividades_disponibles('es');
        $this->load->view('admin/buscador',$data);
    }

    function add(){   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('nombre_buscador','Nombre buscador','required');
		
		if($this->form_validation->run()){   
            $params = array(
				'nombre_buscador' => $this->input->post('nombre_buscador'),
            );
            
            $buscador_id = $this->buscador_model->add_buscador($params);
            redirect('buscador/index');
        }else{            
            $data['_view'] = 'buscador/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    function edit($id_buscador){   
        // check if the buscador exists before trying to edit it
        $data['buscador'] = $this->buscador_model->get_buscador($id_buscador);
        
        if(isset($data['buscador']['id_buscador'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('nombre_buscador','Nombre buscador','required');
		
			if($this->form_validation->run()){   
                $params = array(
					'nombre_buscador' => $this->input->post('nombre_buscador'),
                );

                $this->buscador_model->update_buscador($id_buscador,$params);            
                redirect('buscador/index');
            }else{
                $data['_view'] = 'buscador/edit';
                $this->load->view('layouts/main',$data);
            }
        }else{
            show_error('The buscador you are trying to edit does not exist.');
        }
    } 

    function remove($id_buscador){
        $buscador = $this->buscador_model->get_buscador($id_buscador);

        // check if the buscador exists before trying to delete it
        if(isset($buscador['id_buscador'])){
            $this->buscador_model->delete_buscador($id_buscador);
            redirect('buscador/index');
        }else{
            show_error('The buscador you are trying to delete does not exist.');
        }
    }


    function insertaropcion(){
        $data = $this->input->post('data');
        $response = array();
        switch ( $data['type'] ) {
            case 'destino':
                $params_destinos = array(
                    'id_servicio' => $data['id'],
                    'id_idioma'   => $data['ididioma'],
                    'id_codigo_servicio' => $data['idcodigo'],
                    'fecha_destinos_search'  => date('Y-m-d H:i:s'),
                );
                $responseD = $this->buscador_model->add_destinos_search($params_destinos);    
                if ($responseD) {
                    $response['response'] = 'OK';
                }else{
                    $response['response'] = 'ERROR';
                }
            break;
            case 'actividad':
                $params_actividades = array(
                    'id_producto' => $data['id'],
                    'id_idioma'   => $data['ididioma'],
                    'id_codigo_producto' => $data['idcodigo'],
                    'fecha_actividades_search'  => date('Y-m-d H:i:s'),
                );
                $responseA = $this->buscador_model->add_actividades_search($params_actividades);
                if ($responseA) {
                    $response['response'] = 'OK';
                }else{
                    $response['response'] = 'ERROR';
                }                   
            break;
        }
        echo json_encode($response);
    }

    function eliminaropcion(){
        $data = $this->input->post('data');
        $response = array();
        switch ( $data['type'] ) {
            case 'destino':
                $responseD = $this->buscador_model->delete_destinos_search($data['id'],$data['idcodigo'],$data['ididioma']);    
                if ($responseD) {
                    $response['response'] = 'OK';
                }else{
                    $response['response'] = 'ERROR';
                }
            break;
            case 'actividad':
                $responseA = $this->buscador_model->delete_actividades_search($data['id'],$data['idcodigo'],$data['ididioma']);
                if ($responseA) {
                    $response['response'] = 'OK';
                }else{
                    $response['response'] = 'ERROR';
                }                   
            break;
        }
        echo json_encode($response);
    }
    
}
