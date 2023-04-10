<?php
class Idioma extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/idioma_model');
    } 

    function index(){
        $data['idiomas'] = $this->idioma_model->get_all_idiomas();

        $this->load->view('admin/idioma',$data);
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

    function codigo(){
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
    }

    function duplicidad(){
        $response = $this->idioma_model->descartar_duplicidad( strtoupper($this->input->post('codigo')) );
        $data = array();
        if ($response) {
            $data = array(
                'response' => 'ERROR',
                'message'  => 'El idioma ya está registrado..!'
            );
        }else{
            $data = array(
                'response' => 'OK',
                'message'  => 'El idioma a un no está registrado..!'
            );            
        }
        echo json_encode($data);
    }
}
