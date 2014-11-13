<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:27
 */

class Controller_Signup extends \framework\classes\Controller\Controller_Abstract{

    public function Index_Action()
    {
        $this->view = \framework\classes\View\FWView::getView();
        $this->view->setLayout("empty");
        $this->view->addTemplateContent("content", array("content" => "Es geht!"), "signup.tpl.php");
    }

    public function test_Action()
    {
        echo "test";
    }
} 