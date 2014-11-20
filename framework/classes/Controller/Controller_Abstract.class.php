<?php
namespace framework\classes\Controller;
use framework\classes\Http\Request;
use framework\classes\Http\Response;
use framework\classes\Security\Authentication;
use framework\classes\View\FWView;
use framework\classes\View\HTML;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 21:26
 */

abstract class Controller_Abstract {
    /**
     * @var \framework\classes\Http\Response|null
     */
    protected $response;

    /**
     * @var \framework\classes\Http\Request|null
     */
    protected $request;

    /**
     * For authentication by user
     * @var \framework\classes\Security\Authentication
     */
    protected $authentication;

    /**
     * @var ModelAbs
     */
    protected $model;
    protected $view;

    /**
     * Constructor
     *
     */
    public function __construct($view, $model) {
        $this->model = $model;
        $this->view = $view;

        $this->authentication = Authentication::getInstance();

        $this->request = Request::getInstance();
        $this->response = Response::getInstance();
        if($this->view instanceof HTML) {
            //$this->view->addTemplateContent( "email", $_SESSION['email']);
        }
        //$this->initComponents();
    }

    /**
     * initialise the view and components
     * @return mixed
     */
    //public abstract function initComponents();

    /**
     * first default method
     * @return mixed
     */
    //public abstract function run();

    /**
     * show the hole html code
     * @return string: HTML
     */
    public function display() {
        return $this->view->getTemplateContent();
    }

    /**
     * check for user authentication
     * @param $index
     */
    public function checkAuthentication($index) {
        switch ($index) {
            case 0:
                break;
            case 1:
                ErrorManager::setError("Bitte melde dich an!", 0);
                $this->response->redirect("index");

                break;
            case 2:
                ErrorManager::setError("Bitte melde dich an!", 0);
                $this->response->redirect("index");
                break;
            default:
                ErrorManager::setError("Bitte melde dich an!", 0);
                $this->response->redirect("index");
                break;
        }
    }

    /**
     * @access public
     * @param object controller
     * @return bool
     * Prüft, ob das übergebene Modul gültig ist und gibt je nach dem true oder false
     * zurück.
     */
    public static function isValid($controller)
    {
        return ($controller instanceof Controller_Abstract
            && is_callable(array($controller, 'index_Action')));
    }

    public static function getValidControllerFileName($modul){
        return $modul.'.class.php';
    }
    /**
     * Diese Methode muss von jedem Controller implementiert werden.
     */
    abstract function index_Action();
} 