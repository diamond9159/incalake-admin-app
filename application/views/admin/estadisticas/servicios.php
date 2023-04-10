<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-08">
	<title>Reporte de cantidad de personas y montos según actividad</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.es.min.js"></script>

	<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
	<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content >
			<div class="container">
			<div class="panel panel-danger">
				<div class="panel-heading">Reporte de reserva de actividades
					<span class="pull-right">
						<a href="" target="_blank" class="btn btn-primary btn-xs pdf"><span class="fa fa-file"></span> Imprimir</a>
					</span>
                                </div>
				<div class="panel-body">
					<div class="alert alert-info" id="filtros">
						Filtrar por fecha: 
						<input class="datepicker" name="fecha_inicio" readonly placeholder="Desde" />
						<input class="datepicker" name="fecha_fin" readonly placeholder="Hasta" />
						<label>Rango de fecha <input value="4" name="option" type="radio" /></label>
						<label>Todo <input value="0" name="option" type="radio" /></label>
						<label>Este mes <input value="3" name="option" type="radio" /></label>
						<label>30 dias <input value="2" name="option" type="radio" /></label>
						<label>Mes anterior <input value="1" name="option" type="radio" /></label>
						<button class="btn btn-success pull-right" id="btn-aplicar">Aplicar</button>
					</div>
					<div id="contenedor_tabla">
						<img style="margin:auto;display:block" src="<?=base_url('assets/img/ajax-loader.gif');?>" />
					</div>
				</div>
			</div>
				
			</div>
		</content>
		<footer>
			<?php
				//$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
	</body>
	<script>
	  
