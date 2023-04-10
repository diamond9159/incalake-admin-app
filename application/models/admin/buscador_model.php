<?php

class Buscador_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_buscador($id_buscador){
        $buscador = $this->db->query("SELECT * FROM destinos_search WHERE id_destinos_search = ?",array($id_buscador))->row_array();
        return $buscador;
    }

    function get_all_buscadores(){
        $buscadors = $this->db->query("SELECT * FROM destinos_search WHERE 1 = 1 ORDER BY id_destinos_search DESC")->result_array();
        return $buscadors;
    }
        
    function add_buscador($params){
        $this->db->insert('destinos_search',$params);
        return $this->db->insert_id();
    }
    
    function update_buscador($id_buscador,$params){
        $this->db->where('id_buscador',$id_buscador);
        return $this->db->update('destinos_search',$params);
    }
    
    function delete_buscador($id_buscador){
        return $this->db->delete('destinos_search',array('id_destinos_search'=>$id_buscador));
    }



    //Obtiene la lista de destinos desde la tabla servicios atraves de idioma
    function get_destinos_disponibles($lang){
        //return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,id_usuarios,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.uri_servicio FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".trim(strip_tags(stripcslashes($lang)))."' GROUP BY s.ubicacion_servicio;")->result_array();

        return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,id_usuarios,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.uri_servicio,ds.id_servicio as id_servicio_search,ds.id_destinos_search FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".trim(strip_tags(stripcslashes(strtolower($lang))))."' LEFT JOIN destinos_search AS ds ON ds.id_servicio IS NULL OR s.id_servicio = ds.id_servicio GROUP BY s.ubicacion_servicio;")->result_array();
    }

    function get_actividades_disponibles($lang){
        //return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,id_usuarios,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.uri_servicio,p.id_producto,p.id_codigo_producto,p.titulo_producto FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".trim(strip_tags(stripcslashes($lang)))."' JOIN producto as p ON p.id_servicio = s.id_servicio  GROUP BY p.titulo_producto;")->result_array();
        return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,id_usuarios,s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio,s.ubicacion_servicio,s.uri_servicio,p.id_producto,p.id_codigo_producto,p.titulo_producto,acs.id_producto as id_actividad_search,acs.id_actividades_search FROM idioma AS i JOIN servicio AS s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".trim(strip_tags(stripcslashes(strtolower($lang))))."' JOIN producto as p ON p.id_servicio = s.id_servicio LEFT JOIN actividades_search as acs ON acs.id_producto IS NULL OR acs.id_producto = p.id_producto GROUP BY p.titulo_producto;")->result_array();
    }


    function add_actividades_search($params){
        $this->db->insert('actividades_search',$params);
        return $this->db->insert_id();
    }

    function add_destinos_search($params){
        $this->db->insert('destinos_search',$params);
        return $this->db->insert_id();
    }



    function delete_destinos_search($id_servicio,$id_codigo_servicio,$id_idioma){
        return $this->db->delete('destinos_search',array('id_servicio'=>$id_servicio,'id_codigo_servicio' => $id_codigo_servicio,'id_idioma'=>$id_idioma));
    }

    function delete_actividades_search($id_producto,$id_codigo_producto,$id_idioma){
        return $this->db->delete('actividades_search',array('id_producto'=>$id_producto,'id_codigo_producto'=>$id_codigo_producto,'id_idioma'=>$id_idioma));
    }
/*
    private function uri_amigable($token) {
        $separador = '-';//ejemplo utilizado con guión medio
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        //Quitamos todos los posibles acentos
        $url = strtr(utf8_decode($token), utf8_decode($originales), $modificadas);
        //Convertimos la cadena a minusculas
        $url = utf8_encode(strtolower($url));
        //Quitamos los saltos de linea y cuanquier caracter especial
        $buscar = array(' ', '&amp;', '\r\n', '\n', '+');
        $url = str_replace ($buscar, $separador, $url);
        $buscar = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;[^&gt;]*&gt;/');
        $reemplazar = array('', $separador, '');
        $url = preg_replace ($buscar, $reemplazar, $url);
        return $url;
    }
*/
}
