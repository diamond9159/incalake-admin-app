<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();


// if ($CI->uri->segment(1)=='admin') {
$CI->load->library('session');



//$avoidFiles = array('login','relacionados','precios','paqueteturistico','web','oferta');
//if($CI->uri->segment(1)=='admin'){ activar luego
	$avoidFiles = array('login');
	 //session_start(); //we need to call PHP's session object to access it through CI
	//$CI->session->userdata('username_usuarios'));
	///////////////////////////////////////
	if(empty($CI->session->userdata('username_usuarios'))){
		$existe = false;
		foreach ($avoidFiles as $value) {
			if($CI->uri->segment(2)==$value){$existe = true;break;}
		}

		if(!$existe){
			redirect(base_url().'admin/login?url='.current_url());
		}
	}
//}
// }
  

?>