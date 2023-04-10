<?php

class Metodopago_model extends CI_Model{
    function __construct(){
        parent::__construct();
    } 

    function get_metodopago($id_metodopago){
        $metodo_pago = $this->db->query("SELECT * FROM metodo_pago WHERE id_metodo_pago = ?;",array($id_metodopago))->row_array();
        return $metodo_pago;
    }

    function get_all_metodopagos(){
        $metodo_pagos = $this->db->query("SELECT * FROM metodo_pago WHERE 1 = 1;")->result_array();
        return $metodo_pagos;
    }

    function add_metodopago($params){
        $this->db->insert('metodo_pago',$params);
        return $this->db->insert_id();
    }
    
    function update_metodopago($id_metodopago,$params){
        $this->db->where('id_metodo_pago',$id_metodopago);
        $response = $this->db->update('metodo_pago',$params);
        if($response){
            return true;
        }else{
            return false;
        }
    }

    function delete_metodopago($id_metodopago){
        $data = array();
        $response = $this->db->delete('metodo_pago',array('id_metodo_pago'=>$id_metodopago));
        if($response){
            $data['response'] = 'OK';
            $data['message']  = 'Se ha eliminado correctamente.';
        } else {
            $data['response'] = 'ERROR';
            $data['message']  = 'no se ha podido eliminar el registro.';
        }
        echo json_encode($data);
    }

    function get_metodo($idProducto){
        return $this->db->query("SELECT * FROM producto WHERE id_producto = ? LIMIT 1;",array($idProducto))->row_array();
    }

    function actualizar_metodopago($id_producto,$params){
        $this->db->where('id_producto',$id_producto);
        $response = $this->db->update('producto',$params);
        if($response){
            return true;
        }else{
            return false;
        }
    }

    function actualizar_metodopago_por_codigo_producto($id_codigo_producto,$params){
        $this->db->where('id_codigo_producto',$id_codigo_producto);
        $response = $this->db->update('producto',$params);
        if($response){
            return true;
        }else{
            return false;
        }
    }
}
