<?php
/**
 * Created by PhpStorm.
 * User: Sandro Pedrett
 * refactor: Michael Huber
 * Date: 27.10.2014
 * Time: 13:58
 * This file was copied from the Existing Projekt from Sandro pedrett. Cause i was too lazy
 */

namespace framework\classes\Security;
use framework\tools\Database\Database;
use framework\tools\Session\FWSessionHandler;

/**
 * Class Authentication
 * @package framework\security
 */
class Authentication {
    private $database;
    private static $instance;

    private function __clone() {}

    private function __construct() {
        $this->database = new Database();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Authentication();
        }
        return self::$instance;
    }


    /**
     * create a session for login if username and password correct
     * @param $email: email from user
     * @param $password: password from user
     * @return bool: true if user sign in
     */
    public function signInUser($email, $password) {
        $resultUser = $this->database->executeWithResult("SELECT token,hash FROM t_user WHERE LOWER(email)='$email' and active=TRUE");

        if (count($resultUser) ==  1) {
            // user exist in database
            $token = $resultUser[0]['token'];
            $hash = $resultUser[0]['hash'];

            // decrypted password with token and sha1
            $decryprePass = sha1($token . $password);

            $resultUser = $this->database->executeWithResult("SELECT iduser, errorlog,email, firstname, lastname FROM t_user WHERE lower(email)='$email' and password='$decryprePass'");

            if (count($resultUser) == 1) {
                // user exist with correct password in database
                if ($resultUser[0]['errorlog']) {
                    $this->database->execute("UPDATE t_user SET errorlog=0 WHERE hash='$hash'");
                }

                // set importand sessions
                $session = FWSessionHandler::getInstance();
                $session->logged = true;
                $session->iduser = $resultUser[0]['iduser'];
                $session->hash = $hash;
                $session->email = $resultUser[0]['email'];
                $session->UserName = $resultUser[0]['firstname'] . " " . $resultUser[0]['lastname'];
                return true;
            } else {
                $this->database->execute("UPDATE t_user SET errorlog=errorlog + 1 WHERE hash='$hash'");
                $userErrorLog = $this->database->executeWithResult("SELECT errorlog FROM t_user WHERE hash='$hash'");

                // TODO disable acc
            }
        }

        return false;
    }

    /**
     * clear sessions
     */
    public function signOutUser() {
        $session = FWSessionHandler::getInstance();
        $session->logged = false;
        $session->iduser = -1;
        $session->hash = null;
        $session->email = null;

        $session->newID(true);
    }

    /**
     * check if user has authentication on website
     * @return int
     */
    public function hasAuthentication() {
        $session = FWSessionHandler::getInstance();
        $hash = $session->hash;

        if ($session->logged !== true) {
            return 1;
        }

        $user = $this->database->executeWithResult("SELECT iduser FROM t_user where hash='$hash' and active=TRUE");

        if (count($user)== 1) {
            // TODO: more security elements. Example ip check, errorlog check
            return 0;
        }

        return 2;
    }
}