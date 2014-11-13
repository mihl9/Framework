<?php

error_reporting(E_ALL | E_NOTICE);
require_once('framework/base_config.php');
//register the autoload
require_once('autoload.php');
ProjectAutoload::register();
date_default_timezone_set('Europe/Berlin'); //set the timezone
//register the Error handler
\framework\classes\Debugger\Debugger::registerErrorHandler();
//make instance of the request an response class
$request = \framework\classes\Http\Request::getInstance();
$response = \framework\classes\Http\Response::getInstance();

$conf = \framework\classes\Configuration\Config::getInstance();
$conf->set("project_root", "./");
$conf->set("www_root", "http://buchhaltung.ch");
$conf->set("project_classes", "./application");
$conf->set("project_controllers", $conf->get("project_classes")."/Controller");
$conf->set("viewpath", $conf->get("project_root")."viewfiles");
$conf->readINI($conf->get("project_root")."config/config.ini");

$frontController = \framework\classes\FrontController::getInstance();
$frontController->setControllerPath($conf->get("project_controllers"));
try {
    /*$myChain = new \framework\classes\Filter\Chain();
    $myChain->addFilter(new Filter_Big());
    $frontController->addPostFilter($myChain);*/
    $response->addHeader("Content-Type","text/html; charset=UTF-8");
    $frontController->route($request,$response);
    $frontController->run($request, $response);
}catch(\framework\classes\FWException $e) {
    echo $e->getMessage();
}