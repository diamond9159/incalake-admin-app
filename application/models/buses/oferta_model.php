<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oferta_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_oferta($id_oferta){
        return $this->dbBuses->get_where('oferta',array('id_oferta'=>$id_oferta))->row_array();
    }
    
    function get_all_ofertas_count(){
        $this->dbBuses->from('oferta');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_ofertas($params = array()){
        $this->dbBuses->order_by('id_oferta', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('oferta')->result_array();
    }
        
    function add_oferta($params){
        $this->dbBuses->insert('oferta',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_oferta($id_oferta,$params){
        $this->dbBuses->where('id_oferta',$id_oferta);
        return $this->dbBuses->update('oferta',$params);
    }
    
    function delete_oferta($id_oferta){
        return $this->dbBuses->delete('oferta',array('id_oferta'=>$id_oferta));
    }

    function delete_ofertaBus($id_bus){
        return $this->dbBuses->delete('oferta',array('id_bus'=>$id_bus));
    }

    function operarOfertaBus($idBus,$data){
        $arrayData = json_decode($data,true);
        if (!empty($arrayData)) {
            $this->delete_ofertaBus($idBus);
            foreach ($arrayData as $key => $value) {
                $params = array(
                    "valor_oferta"          => @$value['descuento'],
                    "tipo_oferta"           => @$value['tipo_descuento'],
                    "fecha_inicio"          => @$value['start'],
                    "fecha_fin"             => @$value['end'],
                    "color_oferta"          => @$value['color'],
                    "descripcion_oferta"    => @$value['']?mb_strtoupper(trim(@$value['title'])):"OFERTA",
                    "id_bus"                => @$idBus,
                );            
                //if ( !empty($value['id']) ) {
                //    $this->update_oferta($idBus,$params);
                //}else{
                //    $this->add_oferta($params);
                //}
                $this->add_oferta($params);
            }
        }
    }

    function get_ofertasBus($id_bus){
        $data = [];
        $response = $this->dbBuses->get_where('oferta',array('id_bus'=>$id_bus))->result_array();
        if ( !empty($response) ) {
            foreach ($response as $key => $value) {
                $data[] = array(
                    "title"             => $value['descripcion_oferta'],
                    "descuento"         => $value['valor_oferta'],
                    "tipo_descuento"    => $value['tipo_oferta'],
                    "start"             => $value['fecha_inicio'],
                    "end"               => $value['fecha_fin'],
                    "color"             => $value['color_oferta'],
                    "id"                => $value['id_oferta'],
                );   
            }
        }   
        return $data;
    }   
    
}
