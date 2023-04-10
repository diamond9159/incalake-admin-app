<?php

class Oferta extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/oferta_model');
    } 

    function index(){
        //$data['lugares'] = $this->oferta_model->get_all_ofertaes();
        
        $data['idiomas_utilizados'] = $this->oferta_model->get_idiomas_utilizados();
        $data['ofertas']            = $this->oferta_model->get_ofertas_por_idioma(); 
        $data['listview_ofertas']   = $this->oferta_model->get_listview_ofertas();
        $this->load->view('admin/oferta',$data);
    }

    function add( $idioma, $id_producto = 0 ){
        $this->load->library('form_validation');
		$this->form_validation->set_rules('slct_paquete_oferta','Seleccione Paquete','required');
		$this->form_validation->set_rules('txt_inicio_oferta','Seleccione Fecha Inicio de la Oferta','required');
		$this->form_validation->set_rules('txt_fin_oferta','Seleccione Fecha fin de la Oferta','required');
        $this->form_validation->set_rules('slct_tipo_descuento_oferta','Seleccione tipo de descuento oferta','required');
        $this->form_validation->set_rules('txt_descuento_oferta','Ingrese el descuento para la oferta','required');
		if($this->form_validation->run())     {   
            $fecha_inicio = str_replace("/","-",$this->input->post('txt_inicio_oferta'));
            $fecha_fin    = str_replace("/","-",$this->input->post('txt_fin_oferta'));
            $fecha_inicio = date_format( date_create($fecha_inicio),'Y-m-d');
            $fecha_fin    = date_format( date_create($fecha_fin),'Y-m-d');
            $params = array(
				'inicio_oferta'     => $fecha_inicio,
				'fin_oferta'        => $fecha_fin,
				'descripcion_oferta'=> $this->input->post('txtr_descripcion_oferta'),
				'tipo_descuento'    => $this->input->post('slct_tipo_descuento_oferta'),
                'descuento'         => $this->input->post('txt_descuento_oferta'),
                'id_producto'       => $this->input->post('slct_paquete_oferta'),
            );  
            $ofertaid = $this->oferta_model->add_oferta($params);
            if ($ofertaid != 0 ) {
                redirect('admin/oferta');   
            }else{
                $data['error'] = 'Oops..! No se ha podido guardar el registro..!';
                $this->load->view('admin/oferta-add',$data);
            }
        }else{
            $data['id_producto'] = $id_producto;
            $data['idioma'] = $idioma;
            $data['ofertas'] = $this->oferta_model->get_idioma_ofertas($idioma);
            $this->load->view('admin/oferta-add',$data);
        }
    }  

    function edit($idioma,$id_oferta){   
        $data['oferta'] = $this->oferta_model->get_oferta($id_oferta);
        $data['id_servicio_referencia'] = $id_oferta;
        /*
        if(isset($data['oferta']['id_oferta'])){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('slct_paquete_oferta','Seleccione Paquete','required');
            $this->form_validation->set_rules('txt_inicio_oferta','Seleccione Fecha Inicio de la Oferta','required');
            $this->form_validation->set_rules('txt_fin_oferta','Seleccione Fecha fin de la Oferta','required');
            $this->form_validation->set_rules('slct_tipo_descuento_oferta','Seleccione tipo de descuento oferta','required');
            $this->form_validation->set_rules('txt_descuento_oferta','Ingrese el descuento para la oferta','required');
		
			if($this->form_validation->run()){   
                $fecha_inicio = str_replace("/","-",$this->input->post('txt_inicio_oferta'));
                $fecha_fin    = str_replace("/","-",$this->input->post('txt_fin_oferta'));
                $fecha_inicio = date_format( date_create($fecha_inicio),'Y-m-d');
                $fecha_fin    = date_format( date_create($fecha_fin),'Y-m-d');
                $params = array(
                    'inicio_oferta'     => $fecha_inicio,
                    'fin_oferta'        => $fecha_fin,
                    'descripcion_oferta'=> $this->input->post('txtr_descripcion_oferta'),
                    'tipo_descuento'    => $this->input->post('slct_tipo_descuento_oferta'),
                    'descuento'         => $this->input->post('txt_descuento_oferta'),
                    'id_producto'       => $this->input->post('slct_paquete_oferta'),
                );

                $this->oferta_model->update_oferta($id_oferta,$params);            
                redirect('admin/oferta');
            }else{
                */
                //$data['idioma'] = $this->idioma_model->get_nombre_idioma_codigo($idioma);
                //$data['all_ofertas'] = $this->oferta_model->get_idioma_ofertas($idioma);
                $data['productos']  = $this->oferta_model->get_listview_productos($id_oferta);
                $this->load->view('admin/oferta-edit',$data);    
            /*
            }
        }else{
            show_error('La oferta que estas intentando modificar no existe...!');
        }
        */
    } 

    function remove($id_oferta){
        $data['data']  = array();
        $oferta = $this->oferta_model->get_oferta($id_oferta);
        if(isset($oferta['id_oferta'])){
            $rpta = $this->oferta_model->delete_oferta($id_oferta);
            if ($rpta) {
                $data = array('response' => 'OK'); 
            }else{
                $data = array('response' => 'ERROR');
            }
            //redirect('admin/oferta');
        }else{
            $data = array('respose' => 'ERROR');
        }
        echo json_encode($data);
    }

    function find_oferta(){
        $data = array();
        $response = $this->oferta_model->get_producto_in_oferta( $this->input->post('id_paquete') );
        if ( !empty($response) ) {
           $data = array(
                'response' => 'OK',
                'data' => $response,           
            );
        }else{
            $data = array(
                'response' => 'ERROR',
                'data' => $response,            
            );
        }
        echo json_encode($data);
    }

    function eliminar_oferta(){
        $id = $this->input->post('id');
        $data = array();
        $response = $this->oferta_model->delete_oferta($id);
        if ($response != 0) {
            $data['response'] = "success";
            $data['message']  = "Eliminado correctamente";  
            $data['event']    = "Oferta";               
        }else{
            $data['response'] = "error";
            $data['message']  = "No se ha podido Eliminar";
            $data['event']    = "Oferta";
        }
        echo json_encode($data);
    }
}

//SELECT * FROM producto as p JOIN oferta as o ON p.id_producto = o.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio;
//SELECT * FROM producto as p JOIN oferta as o ON p.id_producto = o.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma;