<?php

class Slider_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model("admin/galeria_model");
    } 

    function get_slider($id_slider){
        $slider = $this->db->query("SELECT * FROM slider WHERE id_slider = ? ;",array($id_slider))->row_array();
        $data = array();
        $data['id_slider']          = $slider['id_slider'];
        $data['titulo_slider']      = $slider['titulo_slider'];
        $data['descripcion_slider'] = $slider['descripcion_slider'];
        $data['url_destino']        = $slider['url_destino'];
        $data['galeria']            = $this->galeria_model->get_galeria($slider['id_galeria']);
        $data['fecha']              = $slider['fecha'];

        return $data;
    }

    function get_all_sliders(){
        $sliders = $this->db->query("SELECT * FROM slider WHERE 1 = 1 ORDER BY fecha ASC;")->result_array();
        $data  =array();
        foreach ($sliders as $key => $value) {
            $data[] = array(
                'id_slider'         => $value['id_slider'],
                'titulo_slider'     => $value['titulo_slider'],
                'descripcion_slider'=> $value['descripcion_slider'],
                'url_destino'       => $value['url_destino'],
                'galeria'           => $this->galeria_model->get_archivo($value['id_galeria']),
                'fecha'             => $value['fecha']  
            );
        }

        return $data;
    }

    function add_slider($params){
        $this->db->insert('slider',$params);
        return $this->db->insert_id();
    }
    
    function update_slider($id_slider,$params){
        $this->db->where('id_slider',$id_slider);
        $response = $this->db->update('slider',$params);
        if($response){
            return true;
        }else{
            return false;
        }
    }

    function delete_slider($id_slider){
        $response = $this->db->delete('slider',array('id_slider'=>$id_slider));
        if($response){
            return true;
        } else {
            return false;
        }
    }
}
