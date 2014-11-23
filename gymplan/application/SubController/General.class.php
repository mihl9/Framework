<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 22:28
 */

class SubController_General extends \framework\classes\SubController\SubController_Abstract{
    private $meta;
    private $path;
    private $title;

    public function init()
    {
        $this->meta = $this->FW_View_Helper_Meta();
        $this->title = $this->FW_View_Helper_Title();
        $this->path = $this->FW_View_Helper_Path();
    }

    public function runBeforeMainController()
    {
        $this->title->set("Mein Seitentitel");
        $this->path->add("Startseite", \framework\classes\Configuration\Config::getInstance()->get("www_root"));
        $this->meta->addMetaName("author", "Simon H.")
            ->addMetaHttpEquiv("refresh", "5; http://localhost")
            ->addMeta("name", "ichBin", "Simon H.");
    }

    public function index_Action(){

    }

} 