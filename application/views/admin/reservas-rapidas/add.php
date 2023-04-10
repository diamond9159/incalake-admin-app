<div id="appreservasrapidas">
	<div class="container-fluid">
		<div class="col-md-12 form-group container-fluid">
	        <div class="col-md-4 col-xs-12 col-sm-4">
	            <h4>Nombres<span class="text-danger">*</span> <small>(Escriba nombres del cliente)</small></h4>
	            <input type="text" id="txtNombres" class="form-control txtnombres validar" autofocus="true" placeholder="" name="txtnombres" v-model="datosCliente.nombres">
	        </div>
	        <div class="col-md-4 col-xs-12 col-sm-4">
	            <h4>Apellidos<span class="text-danger">*</span> <small>(Escriba apellidos del cliente)</small></h4>
	            <input type="text" id="txtApellidos" class="form-control txtapellidos validar" name="txtapellidos" v-model="datosCliente.apellidos">
	        </div>
	        <div class="col-md-4 col-xs-12 col-sm-4">
	            <h4>Email<span class="text-danger">*</span> <small>(Escriba E-mail del cliente)</small></h4>
	            <input type="email" id="txtEmail" class="form-control txtemail validar" name="txtemail" v-model="datosCliente.email">
	        </div>
	        <div class="col-md-4 col-xs-12 col-sm-4">
	            <h4>Nacionalidad (Opcional) <small>(Escriba Nacionalidad del cliente)</small></h4>
	            <input type="text" id="txtNacionalidad" class="form-control" name="txtnacionalidad" v-model="datosCliente.nacionalidad">
	        </div>
	        <div class="col-md-4 col-xs-12 col-sm-4">
	            <h4>Teléfono (Opcional) <small>(Escriba Teléfono del cliente)</small></h4>
	            <input type="tel" id="txtTelefono" class="form-control" name="txttelefono" v-model="datosCliente.telefono">
	        </div>
	    </div>
	</div>

	<div class="container-fluid">
		<div class="col-md-12 text-center hidden-xs hidden-sm" style="padding: 0;background: #337ab7;color: #fff; font-weight: bold;font-size: medium;">

		    <div class="col-md-6" style="padding: 0;">
		        <div class="col-md-3">Fecha de servicio</div>
		        <div class="col-md-9">
		            Descripción
		        </div>
		    </div>
		    <div class="col-md-6" style="padding: 0;">
		        <div class="col-md-3">Cantidad</div>
		        <div class="col-md-2">$ Precio Unitario</div>
		        <div class="col-md-4">$ Descuento / tipo</div>
		        <div class="col-md-2">$ Precio Total</div>
		         <div class="col-md-1">#</div>
		    </div>
		</div>

		<div class="servicios  col-md-12 container-fluid contenedorForm" style="padding: 10px 0;border-bottom: 1px solid rgba(85, 90, 90, 0.56);" v-for="(dv, index) in datosVenta">
			<div class="col-md-12" style="padding: 0;">
				<div class="col-md-6" style="padding: 0;">
					<div class="col-md-3 col-xs-12 col-sm-12 "><div class="visible-xs visible-sm">Fecha</div>
						<date-picker @update-date="updateDate" date-format="dd-M-yy" v-bind:fecha="dv.fecha" :item-data="index" v-once></date-picker>
						<div class="form-gruop">
							<label for="">Hora de salida <span class="fa fa-question-circle text-info" title="Seleccione o Ingrese un horario de inicio para el servicio"></span>:</label>
							<div v-if="dv.listaHorasInicio.length > 0 ">
								<input type="text" name="txtHoraSalida[]" id="txtHoraSalida" :list="'listHoraSalida'+index" class="form-control" placeholder="Seleccione Horario" v-model="dv.horaInicio">
								<datalist :id="'listHoraSalida'+index">
									<option v-for="(hi, i) in dv.listaHorasInicio" v-model="hi[datosExtra.idioma]">{{hi[datosExtra.idioma]}}</option>
								</datalist>
							</div>
							<div v-if="dv.listaHorasInicio.length <= 0" >
								<input type="text" name="txtHoraSalida[]" :id="'txtHoraSalida'+index" class="form-control classHorasSalida" placeholder="Seleccione Horario" v-model="dv.horaInicio">
							</div>
						</div>
						<!--
						<input type="text" class="form-control" :id="asignarId(index)" name="txtfecha[]" v-model="dv.fecha" v-on:click="mostrarCalendario(index,dv)">
					-->
					</div>
					<div class="col-md-9 col-xs-12 col-sm-12">
						<div class="visible-xs visible-sm">Descripción</div>
						<input type="text" placeholder="Ingrese nombre del servicio" name="txtdescripcion[]" class="form-control" v-model="dv.titulo" v-on:keyup="servicioSeleccionado(dv.titulo,index)"/>
						<div v-show="selecedDataItem.length > 0 && visibleSelectedDiv === index" style="position: absolute; width: 100%; z-index:7; max-height: 30em; overflow-x: auto;border-radius: 3px; border:solid 2px gray;">
							<div class="list-group">
								<a href="javascript:void(0)" v-for="itemSelected in selecedDataItem"  class="list-group-item" v-on:click="itemSeleccionado(itemSelected,index)"><strong>[{{itemSelected.idioma.toUpperCase()}}]</strong> {{itemSelected.titulo_producto}}</a>
							</div>
						</div>
						<ckeditor v-model="dv.descripcion" v-bind:id="'editor'+index"></ckeditor>
						<!--
						<input onfocus="$(this).siblings('textarea').show()" onblur="$(this).siblings('textarea').focus()" type="text" placeholder="Ingrese nombre del servicio" name="txtdescripcion[]" class="form-control" v-model="dv.titulo">
						-->                        
                        <!--
						<textarea onblur="if(!$(this).val().length)$(this).hide()" style="margin-top: 2px; display: none;" placeholder="Escriba una descripción  mas detallada del servicio" name="txtdescripcionmas[]" class="form-control" v-model="dv.descripcion"></textarea>
						-->
					</div>
				</div>
				<div class="col-md-6" style="padding: 0;">
					<div class="col-md-3 col-xs-6 col-sm-6 text-center">
						<div class="visible-xs visible-sm">Cantidad</div>
						<div class="btn-group" style="width:auto;">
							<div class="btn btn-default" v-on:click="dv.cantidad -=1"><i class="fa fa-caret-left" aria-hidden="true"></i>
							</div>
							<input type="text" value="1" min="1" style="width:31px;padding:0px;text-align:center;font-weight:bold;float: left;" class="form-control" name="txtcantidad[]" v-model="dv.cantidad">
							<div class="btn btn-default" v-on:click="dv.cantidad +=1"><i class="fa fa-caret-right" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-6 col-sm-6">
						<div class="visible-xs visible-sm">Precio Unitario</div>
						<input type="number" class="form-control" name="txtpreciounitario[]" v-model="dv.precioUnitario" style="text-align: center;">
					</div>
					<div class="col-md-3 col-xs-6 col-sm-6 text-center" style="padding-left: 0px;">
						<div class="visible-xs visible-sm">$ Descuento</div>
						<div class="input-group">
							<input type="number" style="width:80px;display: inline; text-align: center;" class="form-control pull-left" name="descuento_cantidad[]" v-model="dv.descuento.cantidadDescuento"> 
							<select class="form-control pull-right" style="width:60px;display: inline" name="tipo_descuento_normal[]" v-model="dv.descuento.tipoDescuento">
								<option value="0" selected="">%</option>
								<option value="1">$</option>
							</select>
						</div>
					</div>
					<div class="col-md-3 col-xs-6 col-sm-6"><div class="visible-xs visible-sm">Precio Total</div>
						<span class="pull-right"><strong>{{ dv.precioSubTotal.toFixed(2) }} <small> USD</small></strong></span>
					</div>
					<div class="col-md-1 col-xs-12 col-sm-1" style="padding:0">
						<span class="btn btn-danger btn-sm fa fa-close pull-right" v-on:click="eliminarItem(index)" title="Eliminar"></span>
					</div>
				
				</div>
			</div>
		</div>
		<div class="pull-right"><br/><span class="btn btn-success btn-lg fa fa-plus-circle" title="Agregar" v-on:click="agregarItem()"> <strong> AGREGAR</strong></span></div>
	</div>
	<!--
	<pre>
	{{datosVenta}}
	</pre>
