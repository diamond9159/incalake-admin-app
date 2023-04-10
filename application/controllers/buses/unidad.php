<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Unidad extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('buses/modelo_buses', 'modelo_buses');
		$this->load->model('buses/disponibilidad_model', 'Disponibilidad_model');
		$this->load->model('buses/oferta_model', 'Oferta_model');
		$this->load->model('buses/bloqueo_model', 'Bloqueo_model');
		$this->load->model('buses/lugar_has_bus_model', 'Lugar_has_bus_model');
		$this->load->model('buses/lugar_model', 'Lugar_model');
		$this->load->model('buses/formulario_model', 'Formulario_model');
		$this->load->model('buses/guia_model', 'Guia_model');
		/* $this->load->model('admin/idioma_model');
		$this->load->model('admin/inicio_model');
		$this->load->model('admin/reservas_model');*/

	}

	public function index()
	{
		//$this->load->view('main');
		/*$count_servicio['numservicios'] = $this->servicio_model->get_count_servicio();
		$data['ultimas_preguntas'] 	= $this->inicio_model->obtener_ultimas_preguntas();
		$data['ultimas_reservas'] 	= $this->reservas_model->get_ultimas_reservas();
		$this->load->view('admin/admin',$count_servicio);*/
		$data['buses'] = $this->modelo_buses->retorna_todo_buses();
		$this->load->view('buses/bus/index', $data);

	}
	// metodo para ver todos los buses relacionados a una pagina
	public function contenido_pagina()
	{
		$id_pagina = $this->uri->segment(4);
		$data['buses'] = $this->modelo_buses->retorna_buses_por_idpagina($id_pagina);
		if (!count(@$data['buses']['pagina_web']))
			redirect(base_url('buses/unidad/'));
		$this->load->view('buses/bus/buses_id_pagina', $data);
		//echo $id_pagina;

	}
	public function registro()
	{
		// BUSCAR PAGINA WEB SI NO EXISTE REDIRIGIR
		$id_pagina = $this->uri->segment(4);
		if (!$id_pagina)
			redirect(base_url('buses/unidad/'));
		$pagina_web = $this->modelo_buses->buscar_pagina($id_pagina);
		if (!count($pagina_web))
			redirect(base_url('buses/unidad/'));

		$data['pagina_web'] = $pagina_web;
		$data['empresas'] = $this->modelo_buses->obtenerEmpresas();
		// servicios = bus cama etc
		$data['servicios'] = $this->modelo_buses->obtenerServicios();
		// servicios adicionales = wifi , baño etc
		$data['servicios_adicionales'] = $this->modelo_buses->obtenerServiciosAdicionales();
		$data['lugares'] = $this->modelo_buses->obtenerLugares();
		$data['datospersonales'] = $this->Formulario_model->get_formularioBus("es", null);
		$data['guias'] = $this->Guia_model->get_guiasBus(null, "es");
		//$this->load->view('admin/admin',$count_servicio);
		$this->load->view('buses/bus/registro', $data);
	}

	public function editar()
	{
		// BUSCAR BUS SI NO EXISTE REDIRIGIR
		$id_bus = $this->uri->segment(4);
		if (!$id_bus)
			redirect(base_url('buses/unidad/'));
		$data['bus'] = $this->modelo_buses->buscar_bus($id_bus);
		//var_dump($data); exit;
		//if(!count($data['bus']['id_bus'])) 
		if (isset($data['bus']['id_bus']))
			redirect(base_url('buses/unidad/'));
		// buscar detalles de la pagina donde pertenece bus
		$data['pagina_web'] = $this->modelo_buses->buscar_pagina($data['bus']['id_pagina']);
		$data['empresas'] = $this->modelo_buses->obtenerEmpresas();
		// servicios = bus cama etc
		$data['servicios'] = $this->modelo_buses->obtenerServicios();
		// servicios adicionales = wifi , baño etc
		$data['servicios_adicionales'] = $this->modelo_buses->obtenerServiciosAdicionales();

		$data['lugares'] = $this->modelo_buses->obtenerLugares();

		$data['disponibilidad'] = $this->Disponibilidad_model->get_disponibilidadBus($id_bus);
		$data['bloqueos'] = $this->Bloqueo_model->get_bloqueosBus($id_bus);
		$data['ofertas'] = $this->Oferta_model->get_ofertasBus($id_bus);
		$data['arrayLugares'] = $this->Lugar_model->get_lugaresBus($id_bus);
		$data['datospersonales'] = $this->Formulario_model->get_formularioBus("es", $id_bus);
		$data['guias'] = $this->Guia_model->get_guiasBus($id_bus, "es");
		//$this->load->view('admin/admin',$count_servicio);
		$this->load->view('buses/bus/registro', $data);
	}
	// clonar
	public function copiar()
	{
		// BUSCAR PAGINA WEB SI NO EXISTE REDIRIGIR
		$id_pagina = $this->uri->segment(4);
		$id_codigo_bus = $this->uri->segment(5);
		if (!$id_pagina)
			redirect(base_url('buses/unidad/'));
		$pagina_web = $this->modelo_buses->buscar_pagina($id_pagina);
		if (!count($pagina_web))
			redirect(base_url('buses/unidad/'));

		$data['bus_copiado'] = $this->modelo_buses->copiar_bus($id_codigo_bus);
		// redirigir si no existe codigo bus
		if (!$data['bus_copiado'])
			redirect(base_url('buses/unidad/'));

		$data['pagina_web'] = $pagina_web;
		$data['empresas'] = $this->modelo_buses->obtenerEmpresas();
		// servicios = bus cama etc
		$data['servicios'] = $this->modelo_buses->obtenerServicios();
		// servicios adicionales = wifi , baño etc
		$data['servicios_adicionales'] = $this->modelo_buses->obtenerServiciosAdicionales();
		$data['lugares'] = $this->modelo_buses->obtenerLugares();
		//$this->load->view('admin/admin',$count_servicio);
		$id_bus = $data['bus_copiado']['id_bus'];
		// var_dump('esto es:'.$id_bus);
		$data['disponibilidad'] = $this->Disponibilidad_model->get_disponibilidadBus($id_bus);
		$data['bloqueos'] = $this->Bloqueo_model->get_bloqueosBus($id_bus);
		$data['ofertas'] = $this->Oferta_model->get_ofertasBus($id_bus);
		$data['arrayLugares'] = $this->Lugar_model->get_lugaresBus($id_bus);
		$data['datospersonales'] = $this->Formulario_model->get_formularioBus("es", $id_bus);
		$data['guias'] = $this->Guia_model->get_guiasBus($id_bus, "es");

		$this->load->view('buses/bus/registro', $data);
	}
	// eliminar bus
	public function eliminar()
	{
		$id_bus = $this->input->post('id_bus');
		echo $this->modelo_buses->eliminar_bus($id_bus ? $id_bus : 0);
	}
	// aqui viene los formularios de registro,editar,clonar
	public function registro_datos()
	{
		// var_dump($this->input->post());exit;
		// 
		$data['bus']['id_pagina'] = $this->input->post('id_pagina');
		$data['bus']['id_codigo_bus'] = $this->input->post('id_codigo_bus');
		$data['bus']['id_empresa'] = $this->input->post('empresa_transporte');

		$data['bus']['titulo_bus'] = $this->input->post('titulo_bus');
		$data['bus']['subtitulo_bus'] = $this->input->post('subtitulo_bus');
		$data['bus']['estado_bus'] = $this->input->post('estado_bus');
		$data['bus']['politicas_bus'] = $this->input->post('tipopolitica') ? $this->input->post('politicas_reserva') : null;
		$data['bus']['hora_anticipacion'] = $this->input->post('anticipacion_reserva');
		$data['bus']['tasas_impuestos'] = $this->input->post('tasas_impuestos');
		$data['bus']['pago_minimo'] = $this->input->post('pago_minimo');
		$data['bus']['requerir_disponibilidad'] = !empty($this->input->post('chckbxRequirirDisponibilidad')) ? 1 : 0;
		$data['bus']['origen_bus'] = $this->input->post('origen_bus');
		$data['bus']['destino_bus'] = $this->input->post('destino_bus');
		$data['bus']['lugar_partida'] = $this->input->post('lugar_partida');
		$data['bus']['lugar_llegada'] = $this->input->post('lugar_llegada');

		$subOpcionRecojo = @$this->input->post('tiporecojoA') ? @$this->input->post('tiporecojoA') : @$this->input->post('tiporecojoB');


		$data['bus']['recojo_opcion'] = $this->input->post('tiporecojo');
		$data['bus']['recojo_subopcion'] = $subOpcionRecojo;
		$data['bus']['recojo_inicio_servicio'] = $this->input->post('txt_lugar_encuentro');
		$data['bus']['recojo_fin_servicio'] = $this->input->post('txt_lugar_finalizacion');
		$data['bus']['tipo_guia'] = @$this->input->post("tipoguia") ? $this->input->post("tipoguia") : 3;

		// tabs 
		$data['tab']['descripcion_tab'] = $this->input->post('descripcion_bus');
		$data['tab']['itinerario_tab'] = $this->input->post('itinerario_bus');
		$data['tab']['incluye_tab'] = $this->input->post('incluye_bus');
		$data['tab']['informacion_tab'] = $this->input->post('info_adicional_bus');
		$data['tab']['recomendacion_tab'] = $this->input->post('recomendaciones_bus');


		// horarios
		$data['horarios']['hora_partida'] = $this->input->post('hora_salida');
		$data['horarios']['id_servicio'] = $this->input->post('servicio_bus');
		$data['horarios']['zona_horaria'] = $this->input->post('zona_horaria');
		$data['horarios']['duracion'] = $this->input->post('duracion_viaje');
		$data['horarios']['precio_persona'] = $this->input->post('precio_viaje');

		// tab adionales
		$data['tab_adicional']['nombre'] = $this->input->post('addedTabs_nombre');
		$data['tab_adicional']['icono'] = $this->input->post('addedTabs_icono');
		$data['tab_adicional']['contenido'] = $this->input->post('addedTabs_contenido');

		// galeria solo contiene las id en un array

		$data['galeria'] = $this->input->post('sliderGaleria');
		$data['servicio_adicional'] = $this->input->post('servicios_adicionales');
		// $data['paradas'] = $this->input->post('paradas_bus');

		$dataExtra['disponibilidad'] = $this->input->post('txt_data_json_disponibilidad');
		$dataExtra['bloqueos'] = $this->input->post('txt_data_json_bloqueo');
		$dataExtra['ofertas'] = $this->input->post('txt_data_json_oferta');

		$dataExtra['lugares'] = $this->input->post('map_prod');
		$dataExtra['formularios'] = $this->input->post('chckbxDatosPersonales');
		$dataExtra["guias"] = !empty($this->input->post('slct_guias_seleccionados')) ? $this->input->post('slct_guias_seleccionados') : [];

		$idBus = 0;
		// si id_bus es igual a 0 se crea nuevo bus de lo contrario se edita
		if (+$this->input->post('id_bus')) {
			$detalles_bus = $this->modelo_buses->editar_bus($data, $this->input->post('id_bus'));
			$idBus = $detalles_bus['id_bus'];
			$codigo_bus = $detalles_bus['id_codigo_bus'];
		} else {
			$detalles_bus = $this->modelo_buses->registrar_bus($data);
			$idBus = $detalles_bus['id_bus'];
			$codigo_bus = $detalles_bus['id_codigo_bus'];
			//echo $idBus;
		}
		$this->Disponibilidad_model->operarDisponibilidadBus($idBus, $dataExtra['disponibilidad']);
		$this->Bloqueo_model->operarBloqueoBus($idBus, $dataExtra['bloqueos']);
		$this->Oferta_model->operarOfertaBus($idBus, $dataExtra['ofertas']);
		$this->Lugar_has_bus_model->add_lugar_has_bus($idBus, $dataExtra['lugares']);
		$this->Formulario_model->operarFormularios($idBus, $dataExtra['formularios']);
		$this->Guia_model->operarGuias($idBus, $dataExtra['guias']);
		// echo $idBus;
		redirect(base_url('buses/unidad/buses_relacionados/' . $codigo_bus));
		//echo "<br/><br/>";
		//echo json_encode( json_decode($dataExtra['disponibilidad']),true ) ."<br/>";
		//echo json_encode( json_decode($dataExtra['bloqueos']),true )."<br/>";
		//echo json_encode( json_decode($dataExtra['ofertas']),true )."<br/>";
	}
	//// ver bus en sus idiomas respectivos segun id_codigo_bus
	public function buses_relacionados()
	{
		$id_codigo_bus = $this->uri->segment(4);
		if (!$id_codigo_bus)
			redirect(base_url('buses/unidad/'));
		//$pagina_web = $this->modelo_buses->buscar_pagina($id_pagina);
		//if(!count($pagina_web))redirect(base_url('buses/unidad/'));
		$data['buses_relacionados'] = $this->modelo_buses->retorna_buses_codigo($id_codigo_bus);
		if (!count($data['buses_relacionados']))
			redirect(base_url('buses/unidad/'));

		$this->load->view('buses/bus/lista_buses_codigo', $data);
		//echo $id_codigo_bus;

	}
}