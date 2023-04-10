<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_pagina_web($id_pagina){
        $resultado = $this->dbBuses->get_where('pagina_web',array('id_pagina'=>$id_pagina))->row_array();
        $slider = $this->db->query("SELECT url_archivo FROM galeria WHERE id_galeria = '{$resultado['imagen_principal']}'")->row_array();
        $miniatura = $this->db->query("SELECT url_archivo FROM galeria WHERE id_galeria = '{$resultado['miniatura_pagina']}'")->row_array();

        $resultado['imagen_principal_url'] = $slider?$slider['url_archivo']:null;
        $resultado['miniatura_pagina_url'] = $miniatura?$miniatura['url_archivo']:null;
        return $resultado;
    }
    
    function get_all_paginas_web_count(){
        $this->dbBuses->from('pagina_web');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_paginas_web($params = array()){
        $this->dbBuses->order_by('id_pagina', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('pagina_web')->result_array();
    }
        
    function get_all_selected_paginas_web(){
        return $this->dbBuses->query("SELECT * FROM idioma as idi JOIN pagina_web AS paw ON idi.id_idioma = paw.id_idioma;")->result_array();
    }    

    function add_pagina_web($params){
        $this->dbBuses->insert('pagina_web',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_pagina_web($id_pagina,$params){
        $this->dbBuses->where('id_pagina',$id_pagina);
        return $this->dbBuses->update('pagina_web',$params);
    }
    
    function delete_pagina_web($id_pagina){
        return $this->dbBuses->delete('pagina_web',array('id_pagina'=>$id_pagina));
    }

    function get_all_group_paginas_web(){
        $data = [];
        $grupoPaginas = $this->dbBuses->query("SELECT idi.*, paw.id_pagina,paw.titulo_pagina, paw.id_codigo_pagina_web FROM idioma AS idi JOIN pagina_web AS paw ON paw.id_idioma = idi.id_idioma GROUP BY paw.id_codigo_pagina_web;")->result_array();
        if ( !empty($grupoPaginas) ) {
            foreach ($grupoPaginas as $key => $value) {
                $data[] = array(
                    'id_idioma'         => $value['id_idioma'],
                    'codigo'            => $value['codigo'],
                    'id_pagina'         => $value['id_pagina'],
                    'titulo_pagina'     => $value['titulo_pagina'],
                    'id_codigo_pagina'  => $value['id_codigo_pagina_web'],
                    'idiomas'           => $this->get_idiomas_disponibles($value['id_codigo_pagina_web']),
                    'paginas_web'       => $this->get_grupo_paginas_web($value['id_codigo_pagina_web']), 
                );                
            }                
        }
        return $data;
    }

    function get_grupo_paginas_web($id_codigo_pagina_web){
        $data = [];
        $resultados = $this->dbBuses->query("SELECT * FROM idioma AS idi JOIN pagina_web AS paw ON paw.id_idioma = idi.id_idioma AND id_codigo_pagina_web = ?", array($id_codigo_pagina_web) )->result_array();
        if (!empty($resultados)) {
            // lista buses para clonar o copiar, solo obtiene detalles de la primera pagina encontrada en el idioma que este
            $resultados[0]['lista_buses'] = $this->dbBuses->query("SELECT id_codigo_bus,titulo_bus FROM bus WHERE id_pagina = '{$resultados[0]['id_pagina']}'")->result_array();

            foreach ($resultados as $key => $value) {
                $value['cantidad_servicios'] = $this->get_cantidad_serviciosBus($value['codigo'],$value['id_pagina']);
                array_push($data, $value);
            }
        }    
        return $data;
    }

    function get_idiomas_disponibles($id_codigo_pagina_web){
        return $this->dbBuses->query("SELECT * FROM idioma AS idi WHERE idi.id_idioma NOT IN (SELECT paw.id_idioma FROM pagina_web AS paw WHERE paw.id_codigo_pagina_web = ?);", array($id_codigo_pagina_web) )->result_array();
    }

    /** Retorna cantidad de servicios por cada página **/
    function get_cantidad_serviciosBus($idioma = "es",$idPaginaWeb=null){
        //return $this->dbBuses->query("SELECT paw.id_pagina, paw.titulo_pagina, COUNT(bus.id_bus) AS cantidad_servicios FROM idioma AS idi LEFT JOIN pagina_web AS paw ON idi.id_idioma = paw.id_idioma AND idi.codigo = ? AND paw.id_pagina = ? LEFT JOIN bus AS bus ON bus.id_pagina = paw.id_pagina GROUP BY paw.id_pagina ORDER BY paw.id_pagina DESC;",array($idioma,$idPaginaWeb) )->row_array();
        $response = $this->dbBuses->query("SELECT COUNT(bus.id_bus) AS cantidad_servicios FROM idioma AS idi LEFT JOIN pagina_web AS paw ON idi.id_idioma = paw.id_idioma AND idi.codigo = ? AND paw.id_pagina = ? LEFT JOIN bus AS bus ON bus.id_pagina = paw.id_pagina GROUP BY paw.id_pagina ORDER BY paw.id_pagina DESC;",array($idioma,$idPaginaWeb) )->row_array();
        return @$response['cantidad_servicios']?$response['cantidad_servicios']:0;
    }
}




