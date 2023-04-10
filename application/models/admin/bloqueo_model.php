<?php

class Bloqueo_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/idioma_model');
        //$this->load->model('admin/disponibilidad_model');
    }
    
    function get_bloqueo($id_producto){
        $data = array();
        if ( !empty($id_producto ) ) {  //Consulta a la base de datos mediante $id_producto
            $bloqueo = $this->db->query("SELECT * FROM bloqueo WHERE id_producto = '".$id_producto."';")->result_array();
            if ( !empty($bloqueo) ) {
                foreach ($bloqueo as $key => $value) {
                    $data[] = array(
                        "id"                => $value['id_bloqueo'],
                        "title"             => utf8_decode($value['descripcion_bloqueo']),
                        "start"             => $value['fecha_inicio'],
                        "end"               => $value['fecha_fin'],
                        "color"             => $value['color_bloqueo'],
                    );
                }
            }           
        }
        return json_encode($data);
    }

    //Retorna bloqueos con id NULL para que vuelvan a ser insertados cuando la actividad este siendo clonado
    function get_bloqueo_clonar($id_producto){
        $data = array();
        if ( !empty($id_producto ) ) {  //Consulta a la base de datos mediante $id_producto
            $bloqueo = $this->db->query("SELECT * FROM bloqueo WHERE id_producto = '".$id_producto."';")->result_array();
            if ( !empty($bloqueo) ) {
                foreach ($bloqueo as $key => $value) {
                    $data[] = array(
                        "id"                => null,
                        "title"             => utf8_decode($value['descripcion_bloqueo']),
                        "start"             => $value['fecha_inicio'],
                        "end"               => $value['fecha_fin'],
                        "color"             => $value['color_bloqueo'],
                    );
                }
            }           
        }
        return json_encode($data);
    }
    
    function get_all_bloqueos(){
        return $this->db->get('bloqueo')->result_array();
    }
    
    function get_listview_bloqueos(){
        return $this->db->query("SELECT * FROM producto as p JOIN bloqueo as o ON p.id_producto = o.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma;")->result_array();
    }
    
    function add_bloqueo($params){
        $this->db->insert('bloqueo',$params);
        return $this->db->insert_id();
    }

    function update_bloqueo($id_bloqueo,$params){
        $this->db->where('id_bloqueo',$id_bloqueo);
        $response = $this->db->update('bloqueo',$params);
        if($response){
            return true;
        }
        else{
            return false;
        }
    }
    
    function delete_bloqueo($id_bloqueo){
        $response = $this->db->delete('bloqueo',array('id_bloqueo'=>$id_bloqueo));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }
    
    function delete_bloqueo_producto($id_producto){
        $response = $this->db->delete('bloqueo',array('id_producto'=>$id_producto));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }

    /********************************************************************************************************/
    function add_bloqueo_producto($params){
        //$this->delete_bloqueo_producto($params['id_producto']);
        $this->db->insert('bloqueo',$params);
        return $this->db->insert_id();
    }
    function get_idiomas_utilizados(){
        // Retorna la lista de idiomas en las que estan disponibles la spáginas web.
        $response = $this->db->query('SELECT i.* FROM servicio as s INNER JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma GROUP BY s.idioma_id_idioma;')->result_array();
        return $response;
    }

    function get_idioma_bloqueos($codigo_idioma){
        $response =  $this->idioma_model->get_nombre_idioma_codigo($codigo_idioma);
        if ( !empty($response['id_idioma']) ) {
            return $this->db->query('SELECT p.*,i.* FROM servicio as s INNER JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma INNER JOIN producto as p ON s.id_servicio = p.id_servicio AND s.idioma_id_idioma = '.$response['id_idioma'].';')->result_array();    
        }else{
            return [];
        }   
    }

    function get_producto_in_bloqueo($id_paquete){
        return $this->db->query("SELECT * FROM bloqueo WHERE id_producto = '".$id_paquete."';")->row_array();
    }

    function get_bloqueos_por_idioma(){
        $data = array();
        $idiomas_utilizados  = $this->get_idiomas_utilizados();
        if ( !empty($idiomas_utilizados) ) {
            foreach ($idiomas_utilizados as $key => $value) {
                $response = $this->db->query("SELECT * FROM producto as p INNER JOIN bloqueo as o INNER JOIN servicio as s ON (o.id_producto = p.id_producto AND s.id_servicio = p.id_servicio AND s.idioma_id_idioma = '".$value['id_idioma']."' );")->result_array(); 
                $data[] = array(
                        'data'      => $value,
                        'bloqueos'   => $response,
                );  
            }
        }
        return $data;
    }
    function get_bloqueo_producto($id_producto){
        //$data = array();
        //return $this->db->get_where('bloqueo',array('id_producto'=>$id_producto))->row_array();
        $bloqueo = $this->db->query("SELECT data_bloqueo FROM bloqueo WHERE id_producto = ? ;",array($id_producto))->row_array();
        if ( is_array($bloqueo) ) {
            //$data[] = $bloqueo['data_bloqueo'];
            return $bloqueo['data_bloqueo'];
        }else{
            return [];
        }
        //return $data;
    }

    function get_listview_productos($id_producto){
        $data = array();
        $response = $this->db->query("SELECT * FROM producto WHERE id_producto = '".$id_producto."';")->result_array();
        foreach ($response as $key => $value) {
            $data[] = array(
                'producto' => $value,
                'disponibilidad' => $this->disponibilidad_model->get_disponibilidad_producto_disponibilidad($value['id_producto']),
                'bloqueo'        => $this->disponibilidad_model->get_disponibilidad_producto_bloqueo($value['id_producto']),
                'bloqueo'         => $this->get_bloqueo_producto($value['id_producto']),
            );
        }
        return $data;
    }
}
