<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <h4>Datos a solicitar al cliente al finalizar la compra.
                <a href="<?=base_url('admin/formularios/categoria')?>" class="pull-right btn btn-primary btn-sm">
                    <i class="glyphicon glyphicon-plus"></i>
                    Añadir nueva categoria 
                </a>
            </h4>
            <br>
            <form action="<?=base_url('api/forms') ?>" method="post">
            <table class="table table-condensed">
                <tr>
                    <th>Nombre del formulario </th>
                    <th>Categoria</th>
                </tr>

                <!-- Se genera un bucle para crear nuevos datos de formulario segun los idiomas registrados de la base de datos. -->
                <tr v-for="i, index in idiomas">
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                <span :class="'flag-icon flag-icon-'+i.codigo.toLowerCase()" v-if="i.codigo.toLowerCase()!='en'"></span>
                                <span class="flag-icon flag-icon-us" v-if="i.codigo.toLowerCase()=='en'"></span>
                            </span>
                            <input type="text" class="form-control" :placeholder="'Descripción '+i.pais.toLowerCase()" :autofocus="index==0?true:false" name="input_label[]" required />
                        </div>
                    </td>
                    <td><select class="form-control" v-if="index==0" name="input_categoria">
                        <!-- <option> categoria_form  Lista las categorias de los formularios -->
                            <option v-for="c in categoria_form" :value="c.id_campo_categoria">{{ JSON.parse(c.nombre_campo_categoria)['es'] }}</option>
                        </select>
                    </td>
                </tr>
            </table>
                <p class="text-center">
                    <input type="submit" value="Registrar campo" class="btn btn-warning"/>
                </p>
            </form>
            <hr>
            <h4>Datos de formulario</h4>
            <h1 v-if="loading">Cargando...</h1>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4" v-for="f, key in inputs">
                         <div class="panel panel-primary">
                            <div class="panel-heading"><strong>{{ f.nombre_categoria['es'] }}</strong></div>
                            <div class="panel-body">
                                <!-- Visualizacion de los datos registrados (formualaios), agrupados según su categoria -->
                                <draggable :list="f.formulario" class="dragArea">
                                    <div v-for="i, index in f.formulario" class="move" style="border: 1px solid #ccc;padding: 6px 10px;cursor: move;">
                                        {{ i.nombre_campo['es'] }} 
                                        <a href="#" @click="eliminarInput(key,index,i.id_campo_formulario, $event)" class="pull-right" style="color: black;" >
                                           <i class="fa fa-remove"></i>
                                        </a> 
                                        <a  href="#" data-toggle="modal" data-target="#myModal" class="pull-right" style="margin-right: 10px;color:black;" 
                                            @click="data_update = { id_campo_formulario: i.id_campo_formulario, label: i.nombre_campo, categoria: f.categoria_id }">
                                            <i class="fa fa-pencil"></i> 
                                        </a>                                         
                                    </div>
                                </draggable>
                            </div>
                        </div>
                    </div>       
                </div>        
            </div>
        </div>
    </div>
</div>


<!-- Modal para modo edición del formulario  -->
 
<form action="<?=base_url('api/forms/update') ?>" method="post">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog  modal-lg" style="width:90%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualización de campos</h4>
      </div>
      <div class="modal-body">         
            <table class="table table-condensed">
                <tr>
                     <input type="hidden" name="id_campo_formulario" :value="data_update.id_campo_formulario" />
                    <th>Nombre  campo</th>
                    <th>Categoria</th>
                </tr>
                <tr v-for="i, index in idiomas">
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                                <span :class="'flag-icon flag-icon-'+i.codigo.toLowerCase()" v-if="i.codigo.toLowerCase()!='en'"></span>
                                <span class="flag-icon flag-icon-us" v-if="i.codigo.toLowerCase()=='en'"></span>
                            </span>
                            <input type="text" name="txtcampo[]" class="form-control" :placeholder="'Descripción '+i.pais.toLowerCase()" :autofocus="index==0?true:false" name="label" 
                            :value="data_update.label[i.codigo.toLowerCase()]" required/>
                        </div>
                    </td>
                    <td><select class="form-control" v-model="data_update.categoria" v-if="index==0" name="id_campo_categoria">
                            <option v-for="c in categoria_form" value="c.id_campo_categoria" :value="c.id_campo_categoria">{{ JSON.parse(c.nombre_campo_categoria)['es'] }}</option>
                        </select></td>
                </tr>
            </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary ">Actualizar</button>
      </div>
    </div>
  </div>
</div>
</form>
