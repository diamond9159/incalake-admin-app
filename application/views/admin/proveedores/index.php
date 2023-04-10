<style type="text/css">
    .prioridad-1{
        background: #cc2e28;
        color: #fff;
    }
    .prioridad-2{
        background: #FF9800;
        color: #fff;
    }
    .prioridad-3{
        background: #FFEB3B;
        color: #fff;
    }
    .prioridad-4{
        background: #8BC34A;
        color: #fff;
    }
    .prioridad-5{
        background: #009688;
        color: #fff;
    }

</style>
<div id="test-list">
    <div class="col-md-12" style="padding: 0;">
        <div class="col-md-6"><input type="text" class="search form-control" /></div>
        <div class="col-md-6 text-right"> <span class="btn btn-success btn_modal_proveedor">Agregar proveedor</span></div>
    </div>
    
    <div class="col-md-12 header-list text-white">
        <div class="col-md-1 text-center">N°</div>
        <div class="col-md-3 text-center">RAZON SOCIAL / NOMBRE</div>
        <div class="col-md-2 text-center">CELULAR</div>
        <div class="col-md-1 text-center">PRIORIDAD</div>
        <div class="col-md-3 text-center">CATEGORIA</div>
        <div class="col-md-2 text-center">OPCION</div>
    </div>
    <div class="list">
