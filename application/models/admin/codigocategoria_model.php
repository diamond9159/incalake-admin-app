<?php

class Codigocategoria_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_codigocategoria($id_codigo){
        $codigoservicio = $this->db->query("SELECT * FROM codigo_categoria WHERE id_codigo_categoria = ?;",array($id_codigo))->row_array();
        return $codigoservicio;
    }
    
    function get_all_codigocategorias(){
        $codigoservicios = $this->db->query("SELECT * FROM codigo_categoria WHERE 1 = 1;")->result_array();
        return $codigoservicios;
    }
    
    function add_codigocategoria($params){
        $this->db->insert('codigo_categoria',$params);
        return $this->db->insert_id();
    }

    function update_codigocategoria($id_codigo,$params){
        $this->db->where('id_codigo_categoria',$id_codigo);
        $response = $this->db->update('codigo_categoria',$params);
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
    
    function delete_codigocategoria($id_codigo){
        $response = $this->db->delete('codigo_categoria',array('id_codigo_categoria'=>$id_codigo));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }

    function get_cantidad_codigocategoria(){
        $cantidad  = $this->db->query("SELECT * FROM codigo_categoria GROUP BY id_codigo_categoria;")->result_array();
        return $cantidad;
    }
}
