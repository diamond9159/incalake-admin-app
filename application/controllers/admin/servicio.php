<?php

class Servicio extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/servicio_model');
        $this->load->model('admin/codigoservicio_model');
        $this->load->model('admin/idioma_model');
        $this->load->model('admin/galeria_model');
    } 
    
    function index(){
        //$data['servicios'] = $this->servicio_model->get_all_servicios();
        $data['servicios'] = $this->servicio_model->get_group_servicios();
        $this->load->view('admin/servicio',$data);
    }

    function add( $code=0 ){   
        $codigo_servicio = 'INCALAKE-'.date('Ymd-His');
        $id_codigo_servicio = $code;
        $this->load->library('form_validation');

		$this->form_validation->set_rules('txt_valoracion','Valoracion','required');
		$this->form_validation->set_rules('txt_url_servicio','Url Servicio','required');
		$this->form_validation->set_rules('txt_titulo_pagina','Titulo Pagina','required');
		$this->form_validation->set_rules('txt_descripcion_pagina','Descripcion Pagina','required');
		
		if($this->form_validation->run()){
            if ( $id_codigo_servicio === 0 || $id_codigo_servicio === '0' ) {
                $id_codigo_servicio = $this->codigoservicio_model->add_codigoservicio(array("codigo_servicio"=>$codigo_servicio, 'id_usuarios' => $this->session->userdata('id_usuarios') ) );
            }   
            $params = array(
				'url_servicio'          => mb_strtolower(utf8_encode($this->input->post('txt_url_pagina_web'))),
				'titulo_pagina'         => $this->input->post('txt_titulo_pagina'),
				'descripcion_pagina'    => $this->input->post('txt_descripcion_pagina'),
				'imagen_principal'      => $this->input->post('txt_imagen_principal'),
				'ver_slider'            => $this->input->post('txt_ver_slider'),
				'idioma_id_idioma'      => $this->input->post('txt_id_idioma'),
				'miniatura'             => $this->input->post('txt_miniatura'),
				'valoracion'            => $this->input->post('txt_valoracion'),
				'reviews'               => $this->input->post('txt_reviews'),
                'codigo_servicio_id_codigo_servicio' => $id_codigo_servicio,
                'ubicacion_servicio'    => $this->input->post('txt_lugar_pagina'),
                'uri_servicio'          => mb_strtolower(utf8_encode($this->input->post('txt_url_servicio'))),
                'fecha'                 => date('Y-m-d H:i:s'),
            );
            
            $servicio_id = $this->servicio_model->add_servicio($params);
            redirect('admin/servicio');
        }else{
			$this->load->model('admin/idioma_model');
			//$data['all_idiomas'] = $this->idioma_model->get_all_idiomas();
            $data['all_idiomas']     = $this->idioma_model->free_idiomas($id_codigo_servicio);
            $data['codigo_servicio'] = $id_codigo_servicio;
            $data['first_servicio']  = $this->servicio_model->get_first_servicio($id_codigo_servicio);
            if (!empty($data['first_servicio']['id_servicio']) ) {
                $data['slider']          = $this->galeria_model->get_galeria($data['first_servicio']['imagen_principal']);
                $data['miniatura']       = $this->galeria_model->get_galeria($data['first_servicio']['miniatura']);
            }else{
                $data['slider']     = array();
                $data['miniatura']  = array();
            }
            $this->load->view('admin/servicio-add',$data);
        }
    }  


    function edit($id_servicio){   
        // check if the servicio exists before trying to edit it
        $data['servicio'] = $this->servicio_model->get_servicio($id_servicio);
        $data['idioma_seleccionado'] = $this->idioma_model->get_idioma($data['servicio']['idioma_id_idioma']);
        if(isset($data['servicio']['id_servicio'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('txt_valoracion','Valoracion','required');
			$this->form_validation->set_rules('txt_url_pagina_web','Url Servicio','required');
			$this->form_validation->set_rules('txt_titulo_pagina','Titulo Pagina','required');
			$this->form_validation->set_rules('txt_descripcion_pagina','Descripcion Pagina','required');
		
			if($this->form_validation->run()){   
                $params = array(
					'url_servicio'         => mb_strtolower(utf8_encode($this->input->post('txt_url_pagina_web'))),
					'titulo_pagina'        => $this->input->post('txt_titulo_pagina'),
					'descripcion_pagina'   => $this->input->post('txt_descripcion_pagina'),
					'imagen_principal'     => $this->input->post('txt_imagen_principal'),
					'ver_slider'           => $this->input->post('txt_ver_slider'),
					'idioma_id_idioma'     => $this->input->post('txt_id_idioma'),
					'miniatura'            => $this->input->post('txt_miniatura'),
					'valoracion'           => $this->input->post('txt_valoracion'),
					'reviews'              => $this->input->post('txt_reviews'),
                    'codigo_servicio_id_codigo_servicio' => $data['servicio']['codigo_servicio_id_codigo_servicio'],
                    'ubicacion_servicio'    => $this->input->post('txt_lugar_pagina'),
                    'uri_servicio'          => mb_strtolower(utf8_encode($this->input->post('txt_url_servicio'))),
                );

                $this->servicio_model->update_servicio($id_servicio,$params);            
                redirect('admin/servicio');
            }else{
				$data['all_idiomas'] = $this->idioma_model->get_all_idiomas();
                $data['slider']      = $this->galeria_model->get_galeria($data['servicio']['imagen_principal']);
                $data['miniatura']   = $this->galeria_model->get_galeria($data['servicio']['miniatura']); 
                $this->load->view('admin/servicio-edit',$data);
            }
        }else{
            $data['message'] = 'El ID del servicio que intentas modificar no existe..!';
            redirect('admin/servicio',$data);
            //show_error('The servicio you are trying to edit does not exist.');
        }
    } 


    function remove($id_servicio){
        $servicio = $this->servicio_model->get_servicio($id_servicio);
        $data = array();
        if(isset($servicio['id_servicio'])){

            $delete_response = $this->servicio_model->delete_servicio($id_servicio);
            if ($delete_response) {
                $data = array(
                    'response'  => 'OK',
                    'data'      => 'Eliminado correctamente..!',
                );
            }else{
                $data = array(
                    'response'  => 'ERROR',
                    'data'      => 'No se ha podido eliminado correctamente, Intente nuevamente por favor..!',
                );
            }            
            //redirect('admin/servicio');
        }else{
            $data = array(
                'response'  => 'ERROR',
                'data'      => 'El registro que quieres eliminar no existe..!',
            );
            //show_error('The servicio you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }

    /**************************************************************************/
    function listview(){
        $data = $this->servicio_model->get_group_servicios();
        echo json_encode($data);
    }
    
    function verificar_url(){
        $data = array();
        $response = $this->servicio_model->verificar_duplicidad_url( $this->input->post('url') );
        if ( !empty($response['url_servicio']) ) {
            // SI LA URL EXISTE RETORNA ERROR
            $data['response'] = 'ERROR';
            $data['message']  = 'La url que acabas de verificar ya esta en uso.';
        }else{
            $data['response'] = 'OK';
            $data['message']  = 'La url que acabas de verificar no esta en uso y esta disponible para tu  página web.';
        }
        echo json_encode($data);
    }
    
}
