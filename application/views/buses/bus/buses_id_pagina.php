<?php
 // var_dump($buses);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title>Lista de buses por pagina web></title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
	
</head>
	<body>
		<header>
			<?php
				$this->load->view('admin/vistas/header/menu');
			?>
		</header>
		<content>
            <div class="container">
                 <div class="titulo-producto">BUS 
                    <span class="fa fa-chevron-right" style="vertical-align: middle;color: #5cb85c;"> </span>
                    <span><?=$buses['pagina_web']['titulo_pagina'];?></span>
                 
                 </div>
                 <div class="alert alert-info" style="padding:7px;"><b>URL:</b><a href="javascript: location.href=this.innerText"><?=$buses['pagina_web']['url_pagina'];?></a><p><b>DESCRIPCION: </b><?=$buses['pagina_web']['descripcion_pagina'];?></p></div>

                 <div class="panel panel-default">
                    <div class="panel-heading">
                        Lista de buses incluidas en la pagina web
                        <a class="btn btn-success pull-right" style="margin-top:-7px" href="<?=base_url('buses/unidad/registro/'.$buses['pagina_web']['id_pagina']);?>"><span class="fa fa-plus"></span> Agregar bus a esta pagina</a>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="50%">Titulo del bus</th>
                                    <th width="10%">Origen</th>
                                    <th width="10%">Destino</th>
                                    <th width="10%" class="text-center">Activo</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $html = null;
                                    foreach(@$buses['buses'] as $value){
                                        $html .= '<tr>
                                                    <td>'.$value['titulo_bus'].'</td>
                                                    <td>'.$value['origen_bus'].'</td>
                                                    <td>'.$value['destino_bus'].'</td>
                                                    <td class="text-center"><i class="fa fa-circle text-'.($value['estado_bus']?'success':'danger').'" aria-hidden="true"></i></td>

                                                    <td>
                                                    <div class="btn-group">
                                                        <a title="Editar" href="'.base_url('buses/unidad/editar/'.$value['id_bus']).'" class="btn btn-success"><span class="fa fa-pencil"></span></a>

                                                        <a title="Ver relacionados a otros idiomas" href="'.base_url('buses/unidad/buses_relacionados/'.$value['id_codigo_bus']).'" class="btn btn-info" ><span class="fa fa-list"></span></a>

                                                        <a title="Eliminar" data-idbus="'.$value['id_bus'].'" class="btn btn-danger btn-eliminar" ><span class="fa fa-times"></span></a>
                                                                
                                                    </div>
                                                    </td>
                                                  </tr>';
                                        
                                    }
                                    echo $html?$html:'<tr class="text-danger"><td>No hay buses en esta pagina.</td></tr>';
                                ?>
                            </tbody>
                            
                        </table>
                    </div>
                 </div>
            </div>
		</content>
		<footer>
			<?php
				$this->load->view('admin/vistas/footer/footer');
			?>
		</footer>
		<script src="<?=base_url();?>assets/resources/listjs/js/custom.js"></script>
	</body>
	<script type="text/javascript">
	    (function(){
            $('.btn-eliminar').click(function(){
                var id_bus = $(this).data('idbus');
                if(confirm('¿Esta seguro de eliminar?')){
                    $.post('<?=base_url('buses/unidad/eliminar');?>',{id_bus:id_bus},function(result){
                        if(!isNaN(result)){
                            if(+result){
                                alert('Eliminado correctamente');
                                location.reload();
                            } else alert('No se pudo eliminar el bus no existe.');
                        } else alert('Errores en el servidor.');
                    });

                }
            });
        })();
	</script>
	<style type="text/css">
	
	</style>
</html>