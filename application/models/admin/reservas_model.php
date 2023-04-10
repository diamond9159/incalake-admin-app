<?php


class Reservas_model extends CI_Model{
    function __construct(){
        parent::__construct();
    } 

    function get_reserva($id_reserva){
        $reservas = $this->db->query("SELECT * FROM reservas WHERE id_reservas = ? ;",array($id_reserva))->row_array();
        return $reservas;
    }

    function get_all_reservas(){
        $reservas = $this->db->query("SELECT * FROM reservas WHERE 1 = 1 ;")->result_array();
        return $reservas;
    }

    function add_reservas($params){
        $this->db->insert('reservas',$params);
        return $this->db->insert_id();
    }
    
    function update_reservas($id_reserva,$params){
        $this->db->where('id_reserva',$id_reserva);
        $response = $this->db->update('reserva',$params);
        if($response){
            return "reservas updated successfully";
        }else{
            return "Error occuring while updating reservas";
        }
    }
    function delete_reservas($id_reserva){
        $response = $this->db->delete('reserva',array('id_reserva'=>$id_reserva));
        if($response){
            return true;
        } else {
            return false;
        }
    }


    /****************************************************************************/
    /* Obtine todas las reservas para mostrar en la vista admin.incalake.com/admin/reservas/ */
    function get_reservas(){
         $reservas = $this->db->query("SELECT * FROM reserva ORDER BY id_reserva DESC;")->result_array();

        foreach($reservas as $key => $value){
             $reservas[$key]['pocentaje_pago'] = $this->devolver_porcentaje($value['id_reserva'])['porcentaje'];
        }

        return $reservas;
    }
    /* funcion para devolver porcentaje de adelanto de reserva */
    private function devolver_porcentaje($id_reserva){
            $total = $this->db->query("SELECT SUM(porcentaje) AS porcentaje, SUM(monto) AS monto,GROUP_CONCAT(' ',detalle_cuota) AS detalles,GROUP_CONCAT(' ',fecha_cuota) AS fecha_cuotas FROM cuotas WHERE cuotas.id_reserva = $id_reserva")->row_array();

            // foreach
            // if($ev)echo json_encode($total);
            return $total;
    }
    /* fin de la funcion para devolver la reserva */
    function get_detalleReserva($idReserva){
		$data = [];
		//$reserva =  $this->db->query("SELECT * FROM reserva WHERE id_reserva = '".trim($idReserva)."';")->row_array();
		$reserva =  $this->db->query("SELECT r.*,c.confirmacion_pago AS coutas_confirmacion_pago FROM reserva AS r JOIN cuotas AS c ON c.id_reserva = r.id_reserva AND r.id_reserva = '".trim($idReserva)."';")->row_array();    	
		if ( !empty($reserva) ) {
            $total_acumulado = $this->devolver_porcentaje(@$reserva['id_reserva']);// total de porcentaje de adelanto y monto
			$data[] = array(
				'id_reserva' 		=> @$reserva['id_reserva'],
				'fecha_compra' 		=> date_format( date_create(@$reserva['fecha_creacion_reserva']),'d-M-Y'),
				'codigo_reserva'	=> @$reserva['codigo_reserva'],
				'nombres_cliente' 	=> mb_strtoupper(trim(@$reserva['nombres_cliente'])." ".trim(@$reserva['apellidos_cliente']) ),
				'email'				=> @$reserva['email_cliente'],
				'telefono'			=> @$reserva['telefono_cliente'],
				'pagado'			=> @$reserva['confirmacion_pago'],
				'texto_pagado'		=> (@$reserva['confirmacion_pago']==1 || @$reserva['coutas_confirmacion_pago'] == 1 ?'<span class="label label-'.($total_acumulado['porcentaje']<100?'warning':'success').'">PAGADO</span>':'<span class="label label-danger">EN PROCESO DE PAGO</span>'),
				'metodo_pago'       => @$reserva['metodo_pago'],
				'tasas_impuestos'   => @$reserva['tasas_impuestos'],
                'detalle_servicio' 	=> $this->detalleServicio($idReserva),
                'porcentaje_pago' 	=> +$total_acumulado['porcentaje'],
                'monto_adelanto' 	=> +$total_acumulado['monto'],
                'detalle_cuota' 	=> $total_acumulado['detalles'],
                'fecha_cuotas'  	=> $total_acumulado['fecha_cuotas'],
                'comentario'      => @$reserva['comentario'],

			);
		}
		return $data;
    }

