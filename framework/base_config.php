<?php
/**
 * @License for the License see /licence.txt
 */

/**
 * @author Michael H.
 * @package Framework-MVC
 * @version 0.1
 *
 * This class must be inherited of each projekt which uses this framework.
 * Through this the autloader shall be activated and the necessary settings are done
 */

//Load the both classes Autload and config
require_once('classes/Autoload.class.php');
require_once('classes/Configuration/Config.class.php');
//set the configuration
$_config = \framework\classes\Configuration\Config::getInstance();
$_config->set("fw_path", dirname(__FILE__));
$_config->set("fw_class_path",$_config->get("fw_path")."/classes");
//register the autload class
\framework\classes\FWAutoload::register();
