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

class Security {
    /**
     * passphrase for encrypte the passwords
     * @var string
     */
    private static $PASSWORD = "r*/5G?B}w,w%Hym-r6&q@2%+d&54@v;w";

    /**
     * encrypte a string with base64 AES256
     * @param $str: string to encrypte
     * @return string: encrypted string
     */
    public static function encryption($str) {
        $size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($size, MCRYPT_RAND);
        $cipher = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$PASSWORD, $str, MCRYPT_MODE_CBC, $iv);

        $cipher_base64 = base64_encode($iv . $cipher);

        return $cipher_base64;
    }

    /**
     * decrypt a string with base64 AES256
     * @param $str
     * @return string
     */
    public static function decryption($str) {
        $cipher_dec = base64_decode($str);
        $size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);

        $iv_dec = substr($cipher_dec, 0, $size);
        $cipher_dec = substr($cipher_dec, $size);

        return rtrim (mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$PASSWORD, $cipher_dec, MCRYPT_MODE_CBC, $iv_dec));
    }

    /**
     * generate a token (with special charakters)
     * @return string
     */
    public static function generateToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!$_-[]{}?/*-+.,<>|';
        return self::generateSecurityString($characters, 25);
    }

    /**
     * generate a hash (without charakters)
     * @return string
     */
    public static function generateHash() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return self::generateSecurityString($characters, 10);
    }

    /**
     * generate a random string with string pattern
     * @param $str: string pattern
     * @param $length: length of random string
     * @return string: a random string for token or hash
     */
    private static function generateSecurityString($str, $length) {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $str[rand(0, strlen($str) - 1)];
        }
        return $randomString;
    }
} 