<?php 
	//echo json_encode($data['guia']);
?>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="typography">
			<div class="headline">
			<div>EDITAR GUIA EN TODOS LOS IDIOMAS</div>
			</div>
			<?//=json_encode($data); ?>
			<!--
			<div class="text-right" style="padding: 10px 0 ;">
				  <div class="btn btn-danger btn-min-panels" title="Minimizar todos los Paneles de idiomas"><span class="fa fa-chevron-up">  Minimizar Panels</span> </div>
			</div>
			-->
			<div class="">
			<?php 
				echo validation_errors(); 
				echo json_encode($data['guia']);
			?>
			<?php echo form_open('admin/guia/edit/'.$codigo_guia,array("class"=>"","id"=>"form_add_guia")); ?>
			<?
				foreach ($data['guia'] as $key => $value) {
			?>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-primary">
					  <div class="panel-heading" data-toggle="collapse" href="#collapse-<?=$key?>" aria-expanded="true">
					  	<h4 class="panel-title">
					  	<span class="div-numeracion"><?=$key+1?></span>
						<b>Guía en <?=ucwords(mb_strtolower($value['pais']));?></b>
						<span class="fa fa-tags"></span>
				        </h4>
					  </div>
					  <div id="collapse-<?=$key?>" class="panel-collapse collapse in" aria-expanded="true">
					  	<div class="panel-body">
						  	<div class="form-group col-md-12">
						  		<div class="">
									<label for="pais" class="control-label">Descripción Guía en <?=ucwords(mb_strtolower($value['pais']));?> <span class="btn btn-info btn-xs fa fa-question" data-placement="top" data-toggle="popover"  data-content="Escriba una decripción para su guia. Ejemplo: Guía Español, Guía Italiano."></span></label> 
									<input type="text" name="txt_nombre_guia[]" value="<?php echo $this->input->post('txt_nombre_guia') ? $this->input->post('txt_nombre_guia') : $value['servicio_guia']; ?>" class="form-control validate[required]" id="txt_nombre_guia" />
									<input type="hidden" name="txt_idioma[]" class="form-control" id="txt_idioma" value="<?=$value['id_idioma'];?>" />
									<input type="hidden" name="txt_id_guia[]" class="form-control" id="txt_id_guia" value="<?=$value['id_guia'];?>" />	
								</div>
						  	</div>								
					  	</div>
					  </div>
					</div>	
				</div>
			<?
				}
			?>
			</div>
			<hr/>
			  <!--
			  <div class="galeriaDivs">
							<button onclick="openGaleria($(this),6,this.innerText); return false;"  class="btn btn-success">
							<span class="fa fa-search-plus"></span> Buscar Imagen destacada</button>
							<input type="text" style="padding:5px;border-radius:5px;border:1px solid #CCC;" class="inputImagenModal" value="<?=@$guia[0]['url_archivo']?>" readonly />
							<input type="hidden" class="inputHideImagenModal" name="img_destacada" value="<?=@$guia[0]['imagen_guia']?>"/>
			 </div>
			 -->
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<a href="<?php echo base_url('admin/guia'); ?>" class="btn btn-danger"><span class="fa fa-chevron-left"></span> VOLVER</a>
					<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> GUARDAR</button>
		        </div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){

		$('.btn-min-panels').click(function(){
			if($(this).children('span.fa').prop('class')=='fa fa-chevron-up'){
				$('.panel-collapse').removeClass('in');
			$(this).removeClass('btn-danger').addClass('btn-success').children('span.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down').html(' Maximizar Panels');
		}else{
			$('.panel-collapse').addClass('in');
			$(this).removeClass('btn-success').addClass('btn-danger').children('span.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up').html(' Minimizar Panels');
		}
			
		});
		
	});
</script>
