<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		<h3 class="text-center"><span class="fa fa-pencil-square-o text-success"></span> TRADUCIR CATEGORIAS PARA EL NUEVO IDIOMA</h3><hr/>

		<?//=json_encode($data['nombre_idiomas']);?>
		<?php echo validation_errors(); ?>
		<?php echo form_open('admin/categoria/translate',array("class"=>"form-horizontal","id" => "form_translate_categoria")); ?>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<th>#</th>
					<?php 
					foreach ($data['nombre_idiomas'] as $key_idiomas => $value): ?>
						<th><?=$value['pais'];?></th>
					<?php endforeach ?>
				</thead>
				<tbody>
					<?php foreach ($data['categorias'] as $key_categorias => $val): 
					$categorias_disponibles  = count($val);
					?>
						<tr>
							<td><?=($key_categorias+1);?></td>
							<?php 
							$categoria_en_espanol = '';
							$primera_entrada_al_foreach = true;	
							foreach ($val as $k => $val_categorias): ?>
								<?php if ( $primera_entrada_al_foreach ): ?>
									<? 
										$categoria_en_espanol = $val_categorias['nombre_categoria']; 
										$primera_entrada_al_foreach = false;
									?>
								<?php endif ?>
								<?php if ( !empty( $val_categorias['nombre_categoria'] ) ): ?>
									<td><?=$val_categorias['nombre_categoria'];?></td>
								<?php else: ?>
									<td class="bg-danger"><?='<small><i>Sin traducción...!</i></small>';?></td>
								<?php endif ?>
							<?php endforeach ?>
							<?php if ( $categorias_disponibles < $data['cantidad_idiomas']['cantidad'] ): ?>
								<td>
									<p class="help-block"><small>TRADUCIR: <i><?=$categoria_en_espanol;?></i></small></p>
									<input type="text" autofocus name="txt_categoria_traduccion[]" id="txt_categoria_traduccion" class="form-control validate[required]" placeholder="Traducir categoria">
									<input type="hidden" name="txt_id_idioma[]" id="txt_id_idioma" value="<?=$value['id_idioma'];?>">
									<input type="hidden" name="txt_id_codigo_categoria[]" id="txt_id_codigo_categoria" value="<?=$val_categorias['id_codigo_categoria'];?>">
								</td>
							<?php endif ?>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div><hr/>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
				<button type="submit" class="btn btn-success">GUARDAR</button>
				<?php if ( $categorias_disponibles === $data['cantidad_idiomas']['cantidad'] ): ?>
					<a href="<?php echo site_url('admin/categoria'); ?>" class="btn btn-danger">Volver</a>
				<?php endif ?>
	        </div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
    $("#form_translate_categoria").validationEngine('attach', {
		relative: true,
		promptPosition:"bottomLeft"
	});
</script>