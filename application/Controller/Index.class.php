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
        \framework\classes\View\FWView::getView()->addTemplateContent("content", array("content" => "Es geht!"), "content.tpl.php");
        \framework\classes\View\FWView::getView()->addTemplateContent("rightBoxes", array("content" => "Es geht!"), "rightBoxes.tpl.php");
    }

    public function test_Action()
    {
        echo "test";
    }
} 