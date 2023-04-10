<?php
  
?>

<div class="container">
  <div class="col-md-12">
	 <div class="panel panel-default">
	  <div class="panel-heading">Lista de cupones <button id="btn_add" class="btn btn-success pull-right" style="margin-top:-7px"><i class="fa fa-plus" aria-hidden="true"></i>
 Agregar cupon</button> </div>
	  <div class="panel-body">
	  	<table class="table table-striped edad" id="tabla_datos">

			    <thead>
			      <tr>
			        <th>Descripcion</th>
			        <th>Codigo</th>
			        <th>Descuento</th>
			        <th>Cantidad a ultilizar</th>
							<th>Cantidad usada</th>
			        <th width="100">#</th>
			      </tr>
			    </thead>
			    <tbody>
<?php
 /* $trs = null;
  foreach($lista_cupones as $value){
		$tipo_des = $value['tipo_descuento_cupon']?'%':'$';
		$value['descuento_cupon'] = $value['descuento_cupon']+0;
		$trs .= "<tr><td>{$value['descripcion_cupon']}</td><td>{$value['codigo_cupon']}</td><td>{$value['descuento_cupon']} $tipo_des</td><td>{$value['veces_activar']}</td><td>{$value['veces_activadas']}</td><td>acciones</td></tr>";
	}
	echo $trs;*/
?>
			    </tbody>
			  </table>
			  
			
	  </div>
	</div>
  </div>
</div>
<!-- Modal -->
<div id="modal_agregar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cupones</h4>
      </div>
      <div class="modal-body">
			 <form id="form_cupones">
        <div><div class="col-md-3"><label>Descripcion: </label></div><div class="col-md-6"><input maxlength="16" type="text" name="descripcion" class="form-control"></div></div>

				<div><div class="col-md-3"><label>Codigo: </label></div><div class="col-md-6"><input maxlength="10" type="text" name="codigo" class="form-control"></div></div>
				<div><div class="col-md-3"><label>Descuento: </label></div><div class="col-md-6"><input maxlength="3" step="any" type="number" name="descuento" class="form-control"></div></div>
				<div><div class="col-md-3"><label>Tipo descuento: </label></div><div class="col-md-6"><select class="form-control" name="tipo"><option value="0">%</option><option value="1">$</option></select></div></div>
			  
				<div><div class="col-md-3"><label>Veces a activar: </label></div><div class="col-md-6"><input maxlength="5" type="number" name="veces" class="form-control"></div></div>
				<input type="hidden" name="id" value="0"><br>
				<div style="clear:both"></div>
			 </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_guardar_cupon">Guardar</button>
      </div>
    </div>

  </div>
</div>



<script>
$(function(){
  var json_cupones = <?=json_encode($lista_cupones);?>;
	
  var btn_add = $('#btn_add');
	var add_modal = $('#modal_agregar');
	var btn_guardar_cupon = $('#btn_guardar_cupon');
	var form_cupones = $('#form_cupones');
	var tabla_datos = $('#tabla_datos');


  /* agregar a la tabla si existe datos */
	var trs_html = '';
	json_cupones.forEach(function($value,$key){
		var $tipo_des = parseInt($value['tipo_descuento_cupon'])?'$':'%';
		var $descuento_cupon = parseFloat($value['descuento_cupon'])+0;

		trs_html += `
		<tr data-key="${$key}">
		  <td>${$value['descripcion_cupon']}</td>
			<td>${$value['codigo_cupon']}</td>
			<td>${$descuento_cupon} ${$tipo_des}</td>
			<td>${$value['veces_activar']}</td>
			<td>${$value['veces_activadas']}</td>
		  <td>
			  <button class="btn btn-success" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
				<button class="btn btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
			</td>
		</tr>`;
	});
	tabla_datos.find('tbody').append(trs_html);
	tabla_datos.DataTable();
	//agregar acciones al pulsar boton de editar
	var  inputs = form_cupones.find('input, select');
	tabla_datos.on('click','.btn-success',function(){
		var index = $(this).parents('tr').data('key');
		var valores = json_cupones[index];
		inputs[0].value = valores.descripcion_cupon;
		inputs[1].value = valores.codigo_cupon;
		inputs[2].value = parseFloat(valores.descuento_cupon)+0;
		inputs[3].value = valores.tipo_descuento_cupon;
		inputs[4].value = valores.veces_activar;
		inputs[5].value = valores.id_cupon;
		
		add_modal.modal('show');
	});
	////////////////////////////////////////
	tabla_datos.on('click','.btn-danger',function(){
		if(!confirm('Seguro de eliminar?'))return;

		var tr = $(this).parents('tr');
		var ide = json_cupones[tr.data('key')].id_cupon;

		$.post('<?=base_url();?>admin/cupones/delete',{id:ide},function(data){
			if(!isNaN(data)){
				tr.remove();
			} else alert('Errores al eliminar.');
		});
	});
	///////////////////////////////////////
	btn_add.click(function(){
		inputs.val('');
		inputs[3].value = 0;
		inputs[5].value = 0;
		add_modal.modal('show');
	});
	//
	btn_guardar_cupon.click(function(){
		//add_modal.modal('hide');
		//form_cupones.css('background','red');
	 var datos =	form_cupones.serializeArray();
	 var error = 0;
	 datos.forEach(function(elem){
		if(!elem.value)error=1;
	 });
   //comprobar si hay errores para luego enviar
	 if(!error){
		console.log(datos);
		$.post('<?=base_url();?>admin/cupones/regedit',datos,function(data){
			if(!isNaN(data)){
				add_modal.modal('hide');
				add_modal.on('hidden.bs.modal', function () {
						location.reload();
				});
			} else alert('Errores al guardar. Cambie el codigo e intente de nuevo.');
		});
	 } else alert('Hay campos vacios.');

	});
});
</script>
<style>
#form_cupones > div{
	clear:both;
}
 #form_cupones .col-md-6,#form_cupones .col-md-3{
	 margin-bottom: 3px;
 }
</style>