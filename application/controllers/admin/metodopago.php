<?php
class Metodopago extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/metodopago_model');
    } 

    function index(){
        $data['metodopago'] = $this->metodopago_model->get_all_metodopagos();
        $this->load->view('admin/metodopago',$data);
    }


    function add(){   
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txt_nombre_metodopago','Nombre Método de Pago','required');
        
        if($this->form_validation->run()){   
            $params = array(
                'nombre_metodo_pago' => strtoupper($this->input->post('txt_nombre_metodopago')),
                'descripcion_metodo_pago' => strtoupper($this->input->post('txtr_descripcion_metodopago')),
            );
            
            $metodopago_id = $this->metodopago_model->add_metodopago($params);
            //redirect('admin/metodopago');
            redirect('admin/metodopago');    
        
        }else{
            $this->load->view('admin/metodopago-add');
        }
    }   


    function edit($id_metodopago){   
        // check if the metodopago exists before trying to edit it
        $data['metodopago'] = $this->metodopago_model->get_metodopago($id_metodopago);
        
        if(isset($data['metodopago']['id_metodo_pago'])){
            $this->load->library('form_validation');

            $this->form_validation->set_rules('txt_nombre_metodopago','Nombre Método de Pago','required');
		
			if($this->form_validation->run()){   
                $params = array(
                    'nombre_metodo_pago' => strtoupper($this->input->post('txt_nombre_metodopago')),
                    'descripcion_metodo_pago' => strtoupper($this->input->post('txtr_descripcion_metodopago')),
                );

                $this->metodopago_model->update_metodopago($id_metodopago,$params);            
                redirect('admin/metodopago');
            }else{
                $this->load->view('admin/metodopago-edit',$data);
            }
        }else{
            show_error('El Método de pago que quieres editar no existe..!');
        }
    } 


    function remove($id_metodopago){
        $metodopago = $this->metodopago_model->get_metodopago($id_metodopago);
        // check if the metodopago exists before trying to delete it
        if(isset($metodopago['id_metodo_pago'])){
            $this->metodopago_model->delete_metodopago($id_metodopago);
            //redirect('admin/metodopago/index');
            return true;
        }else{
            //show_error('The metodopago you are trying to delete does not exist.');
            return false;
        }
    }
    // Actualizar/Update Método de Pago
    function actualizar(){
        $data = [];
        $idProducto         = $this->input->post('idProducto');
        $idCodigoProducto   = $this->input->post('idCodigoProducto');
        $metodoPago         = $this->input->post('metodoPago');
        $clonable           = $this->input->post('clonable');
        $params     = array(
            "metodo_pago" => $metodoPago,            
        );
        $response = null;
        if ($clonable === true || $clonable === 'true') { // Activamos el método de pago para todos los idiomas del servicio
            $response = $this->metodopago_model->actualizar_metodopago_por_codigo_producto($idCodigoProducto,$params);
        }else{ //Activamos el metodo de pago solo para el idioma y para sus traducciones
            $response = $this->metodopago_model->actualizar_metodopago($idProducto,$params);
        }
        if ($response  === true ) {
            $data['response'] = 'success';
            $data['mesagge']  = 'Registro actualizado..!';
        }else{
            $data['response'] = 'error';
            $data['mesagge']  = 'Error actualizando registro';
        }
        echo  json_encode($data);
    }

    function metodo(){
        $idProducto = $this->input->post('idProducto');
        $response = $this->metodopago_model->get_metodo( trim($idProducto) );
        echo json_encode($response);
    }
}
