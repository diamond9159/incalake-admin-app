<?php
class Menum extends CI_Model { 
   public function __construct() {
      parent::__construct();
      // obtener usuario actual
      $this->id_user_actual = $this->session->userdata('id_usuarios');
   }

   // agregar o editar link (url)
   public function procesarMenu($data,$editar){ 
     // si editar tiene un id de un link se editará
      if($editar){
        $this->db->where('menu_id', $editar)->where('id_usuarios',$this->id_user_actual)->update('menu', $data);
        $estado = $this->db->affected_rows();
      // en caso no exista ninguna id de crea un nuevo link
      } else {
        $data['id_usuarios'] = $this->id_user_actual;
        // encontrar prioridad maxima 
        $result =$this->db->where('parent_id',$data['parent_id'])->where('id_usuarios',$this->id_user_actual)->select_max('prioridad')->get('menu')->row();  
        // obtener la ultima prioridad y aumentar 1 para evitar duplicados
        $data['prioridad'] = $result->prioridad+1;
        $this->db->insert('menu', $data); 
        $estado = $this->db->insert_id();
      }
      return $estado;
   }


   public function eliminarMenu($id){
       // eliminar links que esten relacionados a este link
       $this->db->where('parent_id', $id)->where('id_usuarios',$this->id_user_actual)->delete('menu');
       // eliminar el link con la id respectiva
       $this->db->where('menu_id', $id)->where('id_usuarios',$this->id_user_actual)->delete('menu');
       // se eliminará los relacionados en detalle_precio
       return $this->db->affected_rows();
   }
   // obtener todo el arbol del menu
   public function obtenerDatos(){ 
      $resultado['lista_menu'] = $this->db->query("SELECT menu_id,menu_name,parent_id,cod_servicio,idiomas_url,idiomas_nombres,target,prioridad,icono,background FROM menu WHERE id_usuarios=$this->id_user_actual ORDER BY prioridad ASC, menu_id ASC")->result_array();
      $resultado['lista_servicios'] = $this->db->query("SELECT codigo,id_codigo_servicio,url_servicio,titulo_pagina FROM codigo_servicio INNER JOIN servicio ON codigo_servicio.id_codigo_servicio=servicio.codigo_servicio_id_codigo_servicio INNER JOIN idioma ON idioma.id_idioma = servicio.idioma_id_idioma WHERE codigo_servicio.id_usuarios=$this->id_user_actual")->result_array();
     
      
      return $resultado;
   }
   // ordenar la posicion de los links (relevancia)
    public function reordenarRelevancia($datos){ 
        $elem = @$datos['direccion']?@$datos['rel_siguiente']:@$datos['rel_anterior'];
        $estado = 0;
       if($elem){
          $data['prioridad'] = $datos['rel_actual'];

        //actualizar anterior
          $this->db->where('parent_id', $datos['parent'])
          ->where('id_usuarios',$this->id_user_actual)
          ->where('prioridad',$elem)
          ->update('menu', $data);
          $estado = $this->db->affected_rows();

        //actualizar actual
         $data['prioridad'] = $elem;
          $this->db->where('menu_id', $datos['id_elemento'])
          ->where('id_usuarios',$this->id_user_actual)
          ->update('menu', $data);
         if($estado)$estado = $this->db->affected_rows();//devolver estado solo si hay primer estado al actualizar la primera
       }
     return $estado;
   }

    public function obtenerMenuJSON(){
       $resultado = $this->db->query("SELECT * FROM menu WHERE id_usuarios=$this->id_user_actual ORDER BY prioridad ASC, menu_id ASC")->result_array();
       return $resultado;
    }
   
}