-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-1 hidden-sm hidden-xs"></div><hr/>
			<div class="col-md-5">
				<div class="form-group">
                   <label class="col-md-12 control-label">Descuento general: </label>
                   <div class="col-md-12">
                   	<div class="input-group">
	                   <input style="width:100px;display: inline;text-align: center;" class="form-control validar" type="number" value="0" min="0" name="descuento_general" v-model="datosExtra.descuentoGeneral.cantidadDescuentoGeneral">
	                   <select class="form-control" style="width:60px;display: inline" name="tipo_descuento_general" v-model="datosExtra.descuentoGeneral.tipoDescuentoGeneral">
	                       <option value="0" selected="">%</option>
	                       <option value="1">$</option>
	                   </select>
	               </div>
	               </div>
               </div>
               <div class="form-group">
                    <label class="col-md-12 control-label">Tasas e Impuestos: </label>
                    <div class="col-md-12">
                    	<div class="input-group">
	                    <input style="width:100px;display: inline; text-align: center;" class="form-control validar" type="number" value="0" min="0" name="tasas_impuestos" v-model="datosExtra.tasasImpuestos.cantidadTasasImpuestos">
	                    <select class="form-control" style="width:60px;display: inline" name="tipo_impuesto" v-model="datosExtra.tasasImpuestos.tipoTasasImpuestos">
	                        <option value="0" selected="">%</option>
	                        <option value="1">$</option>
	                    </select>
	                </div>
                	</div>
               </div>
               <p class="col-md-12 text-justify"><small><b>NOTA:</b> Al seleccionar <b>($)</b> se sumará la cantidad y en el caso que se seleccione la opción por defecto <b>(%)</b> se aplicará el porcentaje al PRECIO TOTAL</small></p>
               <div class="form-group">
                   <label class="col-md-12 control-label">Porcentaje a Pagar: </label>
                   <div class="col-md-12">
	                   	<div class="input-group">
		                   <input style="width:100px;display: inline;text-align: center;" class="form-control" type="number" value="0" min="0" name="descuento_general" v-model="datosExtra.coutaPorcentaje">
		                   <select class="form-control" style="width:60px;display: inline" readonly >
		                       <option value="0" selected="">%</option>
		                   </select><br/><br/></br>
		                </div>
	               </div>
               </div>

               <div class="form-group">
               		<label class="col-md-12 control-label"><span class="fa fa-credit-card"></span> Método de Pago: </label>
                    <div class="col-md-12">
	                   	<select name="idioma" class="form-control" v-model="datosExtra.metodo_pago" style="width:150px;display:inline">
		              		<option value="culqi">Culqi</option>
		              		<option value="paypal">Paypal</option>
		           		</select>
			        </div>
               </div> 

			</div>
			<div class="col-md-5">
				<h3 class="text-center text-danger">RESUMEN DE LA COMPRA</h3>
				<div class="table-responsive">
					<table class="table table-hover" style="max-width: auto;margin:auto;margin-top:10px">
				        <tbody><tr><td align="right">Sub Total $</td><td align="right">{{ datosExtra.precioSubTotal.toFixed(2) }}</td></tr>
				        <tr><td align="right">Tasas e Impuestos $</td><td align="right">{{ datosExtra.tasasImpuestos.montoTasasImpuestos.toFixed(2) }}</td></tr>
				        <tr><td align="right">Descuento General $</td><td align="right">{{ datosExtra.descuentoGeneral.montoDescuentoGeneral.toFixed(2) }}</td></tr>
				        <tr style="font-size:1.5em; background:#1485CC;color:white;"><td align="right">Total $</td><td align="right" style="color:white;">{{ datosExtra.precioTotal.toFixed(2) }}</td></tr>
				        <tr style="font-size:1.5em;background: #4cae4c;color:white;" class="bg-success"><td align="right">Monto a Pagar ({{ datosExtra.coutaPorcentaje }} %)</td><td align="right" style="color:white;">{{ montoAApagar().toFixed(2) }}</td></tr>
				        <tr style="font-size:1.5em;background: #FF7D1B;color:white;"><td align="right">Monto Restante ({{ 100 - parseFloat(datosExtra.coutaPorcentaje) }} %)</td><td align="right" style="color:white;">{{ montoRestante().toFixed(2) }}</td></tr>
				        </tbody>
				    </table>
				</div>
			</div>
			<div class="col-md-1 hidden-sm hidden-xs"></div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center">	<hr/>	
				<select name="idioma" class="form-control" v-model="datosExtra.idioma" style="width:120px;display:inline">
              		<option value="es">Español</option>
              		<option value="en">Inglés</option>
           		</select>
           		<button class="btn btn-primary" v-on:click="guardarDatos()" title="Guardar y generar link para enviar al cliente">GUARDAR Y GENERAR LINK</button>
