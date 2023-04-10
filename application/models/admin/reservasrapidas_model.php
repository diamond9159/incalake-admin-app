<?php
class Reservasrapidas_model extends CI_Model{
    function __construct(){
        parent::__construct();
    } 

    function get_reservasrapidas($id_reserva){
        $reserva = $this->db->query("SELECT * FROM reserva WHERE id_reserva = ? ;",array($id_reserva))->row_array();
        return $reserva;
    }

    function get_all_reservasrapidas(){
        $reservasrapidas = $this->db->query("SELECT * FROM reserva WHERE 1 = 1 ;")->result_array();
        return $reservasrapidas;
    }

    function add_reserva($params){
        $this->db->insert('reserva',$params);
        return $this->db->insert_id();
    }
    
    function update_reserva($id_reserva,$params){
        $this->db->where('id_reserva',$id_reserva);
        $response = $this->db->update('reserva',$params);
        if($response){
            return "reservasrapidass updated successfully";
        }else{
            return "Error occuring while updating reservasrapidass";
        }
    }

    function delete_reserva($id_reserva){
        $response = $this->db->delete('reserva',array('id_reserva'=>$id_reserva));
        if($response){
            return "reservasrapidass deleted successfully";
        } else {
            return "Error occuring while deleting reservasrapidass";
        }
    }

    //Retorna la cantidad de reservas que hay con la fecha actual consultada.
    function get_cantidadReserva(){
        $response = $this->db->query("SELECT COUNT(*) as cantidad FROM reserva WHERE fecha_creacion_reserva LIKE '%".date('Y-m-d')."%';")->row_array();
        return @$response['cantidad']?@$response['cantidad']:0;
    }

    function add_detalle_servicio($params){
        $this->db->insert('detalle_servicio',$params);
        return $this->db->insert_id();
    }

    function add_reserva_has_detalle_reserva($params){
        $this->db->insert('detalle_servicio_has_reserva',$params);
        return $this->db->insert_id();
    }

    function add_resumen($params){
        $this->db->insert('resumen',$params);
        return $this->db->insert_id();   
    }

    function add_coutas($params){
        $this->db->insert('cuotas',$params);
        return $this->db->insert_id();
    }

