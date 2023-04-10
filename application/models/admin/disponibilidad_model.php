<?php

class Disponibilidad_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_disponibilidad($id_producto){
        $data = array();
        if ( !empty($id_producto ) ) {  //Consulta a la base de datos mediante $id_producto
            $disponibilidad = $this->db->query("SELECT * FROM disponibilidad WHERE id_producto = ?;",array($id_producto))->row_array(); 
            //if ( $disponibilidad->num_rows() > 0 ) {
            if ( !empty($disponibilidad) ) {
                $data[] = array(
                    "id"                => $disponibilidad['id_disponibilidad'],
                    "title"             => $disponibilidad['descripcion_disponibilidad'],
                    "start"             => $disponibilidad['fecha_inicio'],
                    "end"               => $disponibilidad['fecha_fin'],
                    "color"             => $disponibilidad['color_disponibilidad'],
                    "dias_activos"      => json_decode($disponibilidad['dias_activos'],true),
                    "dias_no_activos"   => json_decode($disponibilidad['dias_no_activos'],true),
                    "dias_especiales"   => !empty($disponibilidad['dias_especiales'])?json_decode($disponibilidad['dias_especiales'],true):[],
                    "meses_inactivos"   => !empty($disponibilidad['meses_inactivos'])?json_decode($disponibilidad['meses_inactivos'],true):[],
                );
            }           
        }
        return json_encode($data);
    }

    //Retorna disponibilidad con id NULL para que vuelvan a ser insertados cuando la actividad este siendo clonado
    function get_disponibilidad_clonar($id_producto){
        $data = array();
        if ( !empty($id_producto ) ) {  //Consulta a la base de datos mediante $id_producto
            $disponibilidad = $this->db->query("SELECT * FROM disponibilidad WHERE id_producto = ?;",array($id_producto))->row_array(); 
            //if ( $disponibilidad->num_rows() > 0 ) {
            if ( !empty($disponibilidad) ) {
                $data[] = array(
                    "id"                => null,
                    "title"             => $disponibilidad['descripcion_disponibilidad'],
                    "start"             => $disponibilidad['fecha_inicio'],
                    "end"               => $disponibilidad['fecha_fin'],
                    "color"             => $disponibilidad['color_disponibilidad'],
                    "dias_activos"      => json_decode($disponibilidad['dias_activos'],true),
                    "dias_no_activos"   => json_decode($disponibilidad['dias_no_activos'],true),
                    "dias_especiales"   => !empty($disponibilidad['dias_especiales'])?json_decode($disponibilidad['dias_especiales'],true):[],
                    "meses_inactivos"   => !empty($disponibilidad['meses_inactivos'])?json_decode($disponibilidad['meses_inactivos'],true):[],
                );
            }           
        }
        return json_encode($data);
    }
    
    function get_all_disponibilidades(){
        $disponibilidades = $this->db->query("SELECT * FROM disponibilidad WHERE 1 = 1;")->result_array();
        return $disponibilidades;
    }
    
    function add_disponibilidad($params){
        $this->db->insert('disponibilidad',$params);
        return $this->db->insert_id();
    }
    
    function update_disponibilidad($id_codigo_disponibilidad,$id_disponibilidad,$params){
        $this->db->where('id_disponibilidad',$id_disponibilidad);
        $response = $this->db->update('disponibilidad',$params);
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
    
    function delete_disponibilidad($id){
        $response = $this->db->delete('disponibilidad',array('id_disponibilidad'=>$id));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }

    function delete_disponibilidad_producto($idproducto){
        $response = $this->db->delete('disponibilidad',array('id_producto'=>$idproducto));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }

}




    function delete_disponibilidad_producto($id_producto){
        $response = $this->db->delete('disponibilidad',array('id_producto'=>$id_producto));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }

    function add_disponibilidad_producto($params){
        //$this->delete_disponibilidad_producto($params['id_producto']);
        $this->db->insert('disponibilidad',$params);
        return $this->db->insert_id();
    }
    /*
    function get_disponibilidad_producto($id_producto,$tipo){
        $data = array();
        $disponibilidad = $this->db->query("SELECT * FROM disponibilidad WHERE id_producto = ? AND tipo_disponibilidad = ?;",array($id_producto,$tipo))->result_array();
        if ($disponibilidad) {
            foreach ($disponibilidad as $key => $value) {
                $data[] = $value['data_disponibilidad'];
            }
            return $data;
        }else{
            return [];
        }
    }
    */
    
    

    function get_disponibilidad_producto_disponibilidad($id_producto){
        $disponibilidad = $this->db->query("SELECT * FROM disponibilidad WHERE id_producto = ? ;",array($id_producto))->row_array();

        if (isset($disponibilidad['data_disponibilidad']) ) {
            return $disponibilidad['data_disponibilidad'];
        }else{
            return [];
        }
    }

    function get_disponibilidad_producto_bloqueo($id_producto){
        $bloqueo = $this->db->query("SELECT * FROM disponibilidad WHERE id_producto = ?;",array($id_producto))->row_array();
        if ( isset($bloqueo['data_disponibilidad'] ) ) {
            return $bloqueo['data_disponibilidad'];
        }else{
            return [];
        }
    }

