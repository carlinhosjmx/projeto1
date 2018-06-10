<?php

function pages($page){
    if(!$page){
        return 'pages/home.php';
    }
    return 'pages/'.$page.'.php';
}