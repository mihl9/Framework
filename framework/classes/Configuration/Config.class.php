<?php
namespace framework\classes\Configuration;
use framework\classes\FWException;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 18:50
 */

final class Config
{
    /**
     * @access private
     * @var object intance
     */
    private static $instance = null;

    /**
     * @access private
     * @var array configuration
     * container for all of the settings
     */
    private $configuration = array();

    /**
     * singleton
     */
    private function __construct(){}
    private function __clone() {}

    /**
     * @access public
     * @return object
     *
     * returns the Instance of the CLass
     */
    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new Config();
        }
        return self::$instance;
    }

    /**
     * @access public
     * @param $path string
     * @throws FWException
     * read in the Configuration File
     */
    public function readINI($path)
    {
        if(file_exists($path))
        {
            $ini = parse_ini_file($path);
            foreach($ini as $key => $value)
            {
                $this->set($key, $value);
            }
        }
        else
        {
            throw new FWException("Die ini-Datei existiert nicht!");
        }
    }

    /**
     * @access public
     * @param string key
     * @param string value
     *
     * Saves the NEw Value in to the Array
     */
    public function set($key, $value)
    {
        $this->configuration[strtolower($key)] = $value;
    }

    /**
     * @access public
     * @param string key
     * @return mixed
     *
     * returns 0 if the Key doesn't exists
     * else the value saved in it is returned
     */
    public function get($key)
    {
        if($this->exists($key))
        {
            return $this->configuration[strtolower($key)];
        }
        else
        {
            return false;
        }
    }

    /**
     * @access public
     * @param string key
     * @return bool
     *
     * check if the Key is in the Array
     */
    public function exists($key)
    {
        if(isset($this->configuration[strtolower($key)]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}