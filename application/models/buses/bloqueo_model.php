<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bloqueo_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_bloqueo($id_bloqueo){
        return $this->dbBuses->get_where('bloqueo',array('id_bloqueo'=>$id_bloqueo))->row_array();
    }
    
    function get_all_bloqueos_count(){
        $this->dbBuses->from('bloqueo');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_bloqueos($params = array()){
        $this->dbBuses->order_by('id_bloqueo', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('bloqueo')->result_array();
    }
        
    function add_bloqueo($params){
        $this->dbBuses->insert('bloqueo',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_bloqueo($id_bloqueo,$params){
        $this->dbBuses->where('id_bloqueo',$id_bloqueo);
        return $this->dbBuses->update('bloqueo',$params);
    }
    
    function delete_bloqueo($id_bloqueo){
        return $this->dbBuses->delete('bloqueo',array('id_bloqueo'=>$id_bloqueo));
    }

    function delete_bloqueoBus($id_bus){
        return $this->dbBuses->delete('bloqueo',array('id_bus'=>$id_bus));
    }

    /******************************************************************************************************/
    /******************************************************************************************************/
    function  operarBloqueoBus($idBus,$data){
        $arrayData = json_decode($data,true);
        if ( !empty($arrayData) ) {
            $this->delete_bloqueoBus($idBus);
            foreach ($arrayData as $key => $value) {
                $params = array(
                    "descripcion_bloqueo"   => @$value['title']?mb_strtoupper(trim(@$value['title'])):"",
                    "fecha_inicio"          => @$value['start'],
                    "fecha_fin"             => @$value['end'],
                    "color_bloqueo"         => @$value['color'],
                    "id_bus"                => $idBus, 
                );
                //if ( @$value['id'] ) {
                //    $this->update_bloqueo($value['id'],$params);
                //}else{
                //    $this->add_bloqueo($params);
                //}
                $this->add_bloqueo($params);
            } 
        }
    }
    
    function get_bloqueosBus($id_bus){
        $data = [];
        $response = $this->dbBuses->get_where('bloqueo',array('id_bus'=>$id_bus))->result_array();
        if ( !empty($response) ) {
            foreach ($response as $key => $value) {
                $data[] = array(
                    "title" => $value['descripcion_bloqueo'],
                    "start" => $value['fecha_inicio'],
                    "end"   => $value['fecha_fin'],
                    "color" => $value['color_bloqueo'],
                    "id"    => $value['id_bloqueo'],
                );
            }
        }
        return $data;
    }
    /******************************************************************************************************/
    /******************************************************************************************************/
}
