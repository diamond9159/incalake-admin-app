<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Reportes extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/reporte_model');
    } 


    function index(){
    	$data = [];
		$fechaInicio = '2017-01-01 12:59:00'; // Definimos fecha de inicio para el filtro de registros, por defecto una fecha antes de haber implemntado el sistema
		$fechaFin 	 = '2100-01-01 12:59:00'; // Definimos una fecha mayor para que filtre todos los años
    	
    	$data['data'] = $this->reporte_model->get_servicios( $fechaInicio,$fechaFin );
    	$data['monto_cupones'] = $this->reporte_model->get_montoTotalCupones( $fechaInicio,$fechaFin );
    	$this->load->view('admin/reportes/index',$data);
    }

    function servicios(){
    	$data = [];
		$fechaInicio = '2017-01-01 12:59:00'; // Definimos fecha Inicio por defecto.
		$fechaFin 	 = '2100-01-01 12:59:00'; // Definimos fecha Fin por defecto.
    	if ( $this->input->post('fecha_inicio',TRUE) && $this->input->post('fecha_fin',TRUE) ) {
    		$fechaInicio 	= $this->input->post('fecha_inicio',TRUE);
    		$fechaFin 		= $this->input->post('fecha_fin',TRUE);
    	}
    	if ( $this->input->get('fecha_inicio',TRUE) && $this->input->get('fecha_fin',TRUE) ) {
    		$fechaInicio 	= $this->input->get('fecha_inicio',TRUE);
    		$fechaFin 		= $this->input->get('fecha_fin',TRUE);
    	}

    	$data['data'] = $this->reporte_model->get_servicios( $fechaInicio,$fechaFin );
    	$data['monto_cupones'] = $this->reporte_model->get_montoTotalCupones( $fechaInicio,$fechaFin );
    	echo json_encode($data);
    }
    
    function serviciosmes(){
    	$data = [];
		$fechaInicio = '2017-01-01 12:59:00'; // Definimos fecha Inicio por defecto.
		$fechaFin 	 = '2100-01-01 12:59:00'; // Definimos fecha Fin por defecto.
    	$option 	 = 0; // 0 = Mes Actual, 1 = Mes Anterior, 2 = Ultimos 30 Días
    	if ( $this->input->post('fecha_inicio',TRUE) && $this->input->post('fecha_fin',TRUE) ) {
    		$fechaInicio 	= $this->input->post('fecha_inicio',TRUE);
    		$fechaFin 		= $this->input->post('fecha_fin',TRUE);
    	}
    	$option 		= $this->input->post('option',TRUE);
    	/*
    	if ( $this->input->get('fecha_inicio',TRUE) && $this->input->get('fecha_fin',TRUE) ) {
    		$fechaInicio 	= $this->input->get('fecha_inicio',TRUE);
    		$fechaFin 		= $this->input->get('fecha_fin',TRUE);
    		$option 		= $this->input->get('option',TRUE);
    	}
    	*/
    	$fechaInicio = date_format(date_create($fechaInicio), "Y-m-d");
    	$fechaFin    = date_format(date_create($fechaFin), "Y-m-d");
    	$data['data'] = $this->reporte_model->get_serviciosMes( $option, $fechaInicio, $fechaFin );
    	$data['monto_cupones'] = $this->reporte_model->get_montoTotalCuponesMes( $option, $fechaInicio, $fechaFin );
    	$data['values']	= array( "OPTION"=>(Integer)$option,"FECHA INICIO" => $fechaInicio,"FECHA FIN" => $fechaFin );
        //$data['url_reporte_pdf'] = $this->serviciosmespdf($data);
        $data['url_reporte_pdf'] = null;
    	echo json_encode($data);
    }

    public function serviciosmespdf($data){
        $html = $this->load->view('admin/estadisticas/serviciospdf',$data, true); 

        $options = new Options();
        $options->set('defaultFont','Helvetica');
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdf = $dompdf->output();

        $nombrePdf = date("d-m-Y_h-i-s");
        file_put_contents('assets/pdf/reportes/'.$nombrePdf.'.pdf', $pdf); //Guardamos el pdf en el servidor
        //sleep(7);
        return base_url()."/".'assets/pdf/reportes/'.$nombrePdf.'.pdf';
    }

}