<?php
class Reservarapida extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/reservarapida_model');
        $this->load->model('admin/disponibilidad_model');
        $this->load->model('admin/oferta_model');
        $this->load->model('admin/precio_model');
        $this->load->model('admin/recurso_model');
    } 

    function index(){
        $data['reservarapidas'] = $this->reservarapida_model->get_all_reservarapidas();
        
        $this->load->view('admin/reservarapida',$data);
    }


    function add(){   
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txt_nombre_lider_reservarapida','Nombre del Líder','required');
        
        if($this->form_validation->run()){   
            $data = array();
            $params = array(
                'nombre_lider'            => $this->input->post('txt_nombre_lider_reservarapida'),
                'nro_personas_adultas'    => $this->input->post('txt_numero_adultos_reservarapida'),
                'nro_personas_menores'    => $this->input->post("txt_numero_ninos_reservarapida"),
                'precio_personas_adultas' => $this->input->post("txt_precio_adultos_reservarapida"),
                'precio_personas_menores' => $this->input->post("txt_precio_ninos_reservarapida"),
                'fecha_tour'              => date_format( date_create($this->input->post("txt_fecha_tour_reservarapida") ),'Y-m-d'),
                'nombre_tour'             => $this->input->post("txt_tour_reservarapida"),
                'pago'                    => $this->input->post("txt_pago_reservarapida"),
                'datos_adicionales'       => $this->input->post("txtr_datos_adicionales_reservarapida"),  
                'id_paquete'              => $this->input->post("slct_tour_espanol"),
                'fecha_creacion_registro' => date('Y-m-d H:i:s'),
            );
            $reservarapida_id = $this->reservarapida_model->add_reservarapida($params);
            //redirect('admin/reservarapida');
            redirect('admin/reservarapida');    
        }else{
            $data['es'] = $this->reservarapida_model->get_reservarapida_all_producto_idioma('es');
            $data['en'] = $this->reservarapida_model->get_reservarapida_all_producto_idioma('en');
        
            $this->load->view('admin/reservarapida-add',$data);
        }
    }   


    function edit($id_reservarapida){   
        // check if the reservarapida exists before trying to edit it
        $data['reservarapida'] = $this->reservarapida_model->get_reservarapida($id_reservarapida);
        
        if(isset($data['reservarapida']['id_reservarapida'])){
            $this->load->library('form_validation');

            $this->form_validation->set_rules('txt_nombre_lider_reservarapida','Nombre del Líder','required');
        
            if($this->form_validation->run()){   
                $params = array(
                'nombre_lider'            => $this->input->post('txt_nombre_lider_reservarapida'),
                'nro_personas_adultas'    => $this->input->post('txt_numero_adultos_reservarapida'),
                'nro_personas_menores'    => $this->input->post("txt_numero_ninos_reservarapida"),
                'precio_personas_adultas' => $this->input->post("txt_precio_adultos_reservarapida"),
                'precio_personas_menores' => $this->input->post("txt_precio_ninos_reservarapida"),
                'fecha_tour'              => date_format( date_create($this->input->post("txt_fecha_tour_reservarapida") ),'Y-m-d'),
                'nombre_tour'             => $this->input->post("txt_tour_reservarapida"),
                'pago'                    => $this->input->post("txt_pago_reservarapida"),
                'datos_adicionales'       => $this->input->post("txtr_datos_adicionales_reservarapida"),  
                'id_paquete'              => $this->input->post("slct_tour_espanol"),
            );
                $this->reservarapida_model->update_reservarapida($id_reservarapida,$params);            
                redirect('admin/reservarapida');
            }else{
                $data['es'] = $this->reservarapida_model->get_reservarapida_all_producto_idioma('es');
                $data['en'] = $this->reservarapida_model->get_reservarapida_all_producto_idioma('en');
                $data['reservarapida'] = $this->reservarapida_model->get_reservarapida($id_reservarapida);
                $data['id_paquete']    = $id_reservarapida;   
                $this->load->view('admin/reservarapida-edit',$data);
            }
        }else{
            show_error('The reservarapida you are trying to edit does not exist.');
        }
    } 


    function remove($id_reservarapida){
        $reservarapida = $this->reservarapida_model->get_reservarapida($id_reservarapida);
        $data = array();
        // check if the reservarapida exists before trying to delete it
        if(isset($reservarapida['id_reservarapida'])){
            $this->reservarapida_model->delete_reservarapida($id_reservarapida);
            //redirect('admin/reservarapida/index');
            $data['response'] = 'OK'; 
        }else{
            $data['response'] = 'ERROR';
            //show_error('The reservarapida you are trying to delete does not exist.');
        }
        echo json_encode($data);
    }

    function reservarapida_all_productos_idioma(){
        $lang = trim($this->input->post('lang'));
        $response = $this->reservarapida_model->get_reservarapida_all_producto_idioma($lang);
        echo json_encode($response);
    }

    function reservarapida_producto_idioma(){
        $data_select = $this->input->post('data');
        $idioma      = $this->input->post('lang');
        $response['producto']   = $this->reservarapida_model->get_reservarapida_producto($data_select,$idioma);
        $response['precio']     = $this->precio_model->get_precio_by_producto($response['producto']['id_producto']);
        $response['oferta']     = $this->oferta_model->get_producto_in_oferta($response['producto']['id_producto']);
        $response['disponibilidad'] = $this->disponibilidad_model->get_disponibilidad_producto_disponibilidad($response['producto']['id_producto']);
        $response['bloqueo']    = $this->disponibilidad_model->get_disponibilidad_producto_bloqueo($response['producto']['id_producto']);  
        $response['datos_reserva'] = $this->generar_datos_reserva($response['producto']['config_form']);
        //$response['recursos']   = $this->recurso_model->get_recurso_producto($response['producto']['id_producto']);
        
        echo json_encode($response);
    }

    function generar_datos_reserva($config_form){
        $data = [
            // Información Principal
            'Nombre Completo (Sólo Líder del Grupo)',
            'Nombres Completos (De todos los Clientes)',
            'Edad y Fecha de Nacimiento',
            'Número de Pasajeros',
            'Género Sexual',
            'Tipo de Documento de Identidad',
            'Nacionalidad',
            // Información Operacional
            'Peso del Cliente (kg)',
            'Altura del Cliente (m,fts)',
            'Tipo de Comida Preferida',
            //Información de Viaje
            'Detalles de su Hotel (Ubicación y Nombre)',
            'Número de Vuelo de Llegada',
            'Hora de Llegada del Vuelo',
            'Número de Vuelo Salida',
            'Hora de Salida del Vuelo',
            'Compañia de Bus/tren Utilizado',
            'Terminal de Arribo',
            'Hora de Arribo',
            'Terminal de Salida',
            'Hora de Salida',
            'Otra información Requirida',
            'Email de Contacto',
            'Número Celular de Contacto'
        ];
        $data_string = '';
        $array_config_form = explode(",",$config_form);
        $data_string .= '<ul class="list-unstyled"><strong><ins>INFORMACIÓN PRINCIPAL</ins></strong><br/>';
        foreach ($data as $key => $value) {
            if ( $array_config_form[$key] === 1 || $array_config_form[$key] === '1' ) {
                $data_string .= '<li>'.$value.'.</li>';    
            }
            if ( $key === 6 ) {
                $data_string .= '<strong><ins>INFORMACIÓN OPERACIONAL</ins></strong><br/>';
            }
            if ( $key === 9 ) {
                $data_string .= '<strong><ins>INFORMACIÓN DE  VIAJE</ins></strong><br/>';
            }
        }
        $data_string .= '</ul>';
        return "".$data_string;
    }
}


