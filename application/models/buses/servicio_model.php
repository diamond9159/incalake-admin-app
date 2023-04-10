<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicio_model extends CI_Model { 
   public function __construct() {
      parent::__construct();
      // obtener el usuario actual loggeado
      $this->busesDB = $this->load->database('buses', TRUE);
   } 
  public function obtenerServicios(){ 
    $resultados = $this->busesDB->query("SELECT * FROM servicio")->result_array();
    return $resultados;
  }

  public function obtenerIdiomas(){ 
      $resultado = $this->busesDB->query("SELECT * FROM idioma WHERE codigo != 'es'")->result_array();
      return $resultado;
  }
  public function buscar_servicio($id_servicio){ 
    $resultado = $this->busesDB->query("SELECT * FROM servicio WHERE id_servicio = '$id_servicio'")->row_array();
    return $resultado;
  }
   /* registro del bus */
  public function registrar_servicio($data){ 
       // $this->busesDB->set('fecha', 'NOW()', FALSE);
       $this->busesDB->insert('servicio', $data);
       return $this->busesDB->insert_id();
  }
  public function editar_servicio($data,$id_servicio){
       $this->busesDB->where('id_servicio', $id_servicio)->update('servicio', $data);
       return $this->busesDB->affected_rows();
  }

  public function eliminar_servicio($id_servicio){
    $this->busesDB->where('id_servicio', $id_servicio);
    $this->busesDB->delete('servicio'); 
    return $this->busesDB->affected_rows();
  }

}