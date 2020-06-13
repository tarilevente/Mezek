<?php
session_start(); 

require_once('../config/connect.php'); //database connect
require_once('../config/functions.php'); //using methods
require_once('../php/Mez.php'); //using Mez Class


if(isset($_POST['nemzeti']) && $_POST['nemzeti']==1){
//post is arrived
$html="";

//query


//response

}else{
    die('Nincs post a nemzetiPHP-ra');
}


