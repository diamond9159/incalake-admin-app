<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formulario_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_formulario($id_campo_formulario){
        return $this->dbBuses->get_where('campo_formulario',array('id_campo_formulario'=>$id_campo_formulario))->row_array();
    }
    /*
    function get_all_formularios_count(){
        $this->dbBuses->from('formulario');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_formularios($params = array()){
        $this->dbBuses->order_by('id_formulario', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('formulario')->result_array();
    }
    */
    function add_formulario($params){
        $this->dbBuses->insert('campo_formulario_has_bus',$params);
        return $this->dbBuses->insert_id();
    }
    function add_formularioCampo($params){
        $this->dbBuses->insert('campo_formulario',$params);
        return $this->dbBuses->insert_id();        
    }
    /*
    function update_formulario($id_formulario,$params){
        $this->dbBuses->where('id_formulario',$id_formulario);
        return $this->dbBuses->update('formulario',$params);
    }
    
    function delete_formulario($id_formulario){
        return $this->dbBuses->delete('formulario',array('id_formulario'=>$id_formulario));
    }
	*/

    function delete_formularioCampoTexto($namecampo){
        return $this->dbBuses->delete('campo_formulario',array('name_campo_formulario'=>$namecampo));
    }

    function delete_formularioBus($idBus){
        return $this->dbBuses->delete('campo_formulario_has_bus', array('id_bus'=>$idBus) );
    }


    function operarFormularios($idBus,$dataFormularios){
    	if ( !empty($dataFormularios) ) {
    		$this->delete_formularioBus($idBus);
    		foreach ($dataFormularios as $key => $value) {
    			$params = array(
    				"id_bus" 				=> $idBus,
    				"id_campo_formulario" 	=> $value,
    			);
    			$this->add_formulario($params);
    		}
    	}
    	return true;
    }

    function get_formularioBus($codigo = "es",$idBus = null){
        return $this->dbBuses->query("SELECT i.*,camf.*,cfhb.id_campo_formulario AS cfhb_id_campo_formulario,cfhb.id_bus AS cfhb_id_bus FROM codigo_categoria_formulario AS ccf JOIN categoria_formulario AS catf ON catf.id_codigo_categoria_formulario = ccf.id_codigo_categoria_formulario JOIN campo_formulario AS camf ON catf.id_categoria_formulario = camf.id_categoria_formulario JOIN idioma AS i ON i.id_idioma = camf.id_idioma AND i.codigo = ? LEFT JOIN campo_formulario_has_bus AS cfhb ON camf.id_campo_formulario = cfhb.id_campo_formulario AND cfhb.id_bus = ?;", array($codigo,$idBus) )->result_array();
    }

    /*  Retorna todos los campos de texto para mostrar  */
    function get_formulariosIdioma($idioma = "esz"){
       return $this->dbBuses->query("SELECT * FROM idioma AS idi JOIN campo_formulario AS camf ON idi.id_idioma = camf.id_idioma AND idi.codigo = ? JOIN categoria_formulario AS catf ON catf.id_categoria_formulario = camf.id_categoria_formulario;", array($idioma) )->result_array(); 
    }

    /*  Retorna todas las categorias para clasificar los campos de texto  */
    function get_categoriaCampo($idioma = "es" ){
        return $this->dbBuses->query("SELECT * FROM idioma AS idi JOIN categoria_formulario AS catf ON idi.id_idioma = catf.id_idioma AND idi.codigo = ?;", array($idioma) )->result_array();
    }

    function add_codigoCategoriaFormulario(){
        $params = array(
            'codigo_categoria_formulario' => 'CODE-CATE-FORM*'.date('Ymd.his'),
        );
        $this->dbBuses->insert('codigo_categoria_formulario',$params);
        return $this->dbBuses->insert_id();
    }

    function get_campoTexto($namecampo = null ){
        return $this->dbBuses->query("SELECT * FROM idioma AS idi LEFT JOIN campo_formulario AS camf ON idi.id_idioma = camf.id_idioma AND camf.name_campo_formulario = ?;", array($namecampo) )->result_array();
    }

    function update_campoTexto($id_campo_formulario,$params){
        $this->dbBuses->where('id_campo_formulario',$id_campo_formulario);
        return $this->dbBuses->update('campo_formulario',$params);
    }
}
