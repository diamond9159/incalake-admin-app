<?php 

class Configuracion extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/configuracion_model');
        $this->load->model('admin/idioma_model');
    } 

    function index(){
        $data = array();
        $data['data']    = $this->configuracion_model->get_all_configuraciones();
        $data['idiomas'] = $this->idioma_model->get_nombre_idiomas();
        $this->load->view('admin/configuracion',$data);
    }

    function add(){  
        $data = array();
        $data['idiomas'] = $this->idioma_model->get_nombre_idiomas();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt_nombre_empresa','Nombre Empresa','required');
        
        if($this->form_validation->run()){   
            $data = array();
            $array_nombre_empresa = array();    
            foreach ($_POST['txt_nombre_empresa'] as $key => $value) {
                array_push( $array_nombre_empresa,array( $_POST['txt_idioma'][$key] => $_POST['txt_nombre_empresa'][$key] ) );
            }
            $array_titulo_pagina = array();
            foreach ($_POST['txt_titulo_index'] as $key => $value) {
                array_push( $array_titulo_pagina,array( $_POST['txt_idioma'][$key] => $_POST['txt_titulo_index'][$key] ) );
            }
            $array_keywords = array();
            foreach ($_POST['txt_keywords'] as $key => $value) {
                array_push($array_keywords,array($_POST['txt_idioma'][$key] => $_POST['txt_keywords'][$key] ));
            }
            $array_descripcion = array();
            foreach ($_POST['txt_descripcion'] as $key => $value) {
                array_push($array_descripcion,array($_POST['txt_idioma'][$key] => $_POST['txt_descripcion'][$key] ));
            }


            $params = array(
                'nombre_empresa'    => json_encode($array_nombre_empresa),
                'titulo_index'      => json_encode($array_titulo_pagina),
                'keywords_index'    => json_encode($array_keywords),
                'descripcion_index' => json_encode($array_descripcion),
                'logo_index'        => $_POST['txt_logo'],
                'favicon_index'     => $_POST['txt_favicon'],
                'codigo_google_analitics' => $_POST['txtr_script_google_analitics'],
                'codigo_zoopim'     => $_POST['txtr_script_zoopim'],
                'id_usuarios'       => $this->session->userdata('id_usuarios')
            );
            $this->configuracion_model->add_configuracion($params);
            redirect('admin/configuracion');  
        }else{
            $this->load->view('admin/configuracion-add',$data);
        }
    }

    function edit($id_configuracion){  
        $data = array();
        $data['data']    = $this->configuracion_model->get_all_configuraciones();
        $data['idiomas'] = $this->idioma_model->get_nombre_idiomas();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('txt_nombre_empresa','Nombre Empresa','required');
    
        if($this->form_validation->run()){   
            $data = array();
            $array_nombre_empresa = array();    
            foreach ($_POST['txt_nombre_empresa'] as $key => $value) {
                array_push( $array_nombre_empresa,array( $_POST['txt_idioma'][$key] => $_POST['txt_nombre_empresa'][$key] ) );
            }
            $array_titulo_pagina = array();
            foreach ($_POST['txt_titulo_index'] as $key => $value) {
                array_push( $array_titulo_pagina,array( $_POST['txt_idioma'][$key] => $_POST['txt_titulo_index'][$key] ) );
            }
            $array_keywords = array();
            foreach ($_POST['txt_keywords'] as $key => $value) {
                array_push($array_keywords,array($_POST['txt_idioma'][$key] => $_POST['txt_keywords'][$key] ));
            }
            $array_descripcion = array();
            foreach ($_POST['txt_descripcion'] as $key => $value) {
                array_push($array_descripcion,array($_POST['txt_idioma'][$key] => $_POST['txt_descripcion'][$key] ));
            }


            $params = array(
                'nombre_empresa'    => json_encode($array_nombre_empresa),
                'titulo_index'      => json_encode($array_titulo_pagina),
                'keywords_index'    => json_encode($array_keywords),
                'descripcion_index' => json_encode($array_descripcion),
                'logo_index'        => $_POST['txt_logo'],
                'favicon_index'     => $_POST['txt_favicon'],
                'codigo_google_analitics' => $_POST['txtr_script_google_analitics'],
                'codigo_zoopim'     => $_POST['txtr_script_zoopim'],
                'id_usuarios'       => $this->session->userdata('id_usuarios')
            );
            $this->configuracion_model->update_configuracion($id_configuracion,$params);
            redirect('admin/configuracion');  
        }else{
            $this->load->view('admin/configuracion-edit',$data);    
        }
    }

    function remove($id_configuracion){  
    	echo "Remove Configuraciones..!";
    }
}

