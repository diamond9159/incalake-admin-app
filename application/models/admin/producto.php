<?php
class Producto extends CI_Model { 
   public function __construct() {
      parent::__construct();
      $this->load->model("admin/oferta_model");
      $this->load->model("admin/disponibilidad_model");
      $this->load->model("admin/bloqueo_model");
      $this->load->model("admin/guia_model");
      $this->id_user_actual = $this->session->userdata('id_usuarios');
   }
 private function getPrecios($id_prod){
     $resultados_precios_detalles = $this->db->query("SELECT * FROM detalle_precio WHERE id_producto=$id_prod")->result_array();
     $lista_edades  = array();
      function formatNumber($number){
            $num = explode('.',(float)$number);
            return isset($num[1])?$num[0].'.'.str_pad($num[1],2, '0',STR_PAD_RIGHT):$num[0];
        }

      foreach($resultados_precios_detalles as $res){
         $lista_edades[$res['id_etapa_edad']]['nacionalidades'][$res['id_nacionalidad']]['edad_min']=$res['edad_minimo'];
         $lista_edades[$res['id_etapa_edad']]['nacionalidades'][$res['id_nacionalidad']]['edad_max']=$res['edad_maximo'];
         $lista_edades[$res['id_etapa_edad']]['nacionalidades'][$res['id_nacionalidad']]['precios']=json_decode($res['rangos']);

        /* $resultados_precios = $this->db->query("SELECT * FROM precios WHERE id_detalle_precio={$res['id_detalle_precio']}")->result_array();
         foreach($resultados_precios as $res2){
          $lista_edades[$res['id_etapa_edad']]['nacionalidades'][$res['id_nacionalidad']]['precios'][$res2['cantidad']]=formatNumber($res2['monto']);
         }*/
      }
      //echo json_encode($lista_edades);
      return count($lista_edades)?json_encode($lista_edades):'';
   }
   //////////////////////////////////////////////////////////////////////////////////////////////////
   public function operarProducto($param,$precio,$html,$addedtabs,$galeria,$idprod,$datos_extra,$paramsGuiasSeleccionados, $inputs= null){
      //dentro idprod es igual a id_producto entonces se editaﾅ病 los datos del producto de lo contrario en el else de agregarﾃ｡ uno nuevo
      if($idprod){
         $this->db->where('id_producto', $idprod)->update('producto', $param);
         //precio
         //$this->db->where('id_producto', $idprod)->update('precio', $precio);
         //tabs
         $this->db->where('producto_id_producto', $idprod)->update('tab', $html);
         //eliminar tabs adicionales pero luego se agrega todo los relacionados
         $this->db->delete('tab_adicional', array('id_producto' => $idprod));
         //eliminar galeria para agregarlos de nuevo
         $this->db->delete('galeria_has_producto', array('id_producto' => $idprod));
         //eliminar precios 
         $this->db->delete('detalle_precio', array('id_producto' => $idprod));

         $idproducto = $idprod;
      }else{
         //codigo producto 
         // si no tiene codigo crear uno nuevo tambien se almacenara el id de usuario quien lo crea
         if(empty($param['id_codigo_producto'])){
            $codprod['codigo_producto'] = date('sihdmy');
            $codprod['id_usuarios'] = $this->id_user_actual;
            $this->db->insert('codigo_producto', $codprod);
            $param['id_codigo_producto'] = $this->db->insert_id();
         }
         //producto
         $this->db->insert('producto', $param);
         $idproducto=$this->db->insert_id();
         //precio 
        // $precio['id_producto'] = $idproducto;
         //$this->db->insert('precio', $precio);
         //tabs
         $html['producto_id_producto'] = $idproducto;

         if(!empty($inputs)) {
            foreach($inputs as $i){
              $this->db->insert('producto_has_campoform', [
                  'id_producto' => $idproducto,
                  'id_campo_formulario' => $i,
                ]);
            }
        }

         $this->db->insert('tab', $html);//agregar tabs normal
      } 
      /*insertar precios, si se edita tambien se insertarﾃ｡ porque se debio eliminar todo los id e producto relacionados*/
    /*var_dump($precio['precio_edad']);
    exit();*/
      if(is_array(@$precio)){
        foreach($precio as $id_edad => $values_edad){
          foreach($values_edad['nacionalidades'] as $id_nacionalidad => $values_nacionalidad){
             $this->db->query("INSERT INTO detalle_precio (id_producto, id_etapa_edad, id_nacionalidad,edad_minimo,edad_maximo,rangos) VALUES ($idproducto, $id_edad, $id_nacionalidad, {$values_nacionalidad['edad_min']}, {$values_nacionalidad['edad_max']}, '".json_encode(@$values_nacionalidad['precios'])."')");
             

             $last_id = $this->db->insert_id();
             if(is_array(@$values_nacionalidad['precios'])){
             foreach($values_nacionalidad['precios']['desde'] as $key_precio => $values_precios){

              if(is_numeric(@$values_nacionalidad['precios']['hasta'][$key_precio]) and is_numeric(@$values_nacionalidad['precios']['precio'][$key_precio])){
                   for($i=(int)$values_precios;$i<=(int)$values_nacionalidad['precios']['hasta'][$key_precio];$i++){
                    $this->db->query("INSERT INTO precios (cantidad, monto, id_detalle_precio) VALUES ($i, {$values_nacionalidad['precios']['precio'][$key_precio]}, $last_id)");
                  }
              }
     
             }
            }

          }
      }
    }
      //ahora se registra precio general
      

    
      /*fin insertar precios*/
      //agregar tabs adicionales
         if($addedtabs['nombre']){
            foreach ($addedtabs['nombre'] as $key => $value) {
               $tab['nombre_tab'] = $value;
               $tab['icono_tab_adicional'] = $addedtabs['icono'][$key];
               $tab['contenido_tab'] = $addedtabs['contenido'][$key];
               $tab['id_producto'] = $idproducto;
               $this->db->insert('tab_adicional', $tab);
            }
         }
         //agregar imagenes a la galeria
         if($galeria['id']){
            foreach ($galeria['id'] as $key => $value) {
               $galeriaData['id_galeria'] = $value;
               $galeriaData['id_producto'] = $idproducto;
               if(!empty($value)) $this->db->insert('galeria_has_producto', $galeriaData);
            }
         }

         /**** AGREGAR DISPONIBILIDAD, BLOQUEO y OFERTA *****/
         $jsonDisponibilidad = trim(@$datos_extra['data_disponibilidad']);
         if ( !empty($jsonDisponibilidad) ) {
          $jsonDisponibilidad = json_decode($jsonDisponibilidad,true);
          foreach ($jsonDisponibilidad as $key => $value) {
            if ( !is_numeric($value['id']) )  {
              $this->disponibilidad_model->delete_disponibilidad_producto($idproducto);
              $params_disponibilidad['id_producto']                 = $idproducto;
              $params_disponibilidad['descripcion_disponibilidad']  = $value['title'];
              $params_disponibilidad['fecha_inicio']                = $value['start'];
              $params_disponibilidad['fecha_fin']                   = $value['end'];  
              $params_disponibilidad['color_disponibilidad']        = $value['color'];
              $params_disponibilidad['dias_activos']                = json_encode($value['dias_activos']);
              $params_disponibilidad['dias_no_activos']             = json_encode($value['dias_no_activos']);
              $params_disponibilidad['dias_especiales']             = json_encode($value['dias_especiales']);
              $params_disponibilidad['meses_inactivos']             = json_encode($value['meses_inactivos']);
              $this->disponibilidad_model->add_disponibilidad($params_disponibilidad);              
            }
          }
         }
        
         $jsonOferta = trim(@$datos_extra['data_oferta']); 
         if ( !empty($jsonOferta) ) {
          $jsonOferta = json_decode($jsonOferta,true);
          foreach ($jsonOferta as $key => $value) {
            if ( !is_numeric($value['id']) ) {
              $params_oferta['id_producto']         = $idproducto;
              $params_oferta['valor_oferta']        = $value['descuento'];
              $params_oferta['tipo_oferta']         = $value['tipo_descuento'];
              $params_oferta['fecha_inicio']        = $value['start'];
              $params_oferta['fecha_fin']           = $value['end'];
              $params_oferta['color_oferta']        = $value['color'];
              $params_oferta['descripcion_oferta']  = $value['title'];
              $this->oferta_model->add_oferta($params_oferta);
            }
          }
         }
        
          $jsonBloqueo = trim(@$datos_extra['data_bloqueo']);
          if ( !empty($jsonBloqueo) ) {
            $jsonBloqueo = json_decode($jsonBloqueo,true);
            foreach ($jsonBloqueo as $key => $value) {
              if ( !is_numeric($value['id']) ) {
                $params_bloqueo['id_producto']          = $idproducto;
                $params_bloqueo['descripcion_bloqueo']  = $value['title'];
                $params_bloqueo['fecha_inicio']         = $value['start'];
                $params_bloqueo['fecha_fin']            = $value['end'];
                $params_bloqueo['color_bloqueo']        = $value['color'];
                $this->bloqueo_model->add_bloqueo($params_bloqueo);
              }
            }
          }

          //Actualizando array, cuando es nuevo registro no tiene id_producto ni id_codigo_producto
          $paramsGuiasSeleccionadosUpdate = [];
          foreach ($paramsGuiasSeleccionados as $key => $value) {
            $idproductoUpdate       = $value['id_producto'];
            $idcodigoproductoUpdate = $value['id_codigo_producto'];
            if (empty( trim($value['id_producto'])) ) {
                $idproductoUpdate       = $idproducto;
                $idcodigoproductoUpdate = $param['id_codigo_producto'];
            }
            $paramsGuiasSeleccionadosUpdate[] = array(
              'id_producto' => $idproductoUpdate, //id_producto
              'id_guia'   => $value['id_guia'], //id_guia
              'id_idioma'   => $value['id_idioma'], //id_idioma
              'id_codigo_producto' => $idcodigoproductoUpdate, //id_codigo_producto
              'id_codigo_guia'     => $value['id_codigo_guia'], //id_codigo_guia
              'tipo_guia'          => $value['tipo_guia'],
            );
          }
      $guia_exito = $this->guia_model->insertUpdate($idproducto,$paramsGuiasSeleccionadosUpdate);
      return $guia_exito?$param['id_codigo_producto']:false;
   }
   public function eliminar($id){
      $producto = $this->db->select('id_usuarios')
               ->from('producto')
               ->where('codigo_servicio.id_usuarios', $this->id_user_actual)
               ->join('servicio', 'producto.id_servicio = servicio.id_servicio')
               ->join('codigo_servicio', 'codigo_servicio.id_codigo_servicio = servicio.codigo_servicio_id_codigo_servicio')
               ->where('producto.id_producto', $id)->get();
      if($producto->num_rows()){
        if($this->db->delete('producto',array('id_producto'=>$id))){
            return 1;
        }
      }
      return 0;

   }
   public function obtenerProducto($id){ // uno solo porducto para buscar  mas abajo se buscara todo los productos
      $resultado = $this->db->select('*')
               ->from('producto')
               ->where('producto.id_producto', $id)
               ->where('codigo_servicio.id_usuarios', $this->id_user_actual)
               ->join('tab', 'tab.producto_id_producto = producto.id_producto')
               //->join('precio', 'precio.id_producto = producto.id_producto')
               ->join('servicio', 'producto.id_servicio = servicio.id_servicio')
               ->join('codigo_servicio', 'codigo_servicio.id_codigo_servicio = servicio.codigo_servicio_id_codigo_servicio')
               ->join('idioma', 'idioma.id_idioma = servicio.idioma_id_idioma')
               ->get()->row_array();
      //get tabs adicionales 
      $resultado['tab_adicional'] = $this->db->select('*')
               ->from('tab_adicional')
               ->where('id_producto', $id)
               ->get()->result_array();
      // get galeria
      //buscar documento de politicas
      /*
      if(!empty($resultado['politicas_producto'])){
        $politicas=$this->db->select('url_archivo')->from('galeria')->where('id_galeria', $resultado['politicas_producto'])->get()->row_array();
        $resultado['nombre_politicas'] = $politicas['url_archivo'];
      }
      */
      $resultado['galeria'] = $this->db->select('galeria_has_producto.id_galeria,url_archivo')
               ->from('galeria_has_producto')
               ->where('galeria_has_producto.id_producto', $id)
               ->order_by('id_galeria_has_producto','asc')
               ->join('galeria', 'galeria.id_galeria = galeria_has_producto.id_galeria')
               ->get()->result_array();

      
      if(!empty($resultado['adjuntos_producto'])){
        $idesAdjuntos = explode(',',$resultado['adjuntos_producto']);
        $adjunto = array();

              foreach($idesAdjuntos as $value){
               $adjunto[] =  $this->db->select('*')
               ->from('galeria')
               ->where('id_galeria', $value)
               ->get()->row_array();
                
              }
        $resultado['adjuntos_producto'] = $adjunto;
      }
      $resultado['disponibilidad'] = $this->disponibilidad_model->get_disponibilidad($id);
      $resultado['bloqueo']        = $this->bloqueo_model->get_bloqueo($id);
      $resultado['oferta']         = $this->oferta_model->get_oferta($id);
      /*obetener etapas de edad y nacionalidades json para procesar en javascript*/
      $resultado['etapas_edad'] =  json_encode($this->db->query("SELECT * FROM etapa_edad WHERE id_usuarios=$this->id_user_actual")->result_array());
      $resultado['nacionalidades'] =  json_encode($this->db->query("SELECT * FROM nacionalidad WHERE id_usuarios=$this->id_user_actual")->result_array());
      /*fin obtener json de edad y nacionalidades*/

      /*buscar precios en el nuevo formato*/
      $resultado['precios_full'] = $this->getPrecios($id);//precios personalizados
      /*fin de buscar precios en el nuevo formato*/
      return isset($resultado['id_producto'])?$resultado:false;
   }
   public function obtenerProductos(){ // todo los productos
      $resultado = $this->db->select('id_codigo_producto')
               ->from('codigo_producto')
               ->where('id_usuarios', $this->id_user_actual)
               ->order_by('id_codigo_producto', 'asc')
               ->get()->result_array();
      //buscar servicios de acuerdo a codigo de servicios obtenidos
      foreach($resultado as $key => $value){
        //$resultado[$key] = $this->db->select('titulo_producto,id_codigo_producto,codigo_producto')
        $resultado[$key] = $this->db->query("SELECT p.id_producto,p.titulo_producto,p.id_codigo_producto,p.codigo_producto,p.id_servicio,i.codigo,i.pais,s.ubicacion_servicio,s.uri_servicio  FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON p.id_servicio = s.id_servicio AND p.id_codigo_producto = '".$value['id_codigo_producto']."';")->result_array();
        /*
        $resultado[$key] = $this->db->select('id_producto,titulo_producto,id_codigo_producto,codigo_producto,id_servicio')
                          ->from('producto')
                          ->where('id_codigo_producto',$value['id_codigo_producto'])
         */ 
                          /*->where('codigo_servicio.id_usuarios', $this->id_user_actual)
                          ->join('servicio', 'producto.id_servicio = servicio.id_servicio')
                          ->join('codigo_servicio', 'codigo_servicio.id_codigo_servicio = servicio.codigo_servicio_id_codigo_servicio')*/
          //                ->get()->row_array();
      }
      return $resultado;
   }
   /*recuperarProductosRelacionados para devolver productos relacionados con sus idiomas*/
   function recuperarProductosRelacionados($id_codigo_producto){
    $resultado['productos'] = $this->db->select('*,idioma.pais as idioma, idioma.codigo as codigo_idioma')
               ->from('producto')
               ->where('id_codigo_producto',$id_codigo_producto)
               ->where('codigo_servicio.id_usuarios',$this->id_user_actual)
               ->join('servicio', 'producto.id_servicio = servicio.id_servicio')
               ->join('codigo_servicio', 'codigo_servicio.id_codigo_servicio = servicio.codigo_servicio_id_codigo_servicio')/*added*/
               ->join('idioma', 'idioma.id_idioma = servicio.idioma_id_idioma')
               ->get()->result_array();

     if($resultado['productos']){
      $resultado['idiomas'] = $this->db->select('id_servicio,codigo,pais,codigo_servicio_id_codigo_servicio as cod_servicio')
               ->from('servicio')
               ->where('codigo_servicio_id_codigo_servicio',$resultado['productos'][0]['codigo_servicio_id_codigo_servicio'])
               //->join('servicio', 'producto.id_servicio = servicio.id_servicio')
               ->join('idioma', 'idioma.id_idioma = servicio.idioma_id_idioma')
               ->get()->result_array();
     }
     return $resultado;
   }
   /*fin recuperarProductosRelacionados*/
   /*recuperar servicios por id_servicio*/
   function recuperarPorIdServicio($id_servicio){
     $resultado = $this->db->select('servicio.descripcion_pagina, codigo_producto,id_producto,titulo_producto,id_codigo_producto,url_servicio,titulo_pagina')
               ->from('producto')
               ->where('producto.id_servicio',$id_servicio)
               ->where('codigo_servicio.id_usuarios',$this->id_user_actual)
               ->join('servicio', 'producto.id_servicio = servicio.id_servicio')
               ->join('codigo_servicio', 'codigo_servicio.id_codigo_servicio = servicio.codigo_servicio_id_codigo_servicio')/*added*/
               //->group_by('id_codigo_servicio')
               //->join('idioma', 'idioma.id_idioma = servicio.idioma_id_idioma')
               ->get()->result_array();
     return $resultado;
   }
   /*fin de recuperar servicios por cod_servicio*/
   public function recuperarServicio($id=null){
      $consulta = $this->db->select('id_servicio,titulo_pagina,idioma.pais,idioma.codigo,url_servicio,codigo_servicio_id_codigo_servicio as id_codigo_servicio')
               ->from('servicio')
               ->where('servicio.id_servicio', $id)
               ->where('codigo_servicio.id_usuarios',$this->id_user_actual)
               ->join('codigo_servicio', 'codigo_servicio.id_codigo_servicio = servicio.codigo_servicio_id_codigo_servicio')
               ->join('idioma', 'idioma.id_idioma = servicio.idioma_id_idioma')
               ->get();
      if($consulta->num_rows()){
        $resultado = $consulta->row_array();

        $resultado['etapas_edad'] =  json_encode($this->db->query("SELECT * FROM etapa_edad WHERE id_usuarios=$this->id_user_actual")->result_array());
        $resultado['nacionalidades'] =  json_encode($this->db->query("SELECT * FROM nacionalidad WHERE id_usuarios=$this->id_user_actual")->result_array());
        //$resultado[''] = 
      }
      else $resultado = false;
      
      return $resultado;
   }
   /*funcion para detectar la cantidad de idiomas que tiene un Servicio*/
   /*
    public function idiomasDisponibles($id){
      $resultado = $this->db
                   ->select('codigo_servicio_id_codigo_servicio as codserv')
                   ->from('servicio')
                   ->where('id_servicio', $id)
                   ->get()
                   ->row_array();

      $resultado2 = $this->db
                   ->select('id_servicio,titulo_pagina,pais')
                   ->from('servicio')
                   ->where('servicio.codigo_servicio_id_codigo_servicio', $resultado['codserv'])
                   ->join('idioma', 'idioma.id_idioma = servicio.idioma_id_idioma')
                   ->get()
                   ->result_array();       
   
      return $resultado2;
   }*/
   /*buscar id de prodcuto y extraer algunos datos para clonar algunas partes de idiomas relacionados*/
   public function buscarCodigoProducto($idproducto){
      //$this->db->select('producto.id_producto,codigo_producto,hora_inicio,duracion,precio_persona,precio_edad,ciudad_cercana,aeropuerto_cercano,config_form, url_servicio, idioma.pais')
      
      $this->db->select('producto.id_producto,codigo_producto,hora_inicio,duracion,zona_horaria,ciudad_cercana,aeropuerto_cercano, url_servicio, idioma.pais,idioma.id_idioma,codigo_servicio_id_codigo_servicio as id_codigo_servicio,requerir_disponibilidad,politicas_producto,porcentaje_adelanto')
               ->from('producto')
               ->where('id_codigo_producto', $idproducto)->where('codigo_servicio.id_usuarios',$this->id_user_actual)->limit(1)
               ->order_by("id_producto", "asc")
               //->join('precio', 'precio.id_producto = producto.id_producto')
               ->join('servicio', 'servicio.id_servicio = producto.id_servicio')
               ->join('codigo_servicio', 'codigo_servicio.id_codigo_servicio = servicio.codigo_servicio_id_codigo_servicio')
               ->join('idioma', 'idioma.id_idioma = servicio.idioma_id_idioma');
      $consulta = $this->db->get();
      if($consulta->num_rows()){
        $resultado = $consulta->row_array();
        $resultado['galeria'] = $this->db->select('galeria_has_producto.id_galeria,url_archivo')
               ->from('galeria_has_producto')
               ->where('galeria_has_producto.id_producto', $resultado['id_producto'])
               ->order_by('id_galeria_has_producto','asc')
               ->join('galeria', 'galeria.id_galeria = galeria_has_producto.id_galeria')
               ->get()->result_array();
        //buscar precios
        $resultado['precios_full'] = $this->getPrecios($resultado['id_producto']);
      }
      else $resultado = false;
      
      return $resultado;
   }
   /* fin buscar id de prodcuto y extraer algunos datos*/
  function get_productos_by_id_servicio($id_servicio){
    return $this->db->query("SELECT * FROM producto as p WHERE p.id_servicio = '".$id_servicio."';")->result_array();   
  }
  function get_all_productos_for_disponibilidad(){
    //return $this->db->query("SELECT * FROM producto WHERE 1 = 1;")->result_array();      
    return $this->db->query("SELECT p.* FROM codigo_servicio as cs JOIN servicio as s ON cs.id_codigo_servicio = s.codigo_servicio_id_codigo_servicio JOIN producto as p ON p.id_servicio = s.id_servicio AND cs.id_usuarios = ".$this->session->userdata("id_usuarios")." ;")->result_array();
  }

