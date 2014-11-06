<?php
namespace framework\classes\SubController;
use framework\classes\Controller\Controller_Abstract;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 22:21
 */

abstract class SubController_Abstract extends Controller_Abstract
{
    //---------------------------------------------
    //|erbt Methode init() von FW_Controller_Base |
    //---------------------------------------------

    /**
     * @access public static
     * @param mixed $subController
     * @return bool
     *
     * Überprüft den übergebenen SubController auf Gültigkeit.
     */
    public static function isValid($subController)
    {
        return (is_object($subController) &&
            $subController instanceof SubController_Abstract &&
            $subController instanceof Controller_Abstract &&
            (
                is_callable(array($subController, "runBeforeMainController")) ||
                is_callable(array($subController, "runAfterMainController"))
            )
        ) ? true : false;
    }
}