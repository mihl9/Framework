<?php
namespace framework\classes\View;
use framework\classes\Configuration\Config;
use framework\classes\Debugger\Debugger;
use framework\classes\Http\Response;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:11
 */

class HTML extends View_Abstract {

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function display(Response $response)
    {
        ob_start();
        $path = Config::getInstance()->get("viewpath")."/layouts/".self::$layout.".tpl.php";
        if(file_exists($path))
        {
            include($path);
            $content = ob_get_clean();
            $response->addContent($content);
        }
        else
        {
            $debugger = Debugger::getInstance();
            $debugger->logFile("Layout kann nicht gefunden werden", __FILE__, __LINE__, "error");
        }
    }

    public function addTemplateContent($templatename, $content, $templatefile)
    {
        $this->templates[$templatename] = array($content, $templatefile);
    }

    public function __get($key) //darf nur vars aus aktuellem tplcontent zeigen
    {
        if(isset($this->templates[$this->templateNow][0][$key]))
        {
            return $this->templates[$this->templateNow][0][$key];
        }
    }

    public function showTemplateContent($templatename)
    {
        $this->templateNow = $templatename;
        if(isset($this->templates[$this->templateNow]))
        {
            include(Config::getInstance()->get("viewpath")."/templates/".$this->templates[$this->templateNow][1]);
        }
        else
        {
            echo "Das Template ".$templatename." wurde von keinem Controller mit Daten gefuellt!";
        }
    }

    public function includeTemplateFile($templatename)
    {
        $path = Config::getInstance()->get("viewpath")."/static_templates/".$templatename.".tpl.php";
        if(file_exists($path))
        {
            include($path);
        }
        else
        {
            echo "Template nicht gefunden: ".$templatename." in ".$path;
        }
    }
} 