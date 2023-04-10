<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Empresa_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_empresa($id_empresa){
        $resultado = $this->dbBuses->get_where('empresa',array('id_empresa'=>$id_empresa))->row_array();
        $resultado['url_logo_empresa'] = $this->db->query("SELECT url_archivo FROM galeria WHERE id_galeria = '{$resultado['logo_empresa']}'")->row_array()['url_archivo'];
        return $resultado;
    }
    
    function get_all_empresas_count(){
        $this->dbBuses->from('empresa');
        return $this->dbBuses->count_all_results();
    }
        
    /*
     * Get all empresas
     */
    function get_all_empresas($params = array())
    {
        $this->dbBuses->order_by('id_empresa', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        $resultado = $this->dbBuses->get('empresa')->result_array();
        foreach($resultado as $key => $value){
            $resultado[$key] = $value;
        $resultado[$key]['logo_empresa'] = $this->db->query("SELECT carpeta_archivo,url_archivo FROM galeria WHERE id_galeria = '{$value['logo_empresa']}'")->row_array();
        }
        return ($resultado);
    }
        
    /*
     * function to add new empresa
     */
    function add_empresa($params)
    {
        $this->dbBuses->insert('empresa',$params);
        return $this->dbBuses->insert_id();
    }
    
    /*
     * function to update empresa
     */
    function update_empresa($id_empresa,$params)
    {
        $this->dbBuses->where('id_empresa',$id_empresa);
        return $this->dbBuses->update('empresa',$params);
    }
    
    /*
     * function to delete empresa
     */
    function delete_empresa($id_empresa)
    {
        return $this->dbBuses->delete('empresa',array('id_empresa'=>$id_empresa));
    }
}
