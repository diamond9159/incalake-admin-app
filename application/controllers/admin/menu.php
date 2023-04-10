<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
    public function __construct() {
	  parent::__construct();
	  // modelo para el controlador actual 
	  $this->load->model('admin/menum');
	  // idiomas
      $this->load->model('admin/idioma_model');
   }

	public function index(){
		// obtener la lista del menu
		$datos['lista_datos'] = $this->menum->obtenerDatos();
		// obtener idiomas
		$datos['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		
		$this->load->view('admin/menu/index',$datos);
	}
	 /* para editar registrar menu */
	 public function regedit_menu(){
      if(count($_POST)){
        $data['menu_name'] = $this->input->post('nombre_menu');
		$data['parent_id'] = $this->input->post('parent_menu');
		$data['cod_servicio'] = $this->input->post('id_servicio')?$this->input->post('id_servicio'):NULL;
		$data['idiomas_url'] = json_encode($this->input->post('urls'));
		$data['idiomas_nombres'] = json_encode($this->input->post('nombres'));
		// check para setear si link de abre en nueva ventana o no
		$data['target'] = $this->input->post('nueva_ventana')?$this->input->post('nueva_ventana'):0;
		$data['icono'] = $this->input->post('icono');
		$data['background'] = $this->input->post('color_menu')=='#FFFFFF'?null:$this->input->post('color_menu');
		$editar = $this->input->post('id_menu')?$this->input->post('id_menu'):false;
		// si $editar es false se indica al modelo para cree uno nuevo de lo contrario se edita ya que dicha variable contiene la id del elemento
		echo $this->menum->procesarMenu($data,$editar);  
      } else {
          echo 0;
      }
	}
	
	 public function eliminar_menu()
	 {  
	    echo $this->menum->eliminarMenu($this->input->post('id'));
	    
	 }
	 public function modificar_relevancia()
	 { 
	    print_r($this->menum->reordenarRelevancia($this->input->post()));
	 }
	 // metodo para generar el json que es leido desde 'WEB'
	 public function generar_json()
	 {   
	 	//get idiomas
	 	$idiomas = $this->idioma_model->get_nombre_idiomas();
	 	//
	 	// obtener arbol del menu
	 	$lista_datos = $this->menum->obtenerMenuJSON();

		// reordenar los datos para ajustarse al formato requerido por 'WEB'
        function reordenar_array($lista_datos,$idioma){
	 	
	 	$new_array_links = array();
	  		foreach($lista_datos as $value){
	  			$nombres = json_decode($value['idiomas_nombres'],true);
	  			$idiomas = json_decode($value['idiomas_url'],true);
	  			$values_temp['nombre'] = $nombres[$idioma];
	  			$values_temp['target'] = $value['target'];
	  			$values_temp['url'] = $idiomas[$idioma];
	  			$values_temp['id'] = $value['menu_id'];
	  			$values_temp['icono'] = $value['icono'];
	  			$values_temp['background'] = $value['background'];
	  			
	  			$new_array_links[$value['parent_id']][]=$values_temp;
	  		}
	  		return $new_array_links;
	 	}
	 	//escribir en txt de cada idioma el idioma correspondiente
	 	 $ruta = '../web/assets/menu/';
		 $new_array = array();
		 foreach($idiomas as $value){
		 	$ruta_edit=$ruta.$value['codigo'].'.txt';
	        $open = fopen($ruta_edit,"w+"); 
			@fwrite($open, json_encode(reordenar_array($lista_datos,$value['codigo'])));
		 }
		 echo 1;

	    
	 }
}