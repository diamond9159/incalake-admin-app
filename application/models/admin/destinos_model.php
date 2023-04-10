<?php

class Destinos_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_destino($id_destino){
        $destino = $this->db->query("SELECT * FROM destino WHERE id_destino = ?;",array($id_destino))->row_array();
        return $destino;
    }

    function get_all_destinos(){
        $destinos = $this->db->query("SELECT * FROM destino WHERE 1 = 1 ORDER BY `id_destino` DESC;")->result_array();
        return $destinos;
    }
        
    function add_destino($params){
        $this->db->insert('destino',$params);
        return $this->db->insert_id();
    }
    
    function update_destino($id_destino,$params){
        $this->db->where('id_destino',$id_destino);
        return $this->db->update('destino',$params);
    }
    
    function delete_destino($id_destino){
        return $this->db->delete('destino',array('id_destino'=>$id_destino));
    }

    function get_destino_idioma($language){
        return $this->db->query("SELECT * FROM idioma as i JOIN destino as d ON i.id_idioma = d.id_idioma AND i.codigo = '".trim($language)."';")->result_array();
    }

    function get_traducciones($idDestino,$idCodigoDestino){
        return $this->db->query("SELECT * FROM idioma as i JOIN destino as d ON i.id_idioma = d.id_idioma AND d.id_codigo_destino = '".$idCodigoDestino."';")->result_array();
    }



    function add_codigoDestino($params){
        $this->db->insert('codigo_destino',$params);
        return $this->db->insert_id();    
    }

    function update_codigoDestino($id_codigoDestino,$params){
        $this->db->where('id_codigo_destino',$id_codigoDestino);
        return $this->db->update('codigo_destino',$params);
    }
    
    function delete_codigodestino($id_destino,$id_codigoDestino){
        return $this->db->delete('codigo_destino',array('id_codigo_destino'=>$id_codigoDestino));
    }    

    function get_destino_producto($idDestino,$idActividad){
        return $this->db->query("SELECT * FROM destino_has_producto WHERE id_destino = '".trim($idDestino)."' AND id_producto = '".trim($idActividad)."';")->row_array();
    }

    function add_destino_producto($params){
        $this->db->insert('destino_has_producto',$params);
        //return $this->db->insert_id();
        return true;
    }

    function delete_destino_producto($id_destino,$id_producto){
        $response = $this->db->delete('destino_has_producto',array('id_producto'=>$id_producto,'id_destino'=>$id_destino));
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
}
