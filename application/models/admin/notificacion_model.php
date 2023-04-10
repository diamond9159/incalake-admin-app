<?php

class Notificacion_model extends CI_Model{
    function __construct(){
        parent::__construct();
    } 

    function get_notificacion($id_notificacion){
        $notificacion = $this->db->query("SELECT * FROM notificacion WHERE id_notificacion = ? ORDER BY fecha_inicio DESC;",array($id_notificacion))->row_array();
        return $notificacion;
    }

    function get_all_notificaciones(){
        $notificacions = $this->db->query("SELECT * FROM notificacion WHERE 1 = 1 ;")->result_array();
        return $notificacions;
    }

    function add_notificacion($params){
        $this->db->insert('notificacion',$params);
        return $this->db->insert_id();
    }
    
    function update_notificacion($id_notificacion,$params){
        $this->db->where('id_notificacion',$id_notificacion);
        $response = $this->db->update('notificacion',$params);
        if($response){
            return true;
        }else{
            return false;
        }
    }

    function delete_notificacion($id_servicio,$id_notificacion){
        $response = $this->db->delete('notificacion',array('id_notificacion'=>$id_notificacion,'id_servicio' => $id_servicio  ));
        if($response){
            return true;
        } else {
            return false;
        }
    }

    function get_notificaciones_servicio($id_servicio){
        return $this->db->query("SELECT * FROM notificacion WHERE id_servicio = ? ORDER BY fecha_inicio DESC;",array($id_servicio))->result_array();
    }
}
