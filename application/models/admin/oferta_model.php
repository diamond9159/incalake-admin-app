<?php

class Oferta_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/idioma_model');
        $this->load->model('admin/disponibilidad_model');
    }
    
    function get_oferta($id_producto){
        $data = array();
        if ( !empty($id_producto ) ) {  //Consulta a la base de datos mediante $id_producto
            $oferta = $this->db->query("SELECT * FROM oferta WHERE id_producto = '".$id_producto."';")->result_array();
            if ( !empty($oferta) ) {
                foreach ($oferta as $key => $value) {
                    $data[] = array(
                        "id"                => $value['id_oferta'],
                        "title"             => $value['descripcion_oferta'],
                        "start"             => $value['fecha_inicio'],
                        "end"               => $value['fecha_fin'],
                        "color"             => $value['color_oferta'],
                        "descuento"         => $value['valor_oferta'],
                        "tipo_descuento"    => $value['tipo_oferta'],
                    );
                }
            }           
        }
        return json_encode($data);
    }

    //Retorna ofertas con id NULL para que vuelvan a ser insertados cuando la actividad este siendo clonado
    function get_oferta_clonar($id_producto){
        $data = array();
        if ( !empty($id_producto ) ) {  //Consulta a la base de datos mediante $id_producto
            $oferta = $this->db->query("SELECT * FROM oferta WHERE id_producto = '".$id_producto."';")->result_array();
            if ( !empty($oferta) ) {
                foreach ($oferta as $key => $value) {
                    $data[] = array(
                        "id"                => null,
                        "title"             => $value['descripcion_oferta'],
                        "start"             => $value['fecha_inicio'],
                        "end"               => $value['fecha_fin'],
                        "color"             => $value['color_oferta'],
                        "descuento"         => $value['valor_oferta'],
                        "tipo_descuento"    => $value['tipo_oferta'],
                    );
                }
            }           
        }
        return json_encode($data);
    }

    function get_all_ofertas(){
        return $this->db->get('oferta')->result_array();
    }
    
    function get_listview_ofertas(){
        return $this->db->query("SELECT * FROM producto as p JOIN oferta as o ON p.id_producto = o.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma;")->result_array();
    }
    
    function add_oferta($params){
        $this->db->insert('oferta',$params);
        return $this->db->insert_id();
    }

    function update_oferta($id_oferta,$params){
        $this->db->where('id_oferta',$id_oferta);
        $response = $this->db->update('oferta',$params);
        if($response){
            return true;
        }
        else{
            return false;
        }
    }
    
    function delete_oferta($id_oferta){
        $response = $this->db->delete('oferta',array('id_oferta'=>$id_oferta));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }
    
    function delete_oferta_producto($id_producto){
        $response = $this->db->delete('oferta',array('id_producto'=>$id_producto));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }

    /********************************************************************************************************/
    
    function add_oferta_producto($params){
        $this->db->insert('oferta',$params);
        return $this->db->insert_id();
        //$this->delete_oferta_producto($params['id_producto']);
        //$this->db->insert('oferta',$params);
        //return $this->db->insert_id();
    }
    
    function get_idiomas_utilizados(){
        // Retorna la lista de idiomas en las que estan disponibles la spáginas web.
        $response = $this->db->query('SELECT i.* FROM servicio as s INNER JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma GROUP BY s.idioma_id_idioma;')->result_array();
        return $response;
    }

    function get_idioma_ofertas($codigo_idioma){
        $response =  $this->idioma_model->get_nombre_idioma_codigo($codigo_idioma);
        if ( !empty($response['id_idioma']) ) {
            return $this->db->query('SELECT p.*,i.* FROM servicio as s INNER JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma INNER JOIN producto as p ON s.id_servicio = p.id_servicio AND s.idioma_id_idioma = '.$response['id_idioma'].';')->result_array();    
        }else{
            return [];
        }   
    }

    function get_producto_in_oferta($id_paquete){
        return $this->db->query("SELECT * FROM oferta WHERE id_producto = '".$id_paquete."';")->row_array();
    }

    function get_ofertas_por_idioma(){
        $data = array();
        $idiomas_utilizados  = $this->get_idiomas_utilizados();
        if ( !empty($idiomas_utilizados) ) {
            foreach ($idiomas_utilizados as $key => $value) {
                $response = $this->db->query("SELECT * FROM producto as p INNER JOIN oferta as o INNER JOIN servicio as s ON (o.id_producto = p.id_producto AND s.id_servicio = p.id_servicio AND s.idioma_id_idioma = '".$value['id_idioma']."' );")->result_array(); 
                $data[] = array(
                        'data'      => $value,
                        'ofertas'   => $response,
                );  
            }
        }
        return $data;
    }
    function get_oferta_producto($id_producto){
        //$data = array();
        //return $this->db->get_where('oferta',array('id_producto'=>$id_producto))->row_array();
        $oferta = $this->db->query("SELECT * FROM oferta WHERE id_producto = ? ;",array($id_producto))->row_array();
        if ( is_array($oferta) ) {
            //$data[] = $oferta['data_oferta'];
            //return $oferta['data_oferta'];
            return $oferta;
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
                'oferta'         => $this->get_oferta_producto($value['id_producto']),
            );
        }
        return $data;
    }

}
