<?php
class Preguntas_model extends CI_Model { 
    public function __construct() {
      parent::__construct();
      // la siguiente linea pueda que sea necesario en un futuro para mostrar solo preguntas del usuario actual
      //$this->id_user_actual = $this->session->userdata('id_usuarios');
    }
    // metodo para obtener taoda las preguntas
    public function obtenerPreguntas(){
       $resultado = $this->db->query("SELECT id,nombre,actividad,fecha,leido FROM preguntas ORDER BY fecha DESC")->result_array();
       return $resultado;
    }
    // metodo para obtener toda la informacion detallada de una pregunta
    public function detallesPregunta($id){
      $resultado = $this->db->query("SELECT * FROM preguntas WHERE id=$id")->row_array();
      // si hay resultado cambiar su estado (LEIDO) en 1 que indica que ha sido leido 
      if($resultado){
        $datos['leido']=1;
        $this->db->where("id",$id)->update('preguntas',$datos);
      }
      // fin de cambiar en leido
      return $resultado;
      
    }

    function get_pregunta($id_pregunta){
        return $this->db->query("SELECT * FROM preguntas WHERE id = ?;",array($id_pregunta))->row_array();
    }
    
    function delete_pregunta($id_pregunta){
        $response = $this->db->delete('preguntas',array('id'=>$id_pregunta));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }
}