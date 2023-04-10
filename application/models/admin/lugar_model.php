<?php

class Lugar_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_lugar($id_lugar){
        return $this->db->get_where('lugar',array('id_lugar'=>$id_lugar))->row_array();
    }
    
    function get_all_lugares(){
        return $this->db->get('lugar')->result_array();
    }
    
    function add_lugar($params){
        $this->db->insert('lugar',$params);
        return $this->db->insert_id();
    }
    
    function update_lugar($id_lugar,$params){
        $this->db->where('id_lugar',$id_lugar);
        $response = $this->db->update('lugar',$params);
        if($response){
            return "lugar updated successfully";
        }
        else{
            return "Error occuring while updating lugar";
        }
    }
    
    function delete_lugar($id_lugar){
        $response = $this->db->delete('lugar',array('id_lugar'=>$id_lugar));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }
}
