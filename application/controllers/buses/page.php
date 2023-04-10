<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('buses/page_model','Page_model');
        $this->load->model('buses/idioma_model','Idioma_model');
        $this->load->model('buses/codigo_page_model','Codigo_page_model');
    } 

    function index(){
        /*
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('buses/pagina_web/index?');
        $config['total_rows'] = $this->Page_model->get_all_paginas_web_count();
        $this->pagination->initialize($config);
        */

        //$data['paginas_web'] = $this->Page_model->get_all_paginas_web($params);
        $data['paginas_web'] = $this->Page_model->get_all_selected_paginas_web();
        $data['idiomas']     = $this->Idioma_model->get_select_all_idiomas();
        
        $data['grupo_paginas_web'] = $this->Page_model->get_all_group_paginas_web();

        $data['_view'] = 'buses/pagina_web/index';
        $this->load->view('buses/layouts/main',$data);
    }

    function add($codigo_page = 0, $idioma = null ){  
        $codigo_pagina_web = $codigo_page;
         
        $data['idiomas']         = $this->Idioma_model->get_select_all_idiomas();
        $data['selected_idioma'] = $idioma;
        $data['codigo_page']     = $codigo_page;

        $this->load->library('form_validation');

		$this->form_validation->set_rules('url_pagina','Url Pagina','required');
		$this->form_validation->set_rules('titulo_pagina','Titulo Pagina','required');
		$this->form_validation->set_rules('ubicacion_servicio','Ubicacion Servicio','required');
		$this->form_validation->set_rules('uri_pagina','Uri Pagina','required');
		$this->form_validation->set_rules('descripcion_pagina','Descripcion Pagina','required');
		
		if($this->form_validation->run()){   
            /** Generando un nuevo codigo_pagina_web si en caso que no tiene **/
            if ($codigo_page <= 0) {
                $codigo_pagina_web = $this->Codigo_page_model->add_codigo_page_web(
                    array(
                        'codigo_pagina_web' => 'BUS-IL*'.date('Y-m-d*h:i:s'),
                        'fecha_codigo_pagina_web' => date('Y-m-d h:i:s'),
                     )
                );
             }

            $params = array(
                'id_idioma'         => $this->input->post('id_idioma'),
				'url_pagina'        => $this->input->post('url_pagina'),
				'titulo_pagina'     => $this->input->post('titulo_pagina'),
                'descripcion_pagina'=> $this->input->post('descripcion_pagina'),
				'imagen_principal'  => $this->input->post('imagen_principal'),
				'ver_slider'        => $this->input->post('ver_slider')?1:0,
				'miniatura_pagina'  => $this->input->post('miniatura_pagina'),
				'valoracion_pagina' => $this->input->post('valoracion_pagina'),
				'id_codigo_pagina_web'  => $codigo_pagina_web,
				'ubicacion_servicio'=> $this->input->post('ubicacion_servicio'),
				'uri_pagina'        => $this->input->post('uri_pagina'),
				'fecha'             => date('Y-m-d h:i:s'),
				'reviews_pagina'    => $this->input->post('reviews_pagina'),
            );
            
            $pagina_web_id = $this->Page_model->add_pagina_web($params);
            redirect('buses/page/index');
        }else{            
            $data['_view'] = 'buses/pagina_web/add';
            $this->load->view('buses/layouts/main',$data);
        }
    }  

    function edit( $id_pagina,$codigo_page = 0, $idioma = null ){   
        $codigo_pagina_web = $codigo_page;
        // check if the pagina_web exists before trying to edit it
        $data['pagina_web'] = $this->Page_model->get_pagina_web($id_pagina);
        $data['idiomas']         = $this->Idioma_model->get_select_all_idiomas();
        $data['selected_idioma'] = $idioma;
        $data['codigo_page']     = $codigo_page;


        if(isset($data['pagina_web']['id_pagina'])){
            $this->load->library('form_validation');

    	    $this->form_validation->set_rules('url_pagina','Url Pagina','required');
            $this->form_validation->set_rules('titulo_pagina','Titulo Pagina','required');
            $this->form_validation->set_rules('ubicacion_servicio','Ubicacion Servicio','required');
            $this->form_validation->set_rules('uri_pagina','Uri Pagina','required');
            $this->form_validation->set_rules('descripcion_pagina','Descripcion Pagina','required');
		
			if($this->form_validation->run()){   
                $params = array(
                    'id_idioma'         => $this->input->post('id_idioma'),
                    'url_pagina'        => $this->input->post('url_pagina'),
                    'titulo_pagina'     => $this->input->post('titulo_pagina'),
                    'descripcion_pagina'=> $this->input->post('descripcion_pagina'),
                    'imagen_principal'  => $this->input->post('imagen_principal'),
                    'ver_slider'        => $this->input->post('ver_slider')?1:0,
                    'miniatura_pagina'  => $this->input->post('miniatura_pagina'),
                    'valoracion_pagina' => $this->input->post('valoracion_pagina'),
                    'id_codigo_pagina_web'  => $codigo_pagina_web,
                    'ubicacion_servicio'=> $this->input->post('ubicacion_servicio'),
                    'uri_pagina'        => $this->input->post('uri_pagina'),
                    'fecha'             => date('Y-m-d h:i:s'),
                    'reviews_pagina'    => $this->input->post('reviews_pagina'),
                );

                $this->Page_model->update_pagina_web($id_pagina,$params);            
                redirect('buses/page/index');
            }else{
                $data['_view'] = 'buses/pagina_web/edit';
                $this->load->view('buses/layouts/main',$data);
            }
        }else{
            show_error('The pagina_web you are trying to edit does not exist.');
        }
    } 

    function remove($id_pagina){
        $data['response'] = false;
        $pagina_web = $this->Page_model->get_pagina_web($id_pagina);

        // check if the pagina_web exists before trying to delete it
        if(isset($pagina_web['id_pagina'])){
            $this->Page_model->delete_pagina_web($id_pagina);
            //redirect('buses/page/index');
            $data['response'] = true;
        }else{
            $data['response'] = false;
            //show_error('The pagina_web you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }


    /************ PRUEBA USORT ***************/
    

    function usort(){
        $fechasServicio = [];
        array_push($fechasServicio, date_format(date_create('02-09-2015'),'d-m-Y') );
        function ordenarFechas( $a, $b ) {
            return strtotime($a) - strtotime($b);
        }
        $fechasServicioSeleccionado = date('d-m-Y');
        if (count($fechasServicio) > 0 ) {
            usort($fechasServicio, 'ordenarFechas');
            $fechasServicioSeleccionado = $fechasServicio[0];
        }
        $fechasServicioSeleccionado = str_replace("-", "",$fechasServicioSeleccionado);
        echo "<h3>".$fechasServicioSeleccionado."</h3>";
    }
}
