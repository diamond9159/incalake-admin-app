<?php 
//sleep(1);
  // definir una constante de codeigniter para evitar error
  define('BASEPATH','');
  // obtener la session codeigniter
  $user = unserialize(@$_COOKIE['ci_session']);
  
  // salir si session no existe
  if(empty($user['username_usuarios']))exit('session');

  // configuraciones de la base de datos
  include '../../application/config/database.php';
  // conexion normal de la base de datos
  $conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'],$db['default']['database']);

  // establecer la codificacion de los resultados de la bse de datos
  $conn->set_charset("utf8");

  //detectar que los archivos evueltos pertenescan a usuario logueado
  $ruta = "../../../web/galeria/".$user['username_usuarios'];

// funcion para extraer archivos se le da la ruta y  files que indica si se retorna los archivos por defecto solo carpetas
function archivos($rutaa,$files=false){
  // crear array vacio para almacenar las carpetas/archivos obtenidos
  $folderes = array();
  // buscar archivos-carpetas y agregar a la avariable folderes
  foreach(glob($rutaa.'/*',$files?null:GLOB_ONLYDIR) as $dir) {
    // extraer nombre de la carpeta y o archivo
    $nombreReal = str_replace($rutaa.'/', '', $dir);
    // si carpeta igual a thumbs entonce obiar
    if($nombreReal!='thumbs')$folderes[] =  $nombreReal;
    
  }
   // revolver resultados
  return $folderes;
}

