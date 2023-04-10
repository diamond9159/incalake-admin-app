<div class="container-fluid">
  <div class="row">
    <div class="col-md-12"> 
      <?php 
        //echo json_encode($data); 
      ?>
      <div class="headline">
        <div><span class="fa fa-list"></span> Ver precios de las actividades y/o servicios de cada página web</div>
      </div>
      <div class="col-md-12">
        <div class="col-md-12 bg-primary " style="padding:3px;">
          <div class="col-md-1 text-center">#</div>
          <div class="col-md-4 text-center">Página Web</div>
          <div class="col-md-4 text-center">Ver Precios</div>
          <div class="col-md-3 text-center">Ver todos los Precios</div>
        </div>
        <?php 
              $servicios = [];
              if (!empty($data['productos'])) {
                $servicios = $data['productos'];
              }
            ?>
        <?php foreach ($servicios as $key => $value): ?>
              <?php 
                $btnIdiomas = '';
                foreach ($value['idiomas'] as $k => $val) {
                  $btnIdiomas .= '<div class="btn-group form-group"><a href="'.base_url().'admin/reporteprecios/precios/'.strtolower(trim($val['codigo'])).'/'.$value["id_codigo_servicio"].'" class="btn btn-success btn-sm" title="'.$val['cantidad'].' Actividades disponibles">'.ucfirst(mb_strtoupper($val['pais'])).' ('.$val['cantidad'].')'.'</a>'.'<a href="'.base_url().'admin/reporteprecios/pdf/'.strtolower(trim($val['codigo'])).'/'.$value["id_codigo_servicio"].'" class="btn btn-danger btn-sm" title="Imprimir (Esto puede tardar varios minutos)" target="_blank"><span class="fa fa-file-pdf-o"></span></a></div> ';
                }
              ?>
        <div class="col-md-12" style="padding:2px;border-bottom: solid;border-left: solid;border-right: solid;border-color: #bfbaba;border-width: 1px;">
          <div class="col-md-1 text-center div-num"><?=$key+1;?></div>
          <div class="col-md-4 text-center"><?='<strong>('.mb_strtoupper($value['codigo']).')</strong>  '.mb_strtoupper($value['titulo_pagina']); ?></div>
          <div class="col-md-4 text-center"><?=$btnIdiomas;?></div>
          <div class="col-md-3 text-center">
                <div class="btn-group">
                  <a href="<?=base_url();?>admin/reporteprecios/precios/all/<?=$value['id_codigo_servicio'];?>" class="btn btn-info" title="Ver precios en todos los idiomas"><span class="fa fa-list" ></span></a>
                  <a href="<?=base_url();?>admin/reporteprecios/pdf/all/<?=$value['id_codigo_servicio'];?>" class="btn btn-danger" target="_blank" title="Imprimir todos los precios (Esto puede tardar varios minutos)"><span class="fa fa-file-pdf-o" ></span></a>
                  </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>

      <div class="form-group text-center">
        <a href="<?php echo site_url('admin/servicio'); ?>" class="btn btn-danger"><b><span class="fa fa-chevron-left"></span> VOLVER</b></a>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
@media (max-width: 700px) {
    .div-num{
        background: #337ab7;
    color: #fff;
    }
}
    
</style>