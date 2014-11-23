<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 06.11.2014
 * Time: 00:01
 */

class  Controller_error extends \framework\classes\Controller\Controller_Abstract{

    public function Index_Action()
    {
        $this->view->setLayout("empty");
        //$view->addTemplateContent("content", array("text" => "Error 404 :D!"), "content.tpl.php");
        if($this->request->issetGet("code")){
            $code = $this->request->getGet("code");
        }else{
            $code = "";
        }

        switch ($code){
            case "404":
                $this->view->includeTemplateFile("404error");
                break;

            case "500":

                break;

            default:
            $this->response->redirect("Index");
        }
    }

    public function error404()
    {

    }
} 