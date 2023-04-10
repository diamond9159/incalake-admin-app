<?php

class Reporte_actividades_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/idioma_model');
        //$this->load->model('admin/disponibilidad_model');
    }
    
    function get_actividad($idioma,$idProducto){
    	$actividad = $this->db->query("SELECT i.id_idioma,i.pais,i.codigo,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.titulo_pagina,p.* FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON p.id_servicio = s.id_servicio AND p.id_producto = '".trim($idProducto)."' AND i.codigo ='".trim(strtoupper($idioma))."';")->row_array();
    	
    	if ( empty(trim(@$actividad['politicas_producto'])) ) {
    		$actividad['politicas_producto'] = $this->obtenerPolitcasStandar($actividad['codigo']);	
    	}
    	
    	return $actividad;
    }

    function get_tabs($idProducto){
    	$data = [];
    	$data['tabs'] = $this->db->query("SELECT * FROM tab WHERE producto_id_producto = '".trim($idProducto)."';")->row_array();
    	$data['tabs_adicionales'] = $this->db->query("SELECT * FROM tab_adicional WHERE id_producto = '".trim($idProducto)."';")->result_array();
    	return $data;
    }

    function get_galeria($idProducto){
    	$URL_WEB = "../web/";
    	$galeria = $this->db->query("SELECT * FROM galeria AS g JOIN galeria_has_producto AS ghp ON g.id_galeria = ghp.id_galeria AND ghp.id_producto = '".trim($idProducto)."';")->result_array();
    	$data = [];
    	if (!empty($galeria)) {
    		foreach ($galeria as $key => $value) {
    			$data[] = $URL_WEB."galeria/admin/".$this->carpeta($value["tipo_archivo"])."/".$value["carpeta_archivo"]."/thumbs/".$value["url_archivo"];
    		}
    	}
    	return $data;
    }

    private function carpeta($id){
		$carpeta = '';
		switch ( (integer)$id ) {
			case 0:
				$carpeta = 'docs';
				break;
			case 1:
				$carpeta = 'full-slider';
				break;
			case 2:
				$carpeta = 'short-slider';
				break;
			case 3:
				$carpeta = 'relateds';
				break;
			case 4:
				$carpeta = 'recursos';
				break;
			case 5:
				$carpeta = 'politicas';
				break;
			case 6:
                $carpeta = 'other-images';
                break;
			default:
				$carpeta = 'otros';
				break;
		}
		return $carpeta;
	}

    function obtenerPolitcasStandar($language){
 		$this->load->helper('file');
        $buffer             = '';
        //$ruta = $_SERVER['DOCUMENT_ROOT']."/web/assets/archivos/politicas/".strtoupper($language).".txt";
        $ruta = "../web/assets/archivos/politicas/".strtoupper($language).".txt";
        $leer	= fopen($ruta, 'r+');
        while(!feof($leer)){ 
            $buffer .= fgets($leer);  
        } 
        return $buffer;
    }


    function get_detalle_precios($id_producto){
    	return $this->db->query("SELECT dp.*,ee.id_etapa_edad,ee.descripcion_etapa_edad,ee.traducciones,n.descripcion_nacionalidad,n.traducciones_nacionalidad FROM detalle_precio as dp JOIN nacionalidad as n ON dp.id_nacionalidad = n.id_nacionalidad JOIN etapa_edad as ee ON dp.id_etapa_edad = ee.id_etapa_edad AND dp.id_producto = '".$id_producto."';")->result_array();
    }

    function get_precios($id_detalle_precio){
    	return $this->db->query("SELECT * FROM precios as p WHERE p.id_detalle_precio = '".$id_detalle_precio."' ORDER BY p.cantidad ASC;")->result_array();
    }


	function get_productos(){
		$productos = $this->db->query("SELECT i.id_idioma,i.codigo,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.titulo_pagina, p.titulo_producto, p.id_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON s.id_servicio = p.id_servicio GROUP BY p.id_producto;")->result_array();
		$data = [];
		if (!empty($productos)) {
			foreach ($productos as $key => $value) {
				$data['productos'][] = array(
					'id_idioma' => $value['id_idioma'],
					'codigo' => $value['codigo'],
					'id_servicio' => $value['id_servicio'],
					'id_codigo_servicio' => $value['id_codigo_servicio'], 
					'ubicacion_servicio' => $value['ubicacion_servicio'],
					'titulo_pagina' => $value['titulo_pagina'],
					'titulo_producto' => $value['titulo_producto'],
					'id_producto'	=> $value['id_producto'],
					'idiomas' => $this->get_idiomas_disponibles($value['id_servicio'],$value['id_codigo_servicio'],$value['id_idioma']),					
				);
			}
		}
		return $data;
	}
	function get_productos_idioma($lang){
		$productos = $this->db->query("SELECT cp.id_codigo_producto, i.id_idioma,i.codigo,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.titulo_pagina, p.titulo_producto, p.id_producto, p.codigo_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".strtolower(trim($lang))."' JOIN producto as p ON s.id_servicio = p.id_servicio JOIN codigo_producto as cp ON cp.id_codigo_producto = p.id_codigo_producto  GROUP BY p.id_producto;")->result_array();

		$data = [];
		if (!empty($productos)) {
			foreach ($productos as $key => $value) {
				$data['productos'][] = array(
					'id_idioma' 		=> $value['id_idioma'],
					'codigo' 			=> $value['codigo'],
					'id_servicio' 		=> $value['id_servicio'],
					'id_codigo_servicio'=> $value['id_codigo_servicio'], 
					'ubicacion_servicio'=> $value['ubicacion_servicio'],
					'titulo_pagina' 	=> $value['titulo_pagina'],
					'titulo_producto' 	=> $value['titulo_producto'],
					'id_producto'		=> $value['id_producto'],
					'codigo_producto'   => $value['codigo_producto'],
					'id_codigo_producto'=> $value['id_codigo_producto'],
 					'idiomas' 			=> $this->get_idiomas_disponibles($value['id_servicio'],$value['id_codigo_servicio'],$value['id_idioma']),					
				);
			}
		}
		return $data;
	}



	function get_idiomas_disponibles($idServicio, $idCodigoServicio,$idIdioma){
		return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,COUNT(p.id_producto) as cantidad FROM idioma as i JOIN servicio as s ON s.idioma_id_idioma = i.id_idioma AND s.codigo_servicio_id_codigo_servicio = '".trim($idCodigoServicio)."' LEFT JOIN producto as p ON p.id_servicio = s.id_servicio GROUP BY i.id_idioma;")->result_array();
	}    

	function get_precios_producto($idioma,$idProducto){
		$data = [];
		$response = $this->db->query("SELECT i.id_idioma,i.pais,i.codigo,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.titulo_pagina,p.titulo_producto,p.id_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON p.id_servicio = s.id_servicio AND p.id_producto = '".trim($idProducto)."';")->result_array();

		if (!empty($response)) {
			foreach ($response as $key => $value) {
				$data[] = array(
					'codigo'    => $value['codigo'],
					'pais'      => $value['pais'],
					'titulo_pagina' => $value['titulo_pagina'],
					'titulo_producto'=> $value['titulo_producto'],
					'detalle_precios' => $this->formatear_precios_producto($value['id_producto']),
				);
			}
		}
		return $data;
	}

	function formatear_precios_producto($id_producto){
		$data = [];
		$response = $this->get_detalle_precios($id_producto);
		if (!empty($response)) {
			foreach ($response as $key => $value) {
				$data[] = array(
					'descripcion' => $value['descripcion_etapa_edad'].' '.$value['descripcion_nacionalidad'],
					'precios'     => $this->get_precios($value['id_detalle_precio']),
				);
			}
		}
		return $data;
	}
}