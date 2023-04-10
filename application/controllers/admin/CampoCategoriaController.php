<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CampoCategoriaController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	/* Mostramos las categorias existentes del formulario */
	public function index()
	{
		echo CampoCategoria_::orderBy('id_campo_categoria', 'desc')->get();
	}

	/* Almacenamos nuevas categorias */
	public function store()
	{
		$idiomas = Idioma_::get();
		$categoria_traducciones = [];
		
		foreach($idiomas as $key => $idioma) 
		{
            $categoria_traducciones[strtolower($idioma->codigo)] = $_POST['nombre_categoria'][$key];
        }

        $c = new CampoCategoria_;
        $c->nombre_campo_categoria = json_encode($categoria_traducciones);
        $c->save();

        redirect($_SERVER['HTTP_REFERER']); //Redirect back()
	}
	/* Almacenamos nuevas categorias */
	public function update()
	{
		$idiomas = Idioma_::get();
		$categoria_traducciones = [];
		
		foreach($idiomas as $key => $idioma) 
		{
            $categoria_traducciones[strtolower($idioma->codigo)] = $_POST['nombre_categoria'][$key];
        }

        $c = CampoCategoria_::find($_POST['categoria_id']);
        $c->nombre_campo_categoria = json_encode($categoria_traducciones);
        $c->save();

        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete()
	{
		CampoCategoria_::find($_GET['id'])->delete();
        redirect($_SERVER['HTTP_REFERER']);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */