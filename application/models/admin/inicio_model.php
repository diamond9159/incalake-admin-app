<?php

class Inicio_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/producto');
    }
    function obtener_ultimas_preguntas(){
        return $this->db->query("SELECT id,nombre,actividad,fecha FROM preguntas WHERE id_usuarios = 1 AND leido = 0 ORDER BY fecha DESC LIMIT 10")->result_array();
    }
}
