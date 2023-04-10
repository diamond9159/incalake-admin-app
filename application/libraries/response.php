<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 01/07/2017
 * Time: 10:10 AM
 */
class Response {

    public function json($array)
    {
        header('Content-Type: application/json');
        return json_encode($array);
    }

}
