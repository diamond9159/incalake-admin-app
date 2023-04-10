<?php
class Proveedores_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_proveedores($id_proveedor){
        $proveedor = $this->db->query("SELECT * FROM administracion_proveedores WHERE id_proveedor = ?;",array($id_proveedor))->row_array();
        return $proveedor;
    }
    function get_all_proveedores(){
        $proveedores = $this->db->query("SELECT * FROM administracion_proveedores WHERE 1 = 1 ORDER BY `id_proveedor` DESC;")->result_array();
        return $proveedores;
    }
    function add_proveedor($params){
        $this->db->insert('administracion_proveedores',$params);
        return $this->db->insert_id();
    }
    function update_proveedor($id_proveedor,$params){
        $this->db->where('id_proveedor',$id_proveedor);
        return $this->db->update('administracion_proveedores',$params);
    }
    function delete_proveedor($id_proveedor){
        return $this->db->delete('administracion_proveedores',array('id_proveedor'=>$id_proveedor));
    } 
    function get_ultimate_row(){
        $proveedor = $this->db->query("SELECT * FROM administracion_proveedores ORDER by id_proveedor DESC limit 1")->row_array();
        return $proveedor;
    }
    
}
