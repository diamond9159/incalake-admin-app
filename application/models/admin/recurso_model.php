<?php

class Recurso_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model("admin/idioma_model");
    } 

    function get_recurso($id_recurso){
        $recurso = $this->db->query("SELECT * FROM recurso WHERE recurso.id_recurso = ?;",array($id_recurso))->row_array();
        /*
        $recurso['galeria'] = $this->db->select('galeria.id_galeria,galeria.url_imagen')
               ->from('recurso_has_galeria')
               ->where('recurso_has_galeria.recurso_id_recurso', $id_recurso)
               ->join('galeria', 'galeria.id_galeria = recurso_has_galeria.id_recurso_has_galeria')
               ->get()->row_array();
        */
        return $recurso; 
    }
    
    function get_all_recursos(){
        $recursos = $this->db->query("SELECT * FROM recurso  WHERE 1 = 1 AND id_usuarios = '".$this->session->userdata('id_usuarios')."';")->result_array();
        return $recursos;
    }

    function add_recurso($params,$imagen){
        $this->db->insert('recurso',$params);
        
        if(!empty($imagen)){
            $paramsIMG = array(
                'recurso_id_recurso'  => $this->db->insert_id(),
                'galeria_id_galeria'      => (int)$imagen
         );
           $this->db->insert('recurso_has_galeria',$paramsIMG); 
        }
        return $this->db->insert_id();
    }
    
    function update_recurso($id_recurso,$params,$imagen){
        $this->db->where('id_recurso',$id_recurso);
        $response = $this->db->update('recurso',$params);
        /*a continuacion se elimina la imagen y se inserta de nuevo siempre y cuando tenga valor */
        if($response){
            if(!empty($imagen)){
                $this->db->delete('recurso_has_galeria',array('recurso_id_recurso'=>$id_recurso));
                $paramsIMG = array(
                    'recurso_id_recurso'  => $id_recurso,
                    'galeria_id_galeria'      => (int)$imagen
             );
               $this->db->insert('recurso_has_galeria',$paramsIMG); 
            }

            
            return true;
        }else{
            return false;
        }
    }

    function delete_recurso($id_recurso){
        $response = $this->db->delete('recurso',array('id_recurso'=>$id_recurso));
        if($response){
            return true;
        } else {
            return false;
        }
    }

    function get_recurso_producto($id_producto){
        $recurso = $this->db->query("SELECT * FROM recurso WHERE recurso.id_producto = ?;",array($id_producto))->row_array();
        return $recurso; 
    }

    function get_productos_by_idioma($id_recurso){
        $data = array();
        $data['idiomas'] = $this->idioma_model->get_all_idiomas();
        foreach ($data['idiomas'] as $key => $value) {            
            $data['productos'][] = $this->db->query("SELECT i.*, p.id_producto, p.titulo_producto,p.id_codigo_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON s.id_servicio = p.id_servicio AND i.codigo = '".$value['codigo']."';")->result_array();
        }
        $response = array();
        
        foreach ($data['productos'] as $key => $value) {
            $response_temp = array();
            foreach ($value as $k => $v) {
                $response_temp[] = array(
                    'codigo'            => $v['codigo'],
                    'id_idioma'         => $v['id_idioma'],
                    'pais'              => $v['pais'],
                    'id_producto'       => $v['id_producto'],
                    'titulo_producto'   => $v['titulo_producto'],
                    'asociado'          => $this->previamente_asociado($v['codigo'],$id_recurso,$v['id_producto']),
                    'id_codigo_producto'=> $v['id_codigo_producto']
                );              
            } 
            $response['productos'][] = $response_temp;
        }
        $response['idiomas'] = $data['idiomas'];
        //return $data;
        return $response;
    }

    function get_list_all_recursos($id_producto){
        $data = array();
        $recursos = $this->db->query("SELECT * FROM recurso  WHERE 1 = 1;")->result_array();
        if ( !empty( $recursos[0]['id_recurso'] ) ) {
            $data_temp = array();
            foreach ($recursos as $key => $value) {
                $data_temp[] = array(
                    'id_recurso'            => $value['id_recurso'],
                    'nombre_recurso'        => $value['nombre_recurso'],
                    'descripcion_recurso'   => $value['descripcion_recurso'],
                    'precio_recurso'        => $value['regalo_recurso'],
                    'asociado'              => $this->previamente_asociado_ver_recursos($id_producto,$value['id_recurso']),
                );
            }
            $data = $data_temp;
        }
        return $data;
    }

    // Asociar recurso con producto mediante id_recurso y id_producto
    function asociar_recurso($params){
        $response = $this->verificar_duplicidad($params['id_producto'],$params['id_recurso']);
        if ($response) {
            return true;
        }else{
            $this->db->insert('recurso_has_producto',$params);
            $response = $this->db->insert_id();
            return $response;            
        }
    }
    // Desasociar recurso con producto mediante id_recurso y id_producto
    function desasociar_recurso($id_producto,$id_recurso){
        $response = $this->db->delete('recurso_has_producto',array("id_producto" => $id_producto ,'id_recurso'=>$id_recurso));
        if($response){
            return true;
        } else {
            return false;
        }
    }

    // Asociar recurso con productos mediante id_recurso y id_codigo_producto
    function asociar_recurso_productos($params){
        
        /*
        $response = $this->verificar_duplicidad($params['id_producto'],$params['id_recurso']);
        if ($response) {
            return true;
        }else{
            $this->db->insert('recurso_has_producto',$params);
            $response = $this->db->insert_id();
            return $response;            
        }
        */
    }
    // Desasociar recurso con productos mediante id_recurso y id_codigo_producto
    function desasociar_recurso_productos($params){
        /*
        $response = $this->db->delete('recurso_has_producto',array("id_producto" => $id_producto ,'id_recurso'=>$id_recurso));
        if($response){
            return true;
        } else {
            return false;
        }
        */
    }


    function verificar_duplicidad($id_producto,$id_recurso){
        $response = $this->db->query("SELECT * FROM recurso_has_producto WHERE id_recurso = ? AND id_producto = ?;",array($id_recurso,$id_producto))->row_array();
        return $response; 
    }

    function previamente_asociado_ver_recursos($id_producto, $id_recurso){
        $response = $this->db->query("SELECT * FROM recurso_has_producto as rhp JOIN producto as p ON p.id_producto = rhp.id_producto;")->result_array();
        //SELECT * FROM recurso_has_producto as rhp JOIN producto as p ON p.id_producto = rhp.id_producto JOIN recurso as r ON r.id_recurso = rhp.id_recurso
        if ( !empty( $response[0]['id_producto'] ) ) {
            foreach ($response as $key => $value) {
                if ( $value['id_producto'] === $id_producto && $id_recurso === $value['id_recurso']  ) {
                    return true;
                }
            }
            return false;
        }else{
            return false;
        }
    }

    function previamente_asociado($idioma,$id_recurso,$id_producto){
        $asociados = $this->db->query("SELECT i.*, p.id_producto, p.titulo_producto, rhp.* FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON s.id_servicio = p.id_servicio AND i.codigo = '".$idioma."' JOIN recurso_has_producto as rhp USING(id_producto);")->result_array();
        if ( !empty($asociados[0]['id_recurso']) ) {
            foreach ($asociados as $key => $value) {
                if ( $value['id_recurso'] === $id_recurso && $id_producto === $value['id_producto'] ) {
                    return true;
                }
            }
            return false;
        }else{
            return false;
        }
    }

    function estado_recurso($id_recurso,$estado){
        $this->db->where('id_recurso',$id_recurso);
        $response = $this->db->update('recurso',array("regalo_recurso" => $estado) );
        return $response;
    }

    //Retorna los datos de la imagen del recurso atraves del id_recurso
    function getImagenRecurso($params){
        return $this->db->query("SELECT g.*,r.* FROM galeria as g JOIN recurso_has_galeria as rg ON g.id_galeria = rg.galeria_id_galeria JOIN recurso as r ON r.id_recurso = rg.recurso_id_recurso AND r.id_recurso = '".$params['id']."';")->row_array();
    }

}





