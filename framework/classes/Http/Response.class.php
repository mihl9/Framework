<?php
namespace framework\classes\Http;
use framework\classes\Configuration\Config;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:48
 */

class Response {
    private $headers = array();
    private $content = "";
    private $status  = "200 OK";

    private static $instance = null;

    /**
     * Singleton
     */
    private function __clone() {}

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new Response();
        }
        return self::$instance;
    }

    /**
     * @param $name
     * @param $content
     * Adds the Header
     */
    public function addHeader($name, $content)
    {
        $this->headers[$name] = $content;
    }

    /**
     * @param $status string defines the status of the request
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param $content
     * Adds the text or content which should be displayed
     */
    public function addContent($content)
    {
        $this->content .= $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function replaceContent($newContent)
    {
        $this->content = $newContent;
    }

    /**
     * sends the whole response
     */
    public function send()
    {
        header("HTTP/1.0 ".$this->status);
        foreach($this->headers as $name => $content)
        {
            header($name.": ".$content);
        }
        echo $this->content;

        //resetten
        $this->content = "";
        $this->headers = null;
    }

    /*
     * Additional functions
     */
    public function redirectURL($url, $immediately = false)
    {
        $this->addHeader("Location", $url);
        if($immediately === true)
        {
            $this->send();
            exit();
        }
    }

    public function redirect($controller, $action="", array $additional_params = array())
    {
        $url = $this->getInternalUrl($controller, $action, $additional_params, 1);
        $this->redirectURL($url, true);
    }

    public function setCookie($name, $value = null, $expire = null, $path = "/")
    {
        $expire = (int)($expire === null) ? time()+3600 : $expire;
        setcookie($name, $value, $expire, $path);
    }

    public function deleteCookie($name)
    {
        $this->setCookie($name, null, (time()-(86400*365*10)));
    }

    private function getInternalUrl($controller, $action ,array $additional_params, $id) {
        $url = "";
        $controller = strtolower($controller);

        $config = Config::getInstance();

        $controlllerRoot = $config->get("project_controllers");
        $error404 = $config->get("error404");

        if($action==""){
            //$action = "Index_Action";
        }
        if (file_exists($controlllerRoot ."/".  $controller .'.class.php')) {
            // add ?controller=
            $url .= "?modul=" . $controller;
            if($action!=="") {
                $url .= "&action=" . $action;
            }
            // add actions &test=3
            foreach ($additional_params as $key => $parameter) {
                $url .= "&" . $key . "=" . $parameter;
            }

            // add #testid
            if ($id != "") {
                $url .= "#" . $id;
            }
        } else {
            $url = "?modul=" . $error404 . "&code=404";
        }

        return $url;
    }
} 