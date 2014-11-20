<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 15.11.2014
 * Time: 22:55
 */

class Model_index extends \framework\classes\Model\Model_Abstract {
    public static function getInstance(){
        if(self::$instance===null){
            self::$instance=new Model_Index();
        }
        return self::$instance;
    }
} 