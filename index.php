<?php
session_start();

require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
 header('Location:upload.php');
}

echo file_get_contents("html/header.html");

$menu      = PrintMenu();
$extraMenu = file_get_contents("html/menu_extraForIndex.html");
//removes the "Fooldal" from menustrip
$menu = str_replace("::extraForOthers", "", $menu);
//add to menustrips to menu
echo str_replace("::extraForIndex", $extraMenu, $menu);

require_once 'php/indexContent.php';
$con->close();

$footer = file_get_contents("html/footer.html");
echo str_replace("::otherjs::", "", $footer);
