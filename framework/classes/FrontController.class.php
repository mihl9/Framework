<?php
namespace framework\classes;
use framework\classes\Controller\Controller_Abstract;
use framework\classes\Debugger\Debugger;
use framework\classes\Filter\Chain;
use framework\classes\Filter\Filter_Interface;
use framework\classes\Http\Request;
use framework\classes\Http\Response;
use framework\classes\Model\FWModel;
use framework\classes\SubController\SubController_Abstract;
use framework\classes\View\FWView;


class FrontController{
    private $preFilters = array();
    private $postFilters = array();
    private $subControllers = array();
    private $controllerpath;
    public static $view;
    public static $model;
    private static $instance;

    public function route( Request $request,Response $response){
        if($request->issetGet("modul") && $request->getGet("modul") != ""){
            $modul = htmlentities($request->getGet("modul"));
        }else{
            $modul = "index";
        }

        if($request->issetGet("action") && $request->getGet("action") != ""){
            $action = htmlentities($request->getGet("action"));
        }else{
            $action = "index";
        }

        $request->setControllerName($modul);
        $request->setActionName($action);
    }

    public function run(Request $request,Response $response){
        $this->preFilters->execute($request, $response);
        $debugger = Debugger::getInstance();

        $modul = $request->getControllerName();
        $action = $request->getActionName();
        $action .= "_Action";

        $controllers = $this->controllerpath;
        $path = $controllers."/".Controller_Abstract::getValidControllerFileName($modul);
        if(file_exists($path)){
            require_once($path);
            $controller = "Controller_".$modul;
            $view = "View_".$modul;
            self::$view =$view;
            $model = "Model_".$modul;
            self::$model = $model;
            if(class_exists($controller, false)){
                $this->runSubControllers($request, $response, true); //runBeforeMainController
                $controller = new $controller(FWView::getView(), FWModel::getModel());
                //if(FW_Controller_Abstract::isValid($controller)){
                if(Controller_Abstract::isValid($controller)){
                    try
                    {

                        if(is_callable(array($controller, $action)))
                        {
                            $controller->$action();
                        }
                        else
                        {
                            $response->redirect("error404");
                        }
                        $this->runSubControllers($request, $response, false); //runAfterMainController
                        //Display Data with View
                        $view = FWView::getView();
                        $view->display($response);
                    }catch(\Exception $e){
                        echo $e->getMessage();
                    }
                }else{
                    $debugger->Error("Der Controller ist nicht valid", __FILE__, __LINE__, false);
                }
            }else{
                //$debugger->Error("Controllerklasse nicht gefunden: ".$controller, __FILE__, __LINE__, "error");
                //$debugger->Error("Controllerklasse nicht gefunden: ".$controller, __FILE__, __LINE__, false);
                $response->redirect("error404");
            }
        }else{
            //$debugger->dieError("Controllerdatei nicht gefunden: ".$path."\n Eventuell ist der erste Buchstabe des Dateinamens nicht groß geschrieben. ", __FILE__, __LINE__, false);
            $response->redirect("error404");
        }

        $this->postFilters->execute($request, $response);
        $response->send();
    }

    /**
     * @access public
     * @param $path string
     *
     * Define the Path of the Controller Folder
     */
    public function setControllerPath($path){
        $this->controllerpath = $path;
    }

    /**
     * Singleton
     * @access private
     *
     */

    private function __construct() {
        //create the instance of the Filter
        $this->preFilters = new Chain();
        $this->postFilters = new Chain();
    }
    private function __clone() {}

    /**
     * @access public static
     * returns the current instance of the Class
     */
    public static function getInstance(){
        if(self::$instance===null){
            self::$instance = new FrontController();
        }
        return self::$instance;
    }

    /*
     * Method for the Filters
     */
    public function addPreFilter(Filter_Interface $filter)
    {
        $this->preFilters->addFilter($filter);
    }

    public function addPostFilter(Filter_Interface $filter)
    {
        $this->postFilters->addFilter($filter);
    }

    /*
     * functions for the sub controllers
     */
    public function addSubController($controllername, array $blacklist = array())
    {
        $this->subControllers[(string)$controllername] = array("blacklist" => $blacklist,
            "object" => null);
    }

    public function runSubControllers(Request $request, Response $response, $before_main_controller = false)
    {
        //jetzt alle Controller ausführen
        foreach ($this->subControllers as $name => &$settings) //Referenz, weil $settings verändert wird
        {
            if (!in_array($request->getControllerName(), (array)$settings["blacklist"])){ //(array): Sicher ist sicher!
                //So fangen alle SubController an, weil sie im SubController-Dir liegen
                $name = "SubController_" . $name;

                if ($settings["object"] == null) {
                    $instance = new $name($request, $response);
                    $settings["object"] = $instance;
                } else {
                    $instance = $settings["object"];
                }

                if (!SubController_Abstract::isValid($instance)) {
                    throw new FWException("Es ist ein invalider SubController registriert: " . $name);
                }

                if ($before_main_controller) {
                    if (method_exists($instance, 'runBeforeMainController')) {
                        $instance->runBeforeMainController();
                    }
                } else {
                    if (method_exists($instance, 'runAfterMainController')) {
                        $instance->runAfterMainController();
                    }
                }
            }
        }
    }

}