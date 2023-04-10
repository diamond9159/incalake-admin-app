<?php

class Bloqueo extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/bloqueo_model');
    } 

    function index(){
        //$data['lugares'] = $this->bloqueo_model->get_all_bloqueoes();
        
        //$data['idiomas_utilizados'] = $this->bloqueo_model->get_idiomas_utilizados();
        //$data['bloqueos']            = $this->bloqueo_model->get_bloqueos_por_idioma(); 
        //$data['listview_bloqueos']   = $this->bloqueo_model->get_listview_bloqueos();
        //$this->load->view('admin/bloqueo',$data);
    }

    function add( $idioma, $id_producto = 0 ){
        /*
        $this->load->library('form_validation');
        $this->form_validation->set_rules('slct_paquete_bloqueo','Seleccione Paquete','required');
        $this->form_validation->set_rules('txt_inicio_bloqueo','Seleccione Fecha Inicio de la Bloqueo','required');
        $this->form_validation->set_rules('txt_fin_bloqueo','Seleccione Fecha fin de la Bloqueo','required');
        $this->form_validation->set_rules('slct_tipo_descuento_bloqueo','Seleccione tipo de descuento bloqueo','required');
        $this->form_validation->set_rules('txt_descuento_bloqueo','Ingrese el descuento para la bloqueo','required');
        if($this->form_validation->run())     {   
            $fecha_inicio = str_replace("/","-",$this->input->post('txt_inicio_bloqueo'));
            $fecha_fin    = str_replace("/","-",$this->input->post('txt_fin_bloqueo'));
            $fecha_inicio = date_format( date_create($fecha_inicio),'Y-m-d');
            $fecha_fin    = date_format( date_create($fecha_fin),'Y-m-d');
            $params = array(
                'inicio_bloqueo'     => $fecha_inicio,
                'fin_bloqueo'        => $fecha_fin,
                'descripcion_bloqueo'=> $this->input->post('txtr_descripcion_bloqueo'),
                'tipo_descuento'    => $this->input->post('slct_tipo_descuento_bloqueo'),
                'descuento'         => $this->input->post('txt_descuento_bloqueo'),
                'id_producto'       => $this->input->post('slct_paquete_bloqueo'),
            );  
            $bloqueoid = $this->bloqueo_model->add_bloqueo($params);
            if ($bloqueoid != 0 ) {
                redirect('admin/bloqueo');   
            }else{
                $data['error'] = 'Oops..! No se ha podido guardar el registro..!';
                $this->load->view('admin/bloqueo-add',$data);
            }
        }else{
            $data['id_producto'] = $id_producto;
            $data['idioma'] = $idioma;
            $data['bloqueos'] = $this->bloqueo_model->get_idioma_bloqueos($idioma);
            $this->load->view('admin/bloqueo-add',$data);
        }
        */
    }  

    function edit($idioma,$id_bloqueo){   
        //$data['bloqueo'] = $this->bloqueo_model->get_bloqueo($id_bloqueo);
        //$data['id_servicio_referencia'] = $id_bloqueo;
        
        /*
        if(isset($data['bloqueo']['id_bloqueo'])){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('slct_paquete_bloqueo','Seleccione Paquete','required');
            $this->form_validation->set_rules('txt_inicio_bloqueo','Seleccione Fecha Inicio de la Bloqueo','required');
            $this->form_validation->set_rules('txt_fin_bloqueo','Seleccione Fecha fin de la Bloqueo','required');
            $this->form_validation->set_rules('slct_tipo_descuento_bloqueo','Seleccione tipo de descuento bloqueo','required');
            $this->form_validation->set_rules('txt_descuento_bloqueo','Ingrese el descuento para la bloqueo','required');
        
            if($this->form_validation->run()){   
                $fecha_inicio = str_replace("/","-",$this->input->post('txt_inicio_bloqueo'));
                $fecha_fin    = str_replace("/","-",$this->input->post('txt_fin_bloqueo'));
                $fecha_inicio = date_format( date_create($fecha_inicio),'Y-m-d');
                $fecha_fin    = date_format( date_create($fecha_fin),'Y-m-d');
                $params = array(
                    'inicio_bloqueo'     => $fecha_inicio,
                    'fin_bloqueo'        => $fecha_fin,
                    'descripcion_bloqueo'=> $this->input->post('txtr_descripcion_bloqueo'),
                    'tipo_descuento'    => $this->input->post('slct_tipo_descuento_bloqueo'),
                    'descuento'         => $this->input->post('txt_descuento_bloqueo'),
                    'id_producto'       => $this->input->post('slct_paquete_bloqueo'),
                );

                $this->bloqueo_model->update_bloqueo($id_bloqueo,$params);            
                redirect('admin/bloqueo');
            }else{
                */
                //$data['idioma'] = $this->idioma_model->get_nombre_idioma_codigo($idioma);
                //$data['all_bloqueos'] = $this->bloqueo_model->get_idioma_bloqueos($idioma);
                
                //$data['productos']  = $this->bloqueo_model->get_listview_productos($id_bloqueo);
                //$this->load->view('admin/bloqueo-edit',$data);    
            /*
            }
        }else{
            show_error('La bloqueo que estas intentando modificar no existe...!');
        }
        */
    } 

    function remove($id_bloqueo){
        $data['data']  = array();
        $bloqueo = $this->bloqueo_model->get_bloqueo($id_bloqueo);
        if(isset($bloqueo['id_bloqueo'])){
            $rpta = $this->bloqueo_model->delete_bloqueo($id_bloqueo);
            if ($rpta) {
                $data = array('response' => 'OK'); 
            }else{
                $data = array('response' => 'ERROR');
            }
            //redirect('admin/bloqueo');
        }else{
            $data = array('respose' => 'ERROR');
        }
        echo json_encode($data);
    }

    function eliminar_bloqueo(){
        $id = $this->input->post('id');
        $data = array();
        $response = $this->bloqueo_model->delete_bloqueo($id);
        if ($response != 0) {
            $data['response'] = "success";
            $data['message']  = "Eliminado correctamente";  
            $data['event']    = "Bloqueo";               
        }else{
            $data['response'] = "error";
            $data['message']  = "No se ha podido Eliminar";
            $data['event']    = "Bloqueo";
        }
        echo json_encode($data);
    }
}

//SELECT * FROM producto as p JOIN bloqueo as o ON p.id_producto = o.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio;
//SELECT * FROM producto as p JOIN bloqueo as o ON p.id_producto = o.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma;
