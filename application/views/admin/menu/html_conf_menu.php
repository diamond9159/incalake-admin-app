<?php

  $html_edades = null;
  $html_nacionalides = null;

 $lista_servicios = array();
  foreach($lista_datos['lista_servicios'] as $value){
  	$temp_id_cod = $value['id_codigo_servicio'];
  	unset($value['id_codigo_servicio']);
  	$lista_servicios[$temp_id_cod][$value['codigo']] = $value;
  	
  }


 function retornarIdiomas($idiomas,$tipo=true,$values=array()){
 	/*tipo=true: es para traducciones de idiomas nombre, y false para urls idiomas*/
 	$idiomas_html = '<table class="table"><tr><th>#</th><th>Nombre</th><th>URL</th></tr>';
 	foreach($idiomas as $value){
 	//if($value['codigo']=='ES'&&$tipo)continue;
   /* $idiomas_html .= '<li><label>'.$value['pais'].':</label> <input name="idiomas['.$value['codigo'].']" value="'.(@$values[$value['codigo']]).'" type="text"/></li>';*/
    $idiomas_html .= '<tr>
		    <td>'.$value['pais'].'</td>
		    <td><input type="text" data-lang="'.$value['codigo'].'" '.($value['codigo']=='ES'?'readonly':null).' name="nombres['.$value['codigo'].']" class="form-control"></td>
		    <td><input type="text" data-lang="'.$value['codigo'].'" name="urls['.$value['codigo'].']" class="form-control"></td>
		  </tr>';
    }	
    return $idiomas_html.'</table>';
 }
//var_dump(json_decode('{\'en\':"boy","fr":"boyyes"}',true));
//
 //reformatear los resultados para buen procesamiento
  $new_array_links = array();
  foreach($lista_datos['lista_menu'] as $value)$new_array_links[$value['parent_id']][]=$value;
  
?>

<div class="container">
  <div class="col-md-12">
	 <div class="panel panel-default">
	  <div class="panel-heading">

	    Configuraciones del menu 
	    <button onclick="el_modal.modal();resetModal();select_servicio.html(retorna_options_servicio(0));" type="button" class="btn btn-success pull-right" style="margin-top: -7px"><i class="fa fa-plus" aria-hidden="true"></i> Agregar menu principal</button> 
	    <button class="btn btn-info pull-right" data-toggle="modal" data-target="#vistaMenuModal" title="Vista rapida del menu" style="margin-top: -7px;margin-right:3px">
		 <i class="fa fa-eye" aria-hidden="true"></i>
	     Ver menu Actual</button>
	     <button class="btn btn-primary pull-right" id="generarJSON" title="Generar menu para ver cambios" style="margin-top: -7px;margin-right:3px">
		 <i class="fa fa-bars" aria-hidden="true"></i>
	     Generar Menu</button>
	  </div>
	  <div class="panel-body">
	  	<?php
	  	
	  		//
	   $GLOBALS['MENU'] = $new_array_links;
	   $GLOBALS['ID_INICIAL'] = 0;

	   //var_dump(@$GLOBALS['MENU'][1]);
	  	function get_menu_tree($parent_id=0) 
			{ 
				//$colores = array('default','warning','success','info','primary','danger');
			 //global $new_array_links;
			  $menu = "";
			// var_dump($GLOBALS['MENU']);exit;
			  //$sqlquery = " SELECT * FROM menu where status=1 and parent_id='" .$parent_id . "' ";
			

			 if(is_array(@$GLOBALS['MENU'][$parent_id])){
			   foreach($GLOBALS['MENU'][$parent_id] as $key => $value){
			   	$GLOBALS['ID_INICIAL']++;
			   	$cantidad = @count($GLOBALS['MENU'][$value['menu_id']]);
			           /*$menu .="<li class='list-group-item'><a href='".$value['link']."'>".$value['menu_name']."</a>";
			       
			       $menu .= "<ul class='list-group'>".get_menu_tree($value['menu_id'])."</ul>"; //call  recursively
			       
			       $menu .= "</li>";*/
			       $temp_id = 'collapse'.$GLOBALS['ID_INICIAL'];
			 		$menu .= ' <div class="panel panel-default" data-id="'.$value['menu_id'].'" data-parent="'.$value['parent_id'].'" data-relevancia="'.$value['prioridad'].'">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#'.$temp_id.'">
							        <span class="'.$value['icono'].'"></span>
							        '.$value['menu_name'].'</a><span>'.($cantidad?' ('.$cantidad.')':null).'</span>
							        

							        <div class="btn-group pull-right">  
									  <button data-key="'.$key.'"  type="button" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
									  <button type="button" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button>
									  <button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
									</div>
									<div class="pull-right pull-up-down">
							            <span title="Mover arriba" class="fa fa-chevron-circle-up"></span>
							            <span title="Mover abajo" class="fa fa-chevron-circle-down"></span>
							          </div>
									<div style="clear:both"></div>
							      </h4>
							    </div>
							    '.($cantidad?'<div id="'.$temp_id.'" class="panel-collapse collapse">
							      <div class="panel-body">'.get_menu_tree($value['menu_id']).'</div>
							    </div>':null).'
							  </div>';
					
			    }

			  }
			    
			    return $menu;
			} 
			//var_dump(get_menu_tree());
