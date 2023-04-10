<?php
class Operador extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/operador_model');
    } 

    function index(){
        /*
        $idProducto         = $this->input->post('idProducto');
        $idCodigoProducto   = $this->input->post('idCodigoProducto');

        $response = $this->operador_model->get_operador( trim(strip_tags(stripcslashes($idProducto))), trim(strip_tags(stripcslashes($idCodigoProducto))) );
        echo json_encode($response);
        */
    }


    function add(){ 
        if ( $this->session->userdata('id_usuarios') != 1 || $this->session->userdata('id_usuarios') != '1' ) {
            redirect("admin/idioma");
        }  
        $this->load->library('form_validation');

        $this->form_validation->set_rules('codigo','Codigo','max_length[2]|min_length[2]');
        
        if($this->form_validation->run()){   
            $data = array();
            $params = array(
                'pais' => strtoupper($this->input->post('pais')),
                'codigo' => strtoupper($this->input->post('codigo')),
                'id_usuarios' => $this->session->userdata('id_usuarios'),
            );
            if ( !$this->idioma_model->descartar_duplicidad( strtoupper($this->input->post('codigo') ) ) ) {
                $idioma_id = $this->idioma_model->add_idioma($params);
                //redirect('admin/idioma');
                redirect('admin/idioma');    
            }else{
                //$idioma_id = $this->idioma_model->add_idioma($params);
                $data['data'] = 'El idioma que quieres registrar ya existe..!';
                $this->load->view('admin/idioma-add',$data);
            }
        }else{
            $this->load->view('admin/idioma-add');
        }
    }   

    function edit($id_idioma){   
        if ( $this->session->userdata('id_usuarios') != 1 || $this->session->userdata('id_usuarios') != '1' ) {
            redirect("admin/idioma");
        }
        // check if the idioma exists before trying to edit it
        $data['idioma'] = $this->idioma_model->get_idioma($id_idioma);
        
        if(isset($data['idioma']['id_idioma'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('codigo','Codigo','max_length[2]|min_length[2]');
		
			if($this->form_validation->run()){   
                $params = array(
					'pais' => $this->input->post('pais'),
					'codigo' => $this->input->post('codigo'),
                );

                $this->idioma_model->update_idioma($id_idioma,$params);            
                redirect('admin/idioma');
            }else{
                $this->load->view('admin/idioma-edit',$data);
            }
        }else{
            $data['message'] = 'El ID del idioma que has intentado editar no existe..!'; 
            redirect('admin/idioma',$data);
            //show_error('The idioma you are trying to edit does not exist.');
        }
    } 


    function remove($id_idioma){
        $idioma = $this->idioma_model->get_idioma($id_idioma);

        // check if the idioma exists before trying to delete it
        if(isset($idioma['id_idioma'])){
            $this->idioma_model->delete_idioma($id_idioma);
            redirect('admin/idioma/index');
        }else{
            show_error('The idioma you are trying to delete does not exist.');
        }
    }

    function operadores(){
        $idProducto         = $this->input->post('idProducto');
        $idCodigoProducto   = $this->input->post('idCodigoProducto');

        $response = $this->operador_model->get_operador( trim(strip_tags(stripcslashes($idProducto))), trim(strip_tags(stripcslashes($idCodigoProducto))) );
        echo json_encode($response);
    }

    function addAjax(){
        $idProducto         = $this->input->post('id_producto');
        $idCodigoProducto   = $this->input->post('id_codigo_producto');
        $nombreOperador     = $this->input->post('nombre_operador');
        $emailOperador      = $this->input->post('email_operador');
        $clonable           = $this->input->post('clonable');

        $operadorActivo     = $this->operador_model->get_operador_activo( trim(strip_tags(stripcslashes($idProducto))), trim(strip_tags(stripcslashes($idCodigoProducto))) );
        $activo             = !empty($operadorActivo)?0:1;
        $data = [];
        if ( $clonable === true || $clonable === 'true' ) {
            // Setear a todo el grupo id_codigo_producto
            $response = $this->operador_model->get_operador( trim(strip_tags(stripcslashes($idProducto))), trim(strip_tags(stripcslashes($idCodigoProducto))) );
            foreach ($response as $key => $value) {
                $params = array(
                    "nombre_operador"       => $nombreOperador,
                    "email_operador"        => $emailOperador,
                    "id_codigo_producto"    => $value['id_codigo_producto'],
                    "id_producto"           => $value['id_producto'],  
                    "activo"                => $activo,
                );
                $this->operador_model->add_operador($params);                    
            }
            $data['response'] = 'success';
            $data['message']  = 'Datos del operador guardados con éxito..!';
        }else{
            //Setear solo el id_producto
            $params = array(
                "nombre_operador"       => $nombreOperador,
                "email_operador"        => $emailOperador,
                "id_codigo_producto"    => $idCodigoProducto,
                "id_producto"           => $idProducto, 
                "activo"                => $activo, 
            );
            $this->operador_model->add_operador($params);
            $data['response'] = 'success';
            $data['message']  = 'Datos del operador guardados con éxito..!';
        }
        echo json_encode($data);
    }

    function updatecb(){
        $idProducto         = $this->input->post('idProducto');
        $idCodigoProducto   = $this->input->post('idCodigoProducto');
        $idOperador         = $this->input->post('idOperador');
        $activado           = $this->input->post('activado');
        
        $this->operador_model->updateAjax($idProducto,$idCodigoProducto,$idOperador,$activado);
        echo json_encode(
            array(
                "response" => "success",
                "message"  => "Actualizado Correctamente..!",
            )
        );
    }
    function eliminar(){
        $data = [];
        $idProducto         = $this->input->post('idProducto');
        $idCodigoProducto   = $this->input->post('idCodigoProducto');
        $idOperador         = $this->input->post('idOperador');
        $response = $this->operador_model->delete_operador($idProducto,$idCodigoProducto,$idOperador);
        if($response){
            $data["response"] = "success";
            $data["message"]  = $response;
        } else{
            $data["response"] = "error";
            $data["message"]  = "Error Eliminando registro..!";
        }
        echo json_encode($data);
    }
}