  function getTabProducto($id){
    $response = array();
    $response = $this->db->query("SELECT t.mapa_tab FROM tab as t WHERE t.producto_id_producto = '".$id."';")->row_array();
    if (count($response) > 0 ) {
      return trim($response['mapa_tab']);
    }else{
      return array();
    }
  }

  function getGrupoProductos($id_codigo_producto){
      $response  = array();
      $response  = $this->db->query("SELECT id_producto,id_codigo_producto,id_servicio, titulo_producto FROM producto WHERE id_codigo_producto = '".$id_codigo_producto."';")->result_array();
      if ( count($response) != 0 ) {
        return $response;
      }else{
        return array();
      }
  }
  function getNextCodigoProducto($language,$idServicio){
    $token = null;
    $digito = 0;
    /*
    $response = $this->db->query("SELECT cs.id_codigo_servicio, cs.codigo_servicio,s.id_servicio,s.ubicacion_servicio, i.codigo,p.id_producto,p.codigo_producto,p.fecha FROM codigo_servicio as cs JOIN servicio as s ON cs.id_codigo_servicio = s.codigo_servicio_id_codigo_servicio JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma JOIN producto as p ON p.id_servicio = s.id_servicio AND s.codigo_servicio_id_codigo_servicio = (SELECT s.codigo_servicio_id_codigo_servicio FROM servicio as s JOIN producto as p ON s.id_servicio = p.id_servicio AND p.id_producto = '".$idProducto."' ) ORDER BY p.fecha DESC LIMIT 1;")->row_array();

    if (!empty( $response['codigo_producto'] )) {
      $token      = str_replace( ",","",strtoupper(trim($response['ubicacion_servicio'])) );
      $arrayToken = explode(" ",$token);
      $token      = $arrayToken[0];
      $digito     = intval(preg_replace('/[^0-9]+/', '', $response['codigo_producto']), 10);
      $digito     = ( (Integer)$digito )+1;
      $token      = $token.$digito;
    }
    */
    /*
    $response = $this->db->query("SELECT i.id_idioma,i.codigo,i.pais, s.id_servicio,s.codigo_servicio_id_codigo_servicio as id_codigo_servicio, s.ubicacion_servicio,p.id_producto,p.codigo_producto FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma LEFT JOIN producto as p ON s.id_servicio = p.id_servicio AND i.codigo = '".strtoupper($language)."' AND s.id_servicio = '".$idServicio."' ORDER BY p.codigo_producto DESC LIMIT 1;")->row_array();
    
    if (!empty( $response['codigo_producto'] )) {
      $token      = str_replace( ",","",strtoupper(trim($response['ubicacion_servicio'])) );
      $arrayToken = explode(" ",$token);
      $token      = $arrayToken[0];
      $digito     = intval(preg_replace('/[^0-9]+/', '', $response['codigo_producto']), 10);
      $digito     = ( (Integer)$digito )+1;
      $token      = strtoupper($language).$token.$digito;       
    }else{
      $response   = $this->obtenerDatosServicio($idServicio);
      $token      = str_replace( ",","",strtoupper(trim($response['ubicacion_servicio'])) );
      $arrayToken = explode(" ",$token);
      $token      = $arrayToken[0];
      $digito     = ( (Integer)$digito )+1;
      $token      = strtoupper($language).$token.$digito;
    }
    */
    $response = $this->db->query("SELECT COUNT(p.id_producto) as cantidad FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".trim(mb_strtoupper($language))."' JOIN producto as p ON p.id_servicio = s.id_servicio;")->row_array();
    if (!empty($response['cantidad']) ) {
        $digito     = ( (Integer)$response['cantidad'] )+1;
        $token      = strtoupper($language).str_pad($digito,3,'0',STR_PAD_LEFT);
    }else{
        $token      = strtoupper($language).str_pad(1,3,'0',STR_PAD_LEFT);
    }
    return $token;
    //return $response;
    //return "CODE002";
  }
  function obtenerDatosServicio($idServicio){
    return $this->db->query("SELECT i.id_idioma,i.codigo,i.pais,s.id_servicio,s.ubicacion_servicio FROM idioma as i JOIN servicio as s ON i.id_idioma = s.idioma_id_idioma AND s.id_servicio = '".$idServicio."';")->row_array();
  }

