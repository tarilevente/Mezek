<?php
session_start();
require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods
echo file_get_contents("html/header.html");
print_r($_SESSION['user']);
$menu = PrintMenu(); //menu_in.html will appears
echo $menu;
require_once 'php/uploadContent.php';

$con->close();
echo file_get_contents("html/footer.html");
