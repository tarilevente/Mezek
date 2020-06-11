<?php
session_start(); 

require_once('config/connect.php'); //database connect
require_once('config/functions.php'); //using methods

echo file_get_contents("html/header.html");

PrintMenu();
require_once('php/indexContent.php');
$con->close();
echo file_get_contents("html/footer.html");
