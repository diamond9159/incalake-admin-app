<?php

class Idioma_model extends CI_Model{
    function __construct(){
        parent::__construct();
    } 

    function get_idioma($id_idioma){
        $idioma = $this->db->query("SELECT * FROM idioma WHERE id_idioma = ? ;",array($id_idioma))->row_array();
        return $idioma;
    }

    function get_all_idiomas(){
        $idiomas = $this->db->query("SELECT * FROM idioma WHERE 1 = 1 ;")->result_array();
        return $idiomas;
    }

    function add_idioma($params){
        $this->db->insert('idioma',$params);
        return $this->db->insert_id();
    }
    
    function update_idioma($id_idioma,$params){
        $this->db->where('id_idioma',$id_idioma);
        $response = $this->db->update('idioma',$params);
        if($response){
            return "idioma updated successfully";
        }else{
            return "Error occuring while updating idioma";
        }
    }

    function delete_idioma($id_idioma){
        $response = $this->db->delete('idioma',array('id_idioma'=>$id_idioma));
        if($response){
            return "idioma deleted successfully";
        } else {
            return "Error occuring while deleting idioma";
        }
    }

    function free_idiomas($id_codigo){
        $free_languages = $this->db->query("SELECT i.* FROM idioma as i WHERE i.id_idioma NOT IN(SELECT s.idioma_id_idioma FROM servicio as s WHERE s.codigo_servicio_id_codigo_servicio = ".$id_codigo." );" )->result_array();
        return $free_languages;
    }

    function get_cantidad_idiomas(){
        //Retornaa la cantidad de idiomas que hay, se usa en el MODELO Servicio/index
        $cantidad = $this->db->query("SELECT count(*) as cantidad FROM idioma  WHERE id_usuarios = ".$this->session->userdata('id_usuarios').";")->row_array() ;
        return $cantidad;
    }

    function get_nombre_idiomas(){
        // Retorna los nombres de los idiomas, se usa en el MODELO Servicio/index
        $nombre_idiomas = $this->db->query("SELECT * FROM idioma WHERE id_usuarios = ".$this->session->userdata('id_usuarios')." GROUP BY pais ORDER BY id_idioma ASC;")->result_array() ;
        return $nombre_idiomas;
    }
    function get_nombre_idioma_codigo($nombre){
        //Retorna el id del idioma mediante el codigo, se usa en el MODELO Oferta/add
        return $this->db->query("SELECT * FROM idioma WHERE codigo = '".$nombre."';")->row_array();
    }

    function descartar_duplicidad( $codigo ){
        $response = $this->db->query("SELECT * FROM idioma WHERE idioma.id_usuarios = ".$this->session->userdata('id_usuarios')." AND idioma.codigo = '".$codigo."';")->row_array();
        if ( !empty($response) ) {
            return true;
        }else{
            return false;
        }
    }

    function get_idioma_id_servicio($id_servicio){
        $idioma = $this->db->query("SELECT i.* FROM servicio as s JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma AND s.id_servicio = ?;",array($id_servicio))->row_array();
        return $idioma;
    }
}
