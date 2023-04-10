<div class="container-fluid">
    <div class="headline">
        <div>Lista de servicios</div>
    </div>
    <div class="col-md-12 row">
        <div class="pull-right">
            <a href="<?php echo site_url('admin/servicio/add/'); ?>" class="btn btn-success"><span class="fa fa-plus"></span> <strong>Crear un nuevo servicio</strong></a> 
        </div>
    </div>
     <!-- <?=json_encode($servicios);?> -->
    <div  class="col-md-12  div-contenedor container-fluid" id="users">
    <input class="search" placeholder="Search" />
      <button class="sort" data-sort="name">Buscar servicio</button>
    <div class="col-md-12 header-list hidden-xs hidden-sm">
        <div>
            <div class="col-md-8">SERVICIO - PAGINA WEB</div>
            <div class="col-md-3 text-center">#ACTIVIDADES ASOCIADAS</div>
            <div class="col-md-1 text-center">OPCIONES</div>
        </div>
    </div>
        <div class="container-fluid div-contenedor-lista list" style="padding: 0;">
        <?php 
                $increment2 = 1;
                $increment_idiomas=0;
                $comentarios="";
                $contenito_div="";
                $div_colapse="";
                $icon_down=' ';
                foreach($servicios as $s2){ 
                    $rowspan2 = count($s2['group_pages']);
                    $inicio=true;
                    $div_abrir='<div  class=" col-md-12 container-fluid" style="padding: 0;">';
                            // $div_abrir="";
                    $div_cerrar='</div>';
                            // $div_cerrar="";
                    foreach ($s2['group_pages'] as $key => $value) {
                        if ($inicio) {
                            $div_colapse='<div class=" div_colapse col-md-12 container-fluid" style="padding:0;">'.
                            '<div class="col-md-6 col-xs-8">'.
                            $increment2.". ".mb_strtoupper ($value['titulo_pagina']).
                            '</div>'.
                            '<div class="text-right col-md-6 col-xs-4 " style="padding:0;">'.
                                '<div class="btn-group">'.
                                '<a title="Agregar servicio en Nuevo Idioma" href="'.site_url('admin/servicio/add/'.$value['codigo_servicio_id_codigo_servicio']).'" class=" btn btn-success btn-sm"><span class="fa fa-plus"></span><span class="hidden-xs"> Agregar servicio en otro idioma</span></a>
                                <a href="javascript:void(0)" class="div_derecha btn btn-danger btn-sm btn-eliminar-todas-las-paginas-web" data-id="'.$value['codigo_servicio_id_codigo_servicio'].'"><span class="fa fa-close"></span></a>'.
                                '</div>'.
                            '</div>'.
                            '</div>';
                            $inicio=false;  
                        }else{
                            $div_colapse='';
                        }
                            
                        $cant_comentarios = '';
                        $url = str_replace(' ', '', base_url().'assets/galeria/slider/'.$value['imagen_principal']);
                        if ( !empty( $value['reviews'] ) ) {
                            $comentarios  = json_decode( $value['reviews'],true );
                            $cant_comentarios=count($comentarios['items']).' <span class="fa fa-commenting-o" title="Comentarios"></span>';
                        }else{
                            $cant_comentarios='0  <span class="fa fa-commenting-o" title="comentarios"></span>';
                            
                        }
                        /*$html_paquetes = '';                  
                        $div_colapse_paquetes='';
                        foreach ($value['paquetes'] as $k => $valpaquete) {
                                                
                            $html_paquetes .= '<div class="col-md-12 div-contenedor-line" style="padding-left: 1%;">'.
                                    '<div class="col-md-6 col-xs-7"><span class="fa fa-chevron-right" style="color:#5cb85c;"></span>'.
                                    ucwords(mb_strtolower($valpaquete['titulo_producto'])).
                                    '</div>'.
                                    '<div class="col-md-6 col-xs-5 text-right">'.
                                    '<div class="btn-group">'.
                                    '<a href="'.base_url().'admin/productos/editar/'.$valpaquete['id_producto'].'/'.strtolower($value['codigo']).'" class="btn btn-info btn-sm" title="Editar Paquete"><span class="fa fa-pencil"></span></a>'.
                                    '<a href="javascript:void(0)" class="btn btn-warning btn-sm btn-agregar-categoria" data-id="'.$valpaquete['id_producto'].'" data-idioma="'.$value['id_idioma'].'"><span class="fa fa-tags"></span></a>'.
                                    '<a href="" class="div_derecha btn btn-danger btn-sm btn-eliminar-paquete-web" data-id="'.$valpaquete['id_producto'].'"><span class="fa fa-close"></span></a>'.
                                    '</div>'.
                                    '</div>'.
                                    '</div>';
                        }
                        */
                        $div_cantidad_paquetes=0;
                        if (count($value['paquetes'])>0) {
                            $div_cantidad_paquetes='<a href="'.site_url('admin/productos/ver/'.$value['id_servicio']).'"><label  class="btn btn-info btn-sm" title="Ver actividades asociadas" ><span class="">'.count($value['paquetes']).' </span> Actividades</span></label></a>';
                            /*$div_colapse_paquetes='<div id="demo'.$increment2.$increment_idiomas.$rowspan2.'" class="col-md-12 collapse" style="padding:0;">'.$html_paquetes.
                                '</div>';*/
                        }else
                        {
                            $div_cantidad_paquetes='<a href="" title="Ver actividades asociadas"><label ><span class="text-center">'.count($value['paquetes']).' </span> Actividades</label></a>';
                            $div_colapse_paquetes='';
                            $icon_down='';
                        }
                        $bandera='';
                        if(strtolower($value['codigo'])=='en'){
                        $bandera='us';  
                        }else{
                            $bandera=strtolower($value['codigo']);
                        }
                        /*crear opciones para del debido copiado*/
                        //if(!$key){
                               $clon_options = null;
                               if(count($s2['group_pages'][0]['paquetes'])){
                                    foreach($s2['group_pages'][0]['paquetes'] as $paquete)$clon_options.='<li><a href="'.site_url('admin/productos/agregar/'.$value['id_servicio']).'/'.$paquete['id_codigo_producto'].'">'.$paquete['titulo_producto'].'</a></li>';
                               }
                        //}
                        /*fin de crear opciones de copiado */
                        $contenito_div=$contenito_div.$div_abrir.$div_colapse.'<div class="name container-fluid form-control col-md-12  div-contenedor-line">'.
                                '<div class=" col-md-8 col-xs-12" data-toggle="collapse" data-target="#demo'.$increment2.$increment_idiomas.$rowspan2.'" style="cursor: pointer;"><div style="">'.$icon_down.'<span class="flag flag-'.$bandera.'" title="'.ucwords(mb_strtolower($value['pais'])).' [CLICK PARA VER PÁGINA]"></span><a title="'.$value['titulo_pagina'].'" href='.$value['url_web'].' target="_blank">  <b>'.$value['url_web'].'</b></a>'.($key?'<div class="dropdown pull-right">
                                      <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" title="Copiar detalles importantes desde el idioma espa&ntilde;ol para crear nueva actividad"><i class="fa fa-window-restore" aria-hidden="true"></i>
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">'.$clon_options.'
                                      </ul>
                                    </div>':null).'</div>'.//$increment2.$increment_idiomas.$rowspan2.''.
                                '</div>'.
                                '<div class="col-md-2 col-xs-6 text-center" style="padding:0">'.
                                $div_cantidad_paquetes.
                                '</div>'.                           
                                '<div class="text-right col-md-2 col-xs-6">'.
                                '<div class="btn-group">'.
                                '<a href="'.site_url('admin/servicio/edit/'.$value['id_servicio']).'" class="btn btn-info btn-sm" title="Editar este servicio"><span class="fa fa-pencil"></span></a>'. 
                                '<a href="'.site_url('admin/productos/agregar/'.$value['id_servicio']).'" class="btn btn-success btn-sm" title="Agregar actividad turística"><span class="fa fa-plus"></span></a>'.
                                '<a href="javascript:void(0);" class="btn btn-warning btn-sm btn-notificacion" title="Crear Notificación" data-id="'.$value['id_servicio'].'" data-lang="'.$value['pais'].'"><span class="fa fa-exclamation-triangle"></span></a>'.
                                '<a href="" class="btn btn-danger btn-sm btn-eliminar-pagina-web" data-id="'.$value['id_servicio'].'" title="Eliminar este servicio"><span class="fa fa-close"></span></a>'.
                                '</div>'.
                                '</div>'.                           
                            '</div>'/*.$div_colapse_paquetes*/;
                            
                        if ($increment_idiomas==0) {
                                $div_colapse="";
                                $div_abrir="";
                                $contenito_div=$contenito_div;
                            }
                            
                            if ($increment_idiomas+1==$rowspan2) {
                                
                                $contenito_div=$contenito_div.$div_cerrar;
                            }
    
                        ?>  
                            <?php
                            $increment_idiomas++;
                    }
                    $increment_idiomas=0;
                    $increment2++;
                }
                echo $contenito_div;
            ?>
        </div>
        <ul class="pagination hidden"></ul>
<ul class="pagination">
    <li class="firstlist">
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li class="prev"><a href="#">prev</a></li>
    <li class="value"><a class="text" href="#">1</a></li>
    <li class="next"><a href="#">next</a></li>
    <li class="endlist">
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</div>

<style>
    .div-contenedor{
        padding: 0;
    }
.div-contenedor-lista>div:nth-child(even) { background: #eeeeee; }
.div-contenedor-line{
    line-height: 31px;
    padding: 0;
border-color: #ddd;
border-style: solid solid solid solid;
border-width: 0px 1px 1px 1px;
    }

.div_colapse{
    background: rgba(51, 51, 51, 0.75);
    color: #fff;
}
.div_colapse_paquetes{
    /* background: rgba(165, 196, 223, 0.42); */
    color: #1f6db1;
}
.name:hover{
    background: #ddd;
}
</style>



<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
              <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
  </div>

    <div class="modal fade" id="modal-categoria" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title modal-title-categoria"><span class="fa fa-tags text-success"></span> ASOCIAR CATEGORIA</h4>
            </div>
            <div class="modal-body modal-body-categoria">
              <p><strong>Loading...!</strong></p>
            </div>
            <div class="modal-footer modal-footer-categoria">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>          
        </div>
    </div>
    <div class="modal fade" id="modal-notificacion" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title modal-title-categoria text-center"><strong><span class="fa fa-tags text-success"></span> CREAR NOTIIFICACION - <span id="spn_lang"></span></strong></h4>
            </div>
            <div class="modal-body modal-body">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#add_notification"><strong>Nuevo</strong></a></li>
                  <li><a data-toggle="tab" href="#list_notification"><strong>Notificaciones</strong></a></li>
                </ul>
                <div class="tab-content">
                    <div id="add_notification" class="tab-pane fade in active">
                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                        <label for="FechaInicio">Fecha Inicio</label>
                        <input type="text" class="form-control" id="txt_fecha_inicio_notificacion" aria-describedby="Fecha Inicio" placeholder="Dia/Mes/Año">
                        <small id="fecha_inicio_notificacion" class="form-text text-muted">Seleccione la fecha de inicio de la Notificación</small>
                        <input type="hidden" class="form-control" id="txt_id_servicio_notificacion" aria-describedby="" placeholder="">
                        
                      </div>
                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                        <label for="FechaFin">Fecha Fin</label>
                        <input type="text" class="form-control" id="txt_fecha_fin_notificacion" aria-describedby="" placeholder="Dia/Mes/Año">
                        <small id="fecha_fin_notificacion" class="form-text text-muted">Seleccione la fecha de fin de la Notificación</small>
                      </div>
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <label for="ContenidoNotificacion">Contenido de la Notificación</label>
                        <textarea class="form-control" id="txtr_contenido_notificacion" aria-describedby=""></textarea>
                        <small id="fecha_fin_notificacion" class="form-text text-muted">Escribe el contenido de la Notificación</small>
                      </div>
                    </div>
                    <div id="list_notification" class="tab-pane fade">
                        <div class="container-fluid">
                            <ul class="list-group" id="list-notifications">

                            </ul>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-footer">
              <button type="button" class="btn btn-success" id="btn-guardar-notificacion">GUARDAR</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            </div>
          </div>          
        </div>
    </div>

<script type="text/javascript">
    /* MODAL THUMBAIL IMG */
    $(".modal-img").click(function(){
        $('.modal-body').empty();

        var img = $(this).data('img');
        console.log(img);
        $('.modal-body').html('<img src="'+img+'" class="img-thumbnail">');
        $('#myModal').modal({show:true});
    });

    jQuery(document).ready(function($) {
        /*
        CKEDITOR.replace( 'txtr_contenido_notificacion',{
            toolbar : [

                    ['Styles', 'Format','Font','FontSize'],
                    ['TextColor','BGColor'],
                    ['Bold', 'Italic','Underline','Strike','-','Subscript','Superscript', '-','NumberedList','BulletedList','Outdent','Indent','Blockquote'],
                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                    ['Link','Unlink','Anchor'],
                    ['Image','Table','HorizontalRule','Smiley','PageBreak','Templates','Source']
        ]
        } );
        CKEDITOR.add 
        */
        $('#txt_fecha_inicio_notificacion').datepicker(
            {
                dateFormat:'dd-mm-yy',
                changeMonth: true,
                minDate: 0,
                onSelect: function(selectedDate){
                    $("#txt_fecha_fin_notificacion").datepicker("option", "minDate", selectedDate);
                }
            }
        );
        $('#txt_fecha_fin_notificacion').datepicker(
            {
              dateFormat:'dd-mm-yy',
              changeMonth: true,
              minDate: 0,
            }
        );

        $(document).on('click', '.btn-eliminar-pagina-web', function(event) {
            event.preventDefault();
            var id_delete  =  $(this).data('id');
            swal({
              title: "Estas seguro de eliminar esta página..?",
              text: "Si eliminas este servicio tambien se eliminaran automaticamente los paquetes turísticos que contiene.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/servicio/remove/';?>'+parseInt(id_delete),
                    type: 'DELETE',
                    dataType: 'json',
                    data: {},
                }).done(function(data) {
                    if ( data.response === 'OK' ) {
                        //$('.btn-eliminar-pagina-web').parent().parent().remove();
                        swal("Confirmación","Se ha eliminado correctamente..!","success");
                        location.reload();
                    }else{
                        swal("Oops..!","No se ha podido eliminar, Intente nuevamente por favor..!","error");
                    }
                    console.log(data);
                }).fail(function(e) {
                    console.log(e.responseText);
                });
            });
        });
        $(document).on('click', '.btn-eliminar-todas-las-paginas-web', function(event) {
            event.preventDefault();
            var id_delete  =  $(this).data('id');
            console.log(id_delete);
            swal({
              title: "Estas seguro de eliminar el grupo de páginas..?",
              text: "Si eliminas este grupo de servicios ya no aparecerán en internet ni en sus versiones en idiomas.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/codigoservicio/remove/';?>'+parseInt(id_delete),
                    type: 'DELETE',
                    dataType: 'json',
                    data: {},
                }).done(function(data) {
                    if ( data.response === 'OK' ) {
                        //$('.btn-eliminar-pagina-web').parent().parent().remove();
                        swal("Confirmación","Se ha eliminado correctamente..!","success");
                        location.reload();
                    }else{
                        swal("Oops..!","No se ha podido eliminar, Intente nuevamente por favor..!","error");
                    }
                    console.log(data);
                }).fail(function(e) {
                    console.log(e.responseText);
                });
            });
        });
        $(document).on('click', '.btn-eliminar-paquete-web', function(event) {
            event.preventDefault();
            var id_delete  =  $(this).data('id');
            console.log(id_delete);
            swal({
              title: "Estas seguro de eliminar este Paquete Turístico..?",
              text: "Si eliminas este servicio tambien se eliminaran automaticamente de la lista de Actividades.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/productos/remove/';?>'+parseInt(id_delete),
                    type: 'DELETE',
                    dataType: 'json',
                    data: {},
                }).done(function(data) {
                    if ( data.response === 'OK' ) {
                        //$('.btn-eliminar-pagina-web').parent().parent().remove();
                        swal("Confirmación","Se ha eliminado correctamente..!","success");
                        location.reload();
                    }else{
                        swal("Oops..!","No se ha podido eliminar, Intente nuevamente por favor..!","error");
                    }
                    console.log(data);
                }).fail(function(e) {
                    console.log(e.responseText);
                });
            });
        });
        
        $(document).on('click', '.btn-agregar-categoria', function(event) {
            event.preventDefault();
            var id_paquete = $(this).data('id');
            var idioma     = $(this).data('idioma');
            console.log(id_paquete+" - "+idioma);

            $.ajax({
                url: '<?=base_url().'admin/categoria/get_categoria_json'?>',
                type: 'POST',
                dataType: 'json',
                data: {id: id_paquete,language:idioma},
            }).done(function(data) {
                console.log(data);
                var html_categoria  = '<ul class="list-group">';
                $.each(data, function(index, val) { 
                    //console.log(val);
                    html_categoria += '<li class="list-group-item">'+val.nombre_categoria+'<span class="loading-asociar-categoria"></span><span class="pull-right"><input type="checkbox" name="chkbx_categoria" '+val.producto_id_producto+' id="chkbx_categoria" name="chkbx_categoria" data-categoria="'+val.id_categoria+'" data-paquete="'+id_paquete+'"></span></li>';
                }); 
                html_categoria += "</ul>";
                $('.modal-body-categoria').empty().append(html_categoria);
            }).fail(function(e) {
                console.log(e.responseText);
            });
            $('.modal-body-categoria').html(id_paquete + " - " + idioma);
            $('#modal-categoria').modal({show:true});
        });

        $(document).on('change', '#chkbx_categoria', function(event) {
            event.preventDefault();
            var categoria = $(this).data('categoria');
            var paquete   = $(this).data('paquete');
            var checked   = 0;
            var url_server= '<?=base_url().'admin/categoria/delete_categoria_producto';?>';
            if ($(this).is(':checked') ) {
                checked = 1;
                url_server = '<?=base_url().'admin/categoria/add_categoria_producto';?>';
            } 
            $.ajax({
                url: url_server,
                type: 'POST',
                dataType: 'json',
                data: {id_categoria: categoria,id_paquete: paquete},
            }).done(function(data) {
                console.log(data);
            }).fail(function(e) {
                console.log(e.responseText);
            });
            console.log("Categoria "+categoria+" - Paquete "+paquete + " - Checked " + checked);
        });

        $(document).on('click', '.btn-notificacion', function(event) {
            event.preventDefault();
            var id_servicio = $(this).data('id');
            var lang        = $(this).data('lang');
            $("#spn_lang").empty().text(lang);
            $("#txt_id_servicio_notificacion").empty().val(id_servicio);
            //console.log("ID: "+id_servicio+"  LANG: "+lang);
            list_notifications(id_servicio);
            $('#modal-notificacion').modal({show:true});
        });
        $(document).on('click', '#btn-guardar-notificacion', function(event) {
            event.preventDefault();
            var id_servicio  = $("#txt_id_servicio_notificacion").val();
            var fecha_inicio = $("#txt_fecha_inicio_notificacion").val();
            var fecha_fin    = $("#txt_fecha_fin_notificacion").val();
            //var descripcion  = CKEDITOR.instances['txtr_contenido_notificacion'].getData();
            var descripcion  = $("#txtr_contenido_notificacion").val();
            if ( (fecha_inicio.trim()).length === 0 ) {
                $("#txt_fecha_inicio_notificacion").focus();
                return false;
            }
            if ( (fecha_fin.trim()).length === 0 ) {
                $("#txt_fecha_fin_notificacion").focus();
                return false;
            } 
            if ( (fecha_inicio.trim()).length === 0 ) {
                $("#txtr_contenido_notificacion").focus();
                return false;
            }

            $.ajax({
                url: '<?=base_url();?>admin/notificacion/add',
                type: 'POST',
                dataType: 'JSON',
                data: {id: id_servicio,f_inicio: fecha_inicio,f_fin: fecha_fin,descripcion: descripcion},
            }).done(function(data) {
                console.log(data);
                if ( data['response'] === 'OK') {
                    $("#txt_id_servicio_notificacion").val('');
                    $("#txt_fecha_inicio_notificacion").val('');
                    $("#txt_fecha_fin_notificacion").val('');
                    $("#modal-notificacion").modal('hide');
                }else{
                    swal("ERROR",data['message'],"error");
                }
            }).fail(function(e) {
                console.log(e.responseText);
            }); 
        });
        $(document).on('click', '.btn-eliminar-notificacion', function(event) {
            event.preventDefault();
            var object = $(this);
            var id_servicio     = $(this).data('servicio');
            var id_notificacion = $(this).data('notificacion');
            //console.log(id_servicio + ' - ' + id_notificacion);
            $.ajax({
                url: '<?=base_url();?>admin/notificacion/remove',
                type: 'POST',
                dataType: 'JSON',
                data: {id_servicio: id_servicio,id_notificacion: id_notificacion },
            }).done(function(data) {
                if (data['response'] === 'OK' ) {
                    $(object).parent().parent().remove();
                }
            }).fail(function(e) {
                console.log(e.responseText);
            });
        });
    });

function list_notifications(id_servicio){
    $.ajax({
        url: '<?=base_url();?>admin/notificacion/list_notifications',
        type: 'POST',
        dataType: 'JSON',
        data: {id: id_servicio},
    }).done(function(data) {
        var html_notificacion  ='';
        $.each(data, function(index, val) {
            html_notificacion += '<li class="list-group-item"><span class="fa fa-check text-success"></span> '+val['fecha_inicio']+ ' - '+ val['fecha_fin']+ ': <strong>' +val['notificacion']+'</strong><span class="pull-right"><span class="btn btn-danger btn-xs btn-eliminar-notificacion" data-servicio="'+val['id_servicio']+'" data-notificacion="'+val['id_notificacion']+'" title="Eliminar Notificación"><i class="fa fa-close"></i></span></span></li>';
        });
        $("#list-notifications").empty().append(html_notificacion);
    }).fail(function(e) {
        console.log(e.responseText);
    });
    
}
</script>