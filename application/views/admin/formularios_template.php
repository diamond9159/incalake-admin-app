<!DOCTYPE html>
<html lang="es">
<head>
    <title>Formulario</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('admin/vistas/header/css'); ?>
    <link rel="stylesheet" href="<?=base_url().'assets/resources/css/flag-icon.min.css'?>">
    <?php $this->load->view('admin/vistas/header/js'); ?>
</head>
<body>
<section id="form">
    <header>
        <?php $this->load->view('admin/vistas/header/menu'); ?>
    </header>
    <content>
        <?= $view ?>
    </content>
    <footer>
        <?php $this->load->view('admin/vistas/footer/footer'); ?>
    </footer>
</section>
<style type="text/css">
 /*   .move:active {
        background-color: #b2d5ff;
    }*/
</style>
<script src="<?=base_url();?>assets/resources/vue/vue.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>

<!-- CDNJS :: Sortable (https://cdnjs.com/) -->
<script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.6.0/Sortable.min.js"></script>

<!-- CDNJS :: Vue.Draggable (https://cdnjs.com/) -->
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.14.1/vuedraggable.min.js"></script>

<script>
/* textLang(string) - '{json} extrae de un Json segun el idioma' */
window.textLang = (string) => {
    arrayLang = JSON.parse(string.toLowerCase());
    return arrayLang[langApp.toLowerCase()] ? arrayLang[langApp.toLowerCase()] == '' ? arrayLang['en'] : arrayLang[langApp.toLowerCase()] : arrayLang['en'];
}

Vue.prototype.textLang = (string) => textLang(string);  // para Vue data-binding {{ textLang($array_json) }}

$flag = 0;
    new Vue({
        el: "#form",       
        data: {
            loading: true,
            data_update: {
                type: '',
                name: '',
                label: '',
                placeholder: '',

            },
            types_: ['radio', 'checkbox', 'text', 'date', 'search', 'number', 'range'],
            categoria_form: {},
            idiomas: [],
            ver_langs: [],
            ctg_form_select: [],
            inputs: []
        },
        mounted: function () {

            var _this = this;

            $.getJSON( "<?=base_url().'admin/api/idiomas'?>", function(data) {  // Cargamos los idiomas de la base de datos
                _this.idiomas = data;
            });

            $.getJSON( "<?=base_url().'api/formscategoria'?>", function(data) { // Cargamos las categorias de los formularios
                _this.categoria_form = data;
            });

            $.getJSON("<?=base_url().'api/forms'?>", function (data) { // Cargamos los formularios 
                _this.inputs = data;
                _this.loading = false;
            }).error(function () {
                alert('Upps!! Hay problemas con el servidor, porfavor refresque la pagina.');
            });

         },
         methods: {
            eliminarInput: function (key, index, id, event) //Eliminamos los formularios
            {
                if(event) event.preventDefault();
                if(confirm('¿Esta seguro de eliminar este campo?')) {
                    $.getJSON("<?=base_url('api/forms-delete')?>?id="+id, function (data) {});
                    Vue.delete(this.inputs[key].formulario, index); 
                }
            }
         },
         watch: { //Se ejecuta frente a algun cambio.
            inputs: {
                handler: function (change) {
                   var _this = this;

                   if($flag >= 1) {
                       $.post("<?=base_url().'api/forms/update/prioridad'?>", {
                            forms: _this.inputs,
                       }, function(data, status){

                        }).error(function () {
                            alert('Upps!! Hay problemas con el servidor, porfavor refresque la pagina.');
                        });
                   }

                   $flag++;
                },
                deep: true,
            }
         }
    });
</script>
</body>
</html>