?>

<div class="panel-group">
  <?php echo get_menu_tree();//start from root menus having parent id 0 ?>
  
</div>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Configuraciones del menu</h4>
        </div>
        <div class="modal-body">
         <form id="form_principal">
          <input type="hidden" name="id_menu" value="0" />
          <input type="hidden" name="parent_menu" value="0" />
          <div class="panel panel-default" style="background:#F2F3F7">
		    <div class="panel-body">
		    	<div class="form-inline">
				  <div class="form-group">
				    <label for="nombre_menu">Nombre: </label>
				    <input type="text" class="form-control" size="80" id="nombre_menu" onchange="nombre_es.val($(this).val())" name="nombre_menu" />
				  </div>
				 
				    <div class="btn-group">
                        <button data-selected="graduation-cap" type="button" class="icp-dd btn btn-default dropdown-toggle iconpicker-component" data-toggle="dropdown"> Icono  <i id="fa_icon" class=""></i>
                         <span class="caret"></span>
                        </button>
                       <div class="dropdown-menu"></div>
                    </div>

                   <div class="form-group">
				    <input type="text" title="Color de fondo" value="#FFFFFF"  name="color_menu" />
				  </div>

				  <div class="checkbox">
				  <label class="pull-right"> &nbsp; <i class="fa fa-external-link"></i> Relacionar a un servicio <input type="checkbox" id="check_relacionar" /> </label>
				    <label class="pull-right"> &nbsp; <i class="fa fa-window-restore"></i> Abrir en nueva ventana <input type="checkbox" name="nueva_ventana" value="1" /> </label>
				  </div>
				</div>
		    </div>
		  </div>
            
			<div class="col-md-8" style="padding:0 5px 0 0">
			     <div class="panel panel-primary">
					  <div class="panel-heading">Nombres de menu y respectivos links</div>
					  <div class="panel-body">
				       <?=retornarIdiomas($idiomas,false);?>
				     </div>
				</div>
				
			</div>
			<div class="col-md-4" style="padding:0 0 0 5px">
				   <div class="panel panel-primary">
					  <div class="panel-heading">Relacionar un servicio</div>
					  <div class="panel-body">
					  	<select size="20" disabled class="form-control" name="id_servicio" id="select_servicio">
						  
						</select>
					  </div>

					</div>
			

				

			</div>
			<div style="clear:both"></div>
		 </form>
        </div>
        <div class="modal-footer">
           <!--span class="msj-estado">Estado-- </span-->
           <button class="btn btn-primary" id="btn_guardar">Guardar</button>
           <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
   <script src="<?=base_url()?>/recursos/js/fontawesome-iconpicker.min.js"></script>
   <script>
  	

  	 /*json lista de servicios*/
  	 json_servicios = <?=json_encode($lista_servicios);?>;
  	 json_links = <?=json_encode($new_array_links);?>;

  	 //console.log(json_links);
  	 
  	 $('.icp-dd').iconpicker();
  </script>
  <script src="<?=base_url();?>recursos/js/menu.manager.js"></script>
<style type="text/css">
	#icon-panel-producto{
		display: none;
	}
	.panel-group .panel-heading{
		padding: 5px;
	}
	.panel-group .panel-title > a{
		display: inline-block;
		margin-top:8px;
	}
	.panel-group .panel {
		border:2px solid #256B92;
	}
	.panel-group > .panel .panel{
		border-color:#97BD9B;
	}
	.panel-group > .panel .panel .panel{
		border-color:#CDB8D7;
	}
	.panel-group .btn-group{
		padding:0;
		margin:0;
	}
	@media (min-width: 768px){
		#myModal .modal-lg{
			width: 90%;
		}
	}
	.pull-up-down{
		display:inline-block;
		width:20px;
	}
	.pull-up-down span{
		color:#96A274;
	}
	.pull-up-down span:hover{
		color:#82896C;
	}
</style>


	  </div>
	</div>
  </div>
 </div>


 <!-- inicio del modal de la vista previa -->
<div id="vistaMenuModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:95%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Vista rapida del menu</h4>
      </div>
      <div class="modal-body" style="padding:0">
        <iframe id="menu_frame" src="http://web.incalake.com" style="border:0;width: 100%;height:500px;padding:0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
 <!-- fin del modal de la vista previa -->

