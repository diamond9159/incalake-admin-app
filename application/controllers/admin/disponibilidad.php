<?php
class Disponibilidad extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/disponibilidad_model');
        $this->load->model("admin/producto");
        $this->load->model("admin/idioma_model");
        $this->load->model("admin/oferta_model");
        $this->load->model("admin/bloqueo_model");
    } 

    function index(){
        $data['disponibilidades'] = $this->disponibilidad_model->get_all_disponibilidades();
        $this->load->view('admin/disponibilidad',$data);
    }

    function update($id_servicio = 0 ){ //Vista EDIT
        //$data['disponibilidades'] = $this->disponibilidad_model->get_all_disponibilidades();
        $data['productos']  =array();
        $temp_ids=array();
        $data['id_servicio_referencia'] = $id_servicio;
        //$response_producto = $this->producto->obtenerProductos();
        $response_producto = $this->producto->get_all_productos_for_disponibilidad();
        if ( is_array($response_producto) ) {
            foreach ($response_producto as $key => $value) {
                $idioma  = $this->idioma_model->get_idioma_id_servicio($value['id_servicio']);
                array_push($value,$idioma);
                array_push($data['productos'],$value);
                $temp_ids[]=$value['id_producto'];

            }
        $data['id_productos']=$temp_ids;
        }
        $this->load->view('admin/disponibilidad-edit',$data);
    }
    



    function add(){   
        $this->load->library('form_validation');

        $this->form_validation->set_rules('codigo','Codigo','max_length[2]|min_length[2]');
        
        if($this->form_validation->run()){   
            $data = array();
            $params = array(
                'pais' => strtoupper($this->input->post('pais')),
                'codigo' => strtoupper($this->input->post('codigo')),
            );
            if ( !$this->disponibilidad_model->descartar_duplicidad( strtoupper($this->input->post('codigo') ) ) ) {
                $disponibilidad_id = $this->disponibilidad_model->add_disponibilidad($params);
                //redirect('admin/disponibilidad');
                redirect('admin/disponibilidad');    
            }else{
                //$disponibilidad_id = $this->disponibilidad_model->add_disponibilidad($params);
                $data['data'] = 'El disponibilidad que quieres registrar ya existe..!';
                $this->load->view('admin/disponibilidad-add',$data);
            }
        }else{
            $this->load->view('admin/disponibilidad-add');
        }
    }   


    function edit($id_disponibilidad){   
        // check if the disponibilidad exists before trying to edit it
        $data['disponibilidad'] = $this->disponibilidad_model->get_disponibilidad($id_disponibilidad);
        
        if(isset($data['disponibilidad']['id_disponibilidad'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('codigo','Codigo','max_length[2]|min_length[2]');
		
			if($this->form_validation->run()){   
                $params = array(
					'pais' => $this->input->post('pais'),
					'codigo' => $this->input->post('codigo'),
                );

                $this->disponibilidad_model->update_disponibilidad($id_disponibilidad,$params);            
                redirect('admin/disponibilidad');
            }else{
                $this->load->view('admin/disponibilidad/edit',$data);
            }
        }else{
            show_error('The disponibilidad you are trying to edit does not exist.');
        }
    } 


    function remove($id_disponibilidad){
        $disponibilidad = $this->disponibilidad_model->get_disponibilidad($id_disponibilidad);

        // check if the disponibilidad exists before trying to delete it
        if(isset($disponibilidad['id_disponibilidad'])){
            $this->disponibilidad_model->delete_disponibilidad($id_disponibilidad);
            redirect('admin/disponibilidad/index');
        }else{
            show_error('The disponibilidad you are trying to delete does not exist.');
        }
    }

    function eliminar_disponiblidad(){
        $id = $this->input->post('id');
        $data = array();
        $response = $this->delete_disponibilidad($id);
        if ($response != 0) {
            $data['response'] = "success";
            $data['message']  = "Eliminado correctamente";                 
        }else{
            $data['response'] = "error";
            $data['message']  = "No se ha podido Eliminar";
        }
        echo json_encode($data);
    }
    function disponibilidad_bloqueo_oferta_json(){
        $data = array();
        $id_producto        = $this->input->post('id_servicio');
        $disponibilidad     = $this->disponibilidad_model->get_disponibilidad($id_producto);
        $bloqueo            = $this->bloqueo_model->get_bloqueo($id_producto);
        $oferta             = $this->oferta_model->get_oferta($id_producto);
        
        $data['disponibilidad'] = $disponibilidad;
        $data['bloqueo']        = $bloqueo;
        $data['oferta']         = $oferta;
        echo json_encode($data);
    }

    function add_ajax(){
        $data = array();

        $id_producto        = $this->input->post('id_producto');
        $data_disponiblidad = $this->input->post('json_disponiblidad');
        $data_bloqueo       = $this->input->post('json_bloqueo');
        $data_oferta        = $this->input->post('json_oferta');
        $data['response'] = "OK";
        $data['url'] = base_url()."admin/disponibilidad";
        $response_disponibilidad = null;
        $response_oferta         = null;
        $response_bloqueo        = null;
        /**** AGREGAR DISPONIBILIDAD, BLOQUEO y OFERTA *****/
        $jsonDisponibilidad = trim($data_disponiblidad);
        if ( !empty($jsonDisponibilidad) ) {
            $jsonDisponibilidad = json_decode($jsonDisponibilidad,true);
            foreach ($jsonDisponibilidad as $key => $value) {
                if ( !is_numeric($value['id']) )  {
                    $this->disponibilidad_model->delete_disponibilidad_producto($id_producto);
                    $params_disponibilidad['id_producto']                 = $id_producto;
                    $params_disponibilidad['descripcion_disponibilidad']  = $value['title'];
                    $params_disponibilidad['fecha_inicio']                = $value['start'];
                    $params_disponibilidad['fecha_fin']                   = $value['end'];  
                    $params_disponibilidad['color_disponibilidad']        = $value['color'];
                    $params_disponibilidad['dias_activos']                = json_encode($value['dias_activos']);
                    $params_disponibilidad['dias_no_activos']             = json_encode($value['dias_no_activos']);
                    $response_disponibilidad = $this->disponibilidad_model->add_disponibilidad($params_disponibilidad);
                }
            }
        }

        $jsonOferta = trim($data_oferta); 
        if ( !empty($jsonOferta) ) {
            $jsonOferta = json_decode($jsonOferta,true);
            foreach ($jsonOferta as $key => $value) {
                if ( !is_numeric($value['id']) ) {
                    $params_oferta['id_producto']         = $id_producto;
                    $params_oferta['valor_oferta']        = $value['descuento'];
                    $params_oferta['tipo_oferta']         = $value['tipo_descuento'];
                    $params_oferta['fecha_inicio']        = $value['start'];
                    $params_oferta['fecha_fin']           = $value['end'];
                    $params_oferta['color_oferta']        = $value['color'];
                    $params_oferta['descripcion_oferta']  = $value['title'];
                    $response_oferta = $this->oferta_model->add_oferta($params_oferta);
                }
            }
        }

        $jsonBloqueo = trim($data_bloqueo);
        if ( !empty($jsonBloqueo) ) {
            $jsonBloqueo = json_decode($jsonBloqueo,true);
            foreach ($jsonBloqueo as $key => $value) {
                if ( !is_numeric($value['id']) ) {
                    $params_bloqueo['id_producto']          = $id_producto;
                    $params_bloqueo['descripcion_bloqueo']  = $value['title'];
                    $params_bloqueo['fecha_inicio']         = $value['start'];
                    $params_bloqueo['fecha_fin']            = $value['end'];
                    $params_bloqueo['color_bloqueo']        = $value['color'];
                    $response_bloqueo = $this->bloqueo_model->add_bloqueo($params_bloqueo);
                }
            }
        }

        if ( $response_oferta != 0 ) {
            $data['disponibilidad'] = 'Información de Disponibilidad Actualizado Correctamente.';
        }else{
            $data['disponibilidad'] = 'la Disponibilidad no se ha podido actualizar.';
        }
        if ( $response_oferta != 0 ) {
            $data['bloqueo'] = 'Información de Bloqueo Actualizado Correctamente.';
        }else{
            $data['bloqueo'] = 'Información de Bloqueo no se ha podido actualizar.';
        }
        if ( $response_oferta != 0 ) {
            $data['oferta'] = 'Información de Oferta Actualizado Correctamente.';
        }else{
            $data['oferta'] = 'Información de Oferta no se ha podido actualizar.';
        }   
        echo json_encode($data);
    }
}
