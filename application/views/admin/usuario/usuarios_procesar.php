<html>
<head>
<title>Procesando usuarios</title>
<?php
		$this->load->view('admin/vistas/header/css');
		$this->load->view('admin/vistas/header/js');
	?>
</head>

<body>
    <header style="height:55px">
      <?php
        $this->load->view('admin/vistas/header/menu');
      ?>
    </header>
    <content>
<div class="col-md-12">
    	   <?=form_open('admin/usuarios/regedit','class="container-fluid"');?>

           <?=isset($usuario)?'<input type="hidden" value="'.$usuario->id_usuarios.'" name="id" />':'';?>
                <div class="col-md-8 col-md-offset-2 form-group">
                <div class="headline">
            <div><?=isset($usuario)?'Editar':'agregar nuevo';?> usuario</div>
            </div>
                   <div class="col-md-3"><label for="">Nombre de usuario:</label></div>
                   <div class="col-md-5 ">
                        <input class="form-control" maxlength="20" <?=isset($usuario)?'readonly':'';?> required type="text" name="username" value="<?=@$usuario->username_usuarios;?>" pattern="^[A-Za-z0-9_.-]+$" />

                    </div>
                    <div class="col-md-4">
                       <select name="tipo_usuario" class="form-control" <?=isset($usuario)?'disabled':'';?> required>
                           <option value="">-- Tipo de Usuario --</option>
                            <?php 
                            //echo $usuario->tipo_usuarios;
                            $options = array('Administrador','Editor','Otro Usuario');
                            $option = null;
                            foreach($options as $key => $value){
                              $option.='<option '.(@$usuario->tipo_usuarios==$key+1?'selected':'').' '.($key?'':'disabled').' value="'.($key+1).'">'.$value.'</option>';
                            }
                            echo $option;
                            ?>
                       </select>
                   </div>
                </div>
                <div class="col-md-8 col-md-offset-2 form-group">
                   <div class="col-md-3">
                       <label>Clave: </label>
                   </div>
                   <div class="col-md-9 form-group ">
                       <div class="input-group">
                           <input class="form-control" id="field" type="password" <?=isset($usuario)?'':'required';?> placeholder="<?=isset($usuario)?'Click para cambiar su clave':'Ingrese clave';?>" maxlength="20" name="password" ondblclick="" />
                           <span id="changeType" class=" input-group-addon" style="cursor: pointer;">
                            <i class="fa fa-eye"></i>
                            </span>
                       </div>
                   </div>
                </div>
                <div class="col-md-8 col-md-offset-2 form-group">
                   <div class="col-md-3">
                        <label>Nombre: </label>
                   </div>
                   <div class="col-md-9">
                       <input class="form-control" type="text" value="<?=@$usuario->nombre_usuarios;?>" name="nombre" />
                   </div>
                </div>
                <div class="col-md-8 col-md-offset-2 form-group">
                   <div class="col-md-3">
                       <label>E-Mail: </label>
                   </div>
                   <div class="col-md-9">
                       <input class="form-control" type="email" value="<?=@$usuario->mail_usuarios;?>" name="email" />
                   </div>
                </div>
                <div class=" col-md-8 col-md-offset-2  text-center">
                  
                       <a class="btn btn-danger" href='<?base_url()?>/cms/admin/usuarios'>Atras</a>
                   
                   
                       <input class="btn btn-success " type="submit" name="tipoproceso" value="<?=isset($usuario)?'Cambiar':'Agregar';?>" />
                   
                </div>  	   
    	    
    	   </form>
         
         <div class="container">
             <div class=" col-md-8 col-md-offset-2 alert alert-success"><b>Nota: </b><?=!isset($usuario)?'Una vez que haya agregado exitosamente sera dirigido a la pagina de vista con todo los usuarios':'Al Hacer click en Cambiar sera dirigido al login de usuarios para revalidar datos.';?>
             </div>
         </div>
  </div>
    </content>
    <footer>
	  <?php
	    $this->load->view('admin/vistas/footer/footer');
	  ?>
	</footer>
<script>
$('#changeType').css({'background':'#5cb85c','color':'#fff'})
    $('#changeType').click(function(){
if($( "#field" ).is( "[type=password]" )){
    $('#field').attr('type','text');
    $('#changeType i').removeClass('fa-eye').addClass('fa-eye-slash');
    $('#changeType').css({'background':'#c9302c','color':'#fff'})

}else{
    $('#field').attr('type','password');
    $('#changeType i').removeClass('fa-eye-slash').addClass('fa-eye');
    $('#changeType').css({'background':'#5cb85c','color':'#fff'})
}
    
});
</script>
<style>
    
</style>
</body>
</html>