<?php
class Codigoservicio extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/codigoservicio_model');
    } 

    function index(){
        //$data['idiomas'] = $this->idioma_model->get_all_idiomas();
        //$this->load->view('admin/idioma/index',$data);
    }


    function add(){   
        /*
        $this->load->library('form_validation');

        $this->form_validation->set_rules('codigo','Codigo','max_length[2]|min_length[2]');
        
        if($this->form_validation->run()){   
            $params = array(
                'pais' => $this->input->post('pais'),
                'codigo' => $this->input->post('codigo'),
            );
            
            $idioma_id = $this->Codigoservicio_model->add_idioma($params);
            redirect('admin/idioma/index');
        }else{
            $this->load->view('admin/idioma/add');
        }*/
    }   


    function edit($id_idioma){   
        /*
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
                redirect('idioma/index');
            }else{
                $this->load->view('admin/idioma/edit',$data);
            }
        }else{
            show_error('The idioma you are trying to edit does not exist.');
        }
        */
    } 

    function remove($id_codigo_servicio){
        $codigo_servicio = $this->codigoservicio_model->get_codigoservicio($id_codigo_servicio);
        $data = array();
        if(isset($codigo_servicio['id_codigo_servicio'])){
            $delete_response  =  $this->codigoservicio_model->delete_codigoservicio($id_codigo_servicio);
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
            //redirect('admin/idioma/index');
        }else{
            $data = array(
                'response'  => 'ERROR',
                'data'      => 'El registro que has intentado eliminar no existe..!',
            );
            //show_error('The idioma you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }

    function codigo(){
        /*
        $idioma = $this->idioma_model->get_idioma($this->input->post('id'));
        $data = array();
        if ( isset($idioma['id_idioma']) ) {
            $data = array(
                'response'  => 'OK',
                'data'      => $idioma,
            );
        }else{
            $data = array(
                'response'  => 'ERROR',
                'data'      => '',
            );
        }
        echo json_encode($data);
        */
    }    
}
