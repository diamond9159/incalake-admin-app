<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lugar_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_lugar($id_lugar){
        return $this->dbBuses->get_where('lugares',array('id_lugar'=>$id_lugar))->row_array();
    }
    
    function get_all_lugares_count(){
        $this->dbBuses->from('lugares');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_lugares($params = array()){
        $this->dbBuses->order_by('id_lugar', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('lugares')->result_array();
    }
        
    function add_lugar($params){
        $this->dbBuses->insert('lugares',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_lugar($id_lugar,$params){
        $this->dbBuses->where('id_lugar',$id_lugar);
        return $this->dbBuses->update('lugares',$params);
    }
    
    function delete_lugar($id_lugar){
        return $this->dbBuses->delete('lugares',array('id_lugar'=>$id_lugar));
    }

    function get_lugaresBus($id_bus){
        $data = [];
        $response = $this->dbBuses->query("SELECT * FROM bus_has_lugares AS bhl JOIN lugares AS lug ON lug.id_lugar = bhl.id_lugar AND bhl.id_bus = ? ORDER BY lug.orden_lugar ASC;",array($id_bus) )->result_array();
        if ( !empty($response) ) {
            foreach ($response as $key => $value) {
                $data[] = array(
                    'idb'           => (Integer)$value['id_bus'],
                    'idl'           => (Integer)$value['id_lugar'],
                    'nombre'        => $value['nombre_lugar'],
                    'descripcion'   => $value['nombre_lugar'],
                    'coordenadas'   => $value['coordenadas'],
                    'tipo'          => (Integer)$value['tipo_lugar'],
                    'orden'         => (Integer)$value['orden_lugar'],
                );
            }
        }
        return $data;
    }
    
}
