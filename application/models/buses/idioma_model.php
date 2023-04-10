<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Idioma_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_idioma($id_idioma){
        return $this->dbBuses->get_where('idioma',array('id_idioma'=>$id_idioma))->row_array();
    }
    
    function get_all_idiomas_count(){
        $this->dbBuses->from('idioma');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_idiomas($params = array()){
        $this->dbBuses->order_by('id_idioma', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('idioma')->result_array();
    }   
    
    function get_select_all_idiomas(){
        return $this->dbBuses->get('idioma')->result_array();
    }

    function add_idioma($params){
        $this->dbBuses->insert('idioma',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_idioma($id_idioma,$params){
        $this->dbBuses->where('id_idioma',$id_idioma);
        return $this->dbBuses->update('idioma',$params);
    }
    
    function delete_idioma($id_idioma){
        return $this->dbBuses->delete('idioma',array('id_idioma'=>$id_idioma));
    }
}
