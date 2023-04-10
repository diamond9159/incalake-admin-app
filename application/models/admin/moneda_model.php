<?php
class Moneda_model extends CI_Model { 
   public function __construct() {
      parent::__construct();
      $this->id_user_actual = $this->session->userdata('id_usuarios');
   }
   public function procesarMonedas($data,$editar){ // editar tiene el id de la etapa edad
      if($editar){
        $this->db->where('id', $editar)->where('id_usuarios',$this->id_user_actual)->update('monedas', $data);
        $estado = $this->db->affected_rows();
      } else {
        $data['id_usuarios'] = $this->id_user_actual;
        $this->db->insert('monedas', $data); 
        $estado = $this->db->insert_id();
        //$estado = json_encode($data);
      }
      return $estado;
   }


   public function eliminar($id){
       $this->db->where('id', $id)->where('id_usuarios',$this->id_user_actual)->delete('monedas');
      // se eliminará los relacionados en detalle_precio
    // $this->db->where('id_etapa_edad', $id)->delete('detalle_precio');
     return $this->db->affected_rows();
   }
   public function obtenerMonedas(){ // uno solo
      //$resultado['etapas_edad'] = $this->db->query("SELECT * FROM etapa_edad WHERE id_usuarios=$this->id_user_actual")->result_array();
      $resultados = $this->db->query("SELECT id,nombre,codigo,simbolo,traducciones FROM monedas WHERE id_usuarios=$this->id_user_actual")->result_array();
      return $resultados;
   }
  

   
}