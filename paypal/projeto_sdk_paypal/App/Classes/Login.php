<?php

namespace App\Classes;

class Login{
    public function isLoggedIn(){
        if(isset($_SESSION['logado']) && $_SESSION['logado'] == true){
            return true;
        }
        return false;
    }

    public function logout(){
        session_destroy();
        header("Location:/");
    }
}