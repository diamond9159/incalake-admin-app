<?php
class Reservas extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/idioma_model');
        $this->load->model('admin/reservas_model');
    } 

    function index(){
        //$data['idiomas'] = $this->idioma_model->get_all_idiomas();
        $data['reservas'] = $this->reservas_model->get_reservas();
        $this->load->view('admin/reservas',$data);
    }

   	function detallereserva(){
   		$idReserva = $this->input->post('id');
   		$data = $this->reservas_model->get_detalleReserva(trim($idReserva));	
   		echo json_encode($data);
       }
       
    public function datos_pasajeros(){
       // echo $this->uri->segment(4);
       if(is_numeric($this->uri->segment(4))){
        $datos['pasajeros'] = $this->reservas_model->lista_pasajeros($this->uri->segment(4));	
        $this->load->view('admin/reservas/datos_pasajeros',$datos);
       } else redirect(base_url());
        
    }
    /* metodo para almacenar cuota de cancelacion */
    public function guardar_cuota(){
        // echo $this->uri->segment(4);
        echo $this->reservas_model->guardar_cuota($_POST);
        // var_dump($_POST);
     }
     public function editar_comentario_reserva(){

      $idreserva= $_POST['idreserva'];
      $comentario = array('comentario' =>$_POST['comentario']);
      $data=$this->reservas_model->update_reservas($idreserva,$comentario);
      echo json_encode($data);
     }
     public function analytics($fecha_ini,$fecha_fin){
      $result=$this->reservas_model->obtenerReservaPagadosBetween($fecha_ini,$fecha_fin);
      
      $pagados=0;
      $temp_fecha=0;
      $contador_pagados=0;
      $contador_en_espera=0;
      $array_pagados=array();
      $array_en_espera=array();
      $array_dias_fecha=array();
      for($i=strtotime($fecha_ini); $i<=strtotime($fecha_fin); $i+=86400){
        $fecha_temp_array=date("Y-m-d", $i);
        // echo $fecha_temp_array;
            $array_dias_fecha[]=$fecha_temp_array;
             $array_pagados[$fecha_temp_array]=0;
             $array_en_espera[$fecha_temp_array]=0;
        }

      foreach ($result as $key => $value) {
        $time = strtotime($value['fecha_creacion_reserva']);
        $newformat = date('Y-m-d',$time);


        if ($temp_fecha==0) {
          if ((int)$value['confirmacion_pago']>0) {
            $contador_pagados++;
            $array_pagados[$newformat]= $contador_pagados;
          }else{
            $contador_en_espera++;
            $array_en_espera[$newformat]= $contador_en_espera;
          }
        }else if ($temp_fecha==$newformat) {
          if ((int)$value['confirmacion_pago']>0) {
            $contador_pagados++;
            $array_pagados[$newformat]= $contador_pagados;
          }else{
            $contador_en_espera++;
            $array_en_espera[$newformat]= $contador_en_espera;
          }
          
        } else {
          $contador_pagados=0;
          $contador_en_espera=0;
          if ((int)$value['confirmacion_pago']>0) {
            $contador_pagados++;
            $array_pagados[$newformat]= $contador_pagados;
          }else{
            $contador_en_espera++;
            $array_en_espera[$newformat]= $contador_en_espera;
          }
        }

        $temp_fecha=str_replace("-", "", $newformat);
        $temp_fecha=$newformat;
             
        
// 2003-10-16
      }
      $reservas_pagados=array();
      $reservas_en_espera=array();
      $pagados=0;
      $en_espera=0;
      foreach ($array_pagados as $key => $value) {
        $reservas_pagados[]=$value;
        $pagados+=$value;
      }
      foreach ($array_en_espera as $key => $value) {
        $reservas_en_espera[]=$value;
        $en_espera+=$value;
      }
      // $dStart = new DateTime($fecha_ini);

   // $dEnd  = new DateTime($fecha_fin);
   // $dDiff = $dStart->diff($dEnd);
   // echo ($dDiff->days)+1;

      $data['fecha_ini']=$fecha_ini;
      $data['fecha_fin']=$fecha_fin;
      $data['data_pagados']=$reservas_pagados;
      $data['data_en_espera']=$reservas_en_espera;
      $data['data_dias']=$array_dias_fecha;
      $data['total_pagados']=$pagados;
      $data['total_en_espera']=$en_espera;
      // $data['all_reservas']=count($result);
      // var_dump($result);
      $this->load->view('admin/reservas-analytics',$data);
     }
     
     function remove(){
        $data = [];
        $idReserva = $this->input->post('id');
        $response = $this->reservas_model->delete_reservas($idReserva);
        if($response){
            $data['response'] = "success";
        }else{
            $data['response'] = "error";
        }
        echo json_encode($data);
     }
}