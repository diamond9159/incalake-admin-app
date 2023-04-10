<div class="container-fluid">
    <div class="">
            <div class="headline">
            <div><span class="fa fa-list btn-success"></span> LISTA DE CATEGORIAS PARA TODOS LOS IDIOMAS</div>
            </div>
        <!-- <h2 class="text-center"><span class="fa fa-list"></span> LISTA DE CATEGORIAS PARA TODOS LOS IDIOMAS</h2><hr/> -->
        <div class="pull-right">
            <a href="<?php base_url(); ?>categoria/add" class="btn btn-success" title="Agregar Nueva Categoria"><strong><span class="fa fa-plus"></span> AGREGAR</strong></a> 
        </div>
        <?php
            //echo json_encode($data);
        ?>
    <div id="users">
      <input class="search" placeholder="Search" />
      <button class="sort" data-sort="name">
        Buscar
      </button>
        <!-- IMPORTANT, class="list" have to be at tbody -->
        <div class="col-md-12 header-list text-center">
        <div class="col-md-12 hidden-xs">
            <div class="col-md-1 col-sm-1 text-center">#</div>
            <div class="col-md-3 col-sm-3">CATEGORIA</div>
            <div class="col-md-6 col-sm-6">DESCRIPCION</div>
            <div class="col-md-2 col-sm-2">OPCIONES</div>
        </div>
        </div>
        
        <div class="list">
            <?php 
            if ( !empty($data) ) {
                $i = 1;
                $id_codigo_categoria = 0;

                foreach($data as $key => $value){ 
                    $html_nombre_categoria = '';
                    $html_descripcion_categoria ='';
                    $html_id_codigo_categoria  ='';
                    /*
                    foreach ($value as $k => $v) {
                        $html_nombre_categoria .= '<p class="name"><strong>'.$v['codigo'].': </strong>'.$v['nombre_categoria'].'</p>';
                        $html_descripcion_categoria .= '<p><strong>'.$v['codigo'].': </strong>'.$v['descripcion_categoria'].'</p>';
                        $html_id_codigo_categoria = $v['id_codigo_categoria'];
                    }
                    */
                    $html_nombre_categoria .= '<p class="name"><strong>'.($value[0]['pais'] ? $value[0]['pais'] : $value[1]['pais']).'(<small>'.($value[0]['codigo'] ? $value[0]['codigo'] : $value[1]['codigo']).'</small>): </strong>'.($value[0]['nombre_categoria'] ? $value[0]['nombre_categoria'] : $value[1]['nombre_categoria']).'</p>';
                    $html_descripcion_categoria .= '<p><strong>'.($value[0]['pais'] ? $value[0]['pais'] : $value[1]['pais']).'(<small>'.($value[0]['codigo'] ? $value[0]['codigo'] : $value[1]['codigo']).'</small>): </strong>'.($value[0]['descripcion_categoria'] ? $value[0]['descripcion_categoria'] : $value[1]['descripcion_categoria']).'</p>';
                        $html_id_codigo_categoria = $value[0]['id_codigo_categoria'];
                ?>
                    <div class="col-md-12 ">
                        <div class="col-md-12 born lista">
                            <div class="col-md-1 col-sm-1 text-center"><?=$i++;?></div>
                            <div class="col-md-3 col-sm-3"><?=$html_nombre_categoria;?></div>
                            <div class="col-md-6 col-sm-6"><?=$html_descripcion_categoria;?></div>
                            <div class="col-md-2 col-sm-2 text-center">
                                <div class="btn-group">    
                                    <!-- <?php echo base_url('admin/categoria/traduccion/'.$html_id_codigo_categoria); ?> -->
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm btnVerCategoria" title="Traducciones Categoria" data-toggle="modal" data-target="#modalVerCategoria" data-id="<?=$html_id_codigo_categoria?>"><span class="fa fa-list"></span></a>
                                    <a href="<?php echo base_url('admin/categoria/edit/'.$html_id_codigo_categoria); ?>" class="btn btn-info btn-sm" title="Editar Categoria"><span class="fa fa-pencil"></span></a>
                                    <a href="<?php //echo site_url('admin/categoria/remove/'.$id_codigo_categoria); ?>" class="btn btn-danger btn-eliminar-categoria btn-sm" data-id="<?=$html_id_codigo_categoria;?>" title="Eliminar Categoria"><span class="fa fa-close"></span></a> 
                                </div>
                            </div>
                        </div>  
                    </div>
                <?php } ?>
            <?php } ?>
        </div> 
        <div class="text-center">   
            <ul class="pagination"></ul>       
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="modalVerCategoria" tabindex="-1" role="dialog" aria-labelledby="VerCategroia">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel"><span class="fa fa-tag"></span> CATEGORIA</h4>
            </div>
            <div class="modal-body" style="min-height: 12em;">
                <div class="modalLoading" id="modalLoading"></div>
                <div class="modalContent" id="modalContent"></div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-success btnEditarCategoriaGrupo" id="btnEditarCategoriaGrupo" title="Editar Información de la Categoria">EDITAR</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar Modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        new Spinner().spin(document.getElementById("modalLoading"));

        $(document).on('click', '.btn-eliminar-categoria', function(event) {
            event.preventDefault();
            var id_eliminar = $(this).data('id');
            console.log(id_eliminar);
            // swal("Excepción","Los idiomas no se pueden eliminar ya que pueden afectar seriamente a los demas páginas web.","warning");
            swal({
              title: "Estas seguro de eliminar la Categoria...?",
              text: "Eliminar esta categoria a fectará a otras páginas que pertenecen a esta categoria.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Quiero Eliminar!",
              cancelButtonText: "No, Cancelar",
              closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '<?=base_url().'admin/categoria/remove_codigo_categoria/';?>'+parseInt(id_eliminar),
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

        //MUESTRA MODAL DE UNA CATEGORIA CON SUS TRADUCCIONES
        $(document).on('click', '.btnVerCategoria', function(event) {
            event.preventDefault();
            var id = $(this).data("id");
            var modal = null, button = null,html = "";
            $('#modalVerCategoria').on('show.bs.modal', function (event) {
                button = $(event.relatedTarget);
                modal = $(this);
                modal.find('.modal-body>#modalContent').empty(); 
                modal.find('.modal-body>#modalLoading').css('display', 'block');
            });

            $.ajax({
                url: '<?=base_url();?>admin/categoria/categoriasAgrupadas',
                type: 'POST',
                dataType: 'json',
                data: {id:id},
            }).done(function(data) {
                if (data.categoria.length > 0 ) {
                    html = '<div class="list-group">';
                    $.each(data.categoria, function(index, val) {
                        html += '<a href="javascript:void(0);" class="list-group-item">'+
                                    '<h5 class="list-group-item-heading" style="text-transform: uppercase;"><strong>'+val['codigo']+'</strong>: '+val['nombre_categoria']+'</h5>'+
                                    '<p class="list-group-item-text">'+val['descripcion_categoria']+'</p>'+
                                '</a>';
                    });     
                    html += '</div>';
                }else{  html = "<p>No hay traducciones para la categoria.</p>"; }
                $("#modalVerCategoria").find(".modal-body>#modalContent").empty().html(html);
                $("#modalVerCategoria").find('.modal-body>#modalLoading').css('display', 'none');
                var btnEditar = document.getElementById("btnEditarCategoriaGrupo");
                btnEditar.innerHTML = 'EDITAR';
                btnEditar.href = "<?=base_url();?>admin/categoria/edit/"+id;
            }).fail(function(e) {
                $("#modalVerCategoria").find('.modal-body>#modalLoading').css('display', 'none');
                $("#modalVerCategoria").find(".modal-body>#modalContent").empty().html(e.responseText);
                console.log(e.responseText);
            });

        });
    });
</script>
<style type="text/css">
@media (max-width: 700px) {
    .born>div:first-child{
        background: #337ab7;
    color: #fff;
    }
}
    
</style>