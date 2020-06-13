<?php

function dd($var) {
    var_dump($var);
    die();
}

function IsLogged(){
    if(isset($_SESSION['USER'])&&(!empty($_SESSION['USER']))){
        //Someone is logged in
        return true;
    }else{
        return false;
    }
}

function PrintMenu(){
    if(IsLogged()){
        return file_get_contents("html/menu_in.html");
    }
    else{
        return file_get_contents("html/menu_out.html");
    }
}

