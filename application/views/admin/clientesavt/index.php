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
		<div class="col-md-6 text-right"> <span class="btn btn-success btn_modal_cliente">Agregar Cliente</span></div>
	</div>
    
    <div class="col-md-12 header-list text-white">
		<div class="col-md-1 text-center">N째</div>
		<div class="col-md-3 text-center">RAZON SOCIAL / NOMBRE</div>
		<div class="col-md-2 text-center">CELULAR</div>
		<div class="col-md-1 text-center">PRIORIDAD</div>
		<div class="col-md-3 text-center">NOMBRE CONTACTO</div>
		<div class="col-md-2 text-center">OPCION</div>
	</div>
    <div class="list">
<?php foreach ($clientes as $key => $value){ 
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
	?>
	<div class="container-fluid col-md-12  ">
			<div class="col-md-1 text-center"><?=@$value['id_cliente'];?></div>
			<div class="col-md-3 text-center name"><?=@$value['razon_social'];?></div>
			<div class="col-md-2 text-center"><?=@$value['celular'];?></div>
			<div class="col-md-1 text-center"><span class="prioridad-<?=@$value['prioridad'];?> btn btn-xs"><?=@$temp_prioridad;?></span></div>
			<div class="col-md-3 text-center"><?=@$value['nombre_contacto'];?></div>
			<div class="col-md-2 text-center">
				<span class="btn_editar_cliente" data-idcliente="<?=@$value['id_cliente'];?>" title="editar cliente"><span class="btn btn-success btn-sm"><span class="fa fa-search"></span></span></span>
				<span class="btn_eliminar_cliente" data-idcliente="<?=@$value['id_cliente'];?>" title="Eliminar cliente"><span class="btn btn-danger btn-sm"><span class="fa fa-close"></span></span></span>							
			</div>
		</div>
<?php } ?>
    	
    </div>
    <ul class="pagination"></ul>
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
          	<div class="form-group col-md-6">
		      <label for="email">id_cliente:</label>
		      <input type="text" class="form-control" id="id_cliente" placeholder="Enter id_cliente" name="id_cliente" readonly="">
		    </div>
		    <div class="form-group col-md-6">
		      <label for="email">prioridad:</label>
		      <select class="form-control" id="prioridad" name="prioridad" >
				  <option value="1">Super Alta</option>
				  <option value="2">Alta</option>
				  <option selected value="3">Regular</option>
				  <option value="4">Baja</option>
				  <option value="5">Muy Bajo</option>
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
        	<div class="btn btn-success btn-sm btn_actualizar_cliente">Actualizar</div>
        	<div class="btn btn-success btn-sm btn_add_cliente">Agregar</div>
          <div type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</div>
        </div>
      </div>
      
    </div>
  </div>

<script type="text/javascript">
var monkeyList = new List('test-list', {
  valueNames: ['name'],
  page: 20,
  pagination: true
});
// $('#myModal').modal('show');
$(document).on('click', '.btn_modal_cliente', function(event) {
	event.preventDefault();
	$('.btn_actualizar_cliente').css('display', 'none');
	$('.btn_add_cliente').css('display', 'inline-block');
	$.get('<?=base_url();?>admin/clientesavt/get_ultimate_row', function(data) {
		var temp_data=JSON.parse(data);
		var tem_data_parse;
		if(temp_data.length==0){
		    tem_data_parse=0;
		}else{
		    tem_data_parse=parseInt(temp_data.id_cliente);
		}
		console.log(tem_data_parse);
			$('#id_cliente').val(tem_data_parse+1);
			$('#prioridad').val('3');
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
$(document).on('click', '.btn_add_cliente', function(event) {
	event.preventDefault();
	
	var data_cliente={
			'prioridad':$('#prioridad').val(),
			'razon_social':$('#razon_social').val(),
			'ruc':$('#ruc').val(),
			'telefono':$('#telefono').val(),
			'email':$('#email').val(),
			'nombre_contacto':$('#nombre_contacto').val(),
			'celular':$('#celular').val(),
			'observaciones':$('#observaciones').val(),
	}
	$.ajax({
		url: "<?=base_url();?>admin//clientesavt/add",
		type: 'POST',
		dataType: 'json',
		data: {data_add_cliente:data_cliente},
	})
	.done(function(data) {
		console.log("success",data);
		location.reload();

	})
	.fail(function(e) {
		console.log("error");
	});
	
});
$(document).on('click', '.btn_editar_cliente', function(event) {
	event.preventDefault();
	var data_cliente=$(this).data('idcliente');
	$('.btn_add_cliente').css('display', 'none');
	$('.btn_actualizar_cliente').css('display', 'inline-block');
	$.ajax({
		url: "<?=base_url();?>admin/clientesavt/get_clientes",
		type: 'POST',
		dataType: 'json',
		data: {id_cliente:data_cliente},
	})
	.done(function(data) {
		console.log("success",data);
		$('#myModal').modal('show');
			$('#id_cliente').val(data.id_cliente);
			$('#prioridad').val(data.prioridad);
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
$(document).on('click', '.btn_actualizar_cliente', function(event) {
	event.preventDefault();
	var id_cliente=$('#id_cliente').val();
	var data_cliente={
			'prioridad':$('#prioridad').val(),
			'razon_social':$('#razon_social').val(),
			'ruc':$('#ruc').val(),
			'telefono':$('#telefono').val(),
			'email':$('#email').val(),
			'nombre_contacto':$('#nombre_contacto').val(),
			'celular':$('#celular').val(),
			'observaciones':$('#observaciones').val(),
	}
	$.ajax({
		url: "<?=base_url();?>admin/clientesavt/update_cliente",
		type: 'POST',
		dataType: 'json',
		data: {data_cliente:data_cliente,id_cliente:id_cliente},
	})
	.done(function(data) {
		console.log("success",data);
		location.reload();
	})
	.fail(function(e) {
		console.log("error");
	});
	
});
$(document).on('click', '.btn_eliminar_cliente', function(event) {
	event.preventDefault();
	
	if (ConfirmDelete()) {
		var data_cliente=$(this).data('idcliente');
		$.ajax({
			url: "<?=base_url();?>clientesavt/clientesavt/delete_cliente",
			type: 'POST',
			dataType: 'json',
			data: {id_cliente:data_cliente},
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