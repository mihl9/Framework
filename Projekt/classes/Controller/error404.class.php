<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 06.11.2014
 * Time: 00:01
 */

class  Controller_error404 extends \framework\classes\Controller\Controller_Abstract{

    public function Index_Action()
    {
        $view = \framework\classes\View\FWView::getView();
        $view->setLayout("empty");
        //$view->addTemplateContent("content", array("text" => "Error 404 :D!"), "content.tpl.php");
        $view->includeTemplateFile("404error");
    }

    public function test_Action()
    {
        echo "test";
    }
} 