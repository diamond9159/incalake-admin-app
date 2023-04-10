<?php
class Aeropuertos_model extends CI_Model { 
   public function __construct() {
      parent::__construct();
      
      $this->aeroDB = $this->load->database('aeropuerto', TRUE);
   }

   // agregar o editar link (url)
   public function procesarSectores($data,$editar){ 
      if($editar){
        $this->aeroDB->where('id_sector', $editar)->update('sectores', $data);
        $estado = $this->aeroDB->affected_rows();
      } else {
        $this->aeroDB->insert('sectores', $data); 
        $estado = $this->aeroDB->insert_id();
      }
      return $estado;
   }


   public function eliminar_sector($id){
       $this->aeroDB->where('id_sector', $id)->delete('sectores');
       return $this->aeroDB->affected_rows();
   }
   // 
   public function eliminar_vuelo($id){
        $this->aeroDB->where('id_vuelo', $id)->delete('vuelos');
        return $this->aeroDB->affected_rows();
    }
   //

   public function obtenerSectores(){ 
      $resultado = $this->aeroDB->query("SELECT * FROM sectores")->result_array();
      $new_array=[];
      foreach($resultado as $value){
        $new_array[$value['id_sector']] = $value;
        $new_array[$value['id_sector']]['valores_sector'] = $value['valores_sector']?$value['valores_sector']:'[]';
      }
      return $new_array;
   }
   // 
   public function obtenerVuelos(){ 
    $resultado = $this->aeroDB->query("SELECT * FROM vuelos")->result_array();
    
    return $resultado;
 }
 // 
    public function update_precios($datos,$id){ 
      $this->aeroDB->where('id_sector', $id)->update('sectores', $datos);
      return $this->aeroDB->affected_rows();
   }
  //
  public function procesarVuelos($data,$editar){ 
    if($editar){
      $this->aeroDB->where('id_vuelo', $editar)->update('vuelos', $data);
      $estado = $this->aeroDB->affected_rows();
    } else {
      $this->aeroDB->insert('vuelos', $data); 
      $estado = $this->aeroDB->insert_id();
    }
    return $estado;
 }
 /////// configuraciones //
 
  public function obtenerConfiguraciones(){ 
      $resultado = $this->aeroDB->query("SELECT * FROM configuraciones")->row_array();
      
      return $resultado;
  }
  public function procesarTasas($datos){ 
    $this->aeroDB->where('id_conf', 1)->update('configuraciones', $datos);
    return $this->aeroDB->affected_rows();
  }
}