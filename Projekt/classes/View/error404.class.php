<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 23:46
 */

class View_error404 extends \framework\classes\View\HTML{

    public static function getInstance(){
        if(self::$instance===null){
            self::$instance=new View_error404();
        }
        return self::$instance;
    }
/*
    public function display(FW_Http_Response $response){

    }*/

    public function test(){

    }

} 