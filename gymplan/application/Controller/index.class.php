<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:27
 */

class Controller_index extends \framework\classes\Controller\Controller_Abstract{

    public function index_Action()
    {
        $this->view->addTemplateContent("content", array("content" => "Es geht!"), "content.tpl.php");
        $this->view->addTemplateContent("rightBoxes", array("content" => "Es geht!"), "rightBoxes.tpl.php");
    }

    public function test_Action()
    {
        echo "test";
    }

    public function Login_Action(){
        $email= $this->request->getPost("email");
        $password = $this->request->getPost("password");

        if ($this->authentication->signInUser($email, $password)) {
            $this->response->redirect("index");
        } else {
            \framework\classes\Security\ErrorManager::setError("Benutzername/Passwort falsch", 0, 2);
            $this->response->redirect("index");
        }
    }

    public function Logout_Action(){
        $this->authentication->signOutUser();
        $this->response->redirect("Index");
    }
} 