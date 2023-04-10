<?php

/**
* Created by PhpStorm.
* User: Luis
* Date: 03/07/2017
* Time: 11:08 AM
*/
class Campo_formulario extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'campo_formulario';
    }
}