  //retorna todas las actividades segun idioma.
  function get_actividades_asociadas_destino($lang,$idDestino,$idCodigoDestino){
    return $this->db->query("SELECT i.id_idioma,i.codigo, p.id_producto,p.titulo_producto,p.ciudad_cercana,p.id_codigo_producto,dhp.id_destino as destino_asociado,dhp.id_producto as actividad_asociado,dest.id_destino FROM destino as dest JOIN destino_has_producto dhp ON dest.id_destino = dhp.id_destino AND dest.id_destino = '".$idDestino."' RIGHT JOIN producto as p ON p.id_producto = dhp.id_producto JOIN servicio as s ON s.id_servicio = p.id_servicio JOIN idioma as i ON i.id_idioma = s.idioma_id_idioma AND i.codigo = '".trim($lang)."' ORDER BY dhp.id_producto DESC;")->result_array();
  }
  ///////////////////////////////copiar precios/////////////////////////////////////////
  public function copiar_precios($id_producto,$codigo_producto){
      //$this->db->select('producto.id_producto,codigo_producto,hora_inicio,duracion,precio_persona,precio_edad,ciudad_cercana,aeropuerto_cercano,config_form, url_servicio, idioma.pais')
      
     $id_productos = $this->db->query("SELECT id_producto FROM producto WHERE id_codigo_producto = $codigo_producto AND id_producto != $id_producto")->result_array();
               //->join('precio', 'precio.id_producto = producto.id_producto')
     $resultados_precios_detalles = $this->db->query("SELECT * FROM detalle_precio WHERE id_producto=$id_producto")->result_array();

    foreach($id_productos as $idproducto){

      $this->db->delete('detalle_precio', array('id_producto' => $idproducto['id_producto']));

      foreach($resultados_precios_detalles as $detalles_precio){
        $this->db->query("INSERT INTO detalle_precio (id_producto, id_etapa_edad, id_nacionalidad,edad_minimo,edad_maximo,rangos) VALUES ({$idproducto['id_producto']},{$detalles_precio['id_etapa_edad']},{$detalles_precio['id_nacionalidad']}, {$detalles_precio['edad_minimo']}, {$detalles_precio['edad_maximo']}, '{$detalles_precio['rangos']}')");

        $last_id = $this->db->insert_id();
        $precios = json_decode($detalles_precio['rangos'],true);

        foreach ($precios['desde'] as $clave => $valor) {
            for($i=(int)$valor;$i<=(int)$precios['hasta'][$clave];$i++){
                $this->db->query("INSERT INTO precios (cantidad, monto, id_detalle_precio) VALUES ($i, {$precios['precio'][$clave]}, $last_id)");
            }
        }
      }
    }
  // echo $this->db->error;
      return $this->db->insert_id();
   }
   public function copiar_adelanto($id_producto,$codigo_producto){
    $porcentaje_adelanto = $this->db->query("SELECT porcentaje_adelanto FROM producto WHERE id_producto = $id_producto")->row_array();

    $datos['porcentaje_adelanto'] = $porcentaje_adelanto['porcentaje_adelanto'];
    $this->db->where('id_codigo_producto', $codigo_producto)->update('producto', $datos);
    return $this->db->affected_rows();
   }
}