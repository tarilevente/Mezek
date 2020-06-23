<?php
session_start();

require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods

echo file_get_contents("html/header.html");

$menu      = PrintMenu();
$extraMenu = file_get_contents("html/menu_extraForIndex.html");
//removes the "Fooldal" from menustrip
$menu = str_replace("::extraForOthers", "", $menu);
//add to menustrips to menu
echo str_replace("::extraForIndex", $extraMenu, $menu);

require_once 'php/indexContent.php';
$con->close();

echo file_get_contents("html/footer.html");
