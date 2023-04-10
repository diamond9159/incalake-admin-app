<?php
class Clientesavt_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_clientes($id_cliente){
        $cliente_avt = $this->db->query("SELECT * FROM administracion_clientes_avt WHERE id_cliente = ?;",array($id_cliente))->row_array();
        return $cliente_avt;
    }
    function get_all_clientes(){
        $clientes_avt = $this->db->query("SELECT * FROM administracion_clientes_avt WHERE 1 = 1 ORDER BY `id_cliente` DESC;")->result_array();
        return $clientes_avt;
    }
    function add_cliente($params){
        $this->db->insert('administracion_clientes_avt',$params);
        return $this->db->insert_id();
    }
    function update_cliente($id_cliente,$params){
        $this->db->where('id_cliente',$id_cliente);
        return $this->db->update('administracion_clientes_avt',$params);
    }
    function delete_cliente($id_cliente){
        return $this->db->delete('administracion_clientes_avt',array('id_cliente'=>$id_cliente));
    } 
    function get_ultimate_row(){
        $cliente_avt = $this->db->query("SELECT * FROM administracion_clientes_avt ORDER by id_cliente DESC limit 1")->row_array();
        return $cliente_avt;
    }
    
}
