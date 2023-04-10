<?php
class Codigoguia_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_codigoguia($id_codigoguia){
        $codigoguia = $this->db->query("SELECT * FROM codigo_guia WHERE id_codi_goguia = ?;",array($id_codigoguia))->row_array();
        return $codigoguia;
    }

    function get_all_codigoguias(){
        $codigoguias = $this->db->query("SELECT * FROM codigo_guia WHERE 1 = 1 ORDER BY id_codigo_guia DESC;")->result_array();
        return $codigoguias;
    }
        
    function add_codigoguia($params){
        $this->db->insert('codigo_guia',$params);
        return $this->db->insert_id();
    }
    
    function update_codigoguia($id_codigoguia,$params){
        $this->db->where('id_codigo_guia',$id_codigoguia);
        return $this->db->update('codigo_guia',$params);
    }
    
    function delete_codigoguia($id_codigoguia){
        return $this->db->delete('codigo_guia',array('id_codigo_guia'=>$id_codigoguia));
    }
}