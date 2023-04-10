Vue.component('ckeditor', {
  template: `<div class="ckeditor"><textarea :id="id" :value="value"></textarea></div>`,
  props: {
      value: {
        type: String
      },
      id: {
        type: String,
        default: 'editor',
      },
      height: {
        type: String,
        default: '100px',
      },
      toolbar: {
        type: Array,
        default: () => [
          ['Undo','Redo'],
          ['Bold','Italic', 'JustifyLeft', 'JustifyCenter', 'JustifyRight','JustifyBlock'],
          ['NumberedList','BulletedList','Table'],
          ['Cut','Copy','Paste'],
          //['Link', 'Unlink', 'Anchor'],
          ['TextColor', 'BGColor'],
          ['Format'],
          ['basicstyles','Source','Maximize'],
        ]
      },
      language: {
        type: String,
        default: 'es'
      },
      extraplugins: {
        type: String,
        default: ''
      }
    },
    beforeUpdate () {
      const ckeditorId = this.id
      if (this.value !== CKEDITOR.instances[ckeditorId].getData()) {
        CKEDITOR.instances[ckeditorId].setData(this.value)
      }
    },
    mounted () {
      const ckeditorId = this.id
      console.log(this.value)
      const ckeditorConfig = {
        toolbar: this.toolbar,
        language: this.language,
        height: this.height,
        extraPlugins: this.extraplugins
      }
      CKEDITOR.replace(ckeditorId, ckeditorConfig)
      CKEDITOR.instances[ckeditorId].setData(this.value)
      CKEDITOR.instances[ckeditorId].on('change', () => {
        let ckeditorData = CKEDITOR.instances[ckeditorId].getData()
        if (ckeditorData !== this.value) {
          this.$emit('input', ckeditorData)
        }
      })
    },
    destroyed () {
      const ckeditorId = this.id
      if (CKEDITOR.instances[ckeditorId]) {
        CKEDITOR.instances[ckeditorId].destroy()
      }
    }
  
});

Vue.component('date-picker', {
	template: '<input class="form-control" v-model="fecha" placeholder="Seleccione fecha" style="text-align:center;"/>',
	props: [ 'dateFormat','fecha','itemData' ],
	mounted: function() {
		var self = this;
		$(this.$el).datepicker({
			dateFormat: this.dateFormat,
			minDate: 0,
			onSelect: function(date) {
				self.$emit('update-date', {index:self.itemData,fecha:date});
			}
		});
	},
	beforeDestroy: function() {
		$(this.$el).datepicker('hide').datepicker('destroy');
	}
});

