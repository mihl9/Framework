<?php
namespace framework\classes\View;
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:05
 */

abstract class View_Abstract implements View_Interface{
    public static $layout = "Standart";
    protected $templates = array();
    protected $templateNow = null;

    protected $viewHelpers = array();

    protected static $instance = null;

    protected function __clone() {}
    protected function __construct() {}

    //------------------------------------------
    // getInstance() kann nicht in der abstrakten Klasse definiert werden,
    // weil dazu der Klassenname bekannt sein muss.
    // self zeigt immer auf FW_View_Abstract. Das wird mit PHP 6 aber endlich
    // funktionieren.

    /**
     * @access public
     * @param string $func
     * @param array  $params
     *
     * call of the ViewHelpers
     * If the Helper beginns with FW_, the the Helper is a part of the Framework
     * therefor FW_View_Helper_ is used as prefix.
     * otherwise the prefix is ViewHelper.
     */
    public function __call($func, $params)
    {
        if(substr($func, 0, 2) == "FW")
        {
            $class = "framework\\classes\\View\\Helper".substr($func, 3);
        }
        else
        {
            $class = "viewfiles_helper_".$func;
        }

        if(!isset($this->viewHelpers[$class]))
        {
            $this->viewHelpers[$class] = new $class;
        }

        return $this->viewHelpers[$class]->run($params);
    }

    public function setLayout($layoutname){
        self::$layout = $layoutname;
    }
} 