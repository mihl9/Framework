<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 05.11.2014
 * Time: 19:56
 */

namespace framework\classes\View;


use framework\classes\FrontController;

final class FWView {
    /**
     * @access public static
     * @return object
     *
     * Diese Methode soll das richtige View-Objekt liefern. Es dient also als
     * Factory für die Views. Das soll dazu führen, dass der Programmierer nicht
     * wissen muss, mit welchem View-Objekt er arbeitet.
     */
    public static function getView()
    {
        return call_user_func_array(array(FrontController::$view,'getInstance'),array());
    }
} 