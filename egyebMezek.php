<?php
require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods
require_once 'php/Mez.php'; //using Mez Class

echo file_get_contents("html/header.html");
$menu    = PrintMenu();
$menu    = str_replace("::extraForIndex", "", $menu);
$fooldal = file_get_contents("html/menu_extraForOthers.html");
echo str_replace("::extraForOthers", $fooldal, $menu);

// printing bg
echo '<div class="height650" id="bg-picEgyeb1" >
        <!-- //bg -->
     </div>

     <div class="mainDiv">
        <!-- sticky -->
     <div  class="text-center sticky">
        <h4> <strong>Egyéb&nbsp</strong> - mezek</h4>
     </div>
     ';

// printing navigation div
echo '<div class="" id="egyebMezekDiv"></div> '; //js fills this div bynemzetiDiv.php
echo '<div class="p2"><h4 class="error text-danger"></h4></div>'; //for error messages
// printing footer
$footer = file_get_contents("html/footer.html");
echo str_replace("::otherjs::", "", $footer);
