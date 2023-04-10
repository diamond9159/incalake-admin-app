<?php
class Guia_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_guia($id_guia){
        $guia = $this->db->query("SELECT * FROM guia WHERE id_guia = ?;",array($id_guia))->row_array();
        return $guia;
    }
        
    function get_all_guias($idioma = 'ES'){
        //$guias = $this->db->query("SELECT * FROM guia WHERE 1 = 1 ORDER BY id_guia DESC;")->result_array();
        $guias = $this->db->query("SELECT * FROM idioma as i JOIN guia as g ON i.id_idioma = g.id_idioma JOIN codigo_guia as cg ON cg.id_codigo_guia = g.id_codigo_guia AND i.codigo = '".$idioma."';")->result_array();
        return $guias;
    }
        
    function add_guia($params){
        $this->db->insert('guia',$params);
        return $this->db->insert_id();
    }
    
    function update_guia($id_codigo_guia,$id_guia,$params){
        $this->db->where('id_guia',$id_guia);
        return $this->db->update('guia',$params);
    }
    
    function delete_guia($id_guia){
        return $this->db->delete('guia',array('id_guia'=>$id_guia));
    }



    //RETORNA UN REGISTROD E GUIA EN TODOS LOS IDIOMAS PARA VER y/o EDITAR
    function getGuiasAgrupadas($idCodigoGuia = 0){
        $data = $this->db->query("SELECT * FROM idioma as i LEFT JOIN guia as g ON i.id_idioma = g.id_idioma JOIN codigo_guia as cg ON cg.id_codigo_guia = g.id_codigo_guia AND g.id_codigo_guia ='".$idCodigoGuia."';")->result_array();
        //$imagen = array();
        //if (count($data) > 0 ) {
        //    $imagen = $this->galeria_model->get_galeria($data[0]['imagen_categoria'] ? $data[0]['imagen_categoria'] : 0 );
        //}
        //return array("categoria"=>$data,"imagen"=> $imagen );
        return array("guia"=>$data,"imagen"=> null );
    }

    function deleteCodigoGuia($idCodigoGuia,$idGuia){
        return $this->db->delete('codigo_guia',array('id_codigo_guia' => $idCodigoGuia) );
    }

    function getAsociarGuiaProducto($idGuia){
        return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,cs.id_codigo_servicio,s.id_servicio,p.id_producto as idproducto,p.titulo_producto,phg.id_producto,phg.id_guia FROM codigo_servicio as cs JOIN servicio as s ON cs.id_codigo_servicio = s.codigo_servicio_id_codigo_servicio JOIN idioma as i ON s.idioma_id_idioma = i.id_idioma JOIN producto as p ON s.id_servicio = p.id_servicio LEFT JOIN producto_has_guia as phg ON p.id_producto IS NULL OR p.id_producto = phg.id_producto AND phg.id_guia = '".$idGuia."';")->result_array();
    }

    function operarAsociacion($idproducto,$ididioma,$idguia,$operacion){
        $data  =array();
        if ( (Integer)$operacion === 1 ) {
            $params['id_producto'] = $idproducto;
            $params['id_idioma']   = $ididioma;
            $params['id_guia']     = $idguia;
            $this->db->insert('producto_has_guia',$params);
            $response = $this->db->insert_id();
            $data['response']  = "success";
            $data['message']   = "Registrado con éxito.";
        }else{
            $response = $this->db->delete('producto_has_guia',array('id_guia' => $idguia,'id_idioma' => $ididioma,'id_producto' => $idproducto ) );
            if ($response) {
                $data['response']  = "success";
                $data['message']   = "Eliminado corectamente";
            }else{
                $data['response']  = "error";
                $data['message']   = "No se ha podido eliminar";
            }       
        }
        return $data;
    }

    //Retorna todos los guias asociados y por asociar a la vista crear, editar, clonar productos(Actividad)
    function getProductoGuia($idProducto,$idLanguage){
                return $this->db->query("SELECT p.id_producto AS p_id_producto, p.id_codigo_producto AS p_id_codigo_producto, p.titulo_producto, i.id_idioma, i.codigo, g.id_guia AS g_id_guia, g.id_idioma AS g_id_idioma, g.servicio_guia, g.id_codigo_guia AS g_id_codigo_guia, phg. *
            FROM idioma AS i
            JOIN guia AS g ON i.id_idioma = g.id_idioma
            AND g.id_idioma = '".$idLanguage."'
            LEFT JOIN producto_has_guia AS phg ON phg.id_guia IS NULL
            OR phg.id_guia = g.id_guia
            AND phg.id_producto ='".$idProducto."'
            OR phg.id_producto IS NULL
            LEFT JOIN producto AS p ON p.id_producto = phg.id_producto;")->result_array();
    }

    //Retorna todos los guias disponibles para crear unaactiviad
    function getGuiasByIdioma($language){
        return $this->db->query("SELECT i.id_idioma, i.codigo,g.id_guia as g_id_guia,g.servicio_guia,g.id_codigo_guia as g_id_codigo_guia,g.id_idioma as g_id_idioma FROM idioma as i JOIN guia as g ON i.id_idioma = g.id_idioma AND i.codigo = '".trim(strtoupper($language))."';")->result_array();
    }

    //Opera los datos de los guias para la vista producto o actividad (insertar, actualizar,eliminar)
    function insertUpdate($idProducto,$arrayParams){
        if ( count($arrayParams) != 0 ) {
            $this->delete_guiaAsociado($arrayParams[0]['id_idioma'],$arrayParams[0]['id_producto'],$arrayParams[0]['id_codigo_producto']);
            foreach ($arrayParams as $key => $value) {
                $this->add_guiaAsociado($value);
            }
        }else{
            $producto = $this->obtenerDatosProducto($idProducto);
            if (!empty($producto['id_producto'])) {
                $this->delete_guiaAsociado($producto['id_idioma'],$producto['id_producto'],$producto['id_codigo_producto']);
            }
        }
        return true;
    }

    //Obtener id_producto y id_codigo_producto para eliminar guias asociadas al producto.
    function obtenerDatosProducto($idProducto){
        return $this->db->query("SELECT i.id_idioma,i.codigo,p.id_producto,p.id_codigo_producto,p.titulo_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON s.id_servicio = p.id_servicio AND p.id_producto = '".$idProducto."';")->row_array();
    }
    
    function delete_guiaAsociado($idIdioma,$idProducto, $idCodigoProducto){
        return $this->db->delete('producto_has_guia',array(
                                                            'id_producto'=>$idProducto,
                                                            'id_codigo_producto'=>$idCodigoProducto,
                                                            'id_idioma'=>$idIdioma )
            );
    }

    function add_guiaAsociado($params){
        //echo json_encode($params);
        $this->db->insert('producto_has_guia',$params);
        //return $this->db->insert_id();
        return true;
    }
}
