<?php

/**
 * This class should be never instanced in anyway.
 * @author Michael H.
 * @package Framework-MVC
 * @version 0.1
 *
 * This class is used to register the load the classes of the project automatically
 */

class ProjectAutoload{

    /**
     * @access public static
     *
     * register the project autoloader
     */
    public static function register(){
        \framework\classes\FWAutoload::register(array("ProjectAutoload","load"));
    }

    /**
     * @access public static
     * @param $className
     *
     * Load the classes of the Project
     */
    public static function load($className){
        $path = \framework\classes\Configuration\Config::getInstance()->get("project_classes")."/".str_replace("_", "/", $className).".class.php";
        if(file_exists($path)) {
            require_once($path);
        }
    }

    /**
     * make the class to a singleton
     */

    private function __construct(){}
    private  function __clone(){}

}