    function detalleServicio($idReserva){
    	$data = [];
    	$detalleServicio = $this->db->query("SELECT i.codigo,i.pais, p.id_producto,p.titulo_producto, ds.* FROM detalle_servicio_has_reserva AS dshr JOIN detalle_servicio AS ds ON ds.id_detalle_servicio = dshr.id_detalle_servicio AND dshr.id_reserva = '".trim($idReserva)."' LEFT JOIN producto AS p ON p.id_producto = ds.id_producto LEFT JOIN servicio AS s ON p.id_servicio = s.id_servicio LEFT JOIN idioma AS i ON s.idioma_id_idioma = i.id_idioma;")->result_array();
    	if ( !empty($detalleServicio) ) {
    		foreach ($detalleServicio as $key => $value) {
    			$data[] = array(
    				//'detalle_servicio' => $value,
    				'id_detalle_servicio'=> $value['id_detalle_servicio'],
    				'idioma' 			=> $value['codigo'],
    				'pais'				=> $value['pais'],
    				'id_producto'		=> $value['id_producto'],
    				'titulo_producto'	=> ($value['titulo_producto']?$value['titulo_producto']:$value['descripcion_servicio']),
    				'fecha_servicio'	=> date_format( date_create($value['fecha_servicio']),'d-M-Y'),
    				'hora_inicio_servicio'=> $value['duracion_servicio'], //Equivocación en el almacenamiento 
    				'duracion_servicio' => $value['hora_inicio_servicio'], //Equivocación en el almacenamiento
    				'cantidad'			=> $value['cantidad'],
    				'precio_total'		=> number_format($value['precio_total'],2,'.',' '),
    				'descuento'			=> $value['descuento'],
    				'tasas_impuestos'	=> $value['tasas_impuestos'],
    				'importe_tasas_impuestos'=> $value['importe_tasas_impuestos'],
    				'url_servicio'		=> $value['url'],
                    'resumen'			=> $this->resumenServicio($value['id_detalle_servicio']),
                    "descripcion_servicio" => $value['descripcion_servicio'],
                    //"detalle_servicio"     => $value['detalle_servicio'],
                    'email_operador'    => $this->obtenerOperador($idReserva),      
                    'operador_confirmado'=> $value['operador_confirmado'], 
                    
    			);   		
    		}    		
    	}
    	return $data;
    }

    function resumenServicio($idDetalleServicio){
    	return $this->db->query("SELECT * FROM resumen WHERE id_detalle_servicio = '".$idDetalleServicio."';")->result_array();
    }
    function get_ultimas_reservas(){
        //return $this->db->query("SELECT i.codigo, i.pais, p.id_producto, p.titulo_producto, ds.*,dshr.id_reserva,r.confirmacion_pago, r.fecha_creacion_reserva FROM detalle_servicio_has_reserva AS dshr JOIN detalle_servicio AS ds ON ds.id_detalle_servicio = dshr.id_detalle_servicio JOIN producto AS p ON p.id_producto = ds.id_producto JOIN servicio AS s ON p.id_servicio = s.id_servicio JOIN idioma AS i ON s.idioma_id_idioma = i.id_idioma AND ds.fecha_servicio >= NOW() JOIN reserva as r ON r.id_reserva = dshr.id_reserva ORDER BY ds.fecha_servicio ASC;")->result_array();

       return $this->db->query("SELECT idi.codigo, idi.pais, pro.id_producto, pro.titulo_producto, des.*,dshr.id_reserva,res.confirmacion_pago, cuo.confirmacion_pago AS coutas_confirmacion_pago, res.fecha_creacion_reserva FROM reserva AS res INNER JOIN cuotas AS cuo ON res.id_reserva = cuo.id_reserva AND cuo.confirmacion_pago = 1 OR res.confirmacion_pago = 1 JOIN detalle_servicio_has_reserva AS dshr ON res.id_reserva = dshr.id_reserva JOIN detalle_servicio AS des ON dshr.id_detalle_servicio = des.id_detalle_servicio AND des.fecha_servicio >= NOW() LEFT JOIN producto AS pro ON des.id_producto = pro.id_producto LEFT JOIN servicio AS ser ON ser.id_servicio = pro.id_servicio LEFT JOIN idioma AS idi ON idi.id_idioma = ser.idioma_id_idioma GROUP BY des.id_detalle_servicio ORDER BY des.fecha_servicio ASC;")->result_array();
    }

