<?php

class Categoria_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model("admin/idioma_model");
        $this->load->model("admin/codigocategoria_model");
        $this->load->model("admin/galeria_model");
    }
    

    function get_categoria($id_categoria){
        $categoria = $this->db->query("SELECT * FROM categoria WHERE id_categoria = ?;",array($id_categoria))->row_array();
        return $categoria;
    }
    

    function get_all_categorias(){
        $categorias = $this->db->query("SELECT * FROM categoria WHERE 1 = 1;")->result_array();
        return $categorias;
    }
    

    function add_categoria($params){
        $this->db->insert('categoria',$params);
        return $this->db->insert_id();
    }
    

    function update_categoria($id_codigo_categoria,$id_categoria,$params){
        $this->db->where('id_categoria',$id_categoria);
        $response = $this->db->update('categoria',$params);
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
    

    function delete_categoria($id_categoria){
        $response = $this->db->delete('categoria',array('id_categoria'=>$id_categoria));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }

    function get_categorias_agrupadas($id_codigo_categoria){
        $categoria_agrupada = $this->db->query('SELECT c.*,cc.*,i.*,gal.url_archivo FROM categoria as c INNER JOIN codigo_categoria as cc INNER JOIN galeria AS gal INNER JOIN idioma as i ON c.id_codigo_categoria = cc.id_codigo_categoria AND c.id_codigo_categoria = '.$id_codigo_categoria.' AND cc.imagen_categoria = gal.id_galeria AND c.id_idioma = i.id_idioma ORDER BY c.id_idioma;')->result_array();
        return $categoria_agrupada;
    }

    function get_all_categorias_agrupadas(){
        $data = array();
        //$cantidad_idiomas = $this->idioma_model->get_cantidad_idiomas();
        //$nombre_idiomas   = $this->idioma_model->get_nombre_idiomas();
        //$data['cantidad_idiomas']   = $cantidad_idiomas;
        //$data['nombre_idiomas']     = $nombre_idiomas;
        $cantidad_categorias = $this->db->query("SELECT c.id_codigo_categoria FROM categoria as c JOIN idioma as i ON i.id_idioma = c.id_idioma GROUP BY c.id_codigo_categoria;")->result_array();
        if ( !empty($cantidad_categorias[0]['id_codigo_categoria']) ) {
            foreach ($cantidad_categorias as $key => $value) {
                $data[] =   $this->db->query("SELECT * FROM categoria as c JOIN idioma as i ON i.id_idioma = c.id_idioma JOIN codigo_categoria as cc ON cc.id_codigo_categoria = c.id_codigo_categoria AND c.id_codigo_categoria = '".$value['id_codigo_categoria']."';")->result_array();
            }
        }

        //$cantidad_codigo_categoria  = $this->codigocategoria_model->get_cantidad_codigocategoria();
        //foreach ($cantidad_codigo_categoria as $key => $value) {
        //    $data['categorias'][] = $this->get_categorias_agrupadas($value['id_codigo_categoria']);
        //}
        return $data;
    }

    /*
    function free_categorias($id_codigo){
        $free_languages = $this->db->query("SELECT i.* FROM categoria as i WHERE i.id_categoria NOT IN(SELECT s.categoria_id_categoria FROM servicio as s WHERE s.codigo_servicio_id_codigo_servicio = ".$id_codigo." );" )->result_array();
        return $free_languages;
    }
    */

    function get_categoria_json($id_producto, $id_idioma){
        return $this->db->query("SELECT phc.producto_id_producto as id_producto,c.id_categoria,c.nombre_categoria, i.codigo FROM categoria as c LEFT JOIN producto_has_categoria as phc ON phc.categoria_id_categoria IS NULL OR c.id_categoria = phc.categoria_id_categoria AND phc.producto_id_producto = '".$id_producto."' JOIN idioma as i ON c.id_idioma = i.id_idioma AND i.codigo = '".$id_idioma."';")->result_array();
    }

    function asociar_producto_categoria($id_producto,$id_categoria,$estado){
        if ( $estado === 0 || $estado === '0' ) {
            $this->db->delete('producto_has_categoria',array('producto_id_producto'=>$id_producto, 'categoria_id_categoria'=>$id_categoria));
            return true;
        }else if( $estado === 1 || $estado === '1' ){
            $this->db->insert('producto_has_categoria',array('producto_id_producto'=>$id_producto, 'categoria_id_categoria'=>$id_categoria) );
            //$this->db->insert_id();
            return true;
        }else{
            return false;
        }   
    }

    function add_translate_categorias($params){
        $this->db->insert('categoria',$params);
        return $this->db->insert_id();
    }


    //RETORNA UNA CATEGORIA EN TODOS LOS IDIOMAS PARA VER y/o EDITAR
    function getCategoriasAgrupadas($idCodigoCategoria = 0){
        //$data = $this->db->query("SELECT * FROM idioma as i INNER JOIN categoria as c ON i.id_idioma = c.id_idioma AND c.id_codigo_categoria = '".$idCodigoCategoria."';")->result_array();
        $data = $this->db->query("SELECT * FROM idioma as i JOIN categoria as c ON i.id_idioma = c.id_idioma JOIN codigo_categoria as cc ON cc.id_codigo_categoria = c.id_codigo_categoria AND c.id_codigo_categoria ='".$idCodigoCategoria."';")->result_array();
        $imagen = array();
        if (count($data) > 0 ) {
            $imagen = $this->galeria_model->get_galeria($data[0]['imagen_categoria'] ? $data[0]['imagen_categoria'] : 0 );
        }
        return array("categoria"=>$data,"imagen"=> $imagen );
    }
}
