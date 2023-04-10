<?php
class Slider extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/slider_model');
        $this->load->model('admin/idioma_model');
    } 

    function index(){
        $data['sliders'] = $this->slider_model->get_all_sliders();
        $data['idiomas'] = $this->idioma_model->get_nombre_idiomas();
        $this->load->view('admin/slider',$data);
    }


    function add(){ 
        $data = array();
        $data['idiomas'] = $this->idioma_model->get_nombre_idiomas();
        $this->load->library('form_validation');

        $this->form_validation->set_rules('codigo','Codigo','max_length[2]|min_length[2]');
        
        if($this->form_validation->run()){   
            $array_titulo       = array();
            $array_descripcion  = array();
            $array_url_destino  = array();
            foreach ($_POST['txt_titulo_slider'] as $key => $value) {
                array_push( $array_titulo,array( $_POST['txt_idioma'][$key] => $_POST['txt_titulo_slider'][$key] ) );
            }
            foreach ($_POST['txt_descripcion_slider'] as $key => $value) {
                array_push( $array_descripcion,array( $_POST['txt_idioma'][$key] => $_POST['txt_descripcion_slider'][$key] ) );
            }
            foreach ($_POST['txt_url_slider'] as $key => $value) {
                array_push( $array_url_destino,array( $_POST['txt_idioma'][$key] => $_POST['txt_url_slider'][$key] ) );
            }
            $params = array(
                'titulo_slider'     => json_encode($array_titulo),
                'descripcion_slider'=> json_encode($array_descripcion),
                'url_destino'       =>  json_encode($array_url_destino),
                'id_galeria'        => $this->input->post('txt_img_slider'),
                'fecha'             => date('Y-m-d h:i:s'),
            );
            $slider_id = $this->slider_model->add_slider($params);
            redirect('admin/slider');    
        }else{
            $this->load->view('admin/slider-add',$data);
        }
    }   


    function edit($id_slider){   
        $data = array();
        $data['idiomas'] = $this->idioma_model->get_nombre_idiomas();
        $data['slider']  = $this->slider_model->get_slider($id_slider);
        $this->load->library('form_validation');

		$this->form_validation->set_rules('txt_img_slider','Imagen para Slider','required');
	
		if($this->form_validation->run()){   
            $array_titulo       = array();
            $array_descripcion  = array();
            $array_url_destino  = array();
            foreach ($_POST['txt_titulo_slider'] as $key => $value) {
                array_push( $array_titulo,array( $_POST['txt_idioma'][$key] => $_POST['txt_titulo_slider'][$key] ) );
            }
            foreach ($_POST['txt_descripcion_slider'] as $key => $value) {
                array_push( $array_descripcion,array( $_POST['txt_idioma'][$key] => $_POST['txt_descripcion_slider'][$key] ) );
            }
            foreach ($_POST['txt_url_slider'] as $key => $value) {
                array_push( $array_url_destino,array( $_POST['txt_idioma'][$key] => $_POST['txt_url_slider'][$key] ) );
            }
            $params = array(
                'titulo_slider'     => json_encode($array_titulo),
                'descripcion_slider'=> json_encode($array_descripcion),
                'url_destino'       =>  json_encode($array_url_destino),
                'id_galeria'        => $this->input->post('txt_img_slider'),
                'fecha'             => date('Y-m-d h:i:s'),
            );
            $this->slider_model->update_slider($id_slider,$params);            
            redirect('admin/slider');
        }else{
            $this->load->view('admin/slider-edit',$data);
        }
    } 

    function remove($id_slider){
        $servicio = $this->slider_model->get_slider($id_slider);
        $data = array();
        if(isset($servicio['id_slider'])){
            $delete_response = $this->slider_model->delete_slider($id_slider);
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
        }else{
            $data = array(
                'response'  => 'ERROR',
                'data'      => 'El registro que quieres eliminar no existe..!',
            );
        }
        echo json_encode($data);
    }
}
