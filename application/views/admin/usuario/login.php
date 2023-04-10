<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <title>Acceso a Incalake SIS 2</title>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php
    $this->load->view('admin/vistas/header/css');
    $this->load->view('admin/vistas/header/js');
  ?>
 </head>
 <body style="background: #f5f5f5;">

  <div class="container" style="margin-top:40px">
    <div class="row">
      <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <strong> Iniciar Sesión</strong>
          </div>
          <div class="panel-body">
            <?=form_open('admin/login/validar');?>
            <input type="hidden" name="url" value="<?=$url;?>" />  
              <fieldset>
                <div class="row">
                  <div class="text-center text-primary form-group" style="padding: 10px;">
                  <span class="fa fa-user-circle-o fa-5x"></span>
                    
                  </div>
                </div>
                <div class="row">                
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <div class="form-group">
                      <div class="input-group">
                        <label class="input-group-addon"  for="username" style="background: #5cb85c;color: #f5f5f5;">
                            <i  for="username" class="glyphicon glyphicon-user"></i>
                        </label>
                        <input type="text" required maxlength="20" autofocus class="form-control" name="username" id="username" placeholder="Ingrese nombre de usuario">                        
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <label for="password" class="input-group-addon" style="background: #337ab7;color: #f5f5f5;">
                          <i class="glyphicon glyphicon-lock"></i>
                        </label>
                        <input type="password" required class="form-control" name="password" id="password" placeholder="Ingrese Contraseña">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <input type="submit" class="btn btn-lg btn-primary btn-block" value="Entrar">
                    </div>
                    <div class="form-group">
                      <?= validation_errors()?'<div class="alert alert-danger">'.validation_errors().'</div>':''; ?>
                      <a href="#" onClick=""> ¿Olvidaste tu contraseña? </a>
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <div class="panel-footer ">
             <a href="#" onClick=""> ¿No puedes iniciar sesión? </a>
          </div>
        </div>
      </div>
    </div>
  </div>


   
 </body>
</html>
