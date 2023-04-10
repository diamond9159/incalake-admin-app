<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    

    <!-- CORRECCIÓN DE MENU RESPONSIVE PARA DISPOSITIVOS MÓVILES por ALAN GOMEZ C- en caso de eliminar, solo comentar-->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url();?>admin"><span class="fa fa-home"></span> Incalake</a>
    </div>
    <!-- CORRECCIÓN DE MENU RESPONSIVE PARA DISPOSITIVOS MÓVILES por ALAN GOMEZ C  en caso de eliminar, solo comentar-->
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!--<li class="active"><a href="#">ssss <span class="sr-only">(current)</span></a></li>
        <li><a href="#">sss</a></li>-->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Servicios <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url();?>admin/servicio"><span class="fa fa-list"></span> Ver Servicios</a></li>
            <li><a href="<?=base_url();?>admin/servicio/add"><span class="fa fa-plus"></span> Agregar Servicio</a></li>
            <!--<li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>-->
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" title="Actividades" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Actividades <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url();?>admin/productos"><span class="fa fa-list"></span> Ver Actividades</a></li>
          </ul>
        </li>
        <!--
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Ubicación <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/lugar"><span class="fa fa-list"></span> Lista de ubicaciones</a></li>
            <li><a href="<?=base_url(); ?>admin/lugar/add"><span class="fa fa-plus"></span> Nueva ubicación</a></li>
          </ul>
        </li>
        -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Idiomas <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/idioma"><span class="fa fa-list"></span> Ver Idiomas</a></li>
            <li><a href="<?=base_url(); ?>admin/idioma/add"><span class="fa fa-plus"></span> Agregar Idioma</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Categorias <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/categoria"><span class="fa fa-list"></span> Ver Categorias</a></li>
            <li><a href="<?=base_url(); ?>admin/categoria/add"><span class="fa fa-plus"></span> Agregar Categoria</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Recursos <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/recurso"><span class="fa fa-list"></span> Ver Recursos</a></li>
            <li><a href="<?=base_url(); ?>admin/recurso/add"><span class="fa fa-plus"></span> Agregar Recurso</a></li>
            <li><a href="<?=base_url(); ?>admin/cupones"><span class="fa fa-ticket"></span> Cupones</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Guías <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/guia"><span class="fa fa-list"></span> Ver Guías</a></li>
            <li><a href="<?=base_url(); ?>admin/guia/add"><span class="fa fa-plus"></span> Agregar Guía</a></li>
          </ul>
        </li>
<!--
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Disponibilidad <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/disponibilidad/update"><span class="fa fa-calendar"></span> Disponibilidad</a></li>
          </ul>
        </li>
-->
<!--
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Reserva  <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/reservarapida"><span class="fa fa-list"></span> Lista reserva rapida</a></li>
            <li><a href="<?=base_url(); ?>admin/reservarapida/add"><span class="fa fa-plus"></span> Reserva rapida</a></li>
            <li role="separator" class="divider"></li>
            <li><a href=""><span class="fa fa-list"></span> Reservas</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Oferta  <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/oferta"><span class="fa fa-list"></span> Lista oferta</a></li>
            <li><a href="<?=base_url(); ?>admin/oferta/add"><span class="fa fa-plus"></span> Nueva oferta</a></li>
            
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Métodos de Pago<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>admin/metodopago"><span class="fa fa-list"></span> Métodos de Pago</a></li>
            <li><a href="<?=base_url(); ?>admin/metodopago/add"><span class="fa fa-plus"></span> Nuevo Método de Pago</a></li> 
          </ul>
        </li>
