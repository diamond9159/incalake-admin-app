<?php

class Precio_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_precio($id_precio){
        $precio = $this->db->query("SELECT * FROM precio WHERE id_precio = ?;",array($id_precio))->row_array();
        return $precio;
    }
    
    function get_all_precios(){
        $precios = $this->db->query("SELECT * FROM precio WHERE 1 = 1;")->result_array();
        return $precios;
    }
    
    function add_precio($params){
        $this->db->insert('precio',$params);
        return $this->db->insert_id();
    }
    
    function update_precio($id_precio,$params){
        $this->db->where('id_precio',$id_precio);
        $response = $this->db->update('precio',$params);
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
    
    function delete_precio($id_precio){
        $response = $this->db->delete('precio',array('id_precio'=>$id_precio));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }

    function get_precio_by_producto($id_producto){
       $precio = $this->db->query("SELECT * FROM precio WHERE id_producto = ?;",array($id_producto))->row_array();
        return $precio; 
    }
}
