<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 15.11.2014
 * Time: 23:03
 */

class Model_signup extends \framework\classes\Model\Model_Abstract {
    public static function getInstance(){
        if(self::$instance===null){
            self::$instance=new Model_Signup();
        }
        return self::$instance;
    }

    /**
     * add a new user
     * @param $email
     * @param $pass
     * @return bool: true if signup successful
     */
    public function newUser($email, $pass) {
        $usernameCheck = $this->database->executeWithResult("SELECT hash FROM t_user where email='$email'");

        // check if is username unique
        if (count($usernameCheck) >= 1) {
            return false;
        }

        $token = \framework\classes\Security\Security::generateToken();
        $hash = \framework\classes\Security\Security::generateHash();

        $decryptedPass = sha1($token . $pass);

        $this->database->execute("INSERT INTO t_user (password, email, token, hash) VALUES ('$decryptedPass', '$email', '$token', '$hash')");
        $id =  $this->database->GetLastID();

        if ($id != null) {
            return true;
        }

        return false;
    }
} 