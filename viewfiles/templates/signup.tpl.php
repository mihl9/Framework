<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 10.11.2014
 * Time: 23:44
 */
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php echo @\framework\classes\Security\ErrorManager::getError(3,true); ?>

        <form class="form-signin" method="post" action="?modul=signup&action=newuser">
            <fieldset>
                <label>
                    E-Mail:
                    <input class="form-control" type="email" name="email" required>
                </label>
                <label>
                    Passwort:
                    <input class="form-control" type="password" name="password" required>
                </label>
                <label>
                    Passwort Wiederholen:
                    <input class="form-control" type="password" name="password2" required>
                </label>
                <button class="btn btn-primary" type="submit">Registrieren</button>        <a class="btn btn-default" href="?modul=index">Login</a>
            </fieldset>
        </form>
    </div>
</div>