<?php
namespace framework\classes\Debugger;
use framework\classes\Configuration\Config;
use framework\classes\FWException;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 19:04
 */

class Debugger {
    protected static  $instance;
    protected $properties = array();
    /**
     * Singleton
     */
    private function __clone() {}

    /**
     * @access protected
     * the constructor initialise the settings
     */
    protected function __construct()
    {
        $config = Config::getInstance();
        $this->properties["screen_logging"] = $config->get("debugger_screen_logging");
        $this->properties["file_logging"] = $config->get("debugger_file_logging");
        $this->properties["file"] = $config->get("debugger_log_file");
    }

    public static function getInstance(){
        if(self::$instance===null){
            self::$instance = new Debugger();
        }
        return self::$instance;
    }

    /**
     * change the Error handler to the own class
     */
    public static function registerErrorHandler(){
        set_error_handler(array("\\framework\\classes\\Debugger\\Debugger", "handleError"));
    }

    /**
     * @access public
     * @param $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @param null $context
     *
     * handle the error which is thrown over the error_handler
     */
    public static function handleError($errno, $errstr = '', $errfile = '', $errline = '', $context = null){
        $debugger = Debugger::getInstance();
        $config = Config::getInstance();
        if($errno = E_NOTICE || $errno = E_STRICT){
            if($config->get("debugger_handle_unimportant") == "1"){
                $debugger->Error($errno.": ",$errstr, $errfile, $errline, false);
            }
        }else{
            $debugger->Error($errno.": ",$errstr, $errfile, $errline, false);
        }

    }

    /**
     * @param $message
     * @param string $file
     * @param string $line
     * @param bool $exception
     * @throws \framework\classes\FWException
     *
     * Handles the error and throws if it is needed an exception
     */
    public function Error($message, $file = null, $line = null, $exception = false){
        if($this->properties["file_logging"] == 1){
            $this->logFile($message, $file, $line, "error");
        }

        if($this->properties["screen_logging"] == 1){
            $this->logScreen($message, $file,$line, false);
        }

        if($exception === true){
            throw new FWException($message);
        }
    }

    /**
     * @param $message
     * @param string $file
     * @param string $line
     * @param bool $exception
     * @throws FWException
     * Calls the error function and exit the running script
     */
    public function dieError($message, $file = null, $line = null, $exception = false){
        $this->Error($message,$file,$line,$exception);
        exit();
    }

    /**
     * @access protected
     * @param $message
     * @param $file
     * @param $line
     * @param $errString
     * @throws \Exception
     * saves a new entry into the log File
     */
    public function logFile($message, $file, $line, $errString){
        //$errString = $this->Errno2String($errno);
        $handle = fopen($this->properties["file"], 'a');
        if($handle){
            $string = date("d.m.Y - H:i:s", time())." | ".$errString." | ".$_SERVER["REMOTE_ADDR"]." | ";
            $string .= "File: ".$file;
            $string .= " | Line: ".$line;
            $string .= " | ".$message;
            $string .= "\r\n";
            fwrite($handle,$string);
            fclose($handle);
        }else{
            throw new \Exception("Logfile-Error");
        }
    }

    /**
     * @access protected
     * @param string message
     * @param string file
     * @param string line
     * @param bool die
     * print out a message and end the script depending on the $die
     */
    protected function logScreen($message, $file, $line, $die)
    {
        $message = "Error: ".$message." \r\n";
        $message .= ($file == null) ? "" : "File: ".$file."\r\n";
        $message .= ($line == null) ? "" : "Line: ".$line."\r\n";

        if($die == true){
            die($message);
        }else{
            echo $message;
        }
    }

    /**
     * @access public static
     * @param  integer $errno
     * @return string
     *
     * Wandelt eine Fehlernummer in einen String um.
     */
    public static function Errno2String($errno)
    {
        switch($errno)
        {
            case E_ERROR:               return "E_ERROR";
            case E_WARNING:             return "E_WARNING";
            case E_PARSE:               return "E_PARSE";
            case E_NOTICE:              return "E_NOTICE";
            case E_CORE_ERROR:          return "E_CORE_ERROR";
            case E_CORE_WARNING:        return "E_CORE_WARNING";
            case E_COMPILE_ERROR:       return "E_COMPILE_ERROR";
            case E_COMPILE_WARNING:     return "E_COMPILE_WARNING";
            case E_USER_ERROR:          return "E_USER_ERROR";
            case E_USER_WARNING:        return "E_USER_WARNING";
            case E_USER_NOTICE:         return "E_USER_NOTICE";
            case E_ALL:                 return "E_ALL";
            case E_STRICT:              return "E_STRICT";
            case E_RECOVERABLE_ERROR:   return "E_RECOVERABLE_ERROR";
            //NUR PHP6
            //case E_DEPRECATED:          return "E_DEPRECATED";
            //case E_USER_DEPRECATED:     return "E_USER_DEPRECATED";
            default:                    return "UNKNOWN";
        }
    }
} 