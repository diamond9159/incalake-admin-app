<div class="container-fluid">
    <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-8 text-center">
            <a href="" class="btn btn-success" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Agregar nueva categoria</a>
            <!-- Modal -->

            <form action="<?=base_url('api/formscategoria') ?>" method="post">
                <input type="hidden" name="action" value="create">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Nueva categoria de formulario</h4>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr v-for="i, index in idiomas">
                                    <td>{{ parseInt(index+1) }}</td>
                                    <td width="400px">
                                        <input type="text" style="width:100%;color:#0833FF" name="nombre_categoria[]"
                                               :placeholder="index==0?'Nombre categoria':'Añadir traducción'" :required="index==0?true:false"
                                               class="form-control"
                                        />
                                    </td>
                                    <td>
                                        {{ i.pais }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>

           <h3>Categoria formulario</h3>
                <div v-for="c in categoria_form">
                    <form action="<?=base_url('api/formscategoria-update') ?>" method="post">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="categoria_id" :value="c.id_campo_categoria">

                            <table class="table table-condensed table-striped">
                                <tr>
                                    <th></th>
                                    <th>Descripcion</th>
                                    <th>LANG</th>
                                    <th>
                                        ACTIONS
                                    </th>
                                </tr>
                                <tr v-for="i, index in idiomas" class="text-left">
                                    <td>{{ parseInt(index+1) }}</td>
                                    <td width="400px">
                                        <input type="text" style="width:100%;color:#0833FF" name="nombre_categoria[]"
                                               :value="JSON.parse(c.nombre_campo_categoria)[i.codigo.toLowerCase()] ? JSON.parse(c.nombre_campo_categoria)[i.codigo.toLowerCase()] : ''"
                                                :placeholder="'Añadir traducción '+i.pais.toLowerCase()"
                                               :required="index==0?true:false"
                                        />
                                    </td>
                                    <td>
                                        {{ i.pais }}
                                    </td>
                                    <td>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-xs" v-if="index == 0">
                                                <i class="glyphicon glyphicon-floppy-disk"></i>
                                            </button>
                                            <a :href="'<?=base_url('/api/formscategoria-delete?id=') ?>'+c.id_campo_categoria" 
                                                    class="btn btn-danger btn-xs"
                                                    v-if="index == 0"
                                                    onclick="return confirm('¿Esta seguro de eliminar esta categoria?')"
                                            >
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </div>
                                    </td>
                    </form>
                </div>

                    </td>
                </tr>
                <tr></tr>
            </table>
        </div>
        <div class="col-xs-2"></div>
    </div>
</div>