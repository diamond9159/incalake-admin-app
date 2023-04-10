<?php

class Reservarapida_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_reservarapida($id_reservarapida){
        $reservarapida = $this->db->query("SELECT * FROM reservarapida WHERE id_reservarapida = ?;",array($id_reservarapida))->row_array();
        return $reservarapida;
    }
    
    function get_all_reservarapidas(){
        $reservarapidas = $this->db->query("SELECT * FROM reservarapida WHERE 1 = 1 ORDER BY fecha_creacion_registro DESC;")->result_array();
        return $reservarapidas;
    }
    function add_reservarapida($params){
        $this->db->insert('reservarapida',$params);
        return $this->db->insert_id();
    }
    
    function update_reservarapida($id_reservarapida,$params){
        $this->db->where('id_reservarapida',$id_reservarapida);
        $response = $this->db->update('reservarapida',$params);
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
    
    function delete_reservarapida($id_reservarapida){
        $response = $this->db->delete('reservarapida',array('id_reservarapida'=>$id_reservarapida));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }

    function get_reservarapida_by_producto($id_producto){
       $reservarapida = $this->db->query("SELECT * FROM reservarapida WHERE id_producto = ?;",array($id_producto))->row_array();
        return $reservarapida; 
    }

    function get_reservarapida_all_producto_idioma($lang){
        $data = array();
        $response = $this->db->query("SELECT * FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".$lang."' JOIN producto as p ON p.id_servicio = s.id_servicio;")->result_array();
        if ($response) {
            $data = $response;
        }
       return $data;
    }

    function get_reservarapida_producto($data,$lang){
        $array_data = explode("-", $data);
        $response = $this->db->query("SELECT * FROM producto as p WHERE p.id_producto = '".$array_data[2]."';")->row_array();
        return $response;
    }
}