<!--
				<button class="btn btn-success" title="Ver vista previa">VISTA PREVIA</button>
-->
				<button class="btn btn-warning" title="Guardar Información de la Venta Directa" v-on:click="guardarVentaDirecta()">VENTA DIRECTA</button>
				<button class="btn btn-danger" v-on:click="reset()" title="Borrar los datos para generar nuevo link">RESET</button>
			</div>
		</div>
	</div>
<!--
	<pre>
		{{
			datosCliente
		}}
	</pre>
	<pre>
		{{
			datosVenta
		}}
	</pre>
	<pre>
		{{
			datosExtra
		}}
	</pre>
-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success container-fluid" style="width: 100%;height: 8.8em;margin-top: 10px;">
					
					<div v-show="urlVisible">
						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<input type="text" v-model="urlVenta" class="form-control txtCopyUrl" id="txtCopyUrl" style="text-align:center;">
							</div>
							<div class="col-md-12 text-center">
								<div class="form-group" style="padding-top: 0.3em;">
									<button class="btn btn-success btnCopyUrl" id="btnCopyUrl" v-on:click="copiar" title="Copiar url">COPIAR LINK</button> <button class="btn btn-warning btnCopyUrlOpenWindow" id="btnCopyUrlOpenWindow" v-on:click="nuevaVentana" title="Abrir en nueva pestaña">ABRIR LINK</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>
			</div>
		</div>
	</div>
</div>

<script src="<?=base_url()?>assets/js/reservas-rapidas.js" type="text/javascript"></script>
<script type="text/javascript">
	/*
	$(function () {
        $('.fechaDatepicker').datepicker({
            language: 'es',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            autoclose: true,
            format: "dd-M-yyyy",
            todayHighlight: true,
        }).datepicker( "setDate", new Date());
		
		$(document).on('change', '.fechaDatepicker', function(event) {
			event.preventDefault();
			var fecha = $(this).val();
			$(this).val('').val(fecha);
		});
    });
    */
</script>

<style type="text/css">
	/** Muestra el datepicker por encima de todo**/
	div.ui-datepicker{
		z-index: 10 !important;
	}
</style>