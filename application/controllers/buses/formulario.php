<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Formulario extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('buses/formulario_model','Formulario_model');
        $this->load->model('buses/idioma_model','Idioma_model');
    } 

    function index(){
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('idioma/index?');
        $config['total_rows'] = $this->Idioma_model->get_all_idiomas_count();

        $this->pagination->initialize($config);

        $data['idiomas'] = $this->Idioma_model->get_all_idiomas($params);
        $data['formularios'] = $this->Formulario_model->get_formulariosIdioma("es");
        $data['_view'] = 'buses/formulario/index';
        $this->load->view('buses/layouts/main',$data);
    }

    function add(){
    	$data['idiomas'] = $this->Idioma_model->get_select_all_idiomas();
        $data['categoria_campo'] = $this->Formulario_model->get_categoriaCampo("es");
        
        $this->load->library('form_validation');

		$this->form_validation->set_rules('categoria_campo','Categoria Campo','required');
		$this->form_validation->set_rules('nombre_campo_es','Nombre Campo','required');
		
		if($this->form_validation->run()){   
            $id_codigo_categoria_formulario = $this->Formulario_model->add_codigoCategoriaFormulario();
            foreach ($data['idiomas'] as $key => $value) {
            	$nombre_campo_formulario = $this->input->post( 'nombre_campo_'.mb_strtolower($value["codigo"]) );
	            $name_campo_formulario = $this->input->post( 'nombre_campo_es' );
	            $params = array(
					'nombre_campo_formulario' => mb_strtoupper($nombre_campo_formulario),
					'name_campo_formulario'   => mb_strtolower(str_replace(' ', '_', $name_campo_formulario)).'_'.date('Ymd_his'),
					'tipo_campo_formulario'	  => 'text',
					'id_idioma'				  => $value['id_idioma'],
					'id_categoria_formulario' => $this->input->post('categoria_campo'),
					'id_codigo_categoria_formulario'	=> $id_codigo_categoria_formulario,
	            );
	            $formulario_id = $this->Formulario_model->add_formularioCampo($params);
            }
            redirect('buses/formulario/index');
        }else{            
            $data['_view'] = 'buses/formulario/add';
            $this->load->view('buses/layouts/main',$data);
        }
    }

    function edit($id_campo_formulario,$namecampo = null ){
        $data['idiomas'] = $this->Idioma_model->get_select_all_idiomas();
        $data['categoria_campo'] = $this->Formulario_model->get_categoriaCampo("es");
        $data['campo_texto'] = $this->Formulario_model->get_campoTexto($namecampo);
        
        if(isset($data['campo_texto'][0]['id_campo_formulario'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('categoria_campo','Categoria Campo','required');
			$this->form_validation->set_rules('nombre_campo_es','Nombre Campo','required');
		
			if($this->form_validation->run()){   
                foreach ($data['idiomas'] as $key => $value) {
	            	$nombre_campo_formulario = $this->input->post( 'nombre_campo_'.mb_strtolower($value["codigo"]) );
		            $name_campo_formulario = $this->input->post( 'nombre_campo_es' );
		            $params = array(
						'nombre_campo_formulario' => mb_strtoupper($nombre_campo_formulario),
						'name_campo_formulario'   => mb_strtolower(str_replace(' ', '_', $name_campo_formulario)).'_'.date('Ymd_his'),
						'tipo_campo_formulario'	  => 'text',
						'id_idioma'				  => $value['id_idioma'],
						'id_categoria_formulario' => $this->input->post('categoria_campo'),
		            );
		            $id_campo_formulario = $this->input->post('id_nombre_campo_'.mb_strtolower($value['codigo']) );	
		            if ($id_campo_formulario) {
    	                $this->Formulario_model->update_campoTexto($id_campo_formulario,$params);	
		            }else{
		            	$params2 = array(
							'nombre_campo_formulario' => mb_strtoupper($nombre_campo_formulario),
							'name_campo_formulario'   => mb_strtolower(str_replace(' ', '_', $name_campo_formulario)).'_'.date('Ymd_his'),
							'tipo_campo_formulario'	  => 'text',
							'id_idioma'				  => $value['id_idioma'],
							'id_categoria_formulario' => $this->input->post('categoria_campo'),
							'id_codigo_categoria_formulario'	=> $this->input->post('id_codigo_campo_formulario'),
			            );	
		            	$formulario_id = $this->Formulario_model->add_formularioCampo($params2);	
		            }	            	
	            }            
                redirect('buses/formulario/index');
            }else{
                $data['_view'] = 'buses/formulario/edit';
                $this->load->view('buses/layouts/main',$data);
            }
        }else{
            show_error('The text field you are trying to edit does not exist.');
        }
    }	

    function remove($id_formulario,$namecampo){
    	$data = [];
        $campo_formulario = $this->Formulario_model->get_formulario($id_formulario);
        // check if the idioma exists before trying to delete it
        if(isset($campo_formulario['id_campo_formulario'])){
            $this->Formulario_model->delete_formularioCampoTexto($namecampo);
            $data['response'] = true;
            //redirect('buses/idioma/index');
        }else{
            $data['response'] = false;
            //show_error('The idioma you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }

}