

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
			<h3 class="text-primary"><span class="fa fa-edit"></span> EDITAR EMPRESA</h3>
			<?php echo form_open('buses/empresa/edit/'.$empresa['id_empresa'],array("class"=>"form-horizontal","id"=>"form_edit_empresa")); ?>

				<div class="form-group">
					<label for="nombre_empresa" class="col-md-12">Nombre Empresa <span class="text-danger fa fa-asterisk"></span></label>
					<div class="col-md-12">
						<input type="text" name="nombre_empresa" value="<?php echo ($this->input->post('nombre_empresa') ? $this->input->post('nombre_empresa') : $empresa['nombre_empresa']); ?>" class="form-control" id="nombre_empresa" />
						<span class="text-danger"><?php echo form_error('nombre_empresa');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="logo_empresa" class="col-md-12">Logo Empresa</label>
					<div class="col-md-12">
						<!--input type="file" name="logo_empresaVisible" value="<?php echo $this->input->post('logo_empresaVisible'); ?>" class="form-control" id="logo_empresaVisible" /-->
						<input type="hidden" name="logo_empresa" value="<?php echo ($this->input->post('logo_empresa') ? $this->input->post('logo_empresa') : $empresa['logo_empresa']); ?>" class="form-control" id="logo_empresa" />
						<div class="galeriaDivs">
							<button onclick="openGaleria($(this),6,'Buscar logo');" type="button">
							<span class="fa fa-search-plus"></span> Seleccionar logo</button>
							<input type="text" class="inputImagenModal" value="<?=$empresa['url_logo_empresa'];?>" readonly>
							<input type="hidden" class="inputHideImagenModal" value="<?=$empresa['logo_empresa'];?>" name="logo_empresa" >
				   		</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-success">GUARDAR</button>
			        	<a href="<?=base_url()?>buses/empresa/" class="btn btn-danger">VOLVER</a>
			        </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>