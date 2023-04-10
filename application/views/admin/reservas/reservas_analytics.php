<div class="container-fluid">
	<div class="row">
		<div class="col-md-9">
			<div >
				<canvas id="canvas"></canvas>
			</div>
		<script>
			window.chartColors = {
				red: 'rgb(255, 99, 132)',
				orange: 'rgb(255, 159, 64)',
				yellow: 'rgb(255, 205, 86)',
				green: 'rgb(75, 192, 192)',
				blue: 'rgb(54, 162, 235)',
				blue_complemente: 'rgba(54, 162, 235, 0.18)',
				purple: 'rgb(153, 102, 255)',
				grey: 'rgb(201, 203, 207)'
			};
			var config = {
				type: 'line',
				data: {
					labels: <?=json_encode($data_dias);?>,
					datasets: [{
						label: 'Reserva No Confirmada',
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: <?=json_encode($data_en_espera);?>,
						fill: false,
					},{
						label: 'Reserva Confirmada',
						fill: true,
						backgroundColor: window.chartColors.blue_complemente,
						borderColor: window.chartColors.blue,
						data: <?=json_encode($data_pagados);?>,
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Reservas analytics'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Dias'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myLine = new Chart(ctx, config);
			};

		</script>
		</div>
		<div class="col-md-3">
			<div>fecha inicio</div>
			<input class="form-control text-center fecha" id="fecha_ini" type="text" name="" value="<?=$fecha_ini;?>">
			<div>fecha inicio</div>
			<input class="form-control text-center fecha" id="fecha_fin" type="text" name="" value="<?=$fecha_fin;?>">
			<div>total reservas</div>
			<div  class="form-control text-center"><?=$total_en_espera+$total_pagados;?></div>
			<div>Pago confirmado</div>
			<div  class="form-control text-center"><?=$total_pagados;?></div>
			<div>Pago en espera</div>
			<div class="form-control text-center"><?=$total_en_espera;?></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$( function() {
    $( ".fecha").datepicker({
           dateFormat: 'yy-mm-dd',
           todayHighlight: true,
           autoclose: true,
           language: 'es',
           // onSelect: function (date) {
           //   alert(date);
           //      input_lleno($('.input_fecha_viaje'));
           //  }
           // daysOfWeekHighlighted: [1,2,3,4,5,6]
    });
  } );
	$(document).on('change', '.fecha', function(event) {
		event.preventDefault();
		/* Act on the event */
		var fecha_ini= $('#fecha_ini').val();
		var fecha_fin= $('#fecha_fin').val();
		location.href = '<?=base_url()?>'+'admin/reservas/analytics/'+fecha_ini+'/'+fecha_fin;
	});
</script>