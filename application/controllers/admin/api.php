<?php
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model');
        $this->load->library("query");
    }

    public function idiomas() {
        echo $this->query
            ->table("idioma")
            ->select("*")
            ->getJson();
    }
    public function inputs()
    {
        echo $this->query
            ->table("campo_formulario")
            ->select("*")
            ->orderBy('id_campo_formulario', 'desc')
            ->getJson();
    }
}