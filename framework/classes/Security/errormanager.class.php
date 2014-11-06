<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 14:09
 */
/**
 * Created by PhpStorm.
 * User: Sandro Pedrett
 * refactor: Michael Huber
 * Date: 27.10.2014
 * Time: 13:58
 * This file was copied from the Existing Projekt from Sandro pedrett. Cause i was too lazy
 */
namespace framework\classes\Security;


use framework\tools\Session\FWSessionHandler;

abstract class ErrorManager {
    /**
     * new alert
     * @param $msg: nachricht
     * @param $id: id von nachricht
     * @param int $typ: typ von nachricht (1 = error, 2 = warning, 3 = info, 4 = success)
     */
    public static function setError($msg, $id, $typ = 3) {
        $session = FWSessionHandler::getInstance();
        switch ($typ) {
            case 1: // error
                $session->error[$id] = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $msg . '</div>';
                break;
            case 2: // warning
                $session->error[$id] = '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $msg . '</div>';
                break;
            case 3: // info
                $session->error[$id] = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $msg . '</div>';
                break;
            case 4: // success
                $session->error[$id] = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $msg . '</div>';
                break;
        }
    }

    /**
     * returns alert with correct id
     * @param $id: gesuchter alert
     * @param bool $delete: true -> löscht nachdem anzeigen
     * @return mixed
     */
    public static function getError($id, $delete = false)  {
        $session = FWSessionHandler::getInstance();
        $msgError = $session->error[$id];
        if ($delete) {
            self::clear($id);
        }

        return $msgError;
    }

    /**
     * clear all errors
     * @param bool $id: wenn id angegeben wird, wird nur diese gelöscht
     */
    public static function clear($id = false) {
        $session = FWSessionHandler::getInstance();
        if ($id != false) {
            unset($session->error[$id]);
        } else {
            unset($session->error);
        }
    }
} 