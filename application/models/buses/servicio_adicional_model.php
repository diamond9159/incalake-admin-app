<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicio_adicional_model extends CI_Model { 
   public function __construct() {
      parent::__construct();
      // obtener el usuario actual loggeado
      $this->busesDB = $this->load->database('buses', TRUE);
   } 
  public function obtenerServiciosAdicionales(){ 
    $resultados = $this->busesDB->query("SELECT id_servicio_adicional,nombre_servicio_adicional,icono_servicio_adicional FROM servicio_adicional")->result_array();
    return $resultados;
  }

  public function obtenerIdiomas(){ 
      $resultado = $this->busesDB->query("SELECT * FROM idioma WHERE codigo != 'es'")->result_array();
      return $resultado;
  }
  public function buscar_servicio_adicional($id_servicio_adicional){ 
    $resultado = $this->busesDB->query("SELECT * FROM servicio_adicional WHERE id_servicio_adicional = '$id_servicio_adicional'")->row_array();
    return $resultado;
  }
   /* registro del bus */
  public function registrar_servicio_adicional($data){ 
       // $this->busesDB->set('fecha', 'NOW()', FALSE);
       $this->busesDB->insert('servicio_adicional', $data);
       return $this->busesDB->insert_id();
  }
  public function editar_servicio_adicional($data,$id_servicio){
       $this->busesDB->where('id_servicio_adicional', $id_servicio)->update('servicio_adicional', $data);
       return $this->busesDB->affected_rows();
  }

  public function eliminar_servicio_adicional($id_servicio){
    $this->busesDB->where('id_servicio_adicional', $id_servicio);
    $this->busesDB->delete('servicio_adicional'); 
    return $this->busesDB->affected_rows();
  }

}