<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Reporteactividades extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin/reporte_precios_model');
        $this->load->model('admin/reporte_actividades_model');
        $this->load->model('admin/idioma_model');
    } 

    function index(){
        $data['data'] = $this->reporte_actividades_model->get_productos();
        $this->load->view("admin/reporte-actividades",$data);
    }

    function actividades($lang = 'es' ){
        $data['data']       = $this->reporte_actividades_model->get_productos_idioma($lang);
        $data['idiomas']    = $this->idioma_model->get_all_idiomas();
        $this->load->view('admin/reporte-actividades/actividades-idioma',$data);
    }

    function actividad($idioma,$idProducto=0){
        $data['actividad'] = $this->reporte_actividades_model->get_actividad($idioma,$idProducto);
        $data['tabs']      = $this->reporte_actividades_model->get_tabs(@$data['actividad']['id_producto']);
        $data['galeria']   = $this->reporte_actividades_model->get_galeria(@$data['actividad']['id_producto']);
        $data['data']      = $this->reporte_actividades_model->get_precios_producto($idioma,$idProducto);
        $data['precios']   = $this->preciosHTML($data['data']); 
        $data['ids']       = array("idioma" => $idioma,"idproducto" => $idProducto);
        //$this->load->view('admin/pdf/pdf-precios', $data);
        $this->load->view('admin/reporte-ver-actividad',$data);
    }

    function pdf($idioma,$idProducto=0){
        //echo "Hola Mundo..!";
        $data['actividad'] = $this->reporte_actividades_model->get_actividad($idioma,$idProducto);
        $data['tabs']      = $this->reporte_actividades_model->get_tabs(@$data['actividad']['id_producto']);
        $data['galeria']   = $this->reporte_actividades_model->get_galeria(@$data['actividad']['id_producto']);
        $data['data']       = $this->reporte_actividades_model->get_precios_producto($idioma,$idProducto);
        $data['precios']   = $this->preciosHTML($data['data']);
        $data['ids']  = array("idioma" => $idioma,"idproducto" => $idProducto);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', TRUE);

        $html = $this->load->view('admin/pdf/pdf-actividad', $data, true);
        //echo $html;
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        //$dompdf->loadHtml("<h1>Hola<h1/>");

        $dompdf->render();
        //$dompdf->stream('reporte-actividad',[ 'Attachment' => 0 ]);
        $dompdf->stream( mb_strtoupper(@$actividad['titulo_producto']).'.pdf',[ 'Attachment' => 0 ]);
        
        
    }

    private function preciosHTML($data){
        $preciosHtml = '';
        if ( count($data) != 0 ){          
            foreach ($data as $key => $value){
                foreach ($value['detalle_precios'] as $k => $val){
                    $preciosHtml .= '<strong><h4 class="text-warning">PRECIOS: '.mb_strtoupper($val["descripcion"]).'</h4></strong>';
                    if ( count($val['precios']) != 0 ){
                        $preciosHtml .= '<table class="table-striped table-bordered" style="width: 100%;" > 
                            <thead><tr>
                                <th class="text-center"> # Personas </th> 
                                <th class="text-center"> Precio Unitario USD</th> 
                                <th class="text-right" style="padding-right: 10px;"> Precio Total USD</th> 
                            </tr><thead><tbody>';
                        foreach ($val['precios'] as $j => $v){
                            $preciosHtml .= '<tr>
                                <td class="text-center"> '.$v["cantidad"].' </td> 
                                <td class="text-center"> $ <strong>'.number_format($v["monto"],2,'.',' ').'</strong> <small>USD</small></td> 
                                <td class="text-right" style="padding-right: 10px;"> $ <strong>'.number_format(($v["cantidad"]*$v["monto"]),2,'.',' ' ).'</strong> <small>USD</small></td> 
                            </tr>';
                        }
                        $preciosHtml .= '</tbody></table>';    
                    }else{
                        $preciosHtml .= '<div class="alert alert-danger">
                        <div class="text-center text-danger"><span class="fa fa-exclamation-circle"></span> No hay precios para esta actividad..!</div>
                        </div>';
                    }
                }
                $preciosHtml .= '<br/><hr/><br/>';
            }
        }else{
            $preciosHtml .= '<div class="alert alert-danger">
                                <h4 class="text-danger text-center"><span class="fa fa-exclamation-circle"></span> NO HAY DATOS PARA REALIZAR LOS REPORTES DE PRECIOS.</h4>
                            </div>';
        }
        return $preciosHtml;
    }

}