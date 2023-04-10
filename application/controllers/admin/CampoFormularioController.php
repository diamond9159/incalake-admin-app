<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CampoFormularioController extends CI_Controller {

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
	public function index()
	{
		/*
			@administración
			Formularios para cms - nombres, apellidos, ....
		*/

		/* CampoFormulario_::class 	 - 	Model  tabla 'campo_formulario' */
		$inputs = CampoFormulario_::join('campo_categoria', function ($join) {
			$join->on('campo_categoria.id_campo_categoria', '=', 'campo_formulario.id_campo_categoria');
		})
		->orderBy('campo_formulario.id_campo_categoria', 'desc')
		->orderBy('prioridad_campo', 'asc') 
		->get();


		$forms = [];
		$flag = "";
		$j = -1;

		//Ordenamos segun la categoria - $inputs
		foreach($inputs as $i) {
			if($i['id_campo_categoria'] != $flag) {
				array_push($forms, [
					'nombre_categoria' => json_decode($i['nombre_campo_categoria'], true),
					'categoria_id' => $i['id_campo_categoria'],
					'formulario' => [[
						'id_campo_formulario' => $i['id_campo_formulario'],
						'nombre_campo' => json_decode($i['nombre_campo']),
						'prioridad_campo' => $i['prioridad_campo']
					]]
				]);
				$flag = $i['id_campo_categoria'];
				$j++;
			} else {
				array_push($forms[$j]['formulario'], [
					'id_campo_formulario' => $i['id_campo_formulario'],
					'nombre_campo' => json_decode($i['nombre_campo'], true),
					'prioridad_campo' => $i['prioridad_campo']
				]);
			}
		}

		echo json_encode($forms);
	}
	/* Almacenamos el registro de campos */
	public function store()
	{
	    $idiomas = Idioma_::get();
        $input_label_traducciones = [];

        foreach($idiomas as $key => $idioma) {
            $input_label_traducciones[strtolower($idioma->codigo)] = $_POST['input_label'][$key];
        }
        
        $campof = new CampoFormulario_;
	        $campof->nombre_campo = json_encode($input_label_traducciones);
	        $campof->id_campo_categoria = $_POST['input_categoria'];
        $campof->save();

        redirect($_SERVER['HTTP_REFERER']);
	}

	/* Actualizamos el registro de campos */
	public function update() 
	{
			$idiomas = Idioma_::get();

        $input_label_traducciones = [];
        foreach($idiomas as $key => $idioma) {
            $input_label_traducciones[strtolower($idioma->codigo)] = $this->input->post('txtcampo')[$key];
        }

		$f = CampoFormulario_::find($this->input->post('id_campo_formulario'));
		$f->nombre_campo = json_encode($input_label_traducciones);
		$f->id_campo_categoria = $this->input->post('id_campo_categoria');
		$f->update();
		redirect($_SERVER['HTTP_REFERER']);
	}

	/* Eliminamos el registro de algun campo*/
	public function delete()
	{
		CampoFormulario_::find($_GET['id'])->delete();
	}

	/* Actualizamos los registros de los formularios para ordernar segun la prioridad de visualizacion */

	public function updatePrioridad()
	{
		$forms = $this->input->post('forms');
		$cont = 0;
		foreach ($forms as $index => $f) {
			foreach($f['formulario'] as $ff) {
				$d = CampoFormulario_::find($ff['id_campo_formulario']);
				$d->prioridad_campo = $cont++;
				$d->save();
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */