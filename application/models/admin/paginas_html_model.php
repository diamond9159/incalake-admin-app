<?php
class Paginas_html_model extends CI_Model { 
   public function __construct() {
      parent::__construct();
      // obtener el usuario actual loggeado
      $this->id_user_actual = $this->session->userdata('id_usuarios');
   } 
   public function procesar_nombre_pagina($data,$editar){
      // si variable editar contiene el id del agrupado de página
      if($editar){
        $this->db->where('id_pagina', $editar)->where('id_usuarios',$this->id_user_actual)->update('group_pagina', $data);
        $estado = $this->db->affected_rows();
      } else {
        // get actual user
        $data['id_usuarios'] = $this->id_user_actual;
        // get actual date and put it into data base
        $this->db->set('fecha_pagina', 'NOW()', FALSE);
        
        $this->db->insert('group_pagina', $data); 
        // retornar id del ultimo agrupador creado.
        $estado = $this->db->insert_id();
      }
      return $estado;
   }
  
  // procesarPagina metodo para agregar y editar una pagina html
  public function procesarPagina($data,$editar){
      // si editar contiene ID de pagina html se procede a editar
      if($editar){
        $this->db->where('id', $editar)->update('pagina_html', $data);
        //retornar si fue exitoso = 1 o fallido = 0
        $estado = $this->db->affected_rows();
      // en caso que no exista se procede a crear una nueva pagina html
      } else {        
        $this->db->insert('pagina_html', $data);
        //retornar ultimo ID de la ultima pagina html creada 
        $estado = $this->db->insert_id();
      }
      return $estado;
  }
  
   // metodo para eliminar nombre (agrupador de pagina)
   public function eliminarNombre($id){
      $this->db->where('id_pagina', $id)->where('id_usuarios',$this->id_user_actual)->delete('group_pagina');
      // retornar 1 si fue exitoso
      return $this->db->affected_rows();
   }

   // metodo de eliminacion de pagina
   public function eliminarPagina($id){
      $this->db->where('id', $id)->delete('pagina_html');
      // retornar 1 si fue exitosa
      return $this->db->affected_rows();
    }
   
   // obiene todo los nombres (agrupadores de pagina)
   public function obtenerNombresPagina(){ 
      $resultado = $this->db->query("SELECT id_pagina,nombre_pagina FROM group_pagina WHERE id_usuarios=$this->id_user_actual ORDER BY fecha_pagina ASC")->result_array();

      // buscar sus paginas relaciones en idiomas
      foreach($resultado as $key => $value){
        $resultado2 = $this->db->query("SELECT pagina_html.*,idioma.codigo FROM pagina_html INNER JOIN idioma ON idioma.id_idioma=pagina_html.id_idioma WHERE id_pagina={$value['id_pagina']}")->result_array();
        $resultado[$key]['pages'] = $resultado2;
      }
      return $resultado;
   }


}