<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suscripcion extends CI_Controller {
    protected $var_language = null;

    public function __construct() {
      parent::__construct();
      $this->load->model("admin/idioma_model");
      $this->load->model("admin/suscripcion_model");
      $this->load->model("admin/destinos_model");
      $this->load->model("admin/suscripcion_has_destino_model");
      
      $this->var_language = $this->uri->segment(1);
      if( $this->config->item('php-quick-profiler') ){
            $this->output->enable_profiler(FALSE);          
      }
   }

  public function index(){
    $data = array();
    // echo "funciono";
    // echo json_encode($this->suscripcion_model->get_all_suscripciones());
    $data['all_suscripciones']  = $this->suscripcion_model->get_all_suscripciones();
    // echo json_encode($data['destinos']);
    $this->load->view('admin/suscripcion',$data);

  }
  /*
     * Adding a new categoria
     */
  public  function add()
    {   

         $datos_de_suscripciones=$this->input->post('datos_de_suscripcion');
         $params_suscripcion=array();
         $params_suscripcion = array(
              'nombre_suscripcion' => $datos_de_suscripciones['nombre'],
              'email_suscripcion' => $datos_de_suscripciones['email'],
            );
        $suscripcion_id = $this->suscripcion_model->add_suscripcion($params_suscripcion);
         
        foreach ($datos_de_suscripciones['destinos'] as $key => $value) {
            $params_suscripcion_has_destino=array(
                'id_suscripcion'=>$suscripcion_id,
                'id_destino'=>$value['destino'],
                'duracion_viaje'=>$value['duracion_viaje'],
                'fecha_viaje'=>$value['fecha_viaje'],
            );
            $suscripcion_has_destino_id = $this->suscripcion_has_destino_model->add_suscripcion_has_destino($params_suscripcion_has_destino);
         }
        echo json_encode('success');
    } 
  public function state_suscripcion(){
    $result=0;
    $state=$this->suscripcion_model->get_state_suscripcion($this->input->post('email'));
    if (!empty($state)) {
      $result=1;
    }
    echo json_encode($result);
  }
  public function get_suscripcion(){
    $data=array();
    $id_suscripcion=$this->input->post('id');
    $data['suscripcion']=$this->suscripcion_model->get_suscripcion($id_suscripcion);
    $data_temp_destino_footer=$this->destinos_model->get_all_destinos();


    $temp_all_idiomas=$this->idioma_model->get_all_idiomas();
    foreach ($temp_all_idiomas as $key => $value) {
      $all_idiomas[$value['id_idioma']]= array(
        'id_idioma' =>$value['id_idioma'],
        'pais' =>$value['pais'],
        'codigo' =>$value['codigo'],
        'id_usuarios' =>$value['id_usuarios'],
      );
    }
    $data['all_idiomas']=$all_idiomas;

    $temp_suscripcion_detalle=$this->suscripcion_has_destino_model->get_all_suscripcion_has_destinos($id_suscripcion);
    foreach ($data_temp_destino_footer as $key => $value) {
      $temp_destino_footer[$value['id_destino']]=array(
        'id_destino' =>$value['id_destino'],
        'nombre_destino' =>$value['nombre_destino'],
        'uri_destino' =>$value['uri_destino'],
        'descripcion_destino' =>$value['descripcion_destino'],
        'id_idioma' =>$value['id_idioma'],
       );
    }
    $data['destinos_footer']=$temp_destino_footer;
    $data['suscripcion_detalle']=$temp_suscripcion_detalle;
    echo json_encode($data);
  }
  public function delete_suscripcion(){
      $id_suscripcion=$this->input->post('id_suscripcion');
      $temp_suscripcion_detalle=$this->suscripcion_model->delete_suscripcion($id_suscripcion);
      if ($temp_suscripcion_detalle) {
			echo json_encode('success');
		}
  }

}
