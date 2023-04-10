<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Reporteprecios extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/reporte_precios_model');
    } 

    function index(){
        $data['data'] = $this->reporte_precios_model->get_productos();
        $this->load->view("admin/reporte-precios",$data);
    }

    function precios($idioma,$idProducto=0){

        $data['data'] = $this->reporte_precios_model->get_precios_producto($idioma,$idProducto);
        $data['ids']  = array("idioma" => $idioma,"idproducto" => $idProducto);
        //$this->load->view('admin/pdf/pdf-precios', $data);
        $this->load->view('admin/reporte-ver-precio',$data);
    }

    function pdf($idioma,$idProducto=0){

        $data['data'] = $this->reporte_precios_model->get_precios_producto($idioma,$idProducto);
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', TRUE);

        $html = $this->load->view('admin/pdf/pdf-precios', $data, true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        $dompdf->render();
        $dompdf->stream('reporte-precios.pdf',[ 'Attachment' => 0 ]);
    }

}