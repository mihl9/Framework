<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 15.11.2014
 * Time: 13:40
 */

namespace framework\classes\Model;


use framework\tools\Database\Database;

class Model_Abstract {
    protected $database;
    protected static $instance;

    public function __construct(){
        $this->database = new Database();
    }

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //public abstract static function getInstance();

} 