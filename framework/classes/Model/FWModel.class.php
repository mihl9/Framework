<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 15.11.2014
 * Time: 22:23
 */

namespace framework\classes\Model;


use framework\classes\FrontController;

class FWModel {
    public static function getModel()
    {
        return call_user_func_array(array(FrontController::$model,'getInstance'),array());
    }
} 