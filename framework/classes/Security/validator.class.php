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

/**
 * Class Validator
 * @package framework\classes\security
 */
class Validator {
    /**
     * check if regex correct
     * @param $pattern: regex pattern
     * @param $str: string to check
     * @return bool: true if correct
     */
    private static function onRegex($pattern, $str) {
        if ($str != "") {
            if (preg_match($pattern, $str)) {
                return true;
            }
        }
        return false;
    }

    /**
     * check if email valid
     * @param $email
     * @return bool
     */
    public static function isEmailValid($email) {
        if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$email)) {
            list ($user, $domain) = explode("@", $email);

            if (!checkdnsrr($domain, "MX")) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * check if username valid
     * @param $str
     * @return bool
     */
    public static function isUsernameValid($str) {
        return self::onRegex("/^[a-zA-Z][a-zA-Z0-9öäü_-]{1,255}/", $str);
    }

    /**
     * check if any title valid
     * @param $str
     * @return bool
     */
    public static function isCategoryValid($str) {
        return self::onRegex("/[a-zA-Z0-9 ]{1,}/", $str);
    }

    /**
     * returns true if all parameters true
     * @return bool
     */
    public static function isValid() {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!$arg) {
                return false;
            }
        }
        return true;
    }
} 