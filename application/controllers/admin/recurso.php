<?php
class Recurso extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/recurso_model');
        $this->load->model('admin/producto');
        $this->load->model('admin/idioma_model');
        $this->load->model('admin/galeria_model');
    } 

    function index(){
        $data['recursos'] = array();
        $recursos = $this->recurso_model->get_all_recursos();
        $data['idiomas']  = $this->idioma_model->get_all_idiomas();
        
        if ( !empty($recursos[0]['id_recurso']) ) {
            foreach ($recursos as $key => $value) {
                $data_temp = array();
                $data_temp['id_recurso']          = $value['id_recurso'];
                $data_temp['nombre_recurso']      = $value['nombre_recurso'];
                $data_temp['descripcion_recurso'] = $value['descripcion_recurso'];
                $data_temp['precio_recurso']      = $value['precio_recurso'];
                $data_temp['regalo_recurso']      = $value['regalo_recurso'];
                $data_temp['imagen']              = $this->galeria_model->get_imagen($value['id_recurso']);
                array_push($data['recursos'],$data_temp);
            }
        }
        $this->load->view('admin/recurso',$data);
    }

    function add(){   
        $data = array();
        $data['idiomas']  = $this->idioma_model->get_all_idiomas();
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txt_nombre_recurso_es','Nombre recurso','required');
        
        if($this->form_validation->run()){   
            $array_nombre_recurso      = array();
            $array_descripcion_recurso = array();
            $array_precio_recurso      = array();

            foreach ($data['idiomas'] as $key => $value) {
                $input_nombre_recurso = $this->input->post('txt_nombre_recurso_'.strtolower($value['codigo']) );
                if ( empty($input_nombre_recurso) ) {
                    $input_nombre_recurso = '';
                }
                $input_descripcion_recurso = $this->input->post('txtr_descripcion_recurso_'.strtolower($value['codigo']) );
                if ( empty($input_descripcion_recurso) ) {
                    $input_descripcion_recurso = '';
                }
                $input_precio_recurso = $this->input->post('txt_precio_recurso_'.strtolower($value['codigo']) );
                if ( empty($input_precio_recurso) ) {
                    $input_precio_recurso = 0.00;
                }
                //array_push($array_nombre_recurso,array(strtolower($value['codigo']) => $input_nombre_recurso ) );
                //array_push($array_descripcion_recurso,array(strtolower($value['codigo']) => $input_descripcion_recurso ) );
                //array_push($array_precio_recurso,array(strtolower($value['codigo']) => $input_precio_recurso ) );
                $array_nombre_recurso[ $value['codigo'] ]       =  $input_nombre_recurso ;
                $array_descripcion_recurso[ $value['codigo'] ]  =  $input_descripcion_recurso;
                $array_precio_recurso[ $value['codigo'] ]       =  $input_precio_recurso;
            }
            /*
            $params = array(
                'nombre_recurso'        => $this->input->post('txt_nombre_recurso_es'),
                'descripcion_recurso'   => $this->input->post('txtr_descripcion_recurso_es'),
                'precio_recurso'        => $this->input->post('txt_precio_recurso_es'),
                'regalo_recurso'        => $this->input->post('chckbx_regalo_recurso'),
            );
            */
            $params = array(
                'nombre_recurso'        => json_encode($array_nombre_recurso),
                'descripcion_recurso'   => json_encode($array_descripcion_recurso),
                'precio_recurso'        => json_encode($array_precio_recurso),
                'regalo_recurso'        => $this->input->post('chckbx_regalo_recurso'),
                'id_usuarios'           => $this->session->userdata('id_usuarios'),
            );
            $recurso = $this->recurso_model->add_recurso($params,$this->input->post('fl_imagen_recurso'));

            //redirect('admin/recurso');
            redirect('admin/recurso');   
        }else{
            //$data['productos'] = $this->producto->obtenerProductos();
            $this->load->view('admin/recurso-add',$data);
        }
    }   

    function edit($id_recurso){   
        $data = array();
        $data['idiomas']  = $this->idioma_model->get_all_idiomas();
        $data['recurso']  = $this->recurso_model->get_recurso($id_recurso); 
        //$data['imagen']   = $this->galeria_model->get_imagen($data['recurso']['id_recurso']); 
        //$data['productos'] = $this->producto->obtenerProductos();
        if(isset($data['recurso']['id_recurso'])){
            $data['imagen']   = $this->galeria_model->get_imagen($data['recurso']['id_recurso']); 
            $this->load->library('form_validation');

			$this->form_validation->set_rules('txt_nombre_recurso_es','Nombre recurso','required');
		
			if($this->form_validation->run()){   
                $array_nombre_recurso      = array();
                $array_descripcion_recurso = array();
                $array_precio_recurso      = array();

                foreach ($data['idiomas'] as $key => $value) {
                    $input_nombre_recurso = $this->input->post('txt_nombre_recurso_'.strtolower($value['codigo']) );
                    if ( empty($input_nombre_recurso) ) {
                        $input_nombre_recurso = '';
                    }
                    $input_descripcion_recurso = $this->input->post('txtr_descripcion_recurso_'.strtolower($value['codigo']) );
                    if ( empty($input_descripcion_recurso) ) {
                        $input_descripcion_recurso = '';
                    }
                    $input_precio_recurso = $this->input->post('txt_precio_recurso_'.strtolower($value['codigo']) );
                    if ( empty($input_precio_recurso) ) {
                        $input_precio_recurso = 0.00;
                    }
                    //array_push($array_nombre_recurso,array(strtolower($value['codigo']) => $input_nombre_recurso ) );
                    //array_push($array_descripcion_recurso,array(strtolower($value['codigo']) => $input_descripcion_recurso ) );
                    //array_push($array_precio_recurso,array(strtolower($value['codigo']) => $input_precio_recurso ) );
                    $array_nombre_recurso[ $value['codigo'] ]       =  $input_nombre_recurso ;
                    $array_descripcion_recurso[ $value['codigo'] ]  =  $input_descripcion_recurso;
                    $array_precio_recurso[ $value['codigo'] ]       =  $input_precio_recurso;
                }
                /*
                $params = array(
                    'nombre_recurso'        => $this->input->post('txt_nombre_recurso_es'),
                    'descripcion_recurso'   => $this->input->post('txtr_descripcion_recurso_es'),
                    'precio_recurso'        => $this->input->post('txt_precio_recurso_es'),
                    'regalo_recurso'        => $this->input->post('chckbx_regalo_recurso'),
                );
                */
                $params = array(
                    'nombre_recurso'        => json_encode($array_nombre_recurso),
                    'descripcion_recurso'   => json_encode($array_descripcion_recurso),
                    'precio_recurso'        => json_encode($array_precio_recurso),
                    'regalo_recurso'        => $this->input->post('chckbx_regalo_recurso'),
                );

              $recurso = $this->recurso_model->update_recurso( $this->uri->segment(4) ,$params,$this->input->post('fl_imagen_recurso'));             
               redirect('admin/recurso');
            }else{
                $this->load->view('admin/recurso-edit',$data);
            }
        }else{
            //show_error('The recurso you are trying to edit does not exist.');
            redirect("admin/recurso");
        }
    } 

    function remove($id_recurso){
        $recurso = $this->recurso_model->get_recurso($id_recurso);
        $data  =array();
        // check if the recurso exists before trying to delete it
        if(isset($recurso['id_recurso'])){
            $response = $this->recurso_model->delete_recurso($id_recurso);
            //redirect('admin/recurso/index');
            if ($response) {
                $data = array(
                    'data'      =>  'OK',
                    'response'  => 'Registro eliminado.',
                );
            }else{
                $data = array(
                    'data'      =>  'ERROR',
                    'response'  => 'Error eliminando registro.',
                );
            }
        }else{
            //show_error('The recurso you are trying to delete does not exist.');
            $data = array(
                'data'      =>  'ERROR',
                'response'  => 'El registro que quieres eliminar no existe.',
            );
        }
        echo json_encode($data);
    }

    function productos_by_idioma(){
        $id_recurso = $this->input->post('id_recurso');
        $response =  $this->recurso_model->get_productos_by_idioma($id_recurso);
        echo json_encode($response);
    }

    function list_all_recursos(){
        $id_producto = $this->input->post('id_producto');
        $temp_response = array();
        $response['recursos'] =  $this->recurso_model->get_list_all_recursos($id_producto);
        echo json_encode($response);
    }

    //Asocia un producto con un recurso utilizando el id_producto y id_recurso
    function recurso_asociar_producto(){
        $id_producto = $this->input->post('id_producto');
        $id_recurso  = $this->input->post('id_recurso');
        $estado      = $this->input->post('estado');
        $data        = array();

        if ( $estado === 1 || $estado === '1' ) {
            $params['id_recurso'] = $id_recurso;
            $params['id_producto']= $id_producto;
            $this->recurso_model->asociar_recurso($params);
        }else{
            $data['operacion'] = 'Eliminar';
            $this->recurso_model->desasociar_recurso($id_producto , $id_recurso);
        }

        $data["response"] = 'OK';
        $data["message"]  = "La actualización se a realizado con éxito..!"; 
        echo json_encode($data);
    }

    //Asocia y Desasocia productos con recursos utilizando el id_codigo_producto y id_recurso
    function recursoAsociarIdCodigoProducto(){
        $id_producto = $this->input->post('id_producto');
        $id_recurso  = $this->input->post('id_recurso');
        $estado      = $this->input->post('estado');
        $icp         = $this->input->post('icp'); // icp = id_codigo_producto
        $data        = array();

        $params['id_recurso']           = $id_recurso;
        //$params['id_producto']          = $id_producto;
        //8$params['id_codigo_producto']   = $icp;
        
        $productos = $this->producto->getGrupoProductos( trim($icp) );
        if ( count($productos) != 0 ) {
            foreach ($productos as $key => $value) {
                if ( $estado === 1 || $estado === '1' ) {
                    $data['operacion'] = 'Asociar';
                    $params['id_producto'] = $value['id_producto'];
                    $this->recurso_model->asociar_recurso($params);
                }else{
                    $data['operacion'] = 'Desasociar';
                    $this->recurso_model->desasociar_recurso($value['id_producto'] , $id_recurso);
                }
            }
        }

        $data["response"] = 'OK';
        $data["message"]  = "La actualización se a realizado con éxito..!"; 
        echo json_encode($data);
    }

    function update_estado_recurso(){
        $id_recurso = $this->input->post('id_recurso');
        $estado     = $this->input->post('estado');
        $response   = $this->recurso_model->estado_recurso($id_recurso,$estado);
        $data = array();
        if ( $response ) {
            $data['response'] = 'OK';
            $data['message']  = 'Estado de recurso actualizado correctamente..!';
        }else{
            $data['response'] = 'ERROR';
            $data['message']  = 'Error actualizando estado del recurso..!';
        }  
        echo json_encode($data);
    }

    //RETORNA UN RECURSO CON SUS TRADUCCIONES 
    function traduccionesRecurso($id = 0){
        $data = array();
        $id = strip_tags( xss_clean( trim( $this->input->post('id') ) ) );
        $recurso = $this->recurso_model->get_recurso($id);
        $idiomas = $this->idioma_model->get_all_idiomas();

        $json_nombre_recurso      = json_decode($recurso['nombre_recurso'],true);
        $json_descripcion_recurso = json_decode($recurso['descripcion_recurso'],true);
        $json_precio_recurso      = json_decode($recurso['precio_recurso'],true);

        $data_nombre_recurso        = array();
        $data_descripcion_recurso  = array();
        $data_precio_recurso        = array();

        foreach ($json_nombre_recurso as $key => $value) {
            $data_nombre_recurso[] = $value;
        }
        foreach ($json_descripcion_recurso as $key => $value) {
            $data_descripcion_recurso[] = $value;
        }
        foreach ($json_precio_recurso as $key => $value) {
            $data_precio_recurso[] = $value;
        }

        if (count($idiomas) > 0 ) {
            foreach ($idiomas as $key => $value) {
                array_push($data, array(
                        'codigo' => $value['codigo'],
                        'idioma' => $value['pais'],
                        'id'     => $recurso['id_recurso'],
                        //'nombre' => $json_nombre_recurso[ $value['codigo'] ] ? $json_nombre_recurso[ $value['codigo'] ] : '',
                        'nombre' => empty($data_nombre_recurso[$key])?'':$data_nombre_recurso[$key],
                        //'descripcion' => $json_descripcion_recurso[ $value['codigo'] ] ? $json_descripcion_recurso[ $value['codigo'] ] : '',
                        'descripcion' => empty($data_descripcion_recurso[$key])?'':$data_descripcion_recurso[$key],
                        //'precio' => $json_precio_recurso[ $value['codigo'] ] ? $json_precio_recurso[ $value['codigo'] ] : '',
                        'precio' => empty($data_precio_recurso[$key])?'':$data_precio_recurso[$key],
                        'regalo' => $recurso['regalo_recurso'],
                    )
                );
            }
        }
        echo json_encode($data);
    }


    function imagenRecurso(){
        $params['id'] = $this->input->post('id');
        $response = $this->recurso_model->getImagenRecurso($params);
        if ( !empty($response) ) {
            $data['uri'] = $response['url_archivo'];
            $data['url'] = base_url()."galeria/admin/".$this->carpeta($response["tipo_archivo"])."/".$response["carpeta_archivo"]."/".$response["url_archivo"];
            $data['detalle'] = $response['detalles_archivo'];
        }else{
            $data['uri'] = "recurso.png";
            $data['url'] = "";
            $data['detalle'] = "No hay imagen asociada para el recurso.";
        }
        echo json_encode($data);
        //echo json_encode($response);
    }

    private function carpeta($id){
        $carpeta = '';
        switch ( (integer)$id ) {
            case 0:
                $carpeta = 'docs';
                break;
            case 1:
                $carpeta = 'full-slider';
                break;
            case 2:
                $carpeta = 'short-slider';
                break;
            case 3:
                $carpeta = 'relateds';
                break;
            case 4:
                $carpeta = 'recursos';
                break;
            case 5:
                $carpeta = 'politicas';
                break;
            case 6:
                $carpeta = 'other-images';
                break;
            default:
                $carpeta = 'otros';
                break;
        }
        return $carpeta;
    }
}