    /* metodo para retornar lista de los pasajeros relacionados a una reserva */
    public function lista_pasajeros($id_reserva=0){
        $results = array();
        // obtener lista de archivos desde la base de datos
        $result_clientes = $this->db->query("SELECT clientes_info.*,producto.titulo_producto FROM clientes_info INNER JOIN producto ON producto.id_producto = clientes_info.id_producto WHERE id_reserva = $id_reserva")->result_array();


        $resultados = array();
        if($result_clientes){
            foreach($result_clientes as $value){
                $result_campos = $this->db->query("SELECT cliente_has_campo.value_campo_formulario,campo_formulario.nombre_campo FROM cliente_has_campo INNER JOIN campo_formulario ON cliente_has_campo.id_campo_formulario = campo_formulario.id_campo_formulario   WHERE id_clientes_info = {$value['id']}")->result_array();
                $resultados[$value['id_producto']]['titulo_producto'] = $value['titulo_producto'];
                $resultados[$value['id_producto']]['datos_clientes'][] = $result_campos;
            }
            
            
            
        } 
        // retornar json
        return $resultados;
    }

    /* metodo para almacenar cuota de cancelacion */
    public function guardar_cuota($datos){
        $params['monto'] = $datos['monto'];
        $params['porcentaje'] = $datos['porcentaje'];
        // setear fechas 
        $this->db->set('fecha_cuota', 'NOW()', FALSE);
        $this->db->set('fecha_confirmacion_pago', 'NOW()', FALSE);
        // $params['fecha_cuota'] = $datos['porcentaje'];
        
        $params['tipo_cuota'] = 'efectivo';
        $params['detalle_cuota'] = $datos['detalles'];
        $params['confirmacion_pago'] = 1;
        $params['id_reserva'] = $datos['id_reserva'];

        $this->db->insert('cuotas',$params);
        return $this->db->insert_id();
     //var_dump($params);
    }

    public function obtenerOperador($idReserva){
        $email = null;
        $response = $this->db->query("SELECT r.id_reserva, p.id_producto,p.titulo_producto,o.email_operador,o.activo FROM reserva AS r JOIN detalle_servicio_has_reserva AS dshr ON r.id_reserva = dshr.id_reserva AND r.id_reserva = ? JOIN detalle_servicio AS ds ON dshr.id_detalle_servicio = ds.id_detalle_servicio LEFT JOIN producto AS p ON p.id_producto = ds.id_producto LEFT JOIN operador AS o ON o.id_producto = p.id_producto;",array($idReserva))->row_array();
        if ( !empty($response) ) {
            if ($response['activo']) {
                $email = $response['email_operador'];
            }
        }
        return $email;
    }
    public function obtenerReservaPagadosBetween($fecha_ini,$fecha_fin){
        $data=null;

        $response=$this->db->query("SELECT * FROM reserva WHERE  fecha_creacion_reserva BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY id_reserva ASC; ")->result_array();
        // optimizado pero no implementado en el controlador
         // $response=$this->db->query("SELECT date(r.fecha_creacion_reserva) as fecha, count(r.id_reserva) as cantidad, c.confirmacion_pago FROM reserva as r JOIN cuotas as c on r.id_reserva=c.id_reserva and c.confirmacion_pago=1 and  r.fecha_creacion_reserva BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' group by date(r.fecha_creacion_reserva); ")->result_array();
         // var_dump($response);
        if (!empty($response)) {
           $data=$response;
        }
        return $data;
    }

}
