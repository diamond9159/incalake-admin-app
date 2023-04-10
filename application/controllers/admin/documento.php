<?php

class Documento extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('file');
    } 

    function index(){
        
    }

    function politicasStandar(){
        $this->load->helper('file');
        $idioma             = $this->input->post('lang');
        $data['response']   = "success";
        $buffer             = '';
        //$ruta = $_SERVER['DOCUMENT_ROOT']."/web/assets/archivos/politicas/".strtoupper($idioma).".txt";
        $ruta = "../web/assets/archivos/politicas/".strtoupper($idioma).".txt";
        //$content = "Inca Lake Travel Agency EIRL";
        //$txt = fopen($ruta,"r");
        //fwrite($txt,$content);
        //fclose($txt);
        
        $leer= fopen($ruta, 'r');
        #Se juntan los datos en un solo string
        //$mostrar = fgets($leer);
        while(!feof($leer)){ 
            $buffer .= fgets($leer);  
        } 

        //$data['ruta'] = "".$_SERVER['DOCUMENT_ROOT'];
        //$data['message']    = $mostrar;
        $data['message']    = $buffer;
        echo json_encode($data);
    }
}

?>