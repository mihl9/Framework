<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:27
 */

class Controller_signup extends \framework\classes\Controller\Controller_Abstract{

    public function Index_Action()
    {
        $this->view->setLayout("base");
        $this->view->addTemplateContent("content", array("content" => "Es geht!"), "signup.tpl.php");
    }

    /**
     * add a new user
     */
    public function newuser_Action() {
        $email = $this->request->getPost("email");
        $pass = $this->request->getPost("password");
        $pass2 = $this->request->getPost("password2");

        $emailValid = \framework\classes\Security\Validator::isEmailValid($email);

        if (!$emailValid || strlen($pass) < 3 || $pass != $pass2) {
            \framework\classes\Security\ErrorManager::setError("<ul><li>Email nicht korrekt</li><li>Passwort muss länger als 3 Zeichen sein</li><li>Passwörter stimmen nicht überein</li></ul>", 3, 2);
        } else {
            if ($this->model->newUser($email, $pass)) {
                \framework\classes\Security\ErrorManager::setError("Benutzer erstellt!", 0, 4);
                $this->response->redirect("Index");
            } else {
                \framework\classes\Security\ErrorManager::setError("<ul><li>Benutzer existiert bereits</li></ul>", 3, 2);
            }
        }
        $this->response->redirect("Signup");
    }
} 