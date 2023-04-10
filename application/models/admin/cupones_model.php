<?php
class Cupones_model extends CI_Model { 
   public function __construct() {
      parent::__construct();
      $this->id_user_actual = $this->session->userdata('id_usuarios');
   }
   public function procesarCupones($data,$editar){ // editar tiene el id de la etapa edad
      if($editar){
        $this->db->where('id_cupon', $editar)->where('id_usuarios',$this->id_user_actual)->update('cupon', $data);
        $estado = $this->db->affected_rows();
      } else {
        $data['id_usuarios'] = $this->id_user_actual;
        $this->db->insert('cupon', $data); 
        $estado = $this->db->insert_id();
      }
      return $estado;
   }


   public function eliminar($id){
       $this->db->where('id_cupon', $id)->where('id_usuarios',$this->id_user_actual)->delete('cupon');
      // se eliminará los relacionados en detalle_precio
    // $this->db->where('id_etapa_edad', $id)->delete('detalle_precio');
     return $this->db->affected_rows();
   }
   public function obtenerDatos(){ // uno solo
      $resultado = $this->db->query("SELECT * FROM cupon WHERE id_usuarios=$this->id_user_actual")->result_array();
      return $resultado;
   }
   /*ahora para operar nacionalidades*/
   public function procesarNacionalidades($data,$editar){ // editar tiene el id de la etapa edad
      if($editar){
        $this->db->where('id_nacionalidad', $editar)->where('id_usuarios',$this->id_user_actual)->update('nacionalidad', $data);
        $estado = $this->db->affected_rows();
      } else {
        $data['id_usuarios'] = $this->id_user_actual;
        $this->db->insert('nacionalidad', $data);
        $estado = $this->db->insert_id();
      } 
      return $estado;
   }


   public function eliminarNacionalidad($id){ 
      $this->db->where('id_nacionalidad', $id)->where('id_usuarios',$this->id_user_actual)->delete('nacionalidad');
      return $this->db->affected_rows();
   }

   
}