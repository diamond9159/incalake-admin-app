<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_buses extends CI_Model { 
   public function __construct() {
      parent::__construct();
      // obtener el usuario actual loggeado
      $this->busesDB = $this->load->database('buses', TRUE);
   } 
   public function obtenerEmpresas(){ 
      $resultado = $this->busesDB->query("SELECT * FROM empresa")->result_array();
      return $resultado;
   }
   public function obtenerServicios(){ 
    $resultado = $this->busesDB->query("SELECT id_servicio,nombre_servicio FROM servicio")->result_array();
    return $resultado;
  }
   public function obtenerServiciosAdicionales(){ 
    $resultado = $this->busesDB->query("SELECT * FROM servicio_adicional")->result_array();
    return $resultado;
  }
   public function obtenerLugares(){ 
    $resultado = $this->busesDB->query("SELECT * FROM lugares")->result_array();
    return $resultado;
 
   }
   public function buscar_pagina($id_pagina){ 
    $resultado = $this->busesDB->query("SELECT id_pagina,url_pagina,titulo_pagina,idioma.codigo AS cod_idioma,idioma.pais AS nombre_idioma FROM pagina_web JOIN idioma ON pagina_web.id_idioma = idioma.id_idioma WHERE id_pagina = $id_pagina")->row_array();
    return $resultado;
 
   }
   public function buscar_bus($id_bus){ 
    $query = "SELECT bus.*, 
              /*GROUP_CONCAT(DISTINCT bhp.id_lugar) AS paradas,*/
              GROUP_CONCAT(DISTINCT bhsa.id_servicio_adicional) AS servicios_adicionales,
              GROUP_CONCAT(DISTINCT bhg.id_galeria) AS galeria,
              tab.*
              FROM bus 
             /* LEFT JOIN bus_has_paradas AS bhp ON bhp.id_bus = bus.id_bus*/
              LEFT JOIN bus_has_servicio_adicional AS bhsa ON bhsa.id_bus = bus.id_bus
              LEFT JOIN tab ON tab.id_bus = bus.id_bus
              LEFT JOIN bus_has_galeria AS bhg ON bhg.id_bus = bus.id_bus
              WHERE bus.id_bus = $id_bus";
    $resultado = $this->busesDB->query($query)->row_array();
   // var_dump($resultado);
   if($resultado){
    $galeria_ids = $resultado['galeria']?$resultado['galeria']:0;
    $resultado['horarios'] = $this->busesDB->query("SELECT * FROM horarios WHERE id_bus = $id_bus")->result_array();
    $resultado['tabs_adicionales'] = $this->busesDB->query("SELECT * FROM tab_adicional WHERE id_bus = $id_bus")->result_array();
    $resultado['galeria'] = $this->db->query("SELECT id_galeria,url_archivo FROM galeria WHERE id_galeria IN ($galeria_ids)")->result_array();
   }
   
    return $resultado;
   }
   // metodo para obtener datos importantes (clonar)
   public function copiar_bus($id_codigo_bus){
      $result = $this->busesDB->query("SELECT id_bus FROM bus WHERE id_codigo_bus = $id_codigo_bus")->row_array();
      if(count($result)){
        return $this->buscar_bus($result['id_bus']);
      } else {
        return false;
      }
      
   }
   /* registro del bus */
   public function registrar_bus($data){ 
     //codigo producto 
        extract($data);
        // se obtiene laas siguientes variables $bus,$tab,$destinos,$horarios,$tab_adicional,$galeria
        // si no tiene codigo crear uno nuevo tambien se almacenara el id de usuario quien lo crea
        if(!+$bus['id_codigo_bus']){
          $codbus['codigo_bus'] = date('sihdmy');
          $this->busesDB->insert('codigo_bus', $codbus);
          $bus['id_codigo_bus'] = $this->busesDB->insert_id();
        }
       // bus
       // set fecha actual
       $this->busesDB->set('fecha', 'NOW()', FALSE);
       $this->busesDB->insert('bus', $bus);
       $id_bus=$this->busesDB->insert_id();
      

       // relacionar tab horarios destinos
       $tab['id_bus'] = $id_bus;
       $destinos['id_bus'] = $id_bus;


       $this->busesDB->insert('tab', $tab);// agregar tabs normal
       //$this->busesDB->insert('destinos', $destinos);// agregar destinos
       $this->insertarGaleria($galeria,$id_bus);
      // $this->insertarParadas($paradas,$id_bus);
       $this->insertarTabs($tab_adicional,$id_bus);
       $this->insertarServiciosAdicionales($servicio_adicional,$id_bus);
       $this->insertarHorarios($horarios,$id_bus);

       $detalles['id_bus'] = $id_bus;
       $detalles['id_codigo_bus'] = $bus['id_codigo_bus'];
       return $detalles;
   }
   public function editar_bus($data,$id_bus){
         // se obtiene laas siguientes variables $bus,$tab,$destinos,$horarios,$tab_adicional,$galeria
        extract($data);
        // actualizar bus
        $estado = $this->busesDB->where('id_bus', $id_bus)->update('bus', $bus);
        // actualizar tab
        $this->busesDB->where('id_bus', $id_bus)->update('tab', $tab);
        // actualizar destino
       // $this->busesDB->where('id_bus', $id_bus)->update('destinos', $destinos);

        // eliminar tab adicionales horarios y galeria
        $this->busesDB->delete('tab_adicional', array('id_bus' => $id_bus));
        $this->busesDB->delete('bus_has_galeria', array('id_bus' => $id_bus));
        //$this->busesDB->delete('bus_has_paradas', array('id_bus' => $id_bus));
        $this->busesDB->delete('bus_has_servicio_adicional', array('id_bus' => $id_bus));
        $this->busesDB->delete('horarios', array('id_bus' => $id_bus));

        // ingresar nuevos registros de horarios galeria , etc
        $this->insertarGaleria($galeria,$id_bus);
        // $this->insertarParadas($paradas,$id_bus);
        $this->insertarTabs($tab_adicional,$id_bus);
        $this->insertarServiciosAdicionales($servicio_adicional,$id_bus);
        $this->insertarHorarios($horarios,$id_bus);

        $detalles['id_bus'] = $id_bus;
        $detalles['id_codigo_bus'] = $bus['id_codigo_bus'];
        return $detalles;
   }
   // eliminar bus
   public function eliminar_bus($id_bus=0){
        $this->busesDB->delete('bus', array('id_bus' => $id_bus));
        return $this->busesDB->affected_rows();
   }
   // agregar imagenes a la galeria
   private function insertarGaleria($galeria,$id_bus){
      if($galeria){
          foreach ($galeria as $value) {
            $galeriaData['id_galeria'] = $value;
            $galeriaData['id_bus'] = $id_bus;
            if(!empty($value)) $this->busesDB->insert('bus_has_galeria', $galeriaData);
          }
      }
   }
   // agregar paradas
  /* private function insertarParadas($paradas,$id_bus){
      if($paradas){
          foreach ($paradas as $value) {
            $parada['id_lugar'] = $value;
            $parada['id_bus'] = $id_bus;
            if(!empty($value)) $this->busesDB->insert('bus_has_paradas', $parada);
          }
      }
  }*/

   // insertar tabs adicionales
   private function insertarTabs($addedtabs,$id_bus){
    if($addedtabs['nombre']){
      foreach (@$addedtabs['nombre'] as $key => $value) {
         $tab['nombre_tab_adicional'] = $value;
         $tab['icono_tab_adicional'] = $addedtabs['icono'][$key];
         $tab['contenido_tab'] = $addedtabs['contenido'][$key];
         $tab['id_bus'] = $id_bus;
         $this->busesDB->insert('tab_adicional', $tab);
      }
    }
  }
    private function insertarHorarios($horarios,$id_bus){
      if($horarios['hora_partida']){
        foreach (@$horarios['hora_partida'] as $key => $value) {
          $horario['hora_partida'] = $value;
          $horario['id_servicio'] = $horarios['id_servicio'][$key];
          $horario['zona_horaria'] = (is_array($horarios['zona_horaria']) && isset($horarios['zona_horaria'][$key]) && $horarios['zona_horaria'][$key]) ? 1 : 0;
        // $horario['zona_horaria'] = $horarios['zona_horaria'][$key]?1:0;
          $horario['duracion'] = $horarios['duracion'][$key];
          $horario['precio_persona'] = $horarios['precio_persona'][$key];
          $horario['id_bus'] = $id_bus;
          $this->busesDB->insert('horarios', $horario);
        }
      }
    }
  // insertar tabs adicionales
  private function insertarServiciosAdicionales($servicios_adicionales,$id_bus){
    if($servicios_adicionales){
      foreach (@$servicios_adicionales as $value) {
        $adicional['id_servicio_adicional'] = $value;
        $adicional['id_bus'] = $id_bus;
        if(!empty($value)) $this->busesDB->insert('bus_has_servicio_adicional', $adicional);
      }
    }
  }
////////////////////////// metodo para retornar lista de buses segun el codigo de bus //////////////////////
  public function retorna_todo_buses(){ 
    $resultado = $this->busesDB->query("SELECT id_codigo_bus,titulo_bus,subtitulo_bus FROM bus GROUP BY id_codigo_bus ORDER BY id_bus ASC")->result_array();
    return $resultado;
 
  }
  public function retorna_buses_codigo($id_codigo_bus){
    $resultado['buses'] = $this->busesDB->query("SELECT 
              bus.id_codigo_bus,
              bus.id_bus,
              bus.titulo_bus,
              pagina_web.url_pagina,
              idioma.codigo AS idioma_pagina,
              pagina_web.id_pagina,
              pagina_web.id_codigo_pagina_web
              FROM bus
              LEFT JOIN pagina_web ON pagina_web.id_pagina = bus.id_pagina
              LEFT JOIN idioma ON idioma.id_idioma = pagina_web.id_idioma 
              WHERE bus.id_codigo_bus = $id_codigo_bus"
              )->result_array();
            if(count($resultado['buses'])){
              $resultado['paginas_web'] = $this->busesDB->query("SELECT id_pagina,pais AS lenguaje FROM pagina_web LEFT JOIN idioma ON idioma.id_idioma = pagina_web.id_idioma WHERE id_codigo_pagina_web={$resultado['buses'][0]['id_codigo_pagina_web']}")->result_array();
              foreach(@$resultado['paginas_web'] as $key => $value){
                $resultado['paginas_web'][$value['id_pagina']] = $value;
                unset($resultado['paginas_web'][$key]);
              }

            }
              

    return $resultado;
  }
  //
  public function retorna_buses_por_idpagina($id_pagina=0){
    $resultado['pagina_web'] = $this->busesDB->query("SELECT * FROM pagina_web WHERE id_pagina = '$id_pagina'")->row_array();
    $resultado['buses'] = $this->busesDB->query("SELECT 
          bus.id_bus,
          bus.titulo_bus,
          bus.id_codigo_bus,
          bus.estado_bus,
          L1.nombre_lugar origen_bus,
          L2.nombre_lugar destino_bus
          FROM bus 
          JOIN lugares L1 ON (bus.origen_bus = L1.id_lugar) 
          JOIN lugares L2 ON (bus.destino_bus = L2.id_lugar) 
          WHERE bus.id_pagina = '$id_pagina'")->result_array();
    return $resultado;
  }


}