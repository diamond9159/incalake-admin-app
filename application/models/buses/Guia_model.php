<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guia_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_guia($id_guia){
        return $this->dbBuses->get_where('guia',array('id_guia'=>$id_guia))->row_array();
    }
    
    function get_all_guias_count(){
        $this->dbBuses->from('guia');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_guias($params = array()){
        $this->dbBuses->order_by('id_guia', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('guia')->result_array();
    }   
    
    function get_select_all_guias($idioma  = "es"){
        //return $this->dbBuses->get('guia')->result_array();
        return $this->dbBuses->query("SELECT * FROM idioma AS idi JOIN guia AS gui ON gui.id_idioma = idi.id_idioma AND idi.codigo = ?;",array($idioma))->result_array();
    }

    function add_guia($params){
        $this->dbBuses->insert('guia',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_guia($id_guia,$params){
        $this->dbBuses->where('id_guia',$id_guia);
        return $this->dbBuses->update('guia',$params);
    }
    
    function delete_guia($id_guia,$codigo_guia){
        //return $this->dbBuses->delete('guia',array('id_guia'=>$id_guia));
        return $this->dbBuses->delete('guia',array('id_codigo_guia'=>$codigo_guia));
    }

    function delete_guiaBus($id_bus,$codigo_guia){
        return $this->dbBuses->delete('guia_has_bus',array('id_bus'=>$id_bus));    
    }

    function get_guiasBus($idBus = null, $idioma = "es"){
        return $this->dbBuses->query("SELECT idi.*, gui.*, ghb.id_guia AS ghb_id_guia, ghb.id_bus AS ghb_id_bus FROM idioma AS idi JOIN guia AS gui ON gui.id_idioma = idi.id_idioma AND idi.codigo = ? LEFT JOIN guia_has_bus AS ghb ON gui.id_guia = ghb.id_guia AND ghb.id_bus = ?;", array($idioma,$idBus) )->result_array();
    }

    function add_guiaBus($params){
        $this->dbBuses->insert('guia_has_bus',$params);
        return $this->dbBuses->insert_id();
    }

    function operarGuias($idBus,$data){
        if (!empty($data)) {
            $this->delete_guiaBus($idBus);
            foreach ($data as $key => $value) {
                $params = array(
                    "id_guia" => $value,
                    "id_bus"  => $idBus,        
                );
                $this->add_guiaBus($params);
            }
        }
    }

    function add_codigoGuia(){
        $params = array(
            "codigo_guia" => "GUIA*".date('Y-m-d h:i:s'),
        );        
        $this->dbBuses->insert('codigo_guia',$params);
        return $this->dbBuses->insert_id();
    }

    function get_editGuia( $codigo_guia ){
        return $this->dbBuses->query("SELECT * FROM idioma AS idi LEFT JOIN guia AS gui ON idi.id_idioma = gui.id_idioma AND gui.id_codigo_guia = ?;", array($codigo_guia) )->result_array();
    }
}
