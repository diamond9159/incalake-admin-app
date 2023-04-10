<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 01/07/2017
 * Time: 10:32 AM
 */
class Query extends CI_Model {
    protected $_table;
    protected $_select;
    protected $id;
    protected $id_name;
    protected $orderValue;
    protected $orderParams;
    protected $joinTable;
    protected $joinRelation;

    public $query;

    public function __construct()
    {

        parent::__construct();
        $this->load->database();
        $this->load->library("response");
    }

    public function table($value) {
        $this->_table = $value;
        return $this;
    }

    public function find($id, $id_name = 'id')
    {
        $this->id = $id;
        $this->id_name = $id_name;
        return $this;
    }

    public function select($value = '*')
    {
        $this->_select = is_array($value)?implode(",", $value):'*';
        return $this;
    }

    public function orderBy($value, $params = 'asc') 
    {
        $this->orderValue = $value;
        $this->orderParams = $params;
        return $this;
    }
    public function join($joinTable, $joinRelation)
    {
        $this->joinTable = $joinTable;
        $this->joinRelation = $joinRelation;
        return $this;
    }
    public function getJson()
    {
        return $this->response->json($this->sql()->result_array());
    }

    public function getArray()
    {
        return $this->sql()->result_array();
    }

    public function getObject()
    {
        return $this->sql();
    }

    public function sql()
    {
        $this->query = $this->db->select($this->_select)->from($this->_table);

        if(isset($this->joinTable) && isset($this->joinRelation))
        {
            $this->query->join($this->joinTable, $this->joinRelation);
        }
        if(isset($this->id) && isset($this->id_name))
        {
            $this->query->where($this->id_name, $this->id);
        }

        if(isset($this->orderValue) && isset($this->orderParams))
        {
            $this->query->order_by($this->orderValue, $this->orderParams);
        }

        return $this->query->get();
    }

    public function update($data) {
        return 1;
    }


}