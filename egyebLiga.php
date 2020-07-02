<?php
//Prints out the container, and bg after clicking to the Egyéb Liga on navbar
session_start();

require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods
require_once 'php/Mez.php'; //using Mez Class

echo file_get_contents("html/header.html");

// Printing menu
$menu    = PrintMenu();
$menu    = str_replace("::extraForIndex", "", $menu);
$fooldal = file_get_contents("html/menu_extraForOthers.html");
echo str_replace("::extraForOthers", $fooldal, $menu);

// printing bg
echo '<div class="height650" id="bg-picOtherLeague1" >
        <!-- //bg -->
     </div>

     <div class="mainDiv">
        <!-- sticky -->
     <div  class="text-center sticky">
        <h4> <strong>Egyéb ligák</strong> - mezei</h4>
     </div>
     ';

// printing navigation div
echo '<div id="otherLigaDiv"></div> '; //js fills this div bynemzetiDiv.php

// printing footer
$footer = file_get_contents("html/footer.html");
echo str_replace("::otherjs::", "", $footer);
