<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disponibilidad_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_disponibilidad($id_disponibilidad){
        return $this->dbBuses->get_where('disponibilidad',array('id_disponibilidad'=>$id_disponibilidad))->row_array();
    }
    
    function get_all_disponibilidades_count(){
        $this->dbBuses->from('disponibilidad');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_disponibilidades($params = array()){
        $this->dbBuses->order_by('id_disponibilidad', 'desc');
        if(isset($params) && !empty($params) ){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('disponibilidad')->result_array();
    }
        
    function add_disponibilidad($params){
        $this->dbBuses->insert('disponibilidad',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_disponibilidad($id_disponibilidad,$params){
        $this->dbBuses->where('id_disponibilidad',$id_disponibilidad);
        return $this->dbBuses->update('disponibilidad',$params);
    }
    
    function delete_disponibilidad($id_disponibilidad){
        return $this->dbBuses->delete('disponibilidad',array('id_disponibilidad'=>$id_disponibilidad));
    }

    function delete_disponibilidadBus($id_bus){
        return $this->dbBuses->delete('disponibilidad',array('id_bus'=>$id_bus));
    }

    /******************************************************************************************************/
    /******************************************************************************************************/
    /******************************************************************************************************/

    function operarDisponibilidadBus($idBus,$data){
        $arrayData = json_decode($data,true);
        $params = array(
            "descripcion_disponibilidad"=> @$arrayData[0]['title']?mb_strtoupper(trim(@$arrayData[0]['title'])):"DISPONIBLE",   
            "fecha_inicio"              => @$arrayData[0]['start'],
            "fecha_fin"                 => @$arrayData[0]['end'], 
            "color_disponibilidad"      => @$arrayData[0]['color'],
            "dias_activos"              => json_encode(@$arrayData[0]['dias_activos']),
            "dias_no_activos"           => json_encode(@$arrayData[0]['dias_no_activos']),
            "dias_especiales"           => json_encode(@$arrayData[0]['dias_especiales']),
            "meses_inactivos"           => json_encode(@$arrayData[0]['meses_inactivos']),    
            "id_bus"                    => $idBus,
        );

        $this->delete_disponibilidadBus($idBus);
        $this->add_disponibilidad($params);

        //if ( @$arrayData[0]['id'] ) {   /* Si existe entonces actualizamos */
        //    $this->update_disponibilidad(@$arrayData[0]['id'],$params);
        //} else {  /* Si no existe entonces creamos un  uevo registro */ 
        //    $this->add_disponibilidad($params);
        //}
    }
    function get_disponibilidadBus($id_bus){
        $data = [];
        $response = $this->dbBuses->get_where('disponibilidad',array('id_bus'=>$id_bus))->result_array();
        if ( !empty($response) ) {
            foreach ($response as $key => $value) {
                $data[] = array(
                    "id"                => $value['id_disponibilidad'],
                    "start"             => $value['fecha_inicio'],
                    "end"               => $value['fecha_fin'],
                    "title"             => $value['descripcion_disponibilidad'],
                    "color"             => $value['color_disponibilidad'],
                    "dias_activos"      => json_decode( $value['dias_activos'],   true ),
                    "dias_no_activos"   => json_decode( $value['dias_no_activos'],true ),
                    "dias_especiales"   => json_decode( $value['dias_especiales'],true ),
                    "meses_inactivos"   => json_decode( $value['meses_inactivos'],true ),
                );            
            }            
        }
        return $data;
    }

    /******************************************************************************************************/
    /******************************************************************************************************/
    /******************************************************************************************************/

}
