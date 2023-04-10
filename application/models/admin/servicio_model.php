<?php

class Servicio_model extends CI_Model{
    private $URLWEB = 'https://web.incalake.com/';
    function __construct(){
        parent::__construct();
        $this->load->model('admin/producto');
    }

    function get_servicio($id_servicio){
        //$servicio = $this->db->query("SELECT * FROM servicio INNER JOIN galeria ON servicio.imagen_principal=galeria.id_galeria  WHERE servicio.id_servicio  = ?;",array($id_servicio))->row_array();
        $servicio = $this->db->query("SELECT s.* FROM codigo_servicio as cs JOIN servicio as s ON cs.id_codigo_servicio = s.codigo_servicio_id_codigo_servicio AND cs.id_usuarios = ? AND s.id_servicio = ?;",array($this->session->userdata("id_usuarios"),$id_servicio))->row_array();
        return $servicio;
    }

    function get_all_servicios(){
        $servicios = $this->db->query("
            SELECT * FROM servicio WHERE 1 = 1;")->result_array();
        return $servicios;
    }
    
    function add_servicio($params){
        $this->db->insert('servicio',$params);
        return $this->db->insert_id();
    }

    function update_servicio($id_servicio,$params){
        $this->db->where('id_servicio',$id_servicio);
        $response = $this->db->update('servicio',$params);
        if($response){
            return 1;
        } else {
            return 0;
        }
    }
    
    function delete_servicio($id_servicio){
        $response = $this->db->delete('servicio',array('id_servicio'=>$id_servicio));
        if($response){
            return 1;
        } else {
            return 0;
        }
    }
    /***************************************************************************************/
    function get_servicios($id_codigo_servicio){
        $all_servicios = $this->db->query("
            SELECT * FROM servicio as s INNER JOIN idioma as i WHERE s.idioma_id_idioma = i.id_idioma AND s.codigo_servicio_id_codigo_servicio = ?;",array($id_codigo_servicio))->result_array();
        $data = array();
        foreach ($all_servicios as $key => $value) {
            $arrayDestino = explode(",",$value['ubicacion_servicio']); 
            $data[] = array(
                "id_servicio"       => $value['id_servicio'],
                "url_servicio"      => $value['url_servicio'],
                "titulo_pagina"     => $value['titulo_pagina'],
                "descripcion_pagina"=> $value['descripcion_pagina'],
                "imagen_principal"  => $value['imagen_principal'],
                "ver_slider"        => $value['ver_slider'],
                "miniatura"         => $value['miniatura'],
                "valoracion"        => $value['valoracion'],
                "reviews"           => $value['reviews'],
                "idioma_id_idioma"  => $value['idioma_id_idioma'],
                "codigo_servicio_id_codigo_servicio" => $value['codigo_servicio_id_codigo_servicio'],
                "id_idioma"         => $value['id_idioma'],
                "pais"              => $value['pais'],
                "codigo"            => $value['codigo'],
                "paquetes"          => $this->producto->get_productos_by_id_servicio($value['id_servicio']),
                "url_web"           => $this->URLWEB.mb_strtolower($value['codigo'])."/".mb_strtolower($this->uri_amigable($arrayDestino[0]))."/".mb_strtolower($this->uri_amigable($value['uri_servicio']) ),
            );
        }
        return $data;
        //return $all_servicios;
    }

    function get_group_servicios(){
        $data = array();
        //$codigo_servicios = $this->db->query("SELECT * FROM servicio WHERE 1=1 GROUP BY codigo_servicio_id_codigo_servicio;")->result_array();
        $codigo_servicios = $this->db->query("SELECT * FROM codigo_servicio as cs JOIN servicio as s ON cs.id_codigo_servicio = s.codigo_servicio_id_codigo_servicio AND cs.id_usuarios = ".$this->session->userdata("id_usuarios")." GROUP BY cs.id_codigo_servicio;")->result_array();
        if (!empty( $codigo_servicios ) ) {
            foreach ($codigo_servicios as $key => $value) {
                $data[] = array(
                    'group_pages'   => $this->get_servicios($value['codigo_servicio_id_codigo_servicio']),       
                );
            }
        }
        return $data;
    }

    //Retorna un solo registro para reutilizar en otro idioma
    function get_first_servicio($id_codigo_servicio){
        $first_servicio = $this->db->query("
            SELECT * FROM servicio WHERE codigo_servicio_id_codigo_servicio  = ?;",array($id_codigo_servicio))->row_array();
        return $first_servicio;
    }

    function get_servicio_with_paquetes($id_servicio){
        $data = array();
        $data['servicio'] = $this->get_servicio($id_servicio);
        $data['paquetes'] = $this->producto->get_productos_by_id_servicio($value['id_servicio']);
        return $data;
    }
    function get_count_servicio(){
        $count_servicio=array();
        $count_servicio[] = $this->db->query("
            SELECT count(*) as total_servicios FROM servicio ")->row_array();
        $count_servicio[] = $this->db->query("
            SELECT count(*) as total_paquetes FROM producto ")->row_array();
        return $count_servicio;
    }

    function verificar_duplicidad_url($url){
        return $this->db->query("SELECT url_servicio FROM servicio WHERE url_servicio = ?;",array($url))->row_array();
    }

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
}
