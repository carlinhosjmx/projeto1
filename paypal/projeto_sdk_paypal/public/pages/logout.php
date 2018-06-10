<?php

require '../../config.php';

$login = new App\Classes\Login;
if($login->isLoggedIn()){
    $login->logout();
}