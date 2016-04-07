<h1> Utilisateurs </h1>

<?php
/**
 * Created by PhpStorm.
 * User: AA
 * Date: 30/03/2016
 * Time: 14:07
 */

foreach($users as $user){
    echo $user->getLogin()."<br>";
}
?>