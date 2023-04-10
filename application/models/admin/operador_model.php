<?php

class Operador_model extends CI_Model{
    function __construct(){
        parent::__construct();
        //$this->load->model('admin/idioma_model');
        //$this->load->model('admin/disponibilidad_model');
    }
    
    function get_operador($id_producto,$id_codigo_producto){
        $data = [];
        $operador = $this->db->query("SELECT i.codigo,p.id_producto,p.id_codigo_producto,p.titulo_producto,o.id_producto AS o_id_producto,o.id_codigo_producto AS o_id_codigo_producto,o.id_operador,o.email_operador,o.nombre_operador,o.activo FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma JOIN producto AS p ON p.id_servicio = s.id_servicio AND p.id_codigo_producto = '".trim(stripcslashes(((Integer)$id_codigo_producto)))."' AND p.id_producto = '".trim(stripcslashes(((Integer)$id_producto)))."' LEFT JOIN operador AS o ON p.id_producto = o.id_producto ORDER BY o.activo DESC;")->result_array();
        if (!empty($operador)) {
        	foreach ($operador as $key => $value) {
        		$data[] = array(
        			"idioma" => mb_strtolower($value['codigo']),
        			"id_producto" => $value['id_producto'],
        			"id_codigo_producto" 	=> $value['id_codigo_producto'],
        			"nombre_actividad"		=> mb_strtoupper($value['titulo_producto']),
        			"email_operador"		=> mb_strtoupper($value['email_operador']),
        			"nombre_operador"		=> mb_strtoupper($value['nombre_operador']),
        			"o_id_producto"			=> $value['o_id_producto']?true:false,
        			"o_id_codigo_producto"	=> $value['o_id_codigo_producto']?true:false,
        			"id_operador"			=> $value['id_operador'],
        			"activo"				=> $value['activo']?true:false,
        		);
        	}
        }
        return $data;
    }

    function updateAjax($idProducto,$idCodigoProducto,$idOperador,$activado){
    	// Antes de realizar la actualización, desactivamos todos los operadores para que no exista duplicidad
        $this->db->query("UPDATE operador SET activo='0' WHERE id_producto = '".trim($idProducto)."' AND id_codigo_producto='".trim($idCodigoProducto)."';");
        // Procedemos con la actualización del operador
        $response = $this->db->query("UPDATE operador SET activo='".trim(stripcslashes($activado))."' WHERE id_operador = '".trim(stripcslashes($idOperador))."' AND id_producto = '".trim($idProducto)."' AND id_codigo_producto='".trim($idCodigoProducto)."';");
        if($response){
            return true;
        }else{
            return false;
        }
    }

    function delete_operador($idProducto,$idCodigoProducto,$idOperador){
        //$response = $this->db->query("DELETE FROM operador WHERE id_producto = '".trim(stripcslashes($idProducto))."' AND id_codigo_producto = '".trim(stripcslashes($idCodigoProducto))."';");
        $response = $this->db->delete('operador',array('id_operador'=>$idOperador));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }

    // Función que retorna si una actividad ya tiene asociado un operador activo; Una actividad no puede tener dos operadores activos a la vez
    function  get_operador_activo($id_producto,$id_codigo_producto){
    	return $this->db->query("SELECT * FROM operador WHERE id_producto = ? AND id_codigo_producto = ? AND activo = 1;",array($id_producto,$id_codigo_producto))->row_array();
    }

    function add_operador($params){
        $this->db->insert('operador',$params);
        return $this->db->insert_id();
    }

    //Retorna operadors con id NULL para que vuelvan a ser insertados cuando la actividad este siendo clonado
    function get_operador_clonar($id_producto){
        $data = array();
        if ( !empty($id_producto ) ) {  //Consulta a la base de datos mediante $id_producto
            $operador = $this->db->query("SELECT * FROM operador WHERE id_producto = '".$id_producto."';")->result_array();
            if ( !empty($operador) ) {
                foreach ($operador as $key => $value) {
                    $data[] = array(
                        "id"                => null,
                        "title"             => $value['descripcion_operador'],
                        "start"             => $value['fecha_inicio'],
                        "end"               => $value['fecha_fin'],
                        "color"             => $value['color_operador'],
                        "descuento"         => $value['valor_operador'],
                        "tipo_descuento"    => $value['tipo_operador'],
                    );
                }
            }           
        }
        return json_encode($data);
    }

    function get_all_operadors(){
        return $this->db->get('operador')->result_array();
    }
    
    function get_listview_operadors(){
        return $this->db->query("SELECT * FROM producto as p JOIN operador as o ON p.id_producto = o.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma;")->result_array();
    }

    function update_operador($id_operador,$params){
        $this->db->where('id_operador',$id_operador);
        $response = $this->db->update('operador',$params);
        if($response){
            return true;
        }
        else{
            return false;
        }
    }
/*    
    function delete_operador($id_operador){
        $response = $this->db->delete('operador',array('id_operador'=>$id_operador));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }
    
    function delete_operador_producto($id_producto){
        $response = $this->db->delete('operador',array('id_producto'=>$id_producto));
        if($response){
            return 1;
        } else{
            return 0;
        }
    }
*/
    /********************************************************************************************************/

}