/*funcion para buscar nombres de carpete segun el numero dado en $val*/
function getnombreByID($val){
   $folder = null;
      switch ($val) {
      case 0: $folder = 'docs';break;
      case 1: $folder = 'full-slider';break;
      case 2: $folder = 'short-slider';break;
      case 3: $folder = 'relateds';break;
      case 4: $folder = 'recursos';break;
      case 5: $folder = 'politicas';break;
      case 6: $folder = 'other-images';break;
      case 7: $folder = 'other-docs';break;
    }
  return $folder;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
// obtener carpetas
if(isset($_GET['getCarpetas'])){
  // obtener lista de carpetas principales (full-slider,etc)
  $carpetas = archivos($ruta.'/'.getnombreByID($_GET['getCarpetas']));

 // buscar carpetas dentro del tipo de contenedor de carpetas (full-slider,etc)
  $carpetasMulti = array();
  foreach ($carpetas as $value) {
    $contenido = array();
    $subFolder = archivos($ruta.'/'.getnombreByID($_GET['getCarpetas']).'/'.$value);
    // buscar subcarpetas
    foreach($subFolder as $value2){
      $contenido[$value2] = archivos($ruta.'/'.getnombreByID($_GET['getCarpetas']).'/'.$value.'/'.$value2,true);
    }
    $carpetasMulti[$value] = $contenido;
  }
  exit(json_encode($carpetasMulti));

// crear carpetas
} elseif(isset($_GET['crearCarpeta'])){
    $exito = 0;
    // si carpeta esta seleccionada crear dentro de esta de lo contrario crear una independiente
    $nuevaCarpeta = empty($_POST['folderPrincipal'])?$_POST['nuevacarpeta']:$_POST['folderPrincipal'].'/'.$_POST['nuevacarpeta'];
    // crear string de ruta con toda la ruta : admin/galeria/full-..../nuevacarpeta
    $ruta_carpeta = $ruta.'/'.getnombreByID($_POST['folder']).'/'.$nuevaCarpeta;
    // si existe carpeta
    if(mkdir($ruta_carpeta, 0777, true)) {
      // cambiar permisos
       chmod($ruta_carpeta, 0777);
      if(!preg_match('/(0|5|7)/', $_POST['folder'])){//0-5-7: ids de documentos
         $carpeta_thumb = $ruta_carpeta.'/'.'thumbs/';
         mkdir($carpeta_thumb, 0777, true);//crear carpeta de thumbnails
         chmod($carpeta_thumb, 0777);// dar permisos
       }

       $exito = 1;
    }
    // devolver 1 o 0 para indicar si operacion fue exitosa
    exit($exito?'1':'0');
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
// retorna los archivos
if(isset($_GET['getArchivos'])){ 
   //sleep(3);
   $results = array();
   // obtener lista de archivos desde la base de datos
   $result = $conn->query("SELECT * FROM galeria WHERE tipo_archivo = ".$_GET['getArchivos']." AND carpeta_archivo='{$_GET['customfolder']}' AND id_usuarios = {$user['id_usuarios']}");
      if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
         // obtener el tipo de archivo (1=full-slider,etc)
          $row['tipo_archivo'] = getnombreByID($row['tipo_archivo']);
          $row['user'] = $user['username_usuarios'];
          $results[] = $row;
       }
      } 
   // retornar json
   exit(json_encode($results));
}
// retorna idiomas
elseif(isset($_GET['getidiomas'])){
  // buscar en la bse de datos
   $result = $conn->query("SELECT pais,codigo FROM idioma");
    if($result->num_rows > 0){
      $idiomas = array(); 
      while($row = $result->fetch_assoc()){
        $idiomas[] = $row;
      }
      // retornar idiomas
      exit(json_encode($idiomas));
    }
}
// a continuacion sube imagenes y docs
elseif(isset($_GET['folder'])){
  //echo json_encode($_POST['nombre_imagen']);
$verificador = 0;
  
// empezamos creando la carpeta// ruta_nueva_carpeta
// si tiene subcarpeta subir ahi 
     if(@$_POST['subcarpetaselect'])$_POST['carpetaselect']=$_POST['subcarpetaselect'];
     // ubicar carpeta padre
     $folder = getnombreByID($_GET['folder']);
     // crear ruta completa 
     $ruta_carpeta = $ruta.'/'.$folder.'/'.$_POST['carpetaselect'].'/';
  // si hay archivo
   if(is_array($_FILES)) {
    // detectar archivo que se aca de subir
    if(is_uploaded_file($_FILES['file']['tmp_name'])) {
    // obtener el nombre temporal
    $sourcePath = $_FILES['file']['tmp_name'];
    // obtener la extencion del archivo
    $extencion = explode('.',$_FILES['file']['name']);
    //si viene url personalizada tomar ello de lo contrario tomar el nombre del archivo
    $url_extencion = empty($_POST['url_archivo'])?$_FILES['file']['name']:$_POST['url_archivo'].'.'.$extencion[1];
    // crear url
    $nuevaruta = $ruta_carpeta.$url_extencion;

    if(file_exists($nuevaruta))exit('0');//si archivo existe salir

    if(move_uploaded_file($sourcePath,$nuevaruta)) {
      //if((int)$_GET['folder'] && (int)$_GET['folder']<5){
      if(!preg_match('/(0|5|7)/', $_GET['folder'])){//0-5-7: ids de documentos
        /*inicio de redicmencionar imagen para thumbnails*/
            function resize_image($file, $w, $h) {
             global $extencion;
             list($width, $height) = getimagesize($file);
             // detectar extencion de archivo y usar funcion especifica para crean miniatura
             $src = $extencion[1]=='png'?imagecreatefrompng($file):imagecreatefromjpeg($file);
             $dst = imagecreatetruecolor($w, $h);
             imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
             return $dst;
          }
          // remiencionar la imagen
          $thumb =  resize_image($nuevaruta,200,150);
          $rutathumb = $ruta_carpeta.'thumbs/'.$url_extencion;
          $extencion[1]=='png'?imagepng($thumb,$rutathumb):imagejpeg($thumb,$rutathumb);
          /*fin redimencionar imagen*/
      }
  
      /*agregado de datos de la imagen y o docuemnto a la base de datos*/
      $detalles_archivo = null;
      if(!empty($_POST['idioma_archivo'])){
        $array = array();
          foreach ($_POST['idioma_archivo'] as $key => $value) {
             $array[$value]['titulo'] = $_POST['titulo_imagen'][$key];
             $array[$value]['descripcion'] = $_POST['descripcion_imagen'][$key];
          }
        $detalles_archivo = json_encode($array);
      }
      // insertar detalles del archivo en la base de datos 
      $sql = "INSERT INTO galeria (url_archivo, detalles_archivo,tipo_archivo,carpeta_archivo,id_usuarios)
VALUES ('$url_extencion', '$detalles_archivo','{$_GET['folder']}','{$_POST['carpetaselect']}',{$user['id_usuarios']})";
      if($conn->query($sql) === TRUE) {
        $verificador = 1;
      }
      /*fin de agrego de imagen a base de datos*/
    }
    }
    }
// fin de la creacion de la carpeta//
echo($verificador);
}
?>