(function(){
	var dataObject = {
    columns: [{
      title: "NAME"
    }, {
      title: "COUNTY"
    }],
    data: [
      ["John Doe", "Fresno"],
      ["Billy", "Fresno"],
      ["Tom", "Kern"],
      ["King Smith", "Kings"]
    ]
  };
  var columns = [];
  /* {
    "data": dataObject.data,
    "columns": dataObject.columns
  } */
  // configuracion para datatable
  function retorna_config(html){
	return {
		language: {
			"decimal": "",
			"emptyTable": "No hay informaci贸n",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas "+html,
			"infoEmpty": "Mostrando del 0 al 1 de 1 Entradas",
			"infoFiltered": "(Filtrado de _MAX_ total entradas)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ Entradas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar:",
			"zeroRecords": "Sin resultados encontrados",
			"paginate": {
				"first": "Primero",
				"last": "Ultimo",
				"next": "Siguiente",
				"previous": "Anterior"
			}
		},
		"bJQueryUI": true
	}
  }

	/*var tabla_datos = $('#tabla_datos');
	tabla_datos.dataTable(config);*/

/////////////////////////////// date picker ////////////////////////////////
	 var contenedor_filtros = $('#filtros');
 	 var date_input=$('.datepicker'); //our date input has the name "date"
        date_input.eq(0).datepicker({
           format: 'dd-mm-yyyy',
           todayHighlight: true,
           autoclose: true,
           language: 'es',
           daysOfWeekHighlighted: [1,2,3,4,5,6]
       });
      
	function change2calandar(){
			date_input.eq(1).val('');
			date_input.eq(1).datepicker('remove');
			date_input.eq(1).datepicker({
			format: 'dd-mm-yyyy',
			todayHighlight: true,
			autoclose: true,
			language: 'es',
			startDate: this.value,
			daysOfWeekHighlighted: [1,2,3,4,5,6]
			
		});
	}
	date_input.eq(0).change(change2calandar);
	//// configurar acciones al cambiar los radio buttons ////////
	var inputs_filtro = $('input[name="option"]');
	inputs_filtro.change(function(){
		var elem_padre = $(this).parent();
		contenedor_filtros.find('label').removeClass('en_foco');
		elem_padre.addClass('en_foco');
		if(+$(this).val()!=4){
			date_input.attr('disabled','disabled');
			// alert('inabilitando');
		} else {
			date_input.removeAttr('disabled');
			// alert('habilitando');
		}
	});
	inputs_filtro.eq(1).trigger('click'); // simular evento para seleccionar input
	// buscar contenido al hacer click en aplicar
	var contenedor_tabla = $('#contenedor_tabla');
	$('#btn-aplicar').click(function(){
		contenedor_tabla.html('<img style="margin:auto;display:block" src="<?=base_url('assets/img/ajax-loader.gif');?>" />');
		var inputs = contenedor_filtros.find('input:not(input[disabled])');
	    console.log(inputs.serializeArray());
		var validador = true;
		inputs.each(function(){
			if(!$(this).val()){
				validador = false;
				$(this).css('border-color','red');
			}
		});
		if(!validador)return false;
		hacer_peticion(inputs.serializeArray());		
	}).trigger('click');

	// funcion para peticionar ajax
	function hacer_peticion(data){
		    
			// enviar la peticion ajax
			$.post('<?=base_url();?>admin/reportes/serviciosmes',data,function(resultado){
				
				var json = JSON.parse(resultado);
				console.log(json.values);
                                $("a.pdf").attr("href",json.url_reporte_pdf);
				var html = '';
				var total_reservas = 0;
				var total_pasajeros = 0;
				var total_monto = 0;
				for(i in json.data){
					html += retorna_html_tabla(json.data[i]);
					total_reservas += +json.data[i].cantidad_servicio;
					total_pasajeros += +json.data[i].cantidad_clientes;
					total_monto += +json.data[i].precio_total;
				}
				var tabla = `<table class="table" id="tabla_datos" style="width:100%">
								<thead>
									<tr>
										<th width="50"># reservas</th>
										<th>Actividad</th>
										<th width="50"># pasajeros</th>
										<th width="100">$ Monto</th>
									</tr>
								<thead>
								<tbody>
								${html}
								</tbody>
							</table>`;
				var html_detalles = `<hr><div class="col-md-4 pull-right">
					<table class="table detalles_resultado">
						<tr><th colspan="2">Resumen general</th></tr>
						<tr><td>Sub Total $</td><td class="text-right">${(total_monto).toFixed(2)}</td></tr>
						<tr><td>Monto cupones de descuento</td><td class="text-right">${(+json.monto_cupones).toFixed(2)}</td></tr>
						<tr><td>Total $</td><td class="text-right">${(total_monto-(+json.monto_cupones)).toFixed(2)}</td></tr>
						
					</table>
				</div>`;
				contenedor_tabla.html(tabla+html_detalles);
				var html_totales = `<span class="totales">
										<b>Total reservas: </b>${total_reservas}
									</span>
									<span class="totales">
										<b>Total pasajeros: </b>${total_pasajeros}
									</span>
									<span class="totales">
										<b>Monto total $ : </b>${total_monto.toFixed(2)}
									</span>
									`;
				$('#tabla_datos').dataTable(retorna_config(html_totales));
			});
			// fucntion para escribir resultados
			function retorna_html_tabla(data){
				return `<tr>
							<td class="text-center">${data.cantidad_servicio}</td>
							<td>${data.nombre_servicio}</td>
							<td class="text-right">${data.cantidad_clientes}</td>
							<td class="text-right">$ ${data.precio_total}</td>
						</tr>
						`;
			}
		}

	 // ver toda las actividades por defecto
	 // hacer_peticion();
})();
	</script>
	<style>
		/* stylos precios totales*/
		span.totales{
			background:#285151;
			display:inline-block;
			padding:3px;
			border-radius:3px;
			color:#DDD;
		}

		/* estilos a los inputs de los filtros */
		#filtros input{
			border:1px solid #CCC;
			padding:3px;
		}
		#filtros label{
			background:#afd8d8;
			vertical-align:center;
			padding:3px;
			border-radius:3px;
		}
		#filtros label.en_foco{
			background:#408282;
			color:#f9f9f9;
		}
		
	</style>
</html>