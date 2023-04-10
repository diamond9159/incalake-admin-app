<?php

class Propietario_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function validar($table,$id_table){
        switch ($table) {
            case "oferta":
                    
            break;
            case "disponibilidad":

            break;

            case "categoria":

            break;

            case "metodo_pago":

            break;
            case "recurso":
                $recurso_response  = $this->db->query("SELECT cs.*,r.id_recurso, p.titulo_producto FROM codigo_servicio as cs LEFT JOIN servicio as s ON cs.id_codigo_servicio = s.codigo_servicio_id_codigo_servicio LEFT JOIN producto as p ON p.id_servicio = s.id_servicio LEFT JOIN recurso_has_producto as rhp ON p.id_producto = rhp.id_producto LEFT JOIN recurso as r ON r.id_recurso = rhp.id_recurso WHERE r.id_recurso = ".$id_table.";")->row_array();
                if( !empty($recurso_response['id_usuarios']) ){
                    if ( $recurso_response['id_usuarios'] === $this->session->userdata('id_usuarios') ) {
                        return true;
                    }
                }
                return false;
            break;

            case "servicio":

            break;
            default:
                return false;            
            break;
        }
    }

    /*
    function get_propietario($id_propietario){
        return $this->db->get_where('lugar',array('id_propietario'=>$id_propietario))->row_array();
    }
    
    function get_all_propietarioes(){
        return $this->db->get('lugar')->result_array();
    }
    
    function add_propietario($params){
        $this->db->insert('lugar',$params);
        return $this->db->insert_id();
    }
    
    function update_propietario($id_propietario,$params){
        $this->db->where('id_propietario',$id_propietario);
        $response = $this->db->update('lugar',$params);
        if($response){
            return "lugar updated successfully";
        }
        else{
            return "Error occuring while updating lugar";
        }
    }
    
    function delete_propietario($id_propietario){
        $response = $this->db->delete('lugar',array('id_propietario'=>$id_propietario));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }
    */
}
