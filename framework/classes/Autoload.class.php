<?php
namespace framework\classes;
use framework\classes\Configuration\Config;

/**
 * This class should be never instanced in anyway.
 * @author Michael H.
 * @package Framework-MVC
 * @version 0.1
 *
 * This class is used to register the Autoloaders
 */

class FWAutoload{

    /**
     * @access public static
     * @param null $autloader
     *
     * register a new autoloader
     */
    public static function register($autloader = null){
        if($autloader === null){
            spl_autoload_register(array('\framework\classes\FWAutoload', 'load'));
        }else{
            spl_autoload_register($autloader);
        }
    }

    /**
     * @access public static
     * @param $className
     *
     * Loads only the classes of the Framework the class name should contain FW_ClassName and the File should be ClassName
     * Other _ are handled like new Folder like FW_testClass_Data is testClass/Data.class.php
     */
    public static function load($className){
        if(substr($className, 0,3) == "FW_") { //load only if the class belongs to the Framework
            $classFile = Config::getInstance()->get("fw_class_path")."/".str_replace("_", "/", substr($className, 3)) .".class.php";
            if(file_exists($classFile)){
                require_once($classFile);
            }
        }elseif(substr($className, 0,10) == "framework\\") //nur wenn die Klasse zum FW gehört
        {
            $classFile = dirname(__FILE__)."/../../".str_replace("\\", "/", $className).".class.php";
            if(file_exists($classFile))
            {
                require_once($classFile);
            }
        }
    }


    /**
     * make the class to a singleton
     */

    private function __construct(){}
    private  function __clone(){}

}
