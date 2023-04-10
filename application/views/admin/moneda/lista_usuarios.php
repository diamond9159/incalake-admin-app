<!Doctype Html>
<html lang="es">

<head>
    <title>Lista de Usuarios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
  $this->load->view('admin/vistas/header/css');
  $this->load->view('admin/vistas/header/js');
  ?>
</head>

<html>

<body>
    <header>
        <?php
    $this->load->view('admin/vistas/header/menu');
    ?>
        <script src="<?= base_url(); ?>assets/resources/listjs/js/list.min.js"></script>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/resources/listjs/css/listjs.css">
    </header>
    <content>
        <div class="col-md-12">
            <div class="headline">
                <div>Lista de usuarios</div>
            </div>
            <div class="col-md-12 text-right">
                <a class="btn btn-success " href='<? base_url() ?>/cms/admin/usuarios/agregar'>Agregar</a>

            </div>
            <div id="users">
                <input class="search" placeholder="Search" />
                <button class="sort" data-sort="name">
                    Buscar
                </button>
                <div class="col-md-12 header-list text-center">
                    <div class="col-md-12">
                        <div class="col-md-3">Nombre de Usuario</div>
                        <div class="col-md-3">Nombre completo</div>
                        <div class="col-md-3">E-mail del Usuario</div>
                        <div class="col-md-3">Operación</div>
                    </div>
                </div>
                <div class="list">
                    <?php
          foreach ($usuarios as $key => $value) {
            ?>
                    <div class="col-md-12">
                        <div class="col-md-12 born">
                            <div class="col-md-3">
                                <?php
                  $tipuser = array('Administrador', 'Editor', 'Otro Usuario');
                  echo $value['username_usuarios'] . ' <small style="color:#50918C">(' . $tipuser[((int) $value['tipo_usuarios']) - 1] . ')</small>';
                  ?>

                            </div>
                            <div class="col-md-3">
                                <?php echo $value['nombre_usuarios']; ?>
                            </div>
                            <div class="col-md-3 text-center">
                                <?php echo $value['mail_usuarios']; ?>
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="<?php echo base_url() . 'admin/usuarios/editar/' . $value['id_usuarios']; ?>"
                                    class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a>
                                <?
                  echo ($value['id_usuarios'] == 1 ? '' : '<a class="btn btn-danger btn-sm pull-right" href="javascript:if(confirm(\'¿Esta seguro de querer eliminar este usuario?\'))location.href = \'' . base_url() . 'admin/usuarios/eliminar/' . $value['id_usuarios'] . '\'"><span class="fa fa-close"></span></a>');
                  ?>
                            </div>
                        </div>
                    </div>

                    <!--     	  	$usuariosHTML.='<div class="col-md-12">'.
                            '<div class="col-md-12 born">'.
                                '<div class="col-md-3">'..'</div>'.
                                '<div class="col-md-3 ">'..'</div>'.
                                '<div class="col-md-3">'..'</div>'.
                                '<div class="col-md-3"><a class="btn btn-info  pull-right" href="'..'"><span class="fa fa-pencil"></span></a>'.($value['id_usuarios']==1?'':'<a class="btn btn-danger btn-sm pull-right" href="javascript:if(confirm(\'¿Esta seguro de querer eliminar este usuario?\'))location.href = \''.base_url().'admin/usuarios/eliminar/'.$value['id_usuarios'].'\'"><span class="fa fa-close"></span></a>').
                                '</div>'.
                            '</div>'.
                            '</div>'; -->
                    <?
          }
          ?>

                </div>
                <ul class="pagination"></ul>
            </div>
        </div>
    </content>
    <footer>
        <?php
    $this->load->view('admin/vistas/footer/footer');
    ?>
    </footer>
    <script src="<?= base_url(); ?>assets/resources/listjs/js/custom.js"></script>
</body>

</html>