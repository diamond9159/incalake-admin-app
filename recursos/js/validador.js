/*controlar barra de prograso del formulario*/
$(document).ready(steps);
function steps(){
  var current = 1,current_step,next_step,steps;
  var fieldsets = $("#formPrincipal fieldset");
  var stepButtons = $("#formPrincipal .nextStep");

  stepButtons.click(function(){
  	var valido = true;
  	var current_step = $(this).parents('fieldset');
  	var inputs = current_step.find('input, select').filter('[required]:visible');
  	    inputs.each(function(index) {
  	    	if(!$(this).val().length){
  	    		$(this).addClass('formError2').click(function(){$(this).removeClass('formError2')});
  	    		var msjerror = $(this).data('error');
  	    		bootbox.alert(msjerror?msjerror:'Hay un campo vacio por favor reviselo.');
  	    		valido = false;
  	    		return false;
  	    	}
  	    });

        //Valida si la fecha disponibilidad existe
        if ( $(this).data('siguiente') === 'datos-reserva' ) {
          if( current_step.find('input#txt_fecha_inicio_disponibilidad').val().trim().length === 0 || 
              current_step.find('input#txt_fecha_fin_disponibilidad').val().trim().length === 0 ||
              current_step.find('input#txt_data_json_disponibilidad').val().trim().length === 0 ){
            valido = false;
            //bootbox.alert('Por favor seleccione la fecha de disponibilidad para su Actividad..!');
          }
        }
        

  	   	if(valido){
		    next_step = current_step.next();
		    next_step.show();
		    current_step.hide();
		    setProgressBar(++current);
  	   }
  });

  steps = fieldsets.length;
////////////////////////////////////////////
  function nextStep(key){
    var funcion = $(this).data('function');
    if(funcion!=undefined){
      funcion = eval(funcion);
      if(!funcion)return false;
    }
  }
////////////////////////////////////////////
//  stepButtons.click(nextStep);
  $("#formPrincipal .previousStep").click(function(){
    current_step = $(this).parents('fieldset');
    next_step = current_step.prev();
    next_step.show();
    current_step.hide();
    setProgressBar(--current);
  });
  setProgressBar(current);
  // Change progress bar action
  function setProgressBar(curStep){
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    $(".progress-bar")
      .css("width",percent+"%")
      .html(percent+"%");   
  }
}