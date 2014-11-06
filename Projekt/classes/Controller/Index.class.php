<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:27
 */

class Controller_Index extends \framework\classes\Controller\Controller_Abstract{

    public function Index_Action()
    {
        \framework\classes\View\FWView::getView()->addTemplateContent("content", array("text" => "Es geht!"), "content.tpl.php");
    }

    public function test_Action()
    {
        echo "test";
    }
} 