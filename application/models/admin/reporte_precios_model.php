<?php

class Reporte_precios_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/idioma_model');
        //$this->load->model('admin/disponibilidad_model');
    }
    
    function get_detalle_precios($id_producto){
    	return $this->db->query("SELECT dp.*,ee.id_etapa_edad,ee.descripcion_etapa_edad,ee.traducciones,n.descripcion_nacionalidad,n.traducciones_nacionalidad FROM detalle_precio as dp JOIN nacionalidad as n ON dp.id_nacionalidad = n.id_nacionalidad JOIN etapa_edad as ee ON dp.id_etapa_edad = ee.id_etapa_edad AND dp.id_producto = '".$id_producto."';")->result_array();
    }

    function get_precios($id_detalle_precio){
    	return $this->db->query("SELECT * FROM precios as p WHERE p.id_detalle_precio = '".$id_detalle_precio."' ORDER BY p.cantidad ASC;")->result_array();
    }


	function get_productos(){
		$productos = $this->db->query("SELECT i.id_idioma,i.codigo,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.titulo_pagina FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma GROUP BY s.codigo_servicio_id_codigo_servicio;")->result_array();
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
					'idiomas' => $this->get_idiomas_disponibles($value['id_servicio'],$value['id_codigo_servicio'],$value['id_idioma']),					
				);
			}
		}
		return $data;
	}

	function get_idiomas_disponibles($idServicio, $idCodigoServicio,$idIdioma){
		return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,COUNT(p.id_producto) as cantidad FROM idioma as i JOIN servicio as s ON s.idioma_id_idioma = i.id_idioma AND s.codigo_servicio_id_codigo_servicio = '".trim($idCodigoServicio)."' LEFT JOIN producto as p ON p.id_servicio = s.id_servicio GROUP BY i.id_idioma;")->result_array();
	}    

	function get_precios_producto($idioma,$idCodigoServicio){
		$data = [];
		if (trim(strtolower($idioma)) === 'all') {
			$response = $this->db->query("SELECT i.id_idioma,i.pais,i.codigo,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.titulo_pagina,p.titulo_producto,p.id_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON p.id_servicio = s.id_servicio AND s.codigo_servicio_id_codigo_servicio = '".trim($idCodigoServicio)."';")->result_array();
		}else{
			$response = $this->db->query("SELECT i.id_idioma,i.pais,i.codigo,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.titulo_pagina,p.titulo_producto,p.id_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON p.id_servicio = s.id_servicio AND s.codigo_servicio_id_codigo_servicio = '".trim($idCodigoServicio)."' AND i.codigo ='".trim(strtoupper($idioma))."';")->result_array();
		}

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