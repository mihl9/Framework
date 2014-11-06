<?php
namespace framework\classes\View;
use framework\classes\Http\Response;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:04
 */

interface View_Interface {
    public function display(Response $response);
    public static function getInstance();
} 