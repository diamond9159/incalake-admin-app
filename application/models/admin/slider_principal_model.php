<?php
class Slider_principal_model extends CI_Model { 
   public function __construct() {
      parent::__construct();
      $this->id_user_actual = $this->session->userdata('id_usuarios');
   }
   /* agregar y editar sliders */
   public function procesar_slider($data){
   // buscar el slider en idioma indicado
   $resultado = $this->db->query("SELECT * FROM slider_principal WHERE id_usuarios=$this->id_user_actual AND idioma={$data['idioma']}")->row_array();
      // si hay resultado en el idioma indicado entoces editar
      if($resultado){
        $this->db->where('id', $resultado['id'])->where('id_usuarios',$this->id_user_actual)->update('slider_principal', $data);
        $estado = $this->db->affected_rows();
      // en caso que no exista crear uno nuevo.
      } else {
        $data['id_usuarios'] = $this->id_user_actual;
 
        $this->db->insert('slider_principal', $data); 
        $estado = $this->db->insert_id();
      }
      return $estado;
   }
 
   public function obtenerSliders(){ 
      $resultado = $this->db->query("SELECT * FROM slider_principal WHERE id_usuarios=$this->id_user_actual")->result_array();
      $resultado2 = array();
      foreach($resultado as $value){
        $resultado2[$value['idioma']] = $value;
      }
      return $resultado2;
   }
   public function obtenerServicios(){ 
    $resultado = $this->db->query("SELECT id_codigo_servicio,url_servicio,titulo_pagina,descripcion_pagina,idioma_id_idioma,galeria.url_archivo,galeria.carpeta_archivo FROM codigo_servicio INNER JOIN servicio ON codigo_servicio.id_codigo_servicio=servicio.codigo_servicio_id_codigo_servicio INNER JOIN galeria ON galeria.id_galeria = servicio.imagen_principal WHERE codigo_servicio.id_usuarios=$this->id_user_actual AND servicio.ver_slider=1")->result_array();
   //var_dump($resultado);
   $nuevo_resultado = array();
   foreach($resultado as $key => $value){
    $nuevo_resultado[$value['id_codigo_servicio']][$value['idioma_id_idioma']] = $value;
   }
    return $nuevo_resultado;
 }
   
}