-->     
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Galeria<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a onclick="openGaleria($(this),1,this.innerText,[1200,350,150,200])" href="#"><span class="fa fa-picture-o"></span> Slider Principal</a></li>
            <li><a onclick="openGaleria($(this),2,this.innerText,[800,400,100,150])" href="#"><span class="fa fa-image"></span> Slider Corto</a></li> 
            <li><a onclick="openGaleria($(this),3,this.innerText,[150,150,50,100])" href="#"><span class="fa fa-file-image-o"></span> Imagenes Relacionadas</a></li>
            <li><a onclick="openGaleria($(this),4,this.innerText)" href="#"><span class="fa fa-camera"></span> Recursos</a></li> 
            <li><a onclick="openGaleria($(this),6,this.innerText)" href="#"><span class="fa fa-window-restore"></span> Otras Imagenes</a></li> 
            <li><a onclick="openGaleria($(this),0,this.innerText)" href="#"><span class="fa fa-file-word-o"></span> Archivos Adjuntos</a></li>
            <li><a onclick="openGaleria($(this),5,this.innerText)" href="#"><span class="fa fa-file-pdf-o"></span> Politicas</a></li> 
            <li><a onclick="openGaleria($(this),7,this.innerText)" href="#"><span class="fa fa-file-archive-o"></span> Otros Documentos</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a style="background:#F45" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-bus"></span> Buses<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url(); ?>buses/idioma"><span class="fa fa-globe"></span> Idiomas</a></li>
            <li><a href="<?=base_url(); ?>buses/page"><span class="fa fa-list"></span> Lista de paginas</a></li>
            <li><a href="<?=base_url(); ?>buses/unidad"><span class="fa fa-list"></span> Lista de buses</a></li>
            <li><a href="<?=base_url(); ?>buses/empresa"><span class="fa fa-list"></span> Empresas</a></li>
            <li><a href="<?=base_url(); ?>buses/lugar"><span class="fa fa-list"></span> Lugares</a></li>
            <li><a href="<?=base_url(); ?>buses/servicio"><span class="fa fa-list"></span> Servicios</a></li>
            <li><a href="<?=base_url(); ?>buses/servicios_adicionales"><span class="fa fa-list"></span> Servicios adicionales</a></li>
            <li><a href="<?=base_url(); ?>admin/setpoliticas/bus"><span class="fa fa-list"></span> Politicas reserva bus default</a></li>
            <li><a href="<?=base_url(); ?>buses/guia"><span class="fa fa-gift"></span> Guías</a></li>
            <li><a href="<?=base_url(); ?>buses/formulario"><span class="fa fa-list"></span> Formularios</a></li>
          </ul>
        </li>
        
        <li class="dropdown" style="background:#2E8560">
          <a href="<?=base_url();?>admin/preguntas"> Preguntas</a>
        </li>
        <li class="dropdown" style="background:#286090">
          <a href="<?=base_url();?>admin/reservas"><span class="fa fa-envelope"></span> RESERVAS</a>
        </li>
        <li class="dropdown" style="background:#5cb85c" title="BETA - Continua en Produccción">
          <a href="<?=base_url();?>admin/reservasrapidas/add"><span class="fa fa-cart-plus"></span> <strong>PAGOS</strong></a>
        </li>

        
      </ul>

      <!--
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      -->
      <ul class="nav navbar-nav navbar-right">
 <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plane" aria-hidden="true"></i> Traslados<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url().'admin/aeropuertos'?>"><span class="fa fa-map-o"></span> Sectores de recojo</a></li>
            <li><a  href="<?=base_url().'admin/aeropuertos/tasas'?>"><span class="fa fa-usd"></span> Configurar Precios, impuestos</a></li> 
            <li><a href="<?=base_url().'admin/aeropuertos/vuelos'?>"><span class="fa fa-paper-plane-o"></span> Vuelos</a></li>

          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong><span class="fa fa-file-pdf-o"></span> REPORTES</span><span class="caret"></span></strong></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url().'admin/reporteprecios';?>"><span class="fa fa-money"></span> Precios</a></li>
            <li><a href="<?=base_url().'admin/reporteactividades';?>"><span class="fa fa-gift"></span> Actividades (BETA)</a></li>
            <li><a href="<?=base_url().'admin/reporteactividades/actividades/';?>"><span class="fa fa-gift"></span> Actividades Por Idioma (BETA)</a></li>
            <li class="bg-info"><a href="<?=base_url().'admin/estadisticas/servicios';?>"><span class="fa fa-file"></span> Estadisticas</a></li>
<li><a href="<?=base_url().'admin/suscripcion';?>"><span class="fa fa-check"></span> Suscripción</a></li>
          </ul>
        </li>
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong><span class="fa fa-globe"></span> CONFIG<span class="caret"></span></strong></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url().'admin/configuracion';?>"><span class="fa fa-file-text-o"></span> Datos Generales Index</a></li>
            <li><a href="<?=base_url().'admin/destinos';?>"><span class="fa fa-th-list"></span> Destinos Index</a></li>
            <li><a href="<?=base_url().'admin/buscador';?>"><span class="fa fa-th-list"></span> Buscador Index</a></li>
            <li><a href="<?=base_url().'admin/slider_index';?>"><span class="fa fa-th-list"></span> Slider Index</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?=base_url().'admin/formularios';?>"><span class="fa fa-th-list"></span> Formularios</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?=base_url().'admin/confprecios';?>"><span class="fa fa-cogs"></span> Conf. precios</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?=base_url().'admin/setpoliticas';?>"><span class="fa fa-cogs"></span> Conf. Terminos y condiciones</a></li>
            <li><a href="<?=base_url().'admin/menu';?>"><span class="fa fa-bars"></span> Conf. Menu</a></li>
            <li><a href="<?=base_url().'admin/footer';?>"><span class="fa fa-bars"></span> Conf. del Footer</a></li>
            <li><a href="<?=base_url().'admin/paginahtml';?>"><span class="fa fa-th-list"></span> Agregar Pagina independiente</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$this->session->userdata('username_usuarios');?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url().'admin/usuarios/editar/'.$this->session->userdata('id_usuarios');?>">Editar datos</a></li>
            <?=$this->session->userdata('tipo_usuarios')==1?'<li role="separator" class="divider"></li><li><a href="'.base_url().'admin/usuarios/">Lista usuarios</a></li><li><a href="'.base_url().'admin/usuarios/agregar">Agregar usuario</a></li>':'';?>
            <li role="separator" class="divider"></li>
            <li><a href="<?=base_url().'admin/login/out?url='.current_url();?>">Salir</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

