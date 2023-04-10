<?php

/**
* Created by PhpStorm.
* User: Luis
* Date: 03/07/2017
* Time: 11:08 AM
*/
class Producto_has_campo_formulario extends MY_Model
{

    function __construct()
    {
    	$this->load->database();
        parent::__construct();
        $this->table = 'producto_has_campoform';
        
    }
    /*
     * Retornamos los PrimaryKeyS 'id_campo_formulario' relacionados a algun producto.
    */
    public function ability($id)
    {
    	$checkeds = [];
    	$checks =  $this->db->select('*')->from($this->table)->where('id_producto', $id)->get()->result_array();

		foreach($checks as $c) {
			array_push($checkeds, $c['id_campo_formulario']);
		}

		return $checkeds;

    }
    
    /*
     * Actualizamos los formularios que van a formar parte del producto.
    */
    public function updateProductForm($id, $input)
    {
    	$this->db->from($this->table)->delete('producto_has_campoform', [
			'id_producto' => $id
		]);
        if(!empty($input)) {
        	foreach($input as $i){
        		$this->db->insert('producto_has_campoform', [
        				'id_producto' => $id,
        				'id_campo_formulario' => $i
        			]);
        	}
        }
    }
}