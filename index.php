<?php
session_start(); 

require_once('config/connect.php'); //database connect
require_once('config/functions.php'); //using methods

echo file_get_contents("html/header.html");

PrintMenu();
$con->close();
echo file_get_contents("html/footer.html");
