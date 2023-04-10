<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends CI_Controller {
    public function __construct() {
		parent::__construct();
		$this->load->model('admin/producto');
		$this->load->model('admin/idioma_model');
		$this->load->model('admin/disponibilidad_model');
		$this->load->model('admin/oferta_model');
    	$this->load->model("admin/guia_model");
		$this->load->model('admin/producto_has_campo_formulario');
		$this->load->helper('url');
		$this->load->model('model');
		$this->load->library("query");
   }

	public function index(){
		// retorna todo los productos y luego los envia a la vista
		$datos['resultados'] = $this->producto->obtenerProductos();
		$this->load->view('admin/listaProductos',$datos);
	}

	public function agregar(){
		// id del producto es 0 si se agrega nuevo
		$idProducto = 0;
        $tipo_politicas = 1;
		/*
		  extraer algunos datos si esque se registra un idioma relacionado al segmento/producto 
		  $this->uri->segment(5) contiene el id del codigo producto que se buscará
		*/
		if(!empty($this->uri->segment(5))){
			// buscar codigo de producto del cual se extraerá algunos datos
			$result = $this->producto->buscarCodigoProducto($this->uri->segment(5));

			// si hay resultado retornar datos a un array
			if($result){		
				// retornar mayoria de datos a esta variable
				$data['producto_relacionado'] = $result;
				$idProducto = $data['producto_relacionado']['id_producto'];
		        $data['producto_relacionado']['disponibilidad'] = $this->disponibilidad_model->get_disponibilidad_clonar($idProducto);
		        $data['producto_relacionado']['bloqueo']        = $this->bloqueo_model->get_bloqueo_clonar($idProducto);
		        $data['producto_relacionado']['oferta']         = $this->oferta_model->get_oferta_clonar($idProducto);
		        $data['producto_relacionado']['data_mapa'] 		= $this->producto->getTabProducto($idProducto);
		        $data['producto_relacionado']['data_producto']  = Producto_::find($idProducto);
                // $data['producto_relacionado']['guias']		= $this->guia_model->getProductoGuia( $idProducto,$result['id_idioma'] ); 
				$tipo_politicas		= strlen(trim($data['producto_relacionado']['politicas_producto'])) == 0 ? 0 : 1; 
				// 0 = politica Standar, 1 = politica personalizada
			
                 /* PARA COPIA */
				/* Formulario que son asiganos a un producto */                       
		        $array_inputs = $this->producto_has_campo_formulario->ability($idProducto);
		
				/* Lista de todos los formularios */
				$forms =    $this->query
				            ->table("campo_formulario")
				            ->select(["campo_formulario.id_campo_formulario as input_id", "nombre_campo", "nombre_campo_categoria"])
				            ->join('campo_categoria', 'campo_formulario.id_campo_categoria = campo_categoria.id_campo_categoria')
				            ->orderBy('campo_categoria.nombre_campo_categoria', 'desc')
				            ->orderBy('campo_formulario.prioridad_campo', 'asc')
				            ->getArray();
				            
				/*
					NOTA: Las variables $array_inputs y $forms estan funcionadas para poder indicar que campos estan checkeadas
				*/

				           
				 $forms_check = [];
				
				/* 
					Listamos todos los formularios
					@foreach - Utilizado para crear los formularios que van a ser checkeados en la vista.
				*/
				foreach($forms as $f){
					array_push($forms_check, [
						'input_id' => $f['input_id'],
						'nombre_campo' => $f['nombre_campo'],
						'nombre_campo_categoria' => $f['nombre_campo_categoria'],
						/* 
						 	$this->checkboxs_ability()
							Método habilitado para validar si este formulario esta asignado a un producto
						*/
						'checked' => count($array_inputs) > 0 ? $this->checkboxs_ability($f['input_id'], $array_inputs): 'false', 
					]);
				}	

				$forms_check;

                $data['producto_relacionado']['demo'] = $forms_check;


			// si no hay resultados de (producto relacionado) redirigir a crear nuevo
			} else {
				redirect(base_url().'admin/productos/agregar/'.$this->uri->segment(4));
			}
		}
		//fin extraer datos
		//
		
		$data['servicio'] 				= $this->producto->recuperarServicio($this->uri->segment(4));
		$data['idiomas'] 				= $this->idioma_model->get_nombre_idiomas();
        $data['guias_disponibles']      = $this->guia_model->getGuiasByIdioma( $data['servicio']['codigo']?$data['servicio']['codigo']:'ES' );
		//$data['next_codigo_producto'] 	= $this->producto->getNextCodigoProducto($idProducto);
		//var_dump($data);
        if ($tipo_politicas == 0) {
			$data['texto_politicas'] = $this->obtenerPolitcasStandar($data['servicio']['codigo']);
		}else if ($tipo_politicas == 1) {
			$data['texto_politicas'] = "";
		}

        /* Formulario que son asiganos a un producto */     
		$array_inputs = $this->producto_has_campo_formulario->ability($this->uri->segment(4));

		$forms =    $this->query
		            ->table("campo_formulario")
		            ->select(["campo_formulario.id_campo_formulario as input_id", "nombre_campo", "nombre_campo_categoria"])
		            ->join('campo_categoria', 'campo_formulario.id_campo_categoria = campo_categoria.id_campo_categoria')
		            ->orderBy('campo_categoria.nombre_campo_categoria', 'desc')
		            ->orderBy('campo_formulario.prioridad_campo', 'asc')
		            ->getArray();
		/*
			NOTA: Las variables $array_inputs y $forms estan funcionadas para poder indicar que campos estan checkeadas
		*/
		            
		           
		 $forms_check = [];
		foreach($forms as $f)
		{
			array_push($forms_check, [
				'input_id' => $f['input_id'],
				'nombre_campo' => $f['nombre_campo'],
				'nombre_campo_categoria' => $f['nombre_campo_categoria'],
				/* 
				 	$this->checkboxs_ability()
					Método habilitado para validar si este formulario esta asignado a un producto
				*/
				'checked' => count($array_inputs) > 0 ? $this->checkboxs_ability($f['input_id'], $array_inputs): 'false',
			]);
		}	

		$data['formularios'] = $forms_check;

		// si servicio existe enviar datos a la vista de crear producto nuevo
		if($data['servicio'])$this->load->view('admin/productos',$data);
		// ni no existe redirigir a crear servicio nuevo
		else redirect(base_url().'admin/servicio/add');
	}

   /* cuando se edita se utilizará la misma vista cambiando ciertos aspectos */
	public function editar(){
		// buscar a traves de codigo de producto el producto a editar dicho codigo se obtiene desde el segmento 4 de la url
		$data['producto'] 	= $this->producto->obtenerProducto($this->uri->segment(4));
        $data['guias']		= $this->guia_model->getProductoGuia( $data['producto']['id_producto'],$data['producto']['id_idioma']);
		$tipo_politicas		= strlen(trim($data['producto']['politicas_producto'])) == 0 ? 0 : 1; // 0 = politica Standar, 1 = politica personalizada
		//$data['texto_politicas'] = $tipo_politicas;
		
		if ($tipo_politicas == 0) {
			$data['texto_politicas'] = $this->obtenerPolitcasStandar($data['producto']['codigo']);
		}else if ($tipo_politicas == 1) {
			$data['texto_politicas'] = @$data['producto']['politicas_producto'];
		}
		
		$data['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$array_inputs = $this->producto_has_campo_formulario->ability($this->uri->segment(4));
		
		$forms =    $this->query
		            ->table("campo_formulario")
		            ->select(["campo_formulario.id_campo_formulario as input_id", "nombre_campo", "nombre_campo_categoria"])
		            ->join('campo_categoria', 'campo_formulario.id_campo_categoria = campo_categoria.id_campo_categoria')
		            ->orderBy('campo_categoria.nombre_campo_categoria', 'desc')
		            ->orderBy('campo_formulario.prioridad_campo', 'asc')
		            ->getArray();
		            
		           
		 $forms_check = [];
		foreach($forms as $f){
			array_push($forms_check, [
				'input_id' => $f['input_id'],
				'nombre_campo' => $f['nombre_campo'],
				'nombre_campo_categoria' => $f['nombre_campo_categoria'],
				/* 
				 	$this->checkboxs_ability()
					Método habilitado para validar si este formulario esta asignado a un producto
				*/
				'checked' => count($array_inputs) > 0 ? $this->checkboxs_ability($f['input_id'], $array_inputs): 'false',
			]);
		}	

		$data['formularios'] = $forms_check;

		//echo json_encode($data['producto']);
		// si existe producto enviar dichos datos a la vista para su edicion
		if($data['producto'])$this->load->view('admin/productos',$data);
		// si no existe producto redirigir a el index (dashboard)
		else redirect(base_url().'admin');
	}

	/* 
	 * 	
	*/
	public function checkboxs_ability($search, $array_inputs)
	{
			
		$check = "false";

		foreach($array_inputs as $i)
		{
			if($i == $search) {
				$check = "true";
			}
		}

		return $check;
	}
	
	/* la siguiente funcion es muy importante ya que con ella se registra nuevas actividades/productos como tambien se edita */
	public function regedit(){
		$param['titulo_producto'] 	 = $this->input->post('titulo_prod');
		$param['subtitulo_producto'] = $this->input->post('subtitulo_prod');
		$param['codigo_producto'] 	 = $this->input->post('codigo_prod');
		$param['tasas_impuestos']	 = $this->input->post('tasas_impuestos');
		$param['porcentaje_adelanto']	 = $this->input->post('porcentaje_adelanto'); // porcentaje de la primera cuota (adelanto)
		$param['id_codigo_producto'] = $this->input->post('codigo_prod_2');// para asociar con idiomas relacionados
		$param['ciudad_cercana'] 	 = $this->input->post('ciudad_cercana');
		$param['aeropuerto_cercano'] = $this->input->post('aeropuerto_cercano');
		$param['politicas_producto'] = $this->input->post('politicas');
		$param['requerimiento_datos']= $this->input->post('requerimiento_datos');
		// si afora esta vacio se le da el valor de 0
		$param['capacidad']          = trim($this->input->post('aforo') ) ? trim($this->input->post('aforo') ) : 0;
		$param['fecha'] 			 = date('Y-m-d H:i:s');
		$param['tipo_recojo']		 = $this->input->post('tiporecojo');
		$param['lugar_recojo']       = $this->input->post('txt_lugar_encuentro');
		$param['lugar_finalizacion_actividad'] = $this->input->post('txt_lugar_finalizacion');
		// forms_multiple = si el formulario de reserva es obligatorio: 1=para todos;0=solo lider del grupo;
		$param['forms_multiple'] = $this->input->post('forms_multiple')?1:0;
       
        $param['requerir_disponibilidad'] = $this->input->post('chckbxRequirirDisponibilidad')?1:0;

		$politica_seleccionada = '';
		$politica_check				 = $this->input->post('tipopolitica');
		switch ( (Integer)$politica_check ) {
			case 0:
				$politica_seleccionada = '';
			break;
			case 1:
				$politica_seleccionada = trim($this->input->post('politicas'));
			break;
		}
		$param['politicas_producto']   = $politica_seleccionada; 


		if(!empty($this->input->post('anticipacion_reserva'))){
			$param['anticipacion_reserva_producto'] = $this->input->post('anticipacion_reserva').':'.$this->input->post('anticipacion_reserva_tipo');// tiempo antes que se debe separar la reserva
		} else $param['anticipacion_reserva_producto'] = '';

		// estado de producto si se muestra en la pagina (checked) : 1 de lo contrario 0
		$param['estado_producto'] = empty($this->input->post('estado_producto'))?'0':'1';
		if($this->input->post('adjuntos_producto'))$param['adjuntos_producto'] = implode(",",array_filter($this->input->post('adjuntos_producto')));//archivo adjunto

		// si existe horario de salidas (siempre iran de la mano)
		// las tres variables 
		if($this->input->post('horasalida_prod')){
			// unir todo los horarios de inicios separado por comas
			$param['hora_inicio'] = implode(",", $this->input->post('horasalida_prod'));
			// tipo de tiempo que es un array tipo_medida_duracion[]
			$tipo_medida_duracion = $this->input->post('tipo_medida_duracion');
			// foreach a toda las duraciones 
			foreach ($this->input->post('horaretorno_prod')  as $key => $value) {
				// crear un array concatenando en el siguiente formato ejemplo 30!0 = 30 minutos
				$arrayDuracion[] = $value.'!'.$tipo_medida_duracion[$key];
			}
			// unir en un string los valores de arrayDuracion separados por una coma
		    $param['duracion'] = implode(",", $arrayDuracion);
            // unir los valores de zona horaria los cuales tienen valores de solo 1y0
            $param['zona_horaria'] = implode(',',$this->input->post('zona_horaria'));
		} else {
		   // si no existe hora de inicio, duracion y zona horaria enviarlos como nulo
           $param['hora_inicio'] = null; 
           $param['duracion'] = null;
           $param['zona_horaria'] = null;
        }
		
		//parametros que describen al tour
		$html['descripcion_tab'] 	= $this->input->post('descripcion_prod');
		$html['itinerario_ta'] 		= $this->input->post('itinerario_prod');
		$html['incluye_tab'] 		= $this->input->post('incluye_prod');
		$html['informacion_tab'] 	= $this->input->post('info_prod');
		$html['mapa_tab'] 			= $this->input->post('map_prod') ;
		$html['recomendacion_tab'] 	= $this->input->post('recomendaciones_prod');
		//tabs adicionales el formulario los envia como arrays
	    $addedtabs['nombre'] = $this->input->post('addedTabs_nombre');
	    $addedtabs['icono']  = $this->input->post('addedTabs_icono');
		$addedtabs['contenido'] = $this->input->post('addedTabs_contenido');

		//galeria de imagenes
		$galeria['id'] = $this->input->post('sliderGaleria');
		// se obtiene el value del toton del formulario
		$button = $this->input->post('formButton');
		// si valor del boton es igual a Actualizar es porque se esta editando de lo contrario se esta creando uno nuevo
		if($button == 'Actualizar'){
			// si tiene id de producto entonces el modelo editará
			$id_producto = $this->input->post('ideGeneral');
			// 
			$inputsKey = $this->input->post('inputs');
			// 
			$array_inputs = $this->producto_has_campo_formulario->updateProductForm($id_producto, $inputsKey);
		} else {
			// si se crea un nuevo registro 'Guardar' se recuperara la id del servicio donde pertenece
			$param['id_servicio'] = $this->input->post('ideGeneral'); 
			// cuando se agrega se enviar la variable id_producto para que el modelo lo detecte cuando se crea nuevo registro
			$id_producto = false;
		}
		/*********** OPERACION DE DATOS SOBRE DISPONIBILIDAD, BLOQUEO, OFERTA *************/
		$datos_extra = array();
		$datos_extra['data_disponibilidad'] = $this->input->post("txt_data_json_disponibilidad");
		$datos_extra['data_bloqueo'] 		= $this->input->post("txt_data_json_bloqueo");
		$datos_extra['data_oferta']			= $this->input->post("txt_data_json_oferta");

		/********** FIN OPERACION DE DATOS SOBRE DISPONIBILIDAD, BLOQUEO, OFERTA **********/
		/********************* OPERACION DE DATOS SOBRE GUIA ************************/
		$paramsGuiasSeleccionados = [];	
		$checkboxGuiaSelected = !empty($this->input->post("tipoguia"))?$this->input->post("tipoguia"):0;
		$inputGuiasSeleccionados = !empty($this->input->post('slct_guias_seleccionados'))?$this->input->post('slct_guias_seleccionados'):[];
		
		$dataIdProducto = !empty($this->input->post('ideGeneral'))?$this->input->post('ideGeneral'):0;

		foreach ($inputGuiasSeleccionados as $key => $value) {
			$arrayData = explode("*",$value);
			$paramsGuiasSeleccionados[] = array(
				'id_producto' => $arrayData[1], // id_producto
				'id_guia'	  => $arrayData[3], // id_guia
				'id_idioma'   => $arrayData[0], // id_idioma
				'id_codigo_producto' => $arrayData[2], // id_codigo_producto
				'id_codigo_guia'     => $arrayData[4], // id_codigo_guia
				'tipo_guia'          => $checkboxGuiaSelected
			);			
		}
		/******************* END OPERACION DE DATOS SOBRE GUIA **********************/
		//echo json_encode($this->input->post('precio'));
		$inputsKey = $this->input->post('inputs');

		// si el registro o actualizacion de datos tiene exito entonces retornara:
		// registro nuevo: id del codigo del prodcuto reciente
		// cuando se editar: retorna 0=exito  o  1=exito 
		$exito = $this->producto->operarProducto($param,$this->input->post('precio'),$html,$addedtabs,$galeria,$id_producto,$datos_extra,$paramsGuiasSeleccionados, $inputsKey);
		// si no retorna 0 esque la operacion se realizo correctamente
		if($exito){
			// si se creó un registro nuevo entonces agregar a data[] el codigo del producto creado
			if(!$id_producto){
				//$data['datos'] = $this->producto->idiomasDisponibles($param['id_servicio']);
				$data['id_codigo_producto'] = $exito;// $exito retorna del modelo id_codigo_producto
			}
			//else $data['datos'] = false;
		}
		
		/*$data['titulo_prod'] = $param['titulo_producto'];//para la vista del mensaje e exito o error
			//$this->load->view('admin/productos/estado_de_subida',$data);
		$this->load->view('admin/productos/estado_de_subida',$data);*/
		$codProd = empty($param['id_codigo_producto'])?$data['id_codigo_producto']:$param['id_codigo_producto'];
		redirect(base_url().'admin/productos/codproducto/'.$codProd);
	}
	/*funcion para ver los productos relacionados en diferentes idiomas*/
	function codproducto(){	
		$data['resultados'] = $this->producto->recuperarProductosRelacionados($this->uri->segment(4));
		//$data['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$this->load->view('admin/productos/productosRelacionados',$data);
	}
	/*fin de la funcion para ver los productos relacionados en diferentes idiomas*/
	/*funcion para ver los productos relacionados en diferentes idiomas*/
	function ver(){	
		$data['resultados'] = $this->producto->recuperarPorIdServicio( $this->uri->segment(4) );
		$data['idioma'] = $this->idioma_model->get_idioma_id_servicio( $this->uri->segment(4) );
		//$data['idiomas'] = $this->idioma_model->get_nombre_idiomas();
		$this->load->view('admin/productos/productos_por_id_servicio', $data);
	}
	/*fin de la funcion para ver los productos relacionados en diferentes idiomas*/
	function remove($id_producto){
        $data['data']  = array();
        $producto = $this->producto->obtenerProducto($id_producto);
        if(isset($producto['id_producto'])){
            $rpta = $this->producto->eliminar($id_producto);
            if ($rpta) {
                $data = array('response' => 'OK'); 
            }else{
                $data = array('response' => 'ERROR',
                	'data'=>'no se a podido eliminar',
                	'producto'=>$producto);
            }
            //redirect('admin/lugar');
        }else{
            $data = array('respose' => 'ERROR',
            	'data'=>'este registro no existe',
            	'producto'=>$producto);
        }
        echo json_encode($data);        
    }

    function obtenerPolitcasStandar($language){
 		$this->load->helper('file');
        $buffer             = '';
        //$ruta = $_SERVER['DOCUMENT_ROOT']."/web/assets/archivos/politicas/".strtoupper($language).".txt";
        $ruta = "../web/assets/archivos/politicas/".strtoupper($language).".txt";
        $leer	= fopen($ruta, 'r+');
        while(!feof($leer)){ 
            $buffer .= fgets($leer);  
        } 
        return $buffer;
    }

    function nextCodigoProducto(){
    	$language = $this->input->post('lang');
    	$idServicio = $this->input->post('idservicio');
    	$response = $this->producto->getNextCodigoProducto($language,$idServicio);

    	echo json_encode(trim($response));
    }

    function copiar_precios(){
    	echo $this->producto->copiar_precios($this->input->post('id_producto'),$this->input->post('codigo_producto'));
    	
	}
	
	function copiar_adelanto(){
    	echo $this->producto->copiar_adelanto($this->input->post('id_producto'),$this->input->post('codigo_producto'));
    	
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */