<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 10.11.2014
 * Time: 23:22
 */

class ViewHelper_LoginBox implements \framework\classes\View\Helper\Helper_Interface {

    public function run(array $params = array()){
        $authentication = \framework\classes\Security\Authentication::getInstance();
        $session = \framework\tools\Session\FWSessionHandler::getInstance();
        if($authentication->hasAuthentication()!==0) {
            return '<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Login</div></div>
                    <div class="box_content">
                        <form class="form-signin" method="post" action="?modul=index&action=login">'.
                            \framework\classes\Security\ErrorManager::getError(0,true)
                            .'<label>
                                E-Mail:
                                <input class="form-control" type="email" name="email" required>
                            </label>
                            <label>
                                Passwort:
                                <input class="form-control" type="password" name="password" required>
                            </label>
                            <br/>
                            <a href="?modul=signup">Du hast noch kein Konto?</a>
                            <button class="form-control btn btn-default" type="submit">Login</button>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>';
        }else{
            return '<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Eingeloggt</div></div>
                        <div class="box_content">
                            <form name="FrmLogin" action="?modul=Index&action=Logout" method="post">'.
                                \framework\classes\Security\ErrorManager::getError(0,true)
                                .'<fieldset>
                                    <div class="panel-body" style="text-align: left;">
                                        <strong>Willkommen, '. $session->UserName .'</strong>
                                        <br />
                                        <br />
                                        Letztes Login erfolgte am: '. date("d.m.Y h:i",strtotime(@'21.11.2014')) .'
                                    </div>
                                    <br />

                                    <button type="submit" class="btn btn-default" name="btnLogout" value="Login">Ausloggen</button>
                                </fieldset>
                            </form>
                        </div>
                    <div class="clear"></div>
                </div>';
        }
    }
} 