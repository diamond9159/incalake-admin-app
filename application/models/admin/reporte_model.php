<?php

class Reporte_model extends CI_Model{
    function __construct(){
        parent::__construct();
        //$this->load->model('admin/idioma_model');
        //$this->load->model('admin/disponibilidad_model');
    }

    function  get_servicios( $fechaInicio, $fechaFin ){
    	$serviciosIdProducto 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_producto) AS cantidad_servicio, UPPER(prod.titulo_producto) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NOT NULL AND dese.fecha_servicio BETWEEN ? AND ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio LEFT JOIN producto AS prod ON prod.id_producto = dese.id_producto GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($fechaInicio,$fechaFin) )->result_array();

    	$serviciosVentaDirecta 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_detalle_servicio) AS cantidad_servicio, UPPER(dese.descripcion_servicio) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NULL AND dese.fecha_servicio BETWEEN ? AND ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($fechaInicio,$fechaFin) )->result_array();

    	return array_merge($serviciosIdProducto, $serviciosVentaDirecta);

    }
	//Mes actual, mes anterior, ltimos treinta dias.
    function  get_serviciosMes( $option = 0, $fechaInicio, $fechaFin ){
    	$mes = date('m');
    	$serviciosIdProducto 	= [];
    	$serviciosVentaDirecta 	= [];
    	switch ((Integer)$option) {
    		case 0: //Mes Actual
                $serviciosIdProducto    = $this->db->query("SELECT dese.id_producto, COUNT(dese.id_producto) AS cantidad_servicio, UPPER(prod.titulo_producto) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NOT NULL AND dese.fecha_servicio BETWEEN ? AND ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio LEFT JOIN producto AS prod ON prod.id_producto = dese.id_producto GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($fechaInicio,$fechaFin) )->result_array();

                $serviciosVentaDirecta  = $this->db->query("SELECT dese.id_producto, COUNT(dese.id_detalle_servicio) AS cantidad_servicio, UPPER(dese.descripcion_servicio) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NULL AND dese.fecha_servicio BETWEEN ? AND ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($fechaInicio,$fechaFin) )->result_array();
    		break;
			case 1: //Mes Anterior
    			$serviciosIdProducto 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_producto) AS cantidad_servicio, UPPER(prod.titulo_producto) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = ? AND dese.id_producto IS NOT NULL AND MONTH(dese.fecha_servicio) = 1 JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio LEFT JOIN producto AS prod ON prod.id_producto = dese.id_producto GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array( $mes-1 ) )->result_array();

		    	$serviciosVentaDirecta 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_detalle_servicio) AS cantidad_servicio, UPPER(dese.descripcion_servicio) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NULL AND MONTH(dese.fecha_servicio) = ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($mes-1) )->result_array();
    		break;
    		case 2: //Ultimos 30 días
		    	$serviciosIdProducto 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_producto) AS cantidad_servicio, UPPER(prod.titulo_producto) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NOT NULL AND dese.fecha_servicio BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE() JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio LEFT JOIN producto AS prod ON prod.id_producto = dese.id_producto GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;" )->result_array();

		    	$serviciosVentaDirecta 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_detalle_servicio) AS cantidad_servicio, UPPER(dese.descripcion_servicio) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NULL AND dese.fecha_servicio BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE() JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;" )->result_array();
    		break;
    		case 3: // Mes Actual
		    	$serviciosIdProducto 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_producto) AS cantidad_servicio, UPPER(prod.titulo_producto) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = ? AND dese.id_producto IS NOT NULL AND MONTH(dese.fecha_servicio) = 1 JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio LEFT JOIN producto AS prod ON prod.id_producto = dese.id_producto GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array( $mes ) )->result_array();

		    	$serviciosVentaDirecta 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_detalle_servicio) AS cantidad_servicio, UPPER(dese.descripcion_servicio) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NULL AND MONTH(dese.fecha_servicio) = ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($mes) )->result_array();
    		break;
    		case 4: // Rango Fecha
		    	$serviciosIdProducto 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_producto) AS cantidad_servicio, UPPER(prod.titulo_producto) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NOT NULL AND dese.fecha_servicio BETWEEN ? AND ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio LEFT JOIN producto AS prod ON prod.id_producto = dese.id_producto GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($fechaInicio,$fechaFin) )->result_array();

    			$serviciosVentaDirecta 	= $this->db->query("SELECT dese.id_producto, COUNT(dese.id_detalle_servicio) AS cantidad_servicio, UPPER(dese.descripcion_servicio) AS nombre_servicio, SUM(resu.cantidad) AS cantidad_clientes,SUM(dese.precio_total + dese.importe_tasas_impuestos - dese.descuento) AS precio_total FROM reserva AS rese JOIN cuotas AS cuot ON rese.id_reserva = cuot.id_reserva JOIN detalle_servicio_has_reserva AS dshr ON rese.id_reserva = dshr.id_reserva JOIN detalle_servicio AS dese ON dshr.id_detalle_servicio = dese.id_detalle_servicio AND cuot.confirmacion_pago = 1 AND dese.id_producto IS NULL AND dese.fecha_servicio BETWEEN ? AND ? JOIN resumen AS resu ON dese.id_detalle_servicio = resu.id_detalle_servicio GROUP BY dese.descripcion_servicio ORDER BY cantidad_servicio DESC;", array($fechaInicio,$fechaFin) )->result_array();
    		break;
    	}

    	return array_merge($serviciosIdProducto, $serviciosVentaDirecta);
    }
    function get_montoTotalCupones( $fechaInicio, $fechaFin ){
    	$response = $this->db->query("SELECT SUM(res.monto_cupon_descuento) AS monto_cupon FROM reserva AS res LEFT JOIN cuotas AS cuo ON res.id_reserva = cuo.id_reserva LEFT JOIN detalle_servicio_has_reserva AS desehre ON res.id_reserva = desehre.id_reserva LEFT JOIN detalle_servicio AS dese ON desehre.id_detalle_servicio = dese.id_detalle_servicio AND dese.fecha_servicio BETWEEN ? AND ? ;", array($fechaInicio,$fechaFin) )->row_array();
    	return $response['monto_cupon'];
    }
    function get_montoTotalCuponesMes( $option, $fechaInicio, $fechaFin ){
    	$response = null;
    	$mes = date('m');
    	$total = 0;
    	switch ( (Integer)$option ) {
    		case 0: // Todo
    			$response = null;	
    			//$response['monto_cupon'] = 0;
	    		$response = $this->db->query("SELECT SUM(res.monto_cupon_descuento) AS monto_cupon FROM reserva AS res WHERE res.id_reserva IN (SELECT res2.id_reserva FROM reserva AS res2 JOIN detalle_servicio_has_reserva AS dshr2 ON res2.id_reserva = dshr2.id_reserva JOIN detalle_servicio AS dese2 ON dese2.id_detalle_servicio = dshr2.id_detalle_servicio AND dese2.fecha_servicio BETWEEN ? AND ? JOIN cuotas AS cuo2 ON res2.id_reserva = cuo2.id_reserva AND cuo2.confirmacion_pago = 1 GROUP BY res2.id_reserva);", array($fechaInicio,$fechaFin) )->row_array();
    		break;
    		case 1: //Mes Anterior
    			$response = null;
	    		//$response['monto_cupon'] = 1;
	    		$response = $this->db->query("SELECT SUM(res.monto_cupon_descuento) AS monto_cupon FROM reserva AS res WHERE res.id_reserva IN (SELECT res2.id_reserva FROM reserva AS res2 JOIN detalle_servicio_has_reserva AS dshr2 ON res2.id_reserva = dshr2.id_reserva JOIN detalle_servicio AS dese2 ON dese2.id_detalle_servicio = dshr2.id_detalle_servicio AND MONTH(dese2.fecha_servicio) = ? JOIN cuotas AS cuo2 ON res2.id_reserva = cuo2.id_reserva AND cuo2.confirmacion_pago = 1 GROUP BY res2.id_reserva);", array($mes-1) )->row_array();
    		break;
    		case 2: // 30 Días
    			$response = null;
    			//$response['monto_cupon'] = 2;
    			$response = $this->db->query("SELECT SUM(res.monto_cupon_descuento) AS monto_cupon FROM reserva AS res WHERE res.id_reserva IN (SELECT res2.id_reserva FROM reserva AS res2 JOIN detalle_servicio_has_reserva AS dshr2 ON res2.id_reserva = dshr2.id_reserva JOIN detalle_servicio AS dese2 ON dese2.id_detalle_servicio = dshr2.id_detalle_servicio AND dese2.fecha_servicio BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE() JOIN cuotas AS cuo2 ON res2.id_reserva = cuo2.id_reserva AND cuo2.confirmacion_pago = 1 GROUP BY res2.id_reserva);" )->row_array();
    		break;
    		case 3: // Mes Actual
    			$response = null;
	    		//$response['monto_cupon'] = 3;
	    		$response = $this->db->query("SELECT SUM(res.monto_cupon_descuento) AS monto_cupon FROM reserva AS res WHERE res.id_reserva IN (SELECT res2.id_reserva FROM reserva AS res2 JOIN detalle_servicio_has_reserva AS dshr2 ON res2.id_reserva = dshr2.id_reserva JOIN detalle_servicio AS dese2 ON dese2.id_detalle_servicio = dshr2.id_detalle_servicio AND MONTH(dese2.fecha_servicio) = ? JOIN cuotas AS cuo2 ON res2.id_reserva = cuo2.id_reserva AND cuo2.confirmacion_pago = 1 GROUP BY res2.id_reserva);", array($mes) )->row_array();
    		break;
    		case 4: // Rango Fecha
    			$response = null;
	    		//$response['monto_cupon'] = 4;
	    		$response = $this->db->query("SELECT SUM(res.monto_cupon_descuento) AS monto_cupon FROM reserva AS res WHERE res.id_reserva IN (SELECT res2.id_reserva FROM reserva AS res2 JOIN detalle_servicio_has_reserva AS dshr2 ON res2.id_reserva = dshr2.id_reserva JOIN detalle_servicio AS dese2 ON dese2.id_detalle_servicio = dshr2.id_detalle_servicio AND dese2.fecha_servicio BETWEEN ? AND ? JOIN cuotas AS cuo2 ON res2.id_reserva = cuo2.id_reserva AND cuo2.confirmacion_pago = 1 GROUP BY res2.id_reserva);", array($fechaInicio,$fechaFin) )->row_array();
    		break;
    	}
    	return $response['monto_cupon'];
    	//return $option." -> ".$fechaInicio." - ".$fechaFin;
    }
    /*
	0 = Todo
	1 = Mes Anterior
	2 = 30 Días
	3 = Mes Actual
	4 = Rango Fecha
    */
}