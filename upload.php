<?php
session_start();
require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods
if (!isLogged()) {
 header('Location:not_logged_in.php');
}
echo file_get_contents("html/header.html");
$menu = PrintMenu(); //menu_in.html will appears
echo $menu;
//valamit azért írjunk ki ide
echo '<div class="min-height550"></div>';

$con->close();
echo file_get_contents("html/footer.html");
