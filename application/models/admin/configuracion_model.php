<?php

class Configuracion_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model("admin/idioma_model");
        $this->load->model("admin/galeria_model");
    }

    function get_configuracion($id_configuracion){
        $configuracion = $this->db->query("SELECT * FROM configuracion WHERE id_configuracion = ?;",array($id_configuracion))->row_array();
        return $configuracion;
    }
    
    function get_all_configuraciones(){
        //$idiomas  = $this->idioma_model->get_nombre_idiomas();
        $response = $configuracions = $this->db->query("SELECT * FROM configuracion WHERE 1 = 1;")->result_array();
        $data      = array();
        foreach ($response as $key => $value) {
            $data[] = array(
                'id_configuracion' => $value['id_configuracion'],
                'nombre_empresa'   => $value['nombre_empresa'],
                'titulo_index'     => $value['titulo_index'],
                'keywords_index'   => $value['keywords_index'],
                'descripcion_index'=> $value['descripcion_index'],
                
                //'logo'             => $this->galeria_model->get_galeria($value['logo_index']),
                //'favicon'          => $this->galeria_model->get_galeria($value['favicon_index']),
                
                'logo'             => $this->galeria_model->get_archivo($value['logo_index']),
                'favicon'          => $this->galeria_model->get_archivo($value['favicon_index']),

                'codigo_google_analitics' => $value['codigo_google_analitics'],
                'codigo_zoopim'    => $value['codigo_zoopim']
            );
        }
        return $data;
    }
    
    function add_configuracion($params){
        $this->db->insert('configuracion',$params);
        return $this->db->insert_id();
    }
    
    function update_configuracion($id_configuracion,$params){
        $this->db->where('id_configuracion',$id_configuracion);
        $response = $this->db->update('configuracion',$params);
        if($response){
            return 1;
        }else{
            return 0;
        }
    }
    

    function delete_configuracion($id_configuracion){
        $response = $this->db->delete('configuracion',array('id_configuracion'=>$id_configuracion));
        if($response){
            return 1;
        } else {
            return 0;
        }
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
            default:
                $carpeta = 'otros';
                break;
        }
        return $carpeta;
    }
}