<?php 
    $txt_categoria=array();
    $id_categoria=array();
    foreach ($proveedores as $key => $value){ 
    $temp_prioridad='';
    switch (@(int)$value['prioridad']) {
        case 1:
            $temp_prioridad='Super Alta';
            break;
        case 2:
            $temp_prioridad='Alta';
            break;
        case 3:
            $temp_prioridad='Regular';
            break;
        case 4:
            $temp_prioridad='Baja';
            break;
        case 5:
            $temp_prioridad='Muy Bajo';
            break;
        default:
            $temp_prioridad='Regular';
            break;
    }
    $temp_categoria='';
    echo (int)$value['categoria'];
    switch (@(int)$value['categoria']) {
        case 1:
            $temp_categoria='AVT (agencia de viajes)';
            break;
        case 2:
            $temp_categoria='Guias';
            break;
        case 3:
            $temp_categoria='Transporte Terrestre';
            break;
        case 4:
            $temp_categoria='Transporte Acuatico';
            break;
        case 5:
            $temp_categoria='Alojamiento';
            break;
        case 6:
            $temp_categoria='Compañia de Bus';
            break;
        default:
            $temp_categoria='no set';
            break;
    }
    $txt_categoria[(int)$value['categoria']]= $temp_categoria;
    // $id_categoria[]=(int)$value['categoria'];
    ?>
    <div class="container-fluid col-md-12  ">
            <div class="col-md-1 text-center"><?=@$value['id_proveedor'];?></div>
            <div class="col-md-3 text-center name"><?=@$value['razon_social'];?></div>
            <div class="col-md-2 text-center"><?=@$value['celular'];?></div>
            <div class="col-md-1 text-center"><span class="prioridad-<?=@$value['prioridad'];?> btn btn-xs"><?=@$temp_prioridad;?></span></div>
            <div class="col-md-3 text-center "><?=@$temp_categoria;?></div>
            <div class="categoria" style="display: none;"><?=(int)$value['categoria']?></div>
            <div class="col-md-2 text-center">
                <span class="btn_editar_proveedor" data-idproveedor="<?=@$value['id_proveedor'];?>" title="editar proveedor"><span class="btn btn-success btn-sm"><span class="fa fa-search"></span></span></span>
                <span class="btn_eliminar_proveedor" data-idproveedor="<?=@$value['id_proveedor'];?>" title="Eliminar proveedor"><span class="btn btn-danger btn-sm"><span class="fa fa-close"></span></span></span>                            
            </div>
        </div>
<?php } ?>
        
    </div>
    <ul class="pagination"></ul>
    <div class="col-md-12">
        <span class="btn btn-default " onclick="remove_filter()">Todos</span>
          <?php foreach (array_unique($txt_categoria) as $key => $value){ ?>
             <span class="btn btn-default filter_category" data-category="<?=strtolower($key);?>"><?=$value?></span> 
          <?php } ?>
       
  </div>
  </div>

  
  
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <div class="row ">
            <div class="form-group col-md-4">
              <label for="email">id_proveedor:</label>
              <input type="text" class="form-control" id="id_proveedor" placeholder="Enter id_proveedor" name="id_proveedor" readonly="">
            </div>
            <div class="form-group col-md-4">
              <label for="email">prioridad:</label>
              <select class="form-control" id="prioridad" name="prioridad" >
                  <option value="1">Super Alta</option>
                  <option value="2">Alta</option>
                  <option selected value="3">Regular</option>
                  <option value="4">Baja</option>
                  <option value="5">Muy Bajo</option>
                </select>
            </div>
            <div class="form-group col-md-4">
              <label for="email">categoria:</label>
              <select class="form-control" id="categoria" name="categoria" >
                    <option >------</option>
                  <option value="1">AVT (agencia de viajes)</option>
                  <option value="2">Guias</option>
                  <option value="3">Transporte Terrestre</option>
                  <option value="4">Transporte Acuatico</option>
                  <option value="5">Alojamiento</option>
                  <option value="6">Compañia de Bus </option>
                </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="email">razon_social:</label>
              <input type="text" class="form-control" id="razon_social" placeholder="Enter razon_social" name="razon_social">
            </div>
            <div class="form-group col-md-6">
              <label for="email">ruc:</label>
              <input type="text" class="form-control" id="ruc" placeholder="Enter ruc" name="ruc">
            </div>
          </div>
          <div class="row">
          <div class="form-group col-md-6">
              <label for="email">telefono:</label>
              <input type="text" class="form-control" id="telefono" placeholder="Enter telefono" name="telefono">
            </div>
          
          <div class="form-group col-md-6">
              <label for="email">email:</label>
              <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
          </div>
          
          <div class="row">
            <div class="form-group col-md-6">
              <label for="email">nombre_contacto:</label>
              <input type="text" class="form-control" id="nombre_contacto" placeholder="Enter nombre_contacto" name="nombre_contacto">
            </div>
            <div class="form-group col-md-6">
              <label for="email">celular:</label>
              <input type="text" class="form-control" id="celular" placeholder="Enter celular" name="celular">
            </div>
          
          </div>
          <div class="row">
            
          </div>
          <div class="form-group">
              <label for="email">observaciones:</label>
                    <textarea rows="4" class="form-control" id="observaciones" placeholder="Enter observaciones" name="observaciones"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <div class="btn btn-success btn-sm btn_actualizar_proveedor">Actualizar</div>
            <div class="btn btn-success btn-sm btn_add_proveedor">Agregar</div>
          <div type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</div>
        </div>
      </div>
      
    </div>
  </div>

<script type="text/javascript">
var monkeyList = new List('test-list', {
  valueNames: ['name','categoria'],

  page: 40,
  pagination: true
});

$(document).on('click', '.filter_category', function(event) {
    event.preventDefault();
    /* Act on the event */
    var filter_category=$(this).data('category');
    monkeyList.filter(function(item) {
        console.log('item',parseInt(item.values().categoria)==parseInt(filter_category))

    if (parseInt(item.values().categoria)==parseInt(filter_category)) {
       return true;
    } else {
       return false;
    }
    }); // Only items with id > 1 are shown in list
});

