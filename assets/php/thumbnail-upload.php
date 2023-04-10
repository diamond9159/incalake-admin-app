<?php
  $url_base   = 'http://localhost/cms/';
  $directorio = '../galeria/thumbnail/';
  $data = array();
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $file = $_FILES['miniatura']['name'];
    if( !is_dir( $directorio ) ) 
      mkdir( $directorio, 0777);
    if($file && move_uploaded_file($_FILES['miniatura']['tmp_name'],$directorio.$file)){
      sleep(2);
      $data = array(
        'response'=> 'OK',
        'imagen'  => $file,
        'url'     => $url_base.'assets/galeria/thumbnail/'.$file,
      );
    }
  }else{
    //throw new Exception("Error Processing Request", 1);  
    $data = array(
      'response'=> 'ERROR',
      'imagen'  => 'error.png',
      'url'     => $url_base.'assets/galeria/error.png',
    ); 
  }
  echo json_encode($data);
?>