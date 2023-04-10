<?php
class Notificacion extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/notificacion_model');
    } 

    function index(){
        //$data['notificacions'] = $this->notificacion_model->get_all_notificaciones();
        //$this->load->view('admin/notificacion',$data);
    }


    function add(){ 
        
        $this->load->library('form_validation');

        $this->form_validation->set_rules('f_inicio','Fecha Inicio','required');
        
        if($this->form_validation->run()){   
            $data = array();
            $params = array(
                'fecha_inicio'  => date_format(date_create(trim($this->input->post('f_inicio'))), 'Y-m-d H:i:s' ),
                'fecha_fin'     => date_format(date_create(trim($this->input->post('f_fin'))), 'Y-m-d H:i:s' ),
                'notificacion'  => trim($this->input->post('descripcion')),
                'id_servicio'   => trim($this->input->post('id')),
            );
      
            $notificacion_id = $this->notificacion_model->add_notificacion($params);
            echo json_encode(array(
                "response" => "OK",
                "message"  => "La notificacion se ha guardado correctamente..!",
                "id"       => $notificacion_id,
            ));    
        }else{
            echo json_encode(array(
                "response" => "ERROR",
                "message"  => "Error validando datos, Por favor complete todos los ampos requeridos..!",
                "id"       => "0",
            ));
        }
    }   


    function edit($id_notificacion){   
        /*
        if ( $this->session->userdata('id_usuarios') != 1 || $this->session->userdata('id_usuarios') != '1' ) {
            redirect("admin/notificacion");
        }
        
        $data['notificacion'] = $this->notificacion_model->get_notificacion($id_notificacion);
        
        if(isset($data['notificacion']['id_notificacion'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('codigo','Codigo','max_length[2]|min_length[2]');
		
			if($this->form_validation->run()){   
                $params = array(
					'pais' => $this->input->post('pais'),
					'codigo' => $this->input->post('codigo'),
                );

                $this->notificacion_model->update_notificacion($id_notificacion,$params);            
                redirect('admin/notificacion');
            }else{
                $this->load->view('admin/notificacion-edit',$data);
            }
        }else{
            $data['message'] = 'El ID del notificacion que has intentado editar no existe..!'; 
            redirect('admin/notificacion',$data);
        }
        */
    } 


    function remove(){
        $id_servicio = trim( $this->input->post('id_servicio') );
        $id_notificacion = trim( $this->input->post('id_notificacion') );
        $notificacion = $this->notificacion_model->get_notificacion($id_notificacion);
        if(isset($notificacion['id_notificacion'])){
            $this->notificacion_model->delete_notificacion($id_servicio,$id_notificacion);
            echo json_encode(array(
                "response" => "OK",
                "message"  => "Eliminado correctamente..!",
            ));
        }else{
            echo json_encode(array(
                "response" => "ERROR",
                "message"  => "No se ha podido eliminar..!",
            ));
        }
    }

    function list_notifications(){
        $data = array();
        $response = $this->notificacion_model->get_notificaciones_servicio( trim($this->input->post('id')));
        foreach ($response as $key => $value) {
            $data[] = array(
                'fecha_inicio'  => date_format( date_create($value['fecha_inicio']), 'd-M-Y'),
                'fecha_fin'     => date_format( date_create($value['fecha_fin']), 'd-M-Y'),
                'id_servicio'   => $value['id_servicio'],
                'id_notificacion'=> $value['id_notificacion'],
                'notificacion'  => $value['notificacion'],
            );
        }
        echo json_encode( $data );
    }
}
