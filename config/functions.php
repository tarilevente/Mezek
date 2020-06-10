<?php

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
        echo file_get_contents("html/menu_in.html");
    }
    else{
        echo file_get_contents("html/menu_out.html");
    }
}
