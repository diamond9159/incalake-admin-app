<?php
class Categoria extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/categoria_model');
        $this->load->model('admin/codigocategoria_model');
        $this->load->model('admin/categoria_producto_model');
        $this->load->model('admin/idioma_model');
    } 

    function index(){
        //$data['categorias'] = $this->categoria_model->get_all_categorias();

        /******************* CATEGORIAS AGRUPADAS *********************/
        $data['data'] =  $this->categoria_model->get_all_categorias_agrupadas();
        $this->load->view('admin/categoria',$data);
    }


    function add($code=0){   
        if ( $this->session->userdata('id_usuarios') != 1 || $this->session->userdata('id_usuarios') != '1' ) {
            redirect("admin/categoria");
        }
        $codigo_categoria = $code;
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txt_nombre_categoria','Nombre Categoria','required');
        
        if($this->form_validation->run()){  
            if ( $codigo_categoria === 0 || $codigo_categoria === '0' ) {
                $nombre_codigo_categoria = $_POST['txt_nombre_categoria'][0];
                $codigo_categoria = $this->codigocategoria_model->add_codigocategoria(
                    array('codigo_categoria' => str_replace(" ","-",strtolower($nombre_codigo_categoria )),'imagen_categoria'=>$_POST['img_destacada']) 
                );
            }
            /*
            $params = array(
                'nombre_categoria' => $this->input->post('txt_nombre_categoria'),
                'descripcion_categoria' => $this->input->post('txt_descripcion_categoria'),
                'id_idioma'             => $this->input->post('txt_descripcion_categoria'),
                'id_codigo_categoria'   => $codigo_categoria,
            );
            */
            foreach ($_POST['txt_nombre_categoria'] as $key => $value) {
                $categoria_id = $this->categoria_model->add_categoria(
                    array(
                        'nombre_categoria'      => trim($value),
                        'descripcion_categoria' => trim($_POST['txt_descripcion_categoria'][$key]),
                        'id_idioma'             => trim($_POST['txt_idioma'][$key]),
                        'id_codigo_categoria'   => $codigo_categoria,
                        'id_usuarios'           => $this->session->userdata('id_usuarios'),
                    )
                );
            }

            //$categoria_id = $this->categoria_model->add_categoria($params);
            redirect('admin/categoria');
        }else{
            $data['all_idiomas']      = $this->idioma_model->free_idiomas($codigo_categoria);
            $data['codigo_categoria'] = $codigo_categoria;
            $this->load->view('admin/categoria-add',$data);
        }
    }   


    function edit($id_codigo_categoria){  
        if ( $this->session->userdata('id_usuarios') != 1 || $this->session->userdata('id_usuarios') != '1' ) {
            redirect("admin/categoria");
        }   
        //$data['categoria'] = $this->categoria_model->get_categorias_agrupadas($id_codigo_categoria);
        $data['data'] = $this->categoria_model->getCategoriasAgrupadas($id_codigo_categoria);
        
        $data['codigo_categoria'] = $id_codigo_categoria;
        //if(isset($data['categoria']['id_categoria'])){
            $this->load->library('form_validation');

			$this->form_validation->set_rules('txt_nombre_categoria','Nombre Categria','required');

			if($this->form_validation->run()){   
                
                $this->codigocategoria_model->update_codigocategoria($id_codigo_categoria,array('imagen_categoria'=>$_POST['img_destacada']));
                /*
                $params = array(
					'pais' => $this->input->post('pais'),
					'codigo' => $this->input->post('codigo'),
                );
                */
                foreach ($_POST['txt_nombre_categoria'] as $key => $value) {
                    $categoria_id = $this->categoria_model->update_categoria( $id_codigo_categoria,trim($_POST['txt_id_categoria'][$key]),
                        array(
                            'nombre_categoria'      => trim($value),
                            'descripcion_categoria' => trim($_POST['txt_descripcion_categoria'][$key]),
                            'id_idioma'             => trim($_POST['txt_idioma'][$key]),
                            'id_codigo_categoria'   => $id_codigo_categoria,
                        )
                    );
                }
                //$this->categoria_model->update_categoria($id_categoria,$params);            
                redirect('admin/categoria');
            }else{          
                $this->load->view('admin/categoria-edit',$data);
            }
        /*
        }else{
            show_error('The categoria you are trying to edit does not exist.');
        }
        */
    } 


    function remove($id_categoria){
        if ( $this->session->userdata('id_usuarios') != 1 || $this->session->userdata('id_usuarios') != '1' ) {
            redirect("admin/categoria");
        }
        $categoria = $this->categoria_model->get_categoria($id_categoria);

        // check if the categoria exists before trying to delete it
        if(isset($categoria['id_categoria'])){
            $this->categoria_model->delete_categoria($id_categoria);
            redirect('admin/categoria/index');
        }else{
            show_error('The categoria you are trying to delete does not exist.');
        }
    }
    function remove_codigo_categoria($id_categoria){
        $codigo_categoria = $this->codigocategoria_model->get_codigocategoria($id_categoria);
        $data=array();
        // check if the categoria exists before trying to delete it
        if(isset($codigo_categoria['id_codigo_categoria'])){
            $this->codigocategoria_model->delete_codigocategoria($id_categoria);
            // redirect('admin/categoria/index');
            $data=array('response'=>'OK');
        }else{
            // show_error('The categoria you are trying to delete does not exist.');
            $data=array('response'=>'ERROR');

        }
        echo json_encode($data);
    }

    function codigo(){
        $categoria = $this->categoria_model->get_categoria($this->input->post('id'));
        $data = array();
        if ( isset($categoria['id_categoria']) ) {
            $data = array(
                'response'  => 'OK',
                'data'      => $categoria,
            );
        }else{
            $data = array(
                'response'  => 'ERROR',
                'data'      => '',
            );
        }
        echo json_encode($data);
    }
    
    function categorias_agrupadas(){
        //$data['data'] =  $this->categoria_model->get_all_categorias_agrupadas();
        //echo json_encode($data);
    }   

    function get_categoria_json(){
        $data = array();
        $data = $this->categoria_model->get_categoria_json($this->input->post('id'),$this->input->post('language'));
        echo json_encode($data);
    }

    function add_categoria_producto(){
        $data = array();
        $id_categoria = $this->input->post('id_categoria');
        $id_paquete   = $this->input->post('id_paquete'); 
        $data['categoria_producto'] = $this->categoria_producto_model->get_categoria_producto($id_categoria,$id_paquete);
        
        if( isset($data['categoria_producto']['producto_id_producto']) && isset($data['categoria_producto']['categoria_id_categoria']) ){
            $data = array(
                'response' => 'ERROR',
                'data'     => 'Registro ya existe..!', 
            );
        }else{
            $response = $this->categoria_producto_model->add_categoria_producto(array('producto_id_producto'=>$id_paquete,'categoria_id_categoria'=>$id_categoria) );
            if ( $response ) {
                $data = array(
                    'response' => 'OK',
                    'data'     => 'Registrado correctamente..!', 
                );
            }else{
                $data = array(
                    'response' => 'ERROR',
                    'data'     => 'No se ha podido registrar..!', 
                );
            }                 
        }
        echo json_encode($data);
    }

    function delete_categoria_producto(){
        $data = array();
        $id_categoria = $this->input->post('id_categoria');
        $id_paquete   = $this->input->post('id_paquete'); 
        $data['categoria_producto'] = $this->categoria_producto_model->get_categoria_producto($id_categoria,$id_paquete);
        
        if( isset($data['categoria_producto']['producto_id_producto']) && isset($data['categoria_producto']['categoria_id_categoria']) ){
            $response = $this->categoria_producto_model->delete_categoria_producto( $id_paquete,$id_categoria );
            if ( $response ) {
                $data = array(
                    'response' => 'OK',
                    'data'     => 'Registro eliminado correctamente..!', 
                );
            }else{
                $data = array(
                    'response' => 'ERROR',
                    'data'     => 'No se ha podido eliminar registro..!', 
                );
            }       
        }else{
            $data = array(
                'response' => 'ERROR',
                'data'     => 'Registro no existe..!', 
            );            
        }
        echo json_encode($data);
    }

    function translate(){
        $data['data'] =  $this->categoria_model->get_all_categorias_agrupadas();
        $this->load->library('form_validation');
        //$this->load->view('admin/categoria-translate',$data);

        $this->form_validation->set_rules('txt_categoria_traduccion','Nombre Categoria','required');

        if($this->form_validation->run()){   
            foreach ($_POST['txt_categoria_traduccion'] as $key => $value) {
                $categoria_id = $this->categoria_model->add_translate_categorias( 
                    array(
                        'nombre_categoria'      => trim($value),
                        'descripcion_categoria' => trim($_POST['txt_categoria_traduccion'][$key]),
                        'id_idioma'             => trim($_POST['txt_id_idioma'][$key]),
                        'id_codigo_categoria'   => trim($_POST['txt_id_codigo_categoria'][$key]),
                    )
                );
            }
            //$this->categoria_model->update_categoria($id_categoria,$params);            
            redirect('admin/categoria');
        }else{          
            $this->load->view('admin/categoria-translate',$data);
        }
    }

    
    function categoria_asociar_producto(){
        $data = array();
        $id_producto    = $this->input->post('id_producto');
        $id_categoria   = $this->input->post('id_categoria');
        $estado         = $this->input->post('estado');
        $response = $this->categoria_model->asociar_producto_categoria($id_producto,$id_categoria,$estado);
        if ( $response ) {
            $data['response'] = 'OK';
            $data['message']  = 'Operación completada satisfactoriamente.';
        }else{
            $data['response'] = 'ERROR';
            $data['message']  = 'La operación no se ha podido completar.';
        }
        echo json_encode($data);
    }


    //Muestra una categoria con todas sus traducciones
    function categoriasAgrupadas(){
        $data = array();
        $id = strip_tags( xss_clean( trim( $this->input->post('id') ) ) );
        $data = $this->categoria_model->getCategoriasAgrupadas($id);
        echo json_encode($data);
    }
}
