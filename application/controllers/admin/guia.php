<?php

 class Guia extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/guia_model');
        $this->load->model('admin/codigoguia_model');
        $this->load->model('admin/idioma_model');
    } 

    function index(){
        $data['guias'] = $this->guia_model->get_all_guias();   
        $this->load->view('admin/guia',$data);
    }

    function add($code = 0){
        $codigo_guia = $code;   
        $this->load->library('form_validation');
		$this->form_validation->set_rules('txt_nombre_guia','Descripción Guia','required');
		if($this->form_validation->run())     {   
            if ( $codigo_guia === 0 || $codigo_guia === '0' ) {
                $nombre_codigo_guia = $_POST['txt_nombre_guia'][0];
                $codigo_guia = $this->codigoguia_model->add_codigoguia(
                    array(
                        'codigo_guia'  => str_replace(" ","-",strtolower($nombre_codigo_guia )),
                        //'imagen_guia'  => $_POST['img_destacada'],
                        'fecha'        => date('Y-m-d H:i:s')
                    ) 
                );
            }
            foreach ($_POST['txt_nombre_guia'] as $key => $value) {
                $guia_id = $this->guia_model->add_guia(
                    array(
                        'servicio_guia'    => trim($value),
                        'id_idioma'        => trim($_POST['txt_idioma'][$key]),
                        'id_codigo_guia'   => $codigo_guia,
                        'fecha'            => date('Y:m:d H:i:s')     
                    )
                );
            }
            redirect('admin/guia');
        }else{      
            $data['all_idiomas'] = $this->idioma_model->free_idiomas($codigo_guia);
            $data['codigo_guia'] = $codigo_guia;      
            $this->load->view('admin/guia-add',$data);
        }
    }  

    function edit($idCodigoGuia){   
        $data['data'] = $this->guia_model->getGuiasAgrupadas($idCodigoGuia);
        $data['codigo_guia'] = $idCodigoGuia;

        //if(isset($data['categoria']['id_categoria'])){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nombre_guia','Descipción Guía','required');
            if($this->form_validation->run()){   
                //$this->codigoguia_model->update_codigoguia($idCodigoGuia,array('imagen_guia'=>$_POST['img_destacada']));
                foreach ($_POST['txt_nombre_guia'] as $key => $value) {
                    $guia_id = $this->guia_model->update_guia( $idCodigoGuia,trim($_POST['txt_id_guia'][$key]),
                        array(
                            'servicio_guia'    => trim($value),
                            'id_idioma'        => trim($_POST['txt_idioma'][$key]),
                            'id_codigo_guia'   => $idCodigoGuia     
                        )
                    );
                }
                //$this->categoria_model->update_categoria($id_categoria,$params);            
                redirect('admin/guia');
            }else{          
                $this->load->view('admin/guia-edit',$data);
            }
        /*
        }else{
            show_error('The categoria you are trying to edit does not exist.');
        }
        */
    } 

    function remove($id_guia){
        $guia = $this->guia_model->get_guia($id_guia);
        // check if the guia exists before trying to delete it
        if(isset($guia['id_guia'])){
            $this->guia_model->delete_guia($id_guia);
            redirect('admin/guia');
        }else{
            show_error('The guia you are trying to delete does not exist.');
        }
    }

    function remove_codigo_guia(){
        $idguia         = $this->input->post('id');
        $idcodigoguia   = $this->input->post('idcodigo');
        $guia = $this->guia_model->get_guia($idguia);
        $data = array();    
        if(isset($guia['id_guia'])){
            $response = $this->guia_model->deleteCodigoGuia($idcodigoguia,$idguia);
            if ($response) {
                $data['response'] = 'success';
                $data['message']  = 'Se aliminado correctamente.';
            }else{
                $data['response'] = 'error';
                $data['message']  = 'No se ha podido eliminar el registro.';
            }
        }else{
            $data['response'] = 'error';
            $data['message']  = 'El registroque intentas eliminar no existe.';
        }
        echo json_encode($data);   
    }

    function traduccionesJson(){
        $idCodigoGuia   = $this->input->post('idcodigo');
        $idguia         = $this->input->post('id');
        $response = $this->guia_model->getGuiasAgrupadas( trim($idCodigoGuia) );
        echo json_encode($response);
    }

    function asociarGuiaProducto(){
        $idGuia = $this->input->post('id');
        $data['actividades'] = $this->guia_model->getAsociarGuiaProducto($idGuia);
        $data['idiomas']     = $this->idioma_model->get_all_idiomas(); 
        echo json_encode($data);
    }
    
    function operarAsociacion(){
        $idproducto = $this->input->post('idproducto');
        $ididioma   = $this->input->post('ididioma');
        $idguia     = $this->input->post('idguia');
        $operacion  = $this->input->post('operacion');
        
        $response = $this->guia_model->operarAsociacion($idproducto,$ididioma,$idguia,$operacion);
        echo json_encode($response);
    }
}
