<?php
class Confpreciosm extends CI_Model { 
   public function __construct() {
      parent::__construct();
      $this->id_user_actual = $this->session->userdata('id_usuarios');
   }

   // editar tiene el id de la etapa edad
   public function procesarEdades($data,$editar){ 
      // si existe id se procede a editar
      if($editar){
        $this->db->where('id_etapa_edad', $editar)->where('id_usuarios',$this->id_user_actual)->update('etapa_edad', $data);
        $estado = $this->db->affected_rows();
      // si no existe crear un registro nuevo
      } else {
        $data['id_usuarios'] = $this->id_user_actual;
        $this->db->insert('etapa_edad', $data); 
        $estado = $this->db->insert_id();
      }
      return $estado;
   }

   // metodo eliminar edad
   public function eliminar($id){
       $this->db->where('id_etapa_edad', $id)->where('id_usuarios',$this->id_user_actual)->delete('etapa_edad');
       // se eliminará los relacionados en detalle_precio
       return $this->db->affected_rows();
   }

   // obetener lista de nacionalidades y edades para el index
   public function obtenerDatos(){ 
      $resultado['etapas_edad'] = $this->db->query("SELECT * FROM etapa_edad WHERE id_usuarios=$this->id_user_actual")->result_array();
      $resultado['nacionalidades'] = $this->db->query("SELECT * FROM nacionalidad WHERE id_usuarios=$this->id_user_actual")->result_array();
      return $resultado;
   }

   // metodo para registrar / editar nacionalidades
   public function procesarNacionalidades($data,$editar){ 
      // editar tiene el id de la etapa edad si existe entoces se edita
      if($editar){
        $this->db->where('id_nacionalidad', $editar)->where('id_usuarios',$this->id_user_actual)->update('nacionalidad', $data);
        $estado = $this->db->affected_rows();
      
      // si no existe id se crea un nuevo registro
      } else {
        $data['id_usuarios'] = $this->id_user_actual;
        $this->db->insert('nacionalidad', $data);
        $estado = $this->db->insert_id();
      } 
      return $estado;
   }

   // metodo de eliminar nacionalidad
   public function eliminarNacionalidad($id){ 
      $this->db->where('id_nacionalidad', $id)->where('id_usuarios',$this->id_user_actual)->delete('nacionalidad');
      return $this->db->affected_rows();
   }

   
}