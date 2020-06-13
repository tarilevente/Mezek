<?php
session_start(); 

require_once('config/connect.php'); //database connect
require_once('config/functions.php'); //using methods
require_once('php/Mez.php'); //using Mez Class

echo file_get_contents("html/header.html");

// Printing menu
$menu=PrintMenu();
$menu=str_replace("::extraForIndex","",$menu);
$fooldal=file_get_contents("html/menu_extraForOthers.html");
echo str_replace("::extraForOthers",$fooldal,$menu);

// printing bg
echo'<div class="fullDiv" id="bg-picNemzeti1" >
        <!-- //bg -->
     </div>

     <div class="mainDiv">
        <!-- sticky -->
     <div  class="text-center sticky">
        <h4> <strong>Nemzeti&nbspválogatott</strong> -mezek</h4>
     </div>
     ';
     
// printing navigation div
echo'<div class="jumbotron" id="nemzetiDiv"></div> '; //js fills this div bynemzetiDiv.php

//printing csapatmez
// select 1,Path1,2,Path2,weared,PathWeared 
// FROM picstable,teamtable, categorytable, leaguetable,meztable
// WHERE picstable.idPic=meztable.idPic AND
// meztable.idTeam=teamtable.idTeam AND
// teamtable.idCategory=categorytable.idCategory AND
// leaguetable.idLeague=categorytable.idLeague




// printing footer
echo file_get_contents("html/footer.html");