var app = new Vue({
  el: '#appreservasrapidas',
  data: {
    datosCliente: {
      nombres: '',
      apellidos: '',
      email: '',
      nacionalidad: '',
      telefono: '',
    },
    datosVenta: [],
    datosExtra: {
	    descuentoGeneral: {
				tipoDescuentoGeneral: 0, // 0 = Porcentaje (%), 1 = Monto en dinero efectivo ($)
				cantidadDescuentoGeneral: 0, // Cantidad numérica.	
				montoDescuentoGeneral: 0, // Monto de tasas e impuestos calculados mendiate tipoDescuentoGeneral y cantidadDescuentoGeneral
			},
			tasasImpuestos: {
				tipoTasasImpuestos: 0, // 0 = Porcentaje (%), 1 = Monto en dinero efectivo ($)
				cantidadTasasImpuestos: 0, // Cantidad numérica.
				montoTasasImpuestos: 0, // Monto de Tasas e Impuestos calculado mediante tipoTasasImpuestos y cantidadTasasImpuestos
			}, 
			idioma: 'es', 
                        metodo_pago: 'culqi', // Método Pago
			precioSubTotal: 0,
			precioTotal: 0,
			coutaPorcentaje: 100, //Porcentaje a cobrar del total del monto a pagar. Ejemplo: Total $100, solo paga 20% = $20.
	    precioTotalCouta: 0, //Monto a cobrar en base a coutaPorcentaje
	  },
	  urlVisible: false,
	  urlVenta: null,

    dataItem: [],
    selecedDataItem: [],
    visibleSelectedDiv: -1,
  },
  computed:{
    /*
    filteredDataItem:function(){
       var self=this;
       return this.dataItem.filter(function(object){return object.titulo_producto.toLowerCase().indexOf(self.datosVenta['titulo'].toLowerCase())>=0;});
       //return this.customers;
    }
    */
  },
  mounted(){
  	this.datosVenta.length = 0;
  	if ( this.datosVenta.length === 0 ) {
  		this.agregarItem();
  	}  	
    $.blockUI({ css: { 
          border: 'none', 
          padding: '15px', 
          backgroundColor: '#000', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px', 
          opacity: .5, 
          color: '#fff' 
      } });
    axios.get('dataservicios').then(response => {
      // JSON responses are automatically parsed.
      this.dataItem = response.data;
      //console.log(JSON.stringify(this.dataItem));
      $.unblockUI();
    }).catch(e => {
      $.unblockUI();
      console.log("=>",e);
    });
  },
  watch:{
  	datosVenta: {
  		handler: function (change) {
	        this.datosExtra.precioSubTotal = 0;
	        change.forEach((item, i) => {
	        	if( item.cantidad <= 0 ){
	          		this.datosVenta[i].cantidad = 1; //Si es menor o igual a cero le ponemos por default 1
	        	}
	        	switch( parseInt(item.descuento.tipoDescuento) ){
	        		case 0:
	        			var montoDescuento0 = (item.cantidad*item.precioUnitario*item.descuento.cantidadDescuento/100 ); //Calculamos el valor del monto a descontar
	        			this.datosVenta[i].descuento.montoDescuento = montoDescuento0; //Actualizamos el valor del monto a descontar
	        			this.datosVenta[i].precioSubTotal = (item.cantidad*item.precioUnitario) - ( montoDescuento0 ); //Actualizamos Precio Sub Total
	        		break;
	        		case 1:
	        			var montoDescuento1 = item.descuento.cantidadDescuento; //En caso que haya eligido descuento en monto solo igualamos el valor a descontar
	        			this.datosVenta[i].descuento.montoDescuento = montoDescuento1; //Actualizamos el monto a decontar
	        			this.datosVenta[i].precioSubTotal = item.cantidad*item.precioUnitario - montoDescuento1; // Actualizamos el precio sub total incluido el descuento
	        		break;
	        	}
	        	//Actualizamos el Precio Total
	        	this.datosExtra.precioSubTotal += this.datosVenta[i].precioSubTotal;
	        });
	    },
	    deep: true,
  	},
  	datosExtra: {
  		handler: function (change){
  			var descuentoGeneral = this.calcularMonto(change.precioSubTotal,change.descuentoGeneral.tipoDescuentoGeneral,change.descuentoGeneral.cantidadDescuentoGeneral);
  			var tasasImpuestos   = this.calcularMonto(change.precioSubTotal,change.tasasImpuestos.tipoTasasImpuestos,change.tasasImpuestos.cantidadTasasImpuestos);
  			this.datosExtra.tasasImpuestos.montoTasasImpuestos = tasasImpuestos;
  			this.datosExtra.precioTotal =parseFloat(change.precioSubTotal) + parseFloat(tasasImpuestos) - parseFloat(descuentoGeneral);
  			this.datosExtra.descuentoGeneral.montoDescuentoGeneral = this.calcularMonto(this.datosExtra.precioSubTotal,this.datosExtra.descuentoGeneral.tipoDescuentoGeneral,this.datosExtra.descuentoGeneral.cantidadDescuentoGeneral);
  		},
  		deep: true,
  	},
  },
  methods:{
  	updateDate: function(data) {
      this.datosVenta[data.index].fecha = data.fecha;
    },
  	//Agrega nuevo item vacío para almacenar información del producto y/o servicio
  	agregarItem: function(){
  		this.datosVenta.push({
  			fecha : '',
  			titulo: '',
  			descripcion: '',
  			cantidad: 1,
                        horaInicio: '',
  			precioUnitario: 0,
  			descuento:{
  				tipoDescuento: 0, // 0 = Porcentaje (%), 1 = Monto en dinero efectivo ($)
  				cantidadDescuento: 0, // Cantidad numérica.
  				montoDescuento: 0, // montoDescuento calculado en base a tipoDescuento y cantidadDescuento. 
  			},
  			precioSubTotal: 0,
        data: Object,
        listaHorasInicio : [],
  		});
  	},
  	eliminarItem: function(index){
  		this.datosVenta.splice(index, 1);
  	},
  	calcularMonto: function(monto,tipoOperacion,cantidad){ 
  		var resultado = 0;
  		switch( parseInt(tipoOperacion) ){
  			case 0: // 0 = porcentaje 
  				resultado = (monto*cantidad/100);
  			break;
  			case 1: // 1 = cantidad en dólares
  				resultado = (cantidad);
  			break;
  		}
  		return parseFloat(resultado);
  	},
  	/*
  	descuentoGeneral: function(){
  		this.datosExtra.descuentoGeneral.montoDescuentoGeneral = this.calcularMonto(this.datosExtra.precioSubTotal,this.datosExtra.descuentoGeneral.tipoDescuentoGeneral,this.datosExtra.descuentoGeneral.cantidadDescuentoGeneral);this.calcularMonto(this.datosExtra.precioSubTotal,this.datosExtra.descuentoGeneral.tipoDescuentoGeneral,this.datosExtra.descuentoGeneral.cantidadDescuentoGeneral);this.calcularMonto(this.datosExtra.precioSubTotal,this.datosExtra.descuentoGeneral.tipoDescuentoGeneral,this.datosExtra.descuentoGeneral.cantidadDescuentoGeneral);
  		return this.datosExtra.descuentoGeneral.montoDescuentoGeneral;
  	},
  	*/
  	tasasImpuestos: function(){
  		return this.calcularMonto(this.datosExtra.precioSubTotal,this.datosExtra.tasasImpuestos.tipoTasasImpuestos,this.datosExtra.tasasImpuestos.cantidadTasasImpuestos);
  	},
  	updateResponseServer: function(visible,url){
  		this.urlVisible = visible;
		this.urlVenta 	= url;
  	},
  	montoAApagar: function(){
  		if (this.datosExtra.coutaPorcentaje) {
  			this.datosExtra.precioTotalCouta =  (parseFloat(this.datosExtra.precioTotal)*parseFloat(this.datosExtra.coutaPorcentaje))/100 ;
  			return this.datosExtra.precioTotalCouta;
  		}else{
  			return 0;
  		}
  	},
  	montoRestante: function(){
  		if (this.datosExtra.coutaPorcentaje) {
  			return ( parseFloat(this.datosExtra.precioTotal) ) - ( (parseFloat(this.datosExtra.precioTotal)*parseFloat(this.datosExtra.coutaPorcentaje))/100 ) ;
  		}else{
  			return parseFloat(this.datosExtra.precioTotal);
  		}
  	},
  	guardarDatos: function(){
  		if (this.urlVisible) {
  			console.log("No operation..!");
  			swal("Alerta","Para generar un nuevo link haga click en reset..!","warning");
  			return false;
  		}
      $.blockUI({ css: { 
          border: 'none', 
          padding: '15px', 
          backgroundColor: '#000', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px', 
          opacity: .5, 
          color: '#fff' 
      } }); 
  		// Validando información
  		var response = this.validarInformacion(); 

  		if (response.status) {
	  		var params = new URLSearchParams();
		    params.append( 'dataCliente', JSON.stringify(this.datosCliente) );
		    params.append( 'dataVenta',   JSON.stringify(this.datosVenta) );
		    params.append( 'dataExtra',   JSON.stringify(this.datosExtra) );
	  		$.unblockUI();
        axios.post('register', params).then((response)=> {
			    console.log(response.data);
			    if ( response.data.response === "success" ) {
            this.updateResponseServer(true,response.data.url);
			    }else{
			    	console.log("Error guardando información en el servidor..!");
			    }
          $.unblockUI();
			  }).catch(function (error) {
			    $.unblockUI();
          console.log(error);
			  });
		  }else{
        $.unblockUI();
			 swal("Atención",response.message,"warning");
		  }
  	},
  	copiar: function(){
  		var copyTextareaBtn = document.querySelector('.btnCopyUrl');
		
		var copyText = document.querySelector('.txtCopyUrl');
		copyText.select();
		try {
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
			console.log('Copying text command was ' + msg);
		} catch (err) {
			console.log('Oops, unable to copy');
		}
  	},
  	nuevaVentana(){
  		window.open(this.urlVenta);
  	},

  	reset: function(){
  		this.urlVisible 		    = false;
  		this.urlVenta			      = '';
  		this.datosVenta.length 	= 0;
  		this.agregarItem();

  		this.datosCliente.nombres 	= '';
  		this.datosCliente.apellidos = '';
  		this.datosCliente.email 	  = '';
                this.datosCliente.nacionalidad = '';
                this.datosCliente.telefono     = '';

  		this.datosExtra.descuentoGeneral.tipoDescuentoGeneral 		  = 0;
		  this.datosExtra.descuentoGeneral.cantidadDescuentoGeneral 	= 0;	
		  this.datosExtra.descuentoGeneral.montoDescuentoGeneral 		  = 0;
		
		  this.datosExtra.tasasImpuestos.tipoTasasImpuestos 			  = 0;
		  this.datosExtra.tasasImpuestos.cantidadTasasImpuestos 		= 0;
		  this.datosExtra.tasasImpuestos.montoTasasImpuestos 			  = 0; 

		  this.datosExtra.idioma 										    = 'es'; 
		  this.datosExtra.precioSubTotal 								= 0;
		  this.datosExtra.precioTotal 							    = 0;
		  document.getElementById("txtNombres").focus();
  	},
  	validarInformacion: function(){
  		var message = '';
  		var status = true;
  		if ( this.datosCliente.nombres.trim().length === 0 ) {
  			message += "Ingrese los nombres del cliente..!\n";
  			status = false;
  		}
  		if ( this.datosCliente.apellidos.trim().length === 0 ) {
  			message += "Ingrese los apellidos del cliente..!\n";
  			status = false;
  		}
  		if ( this.datosCliente.email.trim().length === 0 ) {
  			message += "Ingrese el e-mail del cliente..!\n";
  			status = false;
  		}
  		
  		this.datosVenta.forEach((item,index)=>{
  			if (item.fecha.trim().length === 0 ) {
  				message += "Seleccione la fecha N° "+(index+1)+"\n";
  				status = false;
  			}
  			if (item.titulo.trim().length === 0 ) {
  				message += "Ingrese el Título del Servicio N° "+(index+1)+"\n";
  				status = false;	
  			}
  			if ( parseFloat(item.precioUnitario) < 1 ) {
  				message += "Ingrese el precio del Servicio N° "+(index+1)+" mayor o igual a $1.00 USD\n";
  				status = false;	
  			}
  		});
  		return {status: status,message: message};
  	},

    // Servicio Seleccionado
    servicioSeleccionado: function(token,index){
      //console.clear();
      this.updateSelectedDiv(index);
      if (token.trim().length > 2 ) {
        var selectedDataItem = this.dataItem.filter(function(servicio){
          return servicio.titulo_producto.toLowerCase().indexOf( token.toLowerCase() ) != -1;
        });
        //console.log(JSON.stringify(selectedDataItem));
        this.updateSelectedDataItem(selectedDataItem);
      }else{
        this.selecedDataItem.length = 0;
      }
    },
    updateSelectedDataItem: function(object){
      this.selecedDataItem = object;
    },
    updateSelectedDiv: function(index){
      this.visibleSelectedDiv = index;
    },
    itemSeleccionado: function(object,index){
      this.updateSelectedDataItem([]);
      this.updateSelectedDiv(-1);

      this.datosVenta[index].horaInicio = ''; // Limpiar el campo Hora salida para que vuelva a seleccionar
      this.datosVenta[index].listaHorasInicio.length = 0; //Borrando Elementos de la lista Horarios
      this.datosVenta[index].data        = null;  // Borrando antes de asignar el objeto que trae la función
      this.datosVenta[index].data        = object;// Asignando el objeto que trae la función
      this.datosVenta[index].titulo      = object.titulo_producto;
      //this.datosVenta[index].descripcion = object.itinerario_tab;
      this.datosVenta[index].cantidad    = parseFloat(object.precios[0]['precios'][1]['cantidad']?object.precios[0]['precios'][1]['cantidad']:1);
      this.datosVenta[index].precioUnitario = parseFloat(object.precios[0]['precios'][1]['monto']?object.precios[0]['precios'][1]['monto']:0);
      this.datosVenta[index].listaHorasInicio = object.horarios;
      //console.log("Horarios",this.datosVenta[index].listaHorasInicio);
      //console.log(index,object);
      //console.log(JSON.stringify(object.precios[0]['precios'][1]));
    },
    guardarVentaDirecta: function(){
      if (this.urlVisible) {
        console.log("No operation..!");
        swal("Alerta","Para generar un nuevo link haga click en reset..!","warning");
        return false;
      }
      $.blockUI({ css: { 
          border: 'none', 
          padding: '15px', 
          backgroundColor: '#000', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px', 
          opacity: .5, 
          color: '#fff' 
      } }); 
      // Validando información
      var response = this.validarInformacion(); 

      if (response.status) {
        var params = new URLSearchParams();
        params.append( 'dataCliente', JSON.stringify(this.datosCliente) );
        params.append( 'dataVenta',   JSON.stringify(this.datosVenta) );
        params.append( 'dataExtra',   JSON.stringify(this.datosExtra) );
        $.unblockUI();
        axios.post('ventadirecta', params).then((response)=> {
          console.log(response.data);
          if ( response.data.response === "success" ) {
            //this.updateResponseServer(true,response.data.url);
            // Si es que tiene su proveedor enviamos los datos al provedor del servicio
            var paramsOperador = new URLSearchParams();
            paramsOperador.append('cr',response.reserva);
            axios.post('https://incalake.com/operador/enviarEmail/'+(parseInt(response.reserva)), paramsOperador ).then((response)=>{
              console.log(reponse);
            }).catch(function(error){
              console.log(error);
            });

            var paramsCalendar = new URLSearchParams();
            paramsOperador.append('id_reserva',response.reserva);
            axios.post('https://incalake.com/reserva/setcalendar/'+(parseInt(response.reserva)), paramsCalendar ).then((response)=>{
              console.log(reponse);
            }).catch(function(error){
              console.log(error);
            });
            this.reset();
            swal("Venta Registrada","La información de la venta a sido registrado correctamente. Compruebe que el servicio haya sido registrado en su calendario","success");
          }else{
            console.log("Error guardando información en el servidor..!");
          }
          $.unblockUI();
        }).catch(function (error) {
          $.unblockUI();
          console.log(error);
        });
      }else{
        $.unblockUI();
       swal("Atención",response.message,"warning");
      }
    },
  },

});