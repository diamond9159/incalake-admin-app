<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Paginahtml extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo para el controlador actual
	  $this->load->model('admin/paginas_html_model');
	  // modelo para obtener lista de idiomas
      $this->load->model('admin/idioma_model');
    
   }

	public function index(){
		// obtiene lista de los nombres con sus respectivas paginas.
		$datos['lista_nombres'] = $this->paginas_html_model->obtenerNombresPagina();
		// retornar todos los idiomas
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$this->load->view('admin/paginas_html/index',$datos);
	}
	// metodo para agregar y editar nombres (agrupadores de paginas).
    public function regedit_nombres(){
		$data['nombre_pagina'] = $this->input->post('nombre'); 
		// si tipo tiene la una ID entonces se edita de lo contrario se crea uno nuevo
        echo $this->paginas_html_model->procesar_nombre_pagina($data,$this->input->post('tipo'));
       
    }
	 // metodo de agregar y editar una pagina 
	 public function regedit_pagina(){
      // si hay datos post		
      if(count($_POST)){
		// set datos
        $data['titulo'] = $this->input->post('titulo');
		$data['keywords'] = $this->input->post('keywords');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['contenido'] = $this->input->post('contenido');
		$data['url'] = $this->input->post('url');

		// si no existe ID de una pagina se crea uno nuevo
		if(!$this->input->post('id')){
			// agregar algunos parametros que solo se indican al crear uno nuevo
			$data['id_idioma'] = $this->input->post('idioma');
			$data['id_pagina'] = $this->input->post('pagina');
			// indicar a variable que no se edita
			$editar = false;
		// si existe una id entonces se edita y se le da a la variable $editar el id de la pagina a editar
		} else $editar = $this->input->post('id');
        // imprimir el resultado desde el modelo 
		echo $this->paginas_html_model->procesarPagina($data,$editar);  
      } else {
		  // si no existe datos post imprimir 0
          echo 0;
      }

	}
	
	// eliminar nombres (agrupador de paginas)
	 public function eliminar_nombres()
	 { 
	    echo $this->paginas_html_model->eliminarNombre($this->input->post('id'));
	    
	 }

	// eliminar una pagina
	 public function eliminar_pagina()
	 { 
	    echo $this->paginas_html_model->eliminarPagina($this->input->post('id'));
	    
	 }
	
}