    // Retorna todos los servicios existentes en la base de datos para luego utilizar en genrador de pagos
    function get_servicios(){
        $data = [];
        $response = $this->db->query("SELECT idi.codigo,pro.id_producto,pro.titulo_producto,pro.tasas_impuestos,pro.porcentaje_adelanto,pro.metodo_pago,pro.hora_inicio,pro.duracion,pro.zona_horaria,tab.itinerario_ta AS itinerario_tab,tab.incluye_tab FROM idioma AS idi JOIN servicio AS ser ON idi.id_idioma = ser.idioma_id_idioma JOIN producto AS pro ON ser.id_servicio = pro.id_servicio JOIN tab AS tab ON pro.id_producto = tab.producto_id_producto;")->result_array();
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                $data[] = array(
                    'idioma'                => mb_strtolower($value['codigo']),
                    'id_producto'           => $value['id_producto'],
                    'titulo_producto'       => mb_strtoupper( trim($value['titulo_producto']) ),
                    'tasas_impuestos'       => $value['tasas_impuestos'],
                    'porcentaje_adelanto'   => $value['porcentaje_adelanto'],
                    'metodo_pago'           => $value['metodo_pago'],
                    'itinerario_tab'        => $value['itinerario_tab'],
                    'incluye_tab'           => $value['incluye_tab'],
                    'precios'               => $this->formatear_precios_producto($value['id_producto']),
                    'ofertas'               => $value['id_producto'],
                    'bloqueos'              => $value['id_producto'],
                    'recursos'              => $value['id_producto'],
                    'horarios'              => $this->formatear_horarios($value['hora_inicio'],$value['duracion'],$value['zona_horaria']),
                );
            }
        }
        return $data;
    }

    function formatear_precios_producto($id_producto){
        $data = [];
        $response = $this->get_detalle_precios($id_producto);
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                $data[] = array(
                    'descripcion' => $value['descripcion_etapa_edad'].' '.$value['descripcion_nacionalidad'],
                    'precios'     => $this->get_precios($value['id_detalle_precio']),
                );
            }
        }
        return $data;
    }
    function formatear_horarios($hora_inicio,$duracion,$zona_horaria){
        $data = [];
        $arrayHorarios      = [];
        $arrayDuraciones    = [];
        $arrayZonasHorarias = [];
        if ( !empty( trim($hora_inicio) ) ) {
            $arrayHorarios = explode(',',$hora_inicio);
        }
        if ( !empty( trim($duracion) ) ) {
            $arrayDuraciones = explode(',', $duracion);
        }
        if ( !empty( trim($zona_horaria) ) ) {
            $arrayZonasHorarias = explode(',', $zona_horaria);
        }
        foreach ($arrayHorarios as $key => $value) {
            $arrayTiempo = explode('!', @$arrayDuraciones[$key] );
            $data[] = array(
                "es" => $value.$this->formatearDuracion($arrayTiempo,'es').$this->formatearZonaHoraria(@$arrayZonasHorarias[$key],'es'),
                "en" => $value.$this->formatearDuracion($arrayTiempo,'en').$this->formatearZonaHoraria(@$arrayZonasHorarias[$key],'en'),
            );
        }
        return $data;
    }

    function  formatearDuracion($arrayDuracion,$language = 'es'){
        $str = '';
            switch ($language) {
                case 'es':
                    switch (@$arrayDuracion[1]) {
                        case 0:
                            $str = ' ('.@$arrayDuracion[0].' Minutos) ';
                        break;
                        case 1:
                            $str = ' ('.@$arrayDuracion[0].' Horas) ';
                        break;
                        case 2:
                            $str = ' ('.@$arrayDuracion[0].' Días) ';
                        break;
                    }
                break;
                case 'en':
                    switch (@$arrayDuracion[1]) {
                        case 0:
                            $str = ' ('.@$arrayDuracion[0].' Minutes) ';
                        break;
                        case 1:
                            $str = ' ('.@$arrayDuracion[0].' Hours) ';
                        break;
                        case 2:
                            $str = ' ('.@$arrayDuracion[0].' Days) ';
                        break;
                    }
                break;
            }
        return $str;
    }
    function formatearZonaHoraria($option = 0, $language = 'es'){
        $str = '';
        switch ($language) {
            case 'es':
                switch ($option) {
                    case 0:
                        $str = ' Hora Peruana';
                    break;
                    case 1:
                        $str = ' Hora Boliviana';
                    break;
                    default:
                        $str = ' Hora Peruana';
                    break;
                }
            break;
            case 'en':
                switch ($option) {
                    case 0:
                        $str = ' Peruvian Time';
                    break;
                    case 1:
                        $str = ' Bolivian Time';
                    break;
                    default:
                        $str = ' Peruvian Time';
                    break;
                }
            break;
        }
        return $str;
    }
    function get_detalle_precios($id_producto){
        return $this->db->query("SELECT dp.*,ee.id_etapa_edad,ee.descripcion_etapa_edad,ee.traducciones,n.descripcion_nacionalidad,n.traducciones_nacionalidad FROM detalle_precio as dp JOIN nacionalidad as n ON dp.id_nacionalidad = n.id_nacionalidad JOIN etapa_edad as ee ON dp.id_etapa_edad = ee.id_etapa_edad AND dp.id_producto = '".$id_producto."';")->result_array();
    }

    function get_precios($id_detalle_precio){
        return $this->db->query("SELECT * FROM precios as p WHERE p.id_detalle_precio = '".$id_detalle_precio."' ORDER BY p.cantidad ASC;")->result_array();
    }
}
