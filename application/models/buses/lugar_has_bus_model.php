<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lugar_has_bus_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model("buses/Lugar_model");
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_lugar_has_bus($id_bus){
        return $this->dbBuses->get_where('bus_has_lugares',array('id_bus'=>$id_bus))->row_array();
    }
    
    function get_all_lugar_has_buses_count(){
        $this->dbBuses->from('bus_has_lugares');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_lugar_has_buses($params = array()){
        $this->dbBuses->order_by('id_bus', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('bus_has_lugares')->result_array();
    }
        
    function add_lugar_has_bus($idBus,$params){
        if ( !empty($params) ) {
            $this->delete_lugar_has_bus($idBus);
            $arrayLugares = json_decode($params,true);
            foreach ($arrayLugares as $key => $value) {
                $paramsLugares = array(
                    "nombre_lugar"  => $value['nombre'],
                    "coordenadas"   => $value['coordenadas'],
                    "tipo_lugar"    => $value['tipo'],
                    "orden_lugar"   => $value['orden'],
                );
                $idLugar = $this->Lugar_model->add_lugar($paramsLugares);
                $this->dbBuses->insert('bus_has_lugares',array("id_bus"=>$idBus,"id_lugar"=>$idLugar) );
                $idBHL = $this->dbBuses->insert_id();
            }
        }
        //$this->dbBuses->insert('bus_has_lugares',$params);
        //return $this->dbBuses->insert_id();
        return true;
    }
    
    function update_lugar_has_bus($id_bus,$params){
        $this->dbBuses->where('id_bus',$id_bus);
        return $this->dbBuses->update('bus_has_lugares',$params);
    }
    
    function delete_lugar_has_bus($id_bus){
        return $this->dbBuses->delete('bus_has_lugares',array('id_bus'=>$id_bus));
    }
}
