<?php

class Galeria_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_galeria($id_galeria = 0 ){
        return $this->db->get_where('galeria',array('id_galeria'=>$id_galeria))->row_array();
    }
    
    function get_all_galerias(){
        return $this->db->get('galeria')->result_array();
    }
    
    function add_galeria($params){
        $this->db->insert('galeria',$params);
        return $this->db->insert_id();
    }
    
    function update_galeria($id_galeria,$params){
        $this->db->where('id_galeria',$id_galeria);
        $response = $this->db->update('galeria',$params);
        if($response){
            return true;
        }
        else{
            return false;
        }
    }
    
    function delete_galeria($id_galeria){
        $response = $this->db->delete('galeria',array('id_galeria'=>$id_galeria));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }

    function get_imagen($id_recurso){
        return $this->db->query("SELECT g.* FROM galeria as g JOIN recurso_has_galeria as rhg ON g.id_galeria = rhg.galeria_id_galeria AND recurso_id_recurso = ".$id_recurso." ;")->row_array();
    }

    function get_archivo($id_galeria){
        $response = $this->db->query("SELECT g.* FROM galeria as g WHERE id_galeria = ".$id_galeria." ;")->row_array();    
        $data = array();
        $data['id_galeria']         = $response['id_galeria'];
        $data['url_archivo']        = $response['url_archivo'];
        $data['detalles_archivo']   = $response['detalles_archivo'];
        $data['tipo_archivo']       = $this->carpeta($response['tipo_archivo']);
        $data['carpeta_archivo']    = $response['carpeta_archivo'];
        $data['id_usuarios']        = $response['id_usuarios'];
        $data['full_url_archivo']   = URL_BASE_ARCHIVO."galeria/admin/".$this->carpeta($response['tipo_archivo'])."/".$response['carpeta_archivo']."/".$response['url_archivo'];
        return $data;
    }
    
    private function carpeta($id){
        $carpeta = '';
        switch ( (integer)$id ) {
            case 0:
                $carpeta = 'docs';
                break;
            case 1:
                $carpeta = 'full-slider';
                break;
            case 2:
                $carpeta = 'short-slider';
                break;
            case 3:
                $carpeta = 'relateds';
                break;
            case 4:
                $carpeta = 'recursos';
                break;
            case 5:
                $carpeta = 'politicas';
                break;
            default:
                $carpeta = 'otros';
                break;
        }
        return $carpeta;
    }

}