function remove_filter(){
    monkeyList.filter(); // Remove all filters
}
// $('#myModal').modal('show');
$(document).on('click', '.btn_modal_proveedor', function(event) {
    event.preventDefault();
    $('.btn_actualizar_proveedor').css('display', 'none');
    $('.btn_add_proveedor').css('display', 'inline-block');
    $.get('<?=base_url();?>admin/proveedores/get_ultimate_row', function(data) {
        var temp_data=JSON.parse(data);
        var tem_data_parse;
		if(temp_data.length==0){
		    tem_data_parse=0;
		}else{
		    tem_data_parse=parseInt(temp_data.id_cliente);
		}
        console.log("success",temp_data);
            $('#id_proveedor').val(tem_data_parse+1);
            $('#prioridad').val('3');
            $('#categoria').val('');
            $('#razon_social').val('');
            $('#ruc').val('');
            $('#telefono').val('');
            $('#email').val('');
            $('#nombre_contacto').val('');
            $('#celular').val('');
            $('#observaciones').val('');
    });
    $('#myModal').modal('show');
});
$(document).on('click', '.btn_add_proveedor', function(event) {
    event.preventDefault();
    
    var data_proveedor={
            'prioridad':$('#prioridad').val(),
            'categoria':$('#categoria').val(),
            'razon_social':$('#razon_social').val(),
            'ruc':$('#ruc').val(),
            'telefono':$('#telefono').val(),
            'email':$('#email').val(),
            'nombre_contacto':$('#nombre_contacto').val(),
            'celular':$('#celular').val(),
            'observaciones':$('#observaciones').val(),
    }
    $.ajax({
        url: "<?=base_url();?>admin/proveedores/add",
        type: 'POST',
        dataType: 'json',
        data: {data_add_proveedor:data_proveedor},
    })
    .done(function(data) {
        console.log("success",data);
        location.reload();

    })
    .fail(function(e) {
        console.log("error");
    });
    
});
$(document).on('click', '.btn_editar_proveedor', function(event) {
    event.preventDefault();
    var data_proveedor=$(this).data('idproveedor');
    $('.btn_add_proveedor').css('display', 'none');
    $('.btn_actualizar_proveedor').css('display', 'inline-block');
    $.ajax({
        url: "<?=base_url();?>admin/proveedores/get_proveedores",
        type: 'POST',
        dataType: 'json',
        data: {id_proveedor:data_proveedor},
    })
    .done(function(data) {
        console.log("success",data);
        $('#myModal').modal('show');
            $('#id_proveedor').val(data.id_proveedor);
            $('#prioridad').val(data.prioridad);
            $('#categoria').val(data.categoria);
            $('#razon_social').val(data.razon_social);
            $('#ruc').val(data.ruc);
            $('#telefono').val(data.telefono);
            $('#email').val(data.email);
            $('#nombre_contacto').val(data.nombre_contacto);
            $('#celular').val(data.celular);
            $('#observaciones').val(data.observaciones);
    })
    .fail(function(e) {
        console.log("error");
    });
    
});
$(document).on('click', '.btn_actualizar_proveedor', function(event) {
    event.preventDefault();
    var id_proveedor=$('#id_proveedor').val();
    var data_proveedor={
            'prioridad':$('#prioridad').val(),
            'razon_social':$('#razon_social').val(),
            'ruc':$('#ruc').val(),
            'categoria':$('#categoria').val(),
            'telefono':$('#telefono').val(),
            'email':$('#email').val(),
            'nombre_contacto':$('#nombre_contacto').val(),
            'celular':$('#celular').val(),
            'observaciones':$('#observaciones').val(),
    }
    console.log('data_proveedor',data_proveedor);
    $.ajax({
        url: "<?=base_url();?>admin/proveedores/update_proveedor",
        type: 'POST',
        dataType: 'json',
        data: {data_proveedor:data_proveedor,id_proveedor:id_proveedor},
    })
    .done(function(data) {
        console.log("success",data);
        location.reload();
    })
    .fail(function(e) {
        console.log("error");
    });
    
});
$(document).on('click', '.btn_eliminar_proveedor', function(event) {
    event.preventDefault();
    
    if (ConfirmDelete()) {
        var data_proveedor=$(this).data('idproveedor');
        $.ajax({
            url: "<?=base_url();?>admin/proveedores/delete_proveedor",
            type: 'POST',
            dataType: 'json',
            data: {id_proveedor:data_proveedor},
        })
        .done(function(data) {
            console.log("success",data);
            location.reload();
        })
        .fail(function(e) {
            console.log("error");
        });
    }
    
    
});

function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
          return true;
      else
        return false;
    }


</script>