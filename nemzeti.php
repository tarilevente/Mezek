<?php
session_start(); 

require_once('config/connect.php'); //database connect
require_once('config/functions.php'); //using methods

echo file_get_contents("html/header.html");

$menu=PrintMenu();
$menu=str_replace("::extraForIndex","",$menu);
$fooldal=file_get_contents("html/menu_extraForOthers.html");
echo str_replace("::extraForOthers",$fooldal,$menu);

echo file_get_contents("html/footer.html");