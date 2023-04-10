<?php

class Destinos extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/destinos_model');
        $this->load->model('admin/idioma_model');
        $this->load->model('admin/galeria_model');
        $this->load->model('admin/producto');
    } 

    function index(){
        //$data['destinos'] = $this->destinos_model->get_all_destinos();
        $data['destinos'] = $this->destinos_model->get_destino_idioma('es');
        $this->load->view('admin/destino',$data);
    }

    function add(){  
        $data['idiomas'] = $this->idioma_model->get_all_idiomas(); 
        $this->load->library('form_validation');
		$this->form_validation->set_rules('txt_nombre_destino_es','Nombre Destino','required');
		$this->form_validation->set_rules('txt_uri_destino_es','Ubicación Actividades','required');

		if($this->form_validation->run()){   
            $paramsCodigoDestino = array(
                'codigo_destino' => 'INCALAKE-'.date('Ymd.Him'),
                'id_usuarios' => $this->session->userdata('id_usuarios'),
            );
            $idCodigoDestino = $this->destinos_model->add_codigoDestino($paramsCodigoDestino);
            
            $imagenSlider = $this->input->post('txt_id_imagen_slider');
            $imagenNormal = $this->input->post('txt_id_imagen_normal');
            
            foreach ($data['idiomas'] as $key => $value) {
                $descripcion_destino = $this->input->post('txt_nombre_destino_'.strtolower($value['codigo']));
                $nombre_destino = $this->input->post('txt_uri_destino_'.strtolower($value['codigo']));
                $idIdioma       = $this->input->post('txt_idioma_'.strtolower($value['codigo']));
                $array_nombre_destino = explode(",",trim($nombre_destino));

                $paramsDestino = array(
                    'descripcion_destino'   => $descripcion_destino,
                    'uri_destino'           => $this->uri_amigable(strtolower($array_nombre_destino[0])),
                    'nombre_destino'        => $nombre_destino,
                    'imagen_slider'         => $imagenSlider,
                    'imagen_normal'         => $imagenNormal,
                    'id_codigo_destino'     => $idCodigoDestino,
                    'id_idioma'             => trim($idIdioma),
                );

                $idDestino = $this->destinos_model->add_destino($paramsDestino);
            }

            //$params = array(
			//	'nombre_destino' => $this->input->post('nombre_destino'),
            //);
            //$destino_id = $this->Categoria_model->add_destino($params);
            redirect('admin/destinos/');
        }else{            
            
            $this->load->view('admin/destino-add',$data);
        }
    }  

    function edit($id_destino,$id_codigo_destino){   
        // check if the destino exists before trying to edit it
        $data['idiomas'] = $this->idioma_model->get_all_idiomas();
        $data['destino'] = $this->destinos_model->get_traducciones($id_destino,$id_codigo_destino);
        
        if(isset($data['destino'][0]['id_codigo_destino'])){
            $this->load->library('form_validation');
			$this->form_validation->set_rules('txt_nombre_destino_es','Nombre Destino','required');
            $this->form_validation->set_rules('txt_uri_destino_es','Ubicación Actividades','required');
		
			if($this->form_validation->run()){   
                $imagenSlider = $this->input->post('txt_id_imagen_slider');
                $imagenNormal = $this->input->post('txt_id_imagen_normal');
                foreach ($data['idiomas'] as $key => $value) {
                    $descripcion_destino = $this->input->post('txt_nombre_destino_'.strtolower($value['codigo']));
                    $nombre_destino = $this->input->post('txt_uri_destino_'.strtolower($value['codigo']));
                    $idIdioma       = $this->input->post('txt_idioma_'.strtolower($value['codigo']));
                    $idDestino      = $this->input->post('txt_id_destino_'.strtolower($value['codigo']));
                    $array_nombre_destino = explode(",",trim($nombre_destino));

                    $paramsDestino = array(
                        'descripcion_destino'   => $descripcion_destino,
                        'uri_destino'           => $this->uri_amigable(strtolower($array_nombre_destino[0])),
                        'nombre_destino'        => $nombre_destino,
                        'imagen_slider'         => $imagenSlider,
                        'imagen_normal'         => $imagenNormal,
                        'id_codigo_destino'     => $id_codigo_destino,
                        'id_idioma'             => trim($idIdioma),
                    );
                    $this->destinos_model->update_destino($idDestino,$paramsDestino);
                }
                redirect('admin/destinos/');
            }else{
                $imagen_slider = $this->galeria_model->get_galeria($data['destino'][0]['imagen_slider']);
                $imagen_normal = $this->galeria_model->get_galeria($data['destino'][0]['imagen_normal']);

                $data['imagen_slider'][] = array('id_imagen' => $data['destino'][0]['imagen_slider'],'data'=>$imagen_slider );
                $data['imagen_normal'][] = array('id_imagen' => $data['destino'][0]['imagen_normal'],'data'=>$imagen_normal );
                $this->load->view('admin/destino-edit',$data);
            }
        }else{
            redirect('admin/destinos/');
        }
    } 

    function remove($id_destino){
        $destino = $this->Categoria_model->get_destino($id_destino);

        // check if the destino exists before trying to delete it
        if(isset($destino['id_destino'])){
            $this->Categoria_model->delete_destino($id_destino);
            redirect('destino/index');
        }else{
            show_error('The destino you are trying to delete does not exist.');
        }
    } 

    private function uri_amigable($token) {
        $separador = '-';//ejemplo utilizado con guión medio
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        //Quitamos todos los posibles acentos
        $url = strtr(utf8_decode($token), utf8_decode($originales), $modificadas);
        //Convertimos la cadena a minusculas
        $url = utf8_encode(strtolower($url));
        //Quitamos los saltos de linea y cuanquier caracter especial
        $buscar = array(' ', '&amp;', '\r\n', '\n', '+');
        $url = str_replace ($buscar, $separador, $url);
        $buscar = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;[^&gt;]*&gt;/');
        $reemplazar = array('', $separador, '');
        $url = preg_replace ($buscar, $reemplazar, $url);
        return $url;
    }

    function remove_codigo_destino(){
        $id = $this->input->post('id');
        $idcodigo = $this->input->post('idcodigo');
        $codigo_destino = $this->destinos_model->get_destino($id);
        $data=array();
        // check if the categoria exists before trying to delete it
        if(isset($codigo_destino['id_codigo_destino'])){
            $this->destinos_model->delete_codigodestino($id,$idcodigo);
            // redirect('admin/categoria/index');
            $data=array('response'=>'OK');
        }else{
            // show_error('The categoria you are trying to delete does not exist.');
            $data=array('response'=>'ERROR');

        }
        echo json_encode($data);

    }

    //Retorna datos json al modal que está en la vista admin/destinos
    function traducciones(){
        $idDestino = $this->input->post('id');
        $idCodigoDestino = $this->input->post('idcodigo');
        $data = $this->destinos_model->get_traducciones($idDestino,$idCodigoDestino);
        echo json_encode($data);
    }

    function actividades($idDestino,$idCodigoDestino){
        $data['destino'] = $this->destinos_model->get_destino($idDestino);
        $data['actividades'] = $this->producto->get_actividades_asociadas_destino("es",$idDestino,$idCodigoDestino);
        $this->load->view('admin/destino-actividad',$data);
    }

    function add_destino_producto(){
        $data = array();
        $iddestino = $this->input->post('iddestino');
        $idactividad   = $this->input->post('idactividad'); 
        $data['destino_producto'] = $this->destinos_model->get_destino_producto($iddestino,$idactividad);
        
        if( isset($data['destino_producto']['id_producto']) && isset($data['destino_producto']['id_destino']) ){
            $data = array(
                'response' => 'ERROR',
                'data'     => 'Registro ya existe..!', 
            );
        }else{
            $response = $this->destinos_model->add_destino_producto(array('id_producto'=>$idactividad,'id_destino'=>$iddestino) );
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

    function delete_destino_producto(){
        $data = array();
        $iddestino = $this->input->post('iddestino');
        $idactividad   = $this->input->post('idactividad'); 
        $data['destino_producto'] = $this->destinos_model->get_destino_producto($iddestino,$idactividad);
        
        if( isset($data['destino_producto']['id_producto']) && isset($data['destino_producto']['id_destino']) ){
            $response = $this->destinos_model->delete_destino_producto( $iddestino,$idactividad );
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

}
