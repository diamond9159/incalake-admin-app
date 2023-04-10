<?php

class Categoria_producto_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_categoria_producto($id_categoria, $id_producto){
        return $this->db->get_where('producto_has_categoria',array('producto_id_producto'=>$id_producto,'categoria_id_categoria'=>$id_categoria))->row_array();
    }

    function get_all_categoria_producto(){
        return $this->db->get('producto_has_categoria')->result_array();
    }
    
    function add_categoria_producto($params){
        $this->db->insert('producto_has_categoria',$params);
        return $this->db->insert_id();
    }
    
    /*
    function update_categoria_producto($id_categoria,$id_producto,$params){
        $this->db->where('id_producto_has_categoria',$id_producto_has_categoria);
        $response = $this->db->update('producto_has_categoria',$params);
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
    */
    function delete_categoria_producto($id_producto,$id_categoria){
        $response = $this->db->delete('producto_has_categoria',array('producto_id_producto'=>$id_producto,'categoria_id_categoria'=>$id_categoria));
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
}
