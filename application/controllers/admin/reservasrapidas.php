<?php
class Reservasrapidas extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/idioma_model');
        $this->load->model('admin/reservas_model');
        $this->load->model('admin/reservasrapidas_model');
    } 

    function index(){
        //$data['idiomas'] = $this->idioma_model->get_all_idiomas();
        //$data['reservas'] = $this->reservas_model->get_reservas();
        //$this->load->view('admin/reservas',$data);

        echo "Reservas rápidas";
    }

    function add(){
      $data['data'] = [];
      $this->load->view("admin/reservas-rapidas-add",$data); 
    }

    //Registra nueva venta directa 
    function register(){
      $dataCliente = json_decode( $this->input->post('dataCliente'), true );
      $dataVenta   = json_decode( $this->input->post('dataVenta'), true );
      $dataExtra   = json_decode( $this->input->post('dataExtra'), true );

      $cantidad_reserva = $this->reservasrapidas_model->get_cantidadReserva();

      $paramsReserva = array(
        'fecha_creacion_reserva' => date('Y-m-d H:i:s'),
        'codigo_reserva'         => date('dmY').'-'.str_pad((@$cantidad_reserva+1), 2, "0", STR_PAD_LEFT),
        'nombres_cliente'        => @$dataCliente['nombres'],
        'apellidos_cliente'      => @$dataCliente['apellidos'],
        'email_cliente'          => @$dataCliente['email'],
        'telefono_cliente'       => $dataCliente['telefono']?@$dataCliente['telefono']:'',
        'nacionalidad_cliente'   => $dataCliente['nacionalidad']?@$dataCliente['nacionalidad']:'',
        'confirmacion_pago'      => '0',
        'lang'                   => mb_strtolower(@$dataExtra['idioma']),
        'metodo_pago'            => mb_strtolower(@$dataExtra['metodo_pago']),
        'tasas_impuestos'        => @$dataExtra['tasasImpuestos']['montoTasasImpuestos'],//Monto en efectivo, Ej.$7
        'cupon_descuento'        => @$dataExtra['descuentoGeneral']['cantidadDescuentoGeneral'],//cantidad, Ej. 7%
        'monto_cupon_descuento'  => @$dataExtra['descuentoGeneral']['montoDescuentoGeneral'],//Monto en efectivo, Ej.$3                 
        
        'venta_directa'          => '1', // 1 = Es una venta directa, 0 = Es una venta desde la página web
        'monto_total'            => @$dataExtra['precioTotal'],
      );
      $id_reserva =  $this->reservasrapidas_model->add_reserva($paramsReserva);
      //$id_reserva = rand(100,999);
      $uriVenta = $this->generarUri(mb_strtolower(@$dataExtra['idioma']),@$id_reserva);

      foreach ($dataVenta as $key => $value) {
        $paramsVenta = array(
          'id_producto'    => null,
          'fecha_servicio' => date_format(date_create(@$value['fecha']),'Y-m-d'),
          'cantidad'       => @$value['cantidad'],
          'precio_total'   => @(Double)$value['cantidad'] * @(Double)$value['precioUnitario'],
          'descuento'      => @$value['descuento']['montoDescuento'],
          'tasas_impuestos'=> @$dataExtra['tasasImpuestos']['cantidadTasasImpuestos'],
          'importe_tasas_impuestos' => @$dataExtra['tasasImpuestos']['montoTasasImpuestos'],
          'duracion_servicio' =>  @$value['horaInicio'], // Aquí va la hora de inicio del servicio, hubo una equivocacion des inserseción de datos desde el inicio; duracion_servicio va el el campo hora_inicio_servicio

          'uri_venta_servicio'      => $uriVenta,
          'descripcion_servicio'    => @$value['titulo'],
          'detalle_servicio'        => @$value['descripcion'],
        );   
        
        $id_detalle_servicio = $this->reservasrapidas_model->add_detalle_servicio($paramsVenta);   
        
        $arrayReservaHasDetalleServicio = array(
          'id_detalle_servicio' => @$id_detalle_servicio,
          'id_reserva'          => @$id_reserva,
        );
        $id_reserva_has_detalle_servicio = $this->reservasrapidas_model->add_reserva_has_detalle_reserva($arrayReservaHasDetalleServicio);

        $arrayDetalleServicioResumen = array(
          'cantidad'            => @$value['cantidad'],
          'precio'              => @(Double)$value['cantidad'] * @(Double)$value['precioUnitario'],
          'nombre_articulo'     => 'Adulto',
          'tipo_articulo'       => 'persona',
          'id_detalle_servicio' => @$id_detalle_servicio,
        );  
        $id_detalle_servicio_resumen = $this->reservasrapidas_model->add_resumen($arrayDetalleServicioResumen);
      }
      $arrayCoutas = array(
        'monto'             => @$dataExtra['precioTotalCouta'],
        'porcentaje'        => @$dataExtra['coutaPorcentaje'],
        'fecha_cuota'       => date('Y-m-d H:i:s'),
        'tipo_cuota'        => mb_strtolower('TARJETA'),
        'detalle_cuota'     => 'Venta directa através del generador de Pagos', 
        'confirmacion_pago' => '0', 
        //'fecha_confirmacion_pago' => '', 
        'id_reserva'        => @$id_reserva,  
      );
      $id_coutas = $this->reservasrapidas_model->add_coutas($arrayCoutas);
      
      $data['response'] = "success";
      $data['message']  = "Información guardado con éxito..!";
      $data['uri']      = $uriVenta;
      
      //$data['url']      = "https://shop.incalake.com/checkout/payments/confirm/".$uriVenta;
      //$data['url']      = "http://localhost/payments/cart/order/".trim($uriVenta);
      $data['url']      = "https://shop.incalake.com/checkout/payments/order/".$uriVenta;
      $data['cliente']  = $dataCliente;
      $data['extra']    = $dataExtra; 
      echo json_encode($data);
    }

   	function detallereserva(){
   		$idReserva = $this->input->post('id');
   		$data = $this->reservas_model->get_detalleReserva(trim($idReserva));	
   		echo json_encode($data);
   	}

    function generarUri( $lang = 'en', $idReserva = 0 ){
      return md5( mb_strtolower($lang).mb_strtolower("incalake").$idReserva )."~".$idReserva; 
      // La desincriptación se debe hacer concadenando los siguientes valores: idioma + "incalake"+ idReserva + "~"+idReservar
    }

    // Retorna todos los servicios existentes en la base de datos
    function dataservicios(){
      $data = [];
      $response = $this->reservasrapidas_model->get_servicios();
      $data = $response;
      echo json_encode($data);
    }
    function ventadirecta(){
      $dataCliente = json_decode( $this->input->post('dataCliente'), true );
      $dataVenta   = json_decode( $this->input->post('dataVenta'), true );
      $dataExtra   = json_decode( $this->input->post('dataExtra'), true );

      $cantidad_reserva = $this->reservasrapidas_model->get_cantidadReserva();

      $paramsReserva = array(
        'fecha_creacion_reserva' => date('Y-m-d H:i:s'),
        'codigo_reserva'         => date('dmY').'-'.str_pad((@$cantidad_reserva+1), 2, "0", STR_PAD_LEFT),
        'nombres_cliente'        => @$dataCliente['nombres'],
        'apellidos_cliente'      => @$dataCliente['apellidos'],
        'email_cliente'          => @$dataCliente['email'],
        'telefono_cliente'       => $dataCliente['telefono']?@$dataCliente['telefono']:'',
        'nacionalidad_cliente'   => $dataCliente['nacionalidad']?@$dataCliente['nacionalidad']:'',
        'confirmacion_pago'      => '1',
        'lang'                   => mb_strtolower(@$dataExtra['idioma']),
        'metodo_pago'            => mb_strtolower('CULQI'),
        'tasas_impuestos'        => @$dataExtra['tasasImpuestos']['montoTasasImpuestos'],//Monto en efectivo, Ej.$7
        'cupon_descuento'        => @$dataExtra['descuentoGeneral']['cantidadDescuentoGeneral'],//cantidad, Ej. 7%
        'monto_cupon_descuento'  => @$dataExtra['descuentoGeneral']['montoDescuentoGeneral'],//Monto en efectivo, Ej.$3                 
        
        'venta_directa'          => '1', // 1 = Es una venta directa, 0 = Es una venta desde la página web
        'monto_total'            => @$dataExtra['precioTotal'],
      );
      $id_reserva =  $this->reservasrapidas_model->add_reserva($paramsReserva);
      //$id_reserva = rand(100,999);
      $uriVenta = $this->generarUri(mb_strtolower(@$dataExtra['idioma']),@$id_reserva);

      foreach ($dataVenta as $key => $value) {
        $paramsVenta = array(
          'id_producto'    => null,
          'fecha_servicio' => date_format(date_create(@$value['fecha']),'Y-m-d'),
          'cantidad'       => @$value['cantidad'],
          'precio_total'   => @(Double)$value['cantidad'] * @(Double)$value['precioUnitario'],
          'descuento'      => @$value['descuento']['montoDescuento'],
          'tasas_impuestos'=> @$dataExtra['tasasImpuestos']['cantidadTasasImpuestos'],
          'importe_tasas_impuestos' => @$dataExtra['tasasImpuestos']['montoTasasImpuestos'],
          
          'uri_venta_servicio'      => $uriVenta,
          'descripcion_servicio'    => @$value['titulo'],
          'detalle_servicio'        => @$value['descripcion'],
        );   
        
        $id_detalle_servicio = $this->reservasrapidas_model->add_detalle_servicio($paramsVenta);   
        
        $arrayReservaHasDetalleServicio = array(
          'id_detalle_servicio' => @$id_detalle_servicio,
          'id_reserva'          => @$id_reserva,
        );
        $id_reserva_has_detalle_servicio = $this->reservasrapidas_model->add_reserva_has_detalle_reserva($arrayReservaHasDetalleServicio);

        $arrayDetalleServicioResumen = array(
          'cantidad'            => @$value['cantidad'],
          'precio'              => @(Double)$value['cantidad'] * @(Double)$value['precioUnitario'],
          'nombre_articulo'     => 'Adulto',
          'tipo_articulo'       => 'persona',
          'id_detalle_servicio' => @$id_detalle_servicio,
        );  
        $id_detalle_servicio_resumen = $this->reservasrapidas_model->add_resumen($arrayDetalleServicioResumen);
      }
      $arrayCoutas = array(
        'monto'             => @$dataExtra['precioTotalCouta'],
        'porcentaje'        => @$dataExtra['coutaPorcentaje'],
        'fecha_cuota'       => date('Y-m-d H:i:s'),
        'tipo_cuota'        => mb_strtolower('VENTA_DIRECTA'),
        'detalle_cuota'     => 'Venta directa através del generador de Pagos', 
        'confirmacion_pago' => '1', 
        'fecha_confirmacion_pago' => date('Y-m-d h:i:s'), 
        'id_reserva'        => @$id_reserva,  
      );
      $id_coutas = $this->reservasrapidas_model->add_coutas($arrayCoutas);
      
      $data['response'] = "success";
      $data['message']  = "Información guardado con éxito..!";
      $data['uri']      = $uriVenta;
      
      //$data['url']      = "https://shop.incalake.com/checkout/payments/confirm/".$uriVenta;
      //$data['url']      = "http://localhost/payments/cart/order/".trim($uriVenta);
      //$data['url']      = "http://localhost/checkout/payments/order/".trim($uriVenta);
      $data['url']      = "";
      $data['cliente']  = $dataCliente;
      $data['extra']    = $dataExtra; 
      $data['message_venta_directa'] = "";

      echo json_encode($data);
    }
}



