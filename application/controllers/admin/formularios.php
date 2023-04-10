<?php

/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 01/07/2017
 * Time: 08:23 AM
 */

class Formularios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model');
        $this->load->model('admin/categoria_form');
        $this->load->model('admin/campo_formulario');
        $this->load->library("response");
        $this->load->library("query");
    }

    /* Cargar vista formulario */
    public function index()
    {
        $template["view"] = $this->page("admin/formularios/index"); 
        $this->render($template);
    }

    /* Vista categoria */
    public function categoria() 
    {
        $template["view"] = $this->page("admin/formularios/categoria");
        $this->render($template);
    }
    
    /* Muestra categorias*/
    public function categoria_show() {
        echo $this->query
            ->table("categoria_campo")
            ->select("*")
            ->getJson();
    }
    
    /* Eliminamos la categoria relacionada a ese formulario */
    public function categoria_delete() {
        $this->categoria_form->delete($_GET['categoria_id']);
        redirect($_SERVER['HTTP_REFERER']);
    }

    /* Elimina un formulario */
    public function input_delete()
    {
        $this->campo_formulario->delete($_GET['input_id']);
    }

    /* Actualiza o crea nombres de categoria para los formularios segun idiomas*/
    public function categoria_create_update()
    {
        $idiomas = $this->query
            ->table("idioma")
            ->select("*")
            ->getArray();

        $categoria_nombre_traducciones = [];
        foreach($idiomas as $key => $idioma) {
            $categoria_nombre_traducciones[strtolower($idioma['codigo'])] = $_POST['nombre_categoria'][$key];
        }

        $categoria = array();
        $categoria['nombre_categoria'] = json_encode($categoria_nombre_traducciones);

        if($_POST['action'] == 'update') {
            $this->categoria_form
                ->where('id', $_POST['categoria_id'])
                ->update($categoria);
        } else if($_POST['action'] == 'create') {
            $this->categoria_form
                ->insert($categoria);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    /*  */
    public function page($directory, $data = null) {
        return $this->load->view($directory, $data ,true);
    }

    /* mi numero */
    public function render($template)    {
        $this->load->view("admin/formularios_template", $template);
    }


}