<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Codigo_page_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->dbBuses = $this->load->database("buses",TRUE);
    }
    
    function get_codigo_page_web($id_codigo_pagina){
        return $this->dbBuses->get_where('codigo_pagina_web',array('id_codigo_pagina_web'=>$id_codigo_pagina))->row_array();
    }
    
    function get_all_paginas_web_count(){
        $this->dbBuses->from('codigo_pagina_web');
        return $this->dbBuses->count_all_results();
    }
        
    function get_all_paginas_web($params = array()){
        $this->dbBuses->order_by('id_codigo_pagina_web', 'desc');
        if(isset($params) && !empty($params)){
            $this->dbBuses->limit($params['limit'], $params['offset']);
        }
        return $this->dbBuses->get('codigo_pagina_web')->result_array();
    }
        
    function add_codigo_page_web($params){
        $this->dbBuses->insert('codigo_pagina_web',$params);
        return $this->dbBuses->insert_id();
    }
    
    function update_codigo_page_web($id_codigo_pagina,$params){
        $this->dbBuses->where('id_codigo_pagina_web',$id_codigo_pagina);
        return $this->dbBuses->update('codigo_pagina_web',$params);
    }
    
    function delete_codigo_page_web($id_codigo_pagina){
        return $this->dbBuses->delete('codigo_pagina_web',array('id_codigo_pagina_web'=>$id_codigo_pagina));
    }
}




