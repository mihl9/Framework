<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 10.11.2014
 * Time: 23:22
 */

class ViewHelper_LoginBox implements \framework\classes\View\Helper\Helper_Interface {

    public function run(array $params = array()){
        return '<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Login</div></div>
                    <div class="box_content">
                        <form class="form-signin" method="post" action="?modul=index&action=login">
                            <label>
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
    }
} 